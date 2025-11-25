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

Route::get('categories', [CategoryController::class, 'index'])->name('categories');
Route::get('assets', [AssetController::class, 'index'])->name('assets');
Route::get('manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers');
Route::get('locations', [LocationController::class, 'index'])->name('locations');
require __DIR__.'/settings.php';
