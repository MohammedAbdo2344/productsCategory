<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'quantity',
        
    ];
    public function categoryProductAttributeValue() {
        return $this->hasMany(ProductAttributeValue::class, 'product_id','id');
    }
    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
