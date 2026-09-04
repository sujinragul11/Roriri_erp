<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT * FROM `food_packages_tbl` WHERE `status`='Active' ";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include "head.php";?>

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
        <?php include "left.php";?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include "top.php";?>
		<!--end header -->
		<!--start page wrapper -->
        <?php include "formFood.php";?>
		
		<div class="page-wrapper">
			<div class="page-content">


            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Food Package List</h2>
                    <div class="col text-end pb-3">
                    <button type="button" id="addFoodBtn" class="btn btn-primary px-5 radius-30" data-bs-toggle="modal" data-bs-target="#addFoodModal"><i class="lni lni-plus me-1"></i> Food Package</button>
                    </div>

                </div>
                   
            </div>

            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5" id="foodContainer">

            <?php  while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                 $id        = $row['id'];  
                 $cotegory      =$row['category'];   
                 $name   =$row['name'];
                 $image   =$row['image'];
                 
            ?>
                  <div class="col">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="ratio ratio-4x3"> <!-- Bootstrap's responsive ratio class -->
                <img src="image/food/<?php echo $image; ?>" class="card-img-top img-fluid object-fit-cover" alt="Food Image">
            </div>
            <div class="card-body d-flex flex-column">
                <h4 class="my-1 text-center text-truncate" style="max-width: 100%;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $name; ?>">
                    <?php echo $name; ?>
                </h4>
                <!-- Display the category -->
                <p class="text-center text-muted">Category : <?php echo $cotegory; ?></p>
                <hr>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <button class="btn btn-primary" onclick="goEditFood(<?php echo $id; ?>)" data-bs-toggle="modal" data-bs-target="#editFoodModal">
                        <i class='bx bx-pencil'></i> 
                    </button>
                    <button class="btn btn-danger" onclick="goDeleteFood(<?php echo $id; ?>)">
                        <i class='bx bx-trash'></i> 
                    </button>
                </div>
            </div>
        </div>
    </div>
            <?php } ?>  

         
            
					
					</div>
				</div>
				
				<div class="card">
							<div class="card-body">
								<ul class="nav nav-pills mb-3" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-home" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
												</div>
												<div class="tab-title">Live History</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="pill" href="#primary-pills-profile" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
												</div>
												<div class="tab-title">Completed History</div>
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
										<th>Name</th>
										<th>Position</th>
										<th>Office</th>
										<th>Age</th>
										<th>Start date</th>
										<th>Salary</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Tiger Nixon</td>
										<td>System Architect</td>
										<td>Edinburgh</td>
										<td>61</td>
										<td>2011/04/25</td>
										<td>$320,800</td>
									</tr>
								
								
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
							<table id="example3" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Name</th>
										<th>Position</th>
										<th>Office</th>
										<th>Age</th>
										<th>Start date</th>
										<th>Salary</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Tiger Nixon</td>
										<td>System Architect</td>
										<td>Edinburgh</td>
										<td>61</td>
										<td>2011/04/25</td>
										<td>$320,800</td>
									</tr>
								
								
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
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>


      var quill = new Quill('#editor', {
        theme: 'snow', // You can also use 'bubble' theme
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['link', 'blockquote', 'code-block', 'image'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['clean'] // Removes formatting
            ]
        }
    });
    
       // On form submit, update the hidden textarea with the content from Quill editor
    document.querySelector('form').onsubmit = function() {
        // Get HTML content from Quill editor
        var descriptionContent = document.querySelector('#description');
        descriptionContent.value = quill.root.innerHTML; // Set Quill content to hidden textarea
    };
    
    
    
     var quill1 = new Quill('#editorEdit', {
        theme: 'snow', // You can also use 'bubble' theme
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['link', 'blockquote', 'code-block', 'image'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['clean'] // Removes formatting
            ]
        }
    });
    
       // On form submit, update the hidden textarea with the content from Quill editor
    document.querySelector('#editFood').onsubmit = function() {
        // Get HTML content from Quill editor
        var descriptionContent1 = document.querySelector('#descriptionEdit');
        descriptionContent1.value = quill1.root.innerHTML; // Set Quill content to hidden textarea
    };
    
    
    
	$(document).ready(function() {
    // Initialize DataTable for example3
    var table3 = $('#example3').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print']
    });
    
    table3.buttons().container()
        .appendTo('#example3_wrapper .col-md-6:eq(0)');

    // Initialize DataTable for example2
    var table2 = $('#example2').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print']
    });
    
    table2.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
});



    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
       // Function to reset the form and hide error messages
       function resetForm(formId) {
    // Reset the form fields
    document.getElementById(formId).reset(); // Reset form inputs

    // Remove Bootstrap validation styles
    $('#' + formId).removeClass('was-validated'); // Remove validation class

    // Clear any custom validation messages
    $('#' + formId).find('.invalid-feedback').remove(); // Remove any invalid feedback messages
    }
 



 // Reset the form when the close button is clicked
 $('#addCourse').click(function () {
         resetForm('courseForm');
     });

</script>

    
    <script>
 
function goDeleteFood(id) {
    // Use SweetAlert to show confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms, proceed with the AJAX request
            $.ajax({
                url: 'action/actFood.php',
                method: 'POST',
                data: { deleteId: id },
                success: function (response) {
                    // Show SweetAlert based on the response
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: response.message,
                            timer: 1000
                        }).then(function () {
                            // Reload the card container
                            $('#foodContainer').load(location.href + ' #foodContainer > *');
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
                    console.error('AJAX request failed:', status, error);
                }
            });
        }
    });
}

//Data Table script 
    </script>
	

	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>

<script>

    $('#addFoodBtn').on('click', function() {
    // Reset the form fields
    $('#addFood')[0].reset();

     $('#addFood').removeClass('was-validated');
        $('#addFood').addClass('needs-validation');
});

      // Handle the form submission via AJAX
   // Handle the form submission via AJAX
$('#addFood').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission
    
     var nameField = $('#name'); // Select the input field by ID
    nameField.val($.trim(nameField.val())); // Trim leading and trailing spaces
    
     // Check if the form is valid using Bootstrap validation
        if (!this.checkValidity()) {
            $(this).addClass('was-validated'); // Add validation class
            return; // Stop the submission
        }
        
    var formData = new FormData(this);
    var submitButton = $(this).find('button[type="submit"]'); // Find the submit button
    submitButton.prop('disabled', true); // Disable the submit button to prevent double-clicks

    $.ajax({
        url: "action/actFood.php",
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
                    timer: 1000
                }).then(function () {
                    $('#addFoodModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
                    
                    $('#foodContainer').load(location.href + ' #foodContainer > *');
                });

                // Reset the form after successful submission
                resetForm('addFood');
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
                text: 'An error occurred while adding Food data.'
            });
        },
        complete: function() {
            submitButton.prop('disabled', false); // Re-enable the submit button after AJAX completes
        }
    });
});
    
    
    function resetForm(formId) {
    document.getElementById(formId).reset(); // Reset the form
    $('.error-message').hide(); // Hide all error messages
}





// edit function ---------------
function goEditFood(clientId) {
    
    
    $('#editFood').removeClass('was-validated');
        $('#editFood').addClass('needs-validation');
        
    $('#submitEditBtn').prop('disabled', false);
    
    $.ajax({
        url: 'action/actFood.php',
        method: 'POST',
        data: {
            food_edit : clientId
        },
        dataType: 'json', 
        success: function(response) {
                $('#food_id').val(response.id);
                $('#categoryEdit').val(response.category);
                $('#nameEdit').val(response.name);
                
                 // Function to decode HTML entities
                function decodeHtmlEntities(str) {
                    var textArea = document.createElement('textarea');
                    textArea.innerHTML = str;
                    return textArea.value;
                }

                // Set the content of the Quill editor
                if (quill1) { // Ensure Quill is initialized
                    let decodedContent = decodeHtmlEntities(response.discretion); // Decode HTML entities
                    quill1.root.innerHTML = decodedContent; // Set decoded HTML content
                }
                
                // $('#descriptionEdit').val(response.description);
                $('#priceEdit').val(response.price);
                
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}



// ----edit function -----------------

  // Handle the form submission via AJAX
$('#editFood').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission
    
    var nameField = $('#nameEdit'); // Select the input field by ID
    nameField.val($.trim(nameField.val())); // Trim leading and trailing spaces
    
     // Check if the form is valid using Bootstrap validation
        if (!this.checkValidity()) {
            $(this).addClass('was-validated'); // Add validation class
            return; // Stop the submission
        }
    
    var formData = new FormData(this);
    var submitButton = $(this).find('button[type="submit"]'); // Find the submit button
    submitButton.prop('disabled', true); // Disable the submit button to prevent double-clicks

    $.ajax({
        url: "action/actFood.php",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json', // Expect JSON response
        success: function (response) {
            
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 1000
                }).then(function () {
                    $('#editFoodModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
                    
                 $('#foodContainer').load(location.href + ' #foodContainer > *');
                });

                // Reset the form after successful submission
                resetForm('editFood');
          
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding Food data.'
            });
        },
        complete: function() {
            submitButton.prop('disabled', false); // Re-enable the submit button after AJAX completes
        }
    });
});

</script>