<?php

namespace App\Providers;

use App\BillItems;
use App\Bills;
use App\Customer;
use App\Item;
use App\Stocks;
use App\Vendor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        //Items::creating([$this , 'user_add']);
        //Customer::creating([$this , 'user_add']);
        Stocks::creating([$this , 'user_add']);
        Item::creating([$this , 'user_add']);
        //Bills::creating([$this , 'user_add']);
        //Vendor::creating([$this , 'user_add']);

        /*Items::creating(function($model){
            $model->user_id = auth()->id();
        });*/

    }

    public function user_add($model){
        if(auth()->id()) {
            $model->created_by = auth()->id();
        } else {
            $model->created_by = 1;
        }
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
