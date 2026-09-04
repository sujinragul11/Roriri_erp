<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
    $selQuery = "SELECT
                    a.`subcat_id`,
                    a.`cat_id`,
                    a.`name` AS subName,
                    b.name AS catName
                FROM
                    `expense_subcategory` AS a
                LEFT JOIN 
                	`expense_category` AS b
                ON
                    a.cat_id = b.cat_id
                WHERE
                    a.`status` = 'Active'";
    
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

        <?php include "formSubCategory.php";?>
		
		<div class="page-wrapper">
			<div class="page-content">
            <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline">Sub Categories</h2>
                    <div class="d-flex justify-content-end">
                        <!-- Button for Category -->
                        <button type="button" id="addSubCategoryBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal">
                            <i class="fadeIn animated bx bx-bookmark-plus"></i>Add Sub Category
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
                                        <th class="col-4 text-center">Category</th>
										<th class="col-5 text-center">Sub Category</th>
										<th class="col-2 text-center">Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                    $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                    $id             = $row['subcat_id'];  
                                    $cat_id         = $row['cat_id'];
                                    $category_name  = htmlspecialchars($row['catName'], ENT_QUOTES);
                                    $subcat_name    = htmlspecialchars($row['subName'], ENT_QUOTES);
                                    ?>
                                    <tr>
                                        <td class="col-1 text-center"><?php echo $i; $i++; ?></td>
                                        <td class="col-4 text-center"><?php echo $category_name; ?></td>
                                        <td class="col-5 text-center"><?php echo $subcat_name; ?></td>
                                        <td class="col-2 text-center">
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditSubCat(<?php echo $id; ?>, <?php echo $cat_id; ?>, '<?php echo $subcat_name; ?>');" data-bs-toggle="tooltip" title="Edit SubCategory" data-bs-target="#top"><i class="lni lni-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete SubCategory" data-bs-target="#top" onclick="goDeleteSubCat(<?php echo $id; ?>);"><i class="lni lni-trash"></i></button>
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
        
        function goDeleteSubCat(subCatId) {
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
                        url: 'action/actSubCat.php',  
                        method: 'POST',
                        data: { delId: subCatId },  
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
                                text: 'An error occurred while deleting the SubCategory.',  
                                icon: 'error', 
                                showConfirmButton: false, 
                                timer: 3000  
                            });
                        }
                    });
                }
            });
        }
        
        function goEditSubCat(subCatId, catId, subCatName) {
            $('#submitEditBtn').prop('disabled', false);
            $('#categoryNameEdit').prop('disabled', true); 
            $('#loader').show();
            resetForm('#editSubCatForm');
            $('#subCategoryId').val(subCatId);
            $('#categoryNameEdit').val(catId);
            $('#subCatNameEdit').val(subCatName);
            $('#editSubCatModal').modal('show');
            $('#loader').hide();
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
				
			$('#addSubCategoryBtn').on('click', function() {
			    $('#submitFormBtn').prop('disabled', false);
                resetForm('#addSubCatForm');
            });
				
		    $('#addSubCatForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }
        
                var formData = new FormData(this);
                $('#submitFormBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actSubCat.php",
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
                                $('#addSubCategoryModal').modal('hide'); 
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
                            resetForm('addSubCatForm');
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
                            text: 'An error occurred while adding SubCategory details.'
                        });
                        $('#submitFormBtn').prop('disabled', false);
                    }
                });
            });
            
            $('#editSubCatForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }
                $('#categoryNameEdit').prop('disabled', false); 
        
                var formData = new FormData(this);
                $('#submitEditBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actSubCat.php",
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
                                $('#editSubCatModal').modal('hide'); 
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
                            resetForm('editCategoryForm');
                            $('#submitEditBtn').prop('disabled', false);
                            $('#categoryNameEdit').prop('disabled', true); 
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                            $('#submitEditBtn').prop('disabled', false);
                            $('#categoryNameEdit').prop('disabled', true); 
                            $('#loader').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#loader').hide();
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while updating SubCategory details.'
                        });
                        $('#submitEditBtn').prop('disabled', false);
                        $('#categoryNameEdit').prop('disabled', true); 
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