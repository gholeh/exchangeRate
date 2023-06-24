<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\CurrencyExchangeService;
use Carbon\Carbon;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Starting Currencies seeding');

        $currencyService = new CurrencyExchangeService();
        $now = Carbon::now();
        $currencies = $currencyService->fetchCurrencies();
       
        if ($currencies->count() > 0) 
        {
            foreach ($currencies as $symbol => $name ) {
                Currency::insert([
                    'symbol' => $symbol,
                    'name' => $name,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
            $this->command->info('Currencies seeding completed.');
        }else{

             $this->command->info('There is a problem');
        }
       
    }
}

