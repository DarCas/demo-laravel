@props(['active', 'id'])
<div class="dropdown dropdown-menu-end">
    <a class="btn btn-sm btn-outline-secondary"
       href="#"
       role="button"
       data-bs-toggle="dropdown"
       aria-expanded="false"
    >
        <i class="bi bi-three-dots-vertical"></i>
    </a>

    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item"
               href="/{{ $id }}/toggle-activation">
                @if($active === true)
                    Disattiva
                @else
                    Attiva
                @endif
            </a>
        </li>

        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <a class="dropdown-item"
               href="/{{ $id }}">
                Modifica
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item"
               href="/{{ $id }}/delete">
                Cancella
            </a>
        </li>
    </ul>
</div>
