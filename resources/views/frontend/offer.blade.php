@extends('layouts.frontend')


@php $gtext = gtext(); @endphp


@section('header')
@include('frontend.partials.header')
@endsection

@section('content')

<main class="main">
	<!-- Page Breadcrumb -->
	<div class="breadcrumb-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
							<li class="breadcrumb-item active" aria-current="page"></li>
						</ol>
					</nav>
				</div>
				<div class="col-lg-6">
					<div class="page-title">
						<h1></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Page Breadcrumb/ -->
	
	<!-- Offer Section -->


	<section class="section offer-section" style="background-color:#F3ECDA">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-heading">

						<h5>Offers</h5>

						

						<h2>Offers Section</h2>

					</div>
				</div>
			</div>

			<div class="row">
				@foreach ($Offerad as $row)
				@php $aRow = json_decode($row->desc); @endphp
				<div class="col-lg-4">
					<div class="offer-card" style="background:{{ $aRow->bg_color == '' ? '#daeac5' : $aRow->bg_color }};">
						@if($aRow->text_1 != '')
						<div class="offer-heading">
							<h2>{{ $aRow->text_1 }}</h2>
						</div>
						@endif
						@if($aRow->text_1 != '')
						<div class="offer-body">
							<p>{{ $aRow->text_2 }}</p>
						</div>
						@endif
						<div class="offer-footer">
							@if($aRow->button_text != '')
							<a href="{{ $row->url }}" class="btn theme-btn" {{ $aRow->target =='' ? '' : "target=".$aRow->target }}>{{ $aRow->button_text }}</a>
							@endif
							<div class="offer-image">
								<img src="{{ asset('public/media/'.$row->image) }}" alt="{{ $aRow->text_1 }}" />
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>

			
			@if (count($globalFaq) > 0)
			<h2 class="text-center mb-4 mt-5">Frequently Asked Questions</h2>
			<div class="accordion" id="faqAccordion">
				@foreach ($globalFaq as $indx => $faq)
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne{{$faq['id']}}">
							<button class="accordion-button {{ $indx == 0? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$faq['id']}}" aria-expanded="{{ $indx == 0? 'true' : 'false'}}" aria-controls="collapseOne{{$faq['id']}}">
							Question {{ $indx + 1}}: {{ $faq['question'] }}
							</button>
						</h2>
						<div id="collapseOne{{$faq['id']}}" class="accordion-collapse collapse {{ $indx == 0? 'show' : ''}}" aria-labelledby="{{$faq['id']}}" data-bs-parent="#faqAccordion">
							<div class="accordion-body">
								<p class="mb-0">{{ $faq['answer'] }}</p>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			@endif
		</div>
	</section>


	<!-- /Offer Section/ -->


</main>

@endsection

@push('scripts')
<script type="text/javascript">
var brand_id = "{{ isset($params) ? $params['brand_id'] : 0 }}";
</script>
<script src="{{asset('public/frontend/pages/brand.js')}}"></script>
@endpush	