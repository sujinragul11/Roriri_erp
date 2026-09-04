<?php

session_start();

include("../db/dbConnection.php");

include("../url.php");

    $selQuery = "SELECT

                    a.event_id,

                    b.category_name,

                    a.name,

                    a.phone,

                    a.email,

                    a.enquiry_date

                FROM

                    allenquiry_tbl AS a

                LEFT JOIN enq_category AS b

                ON

                    a.enq_category_id = b.enq_category_id

                WHERE

                    a.status = 'Active'";

    

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

        <?php include("formAllEnquiries.php");?>

		

		<div class="page-wrapper">

			<div class="page-content">

                

				

            <div class="page-title-box">

                

                <div class="page-title-right">

                    <h2 class="page-title">All Enquiries</h2>

                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->

                    <button type="button" id="addEnquireBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addEnquireModal"><i class="lni lni-plus"></i>New Enquiry</button>

                    </div>



                </div>

                   

            </div>



				<div class="card">

					<div class="card-body">

						<div class="table-responsive">
						    
						  
                        <select id="recordsPerPage" class="form-control" style="display: inline-block; width: auto;">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="-1">All</option> <!-- Display all records -->
                        </select>
						    <!-- Filter Form -->
               <form id="filterForm" novalidate class="needs-validation">
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
                            <label for="Filter_category">Category:</label>
                            <select id="Filter_category" class="form-control">
                                <option value="">-- Select --</option>
                                <?php
                                    // Populate categories from the database
                                    $categories = mysqli_query($conn, "SELECT * FROM enq_category");
                                    while ($cat = mysqli_fetch_assoc($categories)) {
                                        echo "<option value='{$cat['category_name']}'>{$cat['category_name']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 mt-3">
                            <button type="button" class="btn btn-primary" onclick="filterTable()">Filter</button>
                        </div>
                    </div>
                </form>

							<table id="example2" class="table table-striped table-bordered">

								<thead>

									<tr>

                                        <th>S. No</th>

										<th>Name</th>

                                        <th>Phone</th>

                                        <th>Email</th>

                                        <th>Category</th>

										<th>Date</th>

										<th>Action</th>

										

									</tr>

								</thead>

								  <tbody>
        <?php $i = 1; while($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) { 
            $event_id = $row['event_id'];  
            $enq_category_name = $row['category_name'];   
            $name = $row['name'];  
            $email = $row['email'];  
            $phone = $row['phone'];
            $enquiry_date = date('d-m-Y', strtotime($row['enquiry_date']));
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($name); ?></td>
            <td><?php echo htmlspecialchars($phone); ?></td>
            <td><?php echo htmlspecialchars($email); ?></td>
            <td><?php echo htmlspecialchars($enq_category_name); ?></td>
            <td><?php echo htmlspecialchars($enquiry_date); ?></td>
            <td>
                <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewEnquire(<?php echo $event_id; ?>);">
                    <i class="lni lni-eye"></i>
                </button> 
                <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditEnquire(<?php echo $event_id; ?>);" data-bs-toggle="modal" data-bs-target="#editEnquireModal">
                    <i class="lni lni-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteEnquire(<?php echo $event_id; ?>);">
                    <i class="lni lni-trash"></i>
                </button>
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
    $(document).ready(function() {
        // Set the enquiry date to today's date
        const today = new Date().toISOString().split("T")[0];
        $("#enquiryDate").attr("value", today);
    });
        function goViewEnquire(eventId) {
    // Show the modal
    $('#viewEnquireModal').modal('show');

    // Clear previous content and show loading spinner
    $('#clientDetailsContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

    // AJAX request to fetch client details
    $.ajax({
        url: 'action/actAllEnquiry.php', // PHP file to handle request
        method: 'POST',
        data: { event_id: eventId },
        dataType: 'json',
        success: function(response) {
            if (response) {

                showEnquiryDetails(response);

                // $('#clientDetailsContent').html(clientDetailsHtml);
            } else {
                // $('#clientDetailsContent').html('<div class="alert alert-danger">Error loading client details.</div>');
            }
        },
        error: function() {
            $('#clientDetailsContent').html('<div class="alert alert-danger">An error occurred while fetching the details.</div>');
        }
    });
}


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



function filterTable() {
    // Get the filter values
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;
    var category = document.getElementById('Filter_category').value;
    
    // Validation: Check that endDate is not before startDate
    if (startDate && endDate && endDate < startDate) {
        alert('End date cannot be before the start date.');
        return; // Stop the function if the dates are invalid
    }

    // Perform the AJAX call
    $.ajax({
        url: 'action/actAllEnquiry.php', // PHP script that handles filtering
        type: 'POST',
        data: {
            startDate: startDate,
            endDate: endDate,
            category: category
        },
        success: function(response) {
            setTimeout(function() {
                // Destroy the existing DataTable first
                if ($.fn.DataTable.isDataTable('#example2')) {
                    $('#example2').DataTable().destroy();
                }
            
                // Replace the table body with the filtered results
                $('#example2 tbody').html(response);
            
                // Re-initialize DataTable with the desired settings
                $('#example2').DataTable({
                    "paging": true,      // Enable pagination
                    "ordering": true,    // Enable sorting
                    "searching": true    // Enable searching
                });
            }, 300);
            
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
}




// Example function to populate the modal with data
function showEnquiryDetails(data) {
    document.getElementById('viewName').innerText = data.name;
    document.getElementById('viewPhone').innerText = data.phone;
    document.getElementById('viewEmail').innerText = data.email;
    document.getElementById('viewCategory').innerText = data.category_name;
    document.getElementById('viewEnquiryDate').innerText = data.enquiry_date;
    document.getElementById('viewDescription').innerText = data.description;
    document.getElementById('viewAddress').innerText = data.location;
    document.getElementById('viewFollowupDate').innerText = data.follow_up;
    document.getElementById('viewFollowStatus').innerText = data.follow_status;
    document.getElementById('viewComments').innerText = data.comment;

    // Conditional display logic
    if (data.category_name == 'Internship') {

        document.getElementById('internshipFields').style.display = 'block';
        document.getElementById('viewInternCollegeName').innerText = data.internCollegeName;
        document.getElementById('viewInternPassedOutYear').innerText = data.internPassedOutYear;
        document.getElementById('viewInternDegree').innerText = data.internDegree;

       
    } else if(data.category_name == 'Nexemy' || data.category_name == 'Nexgen IT Academy'){
        document.getElementById('NexemyFields').style.display = 'none';
        document.getElementById('viewNexemyCourseNmae').innerText = data.academy_course;
        document.getElementById('viewNexemyDurarion').innerText = data.duration;
        document.getElementById('viewMode').innerText = data.mode;
    }else {

        if (data.experience == 'experienced') {
        document.getElementById('experiencedFields').style.display = 'block';
        document.getElementById('viewCompanyName').innerText = data.previous_company;
        document.getElementById('viewRole').innerText = data.role;
        document.getElementById('viewCTC').innerText = data.ctc;
    } else {
         document.getElementById('fresherFields').style.display = 'block';
        document.getElementById('viewCollegeName').innerText = data.college_name;
        document.getElementById('viewPassedOutYear').innerText = data.passed_out;
        document.getElementById('viewDegree').innerText = data.degree;
    }

    }

    if (data.isExperienced) {
        document.getElementById('experiencedFields').style.display = 'block';
        document.getElementById('viewCompanyName').innerText = data.companyName;
        document.getElementById('viewRole').innerText = data.role;
        document.getElementById('viewCTC').innerText = data.ctc;
    } else {
        document.getElementById('experiencedFields').style.display = 'none';
    }

    if (data.isInternship) {
        document.getElementById('internshipFields').style.display = 'block';
        document.getElementById('viewInternCollegeName').innerText = data.internCollegeName;
        document.getElementById('viewInternPassedOutYear').innerText = data.internPassedOutYear;
        document.getElementById('viewInternDegree').innerText = data.internDegree;
    } else {
        document.getElementById('internshipFields').style.display = 'none';
    }
}

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

        

function goEditEnquire(id) 

  

  {

    $.ajax({

        url: 'action/actAllEnquiry.php',

        method: 'POST',

        data: {

            editIdEnquire: id

        },

        dataType: 'json', // Specify the expected data type as JSON

        success: function(response) {

			



          $('#enquiryId').val(response.event_id);

          $('#editName').val(response.name);

          $('#editPhone').val(response.phone);

          $('#editEmail').val(response.email);

          $('#editCategory').val(response.enq_category_id);

          $('#editEnquiryDate').val(response.enquiry_date);

          $('#editExperienceType').val(response.experience);
          $('#editDescription').val(response.description);
          $('#editAddress').val(response.location);
          $('#editFollowUpDate').val(response.follow_up);
          $('#editFollowStatus').val(response.follow_status);
          $('#editComments').val(response.comment);
          $('#editCollegeName').val(response.college_name);
          $('#editPassedOutYear').val(response.passed_out);
          $('#editDegree').val(response.degree);
          $('#editCompanyName').val(response.previous_company);
          $('#editRole').val(response.role);
          $('#editCTC').val(response.ctc);
          $('#editCollegeNameInternship').val(response.college_name);
          $('#editPassedOutYearInternship').val(response.passed_out);
          $('#editDegreeInternship').val(response.degree);

          $('#edit_course_name').val(response.academy_course);
          $('#edit_course_duration').val(response.duration);
          $('#edit_course_mode').val(response.mode);

            // Hide all experience/internship sections initially
    $('#internship_fields_edit').hide();
    $('#fresher_fields_edit').hide();

    // Show specific sections based on the category ID
    if (response.enq_category_id == 3) { // For Internship
        $('#internship_fields_edit').show();
    } else if (response.enq_category_id == 4 || response.enq_category_id == 5) { // For Fresher
        $('#nexgen_nexemy_fields_edit').show();
    } else { // For Fresher
        $('#career_guidance_jobathon_fields_edit').show();
        if(response.experience == 'fresher'){
            $('#fresher_fields_edit').show();
        } else if(response.experience == 'experienced') {
            
            $('#experienced_fields_edit').show();
        }
        
    }


          

		  

   

        },

        error: function(xhr, status, error) {

            // Handle errors here

            console.error('AJAX request failed:', status, error);

        }

    });

}
function goDeleteEnquire(id) {
    // Confirm deletion
    if (confirm("Are you sure you want to delete Enquire?")) {
        // Disable the button to prevent double-clicking
        const deleteButton = $(this); // Reference to the button or element that triggered this function
        deleteButton.prop('disabled', true); // Disable the button

        $.ajax({
            url: 'action/actAllEnquiry.php',
            method: 'POST',
            data: {
                deleteId: id
            },
            success: function(response) {
                // Check for the success property in the response
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#addEnquireModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop

                        setTimeout(function() {
                            $('#example2').load(location.href + ' #example2 > *', function() {
                                $('#example2').DataTable().destroy();

                                $('#example2').DataTable({
                                    "paging": true, // Enable pagination
                                    "ordering": true, // Enable sorting
                                    "searching": true // Enable searching
                                });
                            });
                        }, 300);
                    });
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
                // Handle errors here
                console.error('AJAX request failed:', status, error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error processing your request. Please try again.'
                });
            },
            complete: function() {
                // Re-enable the button after the AJAX request completes
                deleteButton.prop('disabled', false);
            }
        });
    }
}



//Data Table script 

    </script>

	<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#example2').DataTable({
        "paging": true,
        "ordering": true,
        "searching": true,
        "lengthChange": false,
        "pageLength": 10, // Set default records per page
        "buttons": ['copy', 'excel', 'pdf', 'print'],
    });

    // Append buttons to DataTable
    table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');

    // Change records per page based on dropdown selection
    $('#recordsPerPage').on('change', function() {
        var pageLength = $(this).val();
        table.page.len(pageLength).draw(); // Change the number of records displayed
    });
});
	</script>

<script>
$(document).ready(function() {
    $('#addClient').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Check form validity
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        var submitButton = $(this).find('button[type="submit"]'); // Get the submit button

        // Disable the submit button to prevent double click
        submitButton.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: 'action/actAllEnquiry.php', 
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                // Re-enable the submit button on success
                submitButton.prop('disabled', false);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#addEnquireModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop

                        setTimeout(function() {
                            $('#example2').load(location.href + ' #example2 > *', function() {
                                $('#example2').DataTable().destroy();

                                $('#example2').DataTable({
                                    "paging": true, // Enable pagination
                                    "ordering": true, // Enable sorting
                                    "searching": true // Enable searching
                                });
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
            error: function(jqXHR, textStatus, errorThrown) {
                // Re-enable the submit button on error
                submitButton.prop('disabled', false);
                console.error('Error occurred: ' + textStatus, errorThrown);
                alert('There was an error submitting your enquiry. Please try again.'); 
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {

    $('#editEnquiry').on('submit', function(e) {

        e.preventDefault(); // Prevent the default form submission

        var $submitButton = $(this).find('button[type="submit"]');
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        // Disable the submit button to avoid double clicks
        $submitButton.prop('disabled', true);

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'action/actAllEnquiry.php', 
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function () {
                        $('#editEnquireModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop

                        setTimeout(function () {
                            $('#example2').load(location.href + ' #example2 > *', function() {
                                $('#example2').DataTable().destroy();
                                $('#example2').DataTable({
                                    "paging": true, // Enable pagination
                                    "ordering": true, // Enable sorting
                                    "searching": true // Enable searching
                                });
                            });
                        }, 300);
                    });

                    // Reset the form after successful submission
                    resetForm('editEnquiry ');

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }

                // Re-enable the submit button after the AJAX call is complete
                $submitButton.prop('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error occurred: ' + textStatus, errorThrown);
                alert('There was an error submitting your enquiry. Please try again.'); 

                // Re-enable the submit button if an error occurs
                $submitButton.prop('disabled', false);
            }
        });
    });

});
</script>

    

    <script>

        $(document).ready(function () {

            $(".category-fields, .experience-fields").hide();

    

            $('#category').change(function () {

                var selectedCategory = $(this).val();

                console.log("Selected Category:", selectedCategory); 

    

                $(".category-fields").hide();

                $(".experience-fields").hide(); 

                $("#fresher_fields, #experienced_fields").hide(); 

        

                if (selectedCategory === "3") {  // Internship

                    $("#internship_fields").show();

                    $("#career_guidance_jobathon_fields").hide();

                    $('#experience_type').removeAttr("required");

                } else if (selectedCategory === "4" || selectedCategory === "5") {  // NexGen Nexemy

                    $("#nexgen_nexemy_fields").show();

                    $("#career_guidance_jobathon_fields").hide();

                    $('#experience_type').removeAttr("required");

                } else {  // For other categories

                    $("#career_guidance_jobathon_fields").show();

                }

            });

    

            $('#experience_type').change(function () {

                var experienceType = $(this).val();

                console.log("Experience Type:", experienceType); 

    

                $(".experience-fields").hide();

                $("#fresher_fields, #experienced_fields").hide(); 

        

                if (experienceType === "fresher") {

                    $("#fresher_fields").show();

                } else if (experienceType === "experienced") {

                    $("#experienced_fields").show();

                }

            });



        });

    </script>

<script>

$(document).ready(function () {

    $(".category-fields, .experience-fields").hide();



    $('#editCategory').change(function () {

        var selectedCategory = $(this).val();

        console.log("Selected Category:", selectedCategory); 



        $(".category-fields").hide();

        $(".experience-fields").hide(); 

        $("#fresher_fields_edit, #experienced_fields_edit").hide(); 



        if (selectedCategory === "3") {  // Internship

            $("#internship_fields_edit").show();

            $("#career_guidance_jobathon_fields_edit").hide();

            $('#editExperienceType').removeAttr("required");

        } else if (selectedCategory === "4" || selectedCategory === "5") {  // NexGen Nexemy

            $("#nexgen_nexemy_fields_edit").show();

            $("#career_guidance_jobathon_fields_edit").hide();

            $('#editExperienceType').removeAttr("required");

        } else {  // For other categories

            $("#career_guidance_jobathon_fields_edit").show();

        }

    });



    $('#editExperienceType').change(function () {

        var experienceType = $(this).val();

        console.log("Experience Type:", experienceType); 



        $(".experience-fields").hide();

        $("#fresher_fields_edit, #experienced_fields_edit").hide(); 



        if (experienceType === "fresher") {

            $("#fresher_fields_edit").show();

        } else if (experienceType === "experienced") {

            $("#experienced_fields_edit").show();

        }

    });


});

</script>





	<!--app JS-->

	<script src="<?php echo $app; ?>"></script>

<script src="../assets/js/form-validation.js"></script>
</body>



</html>

