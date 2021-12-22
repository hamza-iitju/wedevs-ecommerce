@extends('layouts.back-end.app')

@section('title', 'Order Details')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none p-3" style="background: white">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                    href="{{ route('admin.orders.list', ['status' => 'all']) }}">{{ trans('messages.Orders') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Order') }}
                                {{ trans('messages.details') }} </li>
                        </ol>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title">{{ trans('messages.Order') }} #{{ $order['id'] }}</h1>

                        @if ($order['payment_status'] == 'paid')
                            <span class="badge badge-soft-success ml-sm-3">
                                <span class="legend-indicator bg-success"></span>{{ trans('messages.Paid') }}
                            </span>
                        @else
                            <span class="badge badge-soft-danger ml-sm-3">
                                <span class="legend-indicator bg-danger"></span>{{ trans('messages.Unpaid') }}
                            </span>
                        @endif

                        @if ($order['order_status'] == 'pending')
                            <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-info text"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='confirmed')
                            <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-info text"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='failed')
                            <span class="badge badge-danger ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-info"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='processing')
                            <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-warning"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>

                        @elseif($order['order_status']=='outForDelivery')
                            <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-success"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='delivered')
                            <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-success"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @elseif($order['order_status']=='canceled')
                            <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-danger"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @else
                            <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                                <span
                                    class="legend-indicator bg-danger"></span>{{ str_replace('_', ' ', $order['order_status']) }}
                            </span>
                        @endif
                        <span class="ml-2 ml-sm-3">
                            <i class="tio-date-range"></i> {{ date('d M Y H:i:s', strtotime($order['created_at'])) }}
                        </span>
                    </div>
                    <div class="col-md-6 mt-2">
                        <a class="text-body mr-3" target="_blank"
                            href={{ route('admin.orders.generate-invoice', [$order['id']]) }}>
                            <i class="tio-print mr-1"></i> {{ trans('messages.Print') }} {{ trans('messages.invoice') }}
                        </a>
                    </div>

                    <!-- Unfold -->

                    <div class="hs-unfold float-right">
                        <div class="dropdown">
                            <select name="order_status" onchange="order_status(this.value)" class="status form-control"
                                data-id="{{ $order['id'] }}">

                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                    {{ trans('messages.Pending') }}</option>
                                <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>
                                    {{ trans('messages.confirmed') }}</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                                    {{ trans('messages.Processing') }} </option>
                                <option value="outForDelivery"
                                    {{ $order->order_status == 'outForDelivery' ? 'selected' : '' }}>
                                    {{ trans('messages.outForDelivery') }}</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                    {{ trans('messages.Delivered') }} </option>
                                <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>
                                    {{ trans('messages.Returned') }}</option>
                                <option value="failed" {{ $order->order_status == 'failed' ? 'selected' : '' }}>
                                    {{ trans('messages.Failed') }} </option>
                                <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>
                                    {{ trans('messages.Cancel') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="hs-unfold float-right pr-2">
                        <div class="dropdown">
                            <select name="payment_status" class="payment_status form-control"
                                data-id="{{ $order['id'] }}">

                                <option
                                    onclick="route_alert('{{ route('admin.orders.payment-status', ['id' => $order['id'], 'payment_status' => 'paid']) }}','Change status to paid ?')"
                                    href="javascript:" value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                    {{ trans('messages.Paid') }}
                                </option>
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                                    {{ trans('messages.Unpaid') }}
                                </option>

                            </select>
                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
        </div>

        <!-- End Page Header -->

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header" style="display: block!important;">
                        <div class="row">
                            <div class="col-12 pb-2 border-bottom">
                                <h4 class="card-header-title">
                                    {{ trans('messages.Order') }} {{ trans('messages.details') }}
                                    <span
                                        class="badge badge-soft-dark rounded-circle ml-1">{{ $order->details->count() }}</span>
                                </h4>
                            </div>
                            <div class="col-6 pt-2">
                                <h6 class="" style="color: #8a8a8a;">
                                    {{ trans('messages.shipping_method') }}
                                    :
                                    {{ $order->details[0]->shipping_method_id ? $order->details[0]->shipping->title : '' }}
                                </h6>
                            </div>
                            <div class="col-6 pt-2">
                                <div class="text-right">
                                    <h6 class="" style="color: #8a8a8a;">
                                        {{ trans('messages.Payment') }} {{ trans('messages.Method') }}
                                        : {{ str_replace('_', ' ', $order['payment_method']) }}
                                    </h6>
                                    <h6 class="" style="color: #8a8a8a;">
                                        {{ trans('messages.Payment') }} {{ trans('messages.reference') }}
                                        : {{ str_replace('_', ' ', $order['transaction_ref']) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar avatar-xl mr-3">
                                <p>{{ trans('messages.image') }}</p>
                            </div>

                            <div class="media-body">
                                <div class="row">
                                    <div class="col-md-4 product-name">
                                        <p> {{ trans('messages.Name') }}</p>
                                    </div>

                                    <div class="col col-md-1 align-self-center p-0 ">
                                        <p> {{ trans('messages.price') }}</p>
                                    </div>

                                    <div class="col col-md-2 align-self-center">
                                        <p>Qty</p>
                                    </div>
                                    <div class="col col-md-2 align-self-center  p-0 product-name">
                                        <p> {{ trans('messages.Discount') }}</p>
                                    </div>

                                    <div class="col col-md-2 align-self-center text-right  ">
                                        <p> {{ trans('messages.Subtotal') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php($subtotal = 0)
                        @php($total = 0)
                        @php($shipping = 100)

                        @foreach ($order->details as $detail)
                            @if ($detail->product)

                                <!-- Media -->
                                <div class="media">
                                    <div class="avatar avatar-xl mr-3">
                                        <img class="img-fluid"
                                            onerror="this.src='{{ asset('public/assets/back-end/img/160x160/img2.jpg') }}'"
                                            src="{{ \App\CPU\ProductManager::product_image_path('images') }}/{{ $detail->product->images[0] }}"
                                            alt="Image Description">
                                    </div>

                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3 mb-md-0 product-name">
                                                <p>
                                                    {{ $detail->product['name'] }}</p>
                                            </div>

                                            <div class="col col-md-1 align-self-center p-0 ">
                                                <h6>{{ $detail['price'] }}</h6>
                                            </div>

                                            <div class="col col-md-2 align-self-center">

                                                <h5>{{ $detail->qty }}</h5>
                                            </div>
                                            <div class="col col-md-2 align-self-center">

                                                <h5>0</h5>
                                            </div>
                                            <div class="col col-md-2 align-self-center text-right  ">
                                                @php($subtotal = $detail['price'] * $detail->qty)

                                                <h5 style="font-size: 12px">৳ {{ $subtotal }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php($total += $subtotal)
                                <!-- End Media -->
                                <hr>
                            @endif
                        @endforeach

                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row text-sm-right">
                                    <dt class="col-sm-6">{{ trans('messages.Shipping') }}</dt>
                                    <dd class="col-sm-6 border-bottom">
                                        <strong>৳ {{ $shipping }}</strong>
                                    </dd>

                                    <dt class="col-sm-6">{{ trans('messages.Total') }}</dt>
                                    <dd class="col-sm-6">
                                        <strong>৳ {{ $total + $shipping }}</strong>
                                    </dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{ trans('messages.Customer') }}</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    @if ($order->customer)
                        <div class="card-body">
                            <div class="media align-items-center" href="javascript:">
                                <div class="media-body">
                                    <span class="text-body text-hover-primary">{{ $order->customer['person_name'] }}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{-- <i class="tio-chevron-right text-body"></i> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="media align-items-center" href="javascript:">
                                <div class="icon icon-soft-info icon-circle mr-3">
                                    <i class="tio-shopping-basket-outlined"></i>
                                </div>
                                <div class="media-body">
                                    <span class="text-body text-hover-primary">
                                        {{ \App\Models\Order::where('customer_id', $order['customer_id'])->count() }}
                                        orders</span>
                                </div>
                                <div class="media-body text-right">
                                    {{-- <i class="tio-chevron-right text-body"></i> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{ trans('messages.Contact') }} {{ trans('messages.info') }} </h5>
                            </div>

                            <ul class="list-unstyled list-unstyled-py-2">
                                <li>
                                    <i class="tio-online mr-2"></i>
                                    {{ $order->customer['email'] }}
                                </li>
                                <li>
                                    <i class="tio-android-phone-vs mr-2"></i>
                                    {{ $order->customer['phone'] }}
                                </li>
                            </ul>

                            <hr>


                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{ trans('messages.shipping_address') }}</h5>

                            </div>

                            <span class="d-block">
                                {{ trans('messages.Name') }} :
                                <strong>{{ $order->shipping ? $order->shipping['person_name'] : 'empty' }}</strong><br>
                                {{ trans('messages.address') }} :
                                <strong>{{ $order->shipping ? $order->shipping['address'] : 'Empty' }}</strong><br>
                                {{ trans('messages.City') }}:
                                <strong>{{ $order->shipping ? $order->shipping['city'] : 'Empty' }}</strong><br>
                                {{ trans('messages.Phone') }}:
                                <strong>{{ $order->shipping ? $order->shipping['phone'] : 'Empty' }}</strong><br>
                                {{ trans('messages.Email') }}:
                                <strong>{{ $order->shipping ? $order->shipping['email'] : 'Empty' }}</strong>

                            </span>

                        </div>
                    @endif
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('change', '.payment_status', function() {
            var id = $(this).attr("data-id");
            var value = $(this).val();
            Swal.fire({
                title: 'Are you sure Change this?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.orders.payment-status') }}",
                        method: 'POST',
                        data: {
                            "id": id,
                            "payment_status": value
                        },
                        success: function(data) {
                            toastr.success('Status Change successfully');
                            location.reload();
                        }
                    });
                }
            })
        });

        function order_status(status) {
            var value = status;
            Swal.fire({
                title: 'Are you sure Change this?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.orders.status') }}",
                        method: 'POST',
                        data: {
                            "id": '{{ $order['id'] }}',
                            "order_status": value
                        },
                        success: function(data) {
                            toastr.success('Status Change successfully');
                            location.reload();
                        }
                    });
                }
            })
        }
    </script>
@endpush
