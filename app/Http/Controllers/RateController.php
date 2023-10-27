<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Rules\Amount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Carbon;

class RateController extends Controller
{

    public static function getTodayDate()
    {
        return Carbon::now()->toDateString();
    }

    public function getDailyRate()
    {
        $today = RateController::getTodayDate();

        $rateExist = Rate::whereDate('updated_at', $today)->first();
        if ($rateExist) {
            echo "You have already fetched today's rate";
        }

        $currencyController = new CurrencyController();
        $currenciesCode = $currencyController->getCurrenciesCode();

        Rate::truncate();

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
        }

        return redirect('/dashboard');
    }

    public function getDefaultConvertedRates($idDefaultCurrency)
    {
        $today = RateController::getTodayDate();
        $todayRates = Rate::whereNotIn('currency_to_id',[$idDefaultCurrency])->whereDate('updated_at', $today)->orderBy('currency_to_id')->get();

        $defaultCurrencyRate = Rate::whereDate('updated_at', $today)->where('currency_to_id', $idDefaultCurrency)->first();
        $mainCurrencyDollarRate = (float) 1 / $defaultCurrencyRate->rate;

        $rates = array();

        foreach ($todayRates as $todayRate) {
            $adjustedTodayRate = $todayRate->rate * $mainCurrencyDollarRate;
            if ($adjustedTodayRate < 1) {
                array_push($rates, sprintf('%.8f', $adjustedTodayRate));
            } else {
                array_push($rates, (string) number_format($adjustedTodayRate, 2, '.', ','));
            }
        }

        return $rates;
    }

    public function convert(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', new Amount()],
        ]);

        $amount = (float) preg_replace('/^[^0-9]+/', '', $validated['amount']);
        $idFromCurrency = (int) $request->input('from_currency');
        $idToCurrency =  (int) $request->input('to_currency');

        $currencyController = new CurrencyController();
        $fromCurrency = $currencyController->getCurrency($idFromCurrency);
        $toCurrency = $currencyController->getCurrency($idToCurrency);

        $today = RateController::getTodayDate();

        $fromCurrencyRate  = Rate::whereDate('updated_at', $today)->where('currency_from_id', 1)->where('currency_to_id', $idFromCurrency)->first();
        $toCurrencyRate  = Rate::whereDate('updated_at', $today)->where('currency_from_id', 1)->where('currency_to_id', $idToCurrency)->first();

        $toCurrencyAmount = (float) (($amount / $fromCurrencyRate->rate) * $toCurrencyRate->rate);
        $toCurrencyAmount = $toCurrencyAmount < 1 ? sprintf('%.8f', $toCurrencyAmount) : (string) round($toCurrencyAmount, 2);

        $oneAmountFromCurrency = (float) ((1 / $fromCurrencyRate->rate) * $toCurrencyRate->rate);
        $oneAmountFromCurrency = $oneAmountFromCurrency < 1 ? sprintf('%.8f', $oneAmountFromCurrency) : (string) round($oneAmountFromCurrency, 2);

        $oneAmountToCurrency = (float) ((1 / $toCurrencyRate->rate) * $fromCurrencyRate->rate);
        $oneAmountToCurrency = $oneAmountToCurrency < 1 ? sprintf('%.8f', $oneAmountToCurrency) : (string) round($oneAmountToCurrency, 2);

        return view('result', [
            'amount' => $amount,
            'fromCurrency' => $fromCurrency,
            'toCurrency' => $toCurrency,
            'toCurrencyAmount' => $toCurrencyAmount,
            'oneAmountFromCurrency' => $oneAmountFromCurrency,
            'oneAmountToCurrency' => $oneAmountToCurrency,
        ]);
    }
}
