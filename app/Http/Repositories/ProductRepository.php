<?php


namespace App\Http\Repositories;


use App\Http\Resources\ProductResource;
use App\Product;

class ProductRepository
{
    public function createAndReturnProduct($request){
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->type = $request->type;
        $product->details = $request->details;
        $product->price = $request->price;
        if ($product->save()){
            return new ProductResource($product);
        }
    }

    public function updateAndReturnProduct($request, $id){
        $productToUpdate = Product::findOrFail($id);
        $productToUpdate->category_id = $request->category_id;
        $productToUpdate->type = $request->type;
        $productToUpdate->details = $request->details;
        $productToUpdate->price = $request->price;
        if ($productToUpdate->save()){
            return new ProductResource($productToUpdate);
        }
    }
}