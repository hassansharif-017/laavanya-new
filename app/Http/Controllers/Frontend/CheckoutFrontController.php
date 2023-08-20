<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order_master;
use App\Models\Order_item;
use App\Models\Country;
use App\Models\Shipping;
use App\Models\Product;
use Cart;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use URL;
use Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use Razorpay\Api\Api;

use Mollie\Laravel\Facades\Mollie;

class CheckoutFrontController extends Controller
{
	
    private $_api_context;
    
    public function __construct()
	{		
		$gtext = gtext();
		
		$mode = 'sandbox';
		if($gtext['ismode_paypal'] == 1){
			$mode = 'sandbox';
		}else{
			$mode = 'live';
		}
		
		$paypal_conf = array();
		$paypal_conf['settings']['mode'] = $mode;
		$paypal_conf['client_id'] = $gtext['paypal_client_id'];
		$paypal_conf['secret'] = $gtext['paypal_secret'];
				
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));

        $this->_api_context->setConfig($paypal_conf['settings']);
    }
	
    public function LoadCheckout()
    {
		$country_list = Country::where('is_publish', '=', 1)->orderBy('country_name', 'ASC')->get();
		$shipping_list = Shipping::where('is_publish', '=', 1)->get();
				
        return view('frontend.checkout', compact('country_list', 'shipping_list'));
    }
	
    public function LoadThank()
    {	
        return view('frontend.thank');
    }
	
    public function LoadMakeOrder(Request $request)
    {
		$res = array();
		$gtext = gtext();
		$gtax = getTax();
		
		Session::forget('pt_payment_error');
		
		$total_qty = Cart::instance('shopping')->count();
		
		if($total_qty == 0){
			$res['msgType'] = 'error';
			$res['msg'] = array('oneError' => array(__('Oops! Your order is failed. Please product add to cart.')));
			return response()->json($res);
		}
		
		$customer_id = '';
		
		$newaccount = $request->input('new_account');
		
		if ($newaccount == 'true' || $newaccount == 'on') {
			$new_account = 1;
		}else {
			$new_account = 0;
		}

		$payment_method_id = $request->input('payment_method');
		$shipping_method_id = $request->input('shipping_method');

		if($new_account == 1){
			
			$validator = Validator::make($request->all(),[
				'name' => 'required',
				'phone' => 'required',
				'country' => 'required',
				'state' => 'required',
				'zip_code' => 'required',
				'city' => 'required',
				'address' => 'required',
				'payment_method' => 'required',
				'shipping_method' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed',
			]);

			if(!$validator->passes()){
				$res['msgType'] = 'error';
				$res['msg'] = $validator->errors()->toArray();
				return response()->json($res);
			}

			$userData = array(
				'name' => $request->input('name'),
				'email' => $request->input('email'),
				'phone' => $request->input('phone'),
				'address' => $request->input('address'),
				'state' => $request->input('state'),
				'zip_code' => $request->input('zip_code'),
				'city' => $request->input('city'),
				'password' => Hash::make($request->input('password')),
				'bactive' => base64_encode($request->input('password')),
				'status_id' => 1,
				'role_id' => 2
			);
			
			$customer_id = User::create($userData)->id;
			
		}else{
			
			$validator = Validator::make($request->all(),[
				'name' => 'required',
				'email' => 'required',
				'phone' => 'required',
				'country' => 'required',
				'state' => 'required',
				'zip_code' => 'required',
				'city' => 'required',
				'address' => 'required',
				'payment_method' => 'required',
				'shipping_method' => 'required'
			]);
			
			if(!$validator->passes()){
				$res['msgType'] = 'error';
				$res['msg'] = $validator->errors()->toArray();
				return response()->json($res);
			}

			$customer_id = $request->input('customer_id');
		}

		$shipping_list = Shipping::where('id', '=', $shipping_method_id)->where('is_publish', '=', 1)->get();
		$shipping_title = NULL;
		$shipping_fee = NULL;
		foreach ($shipping_list as $row){
			$shipping_title = $row->title;
			$shipping_fee_amount = Config::get('constants.MINIMUM_SHIPING_CHARGES_AMOUNT');;
			if($total_amount > Config::get('constants.SHIPING_CHARGES_APPLICABLE_AMOUNT')){
				$shipping_fee_amount = 0;
			}
			$shipping_fee = (comma_remove($row->shipping_fee)+$shipping_fee_amount);
		}

		$total_amount = Cart::instance('shopping')->total();

		$CartDataList = Cart::instance('shopping')->content();
		$UniqueDataArray = array();
		$key = 0;
		foreach($CartDataList as $row){
			
			$UniqueDataArray[$key] = $row->options->seller_id;
			
			$key++;
		}
		
		$UniqueDataList = array_unique($UniqueDataArray);
		
		$MasterData = array();
		$OrderNoArr = $order_arr = array();
		
		$i = 1;
		foreach($UniqueDataList as $row){
			
			$random_code = random_int(100000, 999999);
			
			$order_no = 'ORD-'.$random_code.$i;
			$OrderNoArr[] = $order_no;
			
			$seller_id = $row;
			$data = array(
				'order_no' => $order_no,
				'customer_id' => $customer_id,
				'seller_id' => $seller_id,
				'payment_method_id' => $payment_method_id,
				//'payment_status_id' => 2,
				'payment_status_id' => ($payment_method_id == 5)? 1 :2,
				'order_status_id' => 1,
				'shipping_title' => $shipping_title,
				'shipping_fee' => $shipping_fee,
				'name' => $request->input('name'),
				'email' => $request->input('email'),
				'phone' => $request->input('phone'),
				'country' => $request->input('country'),
				'state' => $request->input('state'),
				'zip_code' => $request->input('zip_code'),
				'city' => $request->input('city'),
				'address' => $request->input('address'),
				'comments' => $request->input('comments')
			);
			
			$order_master_id = Order_master::create($data)->id;
			
			$i++;
			$order_arr[] = $order_no;
			$MasterData[$seller_id] = $order_master_id;
		}

		//set order master ids into session
		Session::put('order_master_ids', $MasterData);
		Session::put('order_arr', $order_arr);
		$tax_rate = $gtax['percentage'];
		
		$index = 0;
		$total_tax = 0;
		foreach($CartDataList as $row){

			$seller_id = $row->options->seller_id;
			$order_master_id = $MasterData[$seller_id];
			$product_id = $row->id;			
			$total_price = $row->price*$row->qty;
			
			$total_tax = (($total_price*$tax_rate)/100);
			
			$OrderItemData = array(
				'order_master_id' => $order_master_id,
				'customer_id' => $customer_id,
				'seller_id' => $seller_id,
				'product_id' => $row->id,
				'variation_size' => $row->options->unit,
				'quantity' => comma_remove($row->qty),
				'price' => comma_remove($row->price),
				'total_price' => comma_remove($total_price),
				'tax' => comma_remove($total_tax)
			);
			
			Order_item::create($OrderItemData);
			//update stock qty
            $product_info = Product::select('stock_qty')->where(['id'=>$product_id])->first();
            $stock_qty = (int)($product_info->stock_qty-$row->qty);
            $update_arr = ['stock_qty'=>$stock_qty];
            if($stock_qty == 0){
                $update_arr['stock_status_id'] = 0;
            }
            Product::where(['id'=>$product_id])->update($update_arr);
            //end stock qty in product table
			$index++;
		}
		
		if($index>0){
			$intent = '';
			
			$sellerCount = 0;
			
			$OrderNoStr = implode(', ', $OrderNoArr);
			$total_qty = comma_remove($total_qty);
			$description = 'Total Quantity:'.$total_qty.', Order No:'. $OrderNoStr;

			$sellerCount = count($UniqueDataList);
		
			if($shipping_fee ==''){
				$shippingFee = 0; 
			}else{
				$shippingFee = $sellerCount * $shipping_fee;
			}
			
			$t_amount = comma_remove($total_amount);
			
			$totalAmount = $t_amount + $shippingFee;

			//Stripe
			if($payment_method_id == 3){
				if($gtext['stripe_isenable'] == 1){
					$stripe_secret = $gtext['stripe_secret'];
					
					// Enter Your Stripe Secret
					\Stripe\Stripe::setApiKey($stripe_secret);
							
					$amount = $totalAmount;
					$amount *= 100;
					$amount = (int) $amount;
					if($gtext['stripe_currency'] !=''){
						$currency = $gtext['stripe_currency'];
					}else{
						$currency = 'usd';
					}
					
					$payment_intent = \Stripe\PaymentIntent::create([
						'amount' => $amount,
						'currency' => $currency,
						'description' => $description,
						'payment_method_types' => ['card']
					]);
					$intent = $payment_intent->client_secret;
				}
				
			//Paypal
			}elseif($payment_method_id == 4){
				
				if($gtext['isenable_paypal'] == 1){
				
					try {
						
						$price = $totalAmount;

						$paypal_currency = $gtext['paypal_currency'];
						
						$payer = new Payer();
						$payer->setPaymentMethod('paypal');

						$item_1 = new Item();

						$item_1->setName($description)
							->setCurrency($paypal_currency)
							->setQuantity(1)
							->setPrice($price);

						$item_list = new ItemList();
						$item_list->setItems(array($item_1));

						$amount = new Amount();
						$amount->setCurrency($paypal_currency)->setTotal($price);

						$transaction = new Transaction();
						$transaction->setAmount($amount)
							->setItemList($item_list)
							->setDescription($description);

						$redirect_urls = new RedirectUrls();
						
						$redirect_urls->setReturnUrl(
							route('frontend.paypal-payment-status')
						)->setCancelUrl(
							route('frontend.paypal-payment-status')
						);

						$payment = new Payment();
						$payment->setIntent('Sale')
							->setPayer($payer)
							->setRedirectUrls($redirect_urls)
							->setTransactions(array($transaction));
							
						try {

							$payment->create($this->_api_context);

						} catch (\PayPal\Exception\PPConnectionException $ex) {
							if (\Config::get('app.debug')) {
								
								Order_item::whereIn('order_master_id', $MasterData)->delete();
								Order_master::whereIn('id', $MasterData)->delete();
								
								$res['msgType'] = 'error';
								$res['msg'] = array('oneError' => array(__('Connection timeout')));
								return response()->json($res);
							} else {
								
								Order_item::whereIn('order_master_id', $MasterData)->delete();
								Order_master::whereIn('id', $MasterData)->delete();
						
								$res['msgType'] = 'error';
								$res['msg'] = array('oneError' => array(__('Some error occur, sorry for inconvenient')));
								return response()->json($res);            
							}
						}

						foreach($payment->getLinks() as $link) {
							if($link->getRel() == 'approval_url') {
								$redirect_url = $link->getHref();
								break;
							}
						}
						
						Session::put('paypal_payment_id', $payment->getId());
						Session::put('order_master_ids', $MasterData);

						if(isset($redirect_url)) {
							$intent = $redirect_url;
						}
						
					}catch(\Exception $e){
						
						Order_item::whereIn('order_master_id', $MasterData)->delete();
						Order_master::whereIn('id', $MasterData)->delete();
					
						$res['msgType'] = 'error';
						$res['msg'] = array('oneError' => array(__('Unknown error occurred')));
						return response()->json($res);
					}
				}
			
			//Razorpay
			}elseif($payment_method_id == 5){
				$intent = '';
				
				if($gtext['isenable_razorpay'] == 1){
					
					$razorpay_payment_id = $request->input('razorpay_payment_id');
					
					if($razorpay_payment_id == ''){
						$res['msgType'] = 'error';
						$res['msg'] = array('oneError' => array(__('Payment failed')));
						return response()->json($res);
					}
			
					$razorpay_key_id = $gtext['razorpay_key_id'];
					$razorpay_key_secret = $gtext['razorpay_key_secret'];
					
					$api = new Api($razorpay_key_id, $razorpay_key_secret);
					
					$payment = $api->payment->fetch($razorpay_payment_id);

					if(!empty($razorpay_payment_id)){
						
						try {
							$response = $api->payment->fetch($razorpay_payment_id)->capture(array('amount'=>$payment['amount'])); 
							
							$api->payment->fetch($razorpay_payment_id)->edit(array('notes'=> array('description'=> $description)));
							
						}catch (\Exception $e){
							
							Order_item::whereIn('order_master_id', $MasterData)->delete();
							Order_master::whereIn('id', $MasterData)->delete();
						
							$res['msgType'] = 'error';
							$res['msg'] = array('oneError' => array(__('Payment failed')));
							return response()->json($res);
						}            
					}
				}
			
			//Mollie
			}elseif($payment_method_id == 6){
	
				if($gtext['isenable_mollie'] == 1){

					$priceString = number_format($totalAmount, 2);
					$price = str_replace(",","", $priceString);
					$amount = (string) $price;
					// $amount = strval($price);

					$mollie_currency = $gtext['mollie_currency'];
						
					$mollie_api_key = $gtext['mollie_api_key'];
					Mollie::api()->setApiKey($mollie_api_key); // your mollie test api key

					$makePayment = [
						"amount" => [
							"currency" => $mollie_currency, //'EUR', // Type of currency you want to send
							"value" => $amount, //'30.00' You must send the correct number of decimals, thus we enforce the use of strings
						],
						"description" => $description, 
						"redirectUrl" => route('frontend.thank') // after the payment completion where you to redirect
					];
					
					$payment = Mollie::api()->payments()->create($makePayment);
				
					$payment = Mollie::api()->payments()->get($payment->id);
					
					$intent = $payment->getCheckoutUrl();
				}
				
			}else{
				$intent = '';
			}
			
			if($payment_method_id != 4){

				Cart::instance('shopping')->destroy();
				
				if($gtext['ismail'] == 1){
					self::orderNotify($MasterData);
				}
			}
			
			$res['msgType'] = 'success';
			$res['msg'] = __('Your order is successfully.');
			$res['intent'] = $intent;
			return response()->json($res);
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Oops! Your order is failed. Please try again.');
			return response()->json($res);
		}
    }
	
    public function getPaypalPaymentStatus(Request $request)
    {   
		$gtext = gtext();
		
		$order_master_ids = Session::get('order_master_ids');
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('order_master_ids');
        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
			
			Order_item::whereIn('order_master_id', $order_master_ids)->delete();
			Order_master::whereIn('id', $order_master_ids)->delete();

            \Session::put('pt_payment_error', __('Payment failed'));
            return Redirect::route('frontend.checkout');
        }
		
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {
			
			Cart::instance('shopping')->destroy();
			
			 if($gtext['ismail'] == 1){
				self::orderNotify($order_master_ids);
			}
			
            return Redirect::route('frontend.thank');
        }
		
		Order_item::whereIn('order_master_id', $order_master_ids)->delete();
		Order_master::whereIn('id', $order_master_ids)->delete();
		
		\Session::put('pt_payment_error', __('Payment failed'));
		return Redirect::route('frontend.checkout');
    }
	
    //Order Notify
    public function orderNotify($MasterData) {
		$gtext = gtext();
		
 		$datalist = DB::table('order_masters as a')
			->join('order_items as b', 'a.id', '=', 'b.order_master_id')
			->join('users as c', 'a.seller_id', '=', 'c.id')
			->join('payment_method as d', 'a.payment_method_id', '=', 'd.id')
			->join('payment_status as e', 'a.payment_status_id', '=', 'e.id')
			->join('order_status as f', 'a.order_status_id', '=', 'f.id')
			->join('products as g', 'b.product_id', '=', 'g.id')
			->select(
				'a.id', 
				'a.customer_id', 
				'a.seller_id', 
				'a.payment_status_id', 
				'a.order_status_id', 
				'a.order_no', 
				'a.created_at', 
				'a.shipping_title', 
				'a.shipping_fee',
				'g.title', 
				'b.quantity', 
				'b.price', 
				'b.total_price', 
				'b.tax', 
				'b.discount',
				'b.variation_color',
				'b.variation_size',
				'a.email as customer_email', 
				'a.name as customer_name', 
				'a.phone as customer_phone', 
				'a.country', 
				'a.state', 
				'a.zip_code', 
				'a.city', 
				'a.address as customer_address',  
				'c.shop_name',  
				'c.shop_url',  
				'c.email as seller_email',  
				'd.method_name', 
				'e.pstatus_name', 
				'f.ostatus_name')
			->whereIn('a.id', $MasterData)
			->orderBy('a.seller_id', 'ASC')
			->get();

		$index = 0;
		$mdata = array();
		$orderDataArr = array();
		$tempSellerId = ''; 
		$SellerCount = 0;
		$totalAmount = 0;
		$totalTax = 0;
		$totalDiscount = 0;
		
		$item_list = '';
		foreach($datalist as $row){
			if($index == 0){
				$mdata['payment_status_id'] = $row->payment_status_id;
				$mdata['order_status_id'] = $row->order_status_id;
				$mdata['customer_name'] = $row->customer_name;
				$mdata['customer_email'] = $row->customer_email;
				$mdata['customer_address'] = $row->customer_address;
				$mdata['city'] = $row->city;
				$mdata['state'] = $row->state;
				$mdata['zip_code'] = $row->zip_code;
				$mdata['country'] = $row->country;
				$mdata['customer_phone'] = $row->customer_phone;
				$mdata['order_no'] = 'order_no888';
				$mdata['created_at'] = $row->created_at;
				$mdata['method_name'] = $row->method_name;
				$mdata['pstatus_name'] = $row->pstatus_name;
				$mdata['ostatus_name'] = $row->ostatus_name;
				$mdata['shipping_title'] = $row->shipping_title;
				$mdata['shipping_fee'] = $row->shipping_fee;
			}
			
			$totalAmount +=$row->total_price;
			$totalTax +=$row->tax;
			$totalDiscount +=$row->discount;
			
			if($gtext['currency_position'] == 'left'){
				$price = $gtext['currency_icon'].number_format($row->price);
				$total_price = $gtext['currency_icon'].number_format($row->total_price);
			}else{
				$price = number_format($row->price).$gtext['currency_icon'];
				$total_price = number_format($row->total_price).$gtext['currency_icon'];
			}

			if($row->variation_size == '0'){
				$size = '';
			}else{
				$size = $row->quantity.' '.$row->variation_size;
			}
			
			if($tempSellerId != $row->seller_id){

				$orderDataArr[$row->seller_id]['id'] = $row->id;
				$orderDataArr[$row->seller_id]['order_no'] = $row->order_no;
				$orderDataArr[$row->seller_id]['seller_id'] = $row->seller_id;
				$orderDataArr[$row->seller_id]['seller_email'] = $row->seller_email;
				$orderDataArr[$row->seller_id]['shop_name'] = $row->shop_name;
				
				$item_list .= '<tr>
								<td colspan="3" style="width:100%;text-align:left;border:1px solid #ddd;background-color:#f7f7f7;font-weight:bold;">'.__('Sold By').': <a href="'.route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]).'"> '.$row->shop_name.'</a>, '.__('Order#').': <a href="'.route('frontend.order-invoice', [$row->id, $row->order_no]).'"> '.$row->order_no.'</a></td>
							</tr>';

				$tempSellerId=$row->seller_id; 
				$SellerCount++;		
			}
			
			$item_list .= '<tr>
							<td style="width:70%;text-align:left;border:1px solid #ddd;">'.$row->title.'<br>'.$size.'</td>
							<td style="width:15%;text-align:center;border:1px solid #ddd;">'.$price.' x '.$row->quantity.'</td>
							<td style="width:15%;text-align:right;border:1px solid #ddd;">'.$total_price.'</td>
						</tr>';
			
			$index++;
		}

		$shipping_fee = $mdata['shipping_fee'] * $SellerCount;
		
		$total_amount_shipping_fee = $totalAmount + $shipping_fee + $totalTax;
		
		if($gtext['currency_position'] == 'left'){
			$shippingFee = $gtext['currency_icon'].number_format($mdata['shipping_fee'], 2);
			$shipping_fee = $gtext['currency_icon'].number_format($shipping_fee, 2);
			$tax = $gtext['currency_icon'].number_format($totalTax, 2);
			$discount = $gtext['currency_icon'].number_format($totalDiscount, 2);
			$subtotal = $gtext['currency_icon'].number_format($totalAmount, 2);
			$total_amount = $gtext['currency_icon'].number_format($total_amount_shipping_fee, 2);
			
		}else{
			$shippingFee = number_format($mdata['shipping_fee'], 2).$gtext['currency_icon'];
			$shipping_fee = number_format($shipping_fee, 2).$gtext['currency_icon'];
			$tax = number_format($totalTax, 2).$gtext['currency_icon'];
			$discount = number_format($totalDiscount, 2).$gtext['currency_icon'];
			$subtotal = number_format($totalAmount, 2).$gtext['currency_icon'];
			$total_amount = number_format($total_amount_shipping_fee, 2).$gtext['currency_icon'];
		}
		
		if($mdata['payment_status_id'] == 1){
			$pstatus = '#26c56d'; //Completed = 1
		}elseif($mdata['payment_status_id'] == 2){
			$pstatus = '#fe9e42'; //Pending = 2
		}elseif($mdata['payment_status_id'] == 3){
			$pstatus = '#f25961'; //Canceled = 3
		}elseif($mdata['payment_status_id'] == 4){
			$pstatus = '#f25961'; //Incompleted 4
		}
		
		if($mdata['order_status_id'] == 1){
			$ostatus = '#fe9e42'; //Awaiting processing = 1
		}elseif($mdata['order_status_id'] == 2){
			$ostatus = '#fe9e42'; //Processing = 2
		}elseif($mdata['order_status_id'] == 3){
			$ostatus = '#fe9e42'; //Ready for pickup = 3
		}elseif($mdata['order_status_id'] == 4){
			$ostatus = '#26c56d'; //Completed 4
		}elseif($mdata['order_status_id'] == 5){
			$ostatus = '#f25961'; //Canceled 5
		}

		$base_url = url('/');

		$InvoiceDownloads = '';
		$orderNos = '';
		$invoice_index = 1;
		$f = 0;
		foreach($orderDataArr as $row){
			if($f++){
				$orderNos .= ', ';
			}
			$orderNos .= $row['order_no'];
			
			$InvoiceDownloads .= '<a href="'.route('frontend.order-invoice', [$row['id'], $row['order_no']]).'" style="background:'.$gtext['theme_color'].';display:block;text-align:center;padding:7px 15px;margin:0 10px 10px 0;border-radius:3px;text-decoration:none;color:#fff;float:left;">'.__('Invoice').' ('.$row['order_no'].')</a>';
			$invoice_index++;
		}
		
		if($gtext['ismail'] == 1){
			try {

				require 'vendor/autoload.php';
				$mail = new PHPMailer(true);
				$mail->CharSet = "UTF-8";

				if($gtext['mailer'] == 'smtp'){
					$mail->SMTPDebug = 0; //0 = off (for production use), 1 = client messages, 2 = client and server messages
					$mail->isSMTP();
					$mail->Host       = $gtext['smtp_host'];
					$mail->SMTPAuth   = true;
					$mail->Username   = $gtext['smtp_username'];
					$mail->Password   = $gtext['smtp_password'];
					$mail->SMTPSecure = $gtext['smtp_security'];
					$mail->Port       = $gtext['smtp_port'];
				}

				//Get mail
				$mail->setFrom($gtext['from_mail'], $gtext['from_name']);
				$mail->addAddress($mdata['customer_email'], $mdata['customer_name']);
				foreach($orderDataArr as $row){
				$mail->addAddress($row['seller_email'], $row['shop_name']);
				// $mail->addCC($row['seller_email'], $row['shop_name']);
				}
				$mail->isHTML(true);
				$mail->CharSet = "utf-8";
				$mail->Subject = $orderNos.' - '. __('Thank you for placing your order with Laavanya.');
				
				$mail->Body = '<table style="background-color:#edf2f7;color:#111111;padding:40px 0px;line-height:24px;font-size:14px;" border="0" cellpadding="0" cellspacing="0" width="100%">	
								<tr>
									<td>
										<table style="background-color:#fff;max-width:1000px;margin:0 auto;padding:30px;" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr><td style="font-size:40px;border-bottom:1px solid #ddd;padding-bottom:25px;font-weight:bold;text-align:center;">'.$gtext['company'].'</td></tr>
											<tr><td style="font-size:25px;font-weight:bold;padding:30px 0px 5px 0px;">'.__('Hi').' '.$mdata['customer_name'].'</td></tr>
											<tr><td>'.__('We have received your order and will contact you as soon as your package is shipped. You can find your purchase information below.').'</td></tr>
											<tr>
												<td style="padding-top:30px;padding-bottom:20px;">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td style="vertical-align: top;">
																<table border="0" cellpadding="3" cellspacing="0" width="100%">
																	<tr><td style="font-size:16px;font-weight:bold;">'.__('BILL TO').':</td></tr>
																	<tr><td><strong>'.$mdata['customer_name'].'</strong></td></tr>
																	<tr><td>'.$mdata['customer_address'].'</td></tr>
																	<tr><td>'.$mdata['city'].', '.$mdata['state'].', '.$mdata['zip_code'].', '.$mdata['country'].'</td></tr>
																	<tr><td>'.$mdata['customer_email'].'</td></tr>
																	<tr><td>'.$mdata['customer_phone'].'</td></tr>
																</table>
																<table style="padding:30px 0px;" border="0" cellpadding="3" cellspacing="0" width="100%">
																	<tr><td style="font-size:16px;font-weight:bold;">'.__('BILL FROM').':</td></tr>
																	<tr><td><strong>'.$gtext['company'].'</strong></td></tr>
																	<tr><td>'.$gtext['invoice_address'].'</td></tr>
																	<tr><td>'.$gtext['invoice_email'].'</td></tr>
																	<tr><td>'.$gtext['invoice_phone'].'</td></tr>
																</table>
															</td>
															<td style="vertical-align: top;">
																<table style="text-align:right;" border="0" cellpadding="3" cellspacing="0" width="100%">
																	<tr><td><strong>'.__('Order Date').'</strong>: '.date('d-m-Y', strtotime($mdata['created_at'])).'</td></tr>
																	<tr><td><strong>'.__('Payment Method').'</strong>: '.$mdata['method_name'].'</td></tr>
																	<tr><td><strong>'.__('Payment Status').'</strong>: <span style="color:'.$pstatus.'">'.$mdata['pstatus_name'].'</span></td></tr>
																	<tr><td><strong>'.__('Order Status').'</strong>: <span style="color:'.$ostatus.'">'.$mdata['ostatus_name'].'</span></td></tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>
													<table style="border-collapse:collapse;" border="0" cellpadding="5" cellspacing="0" width="100%">
														<tr>
															<th style="width:70%;text-align:left;border:1px solid #ddd;">'.__('Product').'</th>
															<th style="width:15%;text-align:center;border:1px solid #ddd;">'.__('Price').'</th>
															<th style="width:15%;text-align:right;border:1px solid #ddd;">'.__('Total').'</th>
														</tr>
														'.$item_list.'
													</table>
												</td>
											</tr>
											<tr>
												<td style="padding-top:5px;padding-bottom:20px;">
													<table style="font-weight:bold;" border="0" cellpadding="5" cellspacing="0" width="100%">
														<tr>
															<td style="width:85%;text-align:left;">'.$mdata['shipping_title'].': '.$shippingFee.' <span style="float:right">'.__('Shipping Fee').':</span></td>
															<td style="width:15%;text-align:right;">'.$shipping_fee.'</td>
														</tr>
														<tr>
															<td style="width:85%;text-align:right;">'.__('Tax').':</td>
															<td style="width:15%;text-align:right;">'.$tax.'</td>
														</tr>
														<tr>
															<td style="width:85%;text-align:right;">'.__('Subtotal').':</td>
															<td style="width:15%;text-align:right;">'.$subtotal.'</td>
														</tr>
														<tr>
															<td style="width:85%;text-align:right;">'.__('Total').':</td>
															<td style="width:15%;text-align:right;">'.$total_amount.'</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr><td style="padding-top:30px;padding-bottom:50px;">'.$InvoiceDownloads.'</td></tr>
											<tr><td style="padding-top:10px;border-top:1px solid #ddd;text-align:center;">'.__('Thank you for purchasing our products.').'</td></tr>
											<tr><td style="padding-top:5px;text-align:center;">'.__('If you have any questions about this invoice, please contact us').'</td></tr>
											<tr><td style="padding-top:5px;text-align:center;"><a href="'.$base_url.'">'.$base_url.'</a></td></tr>
										</table>
									</td>
								</tr>
							</table>';

				$mail->send();
				
				return 1;
			} catch (Exception $e) {
				return 0;
			}
		}
	}	
	public function checkemail(Request $request){
		$total_row = User::where('email',$request->email)->count();	
		$output = ['success' => false];
		if($total_row == 0){
			$output = ['success' => true];	
		}
		return response()->json($output);
	}
}
