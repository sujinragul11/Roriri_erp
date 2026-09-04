<?php

session_start();
include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "CALL ManageClient('SELECT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active',NULL);";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
<?php include("formClient.php");?>
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
        <?php include("top.php"); ?>
		<!--end sidebar wrapper -->
		<!--start header -->
        <?php include("left.php"); ?>
			
		<!--end header -->
		<!--start page wrapper -->
		
		<div class="page-wrapper">

          
			<div class="page-content" id="clientTbl">
                
				
            <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline">Client Details</h2>
                    <div class="d-flex justify-content-end">
                        <button type="button" id="addClientBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addClientModal"><i class="lni lni-upload me-1"></i>Add Client</button>
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
                                        <th>Date</th>
										<th>College Name</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Location</th>
										<th>Username</th>
										<th>Password</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								    
								    <?php $i=1; while($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) { 
                                        $id         = $row['id'];  
                                        $name       = $row['name'];   
                                        $phone      = $row['phone'];  
                                        $email      = $row['email'];
                                        $location      = $row['location'];
                                        $username      = $row['username'];
                                        $date  = date('d M Y', strtotime($row['created_at']));   
                                        $password       = $row['password'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i; $i++; ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $phone; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><?php echo $location; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $password; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-target="#top" title="View IV details" onclick="viewIvDetails(<?php echo $id; ?>);" ><i class="lni lni-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditClient(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#editClientModal"><i class="lni lni-pencil"></i></button>
                                        </td>
                                    </tr>
                                     <?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div><!--end page-content-->
			
			<div class="page-content" id="clientDetails" style="display:none;">
                <div class="page-title-box">
                    <div class="page-title-right pb-3">
                        <h2 class="page-title text-muted text-decoration-underline">College IV Details</h2>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="backClientBtn" class="btn btn-danger me-2"><i class="lni lni-exit me-1"></i>Back</button>
                        </div>
                    </div>
                </div>
                
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 justify-content-center" id="clientCardsContainer">
                    <!-- Dynamic client cards will be appended here -->
                </div>
                
                <div id="pagination-controls" class="pagination-controls mt-3 text-center" style="display:none;">
                    <button id="prevBtn" class="btn btn-secondary" disabled>Previous</button>
                    <span id="pageInfo" class="mx-2">Page 1 of 1</span>
                    <button id="nextBtn" class="btn btn-secondary">Next</button>
                </div>
            </div>
            <!--end page-content-->
			
			<div class="page-content" id="ivDetailsTbl" style="display:none;">
                <div class="page-title-box">
                    <div class="page-title-right pb-3">
                        <h2 class="page-title text-muted text-decoration-underline" id="ivDetailsHeading">College IV Details</h2>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="backViewBtn" class="btn btn-danger me-2">
                                <i class="lni lni-exit me-1"></i>Back
                            </button>
                        </div>
                    </div>
                </div>
            
                <div class="card">
                    <div class="card-body p-4" id="ivFullDetails">
                        <!-- Dynamic content will be inserted here via JavaScript -->
                    </div>
                </div>
            
                <!-- Student Details Section -->
                <div class="page-title-box">
                    <div class="page-title-right pb-3">
                        <h2 class="page-title text-muted text-decoration-underline">Students Details</h2>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="issueBtn" class="btn btn-primary me-2" data-bs-toggle="tooltip" data-bs-target="#top" title="Issue All Certificates" onclick="issueAllCertificates()">
                                <i class="lni lni-checkmark-circle me-1"></i>Issue All
                            </button>
                            <button type="button" id="downloadBtn" class="btn btn-primary me-2" data-bs-toggle="tooltip" data-bs-target="#top" title="Download All Certificates">
                                <i class="lni lni-download me-1"></i>Download All
                            </button>
                            <button type="button" id="addStudentBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                <i class="lni lni-upload me-1"></i>Add Student
                            </button>
                        </div>
                    </div>
                </div>
            
                <!-- Student Details Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Student Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic student rows will be inserted here via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!--end page-content-->
			
			<div class="page-content" id="feedbackTbl" style="display:none;"> 
                <div class="page-title-box">
                    <div class="page-title-right pb-3">
                        <h2 class="page-title text-muted text-decoration-underline">Students Feedback</h2>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="backfeedBtn" class="btn btn-danger me-2"><i class="lni lni-exit me-1"></i>Back</button>
                        </div>
                    </div>
                </div>
                
				<div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Card Header Title</h5>
                    </div>
                
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="chat-content" style="height: 500px; margin-left: 0px; padding: 15px 15px 15px 15px; */">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
			</div><!--end page-content-->
			
			<div class="page-content" id="galleryTbl" style="display:none;">
                <form id="imageUploadForm" enctype="multipart/form-data" novalidate class="needs-validation">
                    <div class="page-title-box">
                        <div class="page-title-right pb-3">
                            <h2 class="page-title text-muted text-decoration-underline">Galleries</h2>
                            <div class="d-flex justify-content-end">
                                <button type="button" id="backgalleryBtn" class="btn btn-danger me-2">
                                    <i class="lni lni-exit me-1"></i>Back
                                </button>
                            </div>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Image Gallery</h5>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('imageInput').click();">
                                <i class="bx bx-upload"></i> Upload Image
                            </button>
                            <input type="hidden" id="galVisitId" name="galVisitId">
                            <input type="file" id="imageInput" accept=".jpg, .jpeg, .png" style="display: none;" onchange="loadImage(this)">
                        </div>
            
                        <div class="card-body">
                            <div class="row g-3" id="imageGallery"></div>
                        </div>
                    </div>
                </form>
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
	<script src="<?php echo $app; ?>"></script>
		<script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script>
		new PerfectScrollbar('.chat-content'); 
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
    <!--app JS-->
	<script src="<?php echo $app; ?>"></script>
    
<script src="../assets/js/form-validation.js"></script>
</body>

<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
				
			
		} );
		function resetForm(formId) {
            var form = $('#' + formId);
            form[0].reset();
            form.removeClass('was-validated');
        }
</script>
<script>
$(document).ready(function() {
    
    $('#addClientBtn').on('click', function() {
        resetForm('clientForm');  // Reset the form fields
        $('#submitFormBtn').prop('disabled', false); // Enable the submit button
    });
    $('#addStudentBtn').on('click', function() {
        resetForm('studentForm');  // Reset the form fields
        $('#submitFormBtn').prop('disabled', false); // Enable the submit button
    });
    $('#backClientBtn').on('click', function() {
        $('#clientTbl').show();
        $('#clientDetails').hide();
    });
    $('#backViewBtn').on('click', function() {
        $('#clientDetails').show();
        $('#ivDetailsTbl').hide();
        $('#example3').DataTable().page(0).draw();
    });
    $('#backfeedBtn').on('click', function() {
        $('#clientDetails').show();
        $('#feedbackTbl').hide();
    });
    $('#backgalleryBtn').on('click', function() {
        $('#clientDetails').show();
        $('#galleryTbl').hide();
    });
    // Handle the form submission via AJAX for Add College
    $('#clientForm').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        $(this).find("input[required], textarea[required]").each(function () {
            $(this).val($(this).val().trim());
        });
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
        $.ajax({
            url: "action/actClient.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function () {
                        $('#addClientModal').modal('hide'); 
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
                            });
                        
                    });
                    // Reset the form after successful submission
                    resetForm('clientForm');
                    $('#submitFormBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#submitFormBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding Client details.'
                });
                $('#submitFormBtn').prop('disabled', false);
            }
        });
    });
    
    // Handle the form submission via AJAX for Edit College
    $('#clientFormEdit').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        $(this).find("input[required], textarea[required]").each(function () {
            $(this).val($(this).val().trim());
        });
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        $.ajax({
            url: "action/actClient.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function (response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function () {
                        $('#editClientModal').modal('hide'); 
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
                            });
                        
                    });
                    // Reset the form after successful submission
                    resetForm('clientFormEdit');
                    $('#submitEditBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#submitEditBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating Client Deatils.'
                });
                $('#submitEditBtn').prop('disabled', false);
            }
        });
    });
    
    $('#studentForm').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        $(this).find("input[required], textarea[required]").each(function () {
            $(this).val($(this).val().trim());
        });
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#stuSubmitBtn').prop('disabled', true);
        $.ajax({
            url: "action/actClient.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function () {
                        $('#addStudentModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                        goViewStudent(response.visitId);
                        
                    });
                    // Reset the form after successful submission
                    resetForm('studentForm');
                    $('#stuSubmitBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#stuSubmitBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding Student details.'
                });
                $('#stuSubmitBtn').prop('disabled', false);
            }
        });
    });
    
    $('#studentFormEdit').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        $(this).find("input[required], textarea[required]").each(function () {
            $(this).val($(this).val().trim());
        });
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#stuEditSubmitBtn').prop('disabled', true);
        $.ajax({
            url: "action/actClient.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function () {
                        $('#editStudentModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                        goViewStudent(response.visitId);
                        
                    });
                    // Reset the form after successful submission
                    resetForm('studentFormEdit');
                    $('#stuEditSubmitBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#stuEditSubmitBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating Student details.'
                });
                $('#stuEditSubmitBtn').prop('disabled', false);
            }
        });
    });
});
</script>
<script>
//Function to populate the edit form with the Vendor details for editing.
function goEditClient(clientId) {
    
    $('#submitEditBtn').prop('disabled', false);
    
    $.ajax({
        url: 'action/actClient.php',
        method: 'POST',
        data: {
            clientId_edit : clientId
        },
        dataType: 'json', 
        success: function(response) {
                $('#clientId').val(response.id);
                $('#clientNameEdit').val(response.name);
                $('#phoneEdit').val(response.phone);
                $('#emailEdit').val(response.email);
                $('#locationEdit').val(response.location);
                $('#passwordEdit').val(response.password);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

//Function to populate the view form with the IV details.
function viewIvDetails(clientId) {
    // Show loader before making AJAX request
    $('#loader').show(); // Assume there's an element with id 'loader' for the spinner
    $('#clientTbl').hide(); // Hide the client table
    $('#clientDetails').hide(); // Hide the client details section initially

    $.ajax({
        url: 'action/actClient.php',
        method: 'POST',
        data: {
            clientId_view: clientId
        },
        dataType: 'json',
        success: function(response) {
            // Clear any existing cards before loading new ones
            $('#clientDetails .row').empty();

            if (response.length > 0) {
                // Loop through each client and append the card
                response.forEach(function(client, index) {
                    let statusClass = (client.ivStatus === 'Visited') ? 'text-success' :
                                      (client.ivStatus === 'Upcoming') ? 'text-warning' :
                                      (client.ivStatus === 'Cancelled' || client.ivStatus === 'Rejected') ? 'text-danger' :
                                      'text-dark';
                    var card = `
                        <div class="col">
                            <div class="card">
                                <div class="card-body p-4">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th class="col-4 font-14 text-secondary">Date</th>
                                                <td>:</td>
                                                <td class="text-dark">${client.date}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-4 font-14 text-secondary">Department</th>
                                                <td>:</td>
                                                <td class="text-dark">${client.department}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-4 font-14 text-secondary">Student Count</th>
                                                <td>:</td>
                                                <td class="text-dark">${client.studentCount}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-4 font-14 text-secondary">Staff Count</th>
                                                <td>:</td>
                                                <td class="text-dark">${client.staffCount}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-4 font-14 text-secondary">In-Charge Staff</th>
                                                <td>:</td>
                                                <td class="text-dark">${client.inChargeStaff}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-4 font-14 text-secondary">IV Status</th>
                                                <td>:</td>
                                                <td class="${statusClass}">${client.ivStatus}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4 d-flex justify-content-center">
                                            <button class="btn btn-outline-success w-100" data-bs-toggle="tooltip" title="View Students Details" data-bs-target="#top" onclick="goViewStudent(${client.iv_id});">
                                                <i class="lni lni-eye"></i>
                                            </button>
                                        </div>
                                        <div class="col-4 d-flex justify-content-center">
                                            <button class="btn btn-outline-primary w-100" data-bs-toggle="tooltip" title="View Gallery" data-bs-target="#top" onclick="goViewGallery(${client.iv_id});">
                                                <i class="lni lni-image"></i>
                                            </button>
                                        </div>
                                        <div class="col-4 d-flex justify-content-center">
                                            <button class="btn btn-outline-info w-100" data-bs-toggle="tooltip" title="View Feedback" data-bs-target="#top" onclick="goViewFeedback(${client.iv_id});">
                                                <i class="lni lni-comments"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#clientDetails .row').append(card);
                    $('[data-bs-toggle="tooltip"]').tooltip();
                });

                setupPagination(response);
                $('#pagination-controls').show();
            } else {
                $('#clientDetails .row').html(`
                    <div class="col text-center d-flex justify-content-center">
                        <div class="alert alert-warning p-4" style="border: 1px solid #ffc107; background-color: #fff3cd; border-radius: 8px; max-width: 500px;">
                            <i class="lni lni-warning text-warning mb-2" style="font-size: 30px;"></i>
                            <h5 class="font-weight-bold text-warning">No IV details available</h5>
                            <p class="text-muted">There are currently no IV details available for this client.</p>
                        </div>
                    </div>
                `);
                $('#pagination-controls').hide();
            }

            $('#loader').hide();
            $('#clientDetails').show();
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
            $('#clientDetails .row').html('<div class="col text-center text-danger">Error loading IV details. Please try again.</div>');
            $('#loader').hide();
            $('#pagination-controls').hide();
            $('#clientDetails').show();
        }
    });
}

function setupPagination(data) {
    const itemsPerPage = 3; // Number of items to display per page
    const totalPages = Math.ceil(data.length / itemsPerPage);
    let currentPage = 1;

    function renderPage(page) {
        $('#clientDetails .row').children().hide(); // Hide all cards
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        $('#clientDetails .row').children().slice(start, end).show(); // Show only the current page cards
        $('#pageInfo').text(`Page ${page} of ${totalPages}`); // Update page info
    }

    $('#prevBtn').off('click').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            renderPage(currentPage);
            updateButtonState();
        }
    });

    $('#nextBtn').off('click').on('click', function() {
        if (currentPage < totalPages) {
            currentPage++;
            renderPage(currentPage);
            updateButtonState();
        }
    });

    function updateButtonState() {
        $('#prevBtn').prop('disabled', currentPage === 1);
        $('#nextBtn').prop('disabled', currentPage === totalPages);
    }

    // Initial render
    renderPage(currentPage);
    updateButtonState();
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return `${('0' + date.getDate()).slice(-2)} ${date.toLocaleString('default', { month: 'short' })} ${date.getFullYear()}`;
}

function goViewStudent(studentId) {
    // Show the loader
    $('#loader').show();
    
    $.ajax({
        url: 'action/actClient.php',
        method: 'POST',
        data: {
            studentId_view: studentId  
        },
        dataType: 'json',  
        success: function(response) {
            console.log(response); 
        
            $('#loader').hide();
        
            if (response && response.ivDetails) {
                var ivDetails = response.ivDetails;
                $('#htnVisitId').val(ivDetails.iv_id);
                $('#editVisitId').val(ivDetails.iv_id);
                $('#ivDetailsHeading').text(ivDetails.college_name + ' IV Details');
                let statusClass1 = (ivDetails.iv_status === 'Visited') ? 'text-success' :
                                   (ivDetails.iv_status === 'Upcoming') ? 'text-warning' :
                                   (ivDetails.iv_status === 'Cancelled' || ivDetails.iv_status === 'Rejected') ? 'text-danger' :
                                   'text-dark';
                var formattedDate = formatDate(ivDetails.iv_date);
        
                var ivCardContent = `
                            <div class="row">
                                <!-- First Column -->
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">Date</th>
                                                <td>:</td>
                                                <td class="text-dark">${formattedDate}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">Department</th>
                                                <td>:</td>
                                                <td class="text-dark">${ivDetails.department}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">Academic Year</th>
                                                <td>:</td>
                                                <td class="text-dark">${ivDetails.batch}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">IV Status</th>
                                                <td>:</td>
                                                <td class="${statusClass1}">${ivDetails.iv_status}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- End First Column -->
                
                                <!-- Second Column -->
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">Student Count</th>
                                                <td>:</td>
                                                <td class="text-dark">${ivDetails.stu_count}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">Staff Count</th>
                                                <td>:</td>
                                                <td class="text-dark">${ivDetails.staff_count}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">In-Charge Staff</th>
                                                <td>:</td>
                                                <td class="text-dark">${ivDetails.incharge_name}</td>
                                            </tr>
                                            <tr>
                                                <th class="col-6 font-14 text-secondary">Staff Number</th>
                                                <td>:</td>
                                                <td class="text-dark">${ivDetails.incharge_phone}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- End Second Column -->
                            </div>
                `;
        
                $('#ivFullDetails').html(ivCardContent);
                $('#clientDetails').hide();
                $('#ivDetailsTbl').show(); 
                $('#issueBtn').attr('onclick', `issueAllCertificates(${ivDetails.iv_id})`);
            } else {
                console.error('No ivDetails found.');
            }
        
            var currentPage = $('#example3').DataTable().page();
            if ($.fn.DataTable.isDataTable('#example3')) {
                $('#example3').DataTable().clear().destroy(); // Clear data and destroy previous instance
            }
            $('#example3 tbody').empty(); 
            // Populate Student Details if available
            if (response.students && response.students.length > 0) {
                response.students.forEach(function(student, index) {
                    var studentRow = `
                        <tr>
                            <td>${index + 1}</td> <!-- S. No -->
                            <td>${student.name}</td>
                            <td>${student.phone}</td>
                            <td>${student.email}</td>
                            <td>${student.address}</td>
                            <td>
                                <span data-bs-toggle="tooltip" title="${student.certificate === 'Not Issued' ? 'Certificate Not Issued' : 'Download Certificate'}"><button class="btn btn-sm btn-outline-info" data-bs-target="#top" ${student.certificate === 'Not Issued' ? 'disabled' : ''} onclick="doCertificate(${student.id});"><i class="lni lni-certificate"></i></button></span>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Student" data-bs-target="#top" onclick="goEditStudent(${student.id});"><i class="lni lni-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" data-bs-target="#top" onclick="goDeleteStudent(${student.id}, ${student.visitId});"><i class="lni lni-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    $('#example3 tbody').append(studentRow);
                    $('[data-bs-toggle="tooltip"]').tooltip();
                });
            } else {
                // Do not append anything if no students are available, just leave it empty
            }
        
            // Initialize DataTable after appending new student rows
            var table = $('#example3').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print'],
                destroy: true // Ensure DataTable is destroyable and reinitialized
            });
        
            table.buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
            table.page(currentPage).draw(false);
        },
        error: function(xhr, status, error) {
            // Hide the loader on error
            $('#loader').hide();
            console.error('AJAX request failed:', status, error);
        }
    });
}

function goEditStudent(stuId) {
    
    $('#stuEditSubmitBtn').prop('disabled', false);
    
    $.ajax({
        url: 'action/actClient.php',
        method: 'POST',
        data: {
            stuId_edit : stuId
        },
        dataType: 'json', 
        success: function(response) {
                $('#editStuId').val(response.id);
                $('#studentNameEdit').val(response.name);
                $('#stuPhoneEdit').val(response.phone);
                $('#stuEmailEdit').val(response.email);
                $('#stuLocationEdit').val(response.address);
                $('#editStudentModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

function goDeleteStudent(stuId, visitId) {
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
                url: 'action/actClient.php',  
                method: 'POST',
                data: { delStuId: stuId },  
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
                            goViewStudent(visitId);
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
                        text: 'An error occurred while deleting the Student details.',  
                        icon: 'error', 
                        showConfirmButton: false, 
                        timer: 3000  
                    });
                }
            });
        }
    });
}

function issueAllCertificates(visitId) {
    // Confirmation prompt
    Swal.fire({
        title: 'Are you sure?',
        text: "This will issue all certificates!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, issue all!',  
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to issue all certificates
            $.ajax({
                url: 'action/actClient.php',
                method: 'POST',
                data: { issue_all: visitId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Issued!',
                            text: response.message,
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload the table or data after deletion
                            goViewStudent(visitId);
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
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while issuing certificates.',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
}

function goViewFeedback(visitId) {
    $('#loader').show();

    // Make an AJAX request to fetch feedback for the selected student
    $.ajax({
        url: 'action/actClient.php', // Replace with the correct path to your server-side script
        type: 'POST',
        data: { visitfeedback: visitId }, 
        dataType: 'json',
        success: function(response) {
            var feedbacks = response; // Feedback data from the server
            var lastDate = ''; // For tracking date headers
            $('.chat-content').empty(); // Clear the chat content area
            
            feedbacks.forEach(function(feedback, index) {
                // Format the date and time for each message
                var feedbackDate = new Date(feedback.date_time).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                var feedbackTime = new Date(feedback.date_time).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            
                // Display date header if it's a new date
                if (feedbackDate !== lastDate || index === 0) {
                    lastDate = feedbackDate;
                    var dateHeader = `
                        <div class="chat-date-header text-center text-gray-500 my-2">
                            <span class="px-4 py-2 bg-light rounded">${feedbackDate}</span>
                        </div>
                    `;
                    $('.chat-content').append(dateHeader);
                }
            
                // Alternate the side of each message based on index
                var feedbackMessage;
                if (index % 2 === 0) {
                    // Right-side message
                    feedbackMessage = `
                        <div class="chat-content-rightside mb-2">
                            <div class="d-flex">
                                <div class="flex-grow-1 me-2">
                                    <p class="mb-0 chat-time text-end fs-6">${feedback.name}, ${feedbackTime}</p>
                                    <p class="mb-0 chat-right-msg">${feedback.msg}</p>
                                </div>
                                <img src="${feedback.user_image}" width="48" height="48" class="rounded-circle" alt="" />
                            </div>
                        </div>`;
                } else {
                    // Left-side message
                    feedbackMessage = `
                        <div class="chat-content-leftside mb-2">
                            <div class="d-flex">
                                 <img src="${feedback.user_image}" width="48" height="48" class="rounded-circle" alt="" />
                                <div class="flex-grow-1 ms-2">
                                    <p class="mb-0 chat-time fs-6">${feedback.name}, ${feedbackTime}</p>
                                    <p class="mb-0 chat-left-msg">${feedback.msg}</p>
                                </div>
                            </div>
                        </div>`;
                }
            
                // Append each message to the chat content area
                $('.chat-content').append(feedbackMessage);
            });
            
            // Scroll to the bottom of the chat content
            $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight);
            $('#clientDetails').hide();
            $('#feedbackTbl').show();
            $('#loader').hide();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#loader').hide();
        }
    });
}

function goViewGallery(visitId) {
    
    $('#loader').show();

    $.ajax({
        url: 'action/actClient.php', 
        type: 'POST',
        data: { galleryId: visitId }, 
        dataType: 'json',
        success: function(response) {
            $('#imageGallery').empty();
            
            // Iterate over the images and dynamically create cards
            response.forEach(function(image) {
                var imageCard = `
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm position-relative overflow-hidden gallery-card" style="cursor: pointer;">
                            <!-- Image container -->
                            <div class="d-flex justify-content-center align-items-center position-relative" style="height: 200px;">
                                <img src="${image.url}" class="img-fluid gallery-img" style="object-fit: contain; width: 100%; height: 100%; transition: filter 0.3s ease;">
                                
                                <!-- Hover buttons -->
                                <div class="position-absolute bottom-0 start-50 translate-middle-x hover-buttons d-flex flex-row align-items-center mb-2" style="transition: all 0.3s ease; opacity: 0; top: 100%;">
                                    <a href="${image.url}" target="_blank" class="btn btn-success btn-sm me-4 align-self-center" data-bs-toggle="tooltip" title="View Image"><i class="lni lni-eye"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm align-self-center" onclick="deleteImage(event, ${image.id})" data-bs-toggle="tooltip" title="Delete Image"><i class="lni lni-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                
                // Append the new image card to the gallery
                $('#imageGallery').append(imageCard);
            });
            $('[data-bs-toggle="tooltip"]').tooltip();
            $('#clientDetails').hide();
            $('#galleryTbl').show();
            $('#galVisitId').val(visitId);
            $('#loader').hide();
            $('.gallery-card').hover(function() {
                // Blur only the image inside the hovered card
                $(this).find('.gallery-img').css('filter', 'blur(4px)');
                
                // Show the buttons inside the hovered card
                $(this).find('.hover-buttons').css({
                    'top': '50%',
                    'opacity': '1'
                });
            }, function() {
                // Remove blur from the image inside the card when hover is removed
                $(this).find('.gallery-img').css('filter', 'none');

                // Hide the buttons when hover is removed
                $(this).find('.hover-buttons').css({
                    'top': '100%',
                    'opacity': '0'
                });
            });
        },
        error: function(xhr, status, error) {
            console.error('Error loading images:', error);
            // Hide loader in case of error
            $('#loader').hide();
        }
    });
}

function loadImage(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const validImageTypes = ['image/jpeg', 'image/png'];

    if (!validImageTypes.includes(file.type)) {
        alert('Please upload a JPG or PNG image.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        // Create a new image card
        const imageGallery = document.getElementById('imageGallery'); 
        const newImageCol = document.createElement('div');
        newImageCol.className = 'col-6 col-md-4 col-lg-3 mb-3'; // Add margin at the bottom for spacing
        
        // Prepare form data for AJAX submission
        const formData = new FormData();
        formData.append('image', file);
        formData.append('galVisitId', document.getElementById('galVisitId').value); // Use the value of galVisitId

        // AJAX request to upload image
        fetch('action/actClient.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    return; // Stop further execution if there's an error
                }

                // Use the ID and name from the response
                newImageCol.innerHTML = `
                    <div class="card shadow-sm position-relative overflow-hidden gallery-card" style="cursor: pointer;">
                        <div class="d-flex justify-content-center align-items-center position-relative" style="height: 200px;">
                            <img src="${e.target.result}" class="img-fluid gallery-img" style="object-fit: contain; width: 100%; height: 100%; transition: filter 0.3s ease;">
                            
                            <!-- Hover buttons -->
                            <div class="position-absolute bottom-0 start-50 translate-middle-x hover-buttons d-flex flex-row align-items-center mb-2" style="transition: all 0.3s ease; opacity: 0; top: 100%;">
                                <a href="https://asset.inforiya.in/ERP/ERP_image/IV/${data.name}" target="_blank" class="btn btn-success btn-sm me-4 align-self-center" data-bs-toggle="tooltip" title="View Image"><i class="lni lni-eye"></i></a>
                                <button type="button" class="btn btn-danger btn-sm align-self-center" onclick="deleteImage(event, ${data.id})" data-bs-toggle="tooltip" title="Delete Image"><i class="lni lni-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `;

                // Append the new image card to the gallery
                imageGallery.insertAdjacentElement('afterbegin', newImageCol);
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Add hover effect to show/hide buttons and apply blur to the image
                $(newImageCol).hover(
                    function() {
                        $(this).find('.gallery-img').css('filter', 'blur(4px)');

                        $(this).find('.hover-buttons').css({
                            'top': '50%',
                            'opacity': '1'
                        });
                    },
                    function() {
                        $(this).find('.gallery-img').css('filter', 'none');

                        $(this).find('.hover-buttons').css({
                            'top': '100%',
                            'opacity': '0'
                        });
                    }
                );
            })
            .catch(error => console.error('Error uploading image:', error));
    };

    reader.readAsDataURL(file);
}

function deleteImage(event, imageId) {
    event.preventDefault(); // Prevent default behavior

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
            $.ajax({
                url: 'action/actClient.php',
                method: 'POST',
                data: { delImageId: imageId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            goViewGallery($('#galVisitId').val());
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
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while deleting the image.',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        }
    });
}


</script>
</html>