@extends('template')

@section('title', $product ? 'Modifica prodotto' : 'Aggiungi prodotto')

@section('back', '/')

@section('content')

    <form action="/{{ $product?->id ?? 'create' }}"
          enctype="multipart/form-data"
          method="post">
        @csrf

        <x-alert :error="$errors->has('error')">
            {{ $errors->first('success') }}
            {{ $errors->first('error') }}
        </x-alert>

        <div class="row">
            <div class="col-4">
                <div class="row">
                    <div class="col-12">
                        <img src="{{ $product?->getImageUrlOrPlaceholder(800, 600) ?? 'https://placehold.co/800x600?text=Immagine+non+caricata' }}"
                             alt=""
                             class="img-fluid rounded"
                             style="aspect-ratio: 4/3; object-fit: cover">
                    </div>
                    <div class="col-12 pt-4">
                        @if ($product?->hasImage())
                            <div class="dropdown dropdown-menu-start">
                                <button
                                    class="btn btn-danger"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <i class="bi bi-trash"></i>

                                    Cancella immagine
                                </button>
                                <ul class="dropdown-menu bg-danger">
                                    <li>
                                        <a href="/{{ $product?->id }}/delete-image"
                                           class="btn text-white">
                                            Conferma cancella immagine
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <input type="file" class="form-control" name="img"
                                   accept="image/jpeg,image/png,image/webp">

                            <x-alert error inline>
                                {{ $errors->first('img') }}
                            </x-alert>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-12 pb-2">
                        <label for="formName">Nome *</label>
                        <input type="text" class="form-control"
                               id="formName" name="name"
                               value="{{ $product?->name ?? '' }}">

                        <x-alert error inline>
                            {{ $errors->first('name') }}
                        </x-alert>
                    </div>

                    <div class="col-12 pb-2">
                        <label for="formDescription">Descrizione *</label>
                        <textarea class="form-control" id="formDescription"
                                  rows="6"
                                  name="description">{{ $product?->description ?? '' }}</textarea>

                        <x-alert error inline>
                            {{ $errors->first('description') }}
                        </x-alert>
                    </div>

                    <div class="col-6 pb-2">
                        <label for="formPrice">Prezzo *</label>
                        <input type="number" class="form-control"
                               min="0" step="0.01" max="99999999.99"
                               id="formPrice" name="price"
                               value="{{ $product?->price ?? '' }}">

                        <x-alert error inline>
                            {{ $errors->first('price') }}
                        </x-alert>
                    </div>
                    <div class="col-6 pb-2">
                        <label for="formQty">Quantità *</label>
                        <input type="number" class="form-control"
                               min="0" step="1" max="65535"
                               id="formQty" name="qty"
                               value="{{ $product?->qty ?? '' }}">

                        <x-alert error inline>
                            {{ $errors->first('qty') }}
                        </x-alert>
                    </div>
                </div>
            </div>


            <div class="col-6 text-end">
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </div>
    </form>

@endsection
