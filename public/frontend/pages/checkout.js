var $ = jQuery.noConflict();
var payment_method = 1;

$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
    $("#new_account").on("click", function () {
		if($(this).is(":checked")){
			$("#new_account_pass").removeClass("hideclass");
			$("#password").attr("required", "");
			$("#password_confirmation").attr("required", "");
		}else if($(this).is(":not(:checked)")){
			$("#new_account_pass").addClass("hideclass");
			$("#password").removeAttr("required");
			$("#password_confirmation").removeAttr("required");
		}
    });
	
    $("#payment_method_stripe").on("click", function () {
		$("#pay_paypal").addClass("hideclass");
		$("#pay_razorpay").addClass("hideclass");
		$("#pay_mollie").addClass("hideclass");
		$("#pay_cod").addClass("hideclass");
		$("#pay_bank").addClass("hideclass");
		$("#pay_stripe").removeClass("hideclass");
    });
	
    $("#payment_method_paypal").on("click", function () {
		$("#pay_stripe").addClass("hideclass");
		$("#pay_razorpay").addClass("hideclass");
		$("#pay_mollie").addClass("hideclass");
		$("#pay_cod").addClass("hideclass");
		$("#pay_bank").addClass("hideclass");
		$("#pay_paypal").removeClass("hideclass");
    });
	
    $("#payment_method_razorpay").on("click", function () {
		$("#pay_stripe").addClass("hideclass");
		$("#pay_paypal").addClass("hideclass");
		$("#pay_mollie").addClass("hideclass");
		$("#pay_cod").addClass("hideclass");
		$("#pay_bank").addClass("hideclass");
		$("#pay_razorpay").removeClass("hideclass");
    });
	
    $("#payment_method_mollie").on("click", function () {
		$("#pay_stripe").addClass("hideclass");
		$("#pay_paypal").addClass("hideclass");
		$("#pay_razorpay").addClass("hideclass");
		$("#pay_cod").addClass("hideclass");
		$("#pay_bank").addClass("hideclass");
		$("#pay_mollie").removeClass("hideclass");
    });
	
    $("#payment_method_cod").on("click", function () {
		$("#pay_stripe").addClass("hideclass");
		$("#pay_paypal").addClass("hideclass");
		$("#pay_razorpay").addClass("hideclass");
		$("#pay_mollie").addClass("hideclass");
		$("#pay_bank").addClass("hideclass");
		$("#pay_cod").removeClass("hideclass");
    });
	
    $("#payment_method_bank").on("click", function () {
		$("#pay_stripe").addClass("hideclass");
		$("#pay_paypal").addClass("hideclass");
		$("#pay_razorpay").addClass("hideclass");
		$("#pay_mollie").addClass("hideclass");
		$("#pay_cod").addClass("hideclass");
		$("#pay_bank").removeClass("hideclass");
    });
	
    $(".shipping_method").on("click", function () {
		var totalWithComma = $(this).data('total');
		var shipping_fee = $(this).data('shippingfee');
		var seller_count = $(this).data('seller_count');
		var shippingfee = shipping_fee*seller_count;
		
		var total = removeCommas(totalWithComma);
		
		var TotalShippingfee = addCommas(parseFloat(total) + parseFloat(shippingfee));
		
		$(".shipping_fee").text(shippingfee);
		$(".total_amount").text(TotalShippingfee);
    });

	function checkemail(value){
		var checkout_btn = $('.checkout_btn').html();
		//alert()
		return $.ajax({
			type : 'POST',
			url: base_url + '/frontend/checkemail',
			data: {email:value},
			beforeSend: function() {
				$('.checkout_btn').html('<span class="spinner-border spinner-border-sm"></span> Please Wait...');
			},
			success: function (response) {	
				$('.checkout_btn').html(checkout_btn);
				if(response.success == true){
					$("#checkout_formid").submit();
				}else{
					$('.email_error').html('This email is already exists.')
					return false;
				}
			}
		});
	}
	function delay(callback, ms) {
		var timer = 0;
		return function() {
		  var context = this, args = arguments;
		  clearTimeout(timer);
		  timer = setTimeout(function () {
			callback.apply(context, args);
		  }, ms || 0);
		};
	  }
	  
	  
	  // Example usage:
	  
	  $('#coupon').on('keyup touchend', delay(function (e) {
		var value = $(this).val();
		if (value) {
			$.ajax({
				type : 'POST',
				url: base_url + '/backend/validateCoupon',
				data: 'coupon='+value + '&active=true',
				success: function (res) {
					if(res.status == true){
						calculateAmounts(res.data.percentage);
					}else{
						calculateAmounts(null);
						onErrorMsg(res.message);
					
					}
				}
			});
		} else {
			calculateAmounts(null);
		}
	  }, 500));

	  function calculateAmounts(discount){
		var productsAmount = $('#coupon').attr('data-products-amount');
		var shippingAmount = $('#coupon').attr('data-shipping-amount');
		var discountAmount = 0;
		$('#discountPercent').text('');
		$('#total-discount').text(currency + "0.00");
		if (discount != null && parseFloat(discount) > 0) {
			discountAmount = productsAmount * discount/100;
			$('#discountPercent').text(parseFloat(discount).toFixed(2) + " % OFF");
			$('#total-discount').text(currency + parseFloat(discountAmount).toFixed(2));
		}

		var totalAmount = parseFloat(productsAmount - discountAmount) + parseFloat(shippingAmount);

		$('.total-price').text(currency + parseFloat(totalAmount).toFixed(2));


	  }

	$("#checkout_submit_form").on("click", function () {
		
		payment_method = $('input[name="payment_method"]:checked').val();
		$('.email_error').html('');
		let new_account = $('input[name="new_account"]:checked').val();

		if(new_account == 'on'){
			let _email = $('input[name="email"]').val();
			checkemail(_email)
		}else{
			$("#checkout_formid").submit();
		}
    });
});

function addCommas(nStr){
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function removeCommas(nStr){

	if(typeof nStr === 'string'){
		var num = nStr.replace(/,/g, "");
	}else{
		var num = nStr;
	}
	
    return num;
}

function showPerslyError() {
    $('.parsley-error-list').show();
}

jQuery('#checkout_formid').parsley({
    listeners: {
        onFieldValidate: function (elem) {
            if (!$(elem).is(':visible')) {
                return true;
            }
            else {
                showPerslyError();
                return false;
            }
        },
        onFormSubmit: function (isFormValid, event) {
            if (isFormValid) {
				if(payment_method == 5){
					onPaymentByRazorpay();
				}else{
					onConfirmMakeOrder();
				}
				
                return false;
            }
        }
    }
});




function onPaymentByRazorpay() {
	var sVal = $(".total_amount").text();
	var totalVal = removeCommas(sVal);
	var amount = parseFloat(totalVal);
	var razorpayAmount = amount.toFixed(2) * 100;

	var	options = {
			"key": razorpay_key_id,
			"amount": razorpayAmount,
			"currency": razorpay_currency,
			"name": site_name, //merchant user name
			"handler": function(response) {
				var razorpay_payment_id = response.razorpay_payment_id;
				$("#razorpay_payment_id").val(razorpay_payment_id);
				if(razorpay_payment_id != ''){
					onConfirmMakeOrder();
				}
			},
			"prefill": {
				"name": $("#name").val(), //user name
				"email": $("#email").val(), //user email
			},
			"theme": {
				"color": theme_color,
			},
			"modal": {
				"ondismiss": function(e) {}
			}
		};
	var rzp1 = new Razorpay(options);
	rzp1.open();		
}

function onConfirmMakeOrder() {

	var payment_method = $('input[name="payment_method"]:checked').val();

 	if(payment_method == 3){
		if(isenable_stripe == 1){
			if(validCardNumer == 0){
				$("span.payment_method_error").text(TEXT['Please type valid card number']);
				return;
			}
		}
	}else{
		$("span.payment_method_error").text('');
	}
	
	var checkout_btn = $('.checkout_btn').html();
	
    $.ajax({
		type : 'POST',
		url: base_url + '/frontend/make_order',
		data: $('#checkout_formid').serialize(),
		beforeSend: function() {
			$('.checkout_btn').html('<span class="spinner-border spinner-border-sm"></span> Please Wait...');
		},
		success: function (response) {		
			var msgType = response.msgType;
			var msg = response.msg;

			if (msgType == "success") {
				$("#checkout_formid").find('span.error-text').text('');
				
				//Stripe
				if(payment_method == 3){
					if(isenable_stripe == 1){
						if(response.intent != ''){
							onConfirmPayment(response.intent, msg);
						}
					}
				
				//Paypal
				}else if(payment_method == 4){
					if(response.intent != ''){
						window.location.href = response.intent;
					}
				
				//Mollie
				}else if(payment_method == 6){
					if(response.intent != ''){
						window.location.href = response.intent;
					}
				}else{
					//onSuccessMsg(msg);
					window.location.href = base_url + '/thank';
				}

			} else {
				$.each(msg, function(prefix, val){
					if(prefix == 'oneError'){
						onErrorMsg(val[0]);
					}else{
						$('span.'+prefix+'_error').text(val[0]);
					}
				});
			}
			
			$('.checkout_btn').html(checkout_btn);
		}
	});
}