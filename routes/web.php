<?php

use App\Http\Controllers\PartieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PartieController::class, 'index'])->name('parties.index');
Route::post('/parties', [PartieController::class, 'store'])->name('parties.store');
Route::get('/parties/{partie}', [PartieController::class, 'show'])->name('parties.show');
Route::post('/parties/{partie}/coups', [PartieController::class, 'jouer'])->name('parties.jouer');
Route::delete('/parties/{partie}/coups/dernier', [PartieController::class, 'annuler'])->name('parties.annuler');
Route::post('/parties/{partie}/coups/suivant', [PartieController::class, 'avancer'])->name('parties.avancer');
Route::delete('/parties/{partie}', [PartieController::class, 'destroy'])->name('parties.destroy');

Route::delete('/parties/{partie}/coups/{coup}', [PartieController::class, 'supprimerCoup'])
    ->whereNumber('coup')->name('parties.supprimerCoup');
