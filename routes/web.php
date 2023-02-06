<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MyController;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');

Route::group(['prefix' => '/blog', 'as' => 'blog.'], function () {

    Route::get('/', function () {
        dd('blog.index.page');
    })->name('index');


    Route::get('/{blog}', function () {
        dd('blog.index.page');
    })->name('show');


});

Route::apiResource('product', MyController::class);

Route::get('/', function () {

    $permission = Permission::query()->get();
    $roles = \App\Models\Role::query()->get();
    return collect([$permission , $roles]);

    return view('welcome');
});
