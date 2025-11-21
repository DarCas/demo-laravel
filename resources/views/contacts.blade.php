@extends('template')

@section('title', 'Contattaci')

@section('back', '/')

@section('content')

    <x-alert :error="$errors->has('error')">
        {{ $errors->first('success') }}
        {{ $errors->first('error') }}
    </x-alert>

    <form action="/contacts" method="post">
        @csrf

        <div class="row">
            <div class="col-6">
                <label for="formName">Nome *</label>
                <input type="text" class="form-control" name="nome" id="formName" required>
                <x-alert error inline>
                    {{ $errors->first('nome') }}
                </x-alert>
            </div>

            <div class="col-6">
                <label for="formCognome">Cognome *</label>
                <input type="text" class="form-control" name="cognome" id="formCognome" required>
                <x-alert error inline>
                    {{ $errors->first('cognome') }}
                </x-alert>
            </div>

            <div class="col-6 pt-4">
                <label for="formEmail">E-Mail *</label>
                <input type="email" class="form-control" id="formEmail" name="email" required>
                <x-alert error inline>
                    {{ $errors->first('email') }}
                </x-alert>
            </div>

            <div class="col-6 pt-4">
                <label for="formTelefono">Telefono</label>
                <input type="tel" class="form-control" id="formTelefono" name="telefono">
                <x-alert error inline>
                    {{ $errors->first('telefono') }}
                </x-alert>
            </div>

            <div class="col-12 py-4">
                <label for="formMessaggio">Messaggio *</label>
                <textarea name="messaggio" rows="10"
                          id="formMessaggio" class="form-control"></textarea>
                <x-alert error inline>
                    {{ $errors->first('messaggio') }}
                </x-alert>
            </div>

            <div class="col-6 text-end">
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary">Invia</button>
            </div>
        </div>
    </form>


@endsection
