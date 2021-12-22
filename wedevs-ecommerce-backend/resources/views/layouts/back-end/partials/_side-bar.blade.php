<style>
    .navbar-vertical .nav-link {
        color: #ffffff;
        font-weight: bold;
    }

    .navbar .nav-link:hover {
        color: #C6FFC1;
    }

    .navbar .active>.nav-link,
    .navbar .nav-link.active,
    .navbar .nav-link.show,
    .navbar .show>.nav-link {
        color: #C6FFC1;
    }

    .navbar-vertical .active .nav-indicator-icon,
    .navbar-vertical .nav-link:hover .nav-indicator-icon,
    .navbar-vertical .show>.nav-link>.nav-indicator-icon {
        color: #C6FFC1;
    }

    .nav-subtitle {
        display: block;
        color: #fffbdf91;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03125rem;
    }

    .side-logo {
        background-color: #F7F8FA;
        border: 1px solid #80808061;
    }

    .nav-sub {
        background-color: #34656D !important;
    }

</style>

<div id="sidebarMain" class="d-none">
    <aside style="background: #34656D!important;"
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset pb-0">
                <div class="navbar-publication-wrapper justify-content-between side-logo">
                    <!-- Logo -->
                    <a class="navbar-publication" href="{{ route('admin.dashboard') }}" aria-label="Front">
                        <img style="max-height: 38px"
                            onerror="this.src='{{ asset('public/assets/back-end/img/900x400/img1.jpg') }}'"
                            class="navbar-publication-logo-mini for-web-logo"
                            src="{{ asset('storage/company/logo.png') }}" alt="Logo">
                    </a>
                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content mt-2">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin') ? 'show' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{ url('admin/dashboard') }}">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ trans('messages.Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <!-- End Dashboards -->


                        <li class="nav-item {{ Request::is('admin/orders*') ? 'scroll-here' : '' }}">
                            <small class="nav-subtitle" title="">{{ trans('messages.order_management') }}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <!-- Order -->
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/orders*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-shopping-cart-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ trans('messages.orders') }}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{ Request::is('admin/order*') ? 'block' : 'none' }}">
                                <li class="nav-item {{ Request::is('admin/orders/list/all') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('admin/orders/list', ['all']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.All') }}
                                            <span class="badge badge-info badge-pill ml-1">
                                                {{ \App\Models\Order::count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/orders/list/pending') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/orders/list', ['pending']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.pending') }}
                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'pending'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/orders/list/confirmed') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/orders/list', ['confirmed']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.confirmed') }}
                                            <span class="badge badge-soft-success badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'confirmed'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/orders/list/processing') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/orders/list', ['processing']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.Processing') }}
                                            <span class="badge badge-warning badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'processing'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/orders/list/outForDelivery') ? 'active' : '' }}">
                                    <a class="nav-link "
                                        href="{{ url('admin/orders/list', ['outForDelivery']) }}" title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.outForDelivery') }}
                                            <span class="badge badge-warning badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'outForDelivery'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/orders/list/delivered') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/orders/list', ['delivered']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.delivered') }}
                                            <span class="badge badge-success badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'delivered'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/orders/list/returned') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/orders/list', ['returned']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.returned') }}
                                            <span class="badge badge-soft-danger badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'returned'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/orders/list/failed') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/orders/list', ['failed']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.failed') }}
                                            <span class="badge badge-danger badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'failed'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('admin/orders/list/canceled') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/orders/list', ['canceled']) }}"
                                        title="">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{ trans('messages.canceled') }}
                                            <span class="badge badge-soft-dark badge-pill ml-1">
                                                {{ \App\Models\Order::where(['order_status' => 'canceled'])->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--order management ends-->

                        {{-- Category start --}}
                        <li
                            class="navbar-vertical-aside-has-menu {{ Request::is('admin/category*') || Request::is('admin/sub*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-filter-list nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ trans('messages.categories') }}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{ Request::is('admin/category*') || Request::is('admin/sub*') ? 'block' : '' }}">
                                <li class="nav-item {{ Request::is('admin/category/view') ? 'active' : '' }}">
                                    <a class="nav-link " href="#">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ trans('messages.category') }}</span>
                                    </a>

                                </li>
                                <li class="nav-item {{ Request::is('admin/sub-category/view') ? 'active' : '' }}">
                                    <a class="nav-link " href="#">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ trans('messages.sub_category') }}</span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ Request::is('admin/sub-sub-category/view') ? 'active' : '' }}">
                                    <a class="nav-link " href="#">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ trans('messages.sub_sub_category') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- end category start --}}

                        {{-- Product start --}}
                        <li
                            class="navbar-vertical-aside-has-menu {{ Request::is('admin/product*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                                <i class="tio-airdrop nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{ trans('messages.Products') }}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{ Request::is('admin/product*') ? 'block' : '' }}">
                                <li
                                    class="nav-item {{ Request::is('admin/product/list/in_house') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ url('admin/product/list', ['in_house']) }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ trans('messages.Products') }}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <!--product management ends-->


                        {{-- Customer start --}}
                        <li class="nav-item {{ Request::is('admin/customer/list') ? 'scroll-here' : '' }}">
                            <small class="nav-subtitle" title="">{{ trans('messages.user_section') }}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        @if (auth()->guard('admin'))
                            <li class="nav-item {{ Request::is('admin/customer/list') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ url('admin/customer/list') }}">
                                    <span class="tio-poi-user nav-icon"></span>
                                    <span class="text-truncate">{{ trans('messages.customers') }} </span>
                                </a>
                            </li>
                        @endif
                        <!--customer list ends here-->

                        <li class="nav-item" style="padding-top: 50px">
                            <div class="nav-divider"></div>
                        </li>
                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>
