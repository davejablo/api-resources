<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'type', 'details', 'price'];

    const PRODUCT_TYPES = ['food', 'electronics', 'cosmetics'];

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
