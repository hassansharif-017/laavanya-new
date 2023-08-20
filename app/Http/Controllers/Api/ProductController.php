<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Pro_category;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Attribute;
use App\Models\Media_option;
use App\Models\Pro_image;
use App\Models\Related_product;

class ProductController extends Controller
{
    
    
    public function saveProductsData(Request $request){

        $validator=Validator::make($request->all(), [

            'title' => 'required',
			'slug' => 'required|max:191|unique:products,slug',
			'cat_id' => 'required',
			'brand_id' => 'required',
			'stock_qty' => 'required',
			'sale_price' => 'required',
			'is_publish' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'errors'=> $validator->messages()
            ],422);
        }else{
            $Product=Product::create([
                'title'=>$request->title,
                'slug'=>$request->slug,
                'cat_id'=>$request->cat_id,
                'brand_id'=>$request->brand_id,
                'stock_qty'=>$request->stock_qty,
                'sale_price'=>$request->sale_price,
                'is_publish'=>$request->is_publish,
                'lan'=>"en",
                'user_id'=>'62'

            ]);

            if($Product){
                return response()->json([
                    'status'=> 200,
                    'message'=> "Product Created Successfully"
                ],200);
            }else{
                return response()->json([
                    'status'=> 500,
                    'message'=> "Something Went Wrong"
                ],500);
            }
        }
}




public function editProductsData($id){

    $Product= Product::find($id);
    if($Product){
        return response()->json([
            'status'=> 200,
            'product'=> $Product
        ],200);
    }else{
        return response()->json([
            'status'=> 404,
            'message'=> "No Such Product Found"
        ],404);
    }
}



public function updateProductsData(Request $request, int $id){

    $validator=Validator::make($request->all(), [

        'title' => 'required',
        'slug' => 'required|max:191|unique:products,slug',
        'cat_id' => 'required',
        'brand_id' => 'required',
        'stock_qty' => 'required',
        'sale_price' => 'required',
        'is_publish' => 'required'
    ]);
    if($validator->fails()){
        return response()->json([
            'status'=> 422,
            'errors'=> $validator->messages()
        ],422);
    }else{

        $Product=Product::find($id);


        if($Product){



            $Product->update([
                'title'=>$request->title,
                'slug'=>$request->slug,
                'cat_id'=>$request->cat_id,
                'brand_id'=>$request->brand_id,
                'stock_qty'=>$request->stock_qty,
                'sale_price'=>$request->sale_price,
                'is_publish'=>$request->is_publish,
                'lan'=>"en",
                'user_id'=>'62'
    
            ]);







            return response()->json([
                'status'=> 200,
                'message'=> "Product Updated Successfully"
            ],200);
        }else{
            return response()->json([
                'status'=> 404,
                'message'=> "No Such Product Found"
            ],500);
        }
    }
}








}
