<?php

namespace App\Components;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductComponent extends BaseComponent
{
    public function store(Request $request): Product
    {
        return Product::create($request->only(['title', 'image', 'user_id']));
    }

    public function update(Request $request, Product $product): bool
    {
        return $product->update($request->only(['title', 'image', 'user_id']));
    }
}
