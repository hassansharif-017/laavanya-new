@extends('layouts.frontend')

@section('title', 'Products')
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
                                <li class="breadcrumb-item active" aria-current="page">Products</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6">
                        <div class="page-title">
                            <h1>Products</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Breadcrumb/ -->

        <!-- Inner Section -->
        <section class="inner-section inner-section-bg">
            <div class="container">

                <div class="row">
                    <div class="col-lg-3">
                        @include('frontend.partials.sidebar-products')
                    </div>
                    <div class="col-lg-9">
                        <div class="filter-card  d-none">
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">

                                    <div class="widget-card">
                                        <div class="widget-title">{{ __('Filter by Price') }}</div>
                                        <div class="widget-body">
                                            <div class="slider-range m-0">
                                                <div id="slider-range"></div>
                                                <div class="price-range">
                                                    <div class="price-label">{{ __('Price Range') }}:</div>
                                                    <div class="price" id="amount"></div>
                                                </div>
                                                <input id="filter_min_price" type="hidden" value="0" />
                                                <input id="filter_max_price" type="hidden" />
                                                <a id="FilterByPrice" href="javascript:void(0);"
                                                    class="btn theme-btn filter-btn"><i class="bi bi-funnel"></i>
                                                    {{ __('Filter') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6"
                                    style="align-content:center">
                                    <div class="sort_by_select">
                                        <select name="sortby" id="sortby" class="form-select form-select-sm">
                                            <option value="default_sorting" selected="">{{ __('Sort By') }}</option>
                                            <option value="date_asc">Oldest</option>
                                            <option value="date_desc">Newest</option>
                                            <option value="name_asc">Name: A-Z</option>
                                            <option value="name_desc">Name : Z-A</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tp_datalist">
                            @include('frontend.partials.products-grid')
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Inner Section/ -->

    </main>

@endsection


