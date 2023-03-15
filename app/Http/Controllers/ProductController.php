<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdcutResource;
use App\Models\Product;
use App\Responses\CollectionResponse;

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
}
