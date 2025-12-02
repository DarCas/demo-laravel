<?php

namespace App\Http\Controllers;

class BackupsController extends Controller
{
    public function index()
    {
        $disk = \Storage::disk('local');

        if (!$disk->exists('/products')) {
            $disk->makeDirectory('/products');
        }

        $files = $disk->files('/products');

        for ($i = 0, $ii = count($files); $i !== $ii; ++$i) {
            $file = $files[$i];

            $files[$i] = [
                'date' => date('d/m/Y H:i:s', filemtime($disk->path($file))),
                'name' => basename($file, '.json'),
                'size' => round($disk->size($file) / 1024, 2),
            ];
        }

        return view('backups')
            ->with('files', $files);
    }

    public function download(string $filename)
    {
        $disk = \Storage::disk('local');

        if ($disk->exists("/products/{$filename}.json")) {
            return response()
                ->download($disk->path("/products/{$filename}.json"));
        } else {
            abort(404);
        }
    }
}
