<a href="{{ $url }}" class="page-link">
    {{ $slot }}

    @if($key === $orderBy)
        <i class="bi bi-sort-alpha-{{ $orderDir === 'asc' ? 'down' : 'up' }}"></i>
    @endif
</a>
