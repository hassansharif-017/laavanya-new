<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsService
{
    public function __construct()
    {
    }

    public function filterProducts(Request $request)
    {
        return Product::with(['user'])
            ->where('is_publish', 1)
            ->where('stock_qty', '>', 0)
            ->whereHas('user', function ($query) {
                return $query->where('status_id', 1);
            })
            ->when($request->color, function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->color . '%')
                    ->orWhere('slug', 'like', '%' . $request->color . '%');
            })
            ->when($request->fabric, function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->fabric . '%')
                    ->orWhere('slug', 'like', '%' . $request->fabric . '%');
            })
            ->when($request->pattern, function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->pattern . '%')
                    ->orWhere('slug', 'like', '%' . $request->pattern . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->appends(request()->query());
    }
}
