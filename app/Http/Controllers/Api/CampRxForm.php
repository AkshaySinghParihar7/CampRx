<?php

namespace App\Http\Controllers\Api;


use App\Models\Campform;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CampRxForm extends Controller
{
    public function GetCampform(){
        $Campform = Campform::all();

        if($Campform->count() > 0){
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $Campform,
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

    public function GetCampformByEmpId($empId){
        $Campform = Campform::where('empId', $empId)->get();
        if($Campform->count() > 0){
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $Campform,
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

    public function GetFormById($id){
        $Campform = Campform::find($id);

        if($Campform->count() > 0){
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $Campform,
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

    public function AddCampform(Request $request){

        $validate = Validator::make($request->all(),
        [
            'tmName' => 'required',
            'campDate' => 'required',
            'POBImagePath' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'msg' => $validate->messages(),
                'data' => [],
                'token' => ""
            ],422);
        }else{
            // $campDate = date('Y-m-d H:i:s', strtotime($request->campDate));
            $campDate = Carbon::parse($request->campDate)->addDay();
            $Campform = Campform::create([
                'tmName' => $request->tmName,
                'doctorName' => $request->doctorName,
                'campType' => $request->campType,
                'speciality' => $request->speciality,
                'POB' => $request->POB,
                'noOfPatientScreened' => $request->noOfPatientScreened,
                'onOfRxnGenerated' => $request->onOfRxnGenerated,
                'campDate' => $campDate,
                'POBImagePath' => $request->POBImagePath,
                'empId' => $request->empId
            ]);
        }

        if($Campform){
            return response()->json([
                'status' => true,
                'msg' => 'Camp Form added successfully!',
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

    public function UpdateCampform(Request $request, int $id){
        $validate = Validator::make($request->all(),
        [
            'tmName' => 'required',
            'campDate' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'msg' => $validate->messages(),
                'data' => [],
                'token' => ""
            ],422);
        }else{
            $Campform = Campform::find($id);
            if($Campform){
                // $campDate = date('Y-m-d H:i:s', strtotime($request->campDate));
                $campDate = Carbon::parse($request->campDate)->addDay();
                $Campform->update([
                    'tmName' => $request->tmName,
                    'doctorName' => $request->doctorName,
                    'campType' => $request->campType,
                    'speciality' => $request->speciality,
                    'POB' => $request->POB,
                    'noOfPatientScreened' => $request->noOfPatientScreened,
                    'onOfRxnGenerated' => $request->onOfRxnGenerated,
                    'campDate' => $campDate,
                    'empId' => $request->empId
                ]);
                return response()->json([
                    'status' => true,
                    'msg' => 'Camp Form updated successfully!',
                    'data' => [],
                    'token' => ""
                ],200);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'Camp Form Not Found!',
                    'data' => [],
                    'token' => ""
                ],404);
            }
        }
    }

    public function POBImgUpload(Request $request)
    {
        $uploadedImage = $request->file('croppedImage');

        // Define where you want to store the uploaded image
        $destinationPath = public_path('Images/POB');
        $imageName = uniqid() . '.jpg';

        $uploadedImage->move($destinationPath, $imageName);
        return response()->json([
            'status' => true,
            'msg' => 'Image uploaded successfully',
            'data' => $imageName,
            'token' => ""
        ],200);
    }

    public function DeleteCampform(int $id){
        $Campform = Campform::find($id);

        if($Campform){
            $Campform->delete();
            return response()->json([
                'status' => true,
                'msg' => 'Camp Form Deleted successfully!',
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

    // public function GetCampaignById($id){
    //     $campaigns = Campaign::find($id);

    //     if($campaigns){
    //         return response()->json([
    //             'status' => true,
    //             'msg' => 'Success',
    //             'data' => $campaigns,
    //             'token' => ""
    //         ],200);
    //     }else{
    //         return response()->json([
    //             'status' => false,
    //             'msg' => 'Campaign Not Found!',
    //             'data' => [],
    //             'token' => ""
    //         ],404);
    //     }
    // }

    // public function UpdateCampaign(Request $request, int $id){
    //     $validate = Validator::make($request->all(),
    //     [
    //         'name' => 'required',
    //         'status' => 'required',
    //     ]);

    //     if($validate->fails()){
    //         return response()->json([
    //             'status' => false,
    //             'msg' => $validate->messages(),
    //             'data' => [],
    //             'token' => ""
    //         ],422);
    //     }else{
    //         $campaigns = Campaign::find($id);
    //         if($campaigns){
    //             $campaigns->update([
    //                 'name' => $request->name,
    //                 'status' => $request->status,
    //             ]);
    //             return response()->json([
    //                 'status' => true,
    //                 'msg' => 'Campaign updated successfully!',
    //                 'data' => [],
    //                 'token' => ""
    //             ],200);
    //         }else{
    //             return response()->json([
    //                 'status' => false,
    //                 'msg' => 'Campaign Not Found!',
    //                 'data' => [],
    //                 'token' => ""
    //             ],404);
    //         }
    //     }
    // }

    // public function DeleteCampaign($id){
    //     $campaigns = Campaign::find($id);

    //     if($campaigns){
    //         $campaigns->delete();
    //         return response()->json([
    //             'status' => true,
    //             'msg' => 'Campaign deleted successfully!',
    //             'data' => [],
    //             'token' => ""
    //         ],200);
    //     }else{
    //         return response()->json([
    //             'status' => false,
    //             'msg' => 'Campaign Not Found!',
    //             'data' => [],
    //             'token' => ""
    //         ],404);
    //     }
    // }

}
