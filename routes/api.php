<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::middleware('auth:sanctum')->group(function (){
         //profile
         Route::get('/profile',[\App\Http\Controllers\Api\ProfileApiController::class,'index']);
        //credits
         Route::get('/credits',[\App\Http\Controllers\Api\ProfileApiController::class,'credits']);


    //contacts
         Route::get('/contacts',[\App\Http\Controllers\Api\ContactsApiController::class,'index']);
         Route::post('/contacts',[\App\Http\Controllers\Api\ContactsApiController::class,'store']);
         Route::get('/contacts/{id}',[\App\Http\Controllers\Api\ContactsApiController::class,'show']);
         Route::put('/contacts/{id}',[\App\Http\Controllers\Api\ContactsApiController::class,'update']);
         Route::delete('/contacts/{id}',[\App\Http\Controllers\Api\ContactsApiController::class,'destroy']);
    //groups

        Route::get('/groups',[\App\Http\Controllers\Api\GroupApiController::class,'index']);
        Route::post('/group',[\App\Http\Controllers\Api\GroupApiController::class,'store']);
        Route::delete('/group/{id}',[\App\Http\Controllers\Api\GroupApiController::class,'destroy']);


   //group contacts

        Route::post('/group-contact/{groupId}',[\App\Http\Controllers\Api\GroupApiController::class,'moveContactToGroup']);
        Route::delete('/group-contact/{groupId}',[\App\Http\Controllers\Api\GroupApiController::class,'removeContactFromGroup']);

    //Departments
        Route::get('/departments',[\App\Http\Controllers\Api\DepartmentApiController::class,'index']);
        Route::post('/departments/{id}',[\App\Http\Controllers\Api\DepartmentApiController::class,'changeDepartment']);

    //Campaigns
        Route::get('/campaigns',[\App\Http\Controllers\Api\CampaignApiController::class,'index']);
        Route::get('/campaigns/{id}',[\App\Http\Controllers\Api\CampaignApiController::class,'show']);

        Route::post('/campaign',[\App\Http\Controllers\Api\CampaignApiController::class,'singleMessage']);
        Route::post('/campaign/bulk',[\App\Http\Controllers\Api\CampaignApiController::class,'scheduleMessage']);
        Route::delete('/campaign/{id}',[\App\Http\Controllers\Api\CampaignApiController::class,'removeCampaign']);



});
