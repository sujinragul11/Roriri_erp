<?php
session_start();
include("../db/dbConnection.php");
include("../url.php"); 
include("action/function.php");   
   $selQuery = "SELECT * FROM `enquire_tbl` WHERE enquire_status='Active' AND entity_id = 2";
    
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
        <?php include("addEnquiry.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Enquiry</h2>
                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                    <button type="button" id="addEnquireBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addEnquiryModal">Add New Enquiry</button>
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
										<th>Name</th>
                                        <th>Enquiry</th>
                                        <th>Phone</th>
										<th>Address</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $enquire_id  = $row['enquire_id'];  
                                        $name=$row['e_name'];   
                                        $enquire_details  = $row['enquire_details'];  
                                        $email   = $row['e_email'];  
                                        $phone          = $row['e_mobile'];
                                        $address        = $row['e_address'];   
                                       
                                        $date=$row['created_at'];

                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                       <td><?php echo formatDate($date); ?></td>
                      <td><?php echo $name; ?></td>
                      
                      <td><?php echo $enquire_details; ?></td>
                      <td><?php echo $phone; ?></td>
                      <td><?php echo $address; ?></td>
                      
                      <td>
                          <!-- <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewClient(<?php echo $enquire_id; ?>);" ><i class="lni lni-eye"></i></button> -->
                          <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditEnquire(<?php echo $enquire_id; ?>);" data-bs-toggle="modal" data-bs-target="#editEnquiryModal"><i class="lni lni-pencil"></i></button>
                         
                         
                          <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteEnquire(<?php echo $enquire_id; ?>);"><i class="lni lni-trash"></i></button>
                          
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
       
function goEditEnquire(id) 
  
  {
    $.ajax({
        url: 'action/actEnquiry.php',
        method: 'POST',
        data: {
            editEnquiryID: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#editEnquiryId').val(response.enquire_id);
          $('#EnameE').val(response.name);
          $('#compNameE').val(response.comp_name);
          $('#AddressE').val(response.address);
          $('#EmailE').val(response.email);
          $('#PhoneE').val(response.phone);
          $('#detailsE').val(response.details);
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
function goDeleteEnquire(id)
{
    //alert(id);
    if(confirm("Are you sure you want to delete Enquiry?"))
    {
      $.ajax({
        url: 'action/actEnquiry.php',
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
    //to validate the optional email

function optionalEmail(fieldId, errorId) {
    var emailField = document.getElementById(fieldId);
    var errorField = document.getElementById(errorId);

    // Trim white space from the email field
    emailField.value = emailField.value.trim();

    // Check if the email field is empty
    if (emailField.value === '') {
        // Hide error message if the email field is empty
        errorField.style.display = 'none';
        return true; // Valid since it is not required
    } else {
        // Validate the email format if not empty
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailField.value)) {
            errorField.style.display = 'block';
            errorField.textContent = 'Please enter a valid email address.';
            return false;
        } else {
            // Hide error message if the email is valid
            errorField.style.display = 'none';
            return true;
        }
    }
}
    function hideErrorMessages() {
    $('.error-message').hide(); // Hide all error messages
    }
        $(document).ready(function () {


// Handle the form submission
$('#submitBtn').click(function (e) {
    e.preventDefault(); // Prevent default form submission

    var isValid = true;

    // Validate fields
         isValid &= validateField('name', 'nameError');
         
         
         isValid &= validateField('eAddress', 'addressError');
         isValid &= validateField('details', 'enquiryError'); 
         isValid &= validateField('ePhone', 'phoneError');
         isValid &= optionalEmail('eEmail', 'emailError');

    if (isValid) {
        $('#addEnquiry').trigger('submit'); // Manually trigger the form submit event if validation passes
    }
});

// Handle the form submission via AJAX
$('#addEnquiry').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var formData = new FormData(this);
    $.ajax({
        url: "action/actEnquiry.php",
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
                    $('#addEnquiryModal').modal('hide'); // Close the modal
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
                resetForm('addEnquiry');
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
    resetForm('addEnquiry');
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
    // Handle the form submission
    $('#updateBtn').click(function (e) {
        e.preventDefault(); // Prevent default button action

        var isValid = true;

        // Validate fields
        isValid &= validateName('EnameE', 'nameErrorE');
        isValid &= validateField('AddressE', 'addressErrorE');
        isValid &= validateField('detailsE', 'enquiryErrorE');
        isValid &= validatePhoneNumber('PhoneE', 'phoneErrorE');
        isValid &= optionalEmail('EmailE', 'emailErrorE');
        if (isValid) {
            $('#editEnquiry').trigger('submit'); // Trigger the form's submit event if validation passes
        }
    });

    // Handle the form submission via AJAX
    $('#editEnquiry').off('submit').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission

        var formData = new FormData(this);
        $.ajax({
            url: "action/actEnquiry.php",
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
                        $('#editEnquiryModal').modal('hide'); // Close the modal
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
                    text: 'An error occurred while adding Enquiry data.'
                });
            }
        });
    });

    $('#modalCloseBtnEdit').click(function () {
    hideErrorMessages(); // Call the function to hide error messages
});
});
</script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>