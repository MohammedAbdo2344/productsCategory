<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryDestroyRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryResource::collection(Category::with(['categoryProduct'])->simplePaginate(5));
        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'Category Not found'
            ],  Response::HTTP_NOT_FOUND);
        }
        return $categories;
    }
    public function show($category)
    {
        $contact = CategoryResource::collection(Category::where('id', $category)->get());
        if ($contact->isEmpty()) {
            return response()->json([
                'message' => 'Category Not found'
            ],  Response::HTTP_NOT_FOUND);
        }
        return $contact;
    }
    public function store(CategoryRequest $request)
    {
        $contacts = Category::create($request->all());
        return new CategoryResource($contacts, Response::HTTP_CREATED);
    }
    public function update(CategoryUpdateRequest $request)
    {
        Category::where('id',$request->id)->update(['name'=>$request->name]);
        return response()->json(['message' => 'Updated Successfull'], 200);
    }
    public function destroy(CategoryDestroyRequest $request)
    {
        Category::where('id',$request->id)->delete();
        return response()->json(['message' => 'Deleted Successfull'], 200);
    }
}
