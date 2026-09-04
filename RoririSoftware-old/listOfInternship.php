<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");
include("action/function.php");    
   $selQuery = "SELECT 
   `id`
   , `name`
   , `phone`
   , `email`
   , `dob`
   , `gender`
   , `join_date`
   , `address`
   , `image`
   , `course_id`
   , `duration`
   , `fees`
   , `username`
   , `password`
   , `status` 
   FROM `intern_tbl` WHERE `status` ='Active'";
    
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
        <?php include "internshipLeft.php";?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
        <?php include ("formInternship.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h2 class="page-title">Candidates</h2>
                </div>
                <div class="col text-end pb-3">
                    <!-- Add Candidates Button -->
                    <button type="button" id="addCondidates" class="btn btn-primary px-4 radius-30" data-bs-toggle="modal" data-bs-target="#addClientModal"><i class="bx bx-plus"></i>Add</button>
                    <!-- Back Button, initially hidden -->
                    <button type="button" id="backBtnView" class="btn btn-danger px-5 radius-30" style="display: none;">Back</button>
                </div>
            </div>
        </div>

				<div class="card" id="condidateTable">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                    <th>S. No</th>
										<th>Name</th>
										<th>Joining Date</th>
										<th>Email</th>
										<th>Fees</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $id        = $row['id'];  
                                        $name      =$row['name'];   
                                       // $proName  = $row['project_name'];  
                                        $phone      = $row['phone'];  
                                        $email      = $row['email'];
                                        $dob        = $row['dob'];   
                                        $join_date  = $row['join_date'];   
                                        $fees       =$row['fees'];

                                
                      ?>
                      <tr>
                                        <td><?php echo $i ;$i++; ?></td>
										<td><?php echo $name ;?></td>
										<td><?php echo $join_date ;?></td>
										<td><?php echo $email ;?></td>
										<td><?php echo $fees ;?></td>
                      
                      <td>
                          <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewCandiaadate(<?php echo $id; ?>);" ><i class="lni lni-eye"></i></button>
                          <button type="button" class="btn btn-sm btn-outline-warning" id="editSaveCandidate" onclick="goEditClient(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#editClientModal"><i class="lni lni-pencil"></i></button>
                          <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteClient(<?php echo $id; ?>);"><i class="lni lni-trash"></i></button>  
                      </td>
                    </tr>
                    <?php } ?>   
								</tbody>
						
							</table>
						</div>
					</div>
				</div>

                <div class="container" id="nextDivId" style="display: none;">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="d-flex flex-column align-items-center text-center">

                                        
                                            <img id="viewImage" src="" alt="Candidate Image" class="rounded-circle p-1 bg-primary" width="110" />
											<div class="mt-3">
												<h4 id="viewName"></h4>
												<p class="text-secondary mb-1" id="viewCourse"></p>
												<p class="text-muted font-size-sm" id="viewAddress"></p>
												
											</div>
										</div>
										<hr class="my-4" />
										
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<div class="card">
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Fees</h6>
											</div>
											<div class="col-sm-9 text-secondary">
                                                <p class="form-control" id="viewFees"></p>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Duration</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												
                                                <p class="form-control" id="viewDuration"></p>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Gender</h6>
											</div>
											<div class="col-sm-9 text-secondary">
                                                <p class="form-control" id="viewGender"></p>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Date Of Brith</h6>
											</div>
											<div class="col-sm-9 text-secondary">
                                                <p class="form-control" id="viewDob"></p>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Phone</h6>
											</div>
											<div class="col-sm-9 text-secondary">
                                                <p class="form-control" id="viewPhone"></p>
											</div>
										</div>
                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="col-sm-9 text-secondary">
                                                <p class="form-control" id="viewMail"></p>
											</div>
										</div>
                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Joining Date</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												
                                                <p class="form-control" id="viewJoiningDate"></p>
											</div>
										</div>

                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Username</h6>
											</div>
											<div class="col-sm-9 text-secondary">
                                                <p class="form-control" id="viewUsername"></>
											</div>
										</div>

                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Password</h6>
											</div>
											<div class="col-sm-9 text-secondary">								
                                                <p class="form-control" id="viewPassword"></p>
											</div>
										</div>
										
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>

			</div><!--end page-content-->
		</div>
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include "footer.php"; ?>
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
    // Function to set up date validations
    function setDateValidations() {
        // Get today's date
        const today = new Date();
        
        // Set the maximum date for the joining date inputs to today
        const formattedToday = today.toISOString().split("T")[0]; // yyyy-mm-dd format
        document.getElementById('joiningDate').setAttribute('max', formattedToday);
        document.getElementById('joiningDateEdit').setAttribute('max', formattedToday); // For edit modal

        // Calculate the date for 18 years ago for the DOB
        const eighteenYearsAgo = new Date();
        eighteenYearsAgo.setFullYear(today.getFullYear() - 18);
        const formattedDOB = eighteenYearsAgo.toISOString().split("T")[0]; // yyyy-mm-dd format
        
        // Set the max attribute of the DOB inputs to 18 years ago
        document.getElementById('dob').setAttribute('max', formattedDOB);
        document.getElementById('dobEdit').setAttribute('max', formattedDOB); // For edit modal
    }

    // Call the function to set validations when the page loads
    window.onload = setDateValidations;
</script>
     


    <script>

$('#username').on('input', function() {
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
            url: 'action/checkIntern.php', // The PHP script that checks the username
            method: 'POST',
            data: { username: username },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#usernameError').text("Username already exists").show();
                    $('#submitBtn').prop('disabled', true); // Disable submit button if username exists
                } else {
                    $('#usernameError').hide();
                    $('#submitBtn').prop('disabled', false); // Enable submit button if username is available
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('#usernameError').text("An error occurred while checking the username").show();
            }
        });
    }
});

        

        // Back button click event
        document.getElementById('backBtnView').addEventListener('click', function() {
            // Show Add Candidates button
            document.getElementById("addCondidates").style.display = "inline-block";

            // Hide Back button
            document.getElementById("backBtnView").style.display = "none";

            // Show candidate table and hide detailed view (you can customize this part)
            document.getElementById("condidateTable").style.display = "block";
            document.getElementById("nextDivId").style.display = "none";
        });




    function goEditClient(id) 
  
  {
    $('#usernameEdit').prop('disabled', true);
    $.ajax({
        url: 'action/actCandidate.php',
        method: 'POST',
        data: {
            editIdClient: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#EditId').val(response.id);
          $('#nameEdit').val(response.name);
          $('#courseEdit').val(response.course_id);
          $('#feesEdit').val(response.fees);
          $('#durationNoEdit').val(response.durationNO);
          $('#durationEdit').val(response.duration);
          $('#genderEdit').val(response.gender);
          $('#dobEdit').val(response.dob);
          $('#phoneEdit').val(response.phone);
          $('#emailEdit').val(response.email);
          $('#addressEdit').val(response.address);
          $('#joiningDateEdit').val(response.join_date);
          $('#usernameEdit').val(response.username);
          $('#passwordEdit').val(response.password);
         
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    }


    //---view function --------


    function goViewCandiaadate(id) 
                {   

                // Hide Add Candidates button
            document.getElementById("addCondidates").style.display = "none";

            // Show Back button
            document.getElementById("backBtnView").style.display = "inline-block";

            // Hide candidate table and show detailed view (you can customize this part)
            document.getElementById("condidateTable").style.display = "none";
            document.getElementById("nextDivId").style.display = "block";

            // Use PHP to set the base URL for the images
    var baseUrl = "<?php echo $internImageView; ?>"; // Ensure this variable is set in PHP
    var defaultUrl = "<?php echo $default_image; ?>"; // Ensure this variable is set in PHP

    $.ajax({
        url: 'action/actCandidate.php',
        method: 'POST',
        data: {
            viewIdClient: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {

            // Check if the image property exists and is not empty
        if (response.image && response.image.trim() !== '') {
            // Set the src attribute of the img tag to the actual image
            $('#viewImage').attr('src', baseUrl + response.image);
        } else {
            // Set the src attribute to the default image
            $('#viewImage').attr('src', defaultUrl);
        }

			
             
             

          $('#viewName').text(response.name);
          $('#viewCourse').text(response.course_id);
          $('#viewFees').text(response.fees);
          $('#viewDuration').text(response.durationNO + " " + response.duration);
        //   $('#durationEdit').text(response.duration);
          $('#viewGender').text(response.gender);
          $('#viewDob').text(response.dob);
          $('#viewPhone').text(response.phone);
          $('#viewMail').text(response.email);
          $('#viewAddress').text(response.address);
          $('#viewJoiningDate').text(response.join_date);
          $('#viewUsername').text(response.username);
          $('#viewPassword').text(response.password);
         
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    }


function goDeleteClient(id)
{
    //alert(id);
    if(confirm("Are you sure you want to delete Candidate?"))
    {
      $.ajax({
        url: 'action/actCandidate.php',
        method: 'POST',
        data: {
          clientdeleteId: id
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
<script>
        $(document).ready(function () {

// Handle the form submission via AJAX
$('#candidatesForm').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var form = document.getElementById('candidatesForm');

    // Check form validity using the HTML5 built-in validation
    if (form.checkValidity() === false) {
        e.stopPropagation(); // Stop submission if form is invalid
        form.classList.add('was-validated'); // Bootstrap's way of showing validation feedback
        return; // Exit the function, don't proceed with the AJAX request
    }
    // Concatenate duration number and unit
    var durationNo = $('#durationNo').val();
    var durationUnit = $('#duration').val();
    var fullDuration = durationNo + " " + durationUnit; // Example: "5 Day"

    // Create a new FormData object
    var formData = new FormData(this);
    formData.append('fullDuration', fullDuration); // Add the concatenated duration to FormData

    // Disable the submit button to prevent double submission
    const submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true);

    
    $.ajax({
        url: "action/actCandidate.php",
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
                    $('#addClientModal').modal('hide'); // Close the modal
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

                // Reset the form after successful submission
                resetForm('candidatesForm');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            // Re-enable the submit button on error
            submitButton.prop('disabled', false);
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding Candidate data.'
            });
        }
    });
});




    // edit form --------------

// Handle the form submission via AJAX
$('#EditcandidatesForm').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission
    $('#usernameEdit').prop('disabled', false);
    var form = document.getElementById('EditcandidatesForm');
    
    // Check form validity using the HTML5 built-in validation
    if (form.checkValidity() === false) {
        e.stopPropagation(); // Stop submission if form is invalid
        form.classList.add('was-validated'); // Bootstrap's way of showing validation feedback
        return; // Exit the function, don't proceed with the AJAX request
    }

    // Concatenate duration number and unit
    var durationNo = $('#durationNoEdit').val();
    var durationUnit = $('#durationEdit').val();
    var fullDuration = durationNo + " " + durationUnit; // Example: "5 Day"

    // Create a new FormData object
    var formData = new FormData(this);
    formData.append('fullDuration', fullDuration); // Add the concatenated duration to FormData

    // Disable the submit button to prevent double submission
    const submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true);

  
    $.ajax({
        url: "action/actCandidate.php",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json', // Expect JSON response
        success: function (response) {
            // Re-enable the submit button after success or error
            submitButton.prop('disabled', false);

            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 2000
                }).then(function () {
                    $('#editClientModal').modal('hide'); // Close the modal
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

                // Reset the form after successful submission
                resetForm('EditcandidatesForm');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            // Re-enable the submit button on error
            submitButton.prop('disabled', false);
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding Candidate data.'
            });
        }
    });
});







    // Reset the form when the 'Add Candidates' button is clicked
    $('#addCondidates').click(function () {
        resetForm('candidatesForm');
    });
    });

    // Function to reset the form and hide error messages
    function resetForm(formId) {
    var form = document.getElementById(formId);
    form.reset(); // Reset the form
    form.classList.remove('was-validated'); // Remove validation styling
    $('.error-message').hide(); // Hide all error messages (if any custom ones exist)
    }

</script>


	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
</body>

</html>