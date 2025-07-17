<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\MachineryController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeedController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () { return view('welcome'); });

Route::get('/',[AuthenticatedSessionController::class,'create']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/select-farm', function (\Illuminate\Http\Request $request) {
    session(['selected_farm_id' => $request->farm_id]);
    return redirect()->back();
})->middleware('auth')->name('select.farm');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/plot', [PlotController::class,'index'])->name('plot.index');
    Route::get('/plot/register', [PlotController::class,'create'])->name('plot.register');
    Route::post('/plot/register', [PlotController::class,'store'])->name('plot.register');
    Route::get('/editar', [PlotController::class,'edit'])->name('editar');
    Route::put('/plot/{plot}', [PlotController::class, 'update'])->name('plot.update');
    Route::delete('/plot/{plot}', [PlotController::class,'delete'])->name('plot.delete');
    Route::get('/crops',[CropController::class,'create'])->name('crop.index');
    Route::post('/crops',[CropController::class,'store'])->name('crop.register');
    Route::put('/crops/{crop}',[CropController::class,'update'])->name('crop.update');
    Route::delete('/crops/{crop}',[CropController::class,'delete'])->name('crop.delete');
    Route::get('/supply', [SupplyController::class,'index'])->name('supply.index');
    Route::post('supply/register',[SupplyController::class,'store'])->name('supply.register');
    Route::delete('/supply/{supply}',[SupplyController::class,'delete'])->name('supply.delete');
    Route::put('/supply/{supply}',[SupplyController::class,'update'])->name('supply.update');
    Route::get('/seed',[SeedController::class,'create'])->name('seed.create');
    Route::post('/seed/register',[SeedController::class,'store'])->name('seed.register');
    Route::put('/seed/{seed}',[SeedController::class,'update'])->name('seed.update');
    Route::delete('/seed/{seed}',[SeedController::class,'delete'])->name('seed.delete');
    Route::get('/farm', [FarmController::class,'index'])->name('farm.index');
    Route::post('farm/register',[FarmController::class,'store'])->name('farm.register');
    Route::put('/farm/{farm}',[FarmController::class,'update'])->name('farm.update');
    Route::delete('/farm/{farm}',[FarmController::class,'delete'])->name('farm.delete');
    Route::get('/machinery',[MachineryController::class,'index'])->name('machinery.index');
    Route::post('/machinery/register',[MachineryController::class,'store'])->name('machinery.register');
    Route::delete('/machinery/{machinery}',[MachineryController::class,'delete'])->name('machinery.delete');
    Route::put('/machinery/{machinery}',[MachineryController::class,'update'])->name('machinery.update');
    Route::get('user/',[UserController::class,'create'])->name('user.create');
    Route::post('/user/register',[UserController::class,'store'])->name('user.register');
    Route::put('/user/{user}',[UserController::class,'update'])->name('user.update');
    Route::delete('/user/{user}',[UserController::class,'delete'])->name('user.delete');
    Route::get('/user/find/',[UserController::class,'findByName'])->name('user.find');
    Route::get('/activity',[ActivityController::class,'create'])->name('activity.create');
    Route::post('/activity/register',[ActivityController::class,'store'])->name('activity.register');
    Route::put('/activity/{activity}',[ActivityController::class,'update'])->name('activity.update');
    Route::delete('/activity/{activity}',[ActivityController::class,'delete'])->name('activity.delete');
    Route::get('/activity/{activity}/json', [ActivityController::class, 'json']);
    Route::get('/activitySupply/{type}/json', [ActivityController::class, 'getInsumosPorTipo'])->name('activity.insumos');
    Route::get('/activity/find',[ActivityController::class,'findByName'])->name('activity.find');
    Route::get('/crop/report/{cropId}',[CropController::class,'getReport'])->name('crop.report');
});

require __DIR__.'/auth.php';
