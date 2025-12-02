@extends('template')

@section('title', 'Prodotti')

@section('headerAppend')

    <a href="/backups" class="btn btn-outline-secondary ms-auto">
        <i class="bi bi-cloud-arrow-down-fill"></i>

        Backups
    </a>

    <a href="/contacts" class="btn btn-outline-secondary ms-1">
        <i class="bi bi-envelope-fill"></i>

        Contattaci
    </a>

    <a href="/create" class="btn btn-outline-primary ms-1">
        <i class="bi bi-plus-lg"></i>

        Aggiungi prodotto
    </a>

    <form action="{{ request()->url() }}" method="get" class="ms-1">
        <div class="input-group">
            <input class="form-control" type="search" name="q"
                   placeholder="Cerca il prodotto"
                   value="{{ $q }}" aria-label="Cerca il prodotto"
            />
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <script>
        const inputSearch = document.querySelector('input[name="q"]');
        inputSearch.addEventListener('input', () => {
            if (inputSearch.value === '') {
                location.href = '/';
            }
        })
    </script>

@endsection

@section('content')

    <x-alert :error="$errors->has('error')">
        {{ $errors->first('success') }}
        {{ $errors->first('error') }}
    </x-alert>

    <form action="/delete" method="post">
        @csrf

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="text-center" style="width: 45px">
                    <input type="checkbox" id="ckeckAll" class="form-check-input">
                </th>
                <th class="text-end">
                    <x-table-header field="id">
                        ID
                    </x-table-header>
                </th>
                <th style="width: 75px">&nbsp;</th>
                <th style="width: 75px">&nbsp;</th>
                <th>
                    <x-table-header field="name">
                        Nome
                    </x-table-header>
                </th>
                <th class="text-end">
                    <x-table-header field="price">
                        Prezzo
                    </x-table-header>
                </th>
                <th class="text-end">
                    <x-table-header field="qty">
                        Quantità
                    </x-table-header>
                </th>
                <th class="text-end">
                    <x-table-header field="updated_at">
                        Ultima modifica
                    </x-table-header>
                </th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <td colspan="4">
                    <div class="dropdown dropdown-menu-start">
                        <button
                            id="deleteAll"
                            disabled
                            class="btn btn-danger"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-trash"></i>

                            Cancella tutto
                        </button>
                        <ul class="dropdown-menu bg-danger">
                            <li>
                                <button type="submit" class="btn text-white">
                                    Conferma cancella tutto
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
                <td colspan="5">
                    {!! $pagination !!}
                </td>
            </tr>
            </tfoot>

            <tbody>
            @forelse ($products as $product)
                <tr style="vertical-align: middle">
                    <td class="text-center">
                        <input type="checkbox" name="ids[]" value="{{ $product->id }}"
                               class="form-check-input">
                    </td>
                    <td class="text-end">
                        {{ $product->id }}
                    </td>

                    <td class="text-center">
                        <a href="/{{ $product->id }}/toggle-activation"
                           class="icon-link">
                            @if($product->active === true)
                                <i class="bi bi-eye-fill text-success"></i>
                            @else
                                <i class="bi bi-eye-slash"></i>
                            @endif
                        </a>
                    </td>

                    <td>
                        <img src="{{ $product->getImageUrlOrPlaceholder(300, 300, 'NO IMAGE\nFOUND') }}"
                             alt=""
                             class="img-thumbnail rounded"
                             style="aspect-ratio: 1; object-fit: cover; width: 100%">
                    </td>

                    <td>
                        {{ $product->name }}
                    </td>

                    <td class="text-end">
                        {{ $product->priceVerbose() }}
                    </td>

                    <td class="text-end">
                        {{ $product->qty }}
                    </td>

                    <td class="text-end">
                        {{ $product->updateAtVerbose() }}
                    </td>

                    <td class="text-end">
                        <x-product-btn
                            :active="$product->active"
                            :id="$product->id"
                        />
                    </td>
                </tr>
            @empty
                <tr>
                    <th colspan="9">
                        Non ci sono prodotti
                    </th>
                </tr>
            @endforelse
            </tbody>
        </table>
    </form>

    <script>
        const btnDeleteAll = document.querySelector('#deleteAll');

        const inputs = document.querySelectorAll('input[name="ids[]"]');
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                tglBtnDeleteAll()
            })
        });

        function tglBtnDeleteAll() {
            for (const input of inputs) {
                if (input.checked) {
                    btnDeleteAll.disabled = false
                    return
                }
            }

            btnDeleteAll.disabled = true
        }

        const inputCheckAll = document.querySelector('#ckeckAll');
        inputCheckAll.addEventListener('change', () => {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = inputCheckAll.checked);

            tglBtnDeleteAll()
        })
    </script>
@endsection
