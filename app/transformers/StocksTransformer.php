<?php
/**
 * Created by PhpStorm.
 * User: TM 8 PC
 * Date: 6/10/2018
 * Time: 4:48 PM
 */

namespace App\Transformers;


use App\Stocks;
use League\Fractal\TransformerAbstract;

class StocksTransformer extends TransformerAbstract
{
    public function transform(Stocks $stocks)
    {
        return [
            'id'            => (int) $stocks->id,
            'user'          => (string) $stocks->user->name,
            'item'         => (string) $stocks->item->label,
            'dealer'       => (string) $stocks->vendor->name,
            'batch_no'       => (string) $stocks->batch_no,
            'invoice_number' => (int) $stocks->invoice_number,
            'exp_date'       => (string) $stocks->exp_date,
            'quantity'       => (string) $stocks->quantity,
            'mrp'       => (string) $stocks->mrp,
            'dealer_price'       => (string) $stocks->dealer_price,
            'breakage'       => (string) $stocks->breakage
        ];
    }
}