<?php
session_start();
include("../db/dbConnection.php");
include("../url.php");   
$selQuery = "SELECT * FROM `course_tbl` WHERE status='Active'";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

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
		<?php include("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
		<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
		<?php include("addCourse.php"); ?>

		<div class="page-wrapper">
			<div class="page-content">


				<div class="page-title-box">

					<div class="page-title-right">
						<h2 class="page-title">Course</h2>
						<div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
							<button type="button" id="addclgCourseBtn"
								class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal"
								data-bs-target="#addCourseModal">Add New Course</button>
						</div>

					</div>
				</div>
				<div class="card">
					<div class="card-body">

					<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Name</th>
                                        <th>Duration</th>
                                        
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $course_id  = $row['course_id'];  
                                        $course_name=$row['course_name'];   
                                        $duration=$row['duration'];

                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo $course_name; ?></td>
					  <td><?php echo $duration; ?></td>
                      
                      
                      <td>
                          
                          <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditCourse(<?php echo $course_id; ?>);" data-bs-toggle="modal" data-bs-target="#editCourseModal"><i class="lni lni-pencil"></i></button>
                         
                         
                          <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteCourse(<?php echo $course_id; ?>);"><i class="lni lni-trash"></i></button>
                          
                      </td>
                    </tr>
                    <?php } ?>   
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
	<script src="../assets/js/function.js"></script>
	<!-- Initialize tooltips -->

	<script>
		//Data Table script 

			$(document).ready(function() {
				$('#example').DataTable();
		  } );
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
<script>
function goEditCourse(id) 
  
  {
    $.ajax({
        url: 'action/actCourse.php',
        method: 'POST',
        data: {
            editId: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#editIdCourse').val(response.course_id);
          $('#eCourse').val(response.course_name);
          $('#editDuration').val(response.duration);
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
function goDeleteCourse(id)
{
    //alert(id);
    if(confirm("Are you sure you want to delete Course?"))
    {
      $.ajax({
        url: 'action/actCourse.php',
        method: 'POST',
        data: {
          deleteId: id
        },
        //dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
          $('#example2').load(location.href + ' #example2 > *', function() {
                               
            if ($.fn.DataTable.isDataTable('#example2')) {
                                $('#example2').DataTable().destroy();
                            }
                            var table = $('#example2').DataTable({
                                "paging": true,
                                "ordering": true,
                                "searching": true,
                                lengthChange: false,
                                buttons: ['copy', 'excel', 'pdf', 'print']
                            });

                            table.buttons().container()
                                .appendTo('#example2_wrapper .col-md-6:eq(0)');
                            });
                            // Show SweetAlert based on the response
                                if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Deleted',
                                                text: response.message,
                                                timer: 2000
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
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    }
}
</script>
<script>
    function validateDuration(fieldId, errorId) {
                var duration = $('#' + fieldId).val().trim();

                if (duration === "") {
                    $('#' + errorId).text("Duration is required.").show();
                    return false;
                }

                var durationNumber = Number(duration);
                
                if (isNaN(durationNumber) || durationNumber == 0 || durationNumber == 1 || durationNumber > 5) {
                    $('#' + errorId).text("Duration must be a number between 2 and 5.").show();
                    return false;
                }

                $('#' + errorId).hide();
                return true;
            }
        $(document).ready(function () {
           //function to use validate the duration
            
                // Handle the form submission
                $('#submitBtn').click(function (e) {
                    e.preventDefault(); // Prevent default form submission

                    var isValid = true;

                    // Validate fields
                    
                    isValid &= validateDuration('duration', 'durationError');
                    isValid &= validateField('course', 'nameError');
                    

                    if (isValid) {
                        $('#addCourse').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

                // Handle the form submission via AJAX
                $('#addCourse').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actCourse.php",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json', // Expect JSON response
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 2000
                                }).then(function () {
                                    $('#addCourseModal').modal('hide'); // Close the modal
                                    $('.modal-backdrop').remove(); // Remove the backdrop
                                    setTimeout(function () {
                                        $('#example2').load(location.href + ' #example2 > *', function () {
                                            if ($.fn.DataTable.isDataTable('#example2')) {
                                                $('#example2').DataTable().destroy();
                                            }
                                            var table = $('#example2').DataTable({
                                                "paging": true,
                                                "ordering": true,
                                                "searching": true,
                                                lengthChange: false,
                                                buttons: ['copy', 'excel', 'pdf', 'print']
                                            });
                                            table.buttons().container()
                                                .appendTo('#example2_wrapper .col-md-6:eq(0)');
                                        });
                                    }, 300);
                                });

                                // Reset the form after the modal is hidden
                                resetForm('addCourse');
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
                                text: 'An error occurred while adding Course data.'
                            });
                        }
                    });
                });

                // Reset the form when the close button is clicked
                $('#modalCloseBtn').click(function () {
                    resetForm('addCourse');
                });
        });

                // Function to reset the form and hide error messages
                function resetForm(formId) {
                document.getElementById(formId).reset(); // Reset the form
                $('.error-message').hide(); // Hide all error messages
                }

</script>
<script>

//--------------Handles edit employee-----------------------------//

document.addEventListener('DOMContentLoaded', function() {
    $('#updateBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
        isValid &= validateField('eCourse', 'nameErrorE');
        isValid &= validateDuration('editDuration', 'durationErrorE');
        
        if (isValid) {
                        $('#editCourse').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

                // Handle the form submission via AJAX
                $('#editCourse').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actCourse.php",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json', // Expect JSON response
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: response.message,
                                    timer: 2000
                                }).then(function () {
                                    $('#editCourseModal').modal('hide'); // Close the modal
                                    $('.modal-backdrop').remove(); // Remove the backdrop
                                    setTimeout(function () {
                                        $('#example2').load(location.href + ' #example2 > *', function () {
                                            if ($.fn.DataTable.isDataTable('#example2')) {
                                                $('#example2').DataTable().destroy();
                                            }
                                            var table = $('#example2').DataTable({
                                                "paging": true,
                                                "ordering": true,
                                                "searching": true,
                                                lengthChange: false,
                                                buttons: ['copy', 'excel', 'pdf', 'print']
                                            });
                                            table.buttons().container()
                                                .appendTo('#example2_wrapper .col-md-6:eq(0)');
                                        });
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
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while adding Course data.'
                            });
                        }
                    });
                    
                });
                $('#editCloseBtn').click(function () {
                    hideErrorMessages(); // Call the function to hide error messages
                });

});

 
</script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>