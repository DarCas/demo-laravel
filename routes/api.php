<?php

use Illuminate\Support\Facades\Route;

/**
 * Questa route è per visualizzare l'elenco dei prodotti
 */
Route::get('/', [
    App\Http\Controllers\Api\DefaultController::class,
    'index'
]);

/**
 * Questa route è per visualizzare un singolo prodotto
 */
Route::get('/{product}', [
    App\Http\Controllers\Api\DefaultController::class,
    'single'
])->whereNumber('product');

/**
 * Questa route è per creare un nuovo prodotto
 */
Route::post('/', [
    App\Http\Controllers\Api\DefaultController::class,
    'create'
]);

/**
 * Queste route è per modificare un prodotto
 */
Route::put('/{product}', [
    App\Http\Controllers\Api\DefaultController::class,
    'update'
])->whereNumber('product');

/**
 * Questa route è per attivare/disattivare un prodotto
 */
Route::patch('/{product}', [
    App\Http\Controllers\Api\DefaultController::class,
    'toggleActivation'
])->whereNumber('product');

/**
 * Questa route è per cancellazioni uno o più prodotti
 */
Route::delete('/{product}', [
    App\Http\Controllers\Api\DefaultController::class,
    'delete'
])->whereNumber('product');

/**
 * Questa route è per cancellare l'immagine di un prodotto
 */
Route::delete('/{product}/image', [
    App\Http\Controllers\Api\DefaultController::class,
    'deleteImage'
])->whereNumber('product');
