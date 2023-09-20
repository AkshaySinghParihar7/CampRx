<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campform;
use App\Models\Employee;

class ReportsController extends Controller
{
    public function GetReport(){
        $campaignCounts = Campform::select('campType', Campform::raw('count(campType) as count'))
                            ->groupBy('campType')
                            ->get();

        if($campaignCounts->count() > 0){
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $campaignCounts,
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

    public function downloadCampReport($campType){
        $campTypeData = Campform::where('campType', $campType)->get();

        if($campTypeData->count() > 0){
            $employeeArr = [];
            $i = 1;
            foreach($campTypeData as $data){
                $tempEmpData = Employee::where('EMPCODE', $data->empId)->first();
                $tempEmpData['TM_Name'] = $data->tmName;
                $tempEmpData['Doctor_Name'] = $data->doctorName;
                $tempEmpData['Camp_Type'] = $data->campType;
                $tempEmpData['Camp_Date'] = $data->campDate;
                $tempEmpData['Speciality'] = $data->speciality;
                $tempEmpData['POB'] = $data->POB;
                $tempEmpData['NoOfPatientScreened'] = $data->noOfPatientScreened;
                $tempEmpData['NoOfRxnGenerated'] = $data->onOfRxnGenerated;
                $tempEmpData['id'] = $i++;
                if ($tempEmpData) {
                    $employeeArr[] = $tempEmpData;
                }
            }
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $employeeArr,
                'token' => ""
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'No data found for the given campaign',
            ], 200);
        }

    }

    public function downloadFullReport()
    {
        //$campTypeData = Campform::all();
        $campTypeData = Campform::orderBy('campType', 'asc')->get();
        if($campTypeData->count() > 0){
            $employeeArr = [];
            $i = 1;
            foreach($campTypeData as $data){
                $tempEmpData = Employee::where('EMPCODE', $data->empId)->first();
                $tempEmpData['TM_Name'] = $data->tmName;
                $tempEmpData['Doctor_Name'] = $data->doctorName;
                $tempEmpData['Camp_Type'] = $data->campType;
                $tempEmpData['Camp_Date'] = $data->campDate;
                $tempEmpData['Speciality'] = $data->speciality;
                $tempEmpData['POB'] = $data->POB;
                $tempEmpData['NoOfPatientScreened'] = $data->noOfPatientScreened;
                $tempEmpData['NoOfRxnGenerated'] = $data->onOfRxnGenerated;
                $tempEmpData['id'] = $i++;
                if ($tempEmpData) {
                    $employeeArr[] = $tempEmpData;
                }
            }
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $employeeArr,
                'token' => ""
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'No data found for the given campaign',
            ], 200);
        }
    }
}
