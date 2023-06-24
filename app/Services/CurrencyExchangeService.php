<?php 
namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Currency;
use App\Models\CurrencyRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CurrencyExchangeService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
        ]);
    }

    public function fetchCurrencies(): Collection
    {
        try {
                $response = $this->client->get('https://api.frankfurter.app/currencies');

                $currencies = json_decode($response->getBody(), true);
                
                return collect($currencies);
            } catch (\Exception $e) {
               Log::error($e);
               return response()->json(['error' => 'Something wrong with the thirdparty'], 500);
            }
    }

    public function fetchRates($baseCurrency, $targetCurrencies)
    {
        $targetCurrencies = implode(',',$targetCurrencies);

        try {
            $response = $this->client->get('https://api.frankfurter.app/latest?from='.$baseCurrency.'&to='.$targetCurrencies);

            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);
                $rates = $responseData['rates'];
                return $rates;
            } else {
                return response()->json(['error' => $response->getReasonPhrase()], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],500);
        }
    }

    public function fetchAndSaveCurrencyRates($baseCurrency, $targetCurrencies)
    {
        $rates = $this->fetchRates($baseCurrency, $targetCurrencies);

        $this->saveCurrencyRates($rates);
    }

    private function saveCurrencyRates( $rates)
    {    
        foreach ($rates as $symbol => $rate) 
        {
            $currency = Currency::where('symbol', $symbol)->first();
        
            if ($currency) 
            {
                $currencyRate = new CurrencyRate();
                $currencyRate->currency_id = $currency->id;
                $currencyRate->rate = $rate;
                $currencyRate->date = Carbon::now();
                $currencyRate->save();
            }
        }
    }  

    public function getExchangeRate($currency)
    {
        return cache()->remember($currency,now()->addHour() ,function () use($currency){
                return CurrencyRate::whereHas('currency', function($query) use($currency){
                    $query->where('symbol',$currency);
                })
                ->orderbyDesc('date')
                ->orderbyDesc('id')
                ->limit(1)
                ->value('rate');
            });
    }

    public function getExchangeRateFromStorage($baseCurrency = 'eur' , array $targetCurrencies)
    {
        $baseExchangeRate = 1 / $this->getExchangeRate(trim($baseCurrency));
        $targetExchangeRates = [];

        foreach($targetCurrencies as $currency)
        {
            $currency = trim($currency);
            $targetExchangeRates[$currency] = $baseExchangeRate * $this->getExchangeRate($currency);
        }

        return $targetExchangeRates;
    }
}    
