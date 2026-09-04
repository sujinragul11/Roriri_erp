<?php

session_start();
include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT
                    `vendor_id`,
                    `vendor_name`,
                    `email`,
                    `phone`,
                    `shop_name`,
                    `location`
                FROM
                    `asset_vendor`
                WHERE
                    `status` = 'Active'";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
<?php include("formVendor.php");?>
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
        <?php include("top.php"); ?>
		<!--end sidebar wrapper -->
		<!--start header -->
        <?php include("left.php"); ?>
			
		<!--end header -->
		<!--start page wrapper -->
		
		<div class="page-wrapper">

          
			<div class="page-content">
                
				
            <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline">Vendor Details</h2>
                    <div class="d-flex justify-content-end">
                        <button type="button" id="addVendorBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addVendorModal"><i class="lni lni-upload me-1"></i>Add Vendor</button>
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
										<th>Company Name</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                <?php
                                $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                $vendor_id      = $row['vendor_id'];  
                                $vendor_name    = htmlspecialchars($row['vendor_name'], ENT_QUOTES);
                                $email          = htmlspecialchars($row['email'], ENT_QUOTES);
                                $phone          = htmlspecialchars($row['phone'], ENT_QUOTES);
                                $shop_name      = htmlspecialchars($row['shop_name'], ENT_QUOTES);

                                ?>
                                <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $vendor_name; ?></td>
                                <td><?php echo $shop_name; ?></td>
                                <td><?php echo $phone; ?></td>
                                <td><?php echo $email; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#viewVendorModal" onclick="goViewVendor(<?php echo $vendor_id; ?>);" ><i class="lni lni-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditVendor(<?php echo $vendor_id; ?>);" data-bs-toggle="modal" data-bs-target="#editVendorModal"><i class="lni lni-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteVendor(<?php echo $vendor_id; ?>);"><i class="lni lni-trash"></i></button>
                                </td>
                                </tr>
                    <?php
                 } 
                 ?>   
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

     <!-- Initialize tooltips -->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <!--app JS-->
	<script src="<?php echo $app; ?>"></script>
    
<script src="../assets/js/form-validation.js"></script>
</body>

<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
		function resetForm(formId) {
            var form = $('#' + formId);
            form[0].reset();
            form.removeClass('was-validated');
        }
</script>
<script>
$(document).ready(function() {
    
    $('#addVendorBtn').on('click', function() {
        resetForm('vendorForm');  // Reset the form fields
        $('#submitFormBtn').prop('disabled', false); // Enable the submit button
    });
    // Handle the form submission via AJAX for Add Vendor
    $('#vendorForm').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
        $.ajax({
            url: "action/actVendor.php",
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
                        $('#addVendorModal').modal('hide'); 
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
                    // Reset the form after successful submission
                    resetForm('vendorForm');
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
                    text: 'An error occurred while adding Vendor data.'
                });
                $('#submitFormBtn').prop('disabled', false);
            }
        });
    });
    
    // Handle the form submission via AJAX for Edit Vendor
    $('#vendorFormEdit').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        $.ajax({
            url: "action/actVendor.php",
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
                        $('#editVendorModal').modal('hide'); 
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
                    // Reset the form after successful submission
                    resetForm('vendorFormEdit');
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
                    text: 'An error occurred while updating Vendor data.'
                });
                $('#submitEditBtn').prop('disabled', false);
            }
        });
    });
});
</script>
<script>
//Function to populate the edit form with the Vendor details for editing.
function goEditVendor(vendorId) {
    resetForm('vendorFormEdit');  
    $('#submitEditBtn').prop('disabled', false);
    
    $.ajax({
        url: 'action/actVendor.php',
        method: 'POST',
        data: {
            editVendorId : vendorId
        },
        dataType: 'json', 
        success: function(response) {
                $('#vendorId').val(response.id);
                $('#vendorNameEdit').val(response.name);
                $('#comNameEdit').val(response.company);
                $('#phoneEdit').val(response.phone);
                $('#emailEdit').val(response.email);
                $('#locationEdit').val(response.address);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

//Function to populate the view form with the Vendor details.
function goViewVendor(vendorId) {

    $.ajax({
        url: 'action/actVendor.php',
        method: 'POST',
        data: {
            editVendorId : vendorId
        },
        dataType: 'json', 
        success: function(response) {
                $('#viewName').text(response.name);
                $('#viewCompany').text(response.company);
                $('#viewPhone').text(response.phone);
                $('#viewEmail').text(response.email);
                $('#viewLocation').text(response.address);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

//Function to handle the deletion of a room.
function goDeleteVendor(venId) {
    // Show confirmation dialog before deletion
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,  
        confirmButtonColor: '#3085d6',  
        cancelButtonColor: '#d33',  
        confirmButtonText: 'Yes, delete it!',  
        reverseButtons: true 
    }).then((result) => {
        // If the user confirmed the deletion
        if (result.isConfirmed) {
            $.ajax({
                url: 'action/actVendor.php',  
                method: 'POST',
                data: { delId: venId },  
                dataType: 'json',  
                success: function(response) {
                    // If the deletion was successful
                    if (response.success) {
                        Swal.fire({
                            title: 'Deleted!',  
                            text: response.message,  
                            icon: 'success',  
                            timer: 3000,  
                            showConfirmButton: false 
                        }).then(() => {
                            // Reload the table or data after deletion
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
                        });
                    } else {
                        // Show error message if deletion failed
                        Swal.fire({
                            title: 'Error!',  
                            text: response.message,  
                            icon: 'error',  
                            timer: 3000,  
                            showConfirmButton: false 
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message if AJAX request failed
                    Swal.fire({
                        title: 'Error!',  
                        text: 'An error occurred while deleting the Vendor.',  
                        icon: 'error', 
                        showConfirmButton: false, 
                        timer: 3000  
                    });
                }
            });
        }
    });
}

</script>
</html>