<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Rules\Amount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Carbon;

class RateController extends Controller
{
    public function getDailyRate()
    {
        $today = Carbon::now()->toDateString();

        $rateExist = Rate::whereDate('updated_at', $today)->first();
        if ($rateExist) {
            echo "You have already fetched today's rate";
        }

        $currencyController = new CurrencyController();
        $currenciesCode = $currencyController->getCurrenciesCode();

        $rates = json_decode(Http::get('https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/usd.json'), true)['usd'];

        $filteredRates = array_intersect_key($rates, $currenciesCode);

        foreach ($filteredRates as $rate => $value) {
            if (array_key_exists($rate, $currenciesCode)) {
                Rate::create([
                    'currency_from_id' => 1,
                    'currency_to_id' => $currenciesCode[$rate],
                    'rate' => $value,
                ]);
            }

            redirect('/');
        }
    }

    public function convert(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', new Amount()],
        ]);

        $amount = (float) preg_replace('/^[^0-9]+/', '', $validated['amount']);
        $idFromCurrency = (int) $request->input('from_currency');
        $idToCurrency =  (int) $request->input('to_currency');

        $fromCurrencyRate  = Rate::where('currency_from_id', 1)->where('currency_to_id', $idFromCurrency)->first();
        $toCurrencyRate  = Rate::where('currency_from_id', 1)->where('currency_to_id', $idToCurrency)->first();

        $toCurrencyAmount = (float) (($amount / $fromCurrencyRate->rate) * $toCurrencyRate->rate);
        $toCurrencyAmount = $toCurrencyAmount < 1 ? sprintf('%.8f', $toCurrencyAmount) : (string) round($toCurrencyAmount, 2);

        $oneAmountFromCurrency = (float) ((1 / $fromCurrencyRate->rate) * $toCurrencyRate->rate);
        $oneAmountFromCurrency = $oneAmountFromCurrency < 1 ? sprintf('%.8f', $oneAmountFromCurrency) : (string) round($oneAmountFromCurrency, 2);

        $oneAmountToCurrency = (float) ((1 / $toCurrencyRate->rate) * $fromCurrencyRate->rate);
        $oneAmountToCurrency = $oneAmountToCurrency < 1 ? sprintf('%.8f', $oneAmountToCurrency) : (string) round($oneAmountToCurrency, 2);

        var_dump($toCurrencyAmount);
        var_dump($oneAmountFromCurrency);
        var_dump($oneAmountToCurrency);
        return view('result', [
            'amount' => $amount,
            'fromCurrencyRate' => $fromCurrencyRate,
            'toCurrencyRate' => $toCurrencyRate,
            'toCurrencyAmount' => $toCurrencyAmount,
            'oneAmountFromCurrency' => $oneAmountFromCurrency,
            'oneAmountToCurrency' => $oneAmountToCurrency,
        ]);
    }
}
