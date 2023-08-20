@extends('layouts.frontend')


@php $gtext = gtext(); @endphp



@section('header')
@include('frontend.partials.header')
@endsection

@section('content')




<main class="page-wrapper" style="background-color: #F3ECDA;">
 
   



      <!-- 
<style>

  #abt1{

    position: absolute;
width: 1200px;
height: 351px;
left: 0px;
top: 201px;

background: linear-gradient(97.08deg, #152745 4.6%, #081936 93.91%);
  }

  #abt2{

    position: absolute;
width: 298px;
height: 148px;
left: 451px;
top: 102px;
  }

</style>
 -->






      <section style="padding:0px !important;" class="section offer-section">
        <!-- <div class="col-md-12 bg-position-center bg-size-cover bg-secondary"
          style="min-height: 25rem; background-image: url(https://easyroomsearch.com/lavanya-test/lavanya/img/aboutusf.png);">

        </div> -->

        <img  src="public/frontend/images/aboutbanner.jpg" alt="" srcset="" width=100%>


      </section>
      <br>


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
          padding-top: 2rem;
          position: relative;
          height: 10rem;
          background-color: #F3ECDA;
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
          font-family: 'Roboto';
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
          font-family: 'EB Garamond';
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
          font-family: 'EB Garamond';
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

        .rect-square-item img {
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
      </style>

<section class="section offer-section" style="background-color: #F3ECDA;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        
      <div class="section-heading text-center">
        
        
        <div class="modern-div22" >
          <div class="header">

            <img style="width:90px" class="svg-icon" src="public/media/flower-header.svg" alt="">
            <h1>Our Journey</h1>
            <img style="width:90px" class="svg-icon" src="public/media/flower-header-right.svg" alt="">
            <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->


          </div>
          </div>
          
      
        </div>

      </div>
    </div>

    <div class="d-flex justify-content-center ">


      <iframe  width="100%" height="576" src="https://www.youtube.com/embed/chS5VKXbzPY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    
         {{-- <a href="{{ $home_video['video_url'] }}"> <img width="100%" src="{{ asset('public/media/'.$home_video['image']) }}" alt=""> </a> --}}

    </div>   
    </div>
  </section>









      <div class="container">


        <br><br>
        <br><br>
        <!-- Row: Shop online-->
        <section class="row g-0">
          <div class="col-md-6 bg-position-center bg-size-cover bg-secondary" style="background-color: #F3ECDA !important;">

              <img src="public/frontend/images/17012023183844-Meet the founders about us.png" alt="" srcset="">
          </div>
          <div class="col-md-6 ">
            <div style="display: flex; justify-content: center; padding-bottom: 0px;">
              <img src="public/frontend/images/aaaa.png" alt="">
            </div>
            <div class="mx-auto py-lg-5" style="max-width: 35rem;">

              <h2 class="h3 pb-3" style="text-align: center; font-family: EB Garamond !important;">The Inception</h2>
              <p class="fs-sm pb-3 text-muted" style="text-align:justify;">Laavanya was started in 2016 by Anuj Ochani and Somna Janey, with a vision to bring beauty and grace to women through their clothing. 
                After realising the lack of stores offering raw fabric in the Gurgaon market, they took the leap and opened their first store.              </p>
            </div>
          </div>
        </section>



        <section style="padding-top: 80px; padding-bottom: 50px;">
          <div class="container">
            <div class="row">
            <div class="col-md-6 ">
              <div style="display: flex; justify-content: center;">
                <img  src="public/frontend/images/mood.png" alt="">
              </div>
              <div >
                <h2 class="h3 pb-3" style="text-align: center; font-family: EB Garamond !important;">Laavanya's Touch
                  <br> <i></i> </h2>
                <p style=" text-align:justify;" class=" pb-3 ">Laavanya sources fabrics from the finest weavers from all over India, and what sets us apart is our curated recommendations that help bring out the inner beauty of every woman.</p>
              </div>
            </div>
  
            <div class="col-md-6 d-flex justify-content-center">
              <img style=" width: 372px; height: 442px; background-color: #F3ECDA !important;" src="public/frontend/images/f1.png" alt="">
            </div>
          </div>
        </section>

        <section class="row g-0">
          <div class="col-md-6 bg-position-center bg-size-cover bg-secondary order-md-2"
            style="min-height: 15rem;  border-radius: 25px; background-color: #F3ECDA !important;">
            <img src="public/frontend/images/17012023184404-Handpicked fabric... about us.png" alt="" srcset="">
        </div>
          <div class="col-md-6 ">
            <div style="display: flex;
            justify-content: center;">
              <img src="public/frontend/images/gada.png" alt="">
            </div>


            <div class="mx-auto py-lg-5" style="max-width: 35rem;">
              <h2 class="h3 pb-3" style="text-align: center; font-family: EB Garamond !important;">Our vision for the Future

                <br> <i>  </i>  <br> <i>  </i> </h2>
              <p class="fs-sm pb-3 text-muted " style="text-align: justify;">Laavanya’s aim is to be the first thought that comes in mind when it comes to fabric, and to always bring beauty and grace to their clients. 
                Whether you're shopping for raw fabric or looking for inspiration, Laavanya is here for you. </p>
            </div>
          </div>
        </section>
        <!-- Row: Delivery-->



        <br>

        <section class="row g-0">


          <div class="col-md-15 modern-div22" style="background-color: #F3ECDA; padding: 0px;">

            <div class="header">

              <img class="svg-icon" src="public/media/flower-header.svg" alt="">
              <h1>Over the Years</h1>
              <img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
              <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->


            </div>



          </div>

          {{-- <div class="mx-auto " style="max-width: 35rem; text-align: center;">
            <h2 class="h3 " style="text-align: center; font-family: EB Garamond !important;">2019 - Finding the Location</h2>
            <p class="fs-sm" style="text-align: justify;">We started scouting for the location when we got the idea. We went around random
              space-hunting for months until we finally got the right space which made us go AHA! Now that's where we
              work from, a cozy space in Gurgaon!</p>
          </div> --}}



        </section>

        <section class="container ">

                      <div class="row ">

                        <div class="col-lg-2 col-6 " style="padding-bottom: 15px;">
                          <div class="card product-card card-static" style="background-color: #F3ECDA !important; border: 0px;">
                            <img src="public/frontend/images/17012023184942-journey about us 1.png" alt="Product">
                     
                          </div>
                        </div>

                        <div class="col-lg-2 col-6 "style="padding-bottom: 15px;">
                          <div class="card product-card card-static" style="background-color: #F3ECDA !important; border: 0px;">
                            <img src="public/frontend/images/17012023184945-journey about us 2.png" alt="Product">
                     
                          </div>
                        </div>

                        <div class="col-lg-2 col-6 "style="padding-bottom: 15px;">
                          <div class="card product-card card-static" style="background-color: #F3ECDA !important; border: 0px;">
                            <img src="public/frontend/images/17012023185054-journey about us 3.png" alt="Product">
                     
                          </div>
                        </div>

                        <div class="col-lg-2 col-6 "style="padding-bottom: 15px;">
                          <div class="card product-card card-static" style="background-color: #F3ECDA !important; border: 0px;">
                            <img src="public/frontend/images/17012023185116-journey about us 4.png" alt="Product">
                     
                          </div>
                        </div>

                        <div class="col-lg-2 col-6 "style="padding-bottom: 15px;">
                          <div class="card product-card card-static" style="background-color: #F3ECDA !important; border: 0px;">
                            <img src="public/frontend/images/17012023192147-journey about us 5.png" alt="Product">
                     
                          </div>
                        </div>

                        <div class="col-lg-2 col-6 "style="padding-bottom: 15px;">
                          <div class="card product-card card-static" style="background-color: #F3ECDA !important; border: 0px;">
                            <img src="public/frontend/images/17012023192151-journey about us 6.png" alt="Product">
                     
                          </div>
                        </div>
                        
                      </div>
              
        </section>  










        <div class="col-md-15 modern-div22" style="background-color: #F3ECDA; padding: 0px;">

          <div class="header" >
                
              <img class="svg-icon" src="public/media/flower-header.svg" alt="">
              <h1>Our Picks</h1>
              <img class="svg-icon" src="public/media/flower-header-right.svg" alt="">
              <!-- <button style="position: absolute; right:2rem; top: 2rem;">VIEW ALL</button> -->
             
          
            </div>
      
      
      
      </div>


<!-- 
      <section class="container py-4 py-sm-5">
        <div style="background-color: #F3ECDA;" class="row pt-3 pt-sm-0">
          <div class="col-lg-3 col-6 px-0 px-sm-2 mb-sm-4 mb-grid-gutter"><img class="card-img-top" src="img/about/f2.png"
              alt="McDonald's">
            <div class="card-body text-center pt-3 pb-4">
              
            

            </div>
          </div>


          <div class="col-lg-3 col-6 px-0 px-sm-2 mb-sm-4 mb-grid-gutter" style="background-color: #F3ECDA !important;">
            <img class="card-img-top" src="img/about/f3.png">
            <div class="card-body text-center pt-3 pb-4">
             
            </div>
          </div>

          <div class="col-lg-3 col-6 px-0 px-sm-2 mb-sm-4 mb-grid-gutter" style="background-color: #F3ECDA !important;">
            <img class="card-img-top" src="img/about/f4.png">
            <div class="card-body text-center pt-3 pb-4">
       
            </div>
          </div>

          <div class="col-lg-3 col-6 px-0 px-sm-2 mb-sm-4 mb-grid-gutter" style="background-color: #F3ECDA !important;">
            <img class="card-img-top" src="img/about/f5.png">
            <div class="card-body text-center pt-3 pb-4">
              
            </div>
          </div>

    

        </div>
      </section> -->
<!-- 


      <section class="container py-4 py-sm-5">
        <div class="container">
          <div class="row">
            <div class="col">
              <img class="card-img-top" src="img/about/f2.png"
              alt="McDonald's">
            </div>
            <div class="col">
              <img class="card-img-top" src="img/about/f3.png"
              alt="McDonald's">
            </div>
            <div class="col">
              <img class="card-img-top" src="img/about/f4.png"
                alt="McDonald's">
            </div>
            <div class="col">
              <img class="card-img-top" src="img/about/f5.png"
                alt="McDonald's">
            </div>
            <div class="col">
              <img class="card-img-top" src="img/about/f6.png"
                alt="McDonald's">
            </div>
          </div>
        </div>
      </section> -->

     



















    <section class="container ">
        <div class="row">

                      <div class="col-lg-2 col-6 " >
                        <a href="https://laavanya-gracefullyyou.in/product-category/90/dupatta">
                        <div class="card product-card card-static" style="background-color: #F3ECDA !important;">
                          <img src="public/frontend/images/dr.png" alt="Product">

                        </div>
                        <p style="text-align: center;">Dupatta Range</p>
                      </a>
                      </div>

                      <div class="col-lg-2 col-6 ">
                        <a href="https://laavanya-gracefullyyou.in/product-category/69/silk-2">
                        <div class="card product-card card-static" style="background-color: #F3ECDA !important;">
                          <img src="public/frontend/images/s.png" alt="Product">
                          <p style="text-align: center;">Silk</p>
                        </div>
                      </a>
                      </div>

                      <div class="col-lg-2 col-6 ">
                        <a href="https://laavanya-gracefullyyou.in/product-category/143/silk-suit-set">
                        <div class="card product-card card-static" style="background-color: #F3ECDA !important;">
                          <img src="public/frontend/images/sss.png" alt="Product">
                          <p style="text-align: center;">Silk Suit Set</p>
                        </div>
                      </a>
                      </div>

                      <div class="col-lg-2 col-6 ">
                        <a href="https://laavanya-gracefullyyou.in/product-category/71/georgette">
                        <div class="card product-card card-static" style="background-color: #F3ECDA !important;">
                          <img src="public/frontend/images/g.png" alt="Product">
                          <p style="text-align: center;">Georgette</p>
                        </div>
                      </a>
                      </div>

                      <div class="col-lg-2 col-6 ">
                        <a href="https://laavanya-gracefullyyou.in/product-category/70/organza-satin">
                        <div class="card product-card card-static" style="background-color: #F3ECDA !important;">
                          <img src="public/frontend/images/o.png" alt="Product">
                          <p style="text-align: center;">Organza</p>
                        </div>
                      </a>
                      </div>

                      <div class="col-lg-2 col-6 ">
                        <a href="https://laavanya-gracefullyyou.in/product-category/123/tie-and-dye">
                        <div class="card product-card card-static" style="background-color: #F3ECDA !important;">
                          <img src="public/frontend/images/td.png" alt="Product">
                          <p style="text-align: center;">Tie & Dye</p>
                        </div>
                      </a>
                      </div>
                
                  </div>
                  <br>
    
                  <br>
             
      </section>  









      </div>

      
  </main>







@endsection

@push('scripts')
<script type="text/javascript">
var category_id = "{{ isset($params) ? $params['category_id'] : 0 }}";
</script>
<script src="{{asset('public/frontend/pages/product-category.js')}}"></script>
@endpush	