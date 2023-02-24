<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepositoryController;
use Illuminate\Support\Facades\Route;

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

Route::get('login/github', 'App\Http\Controllers\Auth\LoginController@redirectToGithub');
Route::get('login/github/callback', 'App\Http\Controllers\Auth\LoginController@handleGithubCallback');

Route::post('/payload', 'App\Http\Controllers\WebhookController@payload');
Route::get('/payload', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('repository', RepositoryController::class);

    Route::post('repository/{repository}/adduser', [RepositoryController::class, 'addUser'])->name('repository.adduser');
});

require __DIR__.'/auth.php';
