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
<?php include("formService.php");?>
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
                        <h2 class="page-title text-muted text-decoration-underline">Enquiry Details</h2>
                    </div>
                </div>
                <div class="card">
					<div class="card-body">
						<ul class="nav nav-pills mb-3" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-home" role="tab" aria-selected="true">
									<div class="d-flex align-items-center">
										<div class="tab-icon"><i class='bx bx-calendar-event font-18 me-1'></i>
										</div>
										<div class="tab-title">Upcoming Visits</div>
									</div>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" data-bs-toggle="pill" href="#primary-pills-profile" role="tab" aria-selected="false">
									<div class="d-flex align-items-center">
										<div class="tab-icon"><i class='bx bx-calendar-check font-18 me-1'></i>
										</div>
										<div class="tab-title">Completed Visits</div>
									</div>
								</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="primary-pills-home" role="tabpanel">
								<div class="card">
                					<div class="card-body">
                						<div class="table-responsive">
                							<table id="example2" class="table table-striped table-bordered">
                								<thead>
                									<tr>
                                                        <th>S. No</th>
                										<th>College Name</th>
                										<th>Date</th>
                										<th>Department</th>
                										<th>Students Count</th>
                										<th>Staff Count</th>
                										<th>Status</th>
                										<th>Action</th>
                									</tr>
                								</thead>
                								<tbody>
                                                <?php
                                                $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                           
                                                $service_id      = $row['service_id'];  
                                                $product_name    = htmlspecialchars($row['product_no'], ENT_QUOTES) . ' - ' . htmlspecialchars($row['product_name'], ENT_QUOTES);
                                                $service_date    = htmlspecialchars($row['service_date'], ENT_QUOTES);
                                                $return_date     = htmlspecialchars($row['return_date'], ENT_QUOTES);
                                                $amount          = htmlspecialchars($row['amount'], ENT_QUOTES);
                
                                                ?>
                                                <tr>
                                                
                                                </tr>
                                                <?php }  ?>   
                								</tbody>
                							</table>
                						</div>
                					</div>
                				</div>
							</div>
							<div class="tab-pane fade" id="primary-pills-profile" role="tabpanel">
								<div class="card">
                					<div class="card-body">
                						<div class="table-responsive">
                							<table id="example2" class="table table-striped table-bordered">
                								<thead>
                									<tr>
                                                        <th>S. No</th>
                										<th>College Name</th>
                										<th>Date</th>
                										<th>Department</th>
                										<th>Students Count</th>
                										<th>Staff Count</th>
                										<th>Status</th>
                										<th>Action</th>
                									</tr>
                								</thead>
                								<tbody>
                                                <?php
                                                $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                           
                                                $service_id      = $row['service_id'];  
                                                $product_name    = htmlspecialchars($row['product_no'], ENT_QUOTES) . ' - ' . htmlspecialchars($row['product_name'], ENT_QUOTES);
                                                $service_date    = htmlspecialchars($row['service_date'], ENT_QUOTES);
                                                $return_date     = htmlspecialchars($row['return_date'], ENT_QUOTES);
                                                $amount          = htmlspecialchars($row['amount'], ENT_QUOTES);
                
                                                ?>
                                                <tr>
                                                
                                                </tr>
                                                <?php }  ?>   
                								</tbody>
                							</table>
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
		 <?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->

<div id="loader" style="display: none;">
	<div class="card-body">
		<div class="spinner-grow text-primary" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-secondary" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-success" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-danger" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-warning" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-info" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-light" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-dark" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
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
    
    $('#addServiceBtn').on('click', function() {
        resetForm('serviceForm');  // Reset the form fields
        $('#submitFormBtn').prop('disabled', false); // Enable the submit button
    });
    
    //Load the product based on selected category
    $('#subCatName').on('change', function() {
        var categoryId = $(this).val();
        
        if (categoryId != '') {
            $.ajax({
                url: 'action/actService.php',
                method: 'POST',
                data: { category_id: categoryId },
                dataType: 'json',
                success: function(response) {
                    var productDropdown = $('#proName');
                    productDropdown.empty(); 

                    if (response.length > 0) {
                        productDropdown.append('<option value="">--Select a Product Name--</option>');
                        
                        $.each(response, function(index, product) {
                            var optionText = product.pro_no + ' - ' + product.name;
                            productDropdown.append('<option value="' + product.id + '">' + optionText + '</option>');
                        });
                    } else {
                        productDropdown.append('<option value="">No Products Available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed: ', status, error);
                }
            });
        } else {
            // If no category is selected, reset the product dropdown
            $('#proName').html('<option value="">--Select a Product Name--</option>');
        }
    });
    
    $('#subCatNameEdit').on('change', function() {
        var categoryId = $(this).val();
        
        if (categoryId != '') {
            $.ajax({
                url: 'action/actService.php',
                method: 'POST',
                data: { category_id: categoryId },
                dataType: 'json',
                success: function(response) {
                    var productDropdown = $('#proNameEdit'); // Assuming there's a corresponding dropdown for product in edit mode
                    productDropdown.empty(); 
    
                    if (response.length > 0) {
                        productDropdown.append('<option value="">--Select a Product Name--</option>');
                        
                        $.each(response, function(index, product) {
                            var optionText = product.pro_no + ' - ' + product.name;
                            productDropdown.append('<option value="' + product.id + '">' + optionText + '</option>');
                        });
                    } else {
                        productDropdown.append('<option value="">No Products Available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed: ', status, error);
                }
            });
        } else {
            // If no category is selected, reset the product dropdown
            $('#proNameEdit').html('<option value="">--Select a Product Name--</option>');
        }
    });

    
    // Handle the form submission via AJAX for Add Service
    $('#serviceForm').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; 
        }

        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
        $.ajax({
            url: "action/actService.php",
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
                        $('#addServiceModal').modal('hide'); 
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
                    resetForm('serviceForm');
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
    
    // Handle the form submission via AJAX for Edit Service
    $('#serviceFormEdit').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        $.ajax({
            url: "action/actService.php",
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
                        $('#editServiceModal').modal('hide'); 
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
                    resetForm('serviceFormEdit');
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
function goEditService(serviceId) {
    resetForm('serviceFormEdit');  
    $('#submitEditBtn').prop('disabled', false);
    $('#loader').show();
    $.ajax({
        url: 'action/actService.php',
        method: 'POST',
        data: {
            editServiceId : serviceId
        },
        dataType: 'json', 
        success: function(response) {
                $('#serviceId').val(response.id);
                $('#subCatNameEdit').val(response.catName).trigger('change');
                setTimeout(function() {
                    $('#proNameEdit').val(response.proName);
                    $('#serDateEdit').val(response.serDate);
                    $('#descriptionEdit').val(response.descript);
                    $('#retDateEdit').val(response.retDate);
                    $('#amountEdit').val(response.amount);
                    $('#loader').hide();
                    $('#editServiceModal').modal('show');
                }, 500);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
            $('#loader').hide();
        }
    });
}

//Function to populate the view form with the Service details.
function goViewService(serviceId) {

    $.ajax({
        url: 'action/actService.php',
        method: 'POST',
        data: {
            viewServiceId : serviceId
        },
        dataType: 'json', 
        success: function(response) {
                $('#viewName').text(response.name);
                $('#viewSerDate').text(new Date(response.serDate).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }));
                $('#viewDescription').text(response.descript);
                $('#viewRetDate').text(response.retDate === '0000-00-00' ? 'Not received' : new Date(response.retDate).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }));
                $('#viewAmount').text('â‚¹ ' + parseFloat(response.amount).toLocaleString('en-IN', { minimumFractionDigits: 2 }));
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
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