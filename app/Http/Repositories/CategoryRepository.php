<?php


namespace App\Http\Repositories;


use App\Category;
use App\Http\Resources\CategoryResource;

class CategoryRepository
{
    public function createAndReturnCategory($request){
        $category = new Category();
        $category->name = $request->name;
        if ($category->save()){
            return new CategoryResource($category);
        }
    }

    public function updateAndReturnCategory($request, $id){
        $categoryToUpdate = Category::findOrFail($id);
        $categoryToUpdate->name = $request->name;
        if ($categoryToUpdate->save()){
            return new CategoryResource($categoryToUpdate);
        }
    }
}