
	<!-- Home Slider -->
	@if($section1->is_publish == 1)
	<section class="slider-section">
		<div class="home-slider owl-carousel">
			<!-- Slider Item -->
			@foreach ($slider as $row)
			@php $aRow = json_decode($row->desc); @endphp
			<div class="single-slider">
				<div class="slider-screen h1-height" style="background-image: url({{ asset('public/media/'.$row->image) }});">
					<div class="container">
						<div class="row">
							<div class="order-1 col-sm-12 order-sm-1 col-md-6 order-md-0 col-lg-5 order-lg-0">
								<div class="slider-content">
									<h1 style="color: #E4D79F">{{ $row->title }}</h1>
									@if($aRow->sub_title != '')
									<p style="color: #E4D79F" class="relative">{{ $aRow->sub_title }}</p>
									@endif
									
									@if($aRow->button_text != '')
									<a href="{{ $row->url }}" class="btn theme-btn"  {{ $aRow->target =='' ? '' : "target=".$aRow->target }}>{{ $aRow->button_text }}</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			<!-- /Slider Item/ -->
		</div>
	</section>
	@endif
	<!-- /Home Slider/ -->

	<!-- Offer Section -->
	@if($section3->is_publish == 1)

	<section class="section offer-section" style="background-color: #F3ECDA; padding-top:50px">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				<div class="section-heading text-center">					
					<div class="modern-div22" >
            <div class="header">

              <img class="svg-icon" src="public/media/flower-header.svg" alt="">
              <h1>Our Best Seller</h1>
              <img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
              <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->
            </div>
            </div>
					</div>
				</div>
			</div>

			<div class="row owl-carousel caro-common category-carousel">
				@foreach ($popular_products as $row)
				<div class="col-lg-12">
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
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>

	@endif
	
  
		 
	
	



