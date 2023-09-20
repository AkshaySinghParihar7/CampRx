<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampRxForm;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\SpecialityController;
use App\Http\Controllers\Api\ReportsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Camp Form API
Route::get('GetCampform', [CampRxForm::class, 'GetCampform']);
Route::get('GetCampformByEmpId/{empId}', [CampRxForm::class, 'GetCampformByEmpId']);
Route::get('GetFormById/{id}', [CampRxForm::class, 'GetFormById']);
Route::post('POBCropedImgUpload', [CampRxForm::class, 'POBImgUpload']);
Route::post('AddCampform', [CampRxForm::class, 'AddCampform']);
Route::post('UpdateCampform/{id}', [CampRxForm::class, 'UpdateCampform']);
Route::delete('DeleteCampform/{id}', [CampRxForm::class, 'DeleteCampform']);

//Users API
Route::post('login', [UsersController::class, 'isLogin']);
Route::get('GetUsers', [UsersController::class, 'GetUsers']);
Route::post('AddUser', [UsersController::class, 'AddUser']);
Route::get('GetUserById/{id}', [UsersController::class, 'GetUserById']);
Route::delete('DeleteUser/{id}', [UsersController::class, 'DeleteUser']);
Route::put('UpdateUser/{id}', [UsersController::class, 'UpdateUser']);
Route::get('ResetPassword/{id}', [UsersController::class, 'ResetPassword']);
Route::post('AddUserExcel', [UsersController::class, 'AddUserExcel']);

//Speciality API
Route::get('GetSpeciality', [SpecialityController::class, 'GetSpeciality']);
Route::get('GetActiveSpeciality', [SpecialityController::class, 'GetActiveSpeciality']);
Route::post('AddSpeciality', [SpecialityController::class, 'AddSpeciality']);
Route::delete('DeleteSpeciality/{id}', [SpecialityController::class, 'DeleteSpeciality']);
Route::get('ChangeStatus/{id}/{status}', [SpecialityController::class, 'StatusChange']);

// Report API
Route::get('GetReport', [ReportsController::class, 'GetReport']);
Route::get('downloadCampReport/{campType}', [ReportsController::class, 'downloadCampReport']);
Route::get('downloadFullReport', [ReportsController::class, 'downloadFullReport']);
