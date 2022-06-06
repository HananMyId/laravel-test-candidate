<?php

use App\Http\Livewire\Candidates;
use App\Http\Livewire\ChangePassword;
use App\Http\Livewire\ManageUsers;
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

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('users', ManageUsers::class)->middleware(['auth', 'admin'])->name('users');
Route::get('candidates', Candidates::class)->middleware(['auth'])->name('candidates');
