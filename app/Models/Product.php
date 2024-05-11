<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function categoryProductAttributeValue()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id', 'id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttributeValue::class,
            'product_attribute_values',
            'product_id',
            'product_attribute_id',
        )
        ->withTimestamps();
    }
}
