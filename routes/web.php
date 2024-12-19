<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PaymentController;
use App\Livewire\WebhookHandler;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/start', [ChatController::class, 'start'])->name('chat.start');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/messages/{chat}', [ChatController::class, 'messages'])->name('chat.messages');
});

//Route::get('/', [ProfessionalController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);

Route::get('/create-payment', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/webhooks/mollie', [PaymentController::class, 'handleWebhook'])->name('webhooks.mollie');

Route::get('/', [LoginController::class, 'index']);
Route::post('/send-magic-link', [LoginController::class, 'sendMagicLink'])->name('send.magic.link');
Route::get('/login/{token}', [LoginController::class, 'loginWithMagicLink'])->name('login.magic.link');
Route::get('/magic-link-sent', function () {
    return view('auth.magic-link-sent');
})->name('magic.link.sent');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/send-message', [ChatController::class, 'sendMessage'])->middleware('auth');

require __DIR__.'/auth.php';
