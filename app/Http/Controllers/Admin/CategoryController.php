<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\PostCategory;

class CategoryController extends Controller
{
    public function index(Request $request) {
    	$limit = $request->limit;

    	$category = Category::paginate(isset($limit) ? $limit : 15);

        return $this->dataResponse($category);
    }

    public function store(PostCategory $request) {
    	$input = $request->only('category_name');
    	try {
    		$checkExistsName = Category::where('category_name', $input['category_name'])->first();
    		if ($checkExistsName) {
    			return $this->errorResponse('Category already exist', 403);
    		}
    		$save = Category::create($input);
    	} catch(\Exception $e) {
    		return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
    	}
    	return $this->successResponse('Category created');
    }

    public function edit(PostCategory $request, $id) {
    	$input = $request->only('category_name');
    	try {
    		$findCategory = Category::find($id);
    		if (!$findCategory) {
    			return $this->errorResponse('Category not found', 404);
    		}

    		$checkExistsName = Category::where('category_name', $input['category_name'])
    			->where('id', '!=', $id)
    			->first();
    		if ($checkExistsName) {
    			return $this->errorResponse('Category already exist', 403);
    		}

    		$update = $findCategory->fill($input)->save();
    	} catch (\Exception $e) {
    		return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
    	}
    	return $this->successResponse('Category updated');
    }

    public function destroy($id) {
    	try {
    		$findCategory = Category::find($id);
			if (!$findCategory) {
				return $this->errorResponse('Category not found', 404);
			}
			Category::destroy($id);
    	} catch(\Exception $e) {
    		return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error"); 
    	}
    	return $this->successResponse('Category deleted');
    }
}
