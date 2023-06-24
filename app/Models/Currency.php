<?php

namespace App\Models;

class Currency extends DefaultModel
{
    protected $guarded = [];

    public function currencyRates()
    {
        return $this->hasMany(CurrencyRate::class);
    }

}
