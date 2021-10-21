<?php

use App\Http\Livewire\ApplyCard;
use App\Http\Livewire\Companies;
use App\Http\Livewire\LeaveCard;
use App\Http\Livewire\UsersList;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Departments;
use App\Http\Livewire\PublicHoliday;
use App\Http\Livewire\UpdateLeave;
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
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware' => [ 'auth:sanctum', 'verified']], function () {

    Route::get('/dashboard', function(){
        return view('dashboard');
    })->name('dashboard');

    Route::get('/home', function(){
        return view('admin.department');
    })->name('home');

    Route::get('/department', Departments::class)->name('department');
    Route::get('/category', Categories::class)->name('category');
    Route::get('/publicholiday', PublicHoliday::class)->name('publicholiday');
    Route::get('/companies', Companies::class)->name('companies');
    Route::get('/users', UsersList::class)->name('users');
    Route::get('/leave', LeaveCard::class)->name('leave');
    Route::get('/apply-leave', ApplyCard::class)->name('apply-leave');
    Route::get('/update-leave/{model}', UpdateLeave::class)->name('update-leave');



});

