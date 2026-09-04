<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT
                a.assetpro_id,
                b.Subcategory,
                c.category_name,
                a.product_no,
                a.product_name,
                a.description,
                a.buy_date,
                d.vendor_name,
                a.asset_status
            FROM
                `asset_product` AS a
            LEFT JOIN asset_subcategory AS b
            ON
                a.subcat_id = b.subcat_id
            LEFT JOIN asset_category AS c
            ON
                b.assetcate_id = c.assetcate_id
            LEFT JOIN asset_vendor AS d
            ON
                a.vendor_id = d.vendor_id
            WHERE
                a.status = 'Active';";
    
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
        <?php include("formAsset.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline ">Asset List</h2>
                    <div class="d-flex justify-content-end">
                       
                        <!-- Button for Sub Category -->
                        <div class="" id="assetBtn">
                        <button type="button" id="addAssetBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssetModal">
                            <i class="fadeIn animated bx bx-bookmark-plus"></i> Asset
                        </button>
                        </div>
                        <div class="d-none" id="assetBackBtn">
                         <button type="button" id="backBtn" class="btn btn-danger">
                            <i class="bx bx-arrow-back"></i> Back
                        </button>
                        </div>
                    </div>
                </div>
                   
            </div>
                   
            </div>

				<div class="card" id="assetDiv">
					<div class="card-body">
					     <div class="row mb-3">
            <div class="col-md-2">
                <label for="reportStartDate">Start Date</label>
                <input type="date" id="reportStartDate" class="form-control">
                 <span id="startDateError" class="text-danger medium"></span>
            </div>
            <div class="col-md-2">
                <label for="endDate">End Date</label>
                <input type="date" id="endDate" class="form-control">
                  <span id="endDateError" class="text-danger medium"></span>
            </div>
            <div class="col-md-3">
                <label for="vendorFilter">Vendor</label>
                <select id="vendorFilter" class="form-control">
                    <option value="">Select Vendor</option>
                    <!-- Populate vendors dynamically if needed -->
                    <?php 
                    // Example to fetch vendor names
                    $vendorsQuery = "SELECT `vendor_id`, `vendor_name` FROM `asset_vendor` WHERE status ='Active'"; // Update your table name
                    $vendorRes = mysqli_query($conn, $vendorsQuery);
                    while($vendorRow = mysqli_fetch_assoc($vendorRes)) {
                        echo '<option value="' . $vendorRow['vendor_id'] . '">' . $vendorRow['vendor_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="statusFilter">Status</label>
                <select id="statusFilter" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Assigned">Assigned</option>
                    <option value="Not in Use">Not in Use</option>
                    <option value="Repair">Repair</option>
                    <option value="Broken">Broken</option>
                    
                </select>
            </div>
            <div class="col-md-2 mt-3 pt-1">
                <button id="filterBtn" class="btn btn-primary">Filter</button>
                </div>
        </div>
        
						<div class="table-responsive mt-3">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Asset No</th>
                                        <th>Asset Name</th>
										<th>Buy Date</th> 
										<th>Vendor</th> 
										<th>Status</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $assetpro_id          = $row['assetpro_id'];  
                                        $Subcategory          = $row['Subcategory'];   
                                        $category_name        = $row['category_name'];  
                                        $product_no           = $row['product_no'];  
                                        $product_name         = $row['product_name'];
                                        $description          = $row['description'];   
                                        $buy_date             = ($row['buy_date'] === '0000-00-00') ? '' : date('d M Y', strtotime($row['buy_date']));  
                                        $vendor_name          = $row['vendor_name'];
                                        $asset_status         = $row['asset_status'];
                                        $isDisabled           = ($asset_status == 'Broken' || $asset_status == 'Repair') ? 'disabled' : '';

                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo $Subcategory; ?></td>
                      <td><?php echo $category_name; ?></th>
                      <td><?php echo $product_no; ?></td>
                     <td><?php echo $product_name; ?></th>
                     <td><?php echo $buy_date; ?></td>
                      <td><?php echo $vendor_name; ?></td>
                      <td><?php echo $asset_status; ?></td>
                      
                      <td>
                          <button onclick="AssignAssetData(<?php echo $assetpro_id; ?>);" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAssignModal" data-bs-placement="top" title="Assign" <?php echo $isDisabled; ?>><i class="lni lni-plus"></i></button>
                          <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="loadViewAssetData(<?php echo $assetpro_id; ?>);" ><i class="lni lni-eye"></i></button>
                          <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="loadEditAssetData(<?php echo $assetpro_id; ?>);" ><i class="lni lni-pencil"></i></button>
                           <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="History" onclick="history(<?php echo $assetpro_id; ?>)" ><i class="lni lni-user"></i></button>
                      </td>
                    </tr>
                    <?php } ?>   
								</tbody>
							
							</table>
						</div>
					</div>
				</div>
				
				
				
				
				<div class="card d-none" id="assetAssignDiv">
					<div class="container my-4">
                      <!-- Tabs for User List and History -->
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="user-list-tab" data-bs-toggle="tab" data-bs-target="#user-list" type="button" role="tab" aria-controls="user-list" aria-selected="true">List of Users</button>
                        </li>
                        <li class="nav-item" role="presentation">
                        <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">History</button>
                        </li>
                        <li class="nav-item" role="presentation">
                        <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab" aria-controls="service" aria-selected="false">Service History</button>
                        </li>
                      </ul>
                    
                      <!-- Tab Content -->
                      <div class="tab-content" id="myTabContent">
                        <!-- List of Users -->
                        <div class="tab-pane fade show active" id="user-list" role="tabpanel" aria-labelledby="user-list-tab">
                          <div class="row my-3">
                            
                         <div id="allUserReport"></div>
                            
                    
                          </div>
                        </div>
                    
                        <!-- History Section -->
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <div class="table-responsive pt-2">
                                <table id="historyTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Name</th>
                                            <th>Room Name</th>
                                            <th>Assign Date</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be appended here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Service History Section -->
                        <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                            <div class="table-responsive pt-2">
                                <table id="serviceTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Service Date</th>
                                            <th>Description</th>
                                            <th>Return Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be appended here -->
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
            function setTodayMaxDate(inputId) {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById(inputId).setAttribute("max", today);
    }

    setTodayMaxDate('assetDate');
    setTodayMaxDate('editAssetDate');
    setTodayMaxDate('startDate');
    setTodayMaxDate('reportStartDate');
    setTodayMaxDate('endDate');

            
            
        });
        
        // Function to validate date inputs and display error messages
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
        
        
        // Filter button click event
    $('#filterBtn').on('click', function() {
        
        // Validate dates before proceeding with AJAX request
    if (!validateDateInputs()) {
        return; // Stop if validation fails
    }
    
        var reportStartDate = $('#reportStartDate').val();
        var endDate = $('#endDate').val();
        var vendor = $('#vendorFilter').val();
        var status = $('#statusFilter').val();
        

        // Perform AJAX request
        $.ajax({
            url: 'action/actAsset.php', // Update with your server-side script to fetch data
            type: 'GET',
            data: {
                report_start_date: reportStartDate,
                end_date: endDate,
                vendor: vendor,
                status: status
            },
            dataType: 'json',
            success: function(data) {
                
        $('#example2').DataTable().destroy();
        $('#example2 tbody').empty();

                   // Loop through the returned data and append rows to the table
        data.forEach(function(item, index) {
             const rowHTML = `
                <tr>
                    <td>${index + 1}</td> <!-- Serial number -->
                    <td>${item.Subcategory}</td> <!-- Subcategory -->
                    <td>${item.category_name}</td> <!-- Category name -->
                    <td>${item.product_no}</td> <!-- Product number -->
                    <td>${item.product_name}</td> <!-- Product name -->
                    <td>${formatDate(item.buy_date)}</td> <!-- Formatted buy date -->
                    <td>${item.vendor_name}</td> <!-- Vendor name -->
                    <td>${item.asset_status}</td> <!-- Asset status -->
                    <td>
                        <button onclick="AssignAssetData(${item.assetpro_id});" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAssignModal" data-bs-placement="top" title="Assign">
                            <i class="lni lni-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="loadViewAssetData(${item.assetpro_id});">
                            <i class="lni lni-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="loadEditAssetData(${item.assetpro_id});">
                            <i class="lni lni-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="History" onclick="history(${item.assetpro_id});">
                            <i class="lni lni-user"></i>
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
    
    
    
        
        // Helper function to format the date
        function formatDate(dateString) {
            // Return 'N/A' if date is null, undefined, or empty
            if (!dateString) return 'N/A'; 
        
            const date = new Date(dateString);
            
            // Check if the date is valid
            if (isNaN(date.getTime())) return 'N/A'; // If date is invalid, return 'N/A'
        
            // Create an array of month abbreviations
            const monthNames = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            
            const day = String(date.getDate()).padStart(2, '0');
            const month = monthNames[date.getMonth()]; // Get the month abbreviation
            const year = date.getFullYear();
            
            return `${day} ${month} ${year}`; // Format as d-MMM-Y
        }
                
function history(id) {
    $('#assetAssignDiv').removeClass('d-none');
    $('#assetDiv').addClass('d-none');
    $('#assetBackBtn').removeClass('d-none');
    $('#assetBtn').addClass('d-none');
     $('#user-list').addClass('Active');
    
    // Clear previous history data
    $('#allUserReport').empty(); // Clear previous user list
    $('#historyTable tbody').empty(); // Clear previous history data

  
    // Clear the existing content
    $('#allUserReport').empty();
    
    $('#user-list-tab').tab('show'); 
    $('#user-list').addClass('active');
    $('#other-tab').removeClass('active');

    // AJAX call to fetch history data
    $.ajax({
        url: 'action/actAsset.php',
        method: 'GET',
        data: { view_id: id }, // Use view_id to fetch data
        dataType: 'json',
        success: function(data) {
            console.log(data);

            let records = Array.isArray(data) ? data : [data];

            // Create a row container for the cards
            let row = $('<div class="row"></div>');

            // Loop through the records and append each as a card in the row
            records.forEach(function(record) {
                const cardHTML = `
                    <div class="col-lg-4 col-md-6 mb-3" data-id="${record.asign_id}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${record.name}</h5>
                                <p class="card-text">
                                    <strong>User Name:</strong> ${record.username}<br>
                                    <strong>Room Name:</strong> ${record.room_name}<br>
                                    <strong>Assign Date:</strong> ${formatDate(record.asign_start_date)}
                                </p>
                                <button class="btn btn-danger remove-btn" data-id="${record.asign_id}">Remove</button>
                            </div>
                        </div>
                    </div>`;
                
                // Append the card to the row container
                row.append(cardHTML);
            });

            // Append the entire row to the container
            $('#allUserReport').append(row);

            // Attach click event handler for the dynamically generated "Remove" buttons
            $('.remove-btn').click(function() {
                const recordId = $(this).data('id');
                updateEndDate(recordId, $(this).closest('.col-lg-4'));
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });

    // This will fetch the history data whenever the history tab is clicked
    $('#history-tab').off('click').on('click', function() {
        // Make an AJAX call to fetch history data
        $.ajax({
            url: 'action/actAsset.php', // Your endpoint for fetching history data
            method: 'GET',
            data: { history_asset_id: id }, // Corrected data structure
            dataType: 'json',
            success: function(data) {
                // Clear the existing data in the table
                $('#historyTable tbody').empty();
                
                // Loop through the returned data and append rows to the table
                data.forEach(function(item, index) {
                    const rowHTML = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.name}</td>
                            <td>${item.room_name}</td>
                            <td>${formatDate(item.asign_start_date)}</td> <!-- Format start date -->
                            <td>${formatDate(item.asign_end_date)}</td> <!-- Format end date -->
                        </tr>`;
                    
                    $('#historyTable tbody').append(rowHTML);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching history data:', error);
            }
        });
    });
    
    $('#service-tab').off('click').on('click', function() {
        // Make an AJAX call to fetch history data
        $.ajax({
            url: 'action/actAsset.php', 
            method: 'GET',
            data: { service_asset_id: id }, 
            dataType: 'json',
            success: function(data) {
                // Clear the existing data in the table
                $('#serviceTable tbody').empty();
                
                // Loop through the returned data and append rows to the table
                data.forEach(function(item, index) {
                    const rowHTML = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${formatDate(item.service_date)}</td> 
                            <td>${item.description}</td>
                            <td>${formatDate(item.return_date)}</td>
                            <td>${item.amount}</td>
                        </tr>`;
                    
                    $('#serviceTable tbody').append(rowHTML);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching history data:', error);
            }
        });
    });
}


function updateEndDate(recordId, cardElement) {
    $.ajax({
        url: 'action/actAsset.php', // Replace with your endpoint for updating end_date
        method: 'POST',
        data: { id: recordId, end_date: new Date().toISOString().split('T')[0] },
        success: function(response) {
            console.log('End date updated:', response);
            
            // Optionally, remove the card from the UI after update
            cardElement.remove();
        },
        error: function(xhr, status, error) {
            console.error('Error updating end date:', error);
        }
    });
}




        $('#backBtn').on('click', function(){
            
         $('#assetDiv').removeClass('d-none');
         $('#assetAssignDiv').addClass('d-none');
         $('#assetBtn').removeClass('d-none');
         $('#assetBackBtn').addClass('d-none');
         // Clear the history content when navigating back
         $('#user-list').addClass('Active');
         // Clear the existing content
    
    
    
    
    });
    
      $('#addAssetBtn').on('click', function(){
            
          $('#addAssetForm').removeClass('was-validated');
        $('#addAssetForm').addClass('needs-validation');
        $('#addAssetForm')[0].reset(); // Reset the form $('#addCourse').removeClass('was-validated');
    
    });
        
        
    </script>
    
    <script>
    function loadSubCategories(categoryId) {
        if (categoryId) {
            $.ajax({
                url: 'action/actAsset.php',  // Update with the actual URL for your subcategories API
                type: 'GET',
                data: { category_id: categoryId },
                dataType: 'json',
                success: function(response) {
                    // Clear existing subcategory options
                    $('#subCategorySelect').empty().append('<option value="" disabled selected>Select a subcategory</option>');
                    
                    
                    // Populate the subcategory dropdown with the new options
                    $.each(response, function(index, subcategory) {
                        $('#subCategorySelect').append('<option value="' + subcategory.subcat_id + '">' + subcategory.Subcategory + '</option>');
                    
                    });
                },
                error: function() {
                    alert('Failed to load subcategories. Please try again.');
                }
            });
        }
    }
    
    function editLoadSubCategories(categoryId) {
        if (categoryId) {
            $.ajax({
                url: 'action/actAsset.php',  // Update with the actual URL for your subcategories API
                type: 'GET',
                data: { category_id: categoryId },
                dataType: 'json',
                success: function(response) {
                    // Clear existing subcategory options
                    $('#subCategorySelect').empty().append('<option value="" disabled selected>Select a subcategory</option>');
                    
                    
                    // Populate the subcategory dropdown with the new options
                    $.each(response, function(index, subcategory) {
                        $('#editSubCategorySelect').append('<option value="' + subcategory.subcat_id + '">' + subcategory.Subcategory + '</option>');
                    
                    });
                },
                error: function() {
                    alert('Failed to load subcategories. Please try again.');
                }
            });
        }
    }
    
</script>
     <script>
     $(document).ready(function() {
    // Fetch categories when the modal is shown
    $('#addAssetModal').on('show.bs.modal', function() {
        $.ajax({
            url: 'action/actAsset.php', // Replace with your actual URL to fetch categories
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
    
        function loadEditAssetData(assetId) {
            
             $('#editAssetForm').removeClass('was-validated');
        $('#editAssetForm').addClass('needs-validation');
        
    // AJAX call to fetch asset details by assetId
    $.ajax({
        url: "action/actAsset.php",
        method: "GET",
        data: { asset_id: assetId },
        dataType: "json",
        success: function (data) {
            // Populate the edit form with fetched data
            $('#editAssetId').val(data.assetpro_id);
            $('#editCategorySelect').val(data.assetcate_id);

                 // Fetch categories for the dropdown
                $.ajax({
                    url: 'action/actAsset.php',
                    method: 'GET',
                    data: {
                   action: 'getSubCategory' // Fixed syntax: use key-value pair correctly
                         },
                    dataType: 'json',
                    success: function(categories) {
                        let options = '<option value="">Select a Sub Category</option>';
                        categories.forEach(category => {
                            
                            options += `<option value="${category.subcat_id}">${category.Subcategory}</option>`;
                        });
                        $('#editSubCategorySelect').html(options);
                        $('#editSubCategorySelect').val(data.subcat_Id);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching categories:', error);
                    }
                });

            
            $('#editAssetNo').val(data.product_no);
            $('#editAssetName').val(data.product_name);
            $('#editVendorSelect').val(data.vendor_id);
            $('#editStatusSelect').val(data.asset_status);
            $('#editDescription').val(data.description);
            $('#editAssetDate').val(data.buy_date);
            // Show the edit modal
            $('#editAssetModal').modal('show');
        },
        error: function () {
            // Handle errors
            alert("Error fetching asset details.");
        }
    });
}


function loadViewAssetData(assetId) {
    // AJAX call to fetch asset details by assetId
    $.ajax({
        url: "action/actAsset.php",
        method: "GET",
        data: { view_asset_id: assetId },
        dataType: "json",
        success: function (data) {
            // Populate the form fields with fetched data
            // $('#viewAssetId').val(data.assetpro_id);
            $('#viewCategorySelect').val(data.Subcategory); // Optionally fetch category name
            $('#viewSubCategorySelect').val(data.category_name); // Optionally fetch subcategory name
            $('#viewAssetNo').val(data.product_no);
            $('#viewAssetName').val(data.product_name);
            $('#viewVendorSelect').val(data.vendor_name); // Optionally fetch vendor name
            $('#viewStatusSelect').val(data.asset_status);
            $('#viewDescription').val(data.description);
            $('#viewAssetDate').val(data.buy_date);

            // Show the view modal
            $('#viewAssetModal').modal('show');
        },
        error: function () {
            alert("Error fetching asset details.");
        }
    });
}

        
    


//Data Table script 
    </script>
	<script>
		$(document).ready(function() {
			
			var table = $('#historyTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print'],
            });
        
            table.buttons().container()
                .appendTo('#historyTable_wrapper .col-md-6:eq(0)');
                
            var table = $('#serviceTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print'],
            });
        
            table.buttons().container()
                .appendTo('#serviceTable_wrapper .col-md-6:eq(0)');
		  } );
	</script>
	<script>
$(document).ready(function() {
    var table = $('#example2').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print'],
        // Add any other options you need here
    });

    // Append buttons to the DOM
    table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
});
</script>

    <!--Handles the Ajax call-->
<script>
        $(document).ready(function () {





            function resetForm(formId) {
            var form = $('#' + formId)[0];
            form.reset(); // Reset all form fields
        
            // Remove validation classes and feedback messages
            $(form).removeClass('was-validated'); 
            $(form).find('.is-valid, .is-invalid').removeClass('is-valid is-invalid'); 
            $(form).find('.invalid-feedback').hide();
        }
        
        // Reset the form when the close button is clicked
        $('#modalCloseBtn').click(function () {
            resetForm('addClient');
        });

                

</script>
<script>

               // Handle the form submission via AJAX
$('#addAssetForm').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var form = this;
    
    // Check if the form is valid
    if (form.checkValidity() === false) {
        // If the form is invalid, show native HTML5 validation messages
        form.classList.add('was-validated');
        return;
    }

    var formData = new FormData(form);
    $.ajax({
        url: "action/actAsset.php",
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
                    timer: 1500
                }).then(function () {
                    $('#addAssetModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
                 
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

                // Reset the form after successful submission
                resetForm('addAssetForm');
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
                text: 'An error occurred while adding Asset data.'
            });
        }
    });
});

        //--------------Handles edit Clients-----------------------------//

        document.addEventListener('DOMContentLoaded', function() {


                // Handle the form submission via AJAX
                $('#editAssetForm').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission
                    var form = this;
                    // Check if the form is valid
                if (form.checkValidity() === false) {
                    // If the form is invalid, show native HTML5 validation messages
                    form.classList.add('was-validated');
                    return;
                }

                    var formData = new FormData(form);
                    $.ajax({
                        url: "action/actAsset.php",
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
                                    timer: 1500
                                }).then(function () {
                                    $('#editAssetModal').modal('hide'); // Close the modal
                                    $('.modal-backdrop').remove(); // Remove the backdrop
                                   
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
                                text: 'An error occurred while Editing Asset data.'
                            });
                        }
                    });
                });

        });
        
        
        
        //------------------------------------
        
        function AssignAssetData (id){
            
          $('#addAssignForm').removeClass('was-validated');
        $('#addAssignForm').addClass('needs-validation');
        $('#addAssignForm')[0].reset();
        $('#assignAssetId').val(id)
       
        }
        
        
        //add assign form data--------------------------
                       // Handle the form submission via AJAX
$('#addAssignForm').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var form = this;
    
    // Check if the form is valid
    if (form.checkValidity() === false) {
        // If the form is invalid, show native HTML5 validation messages
        form.classList.add('was-validated');
        return;
    }

    var formData = new FormData(form);
    $.ajax({
        url: "action/actAsset.php",
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
                    timer: 1500
                }).then(function () {
                    $('#addAssignModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
                 
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

                // Reset the form after successful submission
                resetForm('addAssignForm');
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
                text: 'An error occurred while adding Assign data.'
            });
        }
    });
});


</script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>