<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Trader extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'traders';

    protected $fillable = [
        'trader_id','user_id', 'broker_name', 'broker_email', 'user_id', 'trader_name', 'stock_name', 'current_stock_value',
        'own_money', 'borrowed_money',
        'margin_threshold', 'current_stock_count',
        'initial_total_investment', 'current_total_value', 'equity', 'status'
    ];

    // Make initial_total_investment a computed attribute
    public function getInitialTotalInvestmentAttribute()
    {
        return $this->own_money + $this->borrowed_money;
    }

    // Computed fields
    public function getCurrentTotalValueAttribute()
    {
        return $this->current_stock_value * $this->current_stock_count;
    }

    public function getEquityAttribute()
    {
        return $this->current_total_value - $this->borrowed_money;
    }

    public function getStatusAttribute()
    {
        $ratio = ($this->current_total_value > 0)
            ? ($this->equity / $this->current_total_value) * 100
            : 0;
        return $this->margin_threshold >= $ratio ? 'ALERT' : 'OK';
    }
}
