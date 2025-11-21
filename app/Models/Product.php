<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $qty
 * @property bool $active
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Product extends Model
{
    protected $table = 'products';

    protected $casts = [
        'price' => 'float',
        'qty' => 'int',
        'active' => 'bool'
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'qty',
        'active'
    ];

    /**
     * Restituisce l'URL dell'immagine del prodotto, se presente, altrimenti null
     *
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        $disk = \Illuminate\Support\Facades\Storage::disk('products');

        if ($disk->exists("{$this->id}.jpg")) {
            return $disk->url("{$this->id}.jpg?{$disk->lastModified("{$this->id}.jpg")}");
        } else if ($disk->exists("{$this->id}.png")) {
            return $disk->url("{$this->id}.png?{$disk->lastModified("{$this->id}.png")}");
        } else if ($disk->exists("{$this->id}.webp")) {
            return $disk->url("{$this->id}.webp?{$disk->lastModified("{$this->id}.webp")}");
        }

        return null;
    }

    /**
     * Restituisce l'URL dell'immagine del prodotto o un placeholder se non presente
     *
     * @param int $width La larghezza del placeholder
     * @param int $height L'altezza del placeholder
     * @param string $text Il testo da mostrare nel placeholder
     *
     * @return string URL dell'immagine del prodotto o URL del placeholder
     */
    public function getImageUrlOrPlaceholder(
        int    $width = 600,
        int    $height = 400,
        string $text = 'Immagine non caricata'
    ): string
    {
        return $this->getImageUrl() ?? "https://placehold.co/{$width}x{$height}?text=" . urlencode($text);
    }

    /**
     * Verifica se il prodotto ha un'immagine caricata
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return !is_null($this->getImageUrl());
    }

    /**
     * Visualizza il prezzo del prodotto con il formato localizzato
     *
     * @param string $locale
     * @return false|string
     */
    public function priceVerbose(string $locale = 'it_IT'): false|string
    {
        $formatter = \NumberFormatter::create($locale, \NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($this->price, 'EUR');
    }

    /**
     * Visualizza la data di aggiornamento del prodotto con il formato localizzato
     *
     * @param string $format Formato data in stile PHP date()
     * @return string
     */
    public function updateAtVerbose(string $format = 'd/m/Y H:i'): string
    {
        if (is_null($this->updated_at)) {
            return $this->created_at
                ->format($format);
        }

        return $this->updated_at
            ->format($format);
    }

    /**
     * Restituisce l'array del modello aggiungendo l'URL dell'immagine
     *
     * @return array
     */
    public function toArray(): array
    {
        $timezone = request()->header('timezone', 'UTC');

        $array = parent::toArray();

        $array['created_at'] = $this->created_at
            ->setTimezone($timezone)
            ->format('Y-m-d\TH:i:sP');

        $array['updated_at'] = $this->updated_at
            ?->setTimezone($timezone)
            ?->format('Y-m-d\TH:i:sP');

        $array['image_url'] = $this->getImageUrl();

        ksort($array);

        return $array;
    }
}
