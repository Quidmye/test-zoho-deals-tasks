<?php
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ZohoController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\ContactController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix'=>'zoho','middleware' => ['web', 'auth']], function () {
    Route::group(['prefix'=>'tasks'], function () {
        Route::get('create', [TaskController::class, 'create'])->name('task.create');
        Route::post('create', [TaskController::class, 'createPost'])->name('task.post.create');
    });
    Route::group(['prefix'=>'deals'], function () {
        Route::get('create', [DealsController::class, 'create'])->name('deal.create');
        Route::post('create', [DealsController::class, 'createPost'])->name('deal.post.create');
    });
});

// Add contact in ZOHO
Route::get('zohocrmauth', [ZohoController::class, 'auth'])->name('zohocrmauth');
Route::get('zohocrm', [ZohoController::class, 'store'])->name('zohocrm');
require __DIR__.'/auth.php';
