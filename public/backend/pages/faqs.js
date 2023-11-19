var $ = jQuery.noConflict();
var RecordId = '';
var BulkAction = '';
var ids = [];

$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	resetForm("DataEntry_formId");

	$("#submit-form").on("click", function () {
		$("#DataEntry_formId").submit();
	});

	$(document).on('click', '.pagination a', function (event) {
		event.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
		onPaginationDataLoad(page);
	});

	$('input:checkbox').prop('checked', false);

	$(".checkAll").on("click", function () {
		$("input:checkbox").not(this).prop("checked", this.checked);
	});

	$("#is_publish").chosen();
	$("#is_publish").trigger("chosen:updated");


});

function onCheckAll() {
	$(".checkAll").on("click", function () {
		$("input:checkbox").not(this).prop("checked", this.checked);
	});
}

function onPaginationDataLoad(page) {
	$.ajax({
		url: base_url + "/backend/getFaqsTableData?page=" + page,
		success: function (data) {
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onRefreshData() {
	$.ajax({
		url: base_url + "/backend/getFaqsTableData",
		success: function (data) {
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onSearch() {
	var search = $("#search").val();
	$.ajax({
		url: base_url + "/backend/getFaqsTableData?search=" + search,
		success: function (data) {
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function resetForm(id) {
	$('#' + id).each(function () {
		this.reset();
	});

	$("#satus").trigger("chosen:updated");

	$("#view_thumbnail_image").html('');
	$("#remove_f_thumbnail").hide();
	$("#f_thumbnail_thumbnail").val('');
}

function onListPanel() {
	$('.parsley-error-list').hide();
	$('#list-panel, .btn-form').show();
	$('#form-panel, .btn-list').hide();
}

function onFormPanel() {
	resetForm("DataEntry_formId");
	RecordId = '';

	$("#is_publish").trigger("chosen:updated");

	$('#list-panel, .btn-form').hide();
	$('#form-panel, .btn-list').show();
}

function onEditPanel() {
	$('#list-panel, .btn-form').hide();
	$('#form-panel, .btn-list').show();
}

function showPerslyError() {
	$('.parsley-error-list').show();
}

jQuery('#DataEntry_formId').parsley({
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
				onConfirmWhenAddEdit();
				return false;
			}
		}
	}
});

function onConfirmWhenAddEdit() {

	$.ajax({
		type: 'POST',
		url: base_url + '/backend/saveFaqsData',
		data: $('#DataEntry_formId').serialize(),
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if (msgType == "success") {
				resetForm("DataEntry_formId");
				onRefreshData();
				onSuccessMsg(msg);
				onListPanel();
			} else {
				onErrorMsg(msg);
			}

			onCheckAll();
		}
	});
}

function onEdit(id) {
	RecordId = id;
	var msg = "Do you really want to edit this record";//TEXT["Do you really want to edit this record"];
	onCustomModal(msg, "onLoadEditData");
}

function onLoadEditData() {

	$.ajax({
		type: 'POST',
		url: base_url + '/backend/getFaqById',
		data: 'id=' + RecordId,
		success: function (response) {
			var data = response;
			$("#RecordId").val(data.id);
			$("#question").val(data.question);
			$("#answer").val(data.answer);
			$("#status").val(data.status).trigger("chosen:updated");
			$("#display_order").val(data.display_order);
			onEditPanel();
		}
	});
}

function onDelete(id) {
	RecordId = id;
	var msg = TEXT["Do you really want to delete this record"];
	onCustomModal(msg, "onConfirmDelete");
}

function onConfirmDelete() {

	$.ajax({
		type: 'POST',
		url: base_url + '/backend/deleteFaq',
		data: 'id=' + RecordId,
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if (msgType == "success") {
				onSuccessMsg(msg);
				onRefreshData();
			} else {
				onErrorMsg(msg);
			}

			onCheckAll();
		}
	});
}

function onBulkAction() {
	ids = [];
	$('.selected_item:checked').each(function () {
		ids.push($(this).val());
	});

	if (ids.length == 0) {
		var msg = TEXT["Please select record"];
		onErrorMsg(msg);
		return;
	}

	BulkAction = $("#bulk-action").val();
	if (BulkAction == '') {
		var msg = TEXT["Please select action"];
		onErrorMsg(msg);
		return;
	}
	console.log(TEXT);

	if (BulkAction == 'publish') {
		var msg = TEXT["Do you really want to publish this records"];
	} else if (BulkAction == 'draft') {
		var msg = TEXT["Do you really want to draft this records"];
	} else if (BulkAction == 'delete') {
		var msg = TEXT["Do you really want to delete these records"];
	}

	onCustomModal(msg, "onConfirmBulkAction");
}

function onConfirmBulkAction() {

	$.ajax({
		type: 'POST',
		url: base_url + '/backend/bulkActionFaqs',
		data: 'ids=' + ids + '&BulkAction=' + BulkAction,
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if (msgType == "success") {
				onSuccessMsg(msg);
				onRefreshData();
				ids = [];
			} else {
				onErrorMsg(msg);
			}

			onCheckAll();
		}
	});
}


function onMediaImageRemove(type) {
	$('#f_thumbnail_thumbnail').val('');
	$("#remove_f_thumbnail").hide();
	$("#view_thumbnail_image").html('');
}

$("#media_select_file").on("click", function () {

	var thumbnail = $("#thumbnail").val();
	if (thumbnail != '') {
		$("#f_thumbnail_thumbnail").val(thumbnail);
		$("#view_thumbnail_image").html('<img src="' + public_path + '/media/' + thumbnail + '">');
	}

	$("#remove_f_thumbnail").show();
	$('#global_media_modal_view').modal('hide');
});

