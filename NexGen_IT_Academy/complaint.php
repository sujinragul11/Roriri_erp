<?php
session_start();

include ("../db/dbConnection.php");
include ("../url.php");  
include "class.php"; 

$from_id = $_SESSION['id']; 

    if ($_SESSION['is_admin'] == 'True' ) {
   $selQuery = "SELECT 
   `com_id`
   , `com_from`
   , `com_to`
   , `com_details`
   , `com_reply`
   , `created_at` AS `com_date`
   , `com_status` 
   FROM `complaint_tbl` WHERE  com_status = 'Active'";

    } else {
        $selQuery = "SELECT 
   `com_id`
   , `com_from`
   , `com_to`
   , `com_details`
   , `com_reply`
   , `created_at` AS `com_date`
   , `com_status` 
   FROM `complaint_tbl` WHERE com_from ='$from_id' AND com_status = 'Active'";
    }
   
    
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
			<?php  include "left.php";  ?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include "top.php"; ?>
		<!--end header -->
		<!--start page wrapper -->
        <?php include "formComplaint.php";?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Complaint</h2>
                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                    <?php
			 if ( $_SESSION['role'] == '10') {
				
					?>
                    <button type="button"  class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addComplainModal">Add New Complaint</button>
                    <?php
				 }
				?>
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
                                        <th>Date</th>
										<th>Complaint From</th>
                                        <th>Complaint To</th>
                                        <!-- <th>Complaint Details</th> -->
                                        <!-- <th>Complaint Replay</th> -->
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $com_id             = $row['com_id'];  
                                        $com_from           =$row['com_from'];   
                                        $com_to             = $row['com_to'];  
                                        // $com_details        = $row['com_details'];
                                        // $com_reply          = $row['com_reply'];  
                                        $com_date          = $row['com_date'];   
                                     
                                    // Decode JSON string into an array
                                    $com_to_ids = json_decode($com_to, true);  // Assuming $com_to is a JSON string

                                    // Convert the array of IDs into a comma-separated string
                                    $idString = '';
                                    if (!empty($com_to_ids)) {
                                        $idString = implode(', ', $com_to_ids);  // Convert IDs to a comma-separated string
                                    }
                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                       <td><?php echo date('d-m-Y', strtotime($com_date)); ?></td>
                      <td><?php echo userNameOnly($com_from); ?></th>
                      <td><?php echo htmlspecialchars(userTrainerOnly($idString)); ?></td>
                      
                      
                      <td>
                          <button class="btn btn-sm btn-outline-success"  onclick="showComplaintDetails(<?php echo $com_id; ?>);" ><i class="lni lni-eye"></i></button>
                          <?php
				 if ($_SESSION['is_admin'] == 'True' ) {
					?>
                          <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditClient(<?php echo $com_id; ?>);" data-bs-toggle="modal" data-bs-target="#editComplainModal"><i class="lni lni-pencil"></i></button>                
                          <?php
				 }
				?>
                      </td>
                    </tr>
                    <?php } ?>   
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
    <script src="<?php echo $select2; ?>"></script>
	<script src="<?php echo $select2Custom;?>"></script>
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

        document.getElementById('editComplaintForm').addEventListener('submit', function(event) {
    var form = this;
    if (form.checkValidity() === false) {
        event.preventDefault(); // Prevent form submission
        event.stopPropagation(); // Stop event propagation
    }
    form.classList.add('was-validated'); // Add Bootstrap validation class
}, false);

    </script>
    <script>
    function showComplaintDetails(id) {
        $.ajax({
            url: 'action/actComplaint.php',
            method: 'POST',
            data: { viewComplaint: id },
            dataType: 'json',
            success: function(response) {
                // Populate modal with data
                $('#traineeName').text(response.com_from);  // Assuming `com_from` is the name field
                $('#trainerName').text(response.com_to);  // Assuming `com_from` is the name field
                $('#complaintView').text(response.com_details);

             // Check if the reply_date is empty or has the placeholder value
        var replyDate = response.reply_date;
        if (!replyDate || replyDate === '0000-00-00' || replyDate === 'Invalid date') {
            replyDate = 'No date available';  // Fallback text
        }
        $('#dateView').text(replyDate);

                     $('#replyView').text(response.com_reply || 'No reply yet');  // Handle case where reply might be empty

                // Show the modal
                $('#viewComplaintModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
            }
        });
    }
</script>
    <script>

        function goEditClient(id) {
    $.ajax({
        url: 'action/actComplaint.php',
        method: 'POST',
        data: {
            editIdComplaint: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
            $('#complantId').val(response.com_id);

            // Parse the com_to string to get it as an array
            var comToArray = JSON.parse(response.com_to); // This will convert it to a JavaScript array
            
            // Set the values of the multi-select field
            $('#multiple-select-field').val(comToArray).trigger('change');  // Trigger change if using a library like Select2

            $('#complaintEdit').val(response.com_details).attr('disabled', true);
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

    <!--Handles the Ajax call-->
<script>
        $(document).ready(function () {


                // Handle the form submission via AJAX
                $('#addDepartment').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission
                
                var form = this;
                 // Trim whitespace from the complaint textarea
        var complaintField = $(form).find('textarea[name="complaint"]');
        complaintField.val($.trim(complaintField.val()));
                
                // Check for form validity using Bootstrap's checkValidity
                if (form.checkValidity() === false) {
                    form.classList.add('was-validated'); // Add Bootstrap validation class
                    return; // Exit if the form is invalid
                }

                // Form is valid, proceed with AJAX request
                var formData = new FormData(form);
                    $.ajax({
                        url: "action/actComplaint.php",
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
                                    $('#addComplainModal').modal('hide'); // Close the modal
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
                                resetForm('addDepartment');
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
                                text: 'An error occurred while adding Client data.'
                            });
                        }
                    });
                });

                // Reset the form when the close button is clicked
                $('#modalCloseBtn').click(function () {
                    resetForm('addDepartment');
                });
        });

                // Function to reset the form and hide error messages
                function resetForm(formId) {
                document.getElementById(formId).reset(); // Reset the form
                $('.error-message').hide(); // Hide all error messages
                }

</script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editComplaintForm').addEventListener('submit', function(event) {
        var form = this;
        
        // Trim whitespace from form inputs
        Array.from(form.elements).forEach(function(element) {
            if (element.type !== 'submit' && element.type !== 'button') {
                element.value = element.value.trim();
            }
        });
        
        // Check for form validity using Bootstrap's checkValidity
        if (form.checkValidity() === false) {
            event.preventDefault(); // Prevent form submission if invalid
            event.stopPropagation(); // Stop event propagation
        }
        
        // Add Bootstrap's validation class to the form
        form.classList.add('was-validated');

        // If the form is valid, proceed with AJAX request
        if (form.checkValidity() === true) {
            event.preventDefault(); // Prevent the default form submission
            
            var formData = new FormData(form);
            $.ajax({
                url: "action/actComplaint.php",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: response.message,
                            timer: 2000
                        }).then(function() {
                            $('#editComplainModal').modal('hide'); // Close the modal
                            $('.modal-backdrop').remove(); // Remove the backdrop
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
                        text: 'An error occurred while editing complaint data.'
                    });
                }
            });
        }
    });
});

</script>

	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>