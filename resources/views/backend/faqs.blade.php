@extends('layouts.backend')

@section('title', __('FAQs'))

@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">
		@php $vipc = vipc(); @endphp
		@if($vipc['bkey'] == 0)
		@include('backend.partials.vipc')
		@else
		<div class="row mt-25">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-lg-6">
								<span>{{ __('FAQs') }}</span>
							</div>
							<div class="col-lg-6">
								<div class="float-right">
									<a onClick="onFormPanel()" href="javascript:void(0);" class="btn blue-btn btn-form float-right"><i class="fa fa-plus"></i> {{ __('Add New') }}</a>
									<a onClick="onListPanel()" href="javascript:void(0);" class="btn warning-btn btn-list float-right dnone"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
								</div>
							</div>
						</div>
					</div>
					<!--Data grid-->
					<div id="list-panel" class="card-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group bulk-box">
									<select id="bulk-action" class="form-control">
										<option value="">{{ __('Select Action') }}</option>
										<option value="delete">{{ __('Delete Permanently') }}</option>
									</select>
									<button type="submit" onClick="onBulkAction()" class="btn bulk-btn">{{ __('Apply') }}</button>
								</div>
							</div>
							<div class="col-lg-3"></div>
							<div class="col-lg-5">
								<div class="form-group search-box">
									<input id="search" name="search" type="text" class="form-control" placeholder="{{ __('Search') }}...">
									<button type="submit" onClick="onSearch()" class="btn search-btn">{{ __('Search') }}</button>
								</div>
							</div>
						</div>
						<div id="tp_datalist">
							@include('backend.partials.faqs_table')
						</div>
					</div>
					<!--/Data grid/-->

					
					<!--/Data Entry Form-->
					<div id="form-panel" class="card-body dnone">
						<form novalidate="" data-validate="parsley" id="DataEntry_formId">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="name">{{ __('Question') }}<span class="red">*</span></label>
										<input type="text" name="question" id="question" class="form-control parsley-validated" data-required="true">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="address">Answer<span class="red">*</span></label>
										<textarea name="answer" id="answer" class="form-control" rows="3" data-required="true"></textarea>
									</div>
								</div>
							</div>

							<div class="row">
                                <div class="col-md-6">
									<div class="form-group">
										<label for="name">{{ __('Display Order') }}<span class="red">*</span></label>
										<input type="number" name="display_order" id="display_order" placeholder="Please provide number between (1 - 1000)" class="form-control parsley-validated" data-required="true">
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label for="status">{{ __('Active/Inactive') }}<span class="red">*</span></label>
										<select name="status" id="status" class="chosen-select form-control">
									<option value="active">Active</option>
									<option value="inactive">In Active</option>
										</select>
									</div>
								</div>
							</div>
							
							<input type="text" id="RecordId" name="RecordId" class="dnone"/>
							
							<div class="row tabs-footer mt-15">
								<div class="col-lg-12">
									<a id="submit-form" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
									<a onClick="onListPanel()" href="javascript:void(0);" class="btn danger-btn">{{ __('Cancel') }}</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
<!-- /main Section -->

<!--Global Media-->
@include('backend.partials.global_media')
<!--/Global Media/-->
@endsection

@push('scripts')
<!-- css/js -->
<script type="text/javascript">
var media_type = 'Testimonial';
	var TEXT = [];
	TEXT['Do you really want to delete this record'] = "{{ __('Do you really want to delete this record') }}";
	TEXT['Do you really want to delete these records'] = "{{ __('Do you really want to delete these records') }}";
	TEXT['Do you really want to edit this record'] = "{{ __('Do you really want to edit this record') }}";
	TEXT['Please select action'] = "{{ __('Please select action') }}";
	TEXT['Please select record'] = "{{ __('Please select record') }}";
</script>
<script src="{{asset('public/backend/pages/faqs.js')}}"></script>
<script src="{{asset('public/backend/pages/global-media.js')}}"></script>
@endpush