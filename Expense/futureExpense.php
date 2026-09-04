<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
    $selQuery = "SELECT
                    `id`,
                    `name`,
                    `amount`,
                    `priority`,
                    `description`
                FROM
                    `expense_future`
                WHERE
                    `status` = 'Active'";
    
    $resQuery = mysqli_query($conn , $selQuery); 
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php include("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
		
		<!-- Loader -->

        <?php include "formFutureExpense.php";?>
		
		<div class="page-wrapper">
			<div class="page-content">
            <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline">Future Expenses</h2>
                    <div class="d-flex justify-content-end">
                        <!-- Button for Category -->
                        <button type="button" id="addFutureBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                            <i class="fadeIn animated bx bx-bookmark-plus"></i>Add Future Expense
                        </button>
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
                                        <th class="col-2 text-center">Reason</th>
										<th class="col-2 text-center">Amount</th>
										<th class="col-2 text-center">Priority</th>
										<th class="col-3 text-center">Description</th>
										<th class="col-2 text-center">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                    $id             = $row['id']; 
                                    $reason         = htmlspecialchars($row['name'], ENT_QUOTES);
                                    $priority       = htmlspecialchars($row['priority'], ENT_QUOTES);
                                    $description    = !empty($row['description']) ? htmlspecialchars($row['description'], ENT_QUOTES) : '---';
                                    $amount         = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency(htmlspecialchars($row['amount'], ENT_QUOTES), 'INR');
                                    ?>
                                    <tr>
                                        <td class="col-1 text-center"><?php echo $i; $i++; ?></td>
                                        <td class="col-2 text-center"><?php echo $reason; ?></td>
                                        <td class="col-2 text-end"><?php echo $amount; ?></td>
                                        <td class="col-2 text-center"><?php echo $priority; ?></td>
                                        <td class="col-3 text-wrap"><?php echo $description; ?></td>
                                        <td class="col-2 text-center">
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditExpense(<?php echo $id; ?>);" data-bs-toggle="tooltip" title="Edit Future Expense" data-bs-target="#top"><i class="lni lni-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Future Expense" data-bs-target="#top" onclick="goDeleteExpense(<?php echo $id; ?>);"><i class="lni lni-trash"></i></button>
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

        function resetForm(formId) {
            // Reset the form fields
            $(formId)[0].reset();
        
            $(formId).removeClass('was-validated');
            $(formId).addClass('needs-validation');
        }
        
        function goDeleteExpense(expenseId) {
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
                if (result.isConfirmed) {
                    $('#loader').show();
                    $.ajax({
                        url: 'action/actFutureExpense.php',  
                        method: 'POST',
                        data: { delId: expenseId },  
                        dataType: 'json',  
                        success: function(response) {
                            $('#loader').hide();
                            // If the deletion was successful
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',  
                                    text: response.message,  
                                    icon: 'success',  
                                    timer: 3000,  
                                    showConfirmButton: false 
                                }).then(() => {
                                    var currentPage = $('#example2').DataTable().page();
                               
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
                                        table.page(currentPage).draw(false);
                                        $('#example2 [data-bs-toggle="tooltip"]').tooltip();
                                    });
                                });
                            } else {
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
                            $('#loader').hide();
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',  
                                text: 'An error occurred while deleting the Future Expense Details.',  
                                icon: 'error', 
                                showConfirmButton: false, 
                                timer: 3000  
                            });
                        }
                    });
                }
            });
        }
        
        function goEditExpense(expenseId) {
            resetForm('#editExpenseForm');
            $('#submitEditBtn').prop('disabled', false);
            $('#loader').show();
            $.ajax({
                url: 'action/actFutureExpense.php',
                method: 'POST',
                data: {
                    expense_id : expenseId
                },
                dataType: 'json', 
                success: function(response) {
                        $('#expenseId').val(response.id); 
                        $('#reasonEdit').val(response.name);
                        $('#priorityEdit').val(response.priority);
                        $('#descriptionEdit').val(response.descript);
                        $('#amountEdit').val(response.amount);
                        $('#loader').hide();
                        $('#editExpenseModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    $('#loader').hide();
                }
            });
        }
        
    </script> 

	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
				
			$('#addFutureBtn').on('click', function() {
			    $('#submitFormBtn').prop('disabled', false);
                resetForm('#addExpenseForm');
            });
            
		    $('#addExpenseForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 
                
                $(this).find('input, textarea').each(function () {
                    if ($(this).val()) {
                        $(this).val($(this).val().trim());
                    }
                });

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }
        
                var formData = new FormData(this);
                $('#submitFormBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actFutureExpense.php",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json', 
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1000
                            }).then(function () {
                                $('#addExpenseModal').modal('hide'); 
                                $('.modal-backdrop').remove(); 
                                var currentPage = $('#example2').DataTable().page();
                               
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
                                        table.page(currentPage).draw(false);
                                        $('#example2 [data-bs-toggle="tooltip"]').tooltip();
                                    });
                                
                            });
                            // Reset the form after successful submission
                            $('#loader').hide(); 
                            resetForm('#addExpenseForm');
                            $('#submitFormBtn').prop('disabled', false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                            $('#submitFormBtn').prop('disabled', false);
                            $('#loader').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#loader').hide();
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while adding Future Expense details.'
                        });
                        $('#submitFormBtn').prop('disabled', false);
                    }
                });
            });
            
            $('#editExpenseForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 
                
                $(this).find('input, textarea').each(function () {
                    if ($(this).val()) {
                        $(this).val($(this).val().trim());
                    }
                });

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }

                var formData = new FormData(this);
                $('#submitEditBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actFutureExpense.php",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json', 
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1000
                            }).then(function () {
                                $('#editExpenseModal').modal('hide'); 
                                $('.modal-backdrop').remove(); 
                                var currentPage = $('#example2').DataTable().page();
                               
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
                                        table.page(currentPage).draw(false);
                                        $('#example2 [data-bs-toggle="tooltip"]').tooltip();
                                    });
                                
                            });
                            // Reset the form after successful submission
                            $('#loader').hide();
                            resetForm('#editExpenseForm');
                            $('#submitEditBtn').prop('disabled', false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                            $('#submitEditBtn').prop('disabled', false);
                            $('#loader').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#loader').hide();
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while updating Future Expense details.'
                        });
                        $('#submitEditBtn').prop('disabled', false);
                    }
                });
            });
		} );
    </script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>