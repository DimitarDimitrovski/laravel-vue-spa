<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\RecipesSPAController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UsersController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('admin')->name('admin')->middleware(['web', 'auth'])->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('.dashboard');

    Route::prefix('users')->name('.users')->group(function () {
        Route::get('', [UsersController::class, 'index'])->name('.index');
        Route::get('{id}', [UsersController::class, 'show'])->name('.show');
        Route::delete('{id}', [UsersController::class, 'destroy'])->name('.destroy');
    });

    Route::prefix('recipes')->name('.recipes')->group(function () {
        Route::get('', [RecipesController::class, 'index'])->name('.index');
        Route::get('{id}', [RecipesController::class, 'show'])->name('.show');
        Route::delete('{id}', [RecipesController::class, 'destroy'])->name('.destroy');
        Route::patch('{id}/approval', [RecipesController::class, 'approval'])->name('.approval');
    });

    Route::prefix('comments')->name('.comments')->group(function () {
        Route::get('', [CommentsController::class, 'index'])->name('.index');
        Route::get('{id}', [CommentsController::class, 'show'])->name('.show');
        Route::delete('{id}', [CommentsController::class, 'destroy'])->name('.destroy');
        Route::patch('{id}/approval', [CommentsController::class, 'approval'])->name('.approval');
    });

    Route::prefix('reviews')->name('.reviews')->group(function () {
        Route::get('', [ReviewsController::class, 'index'])->name('.index');
        Route::get('{id}', [ReviewsController::class, 'show'])->name('.show');
        Route::delete('{id}', [ReviewsController::class, 'destroy'])->name('.destroy');
        Route::patch('{id}/approval', [ReviewsController::class, 'approval'])->name('.approval');
    });
});

Auth::routes(['verify' => true]);

Route::get('/login', function () {
    return redirect()->route('admin.login.index');
});

Route::get('/logout', function () {
    return redirect()->route('admin.logout');
});

Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login.index');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::get('/admin/logout',  [LoginController::class, 'logout'])->name('admin.logout');

Route::get('/{any}', [RecipesSPAController::class, 'index'])->where('any', '[\/\w\.-]*');
