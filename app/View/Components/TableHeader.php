<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected ?string $field)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $orderBy = request()->query('orderBy', 'name');
        $orderDir = request()->query('orderDir', 'asc');

        $query = request()->uri()
            ->query()
            ->except('page');

        $query['orderBy'] = $this->field;

        if ($orderBy !== $this->field) {
            $query['orderDir'] = 'asc';
        } else {
            $query['orderDir'] = ($orderDir === 'asc') ? 'desc' : 'asc';
        }

        $url = request()->uri()
            ->replaceQuery($query)
            ->value();

        return view('components.table-header')
            ->with('key', $this->field)
            ->with('orderBy', $orderBy)
            ->with('orderDir', $orderDir)
            ->with('url', $url);
    }
}
