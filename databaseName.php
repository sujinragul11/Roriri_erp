<?php
session_start();
include "url.php";
include "db/dbConnection.php";

    
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
        <!-- Modal -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Edit Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="passwordForm" class="row g-3 needs-validation" novalidate>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['username'] ?>" required readonly>
            <div class="invalid-feedback">
              Please provide a Username.
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group" id="show_hide_password">
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $_SESSION['password'] ?>" required>
            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
            </div>
            <div class="invalid-feedback">
              Please provide a Password.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="savePassword">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
		
		<div class="page-wrapper">
			<div class="page-content">
			    
			 <!--   <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">-->
			        
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-primary">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-9.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Petchimuthu</h5>-->
				<!--					<p class="mb-1 text-white">Riya Ias Academy</p>-->
				<!--					<a href="tel:9363701010">-->
    <!--                                <h5 class="mb-0 mt-0 text-white">9363701010</h5>-->
    <!--                                </a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-danger">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-15.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Sheeba</h5>-->
				<!--					<p class="mb-1 text-white">Nexgen It College</p>-->
				<!--					<a href="tel:9994292150">-->
    <!--                                <h5 class="mb-0 mt-0 text-white">9994292150</h5>-->
    <!--                                </a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-warning">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-7.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Mukila</h5>-->
				<!--					<p class="mb-1 text-white">Riya Ias Academy</p>-->
				<!--					<a href="tel:7810012668">-->
				<!--					<h5 class="mb-0 mt-0 text-white">7810012668</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-info">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-8.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Jebastin</h5>-->
				<!--					<p class="mb-1 text-white">Roriri Software Solutions</p>-->
				<!--					<a href="tel:9363980121">-->
				<!--					<h5 class="mb-0 mt-0 text-white">9363980121</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-1 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-primary">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-1.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Asha</h5>-->
				<!--					<p class="mb-1 text-white">Management</p>-->
				<!--					<a href="tel:9677018421">-->
				<!--					<h5 class="mb-0 mt-0 text-white">9677018421</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-danger">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-2.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Prabhavathi</h5>-->
				<!--					<p class="mb-1 text-white">Nexgen It Academy</p>-->
				<!--					<a href="tel:9360759742">-->
				<!--					<h5 class="mb-0 mt-0 text-white">9360759742</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--		<div class="col">-->
				<!--		<div class="card radius-15 bg-info">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-2.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Prabhavathi</h5>-->
				<!--					<p class="mb-1 text-white">------</p>-->
				<!--					<a href="tel:8778528630">-->
				<!--					<h5 class="mb-0 mt-0 text-white">8778528630</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-warning">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-3.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Srinivas</h5>-->
				<!--					<p class="mb-1 text-white">Internship</p>-->
				<!--					<a href="tel:8778265821">-->
				<!--					<h5 class="mb-0 mt-0 text-white">8778265821</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-info">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-4.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Digital Media</h5>-->
				<!--					<p class="mb-1 text-white">Social Media Team</p>-->
				<!--					<a href="tel:7338941579">-->
				<!--					<h5 class="mb-0 mt-0 text-white">7338941579</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-1 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
					
					
				<!--</div>-->
				
				            <div class="page-title-box">

                

                <div class="page-title-right">

                    <h2 class="page-title">Overall Database Report</h2>

                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                     <?php
                        //   $trainerRoles = [6 ,1,2,5,7,3,9,11,12,13,14,15]; // Define the Admin of roles
                        //   if (in_array($_SESSION['role'], $trainerRoles)) 
                        //   {
              ?>

                    <!--<button type="button" id="addEnquireBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addReportModal"><i class="lni lni-plus"></i>New Report</button>-->
                
                <?php
                // }
                ?>
            
                    </div>



                </div>

                   

            </div>
				
				
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<!-- Main DataTable -->
							<div id="databaseList">
							    
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Database Name</th>
                            <th>Actions</th> <!-- New column for the View Tables button -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated here by DataTable -->
                    </tbody>
                </table>
                </div>
                
                <!-- Container for the new table showing database tables -->
                <div id="tablesContainer" style="display: none;">
                     <button id="backButton" class="btn btn-primary mb-3"  onclick="tableBack()">
                            Back
                            </button>
                    <!-- This will be populated with the table data from the selected database -->
                    <table id="tableList" class="table table-striped">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Table Name</th>
                            <th>Actions</th> <!-- New column for the View Tables button -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated here by DataTable -->
                    </tbody>
                </table>
                </div>
                
                 <!-- Container for the new table showing database tables -->
                <div id="dataContainer" style="display: none;">
                        <button id="dataBackBtn" class="btn btn-primary mb-3" style="display: none;" onclick="dataBack()">
        Back
    </button>
    <div id="tableContent"></div>
                </div> <!-- This will hold the table -->

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
	<script src="assets/js/jquery.min.js"></script>
	<!--plugins-->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script src="assets/plugins/select2/js/select2-custom.js"></script>
	<script src="assets/js/app.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="assets/js/index.js"></script>
	<script src="assets/js/editPassword.js"></script>
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
        "ajax": {
            "url": "getDatabase.php", // Replace with actual path to your PHP script
            "type": "GET",
            "dataSrc": "data",
            "data": { "allDb": "allDb" }
        },
        "columns": [
            { "data": 0 }, // Index (serial number)
            { "data": 1 }, // Database Name
            { 
                "data": null, // For the button
                "render": function(data, type, row) {
                    // Dynamically pass the database name to the function
                    return '<button class="btn btn-info view-tables" onclick="dbTable(\'' + row[1] + '\')">View Tables</button>';
                }
            }
        ]
    });

    // Append buttons to DataTable
    // table.buttons().container()
    //     .appendTo('#example2_wrapper .col-md-6:eq(0)');

 
});


   function dbTable(dbName) {
       
        // Check if DataTable is already initialized and destroy it
    if ($.fn.DataTable.isDataTable('#tableList')) {
        $('#tableList').DataTable().destroy(); // Destroy the existing DataTable instance
    }

    // Clear existing table body
    $('#tableList tbody').empty();
    
    // Initialize the DataTable
    var table1 = $('#tableList').DataTable({
        "paging": true,
        "ordering": true,
        "searching": true,
        "lengthChange": false,
        "pageLength": 10, // Set default records per page
        "buttons": ['copy', 'excel', 'pdf', 'print'],
        "ajax": {
            "url": "getDatabase.php", // Path to PHP script
            "type": "GET",
            "dataSrc": "data",
            "data": { "db": dbName } // Send database name to PHP
        },
        "columns": [
            { "data": 0 }, // Index (serial number)
            { "data": 1 }, // Table Name
            { 
                "data": null, // For the button
                "render": function(data, type, row) {
                    // Dynamically pass the table name to another function
                    return '<button class="btn btn-info view-data" onclick="viewData(\'' + row[1] + '\', \'' + dbName + '\')">View Data</button>';
                }
            }
        ]
    });
    // Show the new table
        $('#tablesContainer').show();
        $('#databaseList').hide();

    // Append buttons to DataTable
    // table1.buttons().container()
    //     .appendTo('#tableList_wrapper .col-md-6:eq(0)');
}




function viewData(tableName, dbName) {
    // Example of an AJAX request to fetch table data
    $.ajax({
        url: 'getDatabase.php', // PHP script to fetch table data
        type: 'GET',
        data: { tableDb: dbName, table: tableName },
        success: function(response) {
            // Handle the response and display the data
            var data = JSON.parse(response);
            
            // Check for errors in the response
            if (data.error) {
                alert(data.error);
                return;
            }

            var columns = data.columns;
            var rows = data.data;

            // Create a new HTML table
            var tableHtml = '<table id="TableData" class="table table-bordered"><thead><tr>';

            // Add column headers
            columns.forEach(function(col) {
                tableHtml += '<th>' + col + '</th>';
            });

            tableHtml += '</tr></thead><tbody>';

            // Add data rows
            rows.forEach(function(row) {
                tableHtml += '<tr>';
                columns.forEach(function(col) {
                    tableHtml += '<td>' + row[col] + '</td>';
                });
                tableHtml += '</tr>';
            });

            tableHtml += '</tbody></table>';

            // Insert the table into a div or another element
          // Insert the table into a specific child div (not the entire #dataContainer)
            $('#dataContainer').find('#tableContent').html(tableHtml);

            // Hide the tables container
            $('#tablesContainer').hide();
            $('#dataContainer').show();
             $('#dataBackBtn').show();
            // $('#dataContainer').css('display', 'block');
           // $('#dataBackBtn').css('display', 'block'); // Explicitly make the button visible

            // Initialize DataTable
            $('#TableData').DataTable({
                paging: true,
                ordering: true,
                searching: true,
                lengthChange: true,
                pageLength: 10
               
            });
        },
        error: function(xhr, status, error) {
            alert("Error fetching data: " + error);
        }
    });
}


function tableBack() {
    // Hide the current table or container
    $('#tablesContainer').hide(); // Assuming this is the container for table data
    $('#databaseList').show(); // Show the database list again
    
      // Optionally destroy the DataTable to reset its state when going back
    if ($.fn.DataTable.isDataTable('#tableList')) {
        $('#tableList').DataTable().destroy(); // Destroy DataTable instance
        $('#tableList tbody').empty(); // Clear table body
    }

}

function dataBack() {
    // Hide the current table or container
    $('#dataContainer').hide(); // Assuming this is the container for table data
    $('#tablesContainer').show(); // Show the database list again
    $('#dataBackBtn').hide(); // Show the database list again
    
      // Optionally destroy the DataTable to reset its state when going back
    if ($.fn.DataTable.isDataTable('#TableData')) {
        $('#TableData').DataTable().destroy(); // Destroy DataTable instance
        $('#TableData tbody').empty(); // Clear table body
    }

}


  
</script>
