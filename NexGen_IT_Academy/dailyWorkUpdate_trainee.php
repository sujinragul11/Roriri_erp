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

        <?php include("dailyWorkUpdateForm_trainee.php");?>

		

		<div class="page-wrapper">
		    
	

			<div class="page-content">

                

				

            <div class="page-title-box">

                

                <div class="page-title-right">

                    <h2 class="page-title">Daily Work Update</h2>

                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                     <?php
                          $trainerRoles = [6 ,1,2,5,7,3,9,11,12,13,14,15,10]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainerRoles)) 
                          {
              ?>

                    <button type="button" id="addEnquireBtn" class="btn btn-primary position-absolute top-0 end-0 " data-bs-toggle="modal" data-bs-target="#addReportModal"><i class="lni lni-plus"></i>New Work Update</button>
                
                <?php
                }
                ?>
            
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
              <form id="filterForm" novalidate class="needs-validation">
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="startDate">Start-Date:</label>
            <input type="date" id="startDate" class="form-control" value="<?php echo date('Y-m-d'); ?>"  placeholder="Start Date">
            <span id="startDateError" class="text-danger"></span>
        </div>
        <div class="col-md-3">
            <label for="endDate">End-Date:</label>
            <input type="date" id="endDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="End Date">
            <span id="endDateError" class="text-danger"></span>
        </div>
      
       
       
        
         <?php
                          $trainerRoles = [17]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') 
                          {
              ?>
              
              
              
                        
									
                        
                        <div class="col-md-3">
                            <label for="empName">Worked By :</label>
                            <select class="form-control" id="empName" name="empName" data-placeholder="Choose one Employee">
                                <option value="">-- Trainee --</option>
                                    
                      <?php
                $queryCou = "SELECT id, name FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id LEFT JOIN roles AS c ON b.role = c.role_id WHERE a.status='Active' AND c.role_id != 17 ";
                $resultCou = mysqli_query($conn, $queryCou);
            
                if ($resultCou) {
                    while ($row = mysqli_fetch_assoc($resultCou)) {
                        $courseId = $row['id'];
                        $courseName = $row['name'];
                        echo "<option value=\"$courseId\">$courseName</option>";
                    }
                }
            ?>
                            </select>
                        </div>
                        
                        
                        <?php } ?>
   

        <div class="col-md-3 mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="lni lni-angle-double-down"></i> Filter
            </button>
            <button type="button" id="clearFilter" class="btn btn-secondary ms-2">
                <i class="lni lni-reload"></i> Clear
            </button>
        </div>
    </div>
</form>
                
               
            
                		<table id="example3" class="table table-striped table-bordered" style="width: 100%;">

								<thead>

									<tr>
                                    <th class="col-1" >S. No</th>
                                    <th class="d-none">image</th>
                                    <th class="d-none">Url</th>
                                    <th class="col-2">Worked Date</th>
                                    <th class="col-2">Name</th>
                                    <th class="col-1">Worked Hours</th>
                                    
                                    <th class="col-4">Work Description </th>
                                    <th class="col-2">Action</th>
                                </tr>

								</thead>
                				<tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right">Total Worked Hours:</th>
                        <th id="totalWorkingHours">0</th>
                        <th colspan="1"></th> <!-- Empty space for the Action column -->
                    </tr>
                </tfoot>

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
    var isAdminOrSuperAdmin = <?php echo ($_SESSION['role'] === '17' || $_SESSION['is_admin'] === 'True') ? 'true' : 'false'; ?>;
    var userId = "<?php echo $_SESSION['id']; ?>"; // User's session ID
</script>

<script>
     $('#addEnquireBtn').click(function() {
            resetFromAdd();
           

            });
            
   function resetFromAdd() {
    // Reset the form
    $('#addDepartment')[0].reset();

    // Remove validation classes
    $('#addDepartment').removeClass('was-validated').addClass('needs-validation');

    // Clear all <textarea> elements
    quill.root.innerHTML='';

    // Reset Select2 elements
    $('#task').val(null).trigger('change'); // Reset the value and update Select2
    $('#category').val(null).trigger('change'); // Reset the value and update Select2
    $('#subcategory').val(null).trigger('change'); // Reset the value and update Select2
    $('#employee').val(null).trigger('change'); // Reset the value and update Select2
}

     $( '#categoryEdit' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#categoryEdit' ).parent(),
    } );

 $( '#subcategoryEdit' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#subcategoryEdit' ).parent(),
    } );

 $( '#taskEdit' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#taskEdit' ).parent(),
    } );

  $( '#task' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#task' ).parent(),
    } );
     
      $( '#subcategory' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#subcategory' ).parent(),
    } );
     
        $( '#category' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#category' ).parent(),
    } );
     
     $( '#employee' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#employee' ).parent(),
    } );


$( '#empName' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#empName' ).parent(),
    } );

$( '#report_subcategory' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#report_subcategory' ).parent(),
    } );
    
    
    $( '#report_category' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#report_category' ).parent(),
    } );
    
     $( '#report_task' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $( '#report_task' ).parent(),
    } );
    
    
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
    
var reportTable = $('#example3').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": "action/actDailyWorkUpdate_trainee.php",
        "type": "POST",
        "data": function(d) {
            d.getData = "GetTable";
            d.startDate = $('#startDate').val();
            d.endDate = $('#endDate').val();
            d.empName = isAdminOrSuperAdmin ? $('#empName').val() : userId;
        },
        dataSrc: function(json) {
            // Update totals in the footer
            $('#totalWorkingHours').text(json.totals.working_hours || "0.00");
            return json.data;
        }
    },
     "columns": [
        { data: "sid", orderable: true, className: "col-1" },
        { data: "date", orderable: true, className: "col-2" },
        { data: "image", visible: false },
        { data: "name", orderable: true, className: "col-2" },
        { data: "hours", orderable: true, className: "col-1" },
        {
            data: "desription",
            orderable: true,
            className: "col-4 text-truncate",
            render: function (data, type, row) {
                if (type === 'display') {
                    // Decode HTML entities
                    var decodedDescription = (new DOMParser()).parseFromString(data, 'text/html').documentElement.textContent;
    
                    // Return truncated content with a tooltip
                    return `
                        <div 
                            class="text-truncate" 
                            style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" 
                            title="${decodedDescription}">
                            ${decodedDescription}
                        </div>`;
                }
                return data; // For other types (e.g., export)
            }
        },
        { data: "action", orderable: true, className: "col-2" }
    ],
    "drawCallback": function() {
      $('[data-bs-toggle="tooltip"]').tooltip(); 
    },
    "pageLength": 10,
    "lengthMenu": [10, 20, 50, -1],
    "order": [[1, 'desc']] // Default sorting on the 'date' column
});



    // Handle filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        reportTable.ajax.reload(); // Reload the table with filter values
    });

    // Optional: Handle filter button click
    // $('#filterBtn').click(function() {
    //     reportTable.ajax.reload();
    // });
    
    
     document.getElementById('addDepartment').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    var form = this;
    var descriptionContent = document.getElementById('description');
    var quillContent = quill.root.innerHTML.trim();

    // Update hidden textarea with Quill editor content
    descriptionContent.value = quillContent;

    // Check if the description is empty
    if (!quillContent || quillContent === '<p><br></p>') {
        descriptionContent.setCustomValidity("Please fill out this field.");
    } else {
        descriptionContent.setCustomValidity(""); // Clear error if valid
    }

    // Perform validation check
    if (!form.checkValidity()) {
        form.classList.add('was-validated'); // Add Bootstrap validation styling
        event.stopPropagation(); // Stop further processing
        return;
    } else {
        form.classList.remove('was-validated');
    }

    var formData = new FormData(form);

    // Show the loader before sending the request
    $('#loader').show();

    $.ajax({
        url: 'action/actDailyWorkUpdate_trainee.php',
        type: 'POST',
        data: formData,
        dataType: 'json', // Specify the expected data type as JSON
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Allow the content type to be set automatically (multipart/form-data)
        success: function (response) {
            $('#loader').hide(); // Hide the loader

            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 1000
                }).then(function() {
                    $('#addReportModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
                    reportTable.ajax.reload(null, false); // Reload the DataTable
                });

                resetFromAdd();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (error) {
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

     let editorContent = quillEdit.getText().trim();
    let descriptionField = $('#descriptionEdit');
    let feedback = $('#editorEdit').siblings('.invalid-feedback');

    // Check if Quill editor content is empty or less than 20 characters
    if (!this.checkValidity() || editorContent.length < 10) {
        $(this).addClass('was-validated');

        // Custom validation feedback for Quill editor
        if (editorContent.length < 10) {
            $('#editorEdit').addClass('is-invalid'); // Add invalid class to editor
            feedback.text('Please enter at least 10 characters.').show(); // Show custom error message
        } else if (!editorContent) {
            $('#editorEdit').addClass('is-invalid'); // Add invalid class if empty
            feedback.text('Please enter a description.').show();
        } else {
            $('#editorEdit').removeClass('is-invalid'); // Remove invalid class if content is valid
            feedback.hide();
        }

        return; // Stop the submission if validation fails
    }
    
    var formData = new FormData(this); // Create FormData object

    // Append the existing images to the FormData
    formData.append('existingImages', existingImages.join(',')); // Combine old images into a string

    // Show a loader while the request is in progress
    $('#loader').show();

    // Send the form data via AJAX
    $.ajax({
        url: 'action/actDailyWorkUpdate_trainee.php',
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
    // $('#taskCategory').text(data.category);
    // $('#taskSubcategory').text(data.subcategory);
    // $('#taskTask').text(data.task);
    $('#taskUrl').text(data.url);
    $('#taskDescription').html(data.desription);
    // $('#taskStatus').text(data.task_status);
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

// Show a loader while the request is in progress
             $('#loader').show();

// AJAX call to fetch existing report data
$.ajax({
    url: 'action/actDailyWorkUpdate_trainee.php',
    method: 'POST',
    data: { editIdReport: id },
    dataType: 'json',
    success: function(response) {
        // Populate other fields
        $('#editReportId').val(response.id);
        $('#dateEdit').val(response.date);
        $('#setName').text(response.full_name);

        $('#nameEdit').val(response.name);
        $('#hoursEdit').val(response.hours);
        $('#projectURLEdit').val(response.url);

        // Decode HTML entities for Quill
        function decodeHtmlEntities(str) {
            var textArea = document.createElement('textarea');
            textArea.innerHTML = str;
            return textArea.value;
        }

        if (quillEdit) {
            let decodedContent = decodeHtmlEntities(response.work); // Decode HTML entities
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
        // Hide the loader when the request completes
                 $('#loader').hide();
        // Show the modal after populating fields
        $('#editReportModal').modal('show');
    },
    error: function(xhr, status, error) {
        console.error('AJAX request failed:', status, error);
        console.error('Response:', xhr.responseText);  // Log response
    }
});

     
    
    

}



document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('clearFilter').addEventListener('click', function () {
        // Reset the form for standard inputs
        document.getElementById('filterForm').reset();

    
        $('#empName').val(null).trigger('change'); // Reset employee (if applicable)
        
        $('#startDate').val('');
        $('#endDate').val('');
        
        // Clear error messages
        document.getElementById('startDateError').innerText = '';
        document.getElementById('endDateError').innerText = '';
    });
});

    </script>


	<!--app JS-->

	<script src="<?php echo $app; ?>"></script>

<script src="../assets/js/form-validation.js"></script>
</body>



</html>

