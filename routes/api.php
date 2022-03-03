<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordApiController;
use App\Http\Controllers\Api\Auth\ResetPasswordApiController;
use App\Http\Controllers\Api\Auth\VerificationApiController;
use App\Http\Controllers\Api\ReviewsApiController;
use App\Http\Controllers\Api\RecipeApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CommentApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('email/verify/{id}/{hash}', [VerificationApiController::class, 'verify'])->name('verificationapi.verify');
Route::post('email/resend', [VerificationApiController::class, 'resend'])->name('verificationapi.resend');

Route::post('password/reset', [ResetPasswordApiController::class, 'reset']);
Route::post('password/email', [ForgotPasswordApiController::class, 'sendResetLinkEmail'])->name('password.email');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::prefix('cooks')->name('cooks')->group(function() {
    Route::get('', [UserApiController::class, 'index']);
    Route::get('{id}', [UserApiController::class, 'show']);
    Route::get('{id}/profile', [UserApiController::class, 'profile'])->middleware('api');
    Route::get('{id}/recipes', [UserApiController::class, 'recipes']);
    Route::patch('edit-profile', [UserApiController::class, 'updateUser'])->middleware('api');
});

Route::prefix('recipes')->name('recipes')->group(function() {
    Route::get('', [RecipeApiController::class, 'index']);
    Route::get('{id}', [RecipeApiController::class, 'show']);
    Route::get('{id}/reviews', [RecipeApiController::class, 'reviews']);
    Route::patch('{id}/update', [RecipeApiController::class, 'update'])->middleware('api');
    Route::post('store', [RecipeApiController::class, 'store'])->middleware('api');
});

Route::prefix('comments')->name('comments')->group(function() {
    Route::get('latest', [CommentApiController::class, 'latestComments']);
    Route::post('post', [CommentApiController::class, 'store'])->middleware('api');
});

Route::prefix('reviews')->name('ratings')->group(function() {
    Route::post('create', [ReviewsApiController::class, 'store'])->middleware('api');
    Route::patch('update', [ReviewsApiController::class, 'updateReview'])->middleware('api');
});

