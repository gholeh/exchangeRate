<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Services\CurrencyExchangeService;
use Illuminate\Support\Facades\Artisan;

class CurrencyExchangeRatesTest extends TestCase
{

    public function testCurrencyExchangeRatesCommand()
    {
        $baseCurrency = 'EUR';
        $targetCurrencies = ['USD','PLN'];

        $currencyExchangeServiceMock = Mockery::mock(CurrencyExchangeService::class);
        $currencyExchangeServiceMock->shouldReceive('fetchAndSaveCurrencyRates')
            ->once()
            ->with($baseCurrency, $targetCurrencies);

        $this->app->instance(CurrencyExchangeService::class, $currencyExchangeServiceMock);

        Artisan::call('app:currency:rates', [
            'base_currency' => $baseCurrency,
            'target_currencies' => $targetCurrencies,
        ]);

        // Assert the output
        $output = Artisan::output();
    
        $this->assertStringContainsString('Currency rates fetched and saved successfully.', $output);
    }

    public function testExchangeRateEndpoint()
    {
        // Mock the CurrencyExchangeService
        $mockCurrencyExchangeService = $this->mock(\App\Services\CurrencyExchangeService::class);

        // Define the expected data
        $baseCurrency = 'EUR';
        $targetCurrencies = ['USD', 'PLN'];
        $expectedResult = [
            'USD' => 1.7,
            'PLN' => 0.7,
        ];

        $mockCurrencyExchangeService->shouldReceive('getExchangeRateFromStorage')
            ->with($baseCurrency, $targetCurrencies)
            ->once()
            ->andReturn($expectedResult);
      

        $response = $this->json('GET', '/api/exchange-rate', [
            'base_currency' => $baseCurrency,
            'target_currencies' => implode(',', $targetCurrencies),
        ]);

        // // Assert the response
        $response->assertStatus(200)
            ->assertJson($expectedResult);
    }
}
