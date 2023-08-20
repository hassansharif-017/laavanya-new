@extends('layouts.backend')

@section('title', __('Testimonial'))

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
								<span>{{ __('Testimonials') }}</span>
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
							<div class="table-responsive">
								<table class="table table-borderless table-theme" style="width:100%;">
									<thead>
										<tr>
											<th class="checkboxlist text-center" style="width:5%"><input class="tp-check-all checkAll" type="checkbox"></th>
											<th class="text-left" style="width:15%">Name</th>
											<th class="text-center" style="width:5%">Designation</th>
											<th class="text-left" style="width:30%">Description</th>
											<th class="text-center" style="width:10%">photo</th>
											<th class="text-center" style="width:5%">{{ __('Action') }}</th>
										</tr>
									</thead>
									<tbody>
										@if (count($datalist)>0)
										@foreach($datalist as $row)
										<tr>
											<td class="checkboxlist text-center"><input name="item_ids[]" value="{{ $row->id }}" class="tp-checkbox selected_item" type="checkbox"></td>
											<td class="text-left">{{ $row->name }}</td>
											<td class="text-center">{{ $row->designation }}</td>
											<td class="text-left">{{ $row->description }}</td>
											<td class="text-left">{{ $row->image }}</td>

											<td class="text-center">
												<div class="btn-group action-group">
													<a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a onclick="onDelete({{ $row->id }})" class="dropdown-item" href="javascript:void(0);">{{ __('Delete') }}</a>
													</div>
												</div>
											</td>
										</tr>
										@endforeach
										@else
										<tr>
											<td class="text-center" colspan="7">{{ __('No data available') }}</td>
										</tr>
										@endif
									</tbody>
								</table>
							</div>
							<div class="row mt-15">
								<div class="col-lg-12">
									{{ $datalist->links() }}
								</div>
							</div>
						</div>
					</div>
					<!--/Data grid/-->

					
					<!--/Data Entry Form-->
					<div id="form-panel" class="card-body dnone">
						<form novalidate="" data-validate="parsley" id="DataEntry_formId">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">{{ __('Name') }}<span class="red">*</span></label>
										<input type="text" name="name" id="name" class="form-control parsley-validated" data-required="true">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="email">Designation<span class="red">*</span></label>
										<input type="text" name="designation" id="designation" class="form-control parsley-validated" data-required="true">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="address">Description</label>
										<textarea name="description" id="description" class="form-control" rows="3"></textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="photo_thumbnail">{{ __('Profile Photo') }}</label>
										<div class="tp-upload-field">
											<input type="text" name="photo" id="photo_thumbnail" class="form-control" readonly>
											<a id="on_thumbnail" href="javascript:void(0);" class="tp-upload-btn"><i class="fa fa-window-restore"></i>{{ __('Browse') }}</a>
										</div>
										<em>Recommended image size width: 200px and height: 200px.</em>
										<div id="remove_photo_thumbnail" class="select-image">
											<div class="inner-image" id="view_photo_thumbnail"></div>
											<a onClick="onMediaImageRemove('photo_thumbnail')" class="media-image-remove" href="javascript:void(0);"><i class="fa fa-remove"></i></a>
										</div>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label for="status_id">{{ __('Active/Inactive') }}<span class="red">*</span></label>
										<select name="status_id" id="status_id" class="chosen-select form-control">
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
	var TEXT = [];
	TEXT['Do you really want to delete this record'] = "{{ __('Do you really want to delete this record') }}";
	TEXT['Do you really want to delete this records'] = "{{ __('Do you really want to delete this records') }}";
	TEXT['Please select action'] = "{{ __('Please select action') }}";
	TEXT['Please select record'] = "{{ __('Please select record') }}";
</script>
<script src="{{asset('public/backend/pages/testimonials.js')}}"></script>
<script src="{{asset('public/backend/pages/global-media.js')}}"></script>
@endpush