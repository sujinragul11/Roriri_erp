<?php

session_start();

include("../db/dbConnection.php");

include("../url.php");

// Load event / meeting reports
$events = [];
$totalHours = 0;
$evQuery = "SELECT id, category, subcategory, participants, hours, guest, description, place, event_status, event_date
            FROM `event_report_tbl` WHERE status = 'Active' ORDER BY id DESC";
$evResult = mysqli_query($conn, $evQuery);
if ($evResult) {
    while ($evRow = mysqli_fetch_assoc($evResult)) {
        $events[] = $evRow;
        $totalHours += floatval($evRow['hours']);
    }
}

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

        <?php include("eventReportForm.php");?>

		

		<div class="page-wrapper">
		    
	

			<div class="page-content">

                

				

            <div class="page-title-box">

                

                <div class="page-title-right">

                    <h2 class="page-title">Event / Meeting Report</h2>

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
                                    <th >Categoty</th>
                                    <th >Sub Categoty</th>
                                    <th >Participants</th>
                                    <th >Hours</th>
                                    <th >Status</th>
                                    <th >Action</th>
                                </tr>

								</thead>
								<tfoot>
        <tr>
            <th colspan="5" style="text-align:right">Total Hours:</th>
            <th id="totalHours"><?php echo $totalHours; ?></th>
            <th colspan="2"></th> <!-- Empty space for the last columns -->
        </tr>
    </tfoot>

								  <tbody>
       <?php
            $sno = 0;
            foreach ($events as $ev) {
                $sno++;
                $evDate = $ev['event_date'] ? date('d-M-Y', strtotime($ev['event_date'])) : '----';
                $evId = $ev['id'];
        ?>
        <tr>
            <td><?php echo $sno; ?></td>
            <td><?php echo htmlspecialchars($evDate); ?></td>
            <td><?php echo htmlspecialchars($ev['category']); ?></td>
            <td><?php echo htmlspecialchars($ev['subcategory']); ?></td>
            <td><?php echo htmlspecialchars($ev['participants']); ?></td>
            <td><?php echo htmlspecialchars($ev['hours']); ?></td>
            <td><?php echo htmlspecialchars($ev['event_status']); ?></td>
            <td>
                <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewEvent(<?php echo $evId; ?>);">
                    <i class="lni lni-eye"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning" title="Edit" onclick="goEditEvent(<?php echo $evId; ?>);" data-bs-toggle="modal" data-bs-target="#editReportModal">
                    <i class="lni lni-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteEvent(<?php echo $evId; ?>);">
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
    
      var reportTable = $('#example3').DataTable({
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
    });

    // Handle filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        $.fn.dataTable.ext.search = [];
        var dateFrom = $('#startDate').val();
        var dateTo = $('#endDate').val();
        var cat = $('#report_category').val();
        var subcat = $('#report_subcategory').val();
        var status = $('#report_status').val();

        $.fn.dataTable.ext.search.push(function(settings, data) {
            var rowDate = new Date(data[1].trim()).getTime();
            var rowCat = data[2].trim();
            var rowSubcat = data[3].trim();
            var rowStatus = data[6].trim();

            // Status filter (Upcoming / Completed)
            var statusMatch = true;
            if (status) {
                if (status === 'Upcoming') {
                    statusMatch = (rowStatus === 'In Progress');
                } else if (status === 'Completed') {
                    statusMatch = (rowStatus === 'Complete');
                }
            }

            var catMatch = !cat || rowCat === cat;
            var subcatMatch = !subcat || rowSubcat === subcat;

            var dateMatch = true;
            if (dateFrom && rowDate < new Date(dateFrom).getTime()) dateMatch = false;
            if (dateTo && rowDate > new Date(dateTo).getTime()) dateMatch = false;

            return statusMatch && catMatch && subcatMatch && dateMatch;
        });
        reportTable.draw();
    });

    // Handle add form submission
    $('#addDepartment').on('submit', function(event) {
        event.preventDefault();

        var form = this;
        var descriptionContent = document.getElementById('description');
        descriptionContent.value = quill.root.innerHTML.trim();

        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        // Gather participants from select2 multi-select
        var participants = $('#multiple-select-clear-field').val() || [];
        participants = participants.join(', ');

        var eventDate = $('#eventDate').val() || new Date().toISOString().split('T')[0];

        var formData = new FormData(form);
        formData.append('participants', participants);
        formData.append('eventDate', eventDate);

        $('#loader').show();

        $.ajax({
            url: 'action/actEventReport.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                }
            },
            error: function(error) {
                $('#loader').hide();
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            }
        });
    });

    // Handle edit form submission
    $('#editDepartment').on('submit', function(event) {
        event.preventDefault();

        var form = this;
        var descriptionEdit = document.getElementById('descriptionEdit');
        descriptionEdit.value = quillEdit.root.innerHTML.trim();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        var participants = $('#participantsEdit').val() || [];
        participants = participants.join(', ');

        var eventDateEdit = $('#eventDateEdit').val() || new Date().toISOString().split('T')[0];

        var formData = new FormData(form);
        formData.append('participants', participants);
        formData.append('eventDateEdit', eventDateEdit);

        $('#loader').show();

        $.ajax({
            url: 'action/actEventReport.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('AJAX request failed:', status, error);
                console.error('Response:', xhr.responseText);
            }
        });
    });

    
});

$(document).ready(function() {
    // View modal trigger
    $('#viewModal').on('show.bs.modal', function() {
        $('#taskImagesContainer').hide();
    });

    function goViewEvent(id) {
        $('#loader').show();
        $.ajax({
            url: 'action/actEventReport.php',
            method: 'POST',
            data: { viewIdEvent: id },
            dataType: 'json',
            success: function(response) {
                $('#loader').hide();
                $('#viewCategory').text(response.category);
                $('#viewSubcategory').text(response.subcategory);
                $('#viewParticipants').text(response.participants);
                $('#viewHours').text(response.hours);
                $('#viewGuest').text(response.guest);
                $('#viewDescription').html(response.description);
                $('#viewPlace').text(response.place);
                $('#viewDate').text(response.event_date);
                $('#viewStatus').text(response.event_status);
                $('#viewModal').modal('show');
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('View failed:', status, error);
            }
        });
    }

    function goEditEvent(id) {
        $('#editReportId').val(id);
        $('#loader').show();
        $.ajax({
            url: 'action/actEventReport.php',
            method: 'POST',
            data: { viewIdEvent: id },
            dataType: 'json',
            success: function(response) {
                $('#loader').hide();
                $('#categoryEdit').val(response.category);
                $('#subcategoryEdit').val(response.subcategory);
                $('#hoursEdit').val(response.hours);
                $('#guestEdit').val(response.guest);
                $('#placeEdit').val(response.place);
                $('#projectStatusEdit').val(response.event_status);
                $('#eventDateEdit').val(response.event_date ? formatForEdit(response.event_date) : todayStr());

                $('#participantsEdit').val(null).trigger('change');
                var parts = (response.participants || '').split(',').map(function(p){ return p.trim(); }).filter(Boolean);
                $('#participantsEdit').val(parts).trigger('change');

                if (quillEdit) {
                    var decodedContent = decodeHtmlEntities(response.description);
                    quillEdit.root.innerHTML = decodedContent;
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('Edit fetch failed:', status, error);
            }
        });
    }

    function goDeleteEvent(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'You want to delete this Event / Meeting?',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                $('#loader').show();
                $.ajax({
                    url: 'action/actEventReport.php',
                    method: 'POST',
                    data: { deleteIdEvent: id },
                    dataType: 'json',
                    success: function(response) {
                        $('#loader').hide();
                        Swal.fire({
                            icon: response.success ? 'success' : 'error',
                            title: response.message,
                            timer: 1000
                        }).then(function() {
                            if (response.success) { location.reload(); }
                        });
                    },
                    error: function() {
                        $('#loader').hide();
                        alert('Something went wrong.');
                    }
                });
            }
        });
    }

    function decodeHtmlEntities(str) {
        var textArea = document.createElement('textarea');
        textArea.innerHTML = str || '';
        return textArea.value;
    }

    function formatForEdit(dateStr) {
        // Accepts d-M-Y, returns Y-m-d
        if (!dateStr) return todayStr();
        var parts = dateStr.split('-');
        if (parts.length === 3) {
            // try Y-m-d
            if (parts[0].length === 4) return dateStr;
            var months = {Jan:1,Feb:2,Mar:3,Apr:4,May:5,Jun:6,Jul:7,Aug:8,Sep:9,Oct:10,Nov:11,Dec:12};
            var m = months[parts[1]];
            if (m) {
                return parts[2] + '-' + (m < 10 ? '0' + m : m) + '-' + parts[0];
            }
        }
        return todayStr();
    }

    function todayStr() {
        return new Date().toISOString().split('T')[0];
    }

    window.goViewEvent = goViewEvent;
    window.goEditEvent = goEditEvent;
    window.goDeleteEvent = goDeleteEvent;
});
</script>

        <script>
        
  
$(document).ready(function() {
    // Initialize participant multi-select dropdowns
    $('#multiple-select-clear-field').select2({
        placeholder: "Choose participants",
        width: '100%'
    });
    $('#participantsEdit').select2({
        placeholder: "Choose participants",
        width: '100%'
    });

    // Update participant values when selection changes
    $('#multiple-select-clear-field').on('select2:select select2:unselect', function() {
        var vals = $(this).val();
        $('#multiple-select-clear-field').val(vals || []).trigger('change');
    });
});

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

<script src="../assets/js/form-validation.js"></script>
</body>



</html>

