@include('admin/common/header')
@include('admin/common/left-side-bar')
<?php
    define('ORDER_STATUS',array('pending'=>'Pending','processing'=>'Processing','completed'=>'Completed','decline'=>'Decline'))
?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center mb-3">
            <div class="col-sm">
                <h1 class="page-header-title">Orders <span class="badge bg-soft-dark text-dark ms-2">106,905</span></h1>

                <div class="d-flex mt-2">
                    <a class="text-body me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exportOrdersModal">
                        <i class="bi-download me-1"></i> Export
                    </a>

                    <!-- Dropdown -->
                    <div class="dropdowm">
                        <a class="text-body" href="javascript:;" id="moreOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            More options <i class="bi-chevron-down"></i>
                        </a>

                        <div class="dropdown-menu mt-1" aria-labelledby="moreOptionsDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="bi-folder-plus dropdown-item-icon"></i> New order
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="bi-folder dropdown-item-icon"></i> New order - Development
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="bi-folder dropdown-item-icon"></i> New order - Staging
                            </a>
                        </div>
                    </div>
                    <!-- End Dropdown -->
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->

        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
          <span class="hs-nav-scroller-arrow-prev" style="display: none;">
            <a class="hs-nav-scroller-arrow-link" href="javascript:;">
              <i class="bi-chevron-left"></i>
            </a>
          </span>

            <span class="hs-nav-scroller-arrow-next" style="display: none;">
            <a class="hs-nav-scroller-arrow-link" href="javascript:;">
              <i class="bi-chevron-right"></i>
            </a>
          </span>

            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">All products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Open</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Unfulfilled</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Unpaid</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
    <!-- End Page Header -->

    <div class="row justify-content-end mb-3">
        <div class="col-lg">
            <!-- Datatable Info -->
            <div id="datatableCounterInfo" style="display: none;">
                <div class="d-sm-flex justify-content-lg-end align-items-sm-center">
              <span class="d-block d-sm-inline-block fs-5 me-3 mb-2 mb-sm-0">
                <span id="datatableCounter">0</span>
                Selected
              </span>
                    <a class="btn btn-outline-danger btn-sm mb-2 mb-sm-0 me-2" href="javascript:;">
                        <i class="bi-trash"></i> Delete
                    </a>
                    <a class="btn btn-white btn-sm mb-2 mb-sm-0 me-2" href="javascript:;">
                        <i class="bi-archive"></i> Archive
                    </a>
                    <a class="btn btn-white btn-sm mb-2 mb-sm-0 me-2" href="javascript:;">
                        <i class="bi-upload"></i> Publish
                    </a>
                    <a class="btn btn-white btn-sm mb-2 mb-sm-0" href="javascript:;">
                        <i class="bi-x-lg"></i> Unpublish
                    </a>
                </div>
            </div>
            <!-- End Datatable Info -->
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->

    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
            <div class="mb-2 mb-md-0">
                <form>
                    <!-- Search -->
                    <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend input-group-text">
                            <i class="bi-search"></i>
                        </div>
                        <input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
                    </div>
                    <!-- End Search -->
                </form>
            </div>

            <div class="d-grid d-sm-flex gap-2">
                <!-- Dropdown -->
                <div class="dropdown">
                    <button type="button" class="btn btn-white btn-sm dropdown-toggle w-100" id="usersExportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-download me-2"></i> Export
                    </button>

                    <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="usersExportDropdown">
                        <span class="dropdown-header">Options</span>
                        <a id="export-copy" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/illustrations/copy-icon.svg" alt="Image Description">
                            Copy
                        </a>
                        <a id="export-print" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/illustrations/print-icon.svg" alt="Image Description">
                            Print
                        </a>
                        <div class="dropdown-divider"></div>
                        <span class="dropdown-header">Download options</span>
                        <a id="export-excel" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/brands/excel-icon.svg" alt="Image Description">
                            Excel
                        </a>
                        <a id="export-csv" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/components/placeholder-csv-format.svg" alt="Image Description">
                            .CSV
                        </a>
                        <a id="export-pdf" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/brands/pdf-icon.svg" alt="Image Description">
                            PDF
                        </a>
                    </div>
                </div>
                <!-- End Dropdown -->

                <!-- Dropdown -->
                <div class="dropdown">
                    <button type="button" class="btn btn-white btn-sm w-100" id="showHideDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <i class="bi-table me-1"></i> Columns <span class="badge bg-soft-dark text-dark rounded-circle ms-1">7</span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end dropdown-card" aria-labelledby="showHideDropdown" style="width: 15rem;">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="d-grid gap-3">
                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_order">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Order</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_order" checked>
                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_date">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Date</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_date" checked>
                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_customer">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Customer</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_customer" checked>
                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_payment_status">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Payment status</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_payment_status" checked>
                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_fulfillment_status">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Fulfillment status</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_fulfillment_status" checked>
                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_payment_method">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Payment method</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_payment_method" checked>
                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_total">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Total</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_total">
                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch" for="toggleColumn_actions">
                        <span class="col-8 col-sm-9 ms-0">
                          <span class="me-2">Actions</span>
                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                          <input type="checkbox" class="form-check-input" id="toggleColumn_actions" checked>
                        </span>
                                    </label>
                                    <!-- End Form Switch -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Dropdown -->
            </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%" data-hs-datatables-options='{
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
                            <select class="js-select js-datatable-filter form-select form-select-sm order_status_change" data-id="{{$order->id}}" data-href="{{url('admin/orders/change-status/'.$order->id)}}" data-target-column-index="2" data-hs-tom-select-options='{
                                      "placeholder": "Any",
                                      "searchInDropdown": false,
                                      "hideSearch": true,
                                      "dropdownWidth": "10rem"
                                    }'>
                                <?php
                                foreach (ORDER_STATUS as $key => $value)
                                    {
                                        ?>
                                    <option value="{{$key}}" {{$order->status ==$key ? 'selected="selected"':''}}>{{$value}}</option>
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
                            <a class="btn btn-white btn-sm" href="ecommerce-order-details.html">
                                <i class="bi-eye"></i> View
                            </a>

                            <!-- Button Group -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="ordersExportDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>

                                <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="ordersExportDropdown1">
                                    <span class="dropdown-header">Options</span>
                                    <a class="js-export-copy dropdown-item" href="javascript:;">
                                        <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/illustrations/copy-icon.svg" alt="Image Description">
                                        Copy
                                    </a>
                                    <a class="js-export-print dropdown-item" href="javascript:;">
                                        <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/illustrations/print-icon.svg" alt="Image Description">
                                        Print
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <span class="dropdown-header">Download options</span>
                                    <a class="js-export-excel dropdown-item" href="javascript:;">
                                        <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/brands/excel-icon.svg" alt="Image Description">
                                        Excel
                                    </a>
                                    <a class="js-export-csv dropdown-item" href="javascript:;">
                                        <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/components/placeholder-csv-format.svg" alt="Image Description">
                                        .CSV
                                    </a>
                                    <a class="js-export-pdf dropdown-item" href="javascript:;">
                                        <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/brands/pdf-icon.svg" alt="Image Description">
                                        PDF
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:;">
                                        <i class="bi-trash dropdown-item-icon"></i> Delete
                                    </a>
                                </div>
                            </div>
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
                            <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
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
<script>
    (function() {
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
       $(".order_status_change").on('change',function () {
           var status = $(this).val();
           var href = $(this).attr('data-href');
           var id = $(this).attr('data-id');
           $.ajax({
               method:"POST",
               url:href,
               data:{status:status,id:id},
               success:function (res) {
                   if(res > 0)
                   {
                       bootbox.alert({
                           message: '<h3>Order Status Change Successfully.</h3>',
                           className: 'rubberBand animated',
                           centerVertical: true,

                       });
                   }
                   else
                   {
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
