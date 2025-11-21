<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\DefaultController::class)
    ->group(function () {
        /**
         * Questa route è per visualizzare l'elenco dei prodotti
         */
        Route::get('/', 'index');

        /**
         * Questa route è per visualizzare la pagina di creazione di un nuovo prodotto
         */
        Route::get('/create', 'single');

        /**
         * Questa route è per salvare il nuovo prodotto
         */
        Route::post('/create', 'save');

        /**
         * Questa route è per modificare un prodotto
         */
        Route::get('/{product}', 'single')
            ->whereNumber('product');

        /**
         * Questa route è per salvare le modifiche apportate al prodotto
         */
        Route::post('/{product}', 'update')
            ->whereNumber('product');

        /**
         * Questa route è per cancellazioni multiple di prodotti
         */
        Route::post('/delete', 'delete');

        /**
         * Questa route è per cancellare un prodotto
         */
        Route::get('/{product}/delete', 'delete')
            ->whereNumber('product');

        /**
         * Questa route è per cancellare l'immagine di un prodotto
         */
        Route::get('/{product}/delete-image', 'deleteImage')
            ->whereNumber('product');

        /**
         * Questa route è per attivare/disattivare un prodotto
         */
        Route::get('/{product}/toggle-activation', 'toggleActivation')
            ->whereNumber('product');
    });
