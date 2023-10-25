<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{

    public function getCurrency($currencyId){
        $currency = Currency::where('id', $currencyId)->first();
        
        return $currency;
    }

    public function getCurrenciesCode() {
        $currencies = Currency::orderBy('id')->get();
        $currenciesCode = [];

        foreach ($currencies as $currency) {
            $currenciesCode[$currency->currency_code] = $currency->id;
        }
        
        return $currenciesCode;
    }

    public function dashboard(Request $request, $currencyId = null) {
        if (!$request->session()->get('has_visit')) {
            $request->session()->put([
                'has_visit' => true,
                'default_currency' => 1,
            ]);
            $idDefaultCurrency = 1;
        } else if ($currencyId) {
            $request->session()->put('default_currency', (int) $currencyId);
            $idDefaultCurrency = (int) $currencyId;
        } else {
            $idDefaultCurrency = $request->session()->get('default_currency');
        }
        
        $currencies = Currency::orderBy('id')->get()->toArray();
        $convertedMainCurrencies =
        Currency::whereNotIn('id', [$idDefaultCurrency])->orderBy('id')->get()->toArray();

        $rateController = new RateController();
        $rates = $rateController->getDefaultConvertedRates($idDefaultCurrency);
        
        return view('dashboard', [
            'idDefaultCurrency' => $idDefaultCurrency,
            'convertedMainCurrencies' => $convertedMainCurrencies,
            'currencies' => $currencies,
            'rates' => $rates,
        ]);
    }
}
