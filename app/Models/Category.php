<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description', 
    ];
    public function categoryProduct() {
        return $this->hasMany(Product::class, 'category_id','id');
    }
    public function categoryProductAttribute() {
        return $this->hasMany(ProductAttribute::class, 'category_id','id');
    }
}
