<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Tp_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitemapXmlController extends Controller
{
    public function index()
    {
        $lan = glan();
        $sData = Tp_option::where('option_name', '=', 'page_variation')->first();
		if($sData !=''){
			$dataObj = json_decode($sData['option_value']);
			$seller_variation = $dataObj->seller_variation;
		}else{
			$seller_variation = 'left_sidebar';
		}
		
		if(($seller_variation == 'left_sidebar') || ($seller_variation == 'right_sidebar')){
			$num = 12;
		}else{
			$num = 16;
		}


        $pages = Page::where('is_publish', 1)->orderBy('id', 'desc')->get();
        $products = Product::where('is_publish', 1)->orderBy('id', 'desc')->get();
        $datalist = DB::table('products')
        ->join('users', 'products.user_id', '=', 'users.id')
        ->select('products.*', 'users.shop_name', 'users.id as seller_id', 'users.shop_url')
        ->where('products.is_publish', '=', 1)
        ->where('users.status_id', '=', 1)
        ->where('products.lan', '=', $lan)
        ->where('products.user_id', '=', 62)
        ->orderBy('products.id', 'desc')
        ->paginate($num);
        return response()->view('sitemap', [
            'storePages' => $datalist->lastPage(),
            'pages' => $pages,
            'products' => $products
        ])->header('Content-Type', 'text/xml');
    }
}
