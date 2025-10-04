
<?php
// AJAX endpoint for admin password validation
Route::post('/admin/validate-password', [\App\Http\Controllers\AdminController::class, 'validatePassword'])->middleware('auth')->name('admin.validatePassword');

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;
use App\Models\Trader;
use App\Http\Controllers\StockController;

Route::post('/stocks/update-price', [StockController::class, 'updatePrice'])->name('stocks.updatePrice')->middleware('auth');


Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && $user->role === 'Admin') {
        $brokers = User::all();
        return view('admin.dashboard', compact('brokers'));
    } else {
        $traders = Trader::where('broker_email', $user->email)->get();
        return view('traders.index', compact('traders'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';

Route::resource('traders', TraderController::class)->middleware('auth');
// Admin dashboard routes
Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->middleware('auth')->name('admin.dashboard');

Route::patch('/admin/brokers/{id}/role', [\App\Http\Controllers\AdminController::class, 'updateRole'])->middleware('auth')->name('admin.brokers.updateRole');
Route::delete('/admin/brokers/{id}', [\App\Http\Controllers\AdminController::class, 'destroy'])->middleware('auth')->name('admin.brokers.destroy');
