<?php

use App\Http\Livewire\ApplyCard;
use App\Http\Livewire\Companies;
use App\Http\Livewire\LeaveCard;
use App\Http\Livewire\UsersList;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Departments;
use App\Http\Livewire\LeaveStatus;
use App\Http\Livewire\UpdateLeave;
use App\Http\Livewire\ApprovalPage;
use App\Http\Livewire\LeavePayment;
use App\Http\Livewire\LeaveApproval;
use App\Http\Livewire\PublicHoliday;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\AllLeaveSummary;
use App\Http\Livewire\OpenLeaveStatus;
use App\Http\Livewire\SearchResult;
use App\Http\Livewire\StaffLeaveSummary;

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
    Route::get('/leave-approval', LeaveApproval::class)->name('leave-approval'); 
    Route::get('/approval-page/{model}', ApprovalPage::class)->name('approval-page');
    Route::get('/approved-leave', LeaveStatus::class)->name('approved-leave');
    Route::get('/leave-allowance', LeavePayment::class)->name('leave-allowance');
    Route::get('/leave-summary', AllLeaveSummary::class)->name('leave-summary');
    Route::get('/staff-leave-summary', StaffLeaveSummary::class)->name('staff-leave-summary');
    Route::get('/open-leave-status', OpenLeaveStatus::class)->name('open-leave-status');
});

