<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speciality;
use Illuminate\Support\Facades\Validator;

class SpecialityController extends Controller
{
    public function GetSpeciality(){
        $Speciality = Speciality::all();

        if($Speciality->count() > 0){
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $Speciality,
                'token' => ""
            ],200);
        }else{
            return response()->json([
                'status' => true,
                'msg' => 'No record found',
                'data' => [],
                'token' => ""
            ],200);
        }
    }

    public function GetActiveSpeciality(){
        $Speciality = Speciality::where("status","0")->get();

        if($Speciality->count() > 0){
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $Speciality,
                'token' => ""
            ],200);
        }else{
            return response()->json([
                'status' => true,
                'msg' => 'No record found',
                'data' => [],
                'token' => ""
            ],200);
        }
    }

    public function AddSpeciality(Request $request){

        $validate = Validator::make($request->all(),
        [
            'key' => 'required',
            'status' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'msg' => $validate->messages(),
                'data' => [],
                'token' => ""
            ],422);
        }else{
            $Speciality = Speciality::create([
                'key' => $request->key,
                'value' => $request->value,
                'status' => $request->status,
                'extras' => $request->extras,
            ]);
        }

        if($Speciality){
            return response()->json([
                'status' => true,
                'msg' => 'Speciality added successfully!',
                'data' => [],
                'token' => ""
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong!',
                'data' => [],
                'token' => ""
            ],200);
        }
    }

    public function DeleteSpeciality($id){
        $Speciality = Speciality::find($id);

        if($Speciality){
            $Speciality->delete();
            return response()->json([
                'status' => true,
                'msg' => 'Speciality deleted successfully!',
                'data' => [],
                'token' => ""
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'Speciality Not Found!',
                'data' => [],
                'token' => ""
            ],200);
        }
    }

    public function StatusChange($id, $status){
        $speciality = Speciality::find($id);
        if($speciality){
            $speciality->update([
                'status' => $status,
            ]);
            return response()->json([
                'status' => true,
                'msg' => $speciality->value .' status updated successfully!',
                'data' => [],
                'token' => ""
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong!',
                'data' => [],
                'token' => ""
            ],200);
        }
    }
}
