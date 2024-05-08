<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductDestroyRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = ProductResource::collection(Product::simplePaginate(5));
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No Products found'], Response::HTTP_NOT_FOUND);
        }
        return $products;
    }

    public function show_products_in_category($product){
        $product = ProductResource::collection(Product::where('category_id',$product)->simplePaginate(5));
        if ($product->isEmpty()) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        return $product;
    }

    public function show($product)
    {
        $product = ProductResource::collection(Product::where('id', $product)->get());
        if ($product->isEmpty()) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
        return $product;
        
    }

    public function store( ProductRequest $request)
    {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name'=>$request->name,
            'description' => $request->description,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
        ]);
        return new ProductResource( $product, Response::HTTP_CREATED);
    }

    public function update(ProductUpdateRequest $request)
    {
        Product::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'category_id' => $request->category_id,
        ]);
        return response(["message " => "Updated Successfull"], Response::HTTP_OK);
    }

    public function destroy(ProductDestroyRequest $request)
    {
        Product::where('id', $request->id)->delete();
        return response()->json(['message' => 'Deleted Successfull'], 200);
    }
}
