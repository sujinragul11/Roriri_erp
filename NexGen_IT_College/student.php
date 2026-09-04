<?php
session_start();
include("../db/dbConnection.php");
include("../url.php");   
   $selQuery = "SELECT a.*, b.*
FROM basic_details AS b
LEFT JOIN additional_details as a ON a.basic_id=b.id
WHERE a.entity_id='$entity_id' AND b.status='Active' AND a.add_status='Active' 
ORDER BY
b.id DESC";
    
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
        <?php include("addStudent.php");
        include("editStudent.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Students</h2>
                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                    <button type="button" id="addStudentBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add New Student</button>
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
                                        <th>ID</th>
                                        <th>Phone</th>
										<th>Email</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                        
                                        $studid  = $row['id'];  
                                        //var_dump($studid);
                                        $stud_name=$row['name'];   
                                       // $proName  = $row['project_name'];  
                                        $email   = $row['email'];  
                                        $phone          = $row['phone'];
                                        $address        = $row['address'];   
                                        $username=$row['username'];
                                        $password=$row['password'];
                                        $reg_no=$row['reg_no'];
                                      
                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo $stud_name; ?></td>
                      <td><?php echo $reg_no; ?></td>
                      <td><?php echo $phone; ?></td>
                      <!-- <td><?php // echo $proName; ?></td> -->
                      <td><?php echo $email; ?></td>
                      
                      <td>
                          <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewStud(<?php echo $studid; ?>);" ><i class="lni lni-eye"></i></button>
                          <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditstud(<?php echo $studid; ?>);" data-bs-toggle="modal" data-bs-target="#editStudentModal"><i class="lni lni-pencil"></i></button>
                         
                         
                          <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteStudent(<?php echo $studid; ?>);"><i class="lni lni-trash"></i></button>
                          
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
    <!-- Include the function.js -->
    <script src="../assets/js/function.js"></script>

     <!-- Initialize tooltips -->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script>
        function goViewStud(id){
            
            location.href = "studentDetail.php?id="+id;

        }
        function goEditstud(id) 
  
  {
    $.ajax({
        url: 'action/actStudent.php',
        method: 'POST',
        data: {
           studid: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
        console.log(response);
          $('#studid').val(response.studid);
          $('#editFname').val(response.firstname);
          $('#editPhone').val(response.phone);
          $('#editemail').val(response.email);
          $('#editDob').val(response.dob);
          $('#editAddress').val(response.address);
          $('#editAadhar').val(response.aadhar);
		  $('#editBlood').val(response.blood);
          $('#editCourse').val(response.course);
          $('#editFee').val(response.course_fee);
          $('#editGender').val(response.gender);
         
		  
		  // Display the image if the URL is provided
          if (response.img) {
            console.log('Image URL:', response.img); // Debugging line
                $('#editStuImg').attr('src', response.img).show();
                
            } else {
                $('#editStuImg').hide();
            }
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}

//Data Table script 
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

    <!--Handles the Ajax call-->
<!-- JavaScript for Client-Side Validation and AJAX Submission -->
<script>
$(document).ready(function () {
    
    

    $('#studentsubmitBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
       
        isValid &= validateDOBClg('dob', 'dobError');
        isValid &= validateField('gender', 'genderError');
        isValid &= validatePhoneNumber('phone', 'phoneError');
        isValid &= validateEmail('email', 'emailError');
        isValid &= validateField('address','addressError');
        isValid &= validateAadhaar('aadhar', 'aadharError');
        isValid &= validateField('course', 'courseError');
        isValid &= validateField('actual_fee', 'feeError');
        isValid &= validateName('name', 'fnameError');

        if (isValid) {
            var phone = $('#phone').val().trim();
            var email = $('#email').val().trim();

            // AJAX request to check for existing records
            $.ajax({
                url: "action/checkStudent.php", // Your URL to check phone and email
                method: 'POST',
                data: { phone: phone, email: email },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (!response.success) {
                        if (response.phoneExists) {
                            $('#phoneError').text("Phone number already exists").show();
                        }
                        if (response.emailExists) {
                            $('#emailError').text("Email already exists").show();
                        }
                    } else {
                        // Submit the form if valid
                        SubmitFormData();
                    }
                },
                error: function(xhr, status, error) {
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

    function SubmitFormData() {
        var formData = new FormData($('#addStudent')[0]);
        $.ajax({
            url: "action/actStudent.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Ensure you expect a JSON response
            success: function(response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#addStudentModal').modal('hide');
                        $('.modal-backdrop').remove();
                        setTimeout(function() {
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
                        }, 300);
                        // Reset the form after successful submission
                        resetForm('addStudent');
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
                    text: 'An error occurred while adding Student data.'
                });
                $('#studentsubmitBtn').prop('disabled', false);
            }
        });
    }

    // Reset the form when the close button is clicked
    $('#modalCloseBtn').click(function () {
        resetForm('addStudent');
    });

    function resetForm(formId) {
        $('#' + formId)[0].reset(); // Reset the form using jQuery
        // Hide all error messages
        $('.error-message').hide();
        $('#dobError').hide(); // Ensure DOB error message is hidden specifically
    }
});
</script>
<script>
function hideErrorMessages() {
    $('.error-message').hide();
}

document.addEventListener('DOMContentLoaded', function() {
$('#updateBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
       
        isValid &= validateDOBClg('editDob', 'dobErrorE');
        isValid &= validateField('editGender', 'genderErrorE');
        isValid &= validatePhoneNumber('editPhone', 'phoneErrorE');
        isValid &= validateEmail('editemail', 'emailErrorE');
        isValid &= validateField('editAddress','addressErrorE');
        isValid &= validateAadhaar('editAadhar', 'aadharErrorE');
        isValid &= validateField('editCourse', 'courseErrorE');
        isValid &= validateField('editFee', 'feeErrorE');
        isValid &= validateName('editFname', 'fnameErrorE');

        if (isValid) {
                        $('#editStudent').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

                // Handle the form submission via AJAX
                $('#editStudent').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actStudent.php",
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
                                    $('#editStudentModal').modal('hide'); // Close the modal
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
                                text: 'An error occurred while Editing Student data.'
                            });
                        }
                    });
                });
                $('#editCloseBtn').click(function () {
                    hideErrorMessages(); // Call the function to hide error messages
                });
        });

                

</script>
<script>



//deleting function

function goDeleteStudent(id)
{
    //alert(id);
    if(confirm("Are you sure you want to delete Student?"))
    {
      $.ajax({
        url: 'action/actStudent.php',
        method: 'POST',
        data: {
          deleteId: id
        },
        dataType: 'json',
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

	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>