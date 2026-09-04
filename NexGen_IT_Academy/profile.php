<?php
session_start();
include("C:\\xampp\\htdocs\\ERP\\db\\dbConnection.php"); // Include your database connection file

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Fetch trainee details
$query = "SELECT * FROM student_tbl INNER JOIN admin_tbl ON admin_tbl.id = student_tbl.user_id INNER JOIN course_tbl ON course_tbl.course_id=student_tbl.course
INNER JOIN position_tbl ON position_tbl.position_id = student_tbl.role_id WHERE admin_tbl.username = '" . mysqli_real_escape_string($conn, $username) . "'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error executing query: " . mysqli_error($conn);
    exit;
}

$trainee = mysqli_fetch_assoc($result);

// Check if trainee data is fetched successfully
if (!$trainee) {
    echo "No trainee found with username: " . htmlspecialchars($username);
    exit;
}
?>

<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php include("left.php");?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php include("top.php");?>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="container">
                    <div class="main-body">
                        <div class="modal-footer p-2">
                            <button type="button" class="btn btn-danger" onclick="javascript:location.href=''">Back</button>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="../../image/<?php echo $trainee['image']?> "alt="no image" class="rounded-circle p-1 bg-primary" width="110">
                                            <div class="mt-3">
                                                <h4><?php echo htmlspecialchars($trainee['firstname']); ?></h4>
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['course_name']); ?></p>
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['duration']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Full Name</h6>
                                            </div>
                                            <div class="col-sm-4 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['firstname'] . ' ' . $trainee['lastname']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Gender</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['gender']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-4 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['email']); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Username</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['username']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Password</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['pass']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Date of Birth</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['dob']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Subject</h6>
                                            </div>
                                            <div class="col-sm-4 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['subject']); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Role</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['position_name']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Discount Amount</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['discount_fee']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Fee</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['fee']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Mode</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo htmlspecialchars($trainee['mode']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End page-content -->
        </div><!-- end page-wrapper -->

        <!--end page wrapper -->
        <!--start overlay-->
        <?php include("footer.php"); ?>
    </div>
    <!--end wrapper-->

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <!-- Include Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <script>
        function goViewEmp(id) {
            alert(id);
            location.href = "employeeDetails.php?id=" + id;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
<script src="../assets/js/form-validation.js"></script>
</body>
</html>
