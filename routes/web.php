<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Doctrine\DBAL\Driver\Middleware;
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
Route::middleware('language')->group(function () {
    Route::get('/', function () {
        return redirect('/home');
    });
    require __DIR__.'/auth.php';

    Route::get('/home', [HomeController::class, 'redirect'])->middleware(['auth']);

    //Route::get('/admin-dashboard', [HomeController::class, 'task_list'])->middleware(['auth'])->name('admin-dashboard');
    Route::get('/create-task', [TaskController::class, 'index'])->name('new-task');

    Route::get('/dashboard', [HomeController::class, 'task_list'])->name('dashboard');

    // Route::get('/create-task', function() {
    //     // dd('create task complete');
    //     return view('user');
    // })->name('create-task');
    Route::post('/create-task', [TaskController::class, 'store'])->name('create-task');

    Route::get('/edit-task/{id}', [TaskController::class, 'edit'])->name('edit-task');

    Route::put('/update-task/{id}', [TaskController::class, 'update'])->name('update-task');

    Route::delete('/delete-task/{id}', [TaskController::class, 'destroy'])->name('delete-task');

    Route::get('test-email', [HomeController::class, 'sendMail']);
    Route::get('lang/{lang}', [HomeController::class, 'switchLang'])->name('lang.switch');

    //Toàn bộ các route khác đặt ở đây.
});
