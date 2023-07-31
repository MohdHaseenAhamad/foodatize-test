<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white  ">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->

            <a class="navbar-brand" href="index.blade.php" aria-label="Front">
                <img class="navbar-brand-logo" src="{{ asset('assets/svg/logos/logo.svg') }}" alt="Logo"
                     data-hs-theme-appearance="default">
                <img class="navbar-brand-logo" src="{{ asset('assets/svg/logos-light/logo.svg') }}" alt="Logo"
                     data-hs-theme-appearance="dark">
                <img class="navbar-brand-logo-mini" src="{{ asset('assets/svg/logos/logo-short.svg') }}" alt="Logo"
                     data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini" src="{{ asset('assets/svg/logos-light/logo-short.svg') }}"
                     alt="Logo" data-hs-theme-appearance="dark">
            </a>

            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align"
                   data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
                <i class="bi-arrow-bar-right navbar-toggler-full-align"
                   data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
            </button>

            <!-- End Navbar Vertical Toggle -->

            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
                    <!-- Collapse -->

                    <!-- End Collapse -->

                    <span class="dropdown-header mt-4">Pages</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>

                    <!-- Collapse -->
                    <div class="navbar-nav nav-compact">

                    </div>


                    <!-- End Collapse -->


                    <!-- End Collapse -->

                    <!-- Collapse -->

                    <div class="nav-item">
                        <a class="nav-link " href="{{ url('admin') }}" data-placement="left">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">Dashboards</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link " href="{{ url('admin/orders') }}" data-placement="left">
                            <i class="bi-key nav-icon"></i>
                            <span class="nav-link-title">Orders</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link " href="{{ url('admin/users') }}" data-placement="left">
                            <i class="bi-people nav-icon"></i>
                            <span class="nav-link-title">
                                    Customers</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link " href="{{ url('admin/products') }}" data-placement="left">
                            <i class="bi-key nav-icon"></i>
                            <span class="nav-link-title">Products</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link " href="{{ url('admin/products/add') }}" data-placement="left">
                            <i class="bi-key nav-icon"></i>
                            <span class="nav-link-title">Add Product</span>
                        </a>
                    </div>
                    <!-- End Collapse -->

                    <!-- Collapse -->

                </div>
                <!-- End Collapse -->


            </div>

        </div>
        <!-- End Content -->

        <!-- Footer -->

        <!-- End Footer -->
    </div>
    </div>
</aside>
<main id="content" role="main" class="main">
