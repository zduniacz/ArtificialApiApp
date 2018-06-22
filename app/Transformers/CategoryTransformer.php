<?php

namespace App\Transformers;
use App\Category;
class CategoryTransformer extends \League\Fractal\TransformerAbstract
{

    public function transform(Category $category) {
        return [
            'title' => $category->title,
            'created_at' => $category->created_at->toDateTimeString(),
            'created_at_human' => $category->created_at->diffForHumans(),
        ];
    }

    
}