<?php
session_start();
include("../db/dbConnection.php");
include("../url.php");
$selQuery = "SELECT s.*, c.course_name
             FROM `subject_tbl` AS s
             LEFT JOIN `course_tbl` AS c ON s.course_id = c.course_id
             WHERE s.entity_id='2' AND s.status='Active'";
$resQuery = mysqli_query($conn, $selQuery);
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
		<?php include("addSubject.php"); ?>

		<div class="page-wrapper">
			<div class="page-content">


				<div class="page-title-box">

					<div class="page-title-right">
						<h2 class="page-title">Subject</h2>
						<div class="position-relative" style="height: 80px;">
							<button type="button" id="addSubjectBtn"
								class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal"
								data-bs-target="#addSubjectModal">Add New Subject</button>
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
										<th>Subject</th>
                                        <th>Duration</th>
                                        <th>Course</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                <?php if ($resQuery && mysqli_num_rows($resQuery) > 0): ?>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                        $subject_id  = $row['id'];  
                                        $subject_name=$row['subject_name'];   
                                        $duration=$row['duration'];
                                        $course_name = $row['course_name'] ? $row['course_name'] : '-';
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo htmlspecialchars($subject_name); ?></td>
					  <td><?php echo htmlspecialchars($duration); ?></td>
					  <td><?php echo htmlspecialchars($course_name); ?></td>
                      
                      
                      <td>
                          
                          <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditSubject(<?php echo $subject_id; ?>);" data-bs-toggle="modal" data-bs-target="#editSubjectModal"><i class="lni lni-pencil"></i></button>
                         
                         
                          <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteSubject(<?php echo $subject_id; ?>);"><i class="lni lni-trash"></i></button>
                          
                      </td>
                    </tr>
                    <?php } ?>
                    <?php else: ?>
                        <tr><td colspan="5">No subjects found.</td></tr>
                    <?php endif; ?>
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

		$(document).ready(function() {
			$('#addSubjectModal').on('show.bs.modal', function() {
				loadCourseOptions('course_id');
				$('#course_id').val('');
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
<script>
function loadCourseOptions(selectId) {
    $.ajax({
        url: 'action/actSubject.php',
        method: 'POST',
        data: { getCourses: 1 },
        dataType: 'json',
        success: function(courses) {
            var $select = $('#' + selectId);
            var currentVal = $select.val();
            $select.find('option').not(':first').remove();
            if (courses && courses.length) {
                $.each(courses, function(i, course) {
                    $select.append('<option value="' + course.id + '">' + course.name + '</option>');
                });
            }
            if (currentVal) {
                $select.val(currentVal);
            }
        },
        error: function() {
            console.error('Failed to load courses');
        }
    });
}

function goEditSubject(id) 
  
  {
    loadCourseOptions('editCourse');
    $.ajax({
        url: 'action/actSubject.php',
        method: 'POST',
        data: {
            editId: id
        },
        dataType: 'json',
        success: function(response) {
			

          $('#editIdSubject').val(response.subject_id);
          $('#eSubject').val(response.subject_name);
          $('#editDuration').val(response.duration);
          $('#editCourse').val(response.course_id);
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
function goDeleteSubject(id)
{
    //alert(id);
    if(confirm("Are you sure you want to delete Subject?"))
    {
      $.ajax({
        url: 'action/actSubject.php',
        method: 'POST',
        data: {
          deleteId: id
        },
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

                $('#' + errorId).hide();
                return true;
            }
        $(document).ready(function () {
           
                // Handle the form submission
                $('#submitBtn').click(function (e) {
                    e.preventDefault();

                    var isValid = true;

                    isValid &= validateDuration('duration', 'durationError');
                    isValid &= validateField('subject', 'nameError');
                    

                    if (isValid) {
                        $('#addSubject').trigger('submit');
                    }
                });

                // Handle the form submission via AJAX
                $('#addSubject').off('submit').on('submit', function (e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actSubject.php",
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
                                    $('#addSubjectModal').modal('hide');
                                    $('.modal-backdrop').remove();
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
                                resetForm('addSubject');
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
                                text: 'An error occurred while adding Subject data.'
                            });
                        }
                    });
                });

                // Reset the form when the close button is clicked
                $('#modalCloseBtn').click(function () {
                    resetForm('addSubject');
                });
        });

                // Function to reset the form and hide error messages
                function resetForm(formId) {
                document.getElementById(formId).reset();
                $('.error-message').hide();
                }

</script>
<script>

//--------------Handles edit subject-----------------------------//

document.addEventListener('DOMContentLoaded', function() {
    $('#updateBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
        isValid &= validateField('eSubject', 'nameErrorE');
        isValid &= validateDuration('editDuration', 'durationErrorE');
        
        if (isValid) {
                        $('#editSubject').trigger('submit');
                    }
                });

                // Handle the form submission via AJAX
                $('#editSubject').off('submit').on('submit', function (e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actSubject.php",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: response.message,
                                    timer: 2000
                                }).then(function () {
                                    $('#editSubjectModal').modal('hide');
                                    $('.modal-backdrop').remove();
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
                                text: 'An error occurred while adding Subject data.'
                            });
                        }
                    });
                    
                });
                $('#editCloseBtn').click(function () {
                    hideErrorMessages();
                });

});

 
</script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>
