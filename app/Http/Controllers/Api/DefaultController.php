<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Trait\ImageFunction;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    use ImageFunction;

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

        $paginator = $builder->paginate(
            perPage: $request->get('perPage', 10),
            page: $request->get('page', 1),
        );

        return response()
            ->json([
                'currentPage' => $paginator->currentPage(),
                'data' => $paginator->items(),
                'pages' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
            ]);
    }

    public function single(Product $product)
    {
        return response()
            ->json($product);
    }

    public function create(Request $request)
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
            return response()
                ->json(
                    ['errors' => $validator->errors()],
                    \Illuminate\Http\Response::HTTP_PRECONDITION_FAILED
                );
        }

        try {
            $product = new Product();
            $product->name = $validator->getValue('name');
            $product->description = $validator->getValue('description');
            $product->price = $validator->getValue('price');
            $product->qty = $validator->getValue('qty');
            $product->save();

            $this->mkImage($validator->getValue('img'), $product->id);

            return response(status: \Illuminate\Http\Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()
                ->json(
                    ['errors' => $th->getMessage()],
                    \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }

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
            return response()
                ->json(
                    ['errors' => $validator->errors()],
                    \Illuminate\Http\Response::HTTP_PRECONDITION_FAILED
                );
        }

        try {
            $product->name = $validator->getValue('name');
            $product->description = $validator->getValue('description');
            $product->price = $validator->getValue('price');
            $product->qty = $validator->getValue('qty');
            $product->save();

            $this->mkImage($validator->getValue('img'), $product->id);

            return response(status: \Illuminate\Http\Response::HTTP_RESET_CONTENT);
        } catch (\Throwable $th) {
            return response()
                ->json(
                    ['errors' => $th->getMessage()],
                    \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }

    public function toggleActivation(Product $product)
    {
        try {
            $product->active = !$product->active;
            $product->save();

            return response(status: \Illuminate\Http\Response::HTTP_RESET_CONTENT);
        } catch (\Throwable $th) {
            return response()
                ->json(
                    ['errors' => $th->getMessage()],
                    \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }

    public function delete(Product $product)
    {
        try {
            $this->rmImage($product->id);

            $product->delete();

            return response(status: \Illuminate\Http\Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()
                ->json(
                    ['errors' => $th->getMessage()],
                    \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }

    public function deleteImage(Product $product)
    {
        $this->rmImage($product->id);

        return response(status: \Illuminate\Http\Response::HTTP_OK);
    }
}
