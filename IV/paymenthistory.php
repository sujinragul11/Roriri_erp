
<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit(); // Stop further script execution
}
?>
<!DOCTYPE html>
<html lang="en">
   <?php include "head.php"; ?>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <?php include "left.php"; ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <?php include "right.php"; ?>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            
                            <!-- end page title end breadcrumb -->
                            

                           <!--end row-->
            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Payment History</h4>
                                            
                                            <table id="paymnetTabl" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                 <tr>
                                                     <th>#</th>
                                                    <th>Date</th>
                                                    <th>Reason</th>
                                                    <th>Food Package</th>
                                                    <th>Total Amount</th>
                                                    <th>Payment Status</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                               
                                                
                                                </tbody>
                                            </table>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    Â© 2022 IV by RoririSoft.
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    <script src="../assets/js/form-validation.js"></script>
</body>
</html>

<script>
$(document).ready(function() {
    var table = $('#paymnetTabl').DataTable({
        "processing": true,      // Show a 'processing' indicator
        "serverSide": true,      // Enable server-side processing
        "ajax": {
            "url": "action/getPaymentTable.php", // Path to your server-side script
            "type": "POST"
        },
        "columns": [
            { "data": null, "render": function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1; // Increment index based on display start
            }},
            { "data": "paid_date" },
            { "data": "reason" },
            { "data": "name" },
            { "data": "amount" },
            { "data": "pay_status", "render": function(data) {
                return data === 'Paid' ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-danger">Unpaid</span>';
            }}
        ],
        "lengthChange": false,   // Disable the ability to change page length
        "buttons": ['copy', 'excel', 'pdf', 'colvis'] // Add buttons
    });

    // Place buttons container above the table
    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
});



    
    
</script>

