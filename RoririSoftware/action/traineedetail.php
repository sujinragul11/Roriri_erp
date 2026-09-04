<?php
session_start();
include("../../db/dbConnection.php");

$id = $_GET['id'] ?? null;
if ($id === null) {
    // Redirect to Trainee.php if no ID is provided
    header("Location: Trainee.php");
    exit();
}

$query = "SELECT * FROM student_tbl 
          INNER JOIN course_tbl ON course_tbl.course_id = student_tbl.course
          INNER JOIN admin_tbl ON admin_tbl.id = student_tbl.user_id
          WHERE id = $id";
$data = $conn->query($query);

if ($data === false) {
    // Handle error
    echo "Error executing query: " . $conn->error;
    exit();
}

$value = $data->fetch_assoc();

if ($value === null) {
    // No record found, handle accordingly
    echo "No record found for the given ID.";
    exit();
}
?>
<!doctype html>
<html lang="en">

<?php include("head.php"); ?>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php include("left.php"); ?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php include("top.php"); ?>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <div class="container">
                    <div class="main-body">
                        <div class="modal-footer p-2">
                            <button type="button" class="btn btn-danger" onclick="javascript:location.href='Trainee.php'">Back</button>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            
                                            <img src="../upload/<?php echo $value['image']; ?>" alt="no image" class="rounded-circle p-1 bg-primary" width="110">
                                            <div class="mt-3">
                                                <h4><?php echo $value['firstname']; ?></h4>
                                                <p class="text-secondary mb-1"><?php echo $value['course_name']; ?></p>
                                                <p class="text-secondary mb-1"><?php echo $value['duration']; ?></p>
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
                                                <p class="text-secondary mb-1"><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Gender</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['gender']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-4 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Username</h6>
                                            </div>
                                            <div class="col-sm-4 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['username']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Password</h6>
                                            </div>
                                            <div class="col-sm-4 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['pass']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Subject</h6>
                                            </div>
                                            <div class="col-sm-4 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['subject']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Mobile</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['phone_number']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Address</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['address']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Location</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['location']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Date of Birth</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['dob']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Aadhar_number</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['aadhar_number']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Discount Amount</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['discount_fee']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Fee</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['fee']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">Mode</h6>
                                            </div>
                                            <div class="col-sm-3 text-secondary">
                                                <p class="text-secondary mb-1"><?php echo $value['mode']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--End page-content-->
        </div><!--end page-wrapper-->
        
        <!--end page wrapper -->
        <!--start overlay-->
        <?php include("footer.php"); ?>
    </div>
    <!--end wrapper-->

    <!--start switcher-->
    <?php include("themes.php"); ?>
    <!--end switcher-->
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
            location.href = "view.php?id=" + id;
        }

        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('fast');
            }, 5000);
        });
    </script>
<script src="../../assets/js/form-validation.js"></script>
</body>
</html>
