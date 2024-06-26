<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAttributeValueDestroyRequest;
use App\Http\Requests\ProductAttributeValueRequest;
use App\Http\Requests\ProductAttributeValueUpdateRequest;
use App\Http\Resources\ProductAttributeValueResource;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductAttributeValueController extends Controller
{
    public function index($product)
    {
        $products =ProductAttributeValueResource::collection(ProductAttributeValue::where('product_id',$product)->get());
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No Attribute found'], Response::HTTP_NOT_FOUND);
        }
        return $products;
    }
    public function show($product_attribute_value, $product)
    {
        $product = ProductAttributeValueResource::collection(
            ProductAttributeValue::where('product_id',$product_attribute_value )
            ->where('id', $product)
            ->get());
        if ($product->isEmpty()) {
            return response()->json(['message' => 'Attribute not found'], Response::HTTP_NOT_FOUND);
        }
        return $product;
    }
    public function store(ProductAttributeValueRequest $request)
    {
        $product=Product::find($request->product_id);
        $product->attributes()->attach(
            $request->product_attribute_id,
            [
                'value'=>$request->value,
            ]);
        return response(["message " => "Created Successfull"], Response::HTTP_OK);
    }
    public function update( ProductAttributeValueUpdateRequest $request)
    {
        ProductAttributeValue::where('id', $request->id)->update([
            'value'=>$request->value,
        ]);
        return response(["message " => "Updated Successfull"], Response::HTTP_OK);
    }
    public function destroy(ProductAttributeValueDestroyRequest $request,$product)
    {
        ProductAttributeValue::where('id', $request->id)->delete();
        return response()->json(['message' => 'Deleted Successfull'], 200);
    }
}
