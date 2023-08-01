@include('admin/common/header')
@include('admin/common/left-side-bar')
<?php
define('ORDER_STATUS', array('pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'decline' => 'Decline'))
?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="" href="{{url('admin/orders')}}">Orders</a>
                        </li>
                        <li class=" active">&nbsp;&nbsp;/ Order details</li>
                    </ol>
                </nav>

                <div class="d-sm-flex align-items-sm-center">
                    <h1 class="page-header-title">Order {{$order_detail['booking_id']}}</h1>
                    <span class="badge bg-soft-success text-success ms-sm-3">
                <span class="legend-indicator bg-success"></span>{{$order_detail['payment_status']==1 ? 'paid':'unpaid'}}
              </span>
                    <span class="ms-2 ms-sm-3">
                <i class="bi-calendar-week"></i> {{$order_detail['order_time']}}
              </span>
                </div>

                <div class="mt-2">
                    <div class="d-flex gap-2">
                        {{--<a class="text-body me-3" href="javascript:;" onclick="window.print(); return false;">--}}
                            {{--<i class="bi-printer me-1"></i> Print order--}}
                        {{--</a>--}}

                        <!-- Dropdown -->

                        <!-- End Dropdown -->
                    </div>
                </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle"
                            data-bs-toggle="tooltip" data-bs-placement="right" title="Previous order">
                        <i class="bi-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle"
                            data-bs-toggle="tooltip" data-bs-placement="right" title="Next order">
                        <i class="bi-arrow-right"></i>
                    </button>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-lg-8 mb-3 mb-lg-0">
            <!-- Card -->
            <div class="card mb-3 mb-lg-5">
                <!-- Header -->
                <div class="card-header card-header-content-between">
                    <h4 class="card-header-title">Order details <span
                            class="badge bg-soft-dark text-dark rounded-circle ms-1">{{count($items)}}</span></h4>
                    <a class="link" href="javascript:void(0);">Edit</a>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body">
                    <!-- Media -->
                    <?php

                    foreach ($items as $item)
                    {
                    ?>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-xl">
                                <img class="img-fluid" src="{{$item->image}}" alt=" Description">
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <a class="h5 d-block" href="javascript:void(0)">{{$item->name}}</a>

                                </div>
                                <!-- End Col -->

                                <div class="col col-md-2 align-self-center">
                                    <h5>{{$item->price}}</h5>
                                </div>
                                <!-- End Col -->

                                <div class="col col-md-2 align-self-center">
                                    <h5>{{$item->quantity}}</h5>
                                </div>
                                <!-- End Col -->

                                <div class="col col-md-2 align-self-center text-end">
                                    <h5>{{$item->price * $item->quantity}}</h5>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->
                        </div>
                    </div>
                    <!-- End Media -->

                    <hr>
                    <?php
                    }?>


                    <div class="row justify-content-md-end mb-3">
                        <div class="col-md-8 col-lg-7">
                            <dl class="row text-sm-end">
                                <dt class="col-sm-6">Item total:</dt>
                                <dd class="col-sm-6">{{$order_detail['total_item_price']}}</dd>
                                <dt class="col-sm-6">Delivery fee({{$order_detail['km']}}Km):</dt>
                                <dd class="col-sm-6">{{$order_detail['km_price']}}</dd>
                                <dt class="col-sm-6">GST({{$order_detail['gst']}}):</dt>
                                <dd class="col-sm-6">{{$order_detail['gst_per']}}</dd>
                                <dt class="col-sm-6">Total:</dt>
                                <dd class="col-sm-6">{{$order_detail['to_pay']}}</dd>
                            </dl>
                            <!-- End Row -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Body -->
            </div>
            <!-- End Card -->

            <!-- Card -->
            {{--<div class="card">--}}
                {{--<!-- Header -->--}}
                {{--<div class="card-header">--}}
                    {{--<h4 class="card-header-title">--}}
                        {{--Shipping activity--}}
                        {{--<span class="badge bg-soft-dark text-dark ms-1">--}}
                  {{--<span class="legend-indicator bg-dark"></span>Marked as fulfilled--}}
                {{--</span>--}}
                    {{--</h4>--}}
                {{--</div>--}}
                {{--<!-- End Header -->--}}

                {{--<!-- Body -->--}}
                {{--<div class="card-body">--}}
                    {{--<!-- Step -->--}}
                    {{--<ul class="step step-icon-xs">--}}
                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-divider">Wednesday, 19 August</span>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}

                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

                                {{--<div class="step-content">--}}
                                    {{--<h5 class="mb-1">--}}
                                        {{--<a class="text-dark" href="#">Delivered</a>--}}
                                    {{--</h5>--}}

                                    {{--<p class="fs-6 mb-0">4:17 AM</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}

                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

                                {{--<div class="step-content">--}}
                                    {{--<h5 class="mb-1">--}}
                                        {{--<a class="text-dark" href="#">Out for delivery</a>--}}
                                    {{--</h5>--}}

                                    {{--<p class="fs-6 mb-0">2:38 AM</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}

                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

                                {{--<div class="step-content">--}}
                                    {{--<h5 class="mb-1">--}}
                                        {{--<a class="text-dark" href="#">Package arrived at the final delivery station</a>--}}
                                    {{--</h5>--}}

                                    {{--<p class="fs-6 mb-0">2:00 AM</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}

                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-divider">Tuesday, 18 August</span>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}

                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

                                {{--<div class="step-content">--}}
                                    {{--<h5 class="mb-1">--}}
                                        {{--<a class="text-dark" href="#">Tracking number</a>--}}
                                    {{--</h5>--}}

                                    {{--<a href="#">3981241023109293</a>--}}
                                    {{--<p class="fs-6 mb-0">6:29 AM</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}

                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

                                {{--<div class="step-content">--}}
                                    {{--<h5 class="mb-1">--}}
                                        {{--<a class="text-dark" href="#">Package has dispatched</a>--}}
                                    {{--</h5>--}}

                                    {{--<p class="fs-6 mb-0">6:29 AM</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}

                        {{--<!-- Step Item -->--}}
                        {{--<li class="step-item">--}}
                            {{--<div class="step-content-wrapper">--}}
                                {{--<span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

                                {{--<div class="step-content">--}}
                                    {{--<h5 class="mb-1">--}}
                                        {{--<a class="text-dark" href="#">Order was placed</a>--}}
                                    {{--</h5>--}}

                                    {{--<p class="fs-6 mb-0">Order #32543</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<!-- End Step Item -->--}}
                    {{--</ul>--}}
                    {{--<!-- End Step -->--}}

                    {{--<span class="small">Times are shown in the local time zone.</span>--}}
                {{--</div>--}}
                {{--<!-- End Body -->--}}
            {{--</div>--}}
            <!-- End Card -->
        </div>

        <div class="col-lg-4">
            <!-- Card -->
            <div class="card">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title">Customer</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body">
                    <!-- List Group -->
                    <ul class="list-group list-group-flush list-group-no-gutters">
                        <li class="list-group-item">
                            <a class="d-flex align-items-center" href="ecommerce-customer-details.html">

                                <div class="flex-grow-1 ms-3">
                                    <span class="text-body text-inherit">{{$user_info->name}}</span>
                                </div>
                                {{--<div class="flex-grow-1 text-end">--}}
                                    {{--<i class="bi-chevron-right text-body"></i>--}}
                                {{--</div>--}}
                            </a>
                        </li>

                        {{--<li class="list-group-item">--}}
                            {{--<a class="d-flex align-items-center" href="ecommerce-customer-details.html">--}}
                                {{--<div class="icon icon-soft-info icon-circle">--}}
                                    {{--<i class="bi-basket"></i>--}}
                                {{--</div>--}}
                                {{--<div class="flex-grow-1 ms-3">--}}
                                {{--<span class="text-body text-inherit">7 orders</span>--}}
                                {{--</div>--}}
                                {{--<div class="flex-grow-1 text-end">--}}
                                    {{--<i class="bi-chevron-right text-body"></i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}

                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Contact info</h5>
                                {{--<a class="link" href="javascript:;">Edit</a>--}}
                            </div>

                            <ul class="list-unstyled list-py-2 text-body">
                                <li><i class="bi-at me-2"></i>{{$user_info->email}}</li>
                                <li><i class="bi-phone me-2"></i>{{$user_info->phone_number}}</li>
                            </ul>
                        </li>

                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Shipping address</h5>
                                {{--<a class="link" href="javascript:;">Edit</a>--}}
                            </div>

                            <span class="d-block text-body">
                                {{$address->full_address." ".$address->pincode}}
                           </span>
                        </li>

                        <li class="list-group-item">

                            {{--<div class="mt-3">--}}
                            {{--<h5 class="mb-0">Mastercard</h5>--}}
                            {{--<span class="d-block text-body">Card Number: ************4291</span>--}}
                            {{--</div>--}}
                        </li>
                    </ul>
                    <!-- End List Group -->
                </div>
                <!-- End Body -->
            </div>
            <!-- End Card -->
        </div>
    </div>
    <!-- End Row -->
</div>
@include('admin/common/footer')
<script>
    (function () {
        window.onload = function () {


            // INITIALIZATION OF NAVBAR VERTICAL ASIDE
            // =======================================================
            new HSSideNav('.js-navbar-vertical-aside').init()


            // INITIALIZATION OF FORM SEARCH
            // =======================================================
            new HSFormSearch('.js-form-search')


            // INITIALIZATION OF BOOTSTRAP DROPDOWN
            // =======================================================
            HSBsDropdown.init()


            // INITIALIZATION OF CHARTJS
            // =======================================================
            HSCore.components.HSChartJS.init('.js-chart')


            // INITIALIZATION OF VECTOR MAP
            // =======================================================
            setTimeout(() => {
                HSCore.components.HSJsVectorMap.init('.js-jsvectormap', {
                    backgroundColor: HSThemeAppearance.getAppearance() === 'dark' ? '#25282a' : '#ffffff'
                })

                const vectorMap = HSCore.components.HSJsVectorMap.getItem(0)

                window.addEventListener('on-hs-appearance-change', e => {
                    vectorMap.setBackgroundColor(e.detail === 'dark' ? '#25282a' : '#ffffff')
                })
            }, 300)


            // INITIALIZATION OF SELECT
            // =======================================================
            HSCore.components.HSTomSelect.init('.js-select')
        }
    })()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $(".order_status_change").on('change', function () {
            var status = $(this).val();
            var href = $(this).attr('data-href');
            var id = $(this).attr('data-id');
            $.ajax({
                method: "POST",
                url: href,
                data: {status: status, id: id},
                success: function (res) {
                    if (res > 0) {
                        bootbox.alert({
                            message: '<h3>Order Status Change Successfully.</h3>',
                            className: 'rubberBand animated',
                            centerVertical: true,

                        });
                    } else {
                        bootbox.alert({
                            message: '<h3>Something went wrong.</h3>',
                            className: 'rubberBand animated',
                            centerVertical: true,

                        });
                    }
                }
            });
        });
    });
</script>
