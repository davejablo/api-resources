<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Repositories\GroupRepository;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected $GroupRepository;

    public function __construct(GroupRepository $repository)
    {
        $this->groupRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GroupResource::collection($this->groupRepository->getGroups());
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
     * @param StoreGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreGroupRequest $request)
    {
        $newGroup = $this->groupRepository->createAndReturnGroup($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Group added',
            'data' => [
                'item' => $newGroup
            ]
        ], 200);
    }

    /**
     * @param Group $Group
     * @return GroupResource
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
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
     * @param UpdateGroupRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $updatedGroup = new GroupResource($this->groupRepository->updateAndReturnGroup($request, $id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Group updated',
            'data' => [
                'item' => $updatedGroup,
            ]
        ], 200);
    }

    /**
     * @param Group $Group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Group $group)
    {
        $this->groupRepository->destroyGroup($group);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Group deleted',
        ], 200);
    }
}
