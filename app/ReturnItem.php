<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    public $guarded = [];

    public function rl_stock(){

        return $this->hasOne(Stocks::class, 'id', 'stock_id');

    }
}
