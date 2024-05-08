<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_attribute_id',
        'value'
    ];
    public function products() {
        return $this->belongsToMany(Product::class);
    }
    public function product_attributes() {
        return $this->belongsToMany(ProductAttribute::class);
    }
}
