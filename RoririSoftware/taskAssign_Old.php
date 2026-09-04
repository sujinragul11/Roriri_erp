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

        <?php include("assignTaskForm.php");?>

		

		<div class="page-wrapper">
		    
	

			<div class="page-content">

                

				

            <div class="page-title-box">

                

                <div class="page-title-right">

                    <h2 class="page-title">Task Assign</h2>

                    <div class="position-relative mb-2" style="height: 40px;"> <!-- Adjust height as needed -->
                   

                    <button type="button" id="addEnquireBtn" class="btn btn-primary position-absolute top-0 end-0 " data-bs-toggle="modal" data-bs-target="#addReportModal"><i class="lni lni-plus"></i>New </button>
                
            
            
                    </div>



                </div>

                   

            </div>



				<div class="card">

					<div class="card-body">

						<div class="table-responsive">
						    
						  
                        <!--<select id="recordsPerPage" class="form-control" style="display: inline-block; width: auto;">-->
                        <!--    <option value="10">10</option>-->
                        <!--    <option value="20">20</option>-->
                        <!--    <option value="50">50</option>-->
                        <!--    <option value="-1">All</option> <!-- Display all records -->
                        <!--</select>-->
						    <!-- Filter Form -->
              <form id="filterForm">
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="startDate">From:</label>
            <input type="date" id="startDate" class="form-control" placeholder="Start Date">
            <span id="startDateError" class="text-danger"></span>
        </div>
        <div class="col-md-3">
            <label for="endDate">To:</label>
            <input type="date" id="endDate" class="form-control" placeholder="End Date">
            <span id="endDateError" class="text-danger"></span>
        </div>
        <div class="col-md-3">
            <label for="report_category">Category:</label>
            <select id="report_category" class="form-control">
                <option value="">-- Select Category --</option>
                <option value="Event">Event</option>
                <option value="Meeting">Meeting</option>
                <option value="Games">Games</option>
              
            </select>
        </div>
        <div class="col-md-3">
            <label for="report_subcategory">Subcategory:</label>
            <select id="report_subcategory" class="form-control">
                <option value="">-- Select Subcategory --</option>
                <option value="Intership">Intership</option>
                <option value="Mega Job Fair">Mega Job Fair</option>
                <option value="Blueprint">Blueprint</option>
            </select>
        </div>
        
        <div class="col-md-3">
            <label for="report_employee">Employee :</label>
            <select id="report_employee" class="form-control">
                <option value="">-- Select --</option>
                <option value="1">Vasanth</option>
                <option value="2">Rajkumar</option>
                <option value="3">Sriram</option>
                <option value="4">Noble</option>
            </select>
        </div>
        
        <div class="col-md-3">
            <label for="report_status">Status :</label>
            <select id="report_status" class="form-control">
                <option value="">-- Select --</option>
                <option value="Upcoming">Upcoming</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        
       
        <div class="col-md-3 mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="lni lni-angle-double-down"></i> Filter
            </button>
        </div>
    </div>
</form>
                
               
                
                		<table id="example3" class="table table-striped table-bordered">

								<thead>

									<tr>
                                    <th >S. No</th>
                                    <th >Date</th>
                                    <th >Name</th>
                                    <th >Categoty</th>
                                    <th >Sub Categoty</th>
                                    <th >Task</th>
                                    
                                    <th >Hours</th>
                                    <th >Status</th>
                                    <th >Action</th>
                                </tr>

								</thead>
								<tfoot>
        <tr>
            <th colspan="6" style="text-align:right">Total Hours:</th>
            <th id="totalHours">0</th>
            <th colspan="2"></th> <!-- Empty space for the last columns -->
        </tr>
    </tfoot>

								  <tbody>
       
        <tr>
            <td>1</td>
            <td>02-Nov-2024</td>
            <td>rajkumar </td>
            <td>Project</td>
            <td>ERP</td>
            <td>Cretae Employe work update page  </td>
            <td>2</td>
            <td>Upcoming</td>
            <td> <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewCandiaadate();">
                                <i class="lni lni-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" id="editSaveCandidate" onclick="goEditClient();" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                <i class="lni lni-pencil"></i>
                            </button></td>
            <tr>
                
                <tr>
            <td>2</td>
            <td>02-Nov-2024</td>
            <td>vasanth </td>
            <td>Event</td>
            <td>Intership</td>
            <td>Cretae Employe work update page  </td>
            <td>2</td>
            <td>Upcoming</td>
            <td> <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewCandiaadate();">
                                <i class="lni lni-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" id="editSaveCandidate" onclick="goEditClient();" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                <i class="lni lni-pencil"></i>
                            </button></td>
            <tr>
                
                
                <tr>
            <td>3</td>
            <td>02-Nov-2024</td>
            <td>Noble </td>
            <td>Event</td>
            <td>Intership</td>
            <td>Cretae user page </td>
            <td>2</td>
            <td>Upcoming</td>
            <td> <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewCandiaadate();">
                                <i class="lni lni-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" id="editSaveCandidate" onclick="goEditClient();" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                <i class="lni lni-pencil"></i>
                            </button></td>
            <tr>
                
                
                <tr>
            <td>4</td>
            <td>02-Nov-2024</td>
            <td>Sriram</td>
            <td>Event</td>
            <td>Intership</td>
            <td>HR Meeting For Intership Students</td>
            <td>2</td>
            <td>Upcoming</td>
            <td> <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewCandiaadate();">
                                <i class="lni lni-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" id="editSaveCandidate" onclick="goEditClient();" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                <i class="lni lni-pencil"></i>
                            </button></td>
            <tr>
                
                
                <tr>
            <td>5</td>
            <td>02-Nov-2024</td>
            <td>vasanth </td>
            <td>Event</td>
            <td>Intership</td>
            <td>HR Meeting For Employee</td>
            
            <td>2</td>
            <td>Upcoming</td>
            <td> <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewCandiaadate();">
                                <i class="lni lni-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" id="editSaveCandidate" onclick="goEditClient();" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                <i class="lni lni-pencil"></i>
                            </button></td>
            <tr>
           
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

     <!-- Include the function.js -->

     <script src="../assets/js/function.js"></script>
     <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

     <!-- Initialize tooltips -->
     <script>
    // Set a variable to determine if the user is an admin or super admin
    var isAdminOrSuperAdmin = <?php echo ($_SESSION['role'] === '16' || $_SESSION['is_admin'] === 'True') ? 'true' : 'false'; ?>;
    var userId = "<?php echo $_SESSION['id']; ?>"; // User's session ID
</script>

<script>
   // Initialize Quill editor
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['link', 'blockquote', 'code-block', 'image'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['clean']
        ]
    }
});
$(document).ready(function() {
    
      $('#example3').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        "pageLength": 10,
    "lengthMenu": [10, 20, 50, -1],
    "order": [[1, 'desc']],
    "dom": 'Bfrtip',
    "buttons": [
        {
            extend: 'excelHtml5',
            text: 'Excel',
            title: 'Report'
        },
        {
            extend: 'print',
            text: 'Report',
            title: 'Report'
        }
    ]
        // Add more options if necessary
    });
    
//     var reportTable = $('#example3').DataTable({
//     "processing": true,
//     "serverSide": true,
//     "ajax": {
//         "url": "action/actDailyReport.php",
//         "type": "POST",
//         "data": function(d) {
//             d.getData = "GetTable";
//             d.startDate = $('#startDate').val();
//             d.endDate = $('#endDate').val();
//             d.category = $('#report_category').val();
//             d.subcategory = $('#report_subcategory').val();
//             d.task = $('#report_task').val();

//             // If user is admin or super admin, allow filtering by selected name.
//             // Otherwise, set empName to the current user's ID to limit results.
//             d.empName = isAdminOrSuperAdmin ? $('#empName').val() : userId;
//         }
//     },
//     "columns": [
//         { data: "sid" },
//         { data: "desription", visible: false },
//         { data: "image", visible: false },
//         { data: "url", visible: false },
//         { data: "date" },
//         { 
//             data: "name", 
//             visible: isAdminOrSuperAdmin // Show name column only for admins
//         },
//         { data: "category" },
//         { data: "subcategory" },
//         { data: "task" },
//         { data: "hours" },
//         { data: "task_status" },
//         { data: "action" }
       
//     ],
//     "footerCallback": function(row, data, start, end, display) {
//     var totalHours = 0;

//     // Loop through each row in the data and add the hours
//     for (var i = start; i < end; i++) {
//         var hours = data[i].hours;
        
//         // Check if the value contains a decimal point and process it
//         if (hours) {
//             var parts = hours.split('.'); // Split the string into hours and minutes
//             var hourPart = parseInt(parts[0], 10); // Get the whole hour part
//             var minutePart = parseInt(parts[1] || 0, 10); // Get the minute part, default to 0 if not available

//             // Convert the minute part to a decimal fraction of the hour
//             var decimalHours = hourPart + (minutePart / 60);
            
//             totalHours += decimalHours; // Add to total
//         }
//     }

//     // Update the footer with the total hours
//     $('#totalHours').text(totalHours.toFixed(2)); // Show total with 2 decimal places
// },
//     "pageLength": 10,
//     "lengthMenu": [10, 20, 50, -1],
//     "order": [[1, 'desc']],
//     "dom": 'Bfrtip',
//     "buttons": [
//         {
//             extend: 'excelHtml5',
//             text: 'Excel',
//             title: 'Report'
//         },
//         {
//             extend: 'print',
//             text: 'Report',
//             title: 'Report'
//         }
//     ]
// });

    // Handle filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        reportTable.ajax.reload(); // Reload the table with filter values
    });

    // Optional: Handle filter button click
    $('#filterBtn').click(function() {
        reportTable.ajax.reload();
    });
    
    
    document.getElementById('addDepartment').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    var form = this;
    var descriptionContent = document.getElementById('description');

    // Update hidden textarea with Quill editor content
    descriptionContent.value = quill.root.innerHTML.trim();

    // Perform validation check (description is optional)
    if (!form.checkValidity()) {
        event.stopPropagation();
        form.classList.add('was-validated'); // Add Bootstrap validation styling
        return;
    }
var formData = new FormData(form);

// Show the loader before sending the request
$('#loader').show();

$.ajax({
    url: 'action/actDailyReport.php',
    type: 'POST',
    data: formData,
    dataType: 'json', // Specify the expected data type as JSON
    processData: false, // Prevent jQuery from processing the data
    contentType: false, // Allow the content type to be set automatically (multipart/form-data)
    success: function (response) {
        // Hide the loader when the request completes
        $('#loader').hide();

        if (response.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
                timer: 1000
            }).then(function() {
                $('#addReportModal').modal('hide'); // Close the modal
                $('.modal-backdrop').remove(); // Remove the backdrop

                // Reload the DataTable to display the new data
                    reportTable.ajax.reload(null, false); // `null, false` to retain the current page
                    
            });
            
            form.reset();
            quill.root.innerHTML = ''; // Clear Quill editor content
            form.classList.remove('was-validated'); // Reset validation styling
        } else {
            // Hide the loader if there's an error
            $('#loader').hide();
            // Show error message from response
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message
            });
        }
    },
    error: function (error) {
        // Hide the loader if there's an error
        $('#loader').hide();
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
    }
});
});


// Submit the form with the data including existing and new images
$('#editDepartment').submit(function(event) {
    event.preventDefault(); // Prevent normal form submission
    
    // Set the content of the hidden textarea to the Quill editor content
    $('#descriptionEdit').val(quillEdit.root.innerHTML);

    // Check form validity (description is optional)
    if (!this.checkValidity()) {
        $(this).addClass('was-validated');
        return; // Stop the submission
    }
    
    var formData = new FormData(this); // Create FormData object

    // Append the existing images to the FormData
    formData.append('existingImages', existingImages.join(',')); // Combine old images into a string

    // Show a loader while the request is in progress
    $('#loader').show();

    // Send the form data via AJAX
    $.ajax({
        url: 'action/actDailyReport.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,  // Do not process data (needed for file upload)
        contentType: false,  // Do not set content type (needed for file upload)
        success: function(response) {
            // Hide the loader when the request completes
            $('#loader').hide();

            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 1000
                }).then(function() {
                    $('#editReportModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop

                    // Reload the DataTable to display the new data
                    reportTable.ajax.reload(null, false); // `null, false` to retain the current page
                });
                
                // Reset the form and clear Quill editor content
                $('#editDepartment')[0].reset();
                quillEdit.root.innerHTML = ''; // Clear Quill editor content
                $('#editDepartment').removeClass('was-validated'); // Reset validation styling
            } else {
                // Show error message from response
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
            console.error('Response:', xhr.responseText);  // Log response
        }
    });
});

    
});

$(document).ready(function() {
    // Assign PHP variable to JavaScript variable outside of the function
var baseUrl = "<?php echo $dailyReportImageView; ?>";

// Trigger modal with task details when a row is clicked
$('#example3 tbody').on('click', '.view-btn', function() {
    var row = $(this).closest('tr');
    var data = $('#example3').DataTable().row(row).data();
    
    // Populate modal with data from the clicked row
    $('#taskName').text(data.name);
    $('#taskCategory').text(data.category);
    $('#taskSubcategory').text(data.subcategory);
    $('#taskTask').text(data.task);
    $('#taskUrl').text(data.url);
    $('#taskDescription').html(data.desription);
    $('#taskHours').text(data.hours);

    // Check if there are images
    if (data.image) {
        var imageUrls = data.image.split(','); // Split the string into an array

        if (imageUrls.length > 0) {
            // Clear any previous images
            $('#taskImagesContainer').empty();

            // Loop through the image URLs and append each to the container
            imageUrls.forEach(function(imageUrl) {
                // Create an anchor tag for the image
                var imgLink = $('<a>')
                    .attr('href', baseUrl + imageUrl)
                    .attr('target', '_blank'); // Open in new tab

                // Create the image element with a fixed size and add to the link
                var imgElement = $('<img>')
                    .attr('src', baseUrl + imageUrl)
                    .addClass('task-image')
                    .css({
                        width: '100px',  // Set the width
                        height: '100px', // Set the height
                        marginRight: '10px',
                        objectFit: 'cover' // Ensure image fits within the size
                    });

                // Append the image element to the link, then to the container
                imgLink.append(imgElement);
                $('#taskImagesContainer').append(imgLink);
            });

            // Show the container
            $('#taskImagesContainer').show();
        } else {
            // Hide the container if no images
            $('#taskImagesContainer').hide();
        }
    } else {
        // Hide the container if there's no 'data.image'
        $('#taskImagesContainer').hide();
    }

    // Show the modal
    $('#viewModal').modal('show');
});
});
</script>

        <script>
        
  
$(document).ready(function() {
    // Load categories dynamically on page load
    $.ajax({
        url: 'action/actDailyReport.php',
        method: 'POST',
        dataType: 'json', // Ensure JSON dataType
        data: {category :"getGategory"},
        success: function(response) {
            let categories = response.categories;
            $.each(categories, function(index, category) {
                $('#category').append('<option value="' + category.id + '">' + category.category + '</option>');
            });
        }
    });

    // Load subcategories when a category is selected
//     $('#category').on('change', function() {
//         let categoryId = $(this).val();
//         $('#subcategory').empty().append('<option value="">--Select Subcategory--</option>');
//         $('#task').empty().append('<option value="">--Select Task--</option>'); // Reset task dropdown

//         if (categoryId) {
//             $.ajax({
//                 url: 'action/actDailyReport.php',
//                 method: 'POST',
//                 dataType: 'json', // Ensure JSON dataType
//                 data: { get_category_id: categoryId },
//                 success: function(response) {
//                     let subcategories = response.subcategories;
//                     $.each(subcategories, function(index, subcategory) {
//                         $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
//                     });
//                 }
//             });
//         }
//     });

//     // Load tasks when a subcategory is selected
//     $('#subcategory').on('change', function() {
//         let subcategoryId = $(this).val();
//         $('#task').empty().append('<option value="">--Select Task--</option>');

//         if (subcategoryId) {
//             $.ajax({
//                 url: 'action/actDailyReport.php',
//                 method: 'POST',
//                 dataType: 'json', // Ensure JSON dataType
//                 data: { get_subcategory_id: subcategoryId },
//                 success: function(response) {
//                     let tasks = response.tasks;
//                     $.each(tasks, function(index, task) {
//                         $('#task').append('<option value="' + task.id + '">' + task.task + '</option>');
//                     });
//                 }
//             });
//         }
//     });
    
    
//       // Load subcategories when a category is selected
//     $('#report_category').on('change', function() {
//         let categoryId = $(this).val();
//         $('#report_subcategory').empty().append('<option value="">--Select Subcategory--</option>');
//         $('#report_task').empty().append('<option value="">--Select Task--</option>'); // Reset task dropdown

//         if (categoryId) {
//             $.ajax({
//                 url: 'action/actDailyReport.php',
//                 method: 'POST',
//                 dataType: 'json', // Ensure JSON dataType
//                 data: { get_category_id: categoryId },
//                 success: function(response) {
//                     let subcategories = response.subcategories;
//                     $.each(subcategories, function(index, subcategory) {
//                         $('#report_subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
//                     });
//                 }
//             });
//         }
//     });

//     // Load tasks when a subcategory is selected
//     $('#report_subcategory').on('change', function() {
//         let subcategoryId = $(this).val();
//         $('#report_task').empty().append('<option value="">--Select Task--</option>');

//         if (subcategoryId) {
//             $.ajax({
//                 url: 'action/actDailyReport.php',
//                 method: 'POST',
//                 dataType: 'json', // Ensure JSON dataType
//                 data: { get_subcategory_id: subcategoryId },
//                 success: function(response) {
//                     let tasks = response.tasks;
//                     $.each(tasks, function(index, task) {
//                         $('#report_task').append('<option value="' + task.id + '">' + task.task + '</option>');
//                     });
//                 }
//             });
//         }
//     });
    
//         // Load subcategories when a category is selected
//     $('#editCategory').on('change', function() {
//         let categoryId = $(this).val();
//         $('#editSubcategory').empty().append('<option value="">--Select Subcategory--</option>');
//         $('#editTask').empty().append('<option value="">--Select Task--</option>'); // Reset task dropdown

//         if (categoryId) {
//             $.ajax({
//                 url: 'action/actDailyReport.php',
//                 method: 'POST',
//                 dataType: 'json', // Ensure JSON dataType
//                 data: { get_category_id: categoryId },
//                 success: function(response) {
//                     let subcategories = response.subcategories;
//                     $.each(subcategories, function(index, subcategory) {
//                         $('#editSubcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
//                     });
//                 }
//             });
//         }
//     });

//     // Load tasks when a subcategory is selected
//     $('#editSubcategory').on('change', function() {
//         let subcategoryId = $(this).val();
//         $('#editTask').empty().append('<option value="">--Select Task--</option>');

//         if (subcategoryId) {
//             $.ajax({
//                 url: 'action/actDailyReport.php',
//                 method: 'POST',
//                 dataType: 'json', // Ensure JSON dataType
//                 data: { get_subcategory_id: subcategoryId },
//                 success: function(response) {
//                     let tasks = response.tasks;
//                     $.each(tasks, function(index, task) {
//                         $('#editTask').append('<option value="' + task.id + '">' + task.task + '</option>');
//                     });
//                 }
//             });
//         }
//     });
// });


    
    
     var quillEdit = new Quill('#editorEdit', {
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

  
    
   
</script>

     <script>
    $(document).ready(function() {
        // Set the enquiry date to today's date
        const today = new Date().toISOString().split("T")[0];
        $("#enquiryDate").attr("value", today);
    });
    


// Function to dynamically update date constraints
function updateDateConstraints() {
    var startDateInput = document.getElementById('startDate');
    var endDateInput = document.getElementById('endDate');

    // Set today's date as the max for the start date
    var today = new Date().toISOString().split('T')[0];
    startDateInput.setAttribute('max', today);

    // When a start date is selected, update the min attribute for the end date
    startDateInput.addEventListener('change', function () {
        var startDate = startDateInput.value;
        if (startDate) {
            // Set the min date for endDate to be the same as startDate
            endDateInput.setAttribute('min', startDate);
        } else {
            // If no start date is selected, reset the min attribute for endDate
            endDateInput.removeAttribute('min');
        }
    });

    // When an end date is selected, ensure it is not before the start date
    endDateInput.addEventListener('change', function () {
        var endDate = endDateInput.value;
        var startDate = startDateInput.value;
        if (startDate && endDate && endDate < startDate) {
            // Reset the end date if it is before the start date
            alert('End date cannot be before the start date.');
            endDateInput.value = '';
        }
    });
}

// Call the function to initialize the date constraints
updateDateConstraints();



     </script>

     <script>

        document.addEventListener('DOMContentLoaded', function () {

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {

                return new bootstrap.Tooltip(tooltipTriggerEl)

            })

        });

        

        function setMaxDate() {

            const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

            $('#enquiryDate').attr('max', today); 

            // $('#followUpDate').attr('max', today); 

        }

    

        function resetForm() {

            $('#addClient')[0].reset(); //

            $('#addClient').find(':input').removeClass('is-invalid is-valid'); 

        }

    

        $(document).ready(function() {

            setMaxDate(); 

    

            $('#addEnquireBtn').on('click', function() {

                resetForm(); 

            });

        });

    </script>

    <script>

    var existingImages = [];  // Declare globally before usage    

function goEditEnquire(id) 

  

  {



// AJAX call to fetch existing report data
$.ajax({
    url: 'action/actDailyReport.php',
    method: 'POST',
    data: { editIdReport: id },
    dataType: 'json',
    success: function(response) {
        // Populate other fields
        $('#editReportId').val(response.id);
        $('#ProjectNameEdit').val(response.project);
        $('#projectURLEdit').val(response.url);
        $('#projectStatusEdit').val(response.task_status);

        // Decode HTML entities for Quill
        function decodeHtmlEntities(str) {
            var textArea = document.createElement('textarea');
            textArea.innerHTML = str;
            return textArea.value;
        }

        if (quillEdit) {
            let decodedContent = decodeHtmlEntities(response.task); // Decode HTML entities
            quillEdit.root.innerHTML = decodedContent;
        }

        // Display existing images with remove option
        var imagesContainer = $('#existingImagesContainer');
        imagesContainer.empty(); // Clear previous images
        imagesContainer.css({
            display: 'flex',
            flexWrap: 'wrap',
            gap: '10px', // Add some spacing between images
        });

        // When displaying the images:
        if (response.image) {
            var imageArray = response.image.split(','); // Split existing images into an array
            imageArray.forEach(function(imageFilename) {
                var imageUrl = response.ImageUrl + imageFilename;
                var imageHtml = `
                    <div class="image-item">
                        <img src="${imageUrl}" alt="Existing Image" class="img-thumbnail" width="100">
                        <button type="button" class="btn btn-danger btn-sm remove-image" data-image="${imageFilename}"><i class="lni lni-trash"></i></button>
                    </div>
                `;
                imagesContainer.append(imageHtml);
                existingImages.push(imageFilename); // Add to existingImages array
            });
        }

        // Delegate click event for dynamically added remove buttons
        $('#existingImagesContainer').on('click', '.remove-image', function() {
            var imageFilename = $(this).data('image');
            $(this).closest('.image-item').remove(); // Remove from UI
            var index = existingImages.indexOf(imageFilename);
            if (index !== -1) {
                existingImages.splice(index, 1); // Remove from existingImages array
            }
        });

        // Show the modal after populating fields
        $('#editReportModal').modal('show');
    },
    error: function(xhr, status, error) {
        console.error('AJAX request failed:', status, error);
        console.error('Response:', xhr.responseText);  // Log response
    }
});

     
    
    

}


    </script>


	<!--app JS-->

	<script src="<?php echo $app; ?>"></script>

</body>



</html>

