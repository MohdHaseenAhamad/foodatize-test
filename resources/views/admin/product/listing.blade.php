

<!-- JS Plugins Init. -->
@include('admin/common/header')
@include('admin/common/left-side-bar')

<!-- Content -->
<!-- Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center mb-3">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                       href="javascript:void(0);">Dashboard</a></li>
                        <li class=" active" aria-current="page">&nbsp;&nbsp;/ Products</li>
                    </ol>
                </nav>

                <h1 class="page-header-title">Products <span class="badge bg-soft-dark text-dark ms-2">{{count($products)}}</span></h1>
            </div>

            <!-- End Col -->

            <div class="col-sm-auto">
                <a class="btn btn-primary" href="{{url('admin/products/add')}}">Add product</a>
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
        {{--<div class="card-header card-header-content-md-between">--}}
            {{--<div class="mb-2 mb-md-0">--}}
                {{--<form>--}}
                    {{--<!-- Search -->--}}
                    {{--<div class="input-group input-group-merge input-group-flush">--}}
                        {{--<div class="input-group-prepend input-group-text">--}}
                            {{--<i class="bi-search"></i>--}}
                        {{--</div>--}}
                        {{--<input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">--}}
                    {{--</div>--}}
                    {{--<!-- End Search -->--}}
                {{--</form>--}}
            {{--</div>--}}

        {{--</div>--}}
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0, 4, 9],
                      "width": "5%",
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
                    <th scope="col" class="table-column-pe-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                            <label class="form-check-label">
                            </label>
                        </div>
                    </th>
                    <th class="table-column-ps-0">Product</th>
                    {{--<th>Stocks</th>--}}
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($products as $product)
                    {
                        ?>
                <tr>
                    <td class="table-column-pe-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll1">
                            <label class="form-check-label" for="datatableCheckAll1"></label>
                        </div>
                    </td>
                    <td class="table-column-ps-0">
                        <a class="d-flex align-items-center" href="ecommerce-product-details.html">
                            <div class="flex-shrink-0">
                                <img class="avatar avatar-lg" src="{{$product->image}}" alt="Image Description">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="text-inherit mb-0">{{$product->name}}</h5>
                            </div>
                        </a>
                    </td>
                    {{--<td><div class="form-check form-switch">--}}
                            {{--<input class="form-check-input" type="checkbox" id="stocksCheckbox1" {{$product->quantity > 0 ? 'checked':''}}>--}}
                            {{--<label class="form-check-label" for="stocksCheckbox1"></label>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                    <td>
                       {{$product->price}}
                    </td>
                    <td>{{$product->quantity}}</td>

                    <td>
                        <div class="btn-group" role="group">
                            <a class="btn btn-white btn-sm" href="{{url('admin/products/edit/'.$product->id)}}">
                                <i class="bi-pencil-fill me-1"></i> Edit
                            </a>
                            <a class="btn btn-white btn-sm" href="{{url('admin/products/delete/'.$product->id)}}">
                                Delete
                            </a>

                        </div>
                    </td>
                </tr>
<?php
                    }?>



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
                                <option value="12">12</option>
                                <option value="14" selected>14</option>
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



<!-- JS Plugins Init. -->
