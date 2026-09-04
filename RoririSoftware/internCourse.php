<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT `inte_cou_id`, `intern_course_name`, `course_logo` FROM `inter_course_tbl` WHERE status = 'Active'";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include "head.php";?>

<body>
<style>
        .error-message {
            color: red;
            display: none;
        }
        .error {
            border-color: red;
        }
    </style>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
        <?php include "internshipLeft.php";?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include "top.php";?>
		<!--end header -->
		<!--start page wrapper -->
        <?php include "formCourse.php";?>
		
		<div class="page-wrapper">
			<div class="page-content" id="courseTbl">


            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Course List</h2>
                    <div class="col text-end pb-3">
                        
                            		 <?php
                  $trainerRoles = [17]; // Define the array of roles

                  if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                    <button type="button" id="addCourse" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#courseModal">
                        <i class="bx bx-plus"></i> Add Course
                    </button>
                    <?php } ?>
                    </div>

                </div>
                   
            </div>

            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5" id="courseContainer">

            <?php  while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                 $id        = $row['inte_cou_id'];  
                 $name      =$row['intern_course_name'];   
                 $logo      = $row['course_logo']; 
                 $logoUrl   = !empty($logo) ? $internCourseView . $logo : $default_image;
            ?>
                    <div class="col">
                        <div class="card border-primary border-bottom border-3 border-0">
                            <div class="ratio ratio-4x3"> <!-- Bootstrap's responsive ratio class -->
                                <img src="<?php echo $logoUrl; ?>" class="card-img-top img-fluid object-fit-cover" alt="Course Image" onclick="viewCourseDetails(<?php echo $id; ?>, '<?php echo $name; ?>')">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h4 class="my-1 text-center text-truncate" style="max-width: 100%;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $name; ?>">
                                    <?php echo $name; ?>
                                </h4>
                                <hr>
                                
                            		 <?php
                                      $trainerRoles = [17]; // Define the array of roles
                    
                                      if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button class="btn btn-primary" id="editCourseBtn" data-bs-toggle="modal" data-bs-target="#editCourseModal" data-course-id="<?php echo $id; ?>" data-course-name="<?php echo $name; ?>">
                                        <i class='bx bx-pencil'></i> 
                                    </button>
                                    <button class="btn btn-danger" onclick="goDeleteCourse(<?php echo $id; ?>)">
                                        <i class='bx bx-trash'></i> 
                                    </button>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php } ?>  

         

					
					</div>
			</div><!--end page-content-->
			<div class="page-content" id="pptTbl" style="display:none;">
                <div class="page-title-box">
                    
                    <div class="page-title-right">
                        <h2 class="page-title" id="pptHeading">Course Details</h2>
                        <div class="row">
                            <div class="col">
                                <button type="button" id="backBtn" class="btn btn-danger">
                                    <i class="lni lni-exit"></i> Back
                                </button>
                            </div>
                            <div class="col text-end pb-3">
                                <button type="button" id="addPpt" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pptModal">
                                    <i class="bx bx-upload"></i> Upload PPT
                                </button>
                            </div>
                        </div>
                    </div>
                       
                </div>
    
                <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th class="col-1 text-center">S. No</th>
                                        <th class="col-3 text-center">Content Title</th>
										<th class="col-6 text-center">Description</th>
                                        <th class="col-2 text-center">Action</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
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
	<script src="<?php echo $simplebar;?>"></script>
	<script src="<?php echo $mentimenu; ?>"></script>
	<script src="<?php echo $perfectScrolbar;  ?>"></script>
	<script src="<?php echo $datatableMin; ?>"></script>
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
     <!-- Include Bootstrap JS (with Popper) -->
    <script src="<?php echo $popper;?>"></script>
    <script src="<?php echo $bootStackPath;?>"></script>
	<script src="<?php echo $sweetalert; ?>"></script>
        <!-- Include the function.js -->
        <script src="../assets/js/function.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
       // Function to reset the form and hide error messages
       function resetForm(formId) {
            var form = $('#' + formId);
            form[0].reset();
            form.removeClass('was-validated');
        }
  // Handle form submission
  $('#courseForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission behavior

        var form = this;

        // Check if form is valid
        if (form.checkValidity() === false) {
            event.stopPropagation(); // Stop form submission if invalid
        } else {
            // Proceed with AJAX submission if the form is valid
            var formData = new FormData(); // Create FormData object

            // Append form data
            formData.append('course_name', $('#courseName').val());
            formData.append('course_logo', $('#courseLogo')[0].files[0]);

            $.ajax({
                url: 'action/actInternCourse.php', // Backend file to process data
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json', // Expecting a JSON response from the server
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000
                        }).then(function () {
                            $('#courseModal').modal('hide'); // Close modal
                            $('.modal-backdrop').remove(); // Remove backdrop

                            // Reload course container after closing modal
                            setTimeout(function () {
                                $('#courseContainer').load(location.href + ' #courseContainer > *');
                            }, 300);
                        });

                        // Reset form after submission
                        resetForm('courseForm');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                    alert('Error while saving course.');
                }
            });
        }

        // Add Bootstrap validation class
        $(form).addClass('was-validated');
    });

// edit submit form----------------

// jQuery for handling the form submission
$('#editSaveCourse').on('click', function (event) {
    event.preventDefault(); // Prevent default form submission
             // Check if the form is valid
             if (!this.checkValidity()) {
                        // If the form is invalid, show validation messages
                        $(this).addClass('was-validated');
                        return; // Stop the submission
                    }

    var formData = new FormData(); // Create FormData object to hold course name and logo file
    formData.append('course_id', $('#course_id').val()); // Append course ID
    formData.append('editCourseName', $('#editCourseName').val()); // Append course name
    formData.append('editCourseLogo', $('#editCourseLogo')[0].files[0]); // Append the logo file

    $.ajax({
        url: 'action/actInternCourse.php', // PHP file to handle data insertion
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 2000
                }).then(function () {
                    $('#editCourseModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
                    // Reload the card container after the modal closes
                    setTimeout(function () {
                        $('#courseContainer').load(location.href + ' #courseContainer > *', function () {
                            // Reinitialize image with a timestamp to prevent caching
                            $('#courseContainer img').each(function() {
                                var src = $(this).attr('src');
                                // Append a timestamp to the image src to prevent caching
                                $(this).attr('src', src + '?' + new Date().getTime());
                            });
                        });
                    }, 300);
                });

                // Reset the form after successful submission
                resetForm('editCourseForm');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.error('Error: ' + error);
            alert('Error while saving course.');
        }
    });
});

    $('#pptForm').off('submit').on('submit', function (e) {
        e.preventDefault();
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; 
        }
        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
        $.ajax({
            url: "action/actInternCourse.php",
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
                        timer: 1000
                    }).then(function () {
                        $('#pptModal').modal('hide'); 
                        $('.modal-backdrop').remove();
                        viewCourseDetails($('#courseId').val(), $('#courseName').text());

                    });
                    // Reset the form after successful submission
                    resetForm('pptForm');
                    $('#submitFormBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#submitFormBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding PPT details.'
                });
                $('#submitFormBtn').prop('disabled', false);
            }
        });
    });
    
    $('#pptFormEdit').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        $.ajax({
            url: "action/actInternCourse.php",
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
                        timer: 1000
                    }).then(function () {
                        $('#pptModalEdit').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                        viewCourseDetails($('#courseId').val(), $('#courseName').text());
                        
                    });
                    resetForm('pptFormEdit');
                    $('#submitEditBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#submitEditBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating PPT details.'
                });
                $('#submitEditBtn').prop('disabled', false);
            }
        });
    });

 // Reset the form when the close button is clicked
 $('#addCourse').click(function () {
         resetForm('courseForm');
     });
      $('#addPpt').click(function () {
         resetForm('pptForm');
     });

</script>

    
    <script>
 
function goDeleteCourse(id) {
    if (confirm("Are you sure you want to delete this Course?")) {
        $.ajax({
            url: 'action/actInternCourse.php',
            method: 'POST',
            data: { deleteId: id },
            success: function (response) {
                // Show SweetAlert based on the response
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: response.message,
                        timer: 2000
                    }).then(function () {
                        // Optionally, reload the card container
                        setTimeout(function () {
                            $('#courseContainer').load(location.href + ' #courseContainer > *');
                        }, 300);
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
                console.error('AJAX request failed:', status, error);
            }
        });
    }
}

function viewCourseDetails(courseId, courseName) {
    
    $.ajax({
        url: 'action/actInternCourse.php',  
        method: 'POST',
        data: { cour_Id: courseId },
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response)) {
                var currentPage = $('#example2').DataTable().page();
                $('#example2').DataTable().clear().destroy();
                $('#example2 tbody').empty();

                $.each(response, function(index, item) {
                    var row = '<tr>' +
                        '<td class="col-1 text-center">' + (index + 1) + '</td>' + 
                        '<td class="col-3 text-center">' + item.content_title + '</td>' + 
                        '<td class="col-6 text-wrap">' + item.descript + '</td>' + 
                        '<td class="col-2 text-center">' +
                        '<button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#pptModalEdit" onclick="editPPTDetails(' + item.id + ')">' + 
                            '<i class="lni lni-pencil"></i>' + 
                        '</button> ' +
                        '<button class="btn btn-sm btn-outline-info" onclick="downloadFile(\'' + item.file_url + '\')">' + 
                            '<i class="lni lni-download"></i>' + 
                        '</button>' +
                        '</td>' +
                    '</tr>';
                    $('#example2 tbody').append(row); 
                });

                var table = $('#example2').DataTable({
                    paging: true,
                    ordering: true,
                    searching: true,
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
                table.page(currentPage).draw(false);
            } 
            $('#courseTbl').hide();
            $('#pptTbl').show();
            $('#pptHeading').text(courseName + " Details");
            $('#courseId').val(courseId);
        },
        error: function() {
            alert('There was an error fetching course details.');
        }
    });
}

function editPPTDetails(pptId) {
    
    $('#submitEditBtn').prop('disabled', false);
    
    $.ajax({
        url: 'action/actInternCourse.php',
        method: 'POST',
        data: {
            pptEdit : pptId
        },
        dataType: 'json', 
        success: function(response) {
                $('#pptIdEdit').val(response.id);
                $('#courseIdEdit').val(response.cou_id);
                $('#contentTitleEdit').val(response.title);
                $('#descriptionEdit').val(response.descript);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

function downloadFile(fileUrl) {
    if (fileUrl) {
        var a = document.createElement('a');
        a.href = fileUrl;
        a.target = '_blank'; 
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    } else {
        alert('File URL not available');
    }
}

$(document).ready(function() {
    $('#backBtn').click(function() {
        $('#pptTbl').hide();
        $('#courseTbl').show();
        $('#example2').DataTable().page(0).draw();
    });
});

//Data Table script 
    </script>
	<script>
		$(document).ready(function() {
            // When an edit button is clicked
            // When the modal is shown, populate the form with data
        $('#editCourseModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var courseId = button.data('course-id'); // Extract course ID
            var courseName = button.data('course-name'); // Extract course name

            // Set the form fields with the extracted data
            $('#course_id').val(courseId);
            $('#editCourseName').val(courseName);
        });
        });
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
</script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>