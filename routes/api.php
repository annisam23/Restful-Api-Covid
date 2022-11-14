<?php

use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//get all resource
Route::get('/patients', [PatientController::class, 'index']);

//add resource
Route::post('/patients', [PatientController::class, 'store']);

//edit resource
Route::put('/patients/{id}', [PatientController::class, 'update']);

//delete resource
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

//search resource by name
Route::get('/patients/search/{name}', [PatientController::class, 'search']);

//get positive resource
Route::get('/patients/status/positive', [PatientController::class, 'positive']);

//get negative resource
Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);

//get dead resource
Route::get('/patients/status/dead', [PatientController::class, 'dead']);

//get detail resource
Route::get('/patients/{id}', [PatientController::class, 'show']);
