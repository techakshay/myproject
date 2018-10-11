<?php
/**
 * Created by PhpStorm.
 * User: TM 8 PC
 * Date: 6/10/2018
 * Time: 4:48 PM
 */

namespace App\Transformers;


use App\Item;
use League\Fractal\TransformerAbstract;

class ItemsTransformer extends TransformerAbstract
{
    public function transform(Item $item)
    {
        return [
            'id'            => (int) $item->id,
            'user_id'          => (string) $item->user->name,
            'product_name'         => (string) $item->label,
            'hsn_code'       => (string) $item->hsn_code,
            'mfg_code'       => (string) $item->mfg_code,
            'gst'       => (string) $item->gst,
            'available'       => (string) $item->available,
            'min_stock'       => (string) $item->min_stock
        ];
    }
}