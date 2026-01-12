<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ItineraryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('trips.index');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | Trips (旅行計画 CRUD)
    */
    Route::prefix('trips')->group(function () {

        // 一覧表示（READ）
        Route::get('/', [TripController::class, 'index'])->name('trips.index');

        // 新規作成画面（CREATE）
        Route::get('/create', [TripController::class, 'create'])->name('trips.create');

        // 新規保存（CREATE）
        Route::post('/', [TripController::class, 'store'])->name('trips.store');

        // 詳細表示（READ）
        Route::get('/{trip}', [TripController::class, 'show'])->name('trips.show');

        // 編集画面（UPDATE）
        Route::get('/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');

        // 更新処理（UPDATE）
        Route::put('/{trip}', [TripController::class, 'update'])->name('trips.update');

        // 削除（DELETE）
        Route::delete('/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');

        // PDF
        Route::get('/trips/{trip}/export-pdf', [TripController::class, 'exportPdf'])->name('trips.pdf');

        /*
        | Itineraries (旅程 CRUD)
        */
        Route::prefix('/{trip}/itineraries')->group(function () {

            // 新規作成画面
            Route::get('/create', [ItineraryController::class, 'create'])->name('itineraries.create');

            // 新規保存
            Route::post('/', [ItineraryController::class, 'store'])->name('itineraries.store');

            // 編集画面
            Route::get('/{itinerary}/edit', [ItineraryController::class, 'edit'])->name('itineraries.edit');

            // 更新処理（PUT/PATCH両対応）
            Route::match(['put', 'patch'], '/{itinerary}', [ItineraryController::class, 'update'])->name('itineraries.update');

            // 削除
            Route::delete('/{itinerary}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');

        });

    });

    /*
    | Itineraries 並び替え
    */
    Route::post('/itineraries/update-order', [ItineraryController::class, 'updateOrder'])
        ->name('itineraries.updateOrder');
    
});

require __DIR__.'/auth.php';
