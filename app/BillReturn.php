<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillReturn extends Model
{
    public function BillItems(){

        return $this->hasMany(BillItems::class, 'bill_id');

    }

    public function rl_return_items(){

        return $this->hasMany(ReturnItem::class);

    }

    public function customer(){

        return $this->belongsTo(Customer::class);

    }
}
