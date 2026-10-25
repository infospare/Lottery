<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\LotteryDrawController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads');
Route::get('/downloads/{id}/file/{type?}', [DownloadController::class, 'downloadFile'])
    ->whereIn('type', ['exe', 'zip'])
    ->name('downloads.file');
Route::get('/downloads/{id}/count', [DownloadController::class, 'getDownloadCount'])->name('downloads.count');
Route::post('/downloads/{id}/increment', [DownloadController::class, 'incrementDownload'])->name('downloads.increment');
Route::post('/downloads/{id}/rate', [DownloadController::class, 'submitRating'])->name('downloads.rate');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/downloads/user-guide/track', [DownloadController::class, 'incrementUserGuideDownload'])->name('downloads.user-guide.track');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lottery/results', [LotteryDrawController::class, 'index'])->name('lottery.results');
Route::get('/lottery/results/list', [LotteryDrawController::class, 'list'])->name('lottery.results.list');
Route::get('/lottery/results/version', [LotteryDrawController::class, 'version'])->name('lottery.results.version');

Route::middleware('auth')->group(function () {
    Route::get('/lottery/results/manage', [LotteryDrawController::class, 'manage'])->name('lottery.results.manage');
    Route::post('/lottery/results/upload', [LotteryDrawController::class, 'upload'])->name('lottery.results.upload');
    Route::post('/lottery/results/{id}/delete', [LotteryDrawController::class, 'destroy'])->name('lottery.results.destroy');

    Route::get('/lottery/lotteries', [LotteryController::class, 'index'])->name('lottery.lotteries.index');
    Route::post('/lottery/lotteries', [LotteryController::class, 'store'])->name('lottery.lotteries.store');
    Route::put('/lottery/lotteries/{id}', [LotteryController::class, 'update'])->name('lottery.lotteries.update');
    Route::delete('/lottery/lotteries/{id}', [LotteryController::class, 'destroy'])->name('lottery.lotteries.destroy');

    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('/subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
    Route::post('/subscribers', [SubscriberController::class, 'store'])->name('subscribers.store');
    Route::put('/subscribers/{id}', [SubscriberController::class, 'update'])->name('subscribers.update');
    Route::delete('/subscribers/{id}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

    Route::get('/account', [AuthController::class, 'showAccount'])->name('account');
    Route::post('/account', [AuthController::class, 'updateAccount'])->name('account.update');
    Route::post('/account/users', [AuthController::class, 'createUser'])->name('account.users.create');
    Route::post('/account/users/{id}/delete', [AuthController::class, 'deleteUser'])->name('account.users.delete');
});

Route::get('/lottery/results/{id}/download', [LotteryDrawController::class, 'download'])->name('lottery.results.download');
Route::get('/lottery/results/{id}/api', [LotteryDrawController::class, 'showApi'])->name('lottery.results.show.api');
Route::get('/lottery/results/{id}', [LotteryDrawController::class, 'show'])->name('lottery.results.show');
