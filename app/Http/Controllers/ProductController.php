<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use mysql_xdevapi\Collection;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all()->keyBy->id;
        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $newProduct = $this->productRepository->createAndReturnProduct($request);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Product added',
            'data' => [
                'item' => $newProduct
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productToShow = Product::findOrFail($id);
        return new ProductResource($productToShow);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productToUpdate = $this->productRepository->updateAndReturnProduct($request, $id);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Product updated',
            'data' => [
                'item' => $productToUpdate->refresh()
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productToDestroy =  Product::findOrFail($id);
        if ($productToDestroy->delete()){
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Product '.$productToDestroy->id.' deleted',
            ]);
        }
    }
}
