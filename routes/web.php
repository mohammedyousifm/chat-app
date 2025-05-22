<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Message page
Route::middleware('auth')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('chat');
    Route::get('/chat/{id}', [MessageController::class, 'chatWith'])->name('chat.with');
    Route::post('/send/message', [MessageController::class, 'store'])->name('message.store');

    Route::get('/notification/clear', function () {
        auth()->user()->notifications()->delete();
    })->name('notification.clear');
});


Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/my-profile', [ProfileController::class, 'profilePicture'])->name('profile.picture');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
