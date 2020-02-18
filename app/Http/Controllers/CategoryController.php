<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Repositories\CategoryRepository;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all()->keyBy->id;
        return CategoryResource::collection($categories);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        $newCategory = $this->categoryRepository->createAndReturnCategory($request);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Category added',
            'data' => [
                'item' => $newCategory
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
        $categoryToShow = Category::findOrFail($id);
        return new CategoryResource($categoryToShow);
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
        $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        $categoryToUpdate = $this->categoryRepository->updateAndReturnCategory($request, $id);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Category updated',
            'data' => [
                'item' => $categoryToUpdate,
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
        $categoryToDestroy = Category::findOrFail($id);
        if ($categoryToDestroy->delete()){
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Category '.$categoryToDestroy->id.' deleted',
            ]);
        }
    }
}
