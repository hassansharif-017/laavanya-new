<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Pro_image;
use App\Models\Product;
use App\Models\Related_product;
use Illuminate\Http\Request;
use App\Services\ProductsService;

use function PHPUnit\Framework\throwException;

class ProductController extends Controller
{
	public function __construct(protected ProductsService $productsService)
	{
	}

	public function index(Request $request)
	{
		return view('frontend.products', [
			'products' => $this->productsService->filterProducts($request),
		]);
	}

	//get Product Page
	public function getProductPage($id, $title)
	{

		//Product details
		$data = DB::table('products')
			->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
			->join('users', 'products.user_id', '=', 'users.id')
			->join('pro_categories', 'products.cat_id', '=', 'pro_categories.id')
			->select('products.*', 'brands.name as brandname', 'pro_categories.name as cat_name', 'pro_categories.slug as cat_slug', 'users.shop_name', 'users.id as seller_id', 'users.shop_url')
			->where('products.is_publish', '=', 1)
			->where('products.stock_qty', '<>', '0')
			->where('users.status_id', '=', 1)
			->where('products.id', '=', $id)
			->first();
		if (!$data) {
			abort(404, "Product was not found");
		}
		$Reviews = getReviews($data->id);
		$data->TotalReview = $Reviews[0]->TotalReview;
		$data->TotalRating = $Reviews[0]->TotalRating;
		$data->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);

		//Product images
		$pro_images = Pro_image::where('product_id', $id)->get();
		$images1 = Pro_image::where('product_id', $id)->first();

		//Related Products
		$related_products = DB::table('products')
			->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
			->join('related_products', 'products.id', '=', 'related_products.related_item_id')
			->join('users', 'products.user_id', '=', 'users.id')
			->select('products.*', 'brands.name as brandname', 'users.shop_name', 'users.id as seller_id', 'users.shop_url')
			->where('products.is_publish', '=', 1)
			->where('products.stock_qty', '<>', '0')
			->where('users.status_id', '=', 1)
			->where('related_products.product_id', '=', $id)
			->get();

		for ($i = 0; $i < count($related_products); $i++) {
			$Reviews = getReviews($related_products[$i]->id);
			$related_products[$i]->TotalReview = $Reviews[0]->TotalReview;
			$related_products[$i]->TotalRating = $Reviews[0]->TotalRating;
			$related_products[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
		}

		//Products by category
		$cat_id = $data->cat_id;
		$category_products = DB::table('products')
			->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
			->join('users', 'products.user_id', '=', 'users.id')
			->select('products.*', 'brands.name as brandname', 'users.shop_name', 'users.id as seller_id', 'users.shop_url')
			->where('products.is_publish', '=', 1)
			->where('products.stock_qty', '<>', '0')
			->where('users.status_id', '=', 1)
			->where('products.cat_id', '=', $cat_id)
			->whereNotIn('products.id', [$id])
			->offset(0)
			->limit(15)
			->get();

		for ($i = 0; $i < count($category_products); $i++) {
			$Reviews = getReviews($category_products[$i]->id);
			$category_products[$i]->TotalReview = $Reviews[0]->TotalReview;
			$category_products[$i]->TotalRating = $Reviews[0]->TotalRating;
			$category_products[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
		}

		//Products Reviews
		$pro_reviews = DB::table('reviews')
			->join('users', 'reviews.user_id', '=', 'users.id')
			->select('reviews.*', 'users.name', 'users.photo')
			->where('reviews.item_id', '=', $id)
			->orderBy('reviews.id', 'desc')
			->paginate(30);

		for ($i = 0; $i < count($pro_reviews); $i++) {
			$pro_reviews[$i]->rating = $pro_reviews[$i]->rating * 20;
		}

		$seller_data = DB::table('users')
			->join('products', 'users.id', '=', 'products.user_id')
			->select('users.id', 'users.email', 'users.shop_name', 'users.phone', 'users.address', 'users.photo', 'users.created_at')
			->where('products.is_publish', '=', 1)
			->where('users.status_id', '=', 1)
			->where('products.stock_qty', '<>', '0')
			->where('products.id', '=', $id)
			->first();

		$seller_id = $seller_data->id;
		$SellerReview = array('TotalReview' => 0, 'TotalRating' => 0, 'ReviewPercentage' => 0);
		$aReview = getReviewsBySeller($seller_id);
		$SellerReview['TotalReview'] = $aReview[0]->TotalReview;
		$SellerReview['TotalRating'] = $aReview[0]->TotalRating;
		$SellerReview['ReviewPercentage'] = number_format($aReview[0]->ReviewPercentage);

		return view('frontend.product', compact('data', 'pro_images', 'related_products', 'category_products', 'pro_reviews', 'seller_data', 'SellerReview', 'images1'));
	}

	//Get data for Products Reviews Pagination
	public function getProductReviewsGrid(Request $request)
	{

		$item_id = $request->item_id;

		if ($request->ajax()) {

			//Products Reviews
			$pro_reviews = DB::table('reviews')
				->join('users', 'reviews.user_id', '=', 'users.id')
				->select('reviews.*', 'users.name', 'users.photo')
				->where('reviews.item_id', '=', $item_id)
				->orderBy('reviews.id', 'desc')
				->paginate(30);

			for ($i = 0; $i < count($pro_reviews); $i++) {
				$pro_reviews[$i]->rating = $pro_reviews[$i]->rating * 20;
			}

			return view('frontend.partials.products-reviews-grid', compact('pro_reviews'))->render();
		}
	}
}
