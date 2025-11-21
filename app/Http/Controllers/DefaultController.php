<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Trait\ImageFunction;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    use ImageFunction;

    /**
     * Controller per visualizzare l'elenco dei prodotti
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var \Illuminate\Database\Query\Builder $builder */
        $builder = Product::orderBy(
            $request->get('orderBy', 'name'),
            $request->get('orderDir', 'asc')
        );

        if ($request->get('q')) {
            $builder->where('name', 'LIKE', "%{$request->get('q')}%")
                ->orWhere('description', 'LIKE', "%{$request->get('q')}%");
        }

//        $paginator = new Paginator(
//            $builder->get(),
//            $request->get('perPage', 10),
//            $request->get('page', 1),
//            ['query' => $request->query()]
//        );

        $paginator = $builder->paginate(
            perPage: $request->get('perPage', 10),
            page: $request->get('page', 1),
        );

        return view('index')
            ->with('q', $request->get('q'))
            ->with('pagination', $paginator->links()->toHtml())
            ->with('products', $paginator->items());
    }

    public function save(\Illuminate\Http\Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => [
                'required',
                'max:150',
            ],
            'description' => 'required|max:65535',
            'price' => [
                'required',
                'decimal:0,2',
                'min:0.01',
                'max:99999999.99',
            ],
            'qty' => [
                'required',
                'integer',
                'min:0',
                'max:65535',
            ],
            'img' => 'nullable|image|mimes:jpg,png,webp',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()
                ->back()
                ->withErrors($errors);
        }

        try {
            $product = new Product();
            $product->name = $validator->getValue('name');
            $product->description = $validator->getValue('description');
            $product->price = $validator->getValue('price');
            $product->qty = $validator->getValue('qty');
            $product->save();

            $this->mkImage($validator->getValue('img'), $product->id);

            return redirect('/')
                ->withErrors([
                    'success' => 'Il prodotto è stato aggiunto con successo.',
                ]);
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withErrors([
                    'error' => $th->getMessage(),
                ]);
        }
    }

    /**
     * Controller per modificare un prodotto
     *
     * @param Product|null $product
     * @return Factory|View|\Illuminate\View\View
     */
    public function single(?Product $product)
    {
        return view('edit')
            ->with('product', $product->exists ? $product : null);
    }

    /**
     * Controller per salvare le modifiche apportate al prodotto
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => [
                'required',
                'max:150',
            ],
            'description' => 'required|max:65535',
            'price' => [
                'required',
                'decimal:0,2',
                'min:0.01',
                'max:99999999.99',
            ],
            'qty' => [
                'required',
                'integer',
                'min:0',
                'max:65535',
            ],
            'img' => 'nullable|image|mimes:jpg,png,webp',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()
                ->back()
                ->withErrors($errors);
        }

        try {
            $product->name = $validator->getValue('name');
            $product->description = $validator->getValue('description');
            $product->price = $validator->getValue('price');
            $product->qty = $validator->getValue('qty');
            $product->save();

            $this->mkImage($validator->getValue('img'), $product->id);

            return redirect()
                ->back()
                ->withErrors([
                    'success' => 'Il prodotto è stato aggiornato con successo.',
                ]);
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withErrors([
                    'error' => $th->getMessage(),
                ]);
        }
    }

    /**
     * Controller per cancellare un prodotto
     *
     * @param Request $request
     * @param Product|null $product
     * @return RedirectResponse
     */
    public function delete(Request $request, ?Product $product)
    {
        try {
            if ($request->method() === 'POST') {
                /** @var int[] $ids */
                $ids = $request->get('ids');

                foreach ($ids as $id) {
                    /** @var Product|null $product */
                    $product = Product::find($id);

                    if (!is_null($product)) {
                        $this->rmImage($product->id);

                        $product->delete();
                    }
                }

                return redirect()
                    ->back()
                    ->withErrors([
                        'success' => 'I prodotti sono stati cancellati con successo.',
                    ]);
            } else {
                $this->rmImage($product->id);

                $product->delete();

                return redirect()
                    ->back()
                    ->withErrors([
                        'success' => 'Il prodotto è stato cancellato con successo.',
                    ]);
            }
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withErrors([
                    'error' => $th->getMessage(),
                ]);
        }
    }

    /**
     * Cancella l'immagine del prodotto
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage(Product $product)
    {
        $this->rmImage($product->id);

        return redirect()
            ->back()
            ->withErrors([
                'success' => "L'immagine è stata cancellata con successo.",
            ]);
    }

    /**
     * Attiva o disattiva un prodotto
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActivation(Product $product)
    {
        try {
            $product->active = !$product->active;
            $product->save();

            return redirect()
                ->back()
                ->withErrors([
                    'success' => $product->active ?
                        "Il prodotto è stato attivato con successo." :
                        "Il prodotto è stato disattivato con successo.",
                ]);
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withErrors([
                    'error' => $th->getMessage(),
                ]);
        }
    }
}
