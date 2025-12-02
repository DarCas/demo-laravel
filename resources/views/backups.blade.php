@extends('template')

@section('title', 'Backups')

@section('back', '/')

@section('content')

    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Nome del file
            </th>

            <th class="text-end">
                Data creazione
            </th>

            <th class="text-end">
                Dimensione
            </th>

            <th>&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        @forelse ($files as $file)
            <tr style="vertical-align: middle">
                <td>
                    {{ $file['name'] }}
                </td>

                <td class="text-end">
                    {{ $file['date'] }}
                </td>

                <td class="text-end">
                    {{ $file['size'] }} KiB
                </td>

                <td class="text-end">
                    <a class="btn btn-sm btn-outline-secondary"
                       href="/backups/{{ $file['name'] }}"
                    >
                        <i class="bi bi-cloud-arrow-down-fill"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <th colspan="4">
                    Non ci sono backups
                </th>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
