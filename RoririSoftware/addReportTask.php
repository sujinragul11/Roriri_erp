<?php

session_start();

include("../db/dbConnection.php");

include("../url.php");


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
			<?php include("addReportTaskForm.php");?>
		
		<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm" novalidate class="needs-validation">
          <div class="mb-3">
            <label for="editCategoryName" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="editCategoryName" name="category" required>
          </div>
          <!-- Add more fields as necessary -->
          <input type="hidden" id="editCategoryId" name="id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveEditBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>



        <div class="modal fade" id="editReportModal" tabindex="-1" aria-labelledby="editReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Edit SubCategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmAddDepartment" id="editSubcategoryForm" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="editSubcategory">
                    <input type="hidden" name="editSubId" id="editSubId">

                    <!-- Project Name Field -->
                    <div class="col-md-12">
                        <label for="subcategorySelectEdit" class="form-label">Category<span class="text-danger">*</span></label>
                        <select class="form-control" name="subcategorySelectEdit" id="subcategorySelectEdit" required>
                            <option value="">--Select--</option>
                      
                        </select>
                        <div class="invalid-feedback">Please select a Category name.</div>
                    </div>
                    

                    <!-- Multiple Image Upload Field for New Images -->
                    <div class="col-md-12">
                        <label for="subcategoryEdit" class="form-label">SubCategory<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="subcategoryEdit" id="subcategoryEdit" >
                        <div class="invalid-feedback">Please enter the Subcategory.</div>
                    </div>

                    

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit Task Modal -->
<div class="modal fade" id="taskFormModal" tabindex="-1" aria-labelledby="taskFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskFormModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="taskForm" novalidate class="needs-validation">
                  <input type="hidden"  name="action" value="updateTaskFrom">
                  <input type="hidden"  name="editTask_id" id="editTask_id">
                <div class="mb-3">
                    <label for="categorySelectTaskEdit" class="form-label">Category</label>
                    <select class="form-control" id="categorySelectTaskEdit" name="categorySelectTaskEdit" required>
                        <option value="">Select Category</option>
                        <!-- Categories will be populated dynamically -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subcategorySelectTaskEdit" class="form-label">Subcategory</label>
                    <select class="form-control" id="subcategorySelectTaskEdit" name="subcategorySelectTaskEdit" required>
                        <option value="">Select Subcategory</option>
                        <!-- Subcategories will be populated dynamically based on selected category -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="taskNameEdit" class="form-label">Task Name</label>
                    <input type="text" class="form-control" id="taskNameEdit" name="taskNameEdit" required>
                </div>
                <div class="mb-3">
                    <label for="hoursEdit" class="form-label">Hours</label>
                    <input type="number" class="form-control" id="hoursEdit" name="hoursEdit" min="0" step="0.1" required>
                </div>
                <button type="button" id="updateTaskButton" class="btn btn-primary" onclick="updateTask()">Save Changes</button>
            </form>

            </div>
        </div>
    </div>
</div>

		

		<div class="page-wrapper">
		    
	

			<div class="page-content">


				

            <div class="page-title-box">

                

                <div class="page-title-right">

                    <h2 class="page-title">Daily Report</h2>

                </div>

                   

            </div>

	                    <div class="card">
							<div class="card-body">
								<ul class="nav nav-tabs nav-success" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" data-bs-toggle="tab" href="#successhome" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='fadeIn animated bx bx-bar-chart-alt-2'></i>
												</div>
												<div class="tab-title">Category</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#successprofile" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='fadeIn animated bx bx-buildings'></i>
												</div>
												<div class="tab-title">SubCategory</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#successcontact" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='fadeIn animated bx bx-badge-check'></i>
												</div>
												<div class="tab-title">Task</div>
											</div>
										</a>
									</li>
								</ul>
								<div class="tab-content py-3">
									<div class="tab-pane fade show active" id="successhome" role="tabpanel">
										  
                                       <!-- Trigger Button for Modal -->
                                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                            Add Category
                                        </button>

                                        <!-- Category Table -->
                                       <table id="categoryTable" class="w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be dynamically populated here -->
                            </tbody>
                        </table>			
                                </div>
                        				<div class="tab-pane fade" id="successprofile" role="tabpanel">
										 
                            <!-- Trigger Button for Modal -->
                        <button type="button" id="addSubCategoryBtn" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#subcategoryModal">
                            Add Subcategory
                        </button>
                                    <!-- Subcategory Table -->
                                    <table  id="subcategoryTable" class="w-100">
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>SubCategory</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                        									</div>
									<div class="tab-pane fade" id="successcontact" role="tabpanel">
										    
                     <button type="button" id="addTaskBtn" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#taskModal">
                        Add Task
                    </button>

                                        <!-- Task Table -->
                                        <!-- Responsive Task Table -->
                                <div class="table-responsive"> <!-- Wrapper div for responsiveness -->
                                    <table class="table table-bordered mt-3 w-100" id="tasksTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Subcategory</th>
                                                <th>Task</th>
                                                <th>Hours</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be dynamically populated by DataTable -->
                                        </tbody>
                                    </table>
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

	  <div id="loader" style="display:none;">
    <div class="loader-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
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
	<script src="<?php echo $select2; ?>"></script>
	<script src="<?php echo $select2Custom;?>"></script>
	
	
	<script>
	  $('#addSubCategoryBtn').click(function() {
            resetFromAdd();
           

            });
              $('#addTaskBtn').click(function() {
            resetFromTaskAdd();
           

            });
            
   function resetFromAdd() {
    // Reset the form
    $('#subcategoryForm')[0].reset();

    // Remove validation classes
    $('#subcategoryForm').removeClass('was-validated').addClass('needs-validation');

    // Reset Select2 elements
    $('#categorySelect').val(null).trigger('change'); // Reset the value and update Select2

}

 function resetFromTaskAdd() {
    // Reset the form
    $('#taskFormAdd')[0].reset();

    // Remove validation classes
    $('#taskFormAdd').removeClass('was-validated').addClass('needs-validation');

    // Reset Select2 elements
    $('#categorySelectTask').val(null).trigger('change'); // Reset the value and update Select2
    $('#subcategorySelectTask').val(null).trigger('change'); // Reset the value and update Select2

}
	 
	
	 $( '#categorySelectTaskEdit' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#categorySelectTaskEdit' ).parent(),
    } );
    
	
	 $( '#subcategorySelectEdit' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#subcategorySelectEdit' ).parent(),
    } );
    
	
	     $( '#categorySelect' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#categorySelect' ).parent(),
    } );
    
      $( '#categorySelectTask' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#categorySelectTask' ).parent(),
    } );
    
    $( '#subcategorySelectTask' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#subcategorySelectTask' ).parent(),
    } );
	</script>

     <!-- Include the function.js -->

     
     <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>




	<script src="<?php echo $app; ?>"></script>

<script src="../assets/js/form-validation.js"></script>
</body>
</html>



<script>

// $(document).ready(function () {
//     fetchCategories();
//     // fetchSubcategories();



// });

$('#categoryModal').on('shown.bs.modal', function () {
    var form = document.getElementById("categoryForm");
    form.reset(); // Reset form fields
    form.classList.remove('was-validated'); // Remove validation classes
    // Optional: Clear all custom validation feedback (e.g., is-invalid)
    $(form).find('.form-control').removeClass('is-invalid');
});

$('#subcategoryModal').on('shown.bs.modal', function () {
    var form = document.getElementById("subcategoryForm");
    form.reset(); // Reset form fields
    form.classList.remove('was-validated'); // Remove validation classes
    // Optional: Clear all custom validation feedback (e.g., is-invalid)
    $(form).find('.form-control').removeClass('is-invalid');
});

// When modal opens, reset the form and validation classes
$('#taskModal').on('shown.bs.modal', function () {
    var form = document.getElementById("taskFormAdd");
    form.reset(); // Reset form fields
    form.classList.remove('was-validated'); // Remove validation classes
    // Optional: Clear all custom validation feedback (e.g., is-invalid)
    $(form).find('.form-control').removeClass('is-invalid');
});

$('#subcategoryForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission
    
    var form = document.getElementById('subcategoryForm');
    var submitButton = $(this).find('button[type="submit"]');
    
    // Disable the submit button to prevent multiple clicks
    submitButton.prop('disabled', true);

    // Clear any previous error classes
    form.classList.remove('was-validated');
    
    // Validate the form manually
    if (form.checkValidity() === false) {
        e.stopPropagation(); // Stop the form submission if invalid
        // Enable the submit button again if validation fails
        submitButton.prop('disabled', false);
    } else {
        // If valid, send the data via AJAX
        const categoryId = $('#categorySelect').val();
        const subcategoryName = $('#subcategoryName').val();

        $.ajax({
            url: 'action/actDailyReport.php',  // Change to your correct PHP file path
            type: 'POST',
            data: {
                action: 'addSubcategory',
                categoryId: categoryId,
                subcategoryName: subcategoryName
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Subcategory Added',
                        text: response.message,
                        timer: 1000
                    });

                    // Optionally reset the form and hide validation feedback
                    form.reset(); // Reset the form
                    form.classList.remove('was-validated'); // Remove validation feedback
                    $('#subcategoryTable').DataTable().ajax.reload(null, false);
                    $('#subcategoryModal').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again later.'
                });
            },
            complete: function() {
                // Enable the submit button again after the AJAX request completes (success or error)
                submitButton.prop('disabled', false);
            }
        });
    }

    // Add Bootstrap validation classes to show feedback
    this.classList.add('was-validated');
});

</script>



        <script>

  
$(document).ready(function() {
    
    

    // Load subcategories when a category is selected
    $('#category').on('change', function() {
        let categoryId = $(this).val();
        $('#subcategory').empty().append('<option value="">--Select Subcategory--</option>');
        $('#task').empty().append('<option value="">--Select Task--</option>'); // Reset task dropdown

        if (categoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_category_id: categoryId },
                success: function(response) {
                    let subcategories = response.subcategories;
                    $.each(subcategories, function(index, subcategory) {
                        $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
                    });
                }
            });
        }
    });


    // Load subcategories when a category is selected
    $('#categorySelectTask').on('change', function() {
        let categoryId = $(this).val();
        $('#subcategorySelectTask').empty().append('<option value="">--Select Subcategory--</option>');
        

        if (categoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_category_id: categoryId },
                success: function(response) {
                    let subcategories = response.subcategories;
                    $.each(subcategories, function(index, subcategory) {
                        $('#subcategorySelectTask').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
                    });
                }
            });
        }
    });

    // Load tasks when a subcategory is selected
    $('#subcategory').on('change', function() {
        let subcategoryId = $(this).val();
        $('#task').empty().append('<option value="">--Select Task--</option>');

        if (subcategoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_subcategory_id: subcategoryId },
                success: function(response) {
                    let tasks = response.tasks;
                    $.each(tasks, function(index, task) {
                        $('#task').append('<option value="' + task.id + '">' + task.task + '</option>');
                    });
                }
            });
        }
    });
    
    
      // Load subcategories when a category is selected
    $('#report_category').on('change', function() {
        let categoryId = $(this).val();
        $('#report_subcategory').empty().append('<option value="">--Select Subcategory--</option>');
        $('#report_task').empty().append('<option value="">--Select Task--</option>'); // Reset task dropdown

        if (categoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_category_id: categoryId },
                success: function(response) {
                    let subcategories = response.subcategories;
                    $.each(subcategories, function(index, subcategory) {
                        $('#report_subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
                    });
                }
            });
        }
    });

    // Load tasks when a subcategory is selected
    $('#report_subcategory').on('change', function() {
        let subcategoryId = $(this).val();
        $('#report_task').empty().append('<option value="">--Select Task--</option>');

        if (subcategoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_subcategory_id: subcategoryId },
                success: function(response) {
                    let tasks = response.tasks;
                    $.each(tasks, function(index, task) {
                        $('#report_task').append('<option value="' + task.id + '">' + task.task + '</option>');
                    });
                }
            });
        }
    });
    
        // Load subcategories when a category is selected
    $('#editCategory').on('change', function() {
        let categoryId = $(this).val();
        $('#editSubcategory').empty().append('<option value="">--Select Subcategory--</option>');
        $('#editTask').empty().append('<option value="">--Select Task--</option>'); // Reset task dropdown

        if (categoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_category_id: categoryId },
                success: function(response) {
                    let subcategories = response.subcategories;
                    $.each(subcategories, function(index, subcategory) {
                        $('#editSubcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
                    });
                }
            });
        }
    });
    
    
          // Load subcategories when a category is selected
    $('#categorySelectTaskEdit').on('change', function() {
        let categoryId = $(this).val();
        $('#subcategorySelectTaskEdit').empty().append('<option value="">--Select Subcategory--</option>');
        

        if (categoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_category_id: categoryId },
                success: function(response) {
                    let subcategories = response.subcategories;
                    $.each(subcategories, function(index, subcategory) {
                        $('#subcategorySelectTaskEdit').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
                    });
                }
            });
        }
    });

    // Load tasks when a subcategory is selected
    $('#editSubcategory').on('change', function() {
        let subcategoryId = $(this).val();
        $('#editTask').empty().append('<option value="">--Select Task--</option>');

        if (subcategoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_subcategory_id: subcategoryId },
                success: function(response) {
                    let tasks = response.tasks;
                    $.each(tasks, function(index, task) {
                        $('#editTask').append('<option value="' + task.id + '">' + task.task + '</option>');
                    });
                }
            });
        }
    });
});


    
    
    
   
</script>

<script>

$('#subcategoryTable').DataTable({
    "ajax": {
        "url": 'action/actDailyReport.php',
        "type": 'POST',
        "data": { "action": "getSubcategories" },
        "dataSrc": "subcategories"
    },
 "columns": [
        {
            "data": null, 
            "render": function (data, type, row, meta) {
                // Serial number: using `meta.row + 1` to get the index for current page
                return meta.row + 1 + meta.settings._iDisplayStart;
            },
            "title": "S.No." // Column title for the S.No. column
        },
        { "data": "category", "title": "Category" },
        { "data": "subcategory", "title": "Subcategory" },
        { 
            "data": null, 
            "render": function (data, type, row) {
                // Edit button with onclick event that calls the editSubcategory function
                return `
                    <button class="btn btn-primary btn-sm edit-btn" onclick="editSubcategory(${row.id})">Edit</button>
                `;
            },
            "title": "Actions" // Column title for Actions
        }
    ],
    "destroy": true  // This allows reinitialization
});
// Fetch Subcategories
// Fetch Subcategories for the Subcategory Table
// function fetchSubcategories() {
//     $.ajax({
//         url: 'action/actDailyReport.php', // PHP file to fetch subcategories
//         type: 'POST',
//         data: { action: 'getSubcategories' },  // Request to get subcategories
//         dataType: 'json',
//         success: function(response) {
//             $('#subcategoryTable tbody').empty();  // Clear any previous data

//             if (response.subcategories && Array.isArray(response.subcategories)) {
//                 $.each(response.subcategories, function(index, subcategory) {
//                     var row = `
//                         <tr data-id="${subcategory.id}">
//                             <td>${index + 1}</td>
//                             <td>${subcategory.category}</td>
//                             <td>
//                                 <span class="subcategory-text">${subcategory.subcategory}</span>
//                                 <input type="text" class="form-control subcategory-input" value="${subcategory.subcategory}" style="display: none;">
//                             </td>
//                             <td>
//                                 <button class="btn btn-primary btn-sm" onclick="editSubcategory(${subcategory.id})">Edit</button>
//                             </td>
//                         </tr>
//                     `;
//                     $('#subcategoryTable tbody').append(row);
//                 });
//             } else {
//                 console.error("Invalid response format:", response);
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error("Error fetching subcategories:", error);
//         }
//     });
// }



$('#categoryTable').DataTable({
    "ajax": {
        "url": 'action/actDailyReport.php',
        "type": 'POST',
        "data": { "category_table": "getCategory" },
        "dataSrc": "categories"
    },
    columns: [
        { 
            "data": null, 
            "render": function (data, type, row, meta) {
                return meta.row + 1; // Sequential index for current page
            },
            "title": "S.No."
        },
        { "data": "category", "title": "Category" },
        { 
            "data": null, 
            "render": function (data, type, row) {
                return `
                    <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}" data-category="${row.category}">Edit</button>
                `;
            },
            "title": "Actions"
        }
    ],
    "rowCallback": function(row, data, index) {
        var pageInfo = this.api().page.info(); // Get page info
        $('td:first', row).html(pageInfo.start + index + 1); // S.No. across pages
    },
    "destroy": true  // This allows reinitialization
});


 // Open modal and populate with data when "Edit" button is clicked
    $('#categoryTable').on('click', '.edit-btn', function () {
        let categoryId = $(this).data('id');
        let categoryName = $(this).data('category');

        // Set values in the modal
        $('#editCategoryId').val(categoryId);
        $('#editCategoryName').val(categoryName);

        // Show the modal
        $('#editModal').modal('show');
    });
    
    
   // Handle the save changes button click
$('#saveEditBtn').click(function () {
    // Validate form input
    let categoryName = $('#editCategoryName').val().trim();
    if (categoryName === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Validation Error',
            text: 'Category name cannot be empty'
        });
        return; // Exit if validation fails
    }

    // Disable the button to prevent double-click
    $('#saveEditBtn').prop('disabled', true);

    // Prepare form data
    let formData = {
        id: $('#editCategoryId').val(),
        category: categoryName
    };

    // Send AJAX request to update data
    $.ajax({
        url: 'action/actDailyReport.php',
        type: 'POST',
        data: {
            action: 'updateCategory',
            ...formData
        },
        success: function (response) {
            // Hide the modal
            $('#editModal').modal('hide');

            // Reload DataTable to reflect changes
            $('#categoryTable').DataTable().ajax.reload(null, false);

            // Show success alert
            Swal.fire({
                icon: 'success',
                title: 'Category Updated',
                text: response.message,
                timer: 1000
            });
        },
        error: function (xhr, status, error) {
            console.error("Error updating category:", error);

            // Show error alert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating the category.'
            });
        },
        complete: function () {
            // Re-enable the button after request completion
            $('#saveEditBtn').prop('disabled', false);
        }
    });
});





  // Function to fetch categories
    function fetchCategories() {
        $.ajax({
            url: 'action/actDailyReport.php',  // PHP file to fetch categories
            type: 'POST',
            data: { "category": "getCategory" },  // Sending the request to fetch categories
            dataType: 'json', // Ensure JSON dataType
            success: function(response) {
                console.log("Response:", response);  // Log the response for debugging

                let category = response.categories;

                // Clear previous data (if any)
                $('#categorySelect, #categorySelectTask, #subcategorySelectEdit, #categorySelectTaskEdit').empty();
                 // Add a default "Select" option to the dropdowns
            $('#categorySelect').append('<option value="">Select Category</option>');
            $('#categorySelectTask').append('<option value="">Select Category</option>');
            $('#subcategorySelectEdit').append('<option value="">Select Category</option>');
            $('#categorySelectTaskEdit').append('<option value="">Select Category</option>');

                // Check if the response is valid
                if (category && Array.isArray(category)) {
                    // Populate the category dropdowns
                    $.each(category, function(index, category) {
                        $('#categorySelect').append('<option value="' + category.id + '">' + category.category + '</option>');
                        $('#categorySelectTask').append('<option value="' + category.id + '">' + category.category + '</option>');
                        $('#subcategorySelectEdit').append('<option value="' + category.id + '">' + category.category + '</option>');
                        $('#categorySelectTaskEdit').append('<option value="' + category.id + '">' + category.category + '</option>');
                    });
                } else {
                    console.error("Invalid response format:", response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching categories:", error);
                console.log("Response Text:", xhr.responseText);  // Log response text for debugging
            }
        });
    }




function addCategory() {
    // Get the form element
    var form = document.getElementById('categoryForm');
    
    // Check if the form is valid using Bootstrap's built-in validation
    if (form.checkValidity() === false) {
        // If form is invalid, add the 'was-validated' class to show validation feedback
        form.classList.add('was-validated');
        return; // Stop form submission
    }
    
    // If form is valid, collect form data and submit via AJAX
    var formData = new FormData(form);
    
    // Show a loader or indication if needed
    $('#loader').show(); // If you have a loader
    
    // Make the AJAX request to submit the form data
    $.ajax({
        url: 'action/actDailyReport.php', // Replace with your actual endpoint
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(response) {
            $('#loader').hide(); // Hide the loader on success
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Category Added',
                    text: response.message,
                    timer: 1000
                });
                
                form.reset(); // Reset the form
                form.classList.remove('was-validated'); // Reset the validation feedback
                 // Refresh the categories in the table
                  $('#categoryTable').DataTable().ajax.reload(null, false);
                    // Hide the modal
                    $('#categoryModal').modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(error) {
            $('#loader').hide(); // Hide the loader on error
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        }
    });
}



function editSubcategory(id) {
    // Send AJAX request to fetch data based on the provided `id`
    $.ajax({
        url: 'action/actDailyReport.php', // Replace with your actual endpoint
        type: 'GET',
        data: { edit_id: id },
        dataType: 'json',  // Expecting a JSON response
        success: function(response) {
            if (response && response.id) {  // Check if response contains expected data
                // Set the values in the modal fields
                $('#editSubId').val(response.id);
                $('#subcategorySelectEdit').val(response.category_id);
                $('#subcategoryEdit').val(response.subcategory);

                // Initialize and show the modal
                const modal = new bootstrap.Modal(document.getElementById('editReportModal'));
                modal.show();
            } else {
                alert("Failed to retrieve subcategory data. Please check the ID or try again.");
            }
        },
        error: function(error) {
            console.error("Error fetching data: ", error);
            alert("Failed to fetch subcategory data.");
        }
    });
}

  $('#editSubcategoryForm').on('submit', function (event) {
        event.preventDefault();  // Prevent the form from submitting the traditional way

        // Check HTML5 form validation
        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        // Disable the submit button to prevent double-clicks
        const submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true);

        // Create a FormData object with the form data
        var formData = new FormData(this);

        $.ajax({
            url: 'action/actDailyReport.php',  // Replace with your actual update endpoint
            type: 'POST',
            data: formData,
            processData: false,  // Prevent jQuery from processing the data
            contentType: false,  // Prevent jQuery from setting the content type
            success: function (response) {
                if (response.success) {  // Assuming the response includes a success property
                    Swal.fire({
                        icon: 'success',
                        title: 'Subcategory Updated',
                        text: response.message,
                        timer: 1000
                    });
                    $('#editReportModal').modal('hide'); 
                    $('#subcategoryTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (error) {
                console.error('Error updating subcategory:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred',
                    text: 'Failed to update the subcategory.'
                });
            },
            complete: function () {
                // Re-enable the submit button after the request completes
                submitButton.prop('disabled', false);
            }
        });
    });


// Declare the table variable globally
var table;

$(document).ready(function () {
    
  
    var table = $('#tasksTable').DataTable({
        ajax: {
            url: 'action/actDailyReport.php', // Your endpoint to fetch task data
            type: 'POST',
            data: { action: 'getTasks' }, // Action parameter to specify fetching tasks
            dataSrc: 'tasks', // The data array in the JSON response
            error: function(xhr, error, thrown) {
                // Handle AJAX errors (e.g., network issues, server errors)
                console.log('Error fetching data:', error);
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    // Serial number logic: current row index + starting index of the current page
                    return meta.row + 1 + meta.settings._iDisplayStart;
                },
                title: "S.No."  // Title for the serial number column
            },
            { data: 'category', title: "Category" },
            { data: 'subcategory', title: "Subcategory" },
            { data: 'task', title: "Task" },
            { data: 'hours', title: "Hours" },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm" onclick="editTask(${row.task_id})">Edit</button>
                    `;
                },
                title: "Action" // Title for the Actions column
            }
        ],
        
        destroy: true // Ensure DataTable can be reinitialized
    });
});

// Refresh the DataTable after a successful task submission
function refreshTable() {
    // Ensure the table is defined before calling reload
    if (table) {
        table.ajax.reload(null, false); // Reloads without resetting pagination
    } else {
        console.error('Table is not defined');
    }
}

// Handle form submission
$('#taskFormAdd').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    var form = document.getElementById('taskFormAdd');
    var submitButton = $(this).find('button[type="button"]');
    
    // Disable the submit button to prevent multiple clicks
    submitButton.prop('disabled', true);

    // Clear previous validation
    form.classList.remove('was-validated');

    // Validate the form manually
    if (form.checkValidity() === false) {
        e.stopPropagation(); // Stop the form submission if invalid
        // Re-enable submit button if validation fails
        submitButton.prop('disabled', false);
    } else {
        // If form is valid, send data via AJAX
        const categoryId = $('#categorySelectTask').val();
        const subcategoryId = $('#subcategorySelectTask').val();
        const taskName = $('#taskName').val();
        const hours = $('#hours').val();

        $.ajax({
            url: 'action/actDailyReport.php',  // Your PHP file path
            type: 'POST',
            data: {
                action: 'addTaskFrom',
                categoryId: categoryId,
                subcategoryId: subcategoryId,
                taskName: taskName,
                hours: hours
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Task Added',
                        text: response.message,
                        timer: 1000
                    });

                    // Reset the form and hide modal on success
                    form.reset(); // Reset form fields
                    form.classList.remove('was-validated'); // Remove validation feedback
                    $('#taskModal').modal('hide'); // Close modal
                    // Optionally, refresh the task list or table
                    // Reload or refresh task list
                    refreshTable()
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'An error occurred. Please try again.'
                });
            },
            complete: function() {
                // Re-enable submit button after AJAX request completes
                submitButton.prop('disabled', false);
            }
        });
    }

    // Add Bootstrap validation classes to show feedback
    this.classList.add('was-validated');
});


// Load subcategories based on the selected category
function loadSubcategories(categoryId, selectedSubcategoryId = null) {
    $.ajax({
        url: 'action/actDailyReport.php', // Endpoint to fetch subcategories based on category
        type: 'POST',
        dataType: 'json',  // Expecting a JSON response
        data: { action: 'getSubcategories_task', category_id: categoryId }, // Pass category ID
        success: function(response) {
            if (response && response.length > 0) {
                // Populate the subcategory dropdown
                $.each(response, function(index, subcategory) {
                    const selected = subcategory.id == selectedSubcategoryId ? 'selected' : '';
                    $('#subcategorySelectTaskEdit').append(`<option value="${subcategory.id}" ${selected}>${subcategory.subcategory}</option>`);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No subcategories found for the selected category.'
                });
            }
        },
        error: function(error) {
            console.error("Error fetching subcategories:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching subcategories.'
            });
        }
    });
}


// Function to handle editing the task
function editTask(taskId) {
    $.ajax({
        url: 'action/actDailyReport.php', // Endpoint to fetch task details
        type: 'POST',
        dataType: 'json',  // Expecting a JSON response
        data: { action: 'getTaskDetails', task_id_edit: taskId }, // Pass task ID to get details
        success: function(response) {
            // Ensure the response has the expected properties
            if (response) {
               $('#categorySelectTaskEdit').val(response.category_id); // Set category
               $('#editTask_id').val(response.id); // Set category
                $('#subcategorySelectTaskEdit').empty(); // Clear the current subcategory options

                // Load subcategories based on the selected category
                loadSubcategories(response.category_id, response.subcategory_id);

                // Set other task details
                $('#taskNameEdit').val(response.task); // Set task name
                $('#hoursEdit').val(response.hours); // Set hours
                
                // Show the modal
                $('#taskFormModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No task details found.'
                });
            }
        },
        error: function(error) {
            console.error("Error fetching task details:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching task details.'
            });
        }
    });
}



// Function to handle task update
function updateTask() {
    // Disable the update button to avoid double submission
    $('#updateTaskButton').prop('disabled', true).text('Updating...'); // Assuming button has id 'updateTaskButton'

    // Get form data
    var formData = new FormData(document.getElementById('taskForm'));

    // Perform form validation
    if (document.getElementById("taskForm").checkValidity()) {
        $.ajax({
            url: 'action/actDailyReport.php', // Endpoint to update task
            type: 'POST',
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Task Updated',
                        text: response.message,
                        timer: 1500
                    });

                    // Close the modal
                    $('#taskFormModal').modal('hide');

                    // Refresh the table
                    $('#tasksTable').DataTable().ajax.reload(null, false); // Reload without resetting pagination
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to update task'
                    });
                }
                // Re-enable the button after the request is complete
                $('#updateTaskButton').prop('disabled', false).text('Update Task');
            },
            error: function(error) {
                console.error("Error updating task:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the task.'
                });
                // Re-enable the button after the request is complete
                $('#updateTaskButton').prop('disabled', false).text('Update Task');
            }
        });
    } else {
        // If the form is not valid, re-enable the button
        $('#updateTaskButton').prop('disabled', false).text('Update Task');
        document.getElementById("taskForm").classList.add('was-validated');
        Swal.fire({
            icon: 'warning',
            title: 'Validation Failed',
            text: 'Please fill in all required fields before submitting.'
        });
    }
}


document.addEventListener('DOMContentLoaded', function () {
    // Add event listener for tab change
    const tabs = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');

    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            // Get the ID of the active tab
            const activeTabId = event.target.getAttribute('href').replace('#', '');
            // Call a function based on the active tab
            handleTabChange(activeTabId);
        });
    });

    // Function to handle tab changes
    function handleTabChange(tabId) {
        switch (tabId) {
            case 'successhome':
                fetchCategories(); // Fetch categories when "Category" tab is active
                console.log('Category Tab Active');
                break;
            case 'successprofile':
                fetchCategories(); // Fetch subcategories when "SubCategory" tab is active
                console.log('SubCategory Tab Active');
                break;
            case 'successcontact':
                fetchCategories(); // Fetch tasks when "Task" tab is active
                console.log('Task Tab Active');
                break;
            default:
                console.log('Unknown Tab');
        }
    }

   
});





</script>

