var $ = jQuery.noConflict();

$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	onViewCartData();

	$(document).on("click", ".btn_quantity_update", function() {
        let row_id = $(this).data('rowid');
        let _qty = $('#quantity-' + row_id).val();
        let is_variation_size = $(this).data('size');
        let stock = $(this).data('stock');
        //alert(is_variation_size)
        let oldvalue = $(this).data('oldvalue');
        if ((_qty == undefined) || (_qty == '') || (_qty <= 0)) {
            onErrorMsg('Please enter quantity.');
            return;
        }
        if (is_variation_size != 'meters' && _qty.indexOf('.') != -1) {
            onErrorMsg('Invalid quantity value.');
            return;
        }
        if (_qty > stock) {
            onErrorMsg('Invalid quantity value.');
            $(this).val(oldvalue)
            return;
        }
        $.ajax({
            type: 'GET',
            url: base_url + '/frontend/update-quantity/' + _qty + '/' + row_id,
            dataType: "json",
            success: function(response) {
                var msgType = response.msgType;
                var msg = response.msg;

                if (msgType == "success") {
                    onSuccessMsg(msg);
                    window.setTimeout(function() { location.reload() }, 1000)
                } else {
                    onErrorMsg(msg);
                }
                //onViewCart();
            }
        });
    });
});

function onViewCartData() {

    $.ajax({
		type : 'GET',
		url: base_url + '/frontend/viewcart_data',
		dataType:"json",
		success: function (data) {

			$(".viewcart_price_total").text(data.price_total);
			$(".viewcart_discount").text(data.discount);
			$(".viewcart_tax").text(data.tax);
			$(".viewcart_sub_total").text(data.sub_total);
			$(".viewcart_total").text(data.total);
		}
	});
}

function onRemoveToCart(id) {
	var rowid = $("#removetoviewcart_"+id).data('id');

	$.ajax({
		type : 'GET',
		url: base_url + '/frontend/remove_to_cart/'+rowid,
		dataType:"json",
		success: function (response) {
			
			var msgType = response.msgType;
			var msg = response.msg;

			if (msgType == "success") {
				onSuccessMsg(msg);
				$('#row_delete_'+id).remove();
			} else {
				onErrorMsg(msg);
			}
			
			onViewCartData();
			onViewCart();
		}
	});
}

