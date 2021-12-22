@extends('layouts.back-end.app')

@section('title', 'Product Preview')

@push('css_or_js')
    <style>
        .checkbox-color label {
            width: 2.25rem;
            height: 2.25rem;
            float: left;
            padding: 0.375rem;
            margin-right: 0.375rem;
            display: block;
            font-size: 0.875rem;
            text-align: center;
            opacity: 0.7;
            border: 2px solid #d3d3d3;
            border-radius: 50%;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            transition: all 0.3s ease;
            transform: scale(0.95);
        }

    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-6">
                    <h1 class="page-header-title">{{ $product['name'] }}</h1>
                </div>
                <div class="col-6">
                    <a href="{{ url()->previous() }}" class="btn btn-primary float-right">
                        <i class="tio-back-ui"></i> Back
                    </a>
                </div>
            </div>
            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:">
                        Product Details
                    </a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center gx-md-5">
                    <div class="col-4">
                        <h4 class="border-bottom">{{ $product['name'] }}</h4>
                        <span>Price :
                            <span>{{ $product['price'] }}
                            </span>
                        </span><br>
                        <span>Current Stock :
                            <span>{{ $product->qty }}</span>
                        </span><br>
                        <span>Product Description :
                            <span>{{ $product->description }}</span>
                        </span>
                    </div>

                    <div class="col-8 pt-2 border-left">
                        Product Image

                        <div class="row">
                            @foreach (json_decode($product->images) as $key => $photo)
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <img style="width: 100%"
                                                onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                                src="{{ asset("storage/product/$photo") }}" alt="Product image">

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </span>
                    </div>

                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
    </div>
@endsection
