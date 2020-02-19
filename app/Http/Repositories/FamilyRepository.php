<?php


namespace App\Http\Repositories;

use App\Family;
use App\Http\Resources\FamilyResource;

class FamilyRepository
{
    public function createAndReturnFamily($request){
        $family = Family::create($request->validated());
        if ($family->save()){
            return new FamilyResource($family);
        }
    }

    public function getFamilies(){
        return $families = Family::all();
    }

    public function getFamily($family){
//        return $familyToReturn = Family::findOrFail($id);
    }

    public function destroyFamily($familyToDestroy){
        $familyToDestroy->delete();
    }

    public function updateAndReturnFamily($request, $family){

        $familyToReturn = $family->update($request->validated());

        $newResource = new FamilyResource($familyToReturn);
        dd($newResource->name);


        dd($familyToReturn);

        return new FamilyResource($familyToReturn);

//        if ($familyToUpdate->save()){
//            return new FamilyResource($familyToUpdate);
//        }
    }
}