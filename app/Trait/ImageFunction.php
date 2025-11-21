<?php

namespace App\Trait;

use Illuminate\Http\UploadedFile;

trait ImageFunction
{
    /**
     * Salva l'immagine del prodotto su disco
     *
     * @param UploadedFile|null $img
     * @param int $id
     * @return void
     */
    private function mkImage(?UploadedFile $img, int $id): void
    {
        if (!is_null($img)) {
            /**
             * Mi collego al disco virtuale "products" che ho configurato in config/filesystems.php
             */
            $disk = \Illuminate\Support\Facades\Storage::disk('products');

            $extension = $img->getClientOriginalExtension();

            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            /**
             * Copio il file caricato nel disco virtuale impostando come nome del file l'ID del prodotto
             */
            $img->move($disk->path('/'), "{$id}.{$extension}");
        }
    }

    /**
     * Rimuove l'immagine del prodotto dal disco
     *
     * @param int $id
     * @return void
     */
    private function rmImage(int $id): void
    {
        $disk = \Illuminate\Support\Facades\Storage::disk('products');

        if ($disk->exists("{$id}.jpg")) {
            $disk->delete("{$id}.jpg");
        } elseif ($disk->exists("{$id}.png")) {
            $disk->delete("{$id}.png");
        } elseif ($disk->exists("{$id}.webp")) {
            $disk->delete("{$id}.webp");
        }
    }
}
