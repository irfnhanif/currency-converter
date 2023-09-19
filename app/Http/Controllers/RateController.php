<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RateController extends Controller
{
    public function getDailyRate(){
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
        }
    }
}
