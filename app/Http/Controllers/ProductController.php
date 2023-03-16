<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdcutResource;
use App\Models\Product;
use App\Responses\CollectionResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class ProductController extends Controller
{
    public function index()
    {
        return new CollectionResponse(
            data: ProdcutResource::collection(
                resource: Product::query()->get(),
            ),
        );
    }

    public function show(Product $product)
    {
        return new CollectionResponse(
            data: ProdcutResource::collection(
                resource: Product::query()->where('id', $product->id)->get()
            )
        );
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only(['title', 'image', 'user_id']));

        return new CollectionResponse(
            data: ProdcutResource::collection(
                resource: Product::query()->where('id', $product->id)->get()
            ),
            status: Http::CREATED
        );
    }

    public function update(Product $product, Request $request)
    {
        $status = $product->update($request->only(['title', 'image', 'user_id']));

        if($status)
            return new CollectionResponse(
                data: ProdcutResource::collection(
                    resource: Product::query()->where('id', $product->id)->get()
                ),
                status: Http::ACCEPTED
            );

    }

    public function destroy(Product $product)
    {
        if($product->delete())
            return response()->json([], Http::NO_CONTENT->value);
    }
}
