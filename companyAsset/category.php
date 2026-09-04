<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT 
    a.subcat_id, 
    b.category_name,
    a.Subcategory,
    a.quantity

FROM 
    `asset_subcategory` AS a 
LEFT JOIN 
    `asset_category` AS b ON a.assetcate_id = b.assetcate_id
WHERE 
    a.staus = 'Active' 
ORDER BY 
    a.subcat_id DESC;";
    
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
		
		<!-- Loader -->
    <
		
		<!-- Loader Spinner -->
    <div id="loader" class="d-none position-fixed top-50 start-50 translate-middle">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
        <?php include("formCategory.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline">Category List</h2>
                    <div class="d-flex justify-content-end">
                        <!-- Button for Category -->
                        <button type="button" id="addCategoryBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fadeIn animated bx bx-bookmark-plus"></i> Category
                        </button>
                        <!-- Button for Sub Category -->
                        <button type="button" id="addSubCategoryBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal">
                            <i class="fadeIn animated bx bx-bookmark-plus"></i> Sub Category
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
                                        <th>S. No</th>
										<th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Quantity</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $subcat_id  = $row['subcat_id'];  
                                        $category_name=$row['category_name'];   
                                        $Subcategory  = $row['Subcategory'];  
                                        $quantity          = $row['quantity'];
                                       

                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo $category_name; ?></td>
                      <td><?php echo $Subcategory; ?></th>
                      <td><?php echo $quantity; ?></td>
                     
                    
                      
                      <td>
                          
                          <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditClient(<?php echo $subcat_id; ?>);"><i class="lni lni-pencil"></i></button>
                         
                         
                          <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteCategory(<?php echo $subcat_id; ?>);"><i class="lni lni-trash"></i></button>
                          
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
        
        
// Add click event listener to the "Add Category" button
$('#addCategoryBtn').on('click', function() {
    resetForm('#addCategoryForm');
});

// Add click event listener to the "Add Subcategory" button
$('#addSubCategoryBtn').on('click', function() {
    resetForm('#addSubCategoryForm');
});

// Function to reset the form and remove validation messages
function resetForm(formId) {
    // Reset the form fields
    $(formId)[0].reset();

     $(formId).removeClass('was-validated');
        $(formId).addClass('needs-validation');
}     
        
    </script>
    <script>
     $(document).ready(function() {
    // Fetch categories when the modal is shown
    $('#addSubCategoryModal').on('show.bs.modal', function() {
        $.ajax({
            url: 'action/actCategory.php', // Replace with your actual URL to fetch categories
            method: 'GET',
            data: {
                action: 'getCategory' // Fixed syntax: use key-value pair correctly
            },
            dataType: 'json',
            success: function(data) {
                let options = '<option value="" disabled selected>Select a category</option>';
                data.forEach(category => {
                    options += `<option value="${category.assetcate_id}">${category.category_name}</option>`;
                });
                $('#categorySelect').html(options);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching categories:', error);
            }
        });
    });
});
    </script>
    
   <script>
    document.getElementById('addCategoryForm').addEventListener('submit', function(event) {
    // Prevent default form submission
    event.preventDefault();
    
    // Check if the form is valid
    if (this.checkValidity() === false) {
        // Add the 'was-validated' class to show validation feedback
        event.stopPropagation();
        this.classList.add('was-validated');
    } else {
        // If valid, proceed with form submission
        const formData = $(this).serialize(); // Serialize form data
        
        // Show loader (if you have a loader implemented)
        $('#loader').removeClass('d-none');

        $.ajax({
            url: 'action/actCategory.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Category Added',
                        text: response.message,
                        timer: 1500
                    });
                    $('#addCategoryModal').modal('hide'); // Hide modal
                    $('#addCategoryForm')[0].reset(); // Reset form
                    // Optionally reload the categories or update the UI here
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding category:', error);
            },
            complete: function() {
                $('#loader').addClass('d-none'); // Hide loader
            }
        });
    }
});
    
    
document.getElementById('addSubCategoryForm').addEventListener('submit', function(event) {
    // Prevent default form submission
    event.preventDefault();
    
    // Check if the form is valid
    if (this.checkValidity() === false) {
        // Add the 'was-validated' class to show validation feedback
        event.stopPropagation();
        this.classList.add('was-validated');
    } else {
        // If valid, proceed with form submission
        const formData = $(this).serialize(); // Serialize form data
        
        // Show loader (if you have a loader implemented)
        $('#loader').removeClass('d-none');

        $.ajax({
            url: 'action/actCategory.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Subcategory Added',
                        text: response.message,
                        timer: 1500
                    });
                    $('#addSubCategoryModal').modal('hide'); // Hide modal
                    $('#addSubCategoryForm')[0].reset(); // Reset form
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding subcategory:', error);
            },
            complete: function() {
                $('#loader').addClass('d-none'); // Hide loader
            }
        });
    }
});


// Assuming you have a button to open the edit modal
function goEditClient(id)  {
    const subcatId = id; // Get the subcategory ID from the button data attribute
     $('#editSubCategoryForm').removeClass('was-validated');
        $('#editSubCategoryForm').addClass('needs-validation');

    // Fetch the existing subcategory data
    $.ajax({
        url: 'action/actCategory.php', // Replace with your actual URL to fetch subcategory details
        method: 'GET',
        data: { subcat_id: subcatId },
        dataType: 'json',
        success: function(data) {
            if (data) {
                $('#editSubcatId').val(data.subcat_id); // Set the hidden ID field
                $('#editSubcategoryName').val(data.Subcategory); // Set the subcategory name
                $('#editQuantity').val(data.quantity); // Set the quantity

                // Fetch categories for the dropdown
                $.ajax({
                    url: 'action/actCategory.php',
                    method: 'GET',
                    data: {
                   action: 'getCategory' // Fixed syntax: use key-value pair correctly
                         },
                    dataType: 'json',
                    success: function(categories) {
                        let options = '<option value="" disabled>Select a category</option>';
                        categories.forEach(category => {
                            const selected = category.assetcate_id === data.assetcate_id ? 'selected' : ''; // Check if this category is selected
                            options += `<option value="${category.assetcate_id}" ${selected}>${category.category_name}</option>`;
                        });
                        $('#editCategorySelect').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching categories:', error);
                    }
                });

                // Show the modal
                $('#editSubCategoryModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching subcategory:', error);
        }
    });
};



document.getElementById('editSubCategoryForm').addEventListener('submit', function(event) {
    // Prevent default form submission
    event.preventDefault();
    
    // Check if the form is valid
    if (this.checkValidity() === false) {
        // Add the 'was-validated' class to show validation feedback
        event.stopPropagation();
        this.classList.add('was-validated');
    } else {
        // If valid, proceed with form submission
        const formData = $(this).serialize(); // Serialize form data
        
        // Show loader (if you have a loader implemented)
        $('#loader').removeClass('d-none');

        $.ajax({
            url: 'action/actCategory.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Subcategory Updated',
                        text: response.message,
                        timer: 1500
                    });
                    $('#editSubCategoryModal').modal('hide'); // Hide modal
                    $('#editSubCategoryForm')[0].reset(); // Reset form
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating subcategory:', error);
            },
            complete: function() {
                $('#loader').addClass('d-none'); // Hide loader
            }
        });
    }
});


</script>
    <script>
        


//Function to handle the deletion of a room.
function goDeleteCategory(Id) {
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
                url: 'action/actCategory.php',  
                method: 'POST',
                data: { delId: Id },  
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
                        text: 'An error occurred while deleting the room.',  
                        icon: 'error', 
                        showConfirmButton: false, 
                        timer: 3000  
                    });
                }
            });
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


<script>



</script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>