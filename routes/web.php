<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\IssueController;

Route::resource('issue', IssueController::class);
Route::get('login/github', 'App\Http\Controllers\Auth\LoginController@redirectToGithub');
Route::get('login/github/callback', 'App\Http\Controllers\Auth\LoginController@handleGithubCallback');

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
});

require __DIR__ . '/auth.php';