<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('jobs', JobPostController::class);

    Route::apiResource('job/applications', JobApplicationController::class)->except('show', 'update', 'destroy');

    Route::post('/job/apply', [JobApplicationController::class, 'store']);

    Route::get('/job/applied', [JobApplicationController::class, 'appliedJobs']);

    Route::get('/job/applicants', [JobApplicationController::class, 'jobApplicants']);

});

