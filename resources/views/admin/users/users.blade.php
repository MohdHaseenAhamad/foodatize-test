@include('admin/common/header')
@include('admin/common/left-side-bar')

<!-- Content -->
<div>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0);">Dashboad</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:void(0);">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
                        </ol>
                    </nav>

                    <h1 class="page-header-title">Users</h1>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="users-add-user.html">
                        <i class="bi-person-plus-fill me-1"></i> Add user
                    </a>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Total users</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">24</span>
                                <span class="text-body fs-5 ms-1">from 22</span>
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                  <span class="badge bg-soft-success text-success p-1">
                    <i class="bi-graph-up"></i> 5.0%
                  </span>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">Active members</h6>

                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">12</span>
                                <span class="text-body fs-5 ms-1">from 11</span>
                            </div>

                            <div class="col-auto">
                  <span class="badge bg-soft-success text-success p-1">
                    <i class="bi-graph-up"></i> 1.2%
                  </span>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Card -->
            </div>

        </div>
        <!-- End Stats -->

        <!-- Card -->
        @livewire('admin.users')
        <!-- End Card -->
    </div>
</div>


@include('admin/common/footer')



<!-- JS Plugins Init. -->
