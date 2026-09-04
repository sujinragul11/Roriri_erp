<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT
                    `intern_enquiry_id`,
                    `name`,
                    `phone`,
                    `email`,
                    `college_name`,
                    `POY`,
                    `department`,
                    `description`,
                    `follow_up`,
                    `comment`,
                    `follow_status`,
                    `enq_date`,
                    `status`
                FROM
                    `Intern_enquiry`
                WHERE `status`='Active'
                ORDER BY
                    `enq_date` DESC";
    
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
			<?php include("internshipLeft.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
        <?php include("formInternEnquiry.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Internship Enquiry</h2>
                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                    <button type="button" id="addClientBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addClientModal"><i class='bx bx-plus'></i> Enquiry</button>
                    </div>

                </div>
                   
            </div>

				<div class="card">
					<div class="card-body">
					     <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="reportStartDate">Start Date</label>
                                <input type="date" id="reportStartDate" class="form-control">
                                 <span id="startDateError" class="text-danger medium"></span>
                            </div>
                            <div class="col-md-3">
                                <label for="endDate">End Date</label>
                                <input type="date" id="endDate" class="form-control">
                                  <span id="endDateError" class="text-danger medium"></span>
                            </div>
                            <div class="col-md-3">
                                <label for="modeFilter">Select Mode</label>
                                <select id="modeFilter" class="form-control">
                                    <option value="">--Select the Mode--</option>
                                    <option value="Online">Online</option>
                                    <option value="Offline">Offline</option>
                                </select>
                            </div>
                           
                            <div class="col-md-3 mt-3 pt-1">
                                <button id="filterBtn" class="btn btn-primary">Apply</button>
                                </div>
                        </div>
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Name</th>
                                        <th>Phone</th>
                                        <th>College Name</th>
										<th>Followed Date</th>
										<th>Status</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $id             = $row['intern_enquiry_id'];  
                                        $name           = $row['name'];   
                                        $phone          = $row['phone'];  
                                        $email          = $row['email'];  
                                        $college_name   = $row['college_name'];
                                        $POY            = $row['POY'];   
                                        $department     = $row['department'];   
                                        $description    = $row['description'];
                                        $follow_up      = date('d M Y', strtotime($row['follow_up']));
                                        $comment        = $row['comment'];
                                        $follow_status  = $row['follow_status'];
                                        

                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo $name; ?></td>
                      <td><?php echo $phone; ?></th>
                      <td><?php echo $college_name; ?></td>
                      <td><?php echo $follow_up; ?></td>
                      <td><?php echo $follow_status; ?></td>
                      
                      <td>
                          <button class="btn btn-sm btn-outline-success" 
                          data-bs-toggle="tooltip" data-bs-placement="top" title="View" 
                          onclick="goViewClient(<?php echo $id; ?>);" >
                          <i class="lni lni-eye"></i></button>


                          <button type="button" class="btn btn-sm btn-outline-warning" 
                          data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" 
                          onclick="goEditClient(<?php echo $id; ?>);"><i class="lni lni-pencil"></i></button>
                         
                         
                          <button class="btn btn-sm btn-outline-danger" 
                          data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" 
                          onclick="goDeleteClient(<?php echo $id; ?>);"><i class="lni lni-trash"></i></button>
                          
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
		 <?php include "footer.php"; ?>
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
     function validateDateInputs() {
    const today = new Date().toISOString().split('T')[0]; // Today's date in YYYY-MM-DD format
    const reportStartDate = $('#reportStartDate').val();
    const endDate = $('#endDate').val();

    let isValid = true; // Flag to track overall validity

    // Clear previous error messages
    $('#startDateError').text('');
    $('#endDateError').text('');

    // Check if Start Date is in the future
    if (reportStartDate && reportStartDate > today) {
        $('#startDateError').text("Start Date cannot be in the future.");
        isValid = false;
    }

    // Check if End Date is in the future
    if (endDate && endDate > today) {
        $('#endDateError').text("End Date cannot be in the future.");
        isValid = false;
    }

    // Ensure End Date is not before Start Date
    if (reportStartDate && endDate && endDate < reportStartDate) {
        $('#endDateError').text("End Date cannot be earlier than Start Date.");
        isValid = false;
    }

    return isValid; // Return overall validity
}
        
    //       function setTodayMaxDate(inputId) {
    // const today = new Date().toISOString().split('T')[0];
    // document.getElementById(inputId).setAttribute("max", today);
    // }

    // // setTodayMaxDate('assetDate');
    // // setTodayMaxDate('editAssetDate');
    // // setTodayMaxDate('startDate');
    // setTodayMaxDate('reportStartDate');
    // setTodayMaxDate('endDate');
    
    
 

// Helper function to format the date
    function formatDate(dateString) {
    // Return 'N/A' if date is null, undefined, or empty
    if (!dateString) return 'N/A'; 
    
    // Check if the date is in the format of 'yyyy-mm-dd'
    const isoFormat = /^\d{4}-\d{2}-\d{2}$/;
    if (isoFormat.test(dateString)) {
        const [year, month, day] = dateString.split('-');
        return formatValidDate(day, month, year);
    }

    // Check if the date is in the format of 'dd-mm-yyyy'
    const customFormat = /^\d{2}-\d{2}-\d{4}$/;
    if (customFormat.test(dateString)) {
        const [day, month, year] = dateString.split('-');
        return formatValidDate(day, month, year);
    }

    // If the format is incorrect, return 'N/A'
    return 'N/A';
}

function formatValidDate(day, month, year) {
    const parsedDay = parseInt(day, 10);
    const parsedMonth = parseInt(month, 10) - 1; // JavaScript months are 0-based
    const parsedYear = parseInt(year, 10);

    // Create a Date object
    const date = new Date(parsedYear, parsedMonth, parsedDay);

    // Check if the date is valid
    if (isNaN(date.getTime())) return 'N/A'; // If date is invalid, return 'N/A'

    // Create an array of month abbreviations
    const monthNames = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    const formattedDay = String(date.getDate()).padStart(2, '0');
    const formattedMonth = monthNames[date.getMonth()]; // Get the month abbreviation
    const formattedYear = date.getFullYear();

    return `${formattedDay}-${formattedMonth}-${formattedYear}`; // Format as d-MMM-Y
}

      // Filter button click event
    $('#filterBtn').on('click', function() {
        
        // Validate dates before proceeding with AJAX request
    if (!validateDateInputs()) {
        return; // Stop if validation fails
    }
    
        var reportStartDate = $('#reportStartDate').val();
        var endDate = $('#endDate').val();
        var mode = $('#modeFilter').val();
        if (!reportStartDate && !endDate && !mode) {
            console.log("All filters are empty. AJAX request will not be triggered.");
            return; // Stop if all variables are empty
        }
        
        // Perform AJAX request
        $.ajax({
            url: 'action/actInternEnquiry.php', // Update with your server-side script to fetch data
            type: 'GET',
            data: {
                report_start_date: reportStartDate,
                end_date: endDate,
                mode: mode
            },
            dataType: 'json',
            success: function(data) {
                
        $('#example2').DataTable().destroy();
        $('#example2 tbody').empty();

                   // Loop through the returned data and append rows to the table
        data.forEach(function(item, index) {
             const rowHTML = `
                <tr>
                    <td>${index + 1}</td> 
                    <td>${item.name}</td> 
                    <td>${item.phone}</td>
                    <td>${item.college_name}</td> 
                    <td>${formatDate(item.follow_up)}</td> 
                    <td>${item.follow_status}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-success"
                                             data-bs-toggle="tooltip" data-bs-placement="top" title="View" 
                                             onclick="goViewClient(${item.intern_enquiry_id});">
                                                <i class="lni lni-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                 id="editSaveCandidate" onclick="goEditClient(${item.intern_enquiry_id});" 
                                                 data-bs-toggle="modal" data-bs-target="#editClientModal">
                                                <i class="lni lni-pencil"></i>
                                            </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                                 data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" 
                                                 onclick="goDeleteClient(${item.intern_enquiry_id});">
                                                <i class="lni lni-trash"></i>
                                            </button>
                        
                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Task" onclick="showTaskTable(${item.intern_enquiry_id})">
                                            <i class="lni lni-radio-button"></i>
                                        </button>
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
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    });
    
    
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });

        // Handle the button click to open the modal and reset the form
$('#addClientBtn').on('click', function() {
    resetForm('addClient'); // Reset the form before opening the modal
});
    </script>
    <script>
    function goViewClient(clientId) {
    // Show loading indicator
    $('#clientDetails').html('<div class="col-12 text-center"><p>Loading...</p></div>');

    // Open the modal
    $('#viewClientModal').modal('show');

    // Make an AJAX call to get client details
    $.ajax({
        url: 'action/actInternEnquiry.php',
        method: 'POST',
        data: { viewId: clientId },
        dataType: 'json',
        success: function (response) {
            if (response) {
                // Build the details view dynamically with Bootstrap cards
                var detailsHtml = `
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Personal Information</h5>
                                <p class="card-text"><strong>Name:</strong> ${response.name}</p>
                                <p class="card-text"><strong>Phone:</strong> ${response.phone}</p>
                                <p class="card-text"><strong>Email:</strong> ${response.email}</p>
                                <p class="card-text"><strong>Enquiry Date:</strong>${response.enq_date === '0000-00-00' ? 'No Data' : formatDate(response.enq_date)}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Academic Information</h5>
                                <p class="card-text"><strong>College Name:</strong> ${response.college_name}</p>
                                <p class="card-text"><strong>Passout Year:</strong> ${response.poy}</p>
                                <p class="card-text"><strong>Department:</strong> ${response.department}</p>
                                <p class="card-text"><strong>Mode:</strong> ${response.mode}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Additional Details</h5>
                                <p class="card-text"><strong>Description:</strong> ${response.description || 'N/A'}</p>
                                <p class="card-text"><strong>Address:</strong> ${response.address || 'N/A'}</p>
                                <p class="card-text"><strong>Follow-up Date:</strong> ${formatDate(response.follow_up)}</p>
                                <p class="card-text"><strong>Follow Status:</strong> ${response.follow_status}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Comments</h5>
                                <p class="card-text">${response.comment || 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                `;
                $('#clientDetails').html(detailsHtml);
            } else {
                // Handle error (e.g., client not found)
                $('#clientDetails').html('<div class="col-12 text-center"><p>Error fetching Enquiry details.</p></div>');
            }
        },
        error: function () {
            $('#clientDetails').html('<div class="col-12 text-center"><p>An error occurred while fetching Enquiry details.</p></div>');
        }
    });
}




function goEditClient(id) 
  
  {
    $('#editClientModal .modal-body').html('<p>Loading...</p>');
    $.ajax({
        url: 'action/actInternEnquiry.php',
        method: 'POST',
        data: {
            editEnquiryId: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			
            if (response) {
          $('#enqId').val(response.intern_enquiry_id);
          $('#editName').val(response.name);
          $('#editPhone').val(response.phone);
          $('#editEmail').val(response.email);
          $('#editCollegeName').val(response.college_name);
          $('#editPassoutYear').val(response.poy);
          $('#editDepartment').val(response.department);
          $('#editDescription').val(response.description);
          $('#editAddress').val(response.address);
          $('#editFollowUpDate').val(response.follow_up);
          $('#editComments').val(response.comment);
          $('#editFollowStatus').val(response.follow_status);
          $('#editEnquiryDate').val(response.enq_date);
          $('#editMode').val(response.mode);
          
		  
            // Now open the modal
            $('#editClientModal').modal('show');

        } else {
                // Handle error (e.g., client not found)
                $('#editClientModal .modal-body').html('<p>Error fetching Enquiry details.</p>');
            }
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    }
    function goDeleteClient(id)
    {
    //alert(id);
    if(confirm("Are you sure you want to delete Enquiry?"))
    {
      $.ajax({
        url: 'action/actInternEnquiry.php',
        method: 'POST',
        data: {
          clientdeleteId: id
        },
        //dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
          $('#example2').load(location.href + ' #example2 > *', function() {
                               
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
                            // Show SweetAlert based on the response
                                if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Deleted',
                                                text: response.message,
                                                timer: 2000
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
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    }
    }
//Data Table script 
    </script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
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
                $('#addClient').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                     // Check if the form is valid
                    if (!this.checkValidity()) {
                        // If the form is invalid, show validation messages
                        $(this).addClass('was-validated');
                        return; // Stop the submission
                    }

                    var formData = new FormData(this);
                    var submitButton = $('#addSubmitBtn'); // Target the submit button

                    // Disable the submit button to avoid multiple clicks
                    submitButton.prop('disabled', true).text('Submitting...');

                    $.ajax({
                        url: "action/actInternEnquiry.php",
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
                                resetForm('addClient');
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
                                text: 'An error occurred while adding Client data.'
                            });
                        },
                        complete: function() {
                            // Re-enable the submit button after the request completes
                            submitButton.prop('disabled', false).text('Save changes');
                        }
                    });
                });

                // Reset the form when the close button is clicked
                $('#addClientBtn').click(function () {
                    resetForm('addClient');
                });
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

</script>
<script>

//--------------Handles edit Clients-----------------------------//

document.addEventListener('DOMContentLoaded', function() {

// Handle the form submission via AJAX
$('#editClient').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

     // Check if the form is valid
     if (!this.checkValidity()) {
        // If the form is invalid, show validation messages
        $(this).addClass('was-validated');
        return; // Stop the submission
    }

    var formData = new FormData(this);
    var submitButton = $('#editSubmitBtn'); // Target the submit button

    // Disable the submit button to avoid multiple clicks
    submitButton.prop('disabled', true).text('Submitting...');

    $.ajax({
        url: "action/actInternEnquiry.php",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json', // Expect JSON response
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: response.message,
                    timer: 2000
                }).then(function () {
                    $('#editClientModal').modal('hide'); // Close the modal
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
                text: 'An error occurred while editing Enquiry data.'
            });
        },
        complete: function() {
            // Re-enable the submit button after the request completes
            submitButton.prop('disabled', false).text('Save changes');
        }
    });
});

$('#editCloseBtn').click(function () {
    hideErrorMessages(); // Call the function to hide error messages
});
});



</script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>