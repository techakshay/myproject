<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'), // secret
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Vendor::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address'=>$faker->address,
        'city'=>$faker->city,
        'state'=>$faker->name,
        'tel'=>$faker->phoneNumber,
        'fax'=>$faker->randomNumber(),
        'email' => $faker->unique()->safeEmail,
        'website' => $faker->unique()->safeEmail,
        'cin_no'=>$faker->randomNumber(),
        'gst_no' =>$faker->phoneNumber,
        'type' => rand(1,2)
    ];
});
$factory->define(App\Item::class, function (Faker $faker) {
    return [
        'product_name' => $faker->name,
        'potency' => $faker->numberBetween(0,2),
        'packing' => $faker->randomNumber(),
        'hsn_code' => $faker->randomDigit,
        'mfg_code' => $faker->text(20),
        'gst' => function(){
            $gst = [5, 12, 18, 28];
            $one = array_random($gst);
            return $one;
        },
        'available' => $faker->numberBetween(50,100),
    ];
});
$factory->define(App\Stocks::class, function (Faker $faker) {
    return [
        'item_id' => function(){

            return factory(App\Item::class)->create()->id;
            },
        'vendor_id' => function(){
            return factory(App\Vendor::class)->create()->id;
        },
        'batch_no' => $faker->randomNumber(),
        'exp_date' => $faker->dateTime,
        'quantity' => $faker->numberBetween(50,100),
        'mrp' => $faker->numberBetween(150,200),
        'dealer_price' => $faker->numberBetween(50,100),
        'invoice_number' => $faker->numberBetween(50,100),
    ];
});
$factory->define(App\Bills::class, function (Faker $faker) {
    return [
        'customer_id' => function(){

            return factory(App\Customer::class)->create()->id;
        },
        'total_amount' =>$faker->numberBetween(0,3),
        'cgst_amount' =>$faker->numberBetween(0,3),
        'sgst_amount' =>$faker->numberBetween(0,3),
        'gst_5_amount' =>$faker->numberBetween(0,3),
        'gst_12_amount' =>$faker->numberBetween(0,3),
        'gst_18_amount' =>$faker->numberBetween(0,3),
        'gst_28_amount' =>$faker->numberBetween(0,3),
        'coin_adjustment' =>$faker->numberBetween(0,3),
        'net_amount' =>$faker->numberBetween(0,3),
        'bill_date' =>$faker->dateTime(),
        'type' =>$faker->numberBetween(0,3),
    ];
});
$factory->define(App\BillItems::class, function (Faker $faker) {
    $discount = $faker->numberBetween(10,20);
    $quantity = $faker->numberBetween(1,10);
    $rate = $faker->numberBetween(100,150);
    $discount_amount = $quantity * $rate * $discount / 100;
    $raw_amount = $quantity * $rate - $discount_amount;
    $data = [
        'bill_id' => function(){
            return rand(1, 50);
        },
        /*'item_id' => function(){

            return factory(App\Items::class)->create()->id;
        },*/
        'stock_id' => function(){
            return rand(1, 100);
        },
        'quantity'=> $quantity,
        'rate'=> $rate,
        'discount'=> $discount,
        'discount_amount'=> $discount_amount,
        'gst' => function(){
            $gst = [5, 12, 18, 28];
            $one = array_random($gst);
            return $one;
        },
        'gst_amount' => $raw_amount
        //'gst'=>$faker->numberBetween(0,3),
        //'amount'=>$faker->numberBetween(200,500),
    ];
    $data['amount'] = $data['quantity'] * $data['rate'];
    $discount_amount = $data['amount'] * $data['discount'] / 100;
    $data['amount'] -= $discount_amount;
    //$gst_amount = $data['amount'] * $data['gst'] / 100;
    return $data;
});
$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address'=>$faker->address,
        'city'=>$faker->city,
        'state'=>$faker->text(20),
        'tel'=>$faker->phoneNumber,
        'fax'=>$faker->randomNumber(),
        'email' => $faker->unique()->safeEmail,
        'website' => $faker->unique()->safeEmail,
        'cin_no'=>$faker->randomNumber(),
        'dl_no'=>$faker->randomNumber(),
        'gst_no'=>$faker->randomNumber(),
        'type' => rand(1,2)
    ];
});