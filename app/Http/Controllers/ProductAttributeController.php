<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAttributeDestroyRequest;
use App\Http\Requests\ProductAttributeRequest;
use App\Http\Requests\ProductAttributeUpdateRequest;
use App\Http\Resources\ProductAttributeResource;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductAttributeController extends Controller
{
    public function index($category)
    {
        $productsAttribute = ProductAttributeResource::collection(ProductAttribute::where('category_id',$category)->get());
        if ($productsAttribute->isEmpty()) {
            return response()->json(['message' => 'No Products found'], Response::HTTP_NOT_FOUND);
        }
        return $productsAttribute;
    }
    public function show($category, $product)
    {
        $productsAttribute = ProductAttributeResource::collection(ProductAttribute::where('category_id', $category)->where('id', $product)->get());
        if ($productsAttribute->isEmpty()) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        return $productsAttribute;
    }
    public function store($category, ProductAttributeRequest $request)
    {
        $productsAttribute = ProductAttribute::create([
            'category_id' => $category,
            'name'=>$request->name,
            'description' => $request->description,
        ]);
        return new ProductAttributeResource( $productsAttribute, Response::HTTP_CREATED);
    }
    public function update(ProductAttributeUpdateRequest $request)
    {
        ProductAttribute::where('id', $request->id)->update([
            'name' => $request->name,
        ]);
        return response(["message " => "Updated Successfull"], Response::HTTP_OK);
    }
    public function destroy(ProductAttributeDestroyRequest $request)
    {
        ProductAttribute::where('id', $request->id)->delete();
        return response()->json(['message' => 'Deleted Successfull'], 200);
    }
}
