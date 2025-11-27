    <?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:super_admin'])->group(function () {
    Route::post('categories', [CategoryController::class,'list'])->name('categories.list');
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
});

Route::middleware(['auth', 'verified', 'role:super_admin,inventory_manager'])->group(function () {
    
});

Route::middleware(['auth', 'verified', 'role:super_admin,inventory_user'])->group(function () {
    
});


Route::resource('manufacturers', ManufacturerController::class)->except(['create', 'edit']);
Route::resource('locations', LocationController::class)->except(['create', 'edit']);
Route::resource('assets', AssetController::class)->except(['create', 'edit']);




require __DIR__.'/settings.php';
