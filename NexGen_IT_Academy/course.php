<?php 
session_start();
include("../db/dbConnection.php");
include("../url.php"); 

?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
    <?php include("addCourse.php")?>
    <?php include("editCourse.php")?>
  
			<?php include("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
        
		<!--start page wrapper -->
		<div class="page-wrapper">

        <!-- Loading Indicator -->
    <!-- Loading Indicator -->
<div id="loading" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex justify-content-center align-items-center text-white" style="z-index: 1050;">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p class="ms-3 mb-0">Loading, please wait...</p>
</div>

       
        <div class="page-content">
          <div class="page-title-box">
              <div class="page-title-right">
                  <h4 class="page-title">Course</h4>
                  <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                      <button type="button" id="addCourseBtn" class="btn btn-info position-absolute end-0" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                          Add Course
                      </button>
                      <!-- <button type="button" id="addCourseDetailsBtn" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addCourseDetailsModal">
                          Add Course Details
                      </button> -->
                  </div>
              </div>      
          </div>
    
          <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap5">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                        <div class="dt-buttons btn-group">      
                                          <button class="btn btn-outline-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="scroll-horizontal-datatable" type="button">
                                            <span>Copy</span>
                                          </button> 
                                          <button class="btn btn-outline-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="scroll-horizontal-datatable" type="button">
                                            <span>Excel</span>
                                          </button> 
                                          <button class="btn btn-outline-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="example2" type="button">
                                            <span>PDF</span>
                                          </button> 
                                          <button class="btn btn-outline-secondary buttons-print" tabindex="0" aria-controls="example2" type="button">
                                            <span>Print</span>
                                          </button> 
                                        </div>
                                      </div>
                                      
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <table id="scroll-horizontal-datatable" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="example2_info">
                                          <thead>
                                              <tr role="row">
                                                  <th class="sorting_asc" tabindex="0" aria-controls="scroll-horizontal-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="S. No: activate to sort column descending" style="width: 100.828px;">S. No</th>
                                                  <th class="sorting" tabindex="0" aria-controls="scroll-horizontal-datatable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 124.953px;">Course</th>
                                                  <th class="sorting" tabindex="0" aria-controls="scroll-horizontal-datatable" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 285.125px;">Subject</th>
                                                  <!-- <th class="sorting" tabindex="0" aria-controls="scroll-horizontal-datatable" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending" style="width: 147.938px;">Duration</th>
                                                  <th class="sorting" tabindex="0" aria-controls="scroll-horizontal-datatable" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 285.125px;">Fees</th> -->
                                                   <?php if ($_SESSION['role_name'] == 'Super Admin') { ?>
                                                  <th class="sorting" tabindex="0" aria-controls="scroll-horizontal-datatable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 303.766px;">Action</th></tr>
                                                  <?php } ?>
                                          </thead>
                                          <?php
$selQuery = "SELECT academy_course_details.*, subject_tbl.subject_name
             FROM academy_course_details 
             LEFT JOIN subject_tbl 
             ON FIND_IN_SET(subject_tbl.id, academy_course_details.subject_id) > 0
             WHERE academy_course_details.status = 'Available'";

$resQuery = mysqli_query($conn, $selQuery);

if (!$resQuery) {
    // Print the error message
    die("SQL Error: " . mysqli_error($conn));
}

// Initialize an array to store subject names for each course
$course_subjects = [];

while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) { 
    $course_id = $row['id'];
    $course_name = $row['course_name'];
    $subject_name = $row['subject_name'];

    // Initialize course entry if not already done
    if (!isset($course_subjects[$course_id])) {
        $course_subjects[$course_id] = [
            'course_name' => $course_name,
            'subjects' => []
        ];
    }
    
    // Add subject names to the course entry
    if ($subject_name) {
        $course_subjects[$course_id]['subjects'][] = $subject_name;
    }
}

// Display the results
$i = 1;
?>
<tbody>
    <?php foreach ($course_subjects as $course_id => $course_data): ?>
    <tr role="row" class="odd">
        <td class="sorting_1"><?php echo $i; $i++; ?></td>
        <td><?php echo $course_data['course_name']; ?></td>
        <td><?php echo implode(', ', $course_data['subjects']); ?> </td> <!-- Concatenate subject names -->
            <?php if ($_SESSION['role_name'] == 'Super Admin') { ?>
        <td>
            <button type="button" class="btn btn-circle btn-warning text-white modalBtn" onclick="goEditCourse(<?php echo $course_id; ?>);">
                <i class='bx bx-pencil'></i>
            </button>
            <button class="btn btn-circle btn-danger text-white" onclick="goDeleteCourse(<?php echo $course_id; ?>);">
                <i class="bx bx-trash"></i>
            </button>
        </td>
        <?php } ?>
    </tr>
    <?php endforeach; ?>
</tbody>
<?php
?>

                                       
                                        </table>
                                      </div>
                                  </div>
             
</div>
                            </div>
                        </div>
                    </div>
                </div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		 <div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright Â© 2024. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
    <!-- end search modal -->
	<!--end switcher-->
	<!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

	<script src="<?php echo $bootsrapBundle; ?>"></script>
	<!--plugins-->
	<script src="<?php echo $js; ?>"></script>
	<script src="<?php echo $simplebar;?>"></script>
	<script src="<?php echo $mentimenu; ?>"></script>
	<script src="<?php echo $perfectScrolbar;  ?>"></script>
	<script src="<?php echo $datatableMin; ?>"></script>
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
     <!-- Include Bootstrap JS (with Popper) -->
    <script src="<?php echo $popper;?>"></script>
    <script src="<?php echo $bootStackPath;?>"></script>
	<script src="<?php echo $sweetalert; ?>"></script>
    <script>
$(document).ready(function () {
    // Function to validate fields
    function validateField(fieldId, errorId) {
        var field = $('#' + fieldId); // Get the field
        var value = field.val().trim(); // Get and trim the value

        if (value === '') {
            $('#' + errorId).show(); // Show error message
            return false;
        } else {
            $('#' + errorId).hide(); // Hide error message
            return true;
        }
    }

    // Function to validate checkbox group
    function validateCheckboxGroup(fieldName, errorId) {
        var checkedBoxes = $('input[name="' + fieldName + '"]:checked').length; // Count checked boxes
        if (checkedBoxes === 0) {
            $('#' + errorId).show(); // Show error message
            return false;
        } else {
            $('#' + errorId).hide(); // Hide error message
            return true;
        }
    }

    // Handle the add course button click event
    $('#addCourseBtn').click(function () {
        $('#addCourseModal').modal('show'); // Show the modal
        resetForm('addCourse'); // Reset the form
    });

    // Handle the form submission via AJAX
    $('#submitCoursebtn').click(function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Validate fields
        var isValid = true;
        isValid &= validateField('course_name', 'fnameError');
        isValid &= validateCheckboxGroup('subject[]', 'SubError');

        if (!isValid) {
            return; // Stop the form submission if validation fails
        }

        // If validation passes, proceed with form submission
        var form = $('#addCourse'); // Assuming your form has the ID 'addCourse'
        var formData = new FormData(form[0]); // Collect the form data

        $.ajax({
            url: "action/actCourse.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        resetForm('addCourse');
                        $('#addCourseModal').modal('hide');
                        location.reload(); // Reload the entire page
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding the course.'
                });
                $('#submitCoursebtn').prop('disabled', false); // Re-enable the submit button on error
            }
        });
    });
});

// Function to reset the form
function resetForm(formId) {
    document.getElementById(formId).reset(); // Reset the form
    $('input[name="subject[]"]').prop('checked', false); // Uncheck all checkboxes
    $('.error-message').hide(); // Hide all error messages
}


// ajax edit course
function goEditCourse(editId) {
    // Show the loading indicator
    document.getElementById('loading').classList.remove('d-none');

    $.ajax({
        url: 'action/actCourse.php',
        method: 'POST',
        data: { editId: editId },
        dataType: 'json',
        success: function(response) {
            if (response) {
                $('#editId').val(response.course_id);
                $('#edit_name').val(response.course_name);

                if (Array.isArray(response.selected_subjects)) {
                    $('input[name="subject[]"]').each(function() {
                        $(this).prop('checked', response.selected_subjects.includes($(this).val()));
                    });
                } else {
                    console.log('Subject data is not an array');
                }

                // Hide the loading indicator and show the modal
                document.getElementById('loading').classList.add('d-none');
                $('#editCourseModal').modal('show');
            } else {
                console.error('Response is empty or not in the expected format');
                document.getElementById('loading').classList.add('d-none');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
            console.log('Response:', xhr.responseText);
            document.getElementById('loading').classList.add('d-none');
        }
    });
}



    document.addEventListener('DOMContentLoaded', function() {
        $('#editCourse').off('submit').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = new FormData(this);
            $.ajax({
                url: "action/actCourse.php",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    // Handle success response

                    console.log(response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000
                        }).then(function() {
                            $('#editCourseModal').modal('hide'); // Close the modal

                            $('.modal-backdrop').remove(); // Remove the backdrop  
                             location.reload();  
                            $('#scroll-horizontal-datatable').load(location.href +
                                ' #scroll-horizontal-datatable > *',
                                function() {

                                    $('#scroll-horizontal-datatable')
                                    .DataTable().destroy();

                                    $('#scroll-horizontal-datatable')
                                .DataTable({
                                        "paging": true, // Enable pagination
                                        "ordering": true, // Enable sorting
                                        "searching": true // Enable searching
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
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while Edit Task data.'
                    });
                    // Re-enable the submit button on error
                    $('#updateBtn').prop('disabled', false);
                }
            });
        });
    });
// delete the course
function goDeleteCourse(deleteId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'action/actCourse.php',
                method: 'POST',
                data: {
                    deleteId: deleteId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            // Reload the data table
                            location.reload();  
                            $('#scroll-horizontal-datatable').load(location.href + ' #scroll-horizontal-datatable > *', function() {
                                $('#scroll-horizontal-datatable').DataTable().destroy();
                                $('#scroll-horizontal-datatable').DataTable({
                                    "paging": true, // Enable pagination
                                    "ordering": true, // Enable sorting
                                    "searching": true // Enable searching
                                });
                            });
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'An unexpected error occurred. Please try again.',
                        'error'
                    );
                    console.error('AJAX request failed:', status, error);
                }
            });
        }
    });
}

$(document).ready(function () {
  $('#addCourseDetailsBtn').click(function () {
    $('#addCourseDetailsModal').modal('show'); // Show the modal
    resetForm('addCourseDetails'); // Reset the form
  });

function resetForm(addCourseDetails) {
    document.getElementById(addCourseDetails).reset(); // Reset the form
}

  
  $('#addCourseDetails').off('submit').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting normally

    var formData = new FormData(this);
    $.ajax({
      url: "action/actCourse.php",
      method: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        // Handle success response
        console.log(response);
        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message,
            timer: 2000
          }).then(function() {
            resetForm('addCourseDetails');
                    $('#addCourseDetailsModal').modal('hide');
            $('#scroll-horizontal-datatable').load(location.href + ' #scroll-horizontal-datatable > *', function() {
              $('#scroll-horizontal-datatable').DataTable().destroy();
              $('#scroll-horizontal-datatable').DataTable({
                "paging": true, // Enable pagination
                "ordering": true, // Enable sorting
                "searching": true // Enable searching
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
      error: function(xhr, status, error) {
        // Handle error response
        console.error(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while adding Task data.'
        });
        // Re-enable the submit button on error
        $('#submitBtn').prop('disabled', false);
      }
    });
  });
});
    </script>
     <script src="<?php echo $app; ?>"></script> 
<script src="../assets/js/form-validation.js"></script>
</body>
</html>
