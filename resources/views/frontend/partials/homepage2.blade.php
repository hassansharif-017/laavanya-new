<main class="main {{ $PageVariation['home_variation'] }}">
  <!-- Home Slider -->
  <!-- <div id="html_{{ $PageVariation['home_variation'] }}">
  </div> -->

  @if($section1->is_publish == 1)
  <section class="slider-section">
    <div class="home-slider owl-carousel">
      <!-- Slider Item -->
      @foreach ($slider as $row)
      @php $aRow = json_decode($row->desc); @endphp
      <div class="single-slider">
        <div class="slider-screen h1-height" style="background-image: url({{ asset('public/media/'.$row->image) }});">
          <div class="container" style="margin-left: 20px !important;">
            <div class="row">
              <div class="order-1 col-sm-12 order-sm-1 col-md-6 order-md-0 col-lg-5 order-lg-0">
                <div class="slider-content">
                  
                  @if($row->title == 'Muslin Print')
                  <h1 style="color: #E4D79F">A Dream online fabric store in Gurgaon- Laavanya</h1>
                  @else
                  <h2 style="color: #E4D79F">{{ $row->title }}</h2>
                  @endif
                  @if($aRow->sub_title != '')
                  <p style="color: #E4D79F" class="relative">{{ $aRow->sub_title }}</p>
                  @endif

                  @if($aRow->button_text != '')
                  <a href="{{ $row->url }}" class="btn theme-btn" {{ $aRow->target =='' ? '' : "target=".$aRow->target }}>{{ $aRow->button_text }}</a>
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
          <div class="swirl-short-videos-M" data-playlist="z1uBtU" data-playlist-name="Test"></div>
          <div id="swirl-short-videos" data-code="feoaxhly"  data-sw="0"></div>
        </div>
      </div>
      <br />
      <br />
      <div class="row">
        <div class="col-md-12">

          <div class="section-heading text-center">


            <div class="modern-div22">
              <div class="header">

                <img class="svg-icon" src="public/media/flower-header.svg" alt="">
                <h2>Our Best Seller</h2>
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
          <div class="item-card" style="height: 320px;">
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

  
  <section class="section offer-section" style="background-color: #F3ECDA;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading text-center">
            <div class="modern-div22">
              <div class="header">

                <img class="svg-icon" src="public/media/flower-header.svg" alt="">
                <h2>Our Fabric Collection</h2>
                <img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
                <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        @php
         shuffle($popular_products);
         $popular_products = collect($popular_products)->take(4);
        @endphp
        @foreach ($popular_products as $row)
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="item-card" style="height: 320px;">
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
      <div class="row">
        <div class="col-md-12 text-center">
          <a href="{{ route('frontend.products') }}" class="btn theme-btn">
            View More
          </a>
          <br />
        </div>
      </div>
    </div>
    <br />
  </section>
  <!-- /Offer Section/ -->

  <section class="section offer-section" style="background-color: #F3ECDA;display: none;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading text-center">
            <div class="modern-div22">
              <div class="header">

                <img class="svg-icon" src="public/media/flower-header.svg" alt="">
                <h2>Shop By Fabric</h2>
                <img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
                <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/145/chanderi-2"> <img style="border-radius: 50% !important;" src="public/frontend/images/chanderi.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Chanderi</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/64/chinon"> <img style="border-radius: 50% !important;" src="public/frontend/images/chinnonchiffon.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Chinnon Chiffon</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/62/cotton"> <img style="border-radius: 50% !important;" src="public/frontend/images/Cotton.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Cotton</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/73/crepe"> <img style="border-radius: 50% !important;" src="public/frontend/images/Crepe.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Crepe</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/71/georgette"> <img style="border-radius: 50% !important;" src="public/frontend/images/Georgette.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Georgette</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/97/jackquard"> <img style="border-radius: 50% !important;" src="public/frontend/images/Jacquard.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Jacquard</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/70/organza-satin"> <img style="border-radius: 50% !important;" src="public/frontend/images/liquidorganza.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Liquid Organza</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/63/muslin"> <img style="border-radius: 50% !important;" src="public/frontend/images/muslin.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Muslin</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/68/satin-2"> <img style="border-radius: 50% !important;" src="public/frontend/images/satin.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Satin</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/94/velvet"> <img style="border-radius: 50% !important;" src="public/frontend/images/velvet.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Velvet</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/110/viscose-silk"> <img style="border-radius: 50% !important;" src="public/frontend/images/viscosesilk.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Viscose Silk</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/product-category/111/voile"> <img style="border-radius: 50% !important;" src="public/frontend/images/voile.png" alt="Product"> </a>

          </div>
          <p style="text-align: center; padding-top: 15px;">Voile</p>
        </div>

      </div>
    </div>






    </div>
  </section>


  <section class="section offer-section" style="background-color: #F3ECDA; display: none;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="section-heading text-center">


            <div class="modern-div22">
              <div class="header">

                <img class="svg-icon" src="public/media/flower-header.svg" alt="">
                <h2>Shop By Pattern</h2>
                <img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
                <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->


              </div>
            </div>


          </div>


        </div>



        <div class="col-md-7 pt-4 pt-md-0 " style="border-width: 0px;">
          <div>
            <div class="tns-carousel-inner" data-carousel-options="{&quot;nav&quot;: false, &quot;controlsContainer&quot;: &quot;#for-women&quot;}">

              <div>
                <div class="row mx-n2">
                  <div class="col-lg-4 col-6 " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
                    <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
                      <a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden" href="https://laavanya-gracefullyyou.in/search?search=Embroidery&category="><img src="public/frontend/images/embroidery.png" alt="Product"></a>
                      <div style="background-color: #F3ECDA !important;" class="card-body py-2">
                        <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Embroidery</a></h3>
                        <div class="d-flex justify-content-center">
                          <a href="https://laavanya-gracefullyyou.in/search?search=Embroidery&category=">
                            <div class="product-price"><span class=" btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div>
                          </a>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6 " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
                    <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
                      <a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden" href="https://laavanya-gracefullyyou.in/search?search=Hakoba&category="><img src="public/frontend/images/Hakoba.png" alt="Product"></a>
                      <div style="background-color: #F3ECDA !important;" class="card-body py-2">
                        <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Hakoba</a></h3>
                        <div class="d-flex justify-content-center">
                          <a href="https://laavanya-gracefullyyou.in/search?search=Hakoba&category=">
                            <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div>
                          </a>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6 " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
                    <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
                      <a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden" href="https://laavanya-gracefullyyou.in/search?search=Ikat&category="><img src="public/frontend/images/Ikat.png" alt="Product"></a>
                      <div style="background-color: #F3ECDA !important;" class="card-body py-2">
                        <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Ikat</a></h3>
                        <div class="d-flex justify-content-center">
                          <a href="https://laavanya-gracefullyyou.in/search?search=Ikat&category=">
                            <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div>
                          </a>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6 " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
                    <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
                      <a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden" href="https://laavanya-gracefullyyou.in/search?search=Kantha&category="><img src="public/frontend/images/Kantha.png" alt="Product"></a>
                      <div style="background-color: #F3ECDA !important;" class="card-body py-2">
                        <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Kantha</a></h3>
                        <div class="d-flex justify-content-center">
                          <a href="https://laavanya-gracefullyyou.in/search?search=Kantha&category=">
                            <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div>
                          </a>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6 " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
                    <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
                      <a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden" href="https://laavanya-gracefullyyou.in/search?search=Pleated&category="><img src="public/frontend/images/Pleated.png" alt="Product"></a>
                      <div style="background-color: #F3ECDA !important;" class="card-body py-2">
                        <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Pleated</a></h3>
                        <div class="d-flex justify-content-center">
                          <a href="https://laavanya-gracefullyyou.in/search?search=Pleated&category=">
                            <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div>
                          </a>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-6 " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
                    <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
                      <a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden" href="https://laavanya-gracefullyyou.in/search?search=Shimmer&category="><img src="public/frontend/images/Shimmer.png" alt="Product"></a>
                      <div style="background-color: #F3ECDA !important;" class="card-body py-2">
                        <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Shimmer</a></h3>
                        <div class="d-flex justify-content-center">
                          <a href="https://laavanya-gracefullyyou.in/search?search=Shimmer&category=">
                            <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div>
                          </a> </a>

                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5">

          <div class="d-flex flex-column h-100 overflow-hidden rounded-3" style="background-color: #F3ECDA !important;">
            <div class="text-center" style="padding-bottom: 10px !important;">


            </div><img class="d-block w-100" src="public/frontend/images/image 49.png" alt="For Women">
          </div>
        </div>




      </div>
    </div>






    </div>
    </div>
  </section>


  <section class="section offer-section" style="background-color: #F3ECDA; display: none;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="section-heading text-center">


            <div class="modern-div22">
              <div class="header">

                <img class="svg-icon" src="public/media/flower-header.svg" alt="">
                <h2>Shop By Colour</h2>
                <img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
                <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->


              </div>
            </div>


          </div>


        </div>



        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=Beige&category="> <img style="border-radius: 50% !important;" src="public/frontend/images/Beige.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Beige</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=Black&category="> <img style="border-radius: 50% !important;" src="public/frontend/images/Black.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Black</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=blue&category"> <img style="border-radius: 50% !important;" src="public/frontend/images/Blues.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Blues</p>
        </div>

        <div class="col-lg-2 col-3">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=brown&category"> <img style="border-radius: 50% !important;" src="public/frontend/images/Browns.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Browns</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=Dyeable&category="> <img style="border-radius: 50% !important;" src="public/frontend/images/Dyeable.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Dyeable</p>
        </div>

        <div class="col-lg-2 col-3">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=green&category"> <img style="border-radius: 50% !important;" src="public/frontend/images/Greens.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Greens</p>
        </div>

        <div class="col-lg-2 col-3">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=Indigo&category="> <img style="border-radius: 50% !important;" src="public/frontend/images/Indigo.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Indigo</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=Orange&category="> <img style="border-radius: 50% !important;" src="public/frontend/images/Orange.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Orange</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=pink&category"> <img style="border-radius: 50% !important;" src="public/frontend/images/Pinks.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Pinks</p>
        </div>

        <div class="col-lg-2 col-3 ">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=red&category"> <img style="border-radius: 50% !important;" src="public/frontend/images/Reds.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Reds</p>
        </div>

        <div class="col-lg-2 col-3">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=White&category="> <img style="border-radius: 50% !important;" src="public/frontend/images/White.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">White</p>
        </div>

        <div class="col-lg-2 col-3">
          <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
            <a href="https://laavanya-gracefullyyou.in/search?search=yellow&category="> <img style="border-radius: 50% !important;" src="public/frontend/images/Yellows.png" alt="Product"> </a>

          </div>

          <p style="text-align: center; padding-top: 15px;">Yellows</p>
        </div>



      </div>
    </div>






    </div>
  </section>




  <!--Testimonial-->
@if (count($client_reviews) > 0)
    <div style="background-color: #F3ECDA; padding: 0px;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="section-heading text-center">


              <div class="modern-div22">
                <div class="header">

                  <img style="width:90px" class="svg-icon" src="public/media/flower-header.svg" alt="">
                  <h2>Client Reviews</h2>
                  <img style="width:90px" class="svg-icon" src="public/media/flower-header-right.svg" alt="">
                  <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->


                </div>
              </div>


            </div>

          </div>
        </div>
      </div>

      <div class="container">
        <div class=" owl-carousel caro-common category-carousel">
          @foreach ($client_reviews as $item)
          <div class="item">
            <div style=" display:grid; place-items:center;">
              <img class="rounded-circle shadow-1-strong mb-4" src="{{asset('public/media/' . $item->image)}}" alt="avatar" style="width: 150px;">
              <h5 class="mb-3">{{ $item->name }}</h5>
              <p>{{ $item->designation }}</p>
              <p class="text-muted" style="text-align: center;">
                <i class="fas fa-quote-left pe-2"></i>
                {{ $item->description }}
              </p>

            </div>
          </div>
          @endforeach
        </div>

      </div>
    </div>
@endif












  <section class="section" style="background-color: #F3ECDA; padding-top:75px">




    <div class="container">
      <div class="row">
        <div class="col-sm fade-in-left">
          <img src="public/frontend/images/17012023185411-home page (left).png" alt="" srcset="">
        </div>
        <div class="col-sm " style="text-align: center;">
          <img style="padding-left: 70px !important; " src="public/frontend/images/aaaa.png" alt="" srcset="">
          <h2 class="h3 pb-3">&nbsp; Handpicked Fabrics
            <br> <i>Curated </i>for You, from all <br> <i>Across India</i>
          </h2>
          <p class="fs-sm pb-3 text-muted">Choose from an extensive range of high-quality materials, printing techniques & latest designs library. </p>
          <a style="padding-bottom: 20px" href="https://laavanya-gracefullyyou.in/aboutus"> <button class="btn" style="background-color:#3FDFD0; color:white">Know More</button></a>



        </div>
        <div class="col-sm">
          <img src="public/frontend/images/17012023185407-home page (right).png" alt="" srcset="">
        </div>
      </div>
    </div>


  </section>











  <style>
    .svg-icon {
      height: 7.1rem;
      width: 7.6rem;
    }

    .round-item {
      border-radius: 50%;
      height: 14.6rem;
      width: 14.6rem;
      box-sizing: border-box;

    }

    .modern-div .items {
      left: 12%;
      right: 12%;
      top: 25%;
      bottom: 12%;
      width: 70.5rem;
      height: 20.3rem;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    .video {
      border-radius: 4.0rem;
      width: 100%;
      justify-content: center;

    }

    .image_contain {
      display: flex;
      justify-content: space-around;
      margin-top: 5rem;
    }

    .modern-div {
      width: 100%;
      padding-top: 2rem;
      position: relative;
      height: 40.8rem;
      background-color: #fffbf1;
      backdrop-filter: blur(1.95rem);
      display: inline-block;
    }

    .modern-div22 {
      width: 100%;
      position: relative;

      backdrop-filter: blur(1.95rem);
      display: inline-block;
    }

    .modern-div .header {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .modern-div22 .header {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .modern-div .header button {
      width: 11.1rem;
      padding: 1.0rem;
      height: 3.5rem;
      border-radius: 4.8rem;
      border: .1rem solid #1C1D1D;
      font-family: 'Montserrat';
      font-style: normal;
      font-weight: 600;
      font-size: 1.2rem;
      line-height: 1.7rem;
      text-align: center;
      letter-spacing: .36rem;
      text-transform: uppercase;
      color: #1C1D1D;

    }

    .modern-div h1 {
      margin: 0 1rem;
      font-family: 'Montserrat';
      font-style: normal;
      font-weight: 200;
      font-size: 3.0rem;
      line-height: 3.2rem;
      /* identical to box height, or 105% */

      text-align: center;
      letter-spacing: .1rem;
      text-transform: capitalize;

      color: #222222;


    }

    .modern-div22 h1 {
      margin: 0 1rem;
      font-family: 'EB Garamond';
      font-style: normal;
      font-weight: 150;
      font-size: 35px;
      line-height: 3.2rem;
      /* identical to box height, or 105% */

      text-align: center;
      letter-spacing: .1rem;
      text-transform: capitalize;

      color: #222222;


    }

    border-0 .rect-square-item img {
      width: 30.1rem;
      height: 35.1rem;
      border-radius: 40px;
    }

    .rect-square-item h3 {
      margin-top: 1rem;
      font-size: 1.8rem;
      line-height: 2.0rem;
      /* identical to box height, or 110% */

      letter-spacing: .36rem;
      text-transform: uppercase;

      color: #3C3C3C;

    }

    .rect-square-item p {
      font-size: 13px;
      line-height: 2.7px;
      /* identical to box height, or 208% */

      letter-spacing: 3.25px;
      text-transform: uppercase;

      color: #B86125;
    }

    a {
      font-family: Montserrat;
    }
  </style>












  <!-- Featured Categories -->
  @if($section2->is_publish == 1)
  <!-- <section class="section" style="background-color: #F3ECDA;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-heading text-center">
					
					
					<div class="modern-div22" >
            <div class="header">

              <img class="svg-icon" src="https://easyroomsearch.com/lavanya-test/lavanya/img/flower-header-left.svg" alt="">
              <h1>Shop Fabric For</h1>
              <img class="svg-icon" src="https://easyroomsearch.com/lavanya-test/lavanya/img/flower-header-left.svg" alt="">



            </div>
            </div>
						
				
					</div>
				</div>
			</div>
			<div class="row owl-carousel caro-common featured-categories">
			

			
				<div class="col-lg-12">
					<div class="featured-card">
						<div class="featured-image">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">
								<img src="https://easyroomsearch.com/lavanya-test/lavanya/updated/public/media/12012023090852-400x400-pj.png" alt="" />
							</a>
						</div>
						<div class="featured-title">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">Pajamas</a>
						</div>
					</div>
				</div>
			
				<div class="col-lg-12">
					<div class="featured-card">
						<div class="featured-image">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">
								<img src="https://easyroomsearch.com/lavanya-test/lavanya/updated/public/media/12012023091335-400x400-bl.png" alt="" />
							</a>
						</div>
						<div class="featured-title">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">Blouse</a>
						</div>
					</div>
				</div>
			
				<div class="col-lg-12">
					<div class="featured-card">
						<div class="featured-image">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">
								<img src="https://easyroomsearch.com/lavanya-test/lavanya/updated/public/media/12012023090909-400x400-kr.png" alt="" />
							</a>
						</div>
						<div class="featured-title">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">Kurti</a>
						</div>
					</div>
				</div>
			
				<div class="col-lg-12">
					<div class="featured-card">
						<div class="featured-image">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">
								<img src="https://easyroomsearch.com/lavanya-test/lavanya/updated/public/media/12012023090728-400x400-du.png" alt="" />
							</a>
						</div>
						<div class="featured-title">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">Dupatta</a>
						</div>
					</div>
				</div>
			
				<div class="col-lg-12">
					<div class="featured-card">
						<div class="featured-image">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">
								<img src="https://easyroomsearch.com/lavanya-test/lavanya/updated/public/media/12012023090748-400x400-lh.png" alt="" />
							</a>
						</div>
						<div class="featured-title">
							<a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">Lehangas</a>
						</div>
					</div>
				</div>

			
			</div>
		</div>
	</section> -->
  @endif
  <!-- /Featured Categories/ -->





  @if($home_video['is_publish'] == 1)
  <section class="section offer-section" style="background-color: #F3ECDA;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="section-heading text-center">


            <div class="modern-div22">
              <div class="header">

                <img style="width:90px" class="svg-icon" src="public/media/flower-header.svg" alt="">
                <h2>Our Journey</h2>
                <img style="width:90px" class="svg-icon" src="public/media/flower-header-right.svg" alt="">
                <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->


              </div>
            </div>


          </div>

        </div>
      </div>

      <div class="d-flex justify-content-center ">


        <iframe width="100%" height="576" src="https://www.youtube.com/embed/{{ $home_video['video_url'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

        {{-- <a href="{{ $home_video['video_url'] }}"> <img width="100%" src="{{ asset('public/media/'.$home_video['image']) }}" alt=""> </a> --}}

      </div>
    </div>
  </section>
  @endif



  {{-- <section class="section offer-section" style="background-color: #F3ECDA;">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						
							<div class="section-heading text-center">
								
										
										<div class="modern-div22" >
											<div class="header">

															<img class="svg-icon" src="public/media/flower-header.svg" alt="">
															<h1>Shop By Mood</h1>
															<img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
															<!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->


											</div>
										</div>
									
							
							</div>


					</div>


					<div class="col-md-5">

<div class="d-flex flex-column h-100 overflow-hidden rounded-3"
  style="background-color: #F3ECDA !important;">
  <div class="text-center" style="padding-bottom: 10px !important;">
	<!-- <div>
    <h2>Mood Collection</h2>
	  <h3 style="padding-bottom: 10px;" class="mb-1"></h3><a class="fs-md btn" style="background-color:#3FDFD0; color:white" href="https://easyroomsearch.com/lavanya-test/lavanya/updated/brand/8/laavanya">View All Collections</a>
	</div> -->

  </div><a class="d-none d-md-block " href="shop-grid-ls.html"><img style="height: 610px;" class="d-block w-100"
	  src="https://easyroomsearch.com/lavanya-test/lavanya/img/f4.png" alt="For Women"></a>
</div>
</div>
<!-- Product grid (carousel)-->
<div class="col-md-7 ">

  <div class="tns-outer" id="tns5-ow">
   
   

	  <div class="row">


		<div class="col-lg-4 col-6  " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
		  <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
			<a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden"
			  href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/119/florals"><img src="https://easyroomsearch.com/lavanya-test/lavanya/img/sbm/Florals.png" alt="Product"></a>
			<div style="background-color: #F3ECDA !important;" class="card-body py-2">
			  <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Florals</a></h3>
			  <div class="d-flex justify-content-center">
				  <a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/119/florals"> <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div> </a> </a>

			  </div>
			</div>
		  </div>
		</div>
		<div class="col-lg-4 col-6  " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
		  <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
			<a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden"
			  href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/120/formals"><img src="https://easyroomsearch.com/lavanya-test/lavanya/img/sbm/Formals.png" alt="Product"></a>
			<div style="background-color: #F3ECDA !important;" class="card-body py-2">
			  <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Formals</a></h3>
			  <div class="d-flex justify-content-center">
			  <a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/120/formals"> <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div> </a> </a>

			  </div>
			</div>
		  </div>
		</div>

		<div class="col-lg-4 col-6  " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
		  <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
			<a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden"
			  href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/121/indian-glam"><img src="https://easyroomsearch.com/lavanya-test/lavanya/img/sbm/indianglam.png" alt="Product"></a>
			<div style="background-color: #F3ECDA !important;" class="card-body py-2">
			  <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Indian Glam</a></h3>
			  <div class="d-flex justify-content-center">
			  <a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/121/indian-glam"> <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div> </a> </a>

			  </div>
			</div>
		  </div>
		</div>
		<div class="col-lg-4 col-6 " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
		  <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
			<a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden"
			  href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/122/plains"><img src="https://easyroomsearch.com/lavanya-test/lavanya/img/sbm/Plains.png" alt="Product"></a>
			<div style="background-color: #F3ECDA !important;" class="card-body py-2">
			  <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Plains</a></h3>
			  <div class="d-flex justify-content-center">
			  <a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/122/plains"> <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div> </a> </a>

			  </div>
			</div>
		  </div>
		</div>

		<div class="col-lg-4 col-6  " style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
		  <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
			<a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden"
			  href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/123/tie-and-dye"><img src="https://easyroomsearch.com/lavanya-test/lavanya/img/sbm/td.png" alt="Product"></a>
			<div style="background-color: #F3ECDA !important;" class="card-body py-2">
			  <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Tie and Dye</a></h3>
			  <div class="d-flex justify-content-center">
			  <a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/123/tie-and-dye"> <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div> </a> </a>

			  </div>
			</div>
		  </div>
		</div>

		<div class="col-lg-4 col-6" style=" padding-top: 5px;padding-bottom: 15px; background-color: #F3ECDA !important;">
		  <div class="card product-card card-static border-0" style="background-color: #F3ECDA !important;">
			<a style="background-color: #F3ECDA !important;" class="card-img-top d-block overflow-hidden"
			  href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/124/traditional"><img src="https://easyroomsearch.com/lavanya-test/lavanya/img/sbm/Traditional.png" alt="Product"></a>
			<div style="background-color: #F3ECDA !important;" class="card-body py-2">
			  <h3 class="product-title fs-sm"><a href="shop-single-v1.html">Traditional</a></h3>
			  <div class="d-flex justify-content-center">
			  <a href="https://easyroomsearch.com/lavanya-test/lavanya/updated/product-category/124/traditional"> <div class="product-price"><span class="btn" style="background-color:#3FDFD0; color:white">Shop Now</span></div> </a> </a>

			  </div>
			</div>
		  </div>
		</div>
	  </div>
   
  </div>
</div>

				</div>
			</div>
		</section>	 --}}
  <!-- /Deals Section/ -->
</main>