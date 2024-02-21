<?php

use App\Http\Controllers\Api\AtendeeController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('events', EventController::class);
// attendees don't function on standalone basis, scoped route required to only get attendees of current event
Route::apiResource('events.atendees', AtendeeController::class)->scoped(['atendee' => 'event']);