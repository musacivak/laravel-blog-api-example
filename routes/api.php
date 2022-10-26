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

//AUTH
Route::post('/auth/signin', [\App\Http\Controllers\AuthController::class, "signin"])->name('signin');
Route::get('/auth/create', [\App\Http\Controllers\AuthController::class, "index"])->name('userCreate');


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    //POST
    Route::get('/post/', [\App\Http\Controllers\PostController::class, 'index'])->name('postList');
    Route::post('/post/create', [\App\Http\Controllers\PostController::class, 'store'])->name('postCreate');
    Route::post('/post/update', [\App\Http\Controllers\PostController::class, 'update'])->name('postUpdate');
    Route::get('/post/get/{id}', [\App\Http\Controllers\PostController::class, 'show'])->name('postGet');
    Route::delete('/post/destroy/{id}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('postDestroy');

    //COMMENT
    Route::get('/comment/', [\App\Http\Controllers\CommentController::class, 'index'])->name('commentList');
    Route::post('/comment/create', [\App\Http\Controllers\CommentController::class, 'store'])->name('commentCreate');
    Route::post('/comment/update', [\App\Http\Controllers\CommentController::class, 'update'])->name('commentUpdate');
    Route::get('/comment/get/{id', [\App\Http\Controllers\CommentController::class, 'show'])->name('commentGet');
    Route::delete('/comment/destroy/{id', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('commentDestroy');
});
