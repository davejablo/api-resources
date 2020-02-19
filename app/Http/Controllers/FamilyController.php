<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Repositories\FamilyRepository;
use App\Http\Requests\StoreFamilyRequest;
use App\Http\Requests\UpdateFamilyRequest;
use App\Http\Resources\FamilyResource;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    protected $familyRepository;

    public function __construct(FamilyRepository $repository)
    {
        $this->familyRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FamilyResource::collection($this->familyRepository->getFamilies());
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
     * @param StoreFamilyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFamilyRequest $request)
    {
        $newFamily = $this->familyRepository->createAndReturnFamily($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Family added',
            'data' => [
                'item' => $newFamily
            ]
        ], 200);
    }

    /**
     * @param Family $family
     * @return FamilyResource
     */
    public function show(Family $family)
    {
        return new FamilyResource($family);
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
     * @param UpdateFamilyRequest $request
     * @param Family $family
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFamilyRequest $request, Family $family)
    {
        $familyToReturn = $this->familyRepository->updateAndReturnFamily($request, $family);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Family updated',
            'data' => [
                'item' => $familyToReturn,
            ]
        ], 200);
    }

    /**
     * @param Family $family
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Family $family)
    {
        $this->familyRepository->destroyFamily($family);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Family deleted',
        ], 200);
    }
}
