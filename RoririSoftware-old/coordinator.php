<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");  
include "class.php";  
   $selQuery = "SELECT `id`, `name`, `details` ,`log` FROM `coordinator` WHERE status = 'Active'";
    
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
        <?php include "formCoordinator.php";?>
		
		<div class="page-wrapper">
			<div class="page-content" id = "coordinatortbl">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Coordinator</h2>
                </div>
                   
            </div>

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Department</th>
                                        <!-- <th>Description</th> -->
                                        <th>Coordinator Name</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 

                                        $id      = $row['id']; 
                                        $dept_name    = $row['name'];  
                                        $details = $row['details'];  
                                        $log = json_decode($row['log'], true); // Decode the JSON log

                                   // Initialize an empty string to hold active coordinator IDs
                                    $idString = '';

                                    // Check if the log is a valid array and contains coordinators
                                    if (is_array($log)) {
                                        // Filter coordinators with 'status' == 'active'
                                        $activeCoordinators = array_filter($log, function($coordinator) {
                                            return isset($coordinator['status']) && $coordinator['status'] === 'active';
                                        });

                                        // Extract the IDs of active coordinators
                                        $coordinatorIds = array_column($activeCoordinators, 'id');
                                        
                                        // Convert the IDs array to a comma-separated string
                                        if (!empty($coordinatorIds)) {
                                            $idString = implode(', ', $coordinatorIds);
                                        }
                                    }
                                        // $coordinatorIds = array_column($log, 'id'); // Extract IDs from log 
                                        // $idString = implode(', ', $coordinatorIds); // Convert IDs array to a comma-separated string
                                       
                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo $dept_name; ?></td>
                      <td><?php echo htmlspecialchars(userNameOnly($idString)); ?></td>
                      
                      
                      <td>
                          <?php 
                            if ($_SESSION['is_admin'] === 'True') {  // Check if the user is an admin
                          ?>
                          <button type="button" onclick="addCoordinator('<?php echo $id ?>','<?php echo $dept_name ?>')" class="btn btn-sm btn-outline-primary"  data-bs-toggle="modal" data-bs-target="#addClientModal"><i class="lni lni-plus"></i></button>   
                          <?php } ?>
                          <button class="btn btn-sm btn-outline-success" onclick="viewCoordinator(<?php echo $id ?>)" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="lni lni-eye"></i></button>
                          <?php 
                            if ($_SESSION['is_admin'] === 'True') {  // Check if the user is an admin
                          ?>
                          <button class="btn btn-sm btn-outline-info history-btn" data-id="<?php echo $id; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="History"><i class="lni lni-timer"></i></button>
                          <?php } ?>
                      </td>
                    </tr>
                    <?php } ?>   
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
			</div><!--end page-content-->
			<div class="page-content" id = "histroytbl" style="display:none;">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Coordinator Histroy</h2>
                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                     <button type="button" id="backBtn" class="btn btn-danger position-absolute top-0 end-0">Back</button> 
                    </div>
                </div>
                   
            </div>

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example3" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Coordinator Name</th>
                                        <th>From Date</th>
										<th>To Date</th>
										<th>Total Days</th>
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
    <script src="<?php echo $textEditor; ?>"></script>
	<script src="<?php echo $sweetalert; ?>"></script>
	<script src="<?php echo $select2; ?>"></script>
	<script src="<?php echo $select2Custom;?>"></script>
    
        <!-- Include the function.js -->
        <script src="../assets/js/function.js"></script>
        <!-- Include Quill's JS -->
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
</script>

     <!-- Initialize tooltips -->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script>

function addCoordinator(id, name) {
    // Reset the form
    $('#addDepartment')[0].reset();

    // Set values in form fields
    $('#dept_id').val(id);
    $('#dept_name').val(name);

    $.ajax({
        url: 'action/actCoordinator.php', // PHP file handling the request
        type: 'POST',
        dataType: 'json',
        data: {
            hdnAction: 'getDepartmentDetails',
            dept_id: id
        },
        success: function(response) {
            // Check if response is successful
            if (response.success) {
                // Extract coordinator details
                let coordinators = response.coordinator;

                // Function to decode HTML entities
                function decodeHtmlEntities(str) {
                    var textArea = document.createElement('textarea');
                    textArea.innerHTML = str;
                    return textArea.value;
                }

                // Set the content of the Quill editor
                if (quill) { // Ensure Quill is initialized
                    let decodedContent = decodeHtmlEntities(response.roles_res); // Decode HTML entities
                    quill.root.innerHTML = decodedContent; // Set decoded HTML content
                }

                // Initialize an array for active coordinator IDs
                let activeCoordinatorIds = [];
                let inactiveCoordinatorData = []; // Array to store inactive coordinators' data

                // If coordinator data is not null, process it
                if (coordinators) {
                    // Check if coordinators is an array or object
                    if (Array.isArray(coordinators)) {
                        // Filter IDs with status 'active' and collect inactive data
                        coordinators.forEach(coordinator => {
                            if (coordinator.status === 'active') {
                                activeCoordinatorIds.push(coordinator.id); // Extract active IDs
                            } else {
                                inactiveCoordinatorData.push(coordinator); // Store inactive coordinators for history
                            }
                        });
                    } else if (typeof coordinators === 'object') {
                        // Handle case where coordinator is a single object
                        if (coordinators.status === 'active') {
                            activeCoordinatorIds = [coordinators.id];
                        } else {
                            inactiveCoordinatorData.push(coordinators); // Store for history
                        }
                    }
                }

                // Set the values in the multi-select field (active IDs only)
                $('#multiple-select-clear-field').val(activeCoordinatorIds);

                // Trigger change event to make sure UI updates
                $('#multiple-select-clear-field').trigger('change');

                // Now, you can process the inactive coordinators as needed for history
                // For example, you can display them in a separate history section or log them
                displayInactiveCoordinators(inactiveCoordinatorData);

            } else {
                // Display an alert message if the response is not successful
                alert(response.message || "Failed to load coordinator details.");
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}

function displayInactiveCoordinators(inactiveCoordinators) {
    // Here you can decide how to display the inactive coordinators for history
    // For example, appending to a table or logging to console
    inactiveCoordinators.forEach(coordinator => {
        console.log('Inactive Coordinator:', coordinator); // Replace with actual display logic
    });
}

function viewCoordinator(id) 
  
  {
    $.ajax({
        url: 'action/actCoordinator.php',
        method: 'POST',
        data: {
            viewId: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#viewDept').text(response.dept);
          $('#viewCoor').text(response.coordinator);
          
          // Ensure the Quill editor is initialized
        if (quill) {
            // Decode HTML entities if necessary
            let decodedContent = decodeHtmlEntities(response.roles_res);
            
            // Use Quill's clipboard method to set the HTML content
            quill.clipboard.dangerouslyPasteHTML(decodedContent);
            
            // Set the HTML of #viewRoles with decoded content to display HTML tags properly
            $('#viewRoles').html(decodedContent);
        }

        // Function to decode any potential HTML entities
        function decodeHtmlEntities(encodedString) {
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = encodedString;
            return tempDiv.textContent || tempDiv.innerText || "";
        }
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
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

    <!--Handles the Ajax call-->
<script>
        $(document).ready(function () {
    // Handle the form submission via AJAX
    $('#addDepartment').off('submit').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission

        var formData = new FormData(this);
        $.ajax({
            url: "action/actCoordinator.php",
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
                        timer: 2000
                    }).then(function () {
                        $('#addClientModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop
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
                    resetForm('addDepartment');
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
                    text: 'An error occurred while adding Coordinator data.'
                });
            }
        });
    });

    // Reset the form when the close button is clicked
    $('#modalCloseBtn').click(function () {
        resetForm('addClient');
    });
});

// Function to reset the form and hide error messages
function resetForm(formId) {
    document.getElementById(formId).reset(); // Reset the form
    $('.error-message').hide(); // Hide all error messages
}

</script>
<script>

$(document).ready(function() {
    // Initialize the DataTable for history (initially empty)
    const historyTable = $('#example3').DataTable();

    // Handle the click event for the history button
    $(document).on('click', '.history-btn', function() {
        const coordinatorId = $(this).data('id');  // Get the coordinator's ID from the button

        // Make an AJAX request to fetch the history for the selected coordinator
        $.ajax({
            url: 'action/actCoordinator.php',  // The PHP script to fetch history
            method: 'POST',
            data: { hisId: coordinatorId },  // Send the coordinator's ID
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const historyData = response.data;

                    // Clear the current history table
                    historyTable.clear(); // Clear existing data

                    // Loop through the data
                    let serialNumber = 1; // Initialize serial number
                    historyData.forEach(function(row) {
                        const log = row.log; // Log is populated with user names

                        // Loop through the log entries
                        log.forEach(function(entry) {
                            const assignTime = new Date(entry.assign_time);
                            const changeTime = entry.change_time ? new Date(entry.change_time) : null;

                            // Calculate total days
                            const totalDays = changeTime 
                                ? Math.ceil((changeTime - assignTime) / (1000 * 60 * 60 * 24)) 
                                : Math.ceil((new Date() - assignTime) / (1000 * 60 * 60 * 24));

                            // Add row data to DataTable
                            historyTable.row.add([
                                serialNumber,
                                entry.user_name,
                                assignTime.toLocaleDateString(),
                                changeTime ? changeTime.toLocaleDateString() : 'Present',
                                totalDays
                            ]).draw(); // Draw the table after adding data

                            serialNumber++;  // Increment serial number for the next row
                        });
                    });

                    // Show the history table and hide the coordinator table
                    $('#coordinatortbl').hide();
                    $('#histroytbl').show();
                } else {
                    alert('Failed to fetch history data: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while fetching history data');
            }
        });
    });

    // Handle the back button click to return to the coordinator table
    $(document).on('click', '#backBtn', function() {
        $('#histroytbl').hide();
        $('#coordinatortbl').show();
    });
});


</script>

	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
</body>

</html>