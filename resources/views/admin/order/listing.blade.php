@include('admin/common/header')
@include('admin/common/left-side-bar')
<?php
define('ORDER_STATUS', array('pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'decline' => 'Decline'))
?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center mb-3">
            <div class="col-sm">
                <h1 class="page-header-title">Orders <span
                        class="badge bg-soft-dark text-dark ms-2">{{count($orders)}}</span></h1>


            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->

        <!-- Nav Scroller -->

        <!-- End Nav Scroller -->
    </div>
    <!-- End Page Header -->


    <!-- End Row -->

    <!-- Card -->
    <div class="card">
        <!-- Header -->

        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="datatable"
                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                   style="width: 100%" data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0],
                      "orderable": false
                    }],
                   "order": [],
                   "info": {
                     "totalQty": "#datatableWithPaginationInfoTotalQty"
                   },
                   "search": "#datatableSearch",
                   "entries": "#datatableEntries",
                   "pageLength": 12,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "datatablePagination"
                 }'>
                <thead class="thead-light">
                <tr>
                    <th class="table-column-pe-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                            <label class="form-check-label" for="datatableCheckAll"></label>
                        </div>
                    </th>
                    <th class="table-column-ps-0">Order</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Payment status</th>
                    <th>Order status</th>
                    <th>Payment method</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($orders as $order){
                ?>
                <tr>
                    <td class="table-column-pe-0">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="ordersCheck1">
                            <label class="form-check-label" for="ordersCheck1"></label>
                        </div>
                    </td>
                    <td class="table-column-ps-0">
                        <a href="ecommerce-order-details.html">{{$order->order_number}}</a>
                    </td>
                    <td>{{$order->order_time}}</td>
                    <td>
                        <a class="text-body" href="ecommerce-customer-details.html">{{$order->name}}</a>
                    </td>
                    <td>
                  <span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>{{$order->payment_status == 1 ?  'Paid':'Unpaid'}}
                  </span>
                    </td>
                    <td>
                        <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select form-select-sm order_status_change"
                                    data-id="{{$order->id}}"
                                    data-href="{{url('admin/orders/change-status/'.$order->id)}}"
                                    data-target-column-index="2" data-hs-tom-select-options='{
                                      "placeholder": "Any",
                                      "searchInDropdown": false,
                                      "hideSearch": true,
                                      "dropdownWidth": "10rem"
                                    }'>
                                <?php
                                foreach (ORDER_STATUS as $key => $value)
                                {
                                ?>
                                <option
                                    value="{{$key}}" {{$order->status ==$key ? 'selected="selected"':''}}>{{$value}}</option>
                                <?php
                                }
                                ?>

                            </select>
                            <!-- End Select -->
                        </div>
                    </td>
                    <td>
                        {{$order->payment_method == 101 ? 'COD':'POD'}}
                    </td>
                    <td>{{$order->final_amount}}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a class="btn btn-white btn-sm" href="{{url('admin/orders/detail/'.$order->id)}}">
                                <i class="bi-eye"></i> View
                            </a>

                            <!-- Button Group -->

                            <!-- End Unfold -->
                        </div>
                    </td>
                </tr>
                <?php
                } ?>


                </tbody>
            </table>
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="card-footer">
            <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                        <span class="me-2">Showing:</span>

                        <!-- Select -->
                        <div class="tom-select-custom">
                            <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto"
                                    autocomplete="off" data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }'>
                                <option value="12" selected>12</option>
                                <option value="14">14</option>
                                <option value="16">16</option>
                                <option value="18">18</option>
                            </select>
                        </div>
                        <!-- End Select -->

                        <span class="text-secondary me-2">of</span>

                        <!-- Pagination Quantity -->
                        <span id="datatableWithPaginationInfoTotalQty"></span>
                    </div>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                    <div class="d-flex justify-content-center justify-content-sm-end">
                        <!-- Pagination -->
                        <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Footer -->
    </div>
    <!-- End Card -->
</div>

@include('admin/common/footer')
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
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
                            // message: '<h3>Order Status Change Successfully.</h3>',
                            message: res,
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
