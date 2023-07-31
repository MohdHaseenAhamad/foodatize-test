@include('admin/common/header')
@include('admin/common/left-side-bar')

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="ecommerce-products.html">Products</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>

                <h1 class="page-header-title">Edit Product</h1>

            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->
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
    <form method="POST" action="{{url('admin/products/update/'.$id)}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Product information</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form -->
                        <div class="mb-4">
                            <label for="name" class="form-label">Name <i
                                    class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Products are the goods or services you sell."></i></label>

                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="" aria-label=""
                                   value="{{isset($result->name) ? $result->name:''}}">
                        </div>
                        <!-- End Form -->

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="price" class="form-label">Price</label>

                                    <input type="text" class="form-control" name="price" id="price"
                                           placeholder="eg. 348121032" aria-label="eg. 240" value="{{isset($result->price) ? $result->price:''}}">
                                </div>
                                <!-- End Form -->
                            </div>

                            <div class="col-sm-6">
                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="pieces" class="form-label">Pieces</label>

                                    <input type="text" class="form-control" name="pieces" id="pieces"
                                           placeholder="eg. 348121032" aria-label="eg. 12" value="{{isset($result->pieces) ? $result->pieces:''}}">
                                </div>
                                <!-- End Form -->
                            </div>
                            <div class="col-sm-6">
                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="quantity" class="form-label">Quantity</label>

                                    <input type="text" class="form-control" name="quantity" id="quantity"
                                           placeholder="eg. 348121032" aria-label="eg. 24" value="{{isset($result->quantity) ? $result->quantity:''}}">
                                </div>
                                <!-- End Form -->
                            </div>
                            <!-- End Col -->


                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                        <div class="mb-4">
                            <label class="form-label">Description <span class="form-label-secondary">(Optional)</span></label>

                            <textarea type="text" rows="3" class="form-control" name="description" id="description"
                                      placeholder="" aria-label=""
                            >{{isset($result->description) ? $result->description:''}}</textarea>
                        </div>

                        <!-- End Quill -->
                    </div>
                    <!-- Body -->
                </div>
                <!-- End Card -->

                <!-- Card -->

                <!-- End Card -->

                <!-- Card -->

                <!-- End Card -->
            </div>
            <!-- End Col -->

            <div class="col-lg-4">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title">Your Product Image</h4>

                        <!-- Dropdown -->

                        <!-- End Dropdown -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="dz-message">
                            <img class="avatar avatar-xl avatar-4x3 mb-3" src="{{isset($result->image) ? $result->image:''}}"
                                 alt="Image Description" data-hs-theme-appearance="default">
                            <img class="avatar avatar-xl avatar-4x3 mb-3"
                                 src="{{isset($result->image) ? $result->image:''}}" alt="Image Description"
                                 data-hs-theme-appearance="dark">
                        </div>
                        <!-- Dropzone -->
                        {{-- <div id="attachFilesNewProjectLabel" class="js-dropzone dz-dropzone dz-dropzone-card">
                            <div class="dz-message">
                                <img class="avatar avatar-xl avatar-4x3 mb-3" src="{{ asset('assets/svg/illustrations/oc-browse.svg') }}"
                                    alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xl avatar-4x3 mb-3"
                                    src="{{ asset('assets/svg/illustrations-light/oc-browse.svg') }}" alt="Image Description"
                                    data-hs-theme-appearance="dark">

                                <h5>Drag and drop your file here</h5>

                                <p class="mb-2">or</p>

                                <span class="btn btn-white btn-sm">Browse files</span>
                            </div>
                        </div> --}}
                        <label>
                            <input type="file" name="image" id="image" accept="image/*" value="{{isset($result->image) ? $result->image:''}}" />
                            <input type="hidden" name="old_image" value="{{isset($result->image) ? $result->image:''}}">
                        </label>
                        <!-- End Dropzone -->
                    </div>
                    <!-- Body -->
                </div>
                <!-- End Card -->

                <!-- Card -->

                <!-- End Card -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->

        <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;">
            <!-- Card -->
            <div class="card card-sm bg-dark border-dark mx-2">
                <div class="card-body">
                    <div class="row justify-content-center justify-content-sm-between">

                        <!-- End Col -->

                        <div class="col-auto">
                            <div class="d-flex gap-3">

                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div>
    </form>
</div>

<!-- End Add Image from URL Modal -->

<!-- Embed Video Modal -->

<!-- End Embed Video Modal -->

<!-- Products Advanced Features Modal -->

<!-- Builder -->


<!-- End Builder -->

<!-- Builder Toggle -->

@include('admin/common/footer')
<script>
    $(document).on('ready', function () {
        // INITIALIZATION OF DATATABLES
        // =======================================================
        HSCore.components.HSDatatables.init($('#datatable'), {
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                classMap: {
                    checkAll: '#datatableCheckAll',
                    counter: '#datatableCounter',
                    counterInfo: '#datatableCounterInfo'
                }
            }
        });
    });
</script>

<!-- JS Plugins Init. -->
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


            // INITIALIZATION OF SELECT
            // =======================================================
            HSCore.components.HSTomSelect.init('.js-select')


            // INITIALIZATION OF ADD FIELD
            // =======================================================
            new HSAddField('.js-add-field', {
                addedField: field => {
                    new HSQuantityCounter(field.querySelector('.js-quantity-counter-dynamic'))
                }
            })


            // INITIALIZATION OF  QUANTITY COUNTER
            // =======================================================
            new HSQuantityCounter('.js-quantity-counter-input')


            // INITIALIZATION OF DROPZONE
            // =======================================================
            HSCore.components.HSDropzone.init('.js-dropzone')


            // INITIALIZATION OF QUILLJS EDITOR
            // =======================================================
            HSCore.components.HSQuill.init('.js-quill')
        }
    })()
</script>

<!-- Style Switcher JS -->

<script>
    (function () {
        // STYLE SWITCHER
        // =======================================================
        const $dropdownBtn = document.getElementById('selectThemeDropdown') // Dropdowon trigger
        const $variants = document.querySelectorAll(`[aria-labelledby="selectThemeDropdown"] [data-icon]`) // All items of the dropdown

        // Function to set active style in the dorpdown menu and set icon for dropdown trigger
        const setActiveStyle = function () {
            $variants.forEach($item => {
                if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
                    $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`
                    return $item.classList.add('active')
                }

                $item.classList.remove('active')
            })
        }

        // Add a click event to all items of the dropdown to set the style
        $variants.forEach(function ($item) {
            $item.addEventListener('click', function () {
                HSThemeAppearance.setAppearance($item.getAttribute('data-value'))
            })
        })

        // Call the setActiveStyle on load page
        setActiveStyle()

        // Add event listener on change style to call the setActiveStyle function
        window.addEventListener('on-hs-appearance-change', function () {
            setActiveStyle()
        })
    })()
</script>
