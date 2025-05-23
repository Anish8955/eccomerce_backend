<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status' => 200,
            'errors' => 'Category added successfully.',
            'data' => $category
        ], 200);

    }

    public function show($id)
    {

        $category = Category::find($id);


        if ($category == null) {
            return response()->json([
                'status' => 404,
                'errors' => 'Category not found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $category
        ]);

    }

    public function update($id, Request $request)
    {

        $category = Category::find($id);


        if ($category == null) {
            return response()->json([
                'status' => 404,
                'errors' => 'Category not found.',
                'data' => []
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }


        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status' => 200,
            'errors' => 'Category updated successfully.',
            'data' => $category
        ], 200);

    }



    public function destroy($id)
    {
         $category = Category::find($id);


        if ($category == null) {
            return response()->json([
                'status' => 404,
                'errors' => 'Category not found.',
                'data' => []
            ], 404);
        }

         $category->delete();

        return response()->json([
            'status' => 200,
            'errors' => 'Category deleted successfully.',
        ], 200);
    }
}
