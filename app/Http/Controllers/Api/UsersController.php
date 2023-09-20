<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function GetUsers() {
        // $users = User::where('status', '0')->get();
        $users = User::all();
        if ($users->count() > 0) {
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $users, // Changed from $Users to $users
                'token' => ""
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'msg' => 'No record found',
                'data' => [],
                'token' => ""
            ], 200);
        }
    }

    public function AddUser(Request $request){
        $validate = Validator::make($request->all(),
        [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'msg' => $validate->messages(),
                'data' => [],
                'token' => ""
            ],200);
        }else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->empId,
                'phone' => $request->phone,
                'role' => $request->role,
                'empId' => $request->empId,
                'status' => 0,
            ]);

            Employee::create([
                'EMPNAME' => $request->name,
                'EMAILIDPERSONAL' => $request->email,
                'EMPCODE' => $request->empId,
                'MOBILENO' => $request->phone,
                'STATUS' => "ACTIVE"
            ]);
        }

        if($user){
            return response()->json([
                'status' => true,
                'msg' => 'User added successfully!',
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

    public function GetUserById($id){
        $user = User::find($id);

        if($user){
            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'data' => $user,
                'token' => ""
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'User Not Found!',
                'data' => [],
                'token' => ""
            ],404);
        }
    }

    public function UpdateUser(Request $request, int $id){
        $validate = Validator::make($request->all(),
        [
            'name' => 'required|string|max:255',
            'email' => 'required|email|',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'msg' => $validate->messages(),
                'data' => [],
                'token' => ""
            ],200);
        }else{
            $users = User::find($id);
            if($users){
                $users->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'empId' => $request->empId,
                    'role' => $request->role,
                    'status' => $request->status,
                ]);
                $employee = Employee::where('EMPCODE',$users->empId)->first();
                if($employee){
                    $status = "";
                    if($request->status == 1 || $request->status == "1"){
                        $status = NULL;
                    }else{
                        $status = "ACTIVE";
                    }
                    $employee->update([
                        'EMPNAME' => $request->name,
                        'EMAILIDPERSONAL' => $request->email,
                        'EMPCODE' => $request->empId,
                        'MOBILENO' => $request->phone,
                        'STATUS' => $status
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'msg' => 'User updated successfully!',
                    'data' => [],
                    'token' => ""
                ],200);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'User Not Found!',
                    'data' => [],
                    'token' => ""
                ],200);
            }
        }
    }

    public function DeleteUser($id){
        $user = User::find($id);

        if($user){
            $user->update([
                'status' => 1,
                // 'extras' => $request->extras,
            ]);
            return response()->json([
                'status' => true,
                'msg' => 'User Deleted successfully!',
                'data' => [],
                'token' => ""
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'User Not Found!',
                'data' => [],
                'token' => ""
            ],404);
        }
    }

    public function ResetPassword(int $id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'msg' => 'User not found',
            ], 200);
        }

        $user->update([
            'password' => $user->empId,
        ]);


        return response()->json([
            'status' => true,
            'msg' => 'Password Reset successfully!',
            'data' => [],
            'token' => ""
        ],200);
    }

    public function isLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'empId' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'msg' => $validator->messages(),
                'data' => [],
                'token' => ""
            ],404);
        }

        $user = User::where('empId', $request->empId)->first();

        if($user->status == 1 || $user->status == "1"){
            return response()->json([
                'status' => false,
                'msg' => "Invalid Id or Password",
                'data' => [],
                'token' => ""
            ],401);
        }

        $credentials = $request->only('empId', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => true,
                'msg' => "Login successfully",
                'data' => $user,
                'token' => uniqid()
            ],200);
        }

        return response()->json([
                'status' => false,
                'msg' => "Invalid Id or Password",
                'data' => [],
                'token' => ""
            ],401);
    }

    public function AddUserExcel(Request $request){
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            Employee::create([
                'zone' => $item['zone'],
                'state' => $item['state'],
                'division' => $item['division'],
                'TerrCode' => $item['TerrCode'],
                'TerrName' => $item['TerrName'],
                'EMPCODE' => $item['EMPCODE'],
                'POSCODE' => $item['POSCODE'],
                'STATUS' => $item['STATUS'],
                'EMPNAME' => $item['EMPNAME'],
                'DOJ' => $item['DOJ'],
                'BIRTHDATE' => $item['BIRTHDATE'],
                'DESIGNATION' => $item['DESIGNATION'],
                'DesignMIS' => $item['DesignMIS'],
                'HEADQ' => $item['HEADQ'],
                'EmailJbpharma' => $item['EmailJbpharma'],
                'EMAILIDPERSONAL' => $item['EMAILIDPERSONAL'],
                'MOBILENO' => $item['MOBILENO'],
                'AMTerrCode' => $item['AMTerrCode'],
                'AMEmpCode' => $item['AMEmpCode'],
                'AMName' => $item['AMName'],
                'AMHQ' => $item['AMHQ'],
                'AMEmail' => $item['AMEmail'],
                'RMTerrCode' => $item['RMTerrCode'],
                'RMEmpCode' => $item['RMEmpCode'],
                'RMName' => $item['RMName'],
                'RMHQ' => $item['RMHQ'],
                'RMEmailID' => $item['RMEmailID'],
                'DSMTerrCode' => $item['DSMTerrCode'],
                'DSMEmpCode' => $item['DSMEmpCode'],
                'DSMName' => $item['DSMName'],
                'DSMHQ' => $item['DSMHQ'],
                'DSMEmail' => $item['DSMEmail'],
                'SMTerrCode' => $item['SMTerrCode'],
                'SMEmpCode' => $item['SMEmpCode'],
                'SMName' => $item['SMName'],
                'SMHQ' => $item['SMHQ'],
                'SMEmail' => $item['SMEmail'],
            ]);

            try {
                $user = User::create([
                    'name' => $item['EMPNAME'],
                    'email' => $item['EMAILIDPERSONAL'],
                    'password' => $item['EMPCODE'],
                    'phone' => $item['MOBILENO'],
                    'role' => 2,
                    'empId' => $item['EMPCODE'],
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                continue;
            }
        }

        return response()->json([
            'status' => true,
            'msg' => "Data imported successfully",
            'data' => [],
            'token' => ""
        ],200);
    }
}
