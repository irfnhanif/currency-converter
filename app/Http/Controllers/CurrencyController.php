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

    public function dashboard() {
        $currencies = Currency::orderBy('id')->get()->toArray();

        $idDefaultCurrency = Auth::user()->default_currency;
        $rateController = new RateController();
        $rates = $rateController->getDefaultConvertedRates($idDefaultCurrency);
        
        return view('dashboard', [
            'currencies' => $currencies,
            'rates' => $rates,
        ]);
    }
}
