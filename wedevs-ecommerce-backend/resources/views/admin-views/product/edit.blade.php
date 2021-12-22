@extends('layouts.back-end.app')

@section('title', 'Product Edit')

@push('css_or_js')
    <link href="{{ asset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #377dff;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #product-images-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        #thumbnail-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #product-images-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }

            #thumbnail-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }
        }

        @media (max-width: 375px) {
            #product-images-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            #thumbnail-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }
        }

        @media (max-width: 500px) {
            #product-images-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            #thumbnail-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            .btn-for-m {
                margin-bottom: 10px;
            }

            .parcent-margin {
                margin-left: 0px !important;
            }
        }

    </style>
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.dashboard') }}">{{ trans('messages.Dashboard') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{ route('admin.product.list', 'in_house') }}">{{ trans('messages.Product') }}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{ trans('messages.Edit') }}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <form class="product-form" enctype="multipart/form-data" id="product_form">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="form-group">
                                    <label class="input-label" for="name">{{ trans('messages.name') }}</label>
                                    <input type="text" name="name" id="name" value="{{ $product['name'] }}"
                                        class="form-control" placeholder="New Product" required>
                                </div>
                                <div class="form-group">
                                    <label class="input-label"
                                        for="description">{{ trans('messages.description') }}</label>
                                    <input type="text" name="description[]" id="description"
                                        value="{{ $product['description'] }}" class="form-control"
                                        placeholder="Description">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4>{{ trans('messages.Product price & stock') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">{{ trans('messages.Unit price') }}</label>
                                        <input type="number" min="0" step="0.01"
                                            placeholder="{{ trans('messages.Unit price') }}" name="price"
                                            class="form-control" value={{ $product->price }} required>
                                    </div>

                                    <div class="col-md-6" id="quantity">
                                        <label class="control-label">{{ trans('messages.total') }}
                                            {{ trans('messages.Quantity') }}</label>
                                        <input type="number" min="0" value={{ $product->qty }} step="1"
                                            placeholder="{{ trans('messages.Quantity') }}" name="qty"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <br>
                        </div>
                    </div>

                    <div class="card mt-2 rest-part">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('messages.Upload product images') }}</label><small
                                            style="color: red">* ( {{ trans('messages.ratio') }} 1:1 )</small>
                                    </div>
                                    <div class="p-2 border border-dashed" style="max-width:430px;">
                                        <div class="row" id="coba">
                                            @foreach (json_decode($product->images) as $key => $photo)
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <img style="width: 100%" height="auto"
                                                                onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                                                src="{{ asset("storage/product/$photo") }}"
                                                                alt="Product image">
                                                            <a href="{{ route('admin.product.remove-image', ['id' => $product['id'], 'name' => $photo]) }}"
                                                                class="btn btn-danger btn-block">Remove</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-footer">
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 20px">
                                <button type="button" onclick="check()" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script src="{{ asset('public/assets/back-end') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        var imageCount = {{ 4 - count(json_decode($product->images)) }};
        $(function() {
            if (imageCount > 0) {
                $("#coba").spartanMultiImagePicker({
                    fieldName: 'images[]',
                    maxCount: imageCount,
                    rowHeight: 'auto',
                    groupClassName: 'col-6',
                    maxFileSize: '',
                    placeholderImage: {
                        image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                        width: '100%',
                    },
                    dropFileLabel: "Drop Here",
                    onAddRow: function(index, file) {

                    },
                    onRenderedPreview: function(index) {

                    },
                    onRemoveRow: function(index) {

                    },
                    onExtensionErr: function(index, file) {
                        toastr.error('Please only input png or jpg type file', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    },
                    onSizeErr: function(index, file) {
                        toastr.error('File size too big', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                });
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function() {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }
    </script>

    <script>
        function check() {
            var formData = new FormData(document.getElementById('product_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.product.update', $product->id) }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('product updated successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#product_form').submit();
                    }
                }
            });
        };
    </script>

    <script>
        update_qty();

        function update_qty() {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="qty"]').attr("readonly", true);
                $('input[name="qty"]').val(total_qty);
            } else {
                $('input[name="qty"]').attr("readonly", false);
            }
        }

        $('input[name^="qty_"]').on('keyup', function() {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            $('input[name="current_stock"]').val(total_qty);
        });
    </script>
@endpush
