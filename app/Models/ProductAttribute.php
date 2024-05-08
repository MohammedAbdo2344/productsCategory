<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'category_id'
    ];
    public function categoryProductAttributeValue() {
        return $this->hasMany(ProductAttributeValue::class, 'product_attribute_id','id');
    }
    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
