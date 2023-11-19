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
	

	<section class="section product-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">

						<h5></h5>

						
		
						<h2></h2>

					</div>
				</div>
			</div>
			<div class="row ">
				@foreach ($new_products as $row)
				<div class="col-lg-3">
					<div class="item-card">
						<div class="item-image">
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@php 
									$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price);
								@endphp
							<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
							@endif
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
								<img src="{{ asset('public/media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" />
							</a>
						</div>
						<div class="item-title">
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">{{ str_limit($row->title) }}</a>
						</div>

						
						<div class="item-sold">
							{{ __('Sold By') }} <a href="{{ route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]) }}">{{ str_limit($row->shop_name) }}</a>
						</div>
						<div class="item-pric-card">
							@if($row->sale_price != '')
								@if($gtext['currency_position'] == 'left')
								<div class="new-price">{{ $gtext['currency_icon'] }}{{ number_format($row->sale_price) }}</div>
								@else
								<div class="new-price">{{ number_format($row->sale_price) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@if($gtext['currency_position'] == 'left')
								<div class="old-price">{{ $gtext['currency_icon'] }}{{ number_format($row->old_price) }}</div>
								@else
								<div class="old-price">{{ number_format($row->old_price) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
						</div>
						<div class="item-card-bottom">
							<a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn add-to-cart addtocart">{{ __('Add To Cart') }}</a>
							<ul class="item-cart-list">
								<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
								<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
							</ul>
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



</main>

@endsection

@push('scripts')
<script type="text/javascript">
var brand_id = "{{ isset($params) ? $params['brand_id'] : 0 }}";
</script>
<script src="{{asset('public/frontend/pages/brand.js')}}"></script>
@endpush	