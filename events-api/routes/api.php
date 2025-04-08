<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;

Route::get('/events', [EventController::class, 'index']);     
Route::post('/events', [EventController::class, 'store']);       
Route::get('/events/{id}', [EventController::class, 'show']);  
Route::put('/events/{id}', [EventController::class, 'update']); 
Route::delete('/events/{id}', [EventController::class, 'destroy']); 
Route::post('/events/{id}/register', [EventRegistrationController::class, 'register']);
Route::get('/user/events', [EventRegistrationController::class, 'userEvents']);
Route::delete('/events/{id}/cancel', [EventRegistrationController::class, 'cancel']);


