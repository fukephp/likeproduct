<?php

namespace App\Http\Controllers;

use App\Components\ProductComponent;
use App\Http\Resources\ProdcutResource;
use App\Models\Product;
use App\Responses\CollectionResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return new CollectionResponse(
            data: ProdcutResource::collection(
                resource: $user->products,
            ),
        );
    }

    public function show(Product $product)
    {
        $user = auth()->user();

        return new CollectionResponse(
            data: ProdcutResource::collection(
                resource: Product::query()->where('id', $product->id)->where('user_id', $user->id)->get()
            )
        );
    }

    public function store(Request $request)
    {
        $product = app(ProductComponent::class)->store($request);

        return new CollectionResponse(
            data: ProdcutResource::collection(
                resource: Product::query()->where('id', $product->id)->get()
            ),
            status: Http::CREATED
        );
    }

    public function update(Product $product, Request $request)
    {
        $updated = app(ProductComponent::class)->update($request, $product);

        if($updated)
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
