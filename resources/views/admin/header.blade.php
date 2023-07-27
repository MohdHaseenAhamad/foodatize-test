<?php
/**
 * Created by PhpStorm.
 * User: MG-CLIENT-14
 * Date: 7/26/2023
 * Time: 4:38 PM
 */
?>

@include('admin/common/header')

<!-- ========== END HEADER ========== -->

<!-- ========== MAIN CONTENT ========== -->
<!-- Navbar Vertical -->
@include('admin/common/left-side-bar')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


<!-- Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Dashboard</h1>
            </div>
            <!-- End Col -->

            {{--<div class="col-auto">--}}
                {{--<a class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#inviteUserModal">--}}
                    {{--<i class="bi-person-plus-fill me-1"></i> Export--}}
                {{--</a>--}}
            {{--</div>--}}
            <div class="col-auto">

            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->


    <!-- Card -->
    <div class="card mb-3 mb-lg-5">
        <!-- Header -->
        <!-- End Header -->

        <!-- Table -->

        <div class="table-responsive datatable-custom">

            <table id="datatable"
                   class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table2excel table2excel_with_colors">
                <thead class="thead-light ">
                <tr>
                    <th scope="col" class="table-column-pe-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                            <label class="form-check-label" for="datatableCheckAll"></label>
                        </div>
                    </th>
                    <?php
                    foreach ($table_header as $key =>$value)
                    {
                    ?>
                    <th><?=$value->name?></th>
                    <?php
                    }?>
                </tr>
                </thead>

                <tbody>



                </tbody>
            </table>
            <button class="btn btn-primary exportToExcel">Export to XLS</button>
        </div>
        <!-- End Table -->

        <!-- Footer -->

        <!-- End Footer -->
    </div>
    <!-- End Card -->


</div>
<!-- End Content -->

<!-- Footer -->

<!-- ========== END MAIN CONTENT ========== -->

<!-- End Edit user -->

<!-- End Body -->

<script>
    $(function() {
        $(".exportToExcel").click(function(e){
            var table = $(this).prev('.table2excel');
            console.log(table);
            if(table && table.length){
                // var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors:true
                });
            }
        });

    });
</script>
@include('admin/common/footer')


