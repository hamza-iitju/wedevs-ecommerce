@extends('layouts.back-end.app')

@section('title', 'Dashboard')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .grid-card {
            border: 2px solid #00000012;
            border-radius: 10px;
            padding: 10px;
        }

        .label_1 {
            position: absolute;
            font-size: 10px;
            background: #FF4C29;
            color: #ffffff;
            width: 80px;
            padding: 2px;
            font-weight: bold;
            border-radius: 6px;
            text-align: center;
        }

        .center-div {
            text-align: center;
            border-radius: 6px;
            padding: 6px;
            border: 2px solid #8080805e;
        }

    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header"
            style="padding-bottom: 0!important;border-bottom: 0!important;margin-bottom: 1.25rem!important;">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{ trans('messages.Dashboard') }}</h1>
                    <p>Welcome admin, here is your business statistics.</p>
                </div>
                <div class="col-sm mb-2 mb-sm-0" style="height: 25px">
                    <label class="badge badge-soft-success float-right">
                        Developed by : Md. Ameer Hamza
                    </label>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card mb-3">
            <div class="card-body">
                <div class="row gx-2 gx-lg-3 mb-2">
                    <div class="col-9">
                        <h4><i style="font-size: 30px"
                                class="tio-chart-bar-4"></i>{{ __('messages.dashboard_order_statistics') }}</h4>
                    </div>
                    <div class="col-3">
                        <select class="custom-select" name="statistics_type" onchange="order_stats_update(this.value)">
                            <option value="overall"
                                {{ session()->has('statistics_type') && session('statistics_type') == 'overall' ? 'selected' : '' }}>
                                Overall Statistics
                            </option>
                            <option value="today"
                                {{ session()->has('statistics_type') && session('statistics_type') == 'today' ? 'selected' : '' }}>
                                Today's Statistics
                            </option>
                            <option value="today"
                                {{ session()->has('statistics_type') && session('statistics_type') == 'this_month' ? 'selected' : '' }}>
                                This Month's Statistics
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row gx-2 gx-lg-3" id="order_stats">
                    @include('admin-views.partials._dashboard-order-stats',['data'=>$data])
                </div>
            </div>
        </div>

        <div class="row gx-2 gx-lg-3 mt-2">
            <div class="col-lg-6 mb-3">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title">
                            <i class="tio-company"></i> Total Business Overview
                        </h5>
                        <i class="tio-chart-pie-1" style="font-size: 45px"></i>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body" id="business-overview-board">
                        <!-- Chart -->
                        <div class="chartjs-custom mx-auto">
                            <canvas id="business-overview" class="mt-2"></canvas>
                        </div>
                        <!-- End Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mb-3">
                <!-- Card -->
                <div class="card h-100">
                    @include('admin-views.partials._top-store-by-order',['top_store_by_order_received'=>$data['top_store_by_order_received']])
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mb-3">
                <!-- Card -->
                <div class="card h-100">
                    @include('admin-views.partials._top-selling-products',['top_sell'=>$data['top_sell']])
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mb-3">
                <!-- Card -->
                <div class="card h-100">
                    @include('admin-views.partials._most-rated-products',['most_rated_products'=>$data['most_rated_products']])
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mb-3">
                <!-- Card -->
                <div class="card h-100">
                    @include('admin-views.partials._top-customer',['top_customer'=>$data['top_customer']])
                </div>
                <!-- End Card -->
            </div>

        </div>
    </div>
@endsection

@push('script_2')

    <script>
        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ url('admin/dashboard/order-stats') }}',
                data: {
                    statistics_type: type
                },
                beforeSend: function() {
                    $('#loading').show()
                },
                success: function(data) {
                    $('#order_stats').html(data.view)
                },
                complete: function() {
                    $('#loading').hide()
                }
            });
        }
    </script>

@endpush
