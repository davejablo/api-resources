<?php


namespace App\Http\Repositories;


use App\Group;
use App\Http\Resources\GroupResource;

class GroupRepository
{
    public function createAndReturnGroup($request){
        $group = Group::create($request->validated());
        if ($group->save()){
            return new GroupResource($group);
        }
    }

    public function getGroups(){
        return $groups = Group::all();
    }

    public function getGroup($group){
//        return $GroupToReturn = Group::findOrFail($id);
    }

    public function destroyGroup($groupToDestroy){
        $groupToDestroy->delete();
    }

    public function updateAndReturnGroup($request, $id){

        $groupFromDb = Group::findOrFail($id);
        $groupToReturn = $groupFromDb->update($request->validated());

        return $groupToReturn;

        $newResource = new GroupResource($groupToReturn);
        dd($newResource->name);


        dd($groupToReturn);

        return new GroupResource($groupToReturn);

//        if ($GroupToUpdate->save()){
//            return new GroupResource($GroupToUpdate);
//        }
    }

}