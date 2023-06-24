<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CurrencyExchangeService;
use App\Http\Requests\Api\ExchangeRateRequest;

class ExchangeRateController extends Controller
{
    public function index(ExchangeRateRequest $request,CurrencyExchangeService $currencyExchangeService)
    {
        $baseCurrency = $request->base_currency;
        $targetCurrency = $request->target_currencies;

        $targetCurrency =  explode(',', $targetCurrency);
        return  $currencyExchangeService->getExchangeRateFromStorage($baseCurrency,$targetCurrency);
      
    }
}

