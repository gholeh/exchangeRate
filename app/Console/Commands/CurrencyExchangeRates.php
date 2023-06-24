<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurrencyExchangeService;

class CurrencyExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:currency:rates {base_currency} {target_currencies*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch currency rates for a base currency and target currencies';

    protected $currencyExchangeService;

    public function __construct(CurrencyExchangeService $currencyExchangeService)
    {
        parent::__construct();
        $this->currencyExchangeService = $currencyExchangeService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $baseCurrency = $this->argument('base_currency') ?? 'EUR';
        $targetCurrencies = $this->argument('target_currencies');
        
        $this->currencyExchangeService->fetchAndSaveCurrencyRates($baseCurrency, $targetCurrencies);

        $this->info('Currency rates fetched and saved successfully.');
    }
}
