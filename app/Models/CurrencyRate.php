<?php

namespace App\Models;

class CurrencyRate extends DefaultModel
{
    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
