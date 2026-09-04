<?php

session_start();
include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT
                    a.`service_id`,
                    a.`service_date`,
                    a.`return_date`,
                    a.`amount`,
                    b.product_no,
                    b.product_name
                FROM
                    `asset_service` AS a
                LEFT JOIN `asset_product` AS b
                ON
                    a.assetpro_id = b.assetpro_id
                WHERE
                    a.`status` = 'Active'
                ORDER BY CASE WHEN
                    a.`return_date` = '0000-00-00' THEN 0 ELSE 1
                END,
                a.`return_date`";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
<?php include("formPayment.php");?>
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
                    <h2 class="page-title text-muted text-decoration-underline">Payment Details</h2>
                    <div class="d-flex justify-content-end">
                        <button type="button" id="addPaymentBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addPaymentModal"><i class="lni lni-upload me-1"></i>Add Payment</button>
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
										<th>Client Name</th>
										<th>Paid Date</th>
										<th>Payment</th>
										<th>Payment Method</th>
										<th>Reason</th>
										<th>Action</th>
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

<div id="loader" style="display: none;">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
	



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
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<!-- DataTables JS -->


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
		    
		var table = $('#example2').DataTable({
    lengthChange: false,
    serverSide: true,
    processing: true,
    ajax: {
        url: "action/actPayment.php", // PHP file to fetch data
        type: "POST",
        data: function(d) {
            d.TableName = "newTable"; // Send TableName with the AJAX request
        }
    },
    columns: [
        { data: "id" },
        { data: "name" },
        { data: "paid_date"},
        { data: "payment_method" },
        { data: "amount" },
        { data: "reason" },
        { data: "action" }
    ],
    buttons: ['copy', 'excel', 'pdf', 'print'] // Move this inside the object
});

// Append buttons to the DataTable container
table.buttons().container()
    .appendTo('#example2_wrapper .col-md-6:eq(0)');
				
			const today = new Date().toISOString().split('T')[0]; 
            $('#serDate').attr('max', today);
            $('#retDate').attr('max', today);
            $('#serDateEdit').attr('max', today);
            $('#retDateEdit').attr('max', today);
		} );
		function resetForm(formId) {
            var form = $('#' + formId);
            form[0].reset();
            form.removeClass('was-validated');
        }
</script>
<script>
$(document).ready(function() {
    
    // Handle the form submission via AJAX for Add Service
    $('#addPayment').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; 
        }

        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
        $.ajax({
            url: "action/actPayment.php",
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
                        $('#addPaymentModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                        
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
                    resetForm('addPayment');
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
                    text: 'An error occurred while adding Service data.'
                });
                $('#submitFormBtn').prop('disabled', false);
            }
        });
    });
    
    
    $('#addServiceBtn').on('click', function() {
        resetForm('serviceForm');  // Reset the form fields
        $('#submitFormBtn').prop('disabled', false); // Enable the submit button
    });
    
  

    
    // Handle the form submission via AJAX for Edit Service
    $('#editPayment').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        $.ajax({
            url: "action/actPayment.php",
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
                        $('#editPaymentModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                        
                             // Reload DataTable with new data
                    if ($.fn.DataTable.isDataTable('#example2')) {
                        $('#example2').DataTable().ajax.reload(null, false); // Reload DataTable without resetting pagination
                    } else {
                        // Initialize DataTable if not already initialized
                        var table = $('#example2').DataTable({
                            lengthChange: false,
                            serverSide: true,
                            processing: true,
                            ajax: {
                                url: "action/actPayment.php",
                                type: "POST",
                                data: function(d) {
                                    d.TableName = "newTable";
                                }
                            },
                            columns: [
                                { data: "id" },
                                { data: "name" },
                                { data: "paid_date" },
                                { data: "payment_method" },
                                { data: "amount" },
                                { data: "reason" },
                                { data: "action" }
                            ],
                            buttons: ['copy', 'excel', 'pdf', 'print']
                        });
                
                        // Append buttons to the DataTable container
                        table.buttons().container()
                            .appendTo('#example2_wrapper .col-md-6:eq(0)');
                    }
                                       
                    });
                    // Reset the form after successful submission
                    resetForm('editPayment');
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
                    text: 'An error occurred while updating Service data.'
                });
                $('#submitEditBtn').prop('disabled', false);
            }
        });
    });
});
</script>
<script>
//Function to populate the edit form with the Service details for editing.
function goEditPayment(id) {
    resetForm('editPayment');  
    $('#submitEditBtn').prop('disabled', false);
    $('#loader').show();
    $.ajax({
        url: 'action/actPayment.php',
        method: 'POST',
        data: {
            editPayId : id
        },
        dataType: 'json', 
        success: function(response) {
                    $('#editPaymentId').val(response.id);
                    $('#visitEdit').val(response.visit_id);
                    $('#reasonEdit').val(response.reason);
                    $('#amountEdit').val(response.amount);
                    $('#paymentMethodEdit').val(response.payment_method);
                    $('#transactionIdEdit').val(response.traisanction_id);
                    $('#dateEdit').val(response.paid_date);
                    $('#loader').hide();
                    $('#editPaymentModal').modal('show');
                
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
            $('#loader').hide();
        }
    });
}



//Function to handle the deletion of a room.
function goDeleteService(serviceId) {
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
                url: 'action/actService.php',  
                method: 'POST',
                data: { delId: serviceId },  
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
                        text: 'An error occurred while deleting the Service.',  
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