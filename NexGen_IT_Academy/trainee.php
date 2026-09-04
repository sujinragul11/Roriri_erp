<?php

session_start();
include("../db/dbConnection.php");
include("../url.php");

$id =$_SESSION['id'];

$selQuery = "SELECT
                a.*,
                b.*,
                c.incharge_name
            FROM
                basic_details AS a
            LEFT JOIN additional_details AS b
            ON
                b.basic_id = a.id
            LEFT JOIN trainee_additional_details AS c
            ON
                a.id = c.basic_id
            WHERE
                b.entity_id = 3 AND a.status = 'Active'  AND a.id !=86";

//   $Roles = [6 ,1,2,5,7,3,9,11,12,13,14,15]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainees_list_roles)) 
                          {
                            $selQuery .=" AND FIND_IN_SET($id , c.incharge_name) > 0";
                              
                          }

$resQuery = mysqli_query($conn, $selQuery);

?>
<!doctype html>
<html lang="en">

<?php include("head.php"); ?>

<body>
    <?php include("addTrainee.php"); ?>
    <?php include("editTrainee.php"); ?>
    <style>
     /* Apply Poppins font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
        .error-message {
            color: red;
            display: none;
        }

        .error {
            border-color: red;
        }
        
    #example2 {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
    }

    #example2 th, #example2 td {
        vertical-align: middle;
        text-align: left;
    }

    .coustome_btn {
        border: none;
        background: transparent;
        cursor: pointer;
        margin: 0 5px;
    }

    .coustome_btn i {
        font-size: 18px;
    }

    .coustome_btn:hover {
        opacity: 0.8;
    }

    .tooltip-inner {
        font-size: 12px;
    }
    
  /* Enhanced Styles for Filters */
    .card {
        border-radius: 8px;
        border: none;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control,
    .form-select {
        border-radius: 6px;
        border: 1px solid #ced4da;
    }

    .btn {
        border-radius: 6px;
        padding: 8px 16px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #565e64;
    }

    .w-48 {
        width: 48%;
    }

    @media (max-width: 768px) {
        .btn {
            width: 100%;
        }

        .w-48 {
            width: 100%;
        }
    }

    </style>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php
        if ($_SESSION['role'] == '10' || $_SESSION['is_admin'] == 'True') {
            include("top.php");
        } else {
            include("../RoririSoftware/top.php");
        }
        ?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php
        if ($_SESSION['role'] == '10' || $_SESSION['is_admin'] == 'True') {
            include("left.php");
        } else {
            include("../RoririSoftware/left.php");
        }
        ?>

        <!--end header -->
        <!--start page wrapper -->

        <div class="page-wrapper">


            <div class="page-content">


                <div class="page-title-box">

                    <div class="page-title-right">
                        <h2 class="page-title">Trainee</h2>
                        <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                            <?php if ($_SESSION['is_admin'] === 'True') { ?>
                                <button type="button" id="addTraineeBtn"
                                    class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal"
                                    data-bs-target="#addTraineeModal">Add Trainee</button>
                            <?php } ?>
                        </div>

                    </div>

                </div>

                <div class="card">
                    <div class="card-body">


     <div class="container-fluid py-4">
    <div class="card shadow-sm p-4">
        <div class="row g-3">
            <!-- Start Date -->
            <div class="col-md-3 col-12">
                <label for="reportStartDate" class="form-label">Start Date</label>
                <input type="date" id="reportStartDate" class="form-control" />
                <span id="startDateError" class="text-danger small"></span>
            </div>

            <!-- End Date -->
            <div class="col-md-3 col-12">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" id="endDate" class="form-control" />
                <span id="endDateError" class="text-danger small"></span>
            </div>

            <!-- Duration -->
            <div class="col-md-3 col-12">
                <label for="durationFilter" class="form-label">Duration (Months)</label>
                <input type="number" id="durationFilter" class="form-control" min="1" max="24" placeholder="Enter duration" />
                <span id="daysError" class="text-danger small"></span>
            </div>

            <!-- Course Name -->
            <div class="col-md-3 col-12">
                <label for="courseFilter" class="form-label">Course Name</label>
                <select id="courseFilter" class="form-select">
                    <option value="">-- Select Course --</option>
                    <?php
                    $queryCou = "SELECT id, course_name FROM academy_course_details WHERE status = 'Available'";
                    $resultCou = mysqli_query($conn, $queryCou);

                    if ($resultCou) {
                        while ($row = mysqli_fetch_assoc($resultCou)) {
                            $courseId = $row['id'];
                            $courseName = $row['course_name'];
                            echo "<option value=\"$courseId\">$courseName</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Slot Timing -->
            <div class="col-md-3 col-12">
                <label for="slotFilter" class="form-label">Slot Timing</label>
                <select id="slotFilter" class="form-select">
                    <option value="">-- Select Slot --</option>
                    <option value="9:30 - 1:30">9:30 - 1:30</option>
                    <option value="1:30 - 5:30">1:30 - 5:30</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-3 col-12 d-flex align-items-end">
                <div class="w-100 d-flex justify-content-between">
                    <button id="filterBtn" class="btn btn-primary w-48">Filter</button>
                    <button id="clearBtn" class="btn btn-secondary w-48">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>
                            <div class="table-responsive">
                                <table id="example2" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Name</th>
                                            <th>ID</th>
                                            <th>Phone</th>
                                            <!-- <th>Project</th> -->
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {

                                            $trainee_id = $row['id'];
                                            $trainee_name = $row['name'];
                                            $trainee_reg = $row['reg_no'];
                                            $trainee_phone = $row['phone'];
                                            $trainee_pemail = $row['email'];
                                            $username = $row['username'];
                                            ?>
                                            <tr>
                                                <td><?php echo $i;
                                                $i++; ?></td>
                                                <td><?php echo $trainee_name; ?></td>
                                                <td><?php echo $trainee_reg; ?></th>
                                                <td><?php echo $trainee_phone; ?></td>
                                                <td><?php echo $trainee_pemail; ?></td>
                                                <td>
                                                    <?php
                                                    if ($_SESSION['is_admin'] == 'True') { ?>
                                                        <button class="coustome_btn text-success" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="View"
                                                            onclick="goViewTrainee(<?php echo $trainee_id; ?>, '<?php echo $username; ?>');"><i
                                                                class="lni lni-eye"></i></button>
                                                        <?php
                                                        if ($_SESSION['role_name'] == 'Super Admin') { ?>
                                                            <button type="button" class="coustome_btn text-warning"
                                                                onclick="goEditTrainee(<?php echo $trainee_id; ?>);"
                                                                data-bs-toggle="modal" data-bs-target="#editTraineeModal"><i
                                                                    class="lni lni-pencil"></i></button>
                                                            <button class="coustome_btn text-danger" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Delete"
                                                                onclick="goDeleteTrainee(<?php echo $trainee_id; ?>);"><i
                                                                    class="lni lni-trash"></i></button>
                                                        <?php }
                                                    } ?>

                                <a href="listSyllabus.php?traineeId=<?php echo $trainee_id; ?>">
                                    <button class="coustome_btn text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Syllabus">
                                        <i class="bi bi-book"></i>
                                    </button>
                                </a>
                                <a href="listApplication.php?traineeId=<?php echo $trainee_id; ?>">
                                    <button class="coustome_btn text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Application">
                                        <i class="bi bi-file-text"></i>
                                    </button>
                                </a>
                                <a href="traineeMiniProject.php?traineeId=<?php echo $trainee_id; ?>">
                                    <button class="coustome_btn text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Projects">
                                        <i class="bi bi-diagram-3"></i>
                                    </button>
                                </a>
                              


                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <!-- <tfoot>
                                    <tr>
                                    <th>S. No</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot> -->
                                </table>
                            </div>
                        
                    </div>
                </div><!--end page-content-->
            </div>

            <!--end page wrapper -->
            <!--start overlay-->
            <?php include("footer.php"); ?>
        </div>
        <!--end wrapper-->






        <!--start switcher-->

        <!--end switcher-->
        <!-- Bootstrap JS -->
        <!-- Bootstrap JS -->
        <script src="<?php echo $bootsrapBundle; ?>"></script>
        <!--plugins-->
        <script src="<?php echo $js; ?>"></script>
        <script src="<?php echo $simplebar; ?>"></script>
        <script src="<?php echo $mentimenu; ?>"></script>
        <script src="<?php echo $perfectScrolbar; ?>"></script>
        <script src="<?php echo $datatableMin; ?>"></script>
        <script src="<?php echo $datatbaleBootstrap; ?>"></script>
        <!-- Include Bootstrap JS (with Popper) -->
        <script src="<?php echo $popper; ?>"></script>
        <script src="<?php echo $bootStackPath; ?>"></script>
        <script src="<?php echo $sweetalert; ?>"></script>
        	<script src="<?php echo $select2; ?>"></script>
	        <script src="<?php echo $select2Custom;?>"></script>
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <!-- Initialize tooltips -->
        <script>
         $( '#employee' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#employee' ).parent(),
    } );
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
        <script>
            $(document).ready(function () {
                var table = $('#example2').DataTable({
                    lengthChange: true,
                    // buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            });
        </script>
        <script>

            function handleReferredByChange() {
                const referredBy = document.getElementById('referredBy').value;
                const otherReferredDiv = document.getElementById('otherReferredDiv');
                const otherReferredName = document.getElementById('otherReferredName');

                if (referredBy === 'others') {
                    otherReferredDiv.style.display = 'block';
                    otherReferredName.setAttribute('required', 'required');
                } else {
                    otherReferredDiv.style.display = 'none';
                    otherReferredName.removeAttribute('required');
                    otherReferredName.value = ''; // Clear the field if hidden
                }
            }

            function handleReferredByChangeEdit() {
                const referredBy = document.getElementById('referredByEdit').value;
                const otherReferredDiv = document.getElementById('otherReferredDivEdit');
                const otherReferredName = document.getElementById('otherReferredNameEdit');

                if (referredBy === 'others') {
                    otherReferredDiv.style.display = 'block';
                    otherReferredName.setAttribute('required', 'required');
                } else {
                    otherReferredDiv.style.display = 'none';
                    otherReferredName.removeAttribute('required');
                    otherReferredName.value = ''; // Clear the field if hidden
                }
            }

            function goViewTrainee(id, username) {

                location.href = "traineeDetails.php?id=" + id + "&username=" + username;

            }
            function goEditTrainee(id) {
                $('#traineeId').val(id);
                $.ajax({
                    url: 'action/actTrainee.php',
                    method: 'POST',
                    data: {
                        traineeId: id
                    },
                    dataType: 'json', // Specify the expected data type as JSON
                    success: function (response) {

                        console.log(response)
                        $('#traineeId').val(response.trainee_id);
                        $('#editName').val(response.name);
                        $('#editPhone').val(response.phone);
                        $('#editGender').val(response.gender);
                        $('#editPemail').val(response.personal_email);
                        $('#editDob').val(response.dob);
                        $('#editAddress').val(response.address);
                        $('#editBlood').val(response.blood_group);
                        $('#editCourse').val(response.course);
                        $('#editDuration').val(response.duration);
                        $('#editJod').val(response.joining_date);
                        $('#editFee').val(response.fee);
                        $('#editSlot').val(response.slot);
                        $('#editBatch').val(response.batch);
                        $('#cemail').val(response.cmail);

                        // Display the image if the URL is provided
                        if (response.img) {
                            console.log('Image URL:', response.img); // Debugging line
                            $('#editTraineeImg').attr('src', response.img).show();

                        } else {
                            $('#editTraineeImg').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle errors here
                        console.error('AJAX request failed:', status, error);
                    }
                });
            }
           function goDeleteTrainee(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, proceed with the AJAX call
            $.ajax({
                url: 'action/actTrainee.php',
                method: 'POST',
                data: {
                    trainee_id: id,
                    hdnAction: 'deleteTrainee'
                },
                success: function (response) {
                    if (typeof response === 'string') {
                        try {
                            response = JSON.parse(response); // Parse string to object
                        } catch (e) {
                            console.error("Response parsing failed: ", e);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }
                    }

                    if (response.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }

                    // Reload the table data after deletion
                    $('#example2').load(location.href + ' #example2 > *', function () {
                        if ($.fn.DataTable.isDataTable('#example2')) {
                            $('#example2').DataTable().destroy();
                        }
                        var table = $('#example2').DataTable({
                            "paging": true,
                            "ordering": true,
                            "searching": true,
                            lengthChange: true,
                        });

                        table.buttons().container()
                            .appendTo('#example2_wrapper .col-md-6:eq(0)');
                    });
                },
                error: function (xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'AJAX request failed: ' + status + ' ' + error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}




            //Data Table script 
        </script>

        <script>
            $(document).ready(function () {

                function validateField(fieldId, errorId) {
                    var field = $('#' + fieldId); // Get the field
                    if (field.length === 0) { // Check if field exists
                        console.error('Element with id "' + fieldId + '" not found.');
                        return false;
                    }

                    var value = field.val(); // Get the value
                    if (typeof value === 'undefined' || value === null) { // Check if value is undefined or null
                        console.error('Value of element with id "' + fieldId + '" is undefined or null.');
                        return false;
                    }

                    value = value.trim(); // Now safely trim the value

                    if (value === '') {
                        $('#' + errorId).show();
                        return false;
                    } else {
                        $('#' + errorId).hide();
                        return true;
                    }
                }


                function validateDOB(fieldId, errorId) {
                    var dob = $('#' + fieldId).val().trim();
                    if (dob === '') {
                        $('#' + errorId).text("DOB is required").show();
                        return false;
                    } else {
                        var age = calculateAge(dob);
                        if (age < 18) {
                            $('#' + errorId).text("You must be at least 18 years old").show();
                            return false;
                        } else {
                            $('#' + errorId).hide();
                            return true;
                        }
                    }
                }

                function validateJoiningDate(fieldId, errorId) {
                    var jDate = $('#' + fieldId).val().trim();
                    if (jDate === '') {
                        $('#' + errorId).text("Date of joining is required").show();
                        return false;
                    } else {
                        var today = new Date();
                        var joiningDate = new Date(jDate);
                        if (joiningDate > today) {
                            $('#' + errorId).text("Date of joining cannot be in the future").show();
                            return false;
                        } else {
                            $('#' + errorId).hide();
                            return true;
                        }
                    }
                }

                function calculateAge(dob) {
                    var birthDate = new Date(dob);
                    var today = new Date();
                    var age = today.getFullYear() - birthDate.getFullYear();
                    var monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    return age;
                }

                $('#username').on('input', function () {
                    var username = $(this).val().trim();

                    // Define the pattern for validation
                    var pattern = /^[a-z]+_?[0-9]{0,5}$/;

                    // Check if the username matches the pattern
                    if (username === '') {
                        $('#usernameError').text("Username is required").show();
                        $('#submitBtn').prop('disabled', true);
                    } else if (!pattern.test(username)) {
                        $('#usernameError').text("Username must consist of lowercase letters, optionally one underscore, and up to 5 numbers.").show();
                        $('#submitBtn').prop('disabled', true);
                    } else {
                        // Proceed with AJAX check if pattern matches
                        $.ajax({
                            url: 'action/checkTrainee.php', // The PHP script that checks the username
                            method: 'POST',
                            data: { username: username },
                            dataType: 'json',
                            success: function (response) {
                                if (response.exists) {
                                    $('#usernameError').text("Username already exists").show();
                                    $('#submitBtn').prop('disabled', true); // Disable submit button if username exists
                                } else {
                                    $('#usernameError').hide();
                                    $('#submitBtn').prop('disabled', false); // Enable submit button if username is available
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                $('#usernameError').text("An error occurred while checking the username").show();
                            }
                        });
                    }
                });

                $('#submitBtn').click(function (e) {
                    var isValid = true;
                    var usernameErrorVisible = $('#usernameError').is(':visible');
                    if (usernameErrorVisible) {
                        isValid = false;
                        e.preventDefault(); // Prevent form submission if there's an error
                    }
                    var username = $('#username').val().trim();

                    if (username === '') {
                        $('#usernameError').text("Username is required").show();
                        isValid = false;
                        event.preventDefault(); // Prevent form submission
                    }
                    e.preventDefault();



                    // Validate fields
                    isValid &= validateField('name', 'fnameError');
                    isValid &= validateDOB('dob', 'dobError');
                    isValid &= validateField('gender', 'genderError');
                    isValid &= validateField('phone', 'phoneError');
                    isValid &= validateField('pemail', 'emailError');
                    // isValid &= validateField('duration', 'durationError');
                    isValid &= validateJoiningDate('jDate', 'jDateError');
                    isValid &= validateField('address', 'addressError');
                    // isValid &= validateField('course_name', 'courseError');
                    // isValid &= validateField('actual_fee', 'feeError');

                    if (isValid) {
                        var phone = $('#phone').val().trim();
                        var pemail = $('#pemail').val().trim();

                        // AJAX request to check for existing records
                        $.ajax({
                            url: "action/checkTrainee.php",
                            method: 'POST',
                            data: { phone: phone, pemail: pemail },
                            dataType: 'json',
                            success: function (response) {
                                if (!response.success) {
                                    if (response.phoneExists) {
                                        $('#phoneError').text("Phone number already exists").show();
                                    }
                                    if (response.emailExists) {
                                        $('#emailError').text("Email already exists").show();
                                    }
                                } else {
                                    // Submit the form if valid
                                    submitForm();
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while checking phone and email.'
                                });
                            }
                        });
                    }
                });

                $('#addTraineeBtn').click(function () {
                    $('#addTraineeModal').modal('show'); // Show the modal
                    resetForm('addTrainee'); // Reset the form
                });

                function resetForm(formId) {
                    $('#' + formId)[0].reset(); // Reset the form using jQuery
                    $('.error-message').hide(); // Hide all error messages
                    $('#dobError').hide(); // Ensure DOB error message is hidden specifically
                    $('#submitBtn').prop('disabled', false);
                }

                function submitForm() {
                    var formData = new FormData($('#addTrainee')[0]);
                    $.ajax({
                        url: "action/actTrainee.php",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 2000
                                }).then(function () {
                                    resetForm('addTrainee');
                                    $('#addTraineeModal').modal('hide');
                                    $('#example2').load(location.href + ' #example2 > *', function () {
                                        $('#example2').DataTable().destroy();
                                        $('#example2').DataTable({
                                            "paging": true,
                                            "ordering": true,
                                            "searching": true
                                        });
                                    });
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while adding Task data.'
                            });
                        }
                    });
                }

                $('#modalCloseBtn').click(function () {
                    resetForm('addTrainee');
                });

                function resetForm(formId) {
                    $('#' + formId)[0].reset(); // Reset the form using jQuery
                    // Hide all error messages
                    $('.error-message').hide();
                    $('#dobError').hide(); // Ensure DOB error message is hidden specifically
                }
            });


$(document).ready(function () {
    var today = new Date().toISOString().split('T')[0]; 
    $('#reportStartDate').attr('max', today); 
    $('#endDate').attr('max', today);
    $('#clearBtn').click(function () {
        // Clear all input fields
        $('#reportStartDate').val('');
        $('#endDate').val('');
        $('#durationFilter').val('');

        // Reset dropdowns to default values
        $('#courseFilter').val('');
        $('#slotFilter').val('');

        // Clear error messages
        $('#startDateError').text('');
        $('#endDateError').text('');
        $('#daysError').text('');
    });
});

// Filter button click event
$('#filterBtn').on('click', function () {

    // Retrieve filter values
    var reportStartDate = $('#reportStartDate').val();
    var endDate = $('#endDate').val();
    var duration = $('#durationFilter').val();
    var slot = $('#slotFilter').val();
    var course = $('#courseFilter').val();

    // Validate if all filters are empty
    if (!reportStartDate && !endDate && !duration && !course && !slot) {
        alert("Please select at least one filter to proceed.");
        return; // Stop further execution
    }

    // Perform AJAX request
    $.ajax({
        url: 'action/actTrainee.php', 
        type: 'GET',
        data: {
            report_start_date: reportStartDate,
            end_date: endDate,
            course: course,
            duration: duration,
            slot: slot
        },
        dataType: 'json',
        success: function (data) {
            // Destroy and refresh the DataTable
            $('#example2').DataTable().destroy();
            $('#example2 tbody').empty();

            // Append rows dynamically based on returned data
            data.forEach(function (item, index) {
                const balance = parseFloat(item.payment) - parseFloat(item.totalAmount);
                const paystatus = balance === 0 ? 'Completed' : 'Pending';

                const rowHTML = `
                    <tr>
                        <td>${index + 1}</td> 
                        <td>${item.name}</td> 
                        <td>${item.reg_no}</td> 
                        <td>${item.phone}</td>
                        <td>${item.email}</td> 
                        <td>
                                                    <?php
                                                        $trainerRoles = [17]; // Define the Admin of roles
                                                        if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="View"
                                                            onclick="goViewTrainee(${item.id}, '${item.username}');"><i
                                                                class="lni lni-eye"></i></button>

                                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                                onclick="goEditTrainee(${item.id});"
                                                                data-bs-toggle="modal" data-bs-target="#editTraineeModal"><i
                                                                    class="lni lni-pencil"></i></button>
                                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Delete"
                                                                onclick="goDeleteTrainee(${item.id});"><i
                                                                    class="lni lni-trash"></i></button>
                                                        <?php 
                                                    } ?>

                                                    <a href="listSyllabus.php?traineeId=${item.id}"><button
                                                            class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip"
                                                            data-bs-placement="top">Syllabus</button></a>
                                                    <a href="listApplication.php?traineeId=${item.id}"><button
                                                            class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                            data-bs-placement="top">Application</button></a>

                        </td>
                    </tr>`;

                // Append the new row
                $('#example2 tbody').append(rowHTML);
            });

            // Reinitialize the DataTable
            var table = $('#example2').DataTable({
                paging: true,
                ordering: true,
                searching: true,
                lengthChange: true,
                // buttons: ['copy', 'excel', 'pdf', 'print']
            });

            // Move buttons to a specific location
            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("An error occurred while processing the request.");
        }
    });
});


        </script>
        <script>

            //--------------Handles edit Trainee-----------------------------//

            document.addEventListener('DOMContentLoaded', function () {
                $('#editTrainee').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent the form from submitting normally

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actTrainee.php",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            console.log(response);
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 2000
                                }).then(function () {
                                    $('#editTraineeModal').modal('hide'); // Close the modal
                                    $('.modal-backdrop').remove(); // Remove the backdrop   
                                    $('#example2').load(location.href + ' #example2 > *', function () {
                                        if ($.fn.DataTable.isDataTable('#example2')) {
                                            $('#example2').DataTable().destroy();
                                        }
                                        var table = $('#example2').DataTable({
                                            "paging": true,
                                            "ordering": true,
                                            "searching": true,
                                            lengthChange: true,
                                            // buttons: ['copy', 'excel', 'pdf', 'print']
                                        });

                                        table.buttons().container()
                                            .appendTo('#example2_wrapper .col-md-6:eq(0)');
                                    });
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while updating Trainee data.'
                            });
                            $('#updateBtn').prop('disabled', false);
                        }
                    });
                });
                $('#updateBtn').on('click', function () {
                    $('#editTrainee').submit();
                });
            });


        </script>
        <script>
            $(document).ready(function () {
                // Function to get the month and year in "MMM-YYYY" format
                function getFormattedDate(offset = 0) {
                    const date = new Date();
                    date.setMonth(date.getMonth() + offset); // Adjust month based on the offset
                    return `${date.toLocaleString('default', { month: 'short' })} - ${date.getFullYear()}`;
                }

                // Function to append options to a given select element
                function addBatchOptions(selector) {
                    $(selector).append(`<option value="${getFormattedDate(0)}">${getFormattedDate(0)}</option>`)
                        .append(`<option value="${getFormattedDate(1)}">${getFormattedDate(1)}</option>`);
                }

                // Add options to both 'batch' and 'editBatch' dropdowns
                addBatchOptions('#batch');
                addBatchOptions('#editBatch');
            });
        </script>

        <!--app JS-->
        <script src="<?php echo $app; ?>"></script>

<script src="../assets/js/form-validation.js"></script>
</body>

</html>