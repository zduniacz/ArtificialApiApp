<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Transformers\CategoryTransformer;
use App\Category;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->title = $request->title;
        $category->save();
        return fractal()
            ->item($category)
            ->transformWith(new CategoryTransformer)
            ->toArray();
    }
}
