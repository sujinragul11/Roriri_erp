<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Zoogler - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!--calendar css-->
        <link href="assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <?php include "left.php" ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <?php include "right.php" ?>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">Zoogler</a></li>
                                                <li class="breadcrumb-item active">Calendar</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Calendar</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-3 col-md-4">
            
                                                    <h4 class="m-t-5 m-b-15 font-16">Created Events</h4>
                                                    <form method="post" id="add_event_form" class="m-t-5 m-b-20 needs-validation" novalidate>
                                                        <input type="text" class="form-control new-event-form" placeholder="Add new event..." />
                                                    </form>
            
                                                    <div id='external-events'>
                                                        <h4 class="m-b-15 font-16">Draggable Events</h4>
                                                        <div class='fc-event'>My Event 1</div>
                                                        <div class='fc-event'>My Event 2</div>
                                                        <div class='fc-event'>My Event 3</div>
                                                        <div class='fc-event'>My Event 4</div>
                                                        <div class='fc-event'>My Event 5</div>
                                                    </div>
            
                                                    <!-- checkbox -->
                                                    <div class="custom-control custom-checkbox mt-3">
                                                        <input type="checkbox" class="custom-control-input" id="drop-remove" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                                        <label class="custom-control-label" for="drop-remove">Remove after drop</label>
                                                    </div>
            
                                                </div>
            
                                                <div id='calendar' class="col-xl-10 col-lg-9 col-md-8"></div>
            
                                            </div>
                                            <!-- end row -->
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->                
    

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    Â© 2023 IV by RoririSoft.
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

        <!-- Jquery-Ui -->
        <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/plugins/moment/moment.js"></script>
        <script src='assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
        <script src="assets/pages/calendar-init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    <script src="../assets/js/form-validation.js"></script>
</body>
</html>