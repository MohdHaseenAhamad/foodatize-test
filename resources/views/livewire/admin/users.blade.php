<div>
<?php if(session()->has('success'))
    {
        ?>
<div class="alert alert-success" role="alert">
    {{ session()->get('success') }}
</div>
<?php
    }
    if(session()->has('error'))
    {
        ?>
<div class="alert alert-danger" role="alert">
    {{ session()->get('error') }}
</div>
<?php
    }
    ?>

<div class="card">
    <!-- Header -->
    <!-- End Header -->

    <!-- Table -->
    <div class="table-responsive datatable-custom position-relative">
        <table id="datatable"
               class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
            <thead class="thead-light">
            <tr>
                <th class="table-column-pe-0">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                        <label class="form-check-label" for="datatableCheckAll"></label>
                    </div>
                </th>
                <th class="table-column-ps-0">Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
<!--            --><?php //var_dump($users) ?>
            @if (count($users) > 0)
                @foreach ($users as $user)
            <tr>
                <td class="table-column-pe-0">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll1">
                        <label class="form-check-label" for="datatableCheckAll1"></label>
                    </div>
                </td>
                <td class="table-column-ps-0">
                    <a class="d-flex align-items-center" href="user-profile.html">
                        <div class="avatar avatar-circle">
                            <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                        </div>
                        <div class="ms-3">
                                    <span class="d-block h5 text-inherit mb-0">{{$user->name}} <i
                                            class="bi-patch-check-fill text-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Top endorsed"></i></span>
                            <span class="d-block fs-5 text-body">amanda@site.com</span>
                        </div>
                    </a>
                </td>
                <td>
                    {{$user->phone_number}}
                </td>
                <td>  {{$user->email}}</td>
                <td>
                    <span class="legend-indicator bg-success"></span>{{$user->status == 1 ? 'Active':'Inactive'}}
                </td>
                <td>
                    <button  wire:click="deleteUser({{$user->id}})" class="btn btn-white btn-sm">
                        <i class="bi-pencil-fill me-1"></i> Delete
                    </button >

                    <a href="" class="btn btn-white btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editUserModal">
                        <i class="bi-pencil-fill me-1"></i> Edit
                    </a>

                </td>
            </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" align="center">
                        No Posts Found.
                    </td>
                </tr>
            @endif
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
                        <select id="datatableEntries"
                                class="js-select form-select form-select-borderless w-auto" autocomplete="off"
                                data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }'>
                            <option value="10">10</option>
                            <option value="15" selected>15</option>
                            <option value="20">20</option>
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
</div>
