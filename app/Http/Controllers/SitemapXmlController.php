<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class SitemapXmlController extends Controller
{
    public function index()
    {
        $pages = Page::where('is_publish', 1)->orderBy('id', 'desc')->get();
        $products = Product::where('is_publish', 1)->orderBy('id', 'desc')->get();
        return response()->view('sitemap', [
            'pages' => $pages,
            'products' => $products
        ])->header('Content-Type', 'text/xml');
    }
}
