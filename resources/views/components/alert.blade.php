@props(['error' => false, 'inline' => false])

@if(trim($slot))
    <div class="alert alert-{{ $error ? 'danger' : 'success' }} {{ $inline ? 'mt-2' : '' }}">
        {{ $slot }}
    </div>
@endif
