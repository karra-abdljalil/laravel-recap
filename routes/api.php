<?php

use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get("/posts", function () {

    // return all the users with their posts

    $usersData = User::with('post')->get();
    return response()->json([
        'message' => 'Welcome to the API',
        'users' => $usersData
    ]);
});


Route::put("/post/update", [PostController::class, 'update']);
Route::post("/post/create", [PostController::class, 'create']);