<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
    $selQuery = "SELECT
                    a.`expense_id`,
                    a.`sub_id`,
                    a.`cash_handler`,
                    a.`date`,
                    a.`amount`,
                    b.`name` AS subname,
                    c.`name` AS catname
                FROM
                    `expense_details` AS a
                LEFT JOIN 
                	`expense_subcategory` AS b
                ON
                    a.`sub_id` = b.`subcat_id`
                LEFT JOIN 
                	`expense_category` AS c
                ON
                    b.`cat_id` = c.`cat_id`
                WHERE
                    a.`status` = 'Active'
                ORDER BY 
                    a.`date` DESC";
    
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

        <?php include "formExpense.php";?>
		
		<div class="page-wrapper">
			<div class="page-content">
            <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline">Expenses</h2>
                    <div class="d-flex justify-content-end">
                        <!-- Button for Category -->
                        <button type="button" id="addExpenseBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                            <i class="fadeIn animated bx bx-bookmark-plus"></i>Add Expense
                        </button>
                    </div>
                </div>
            </div>

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
						   <div class="mb-3 mt-1 d-flex justify-content-center">
                                <div class="col-12 col-sm-8 col-md-6 col-lg-4 d-flex align-items-center gap-2">
                                    <input type="text" id="customInput" name="customInput" class="form-control" placeholder="Filter the rows using the description">
                                    <button type="button" id="resetBtn" class="btn btn-primary flex-shrink-0" style="width: 100px;">
                                        <i class="fadeIn animated bx bx-refresh"></i> Reset
                                    </button>
                                </div>
                            </div>
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th class="col-1 text-center">S. No</th>
										<th class="col-2 text-center">Date</th>
                                        <th class="col-2 text-center">Category</th>
										<th class="col-2 text-center">Sub Category</th>
										<th class="col-2 text-center">Cash Handler</th>
										<th class="col-1 text-center">Amount</th>
										<th class="col-2 text-center">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                    $id             = $row['expense_id']; 
                                    $date           = date('d M Y', strtotime(htmlspecialchars($row['date'], ENT_QUOTES)));
                                    $category_name  = htmlspecialchars($row['catname'], ENT_QUOTES);
                                    $subcat_name    = htmlspecialchars($row['subname'], ENT_QUOTES);
                                    $receiver_name  = htmlspecialchars($row['cash_handler'], ENT_QUOTES);
                                    $amount         = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency(htmlspecialchars($row['amount'], ENT_QUOTES), 'INR');
                                    ?>
                                    <tr>
                                        <td class="col-1 text-center"><?php echo $i; $i++; ?></td>
                                        <td class="col-2 text-center"><?php echo $date; ?></td>
                                        <td class="col-2 text-center"><?php echo $category_name; ?></td>
                                        <td class="col-2 text-center"><?php echo $subcat_name; ?></td>
                                        <td class="col-2 text-center"><?php echo $receiver_name; ?></td>
                                        <td class="col-1 text-end"><?php echo $amount; ?></td>
                                        <td class="col-2 text-center">
                                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-target="#top" title="View Expense details" onclick="viewExpense(<?php echo $id; ?>);" ><i class="lni lni-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditExpense(<?php echo $id; ?>);" data-bs-toggle="tooltip" title="Edit Expense" data-bs-target="#top"><i class="lni lni-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Expense" data-bs-target="#top" onclick="goDeleteExpense(<?php echo $id; ?>);"><i class="lni lni-trash"></i></button>
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
                        url: 'action/actExpense.php',  
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
                                text: 'An error occurred while deleting the Expense Details.',  
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
                url: 'action/actExpense.php',
                method: 'POST',
                data: {
                    expense_id : expenseId
                },
                dataType: 'json', 
                success: function(response) {
                        $('#expenseId').val(response.id); 
                        $('#categoryNameEdit').val(response.catName).trigger('change');
                        setTimeout(function() {
                            $('#expenseDateEdit').val(response.date);
                            $('#descriptionEdit').val(response.descript);
                            $('#receiverNameEdit').val(response.receiver);
                            $('#transcationIdEdit').val(response.transId);
                            $('#modeEdit').val(response.mode);
                            $('#amountEdit').val(response.amount);
                            $('#subCatNameEdit').val(response.subName);
                            $('#loader').hide();
                            $('#editExpenseModal').modal('show');
                        }, 500);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    $('#loader').hide();
                }
            });
        }
        
        function viewExpense(expenseId) {
            $('#loader').show(); 
        
            $.ajax({
                url: 'action/actExpense.php', 
                method: 'POST',
                data: { view_expId: expenseId },
                dataType: 'json',
                success: function(response) {
                    $('#viewExpenseDate').text(response.date);
                    $('#viewCategoryName').text(response.catName);
                    $('#viewSubCategoryName').text(response.subName);
                    $('#viewReceiverName').text(response.receiver);
                    $('#viewAmount').text(new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(response.amount));
                    $('#viewMode').text(response.mode);
                    $('#viewTransactionId').text(response.transId || '-');
                    $('#viewBill').html(response.bill ? '<a href="https://asset.inforiya.in/ERP/ERP_image/ExpenseBill/' + response.bill + '" target="_blank">' + response.bill + '</a>' : '-');
                    $('#viewDescription').text(response.descript || '-');
        
                    $('#loader').hide(); 
                    $('#viewExpenseModal').modal('show'); 
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    $('#loader').hide();
                    alert('Failed to fetch expense details.');
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
				
			$('#addExpenseBtn').on('click', function() {
			    $('#submitFormBtn').prop('disabled', false);
                resetForm('#addExpenseForm');
            });
            
            $('#customInput').on('input', function () {
                const filterValue = $(this).val();
                
                $.ajax({
                    url: 'action/actExpense.php',
                    type: 'GET',
                    data: { description: filterValue },
                    dataType: 'json',
                    success: function(data) {
                        $('#example2').DataTable().destroy();
                        $('#example2 tbody').empty();
            
                        data.forEach(function(item, index) {

                            const rowHTML = `
                                <tr>
                                    <td class="col-1 text-center">${index + 1}</td> 
                                    <td class="col-2 text-center">${item.date}</td> 
                                    <td class="col-2 text-center">${item.catName}</td> 
                                    <td class="col-2 text-center">${item.subName}</td>
                                    <td class="col-2 text-center">${item.cash_handler}</td> 
                                    <td class="col-1 text-end">${item.amount}</td>
                                    <td class="col-2 text-center">
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-target="#top" title="View Expense details" onclick="viewExpense(${item.expense_id});" ><i class="lni lni-eye"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditExpense(${item.expense_id});" data-bs-toggle="tooltip" title="Edit Expense" data-bs-target="#top"><i class="lni lni-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Expense" data-bs-target="#top" onclick="goDeleteExpense(${item.expense_id});"><i class="lni lni-trash"></i></button>
                                    </td>
                                </tr>`;
                            
                            // Append the new row to the table body
                            $('#example2 tbody').append(rowHTML);
                        });
            
                        var table = $('#example2').DataTable({
                            "paging": true,
                            "ordering": true,
                            "searching": true,
                            lengthChange: false,
                            buttons: ['copy', 'excel', 'pdf', 'print']
                        });
            
                        // Move the button container to a specific location
                        table.buttons().container()
                            .appendTo('#example2_wrapper .col-md-6:eq(0)');
                        $('#example2 [data-bs-toggle="tooltip"]').tooltip();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            });
            
             $('#resetBtn').on('click', function () {
                $('#customInput').val('');
        
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
        
                    table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
                    $('#example2 [data-bs-toggle="tooltip"]').tooltip();
                });
            });
            
            $('#categoryName').on('change', function() {
                const categoryId = $(this).val();
                $('#subCatName').html('<option value="">--Select SubCategory--</option>');
        
                if (categoryId) {
                    $.ajax({
                        url: 'action/actExpense.php',  
                        type: 'POST',
                        data: { category_id: categoryId },
                        success: function(data) {
                            $('#subCatName').html(data);
                        },
                        error: function() {
                            alert('An error occurred while fetching subcategories.');
                        }
                    });
                } 
            });
            
            $('#categoryNameEdit').on('change', function() {
                const categoryId = $(this).val();
                $('#subCatNameEdit').html('<option value="">--Select SubCategory--</option>'); 
            
                if (categoryId) {
                    $.ajax({
                        url: 'action/actExpense.php',  
                        type: 'POST',
                        data: { category_id: categoryId },
                        success: function(data) {
                            $('#subCatNameEdit').html(data); 
                        },
                        error: function() {
                            alert('An error occurred while fetching subcategories.');
                        }
                    });
                } 
            });
				
		    $('#addExpenseForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }
        
                var formData = new FormData(this);
                $('#submitFormBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actExpense.php",
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
                            text: 'An error occurred while adding Expense details.'
                        });
                        $('#submitFormBtn').prop('disabled', false);
                    }
                });
            });
            
            $('#editExpenseForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }

                var formData = new FormData(this);
                $('#submitEditBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actExpense.php",
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
                            text: 'An error occurred while updating Expense details.'
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