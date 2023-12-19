<?php

use App\Http\Controllers\ConnectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('userConnection')->middleware('auth')->group(function () {
    Route::get('get_suggestions', [ConnectionController::class, 'suggestions'])->name('suggestions');
    Route::post('connect', [ConnectionController::class, 'connect'])->name('connect');
    Route::get('sent_requests', [ConnectionController::class, 'sent_requests'])->name('sent_requests');
    Route::post('withdraw_request', [ConnectionController::class, 'withdraw_request'])->name('withdraw_request');
    Route::get('received_requests', [ConnectionController::class, 'received_requests'])->name('received_requests');
    Route::post("accept_request", [ConnectionController::class, "accept_request"])->name("accept_request");
    Route::get('connections', [ConnectionController::class, 'connections'])->name('connections');
    Route::post('remove_connection', [ConnectionController::class, 'remove_connection'])->name('remove_connection');
});
