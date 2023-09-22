<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
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
        
        return view('dashboard', [
            'currencies' => $currencies,
        ]);
    }
}
