<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return redirect('/members');
})->name('dashboard');
    
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::group(['prefix' => 'members', 'as'=>'members'], function(){
        Route::get('', [\App\Http\Controllers\MemberController::class, 'index'])->name('.index');
        Route::get('/generate-new-members', [\App\Http\Controllers\MemberController::class, 'generateNewMembers'])->name('.generate-new-members');
        Route::get('/clear-members', [\App\Http\Controllers\MemberController::class, 'clearMembers'])->name('.clear-members');
        Route::get('/dump-members', [\App\Http\Controllers\MemberController::class, 'dumpMembers'])->name('.dump-members');
    });
});
