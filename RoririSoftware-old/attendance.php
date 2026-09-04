<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
//    $selQuery = "SELECT a.*, b.* 
//     FROM client_tbl AS a
//     LEFT JOIN project_tbl as b ON a.client_id=b.client
//     WHERE a.client_status='Active'
//     GROUP BY a.client_id
//     ORDER BY
//     a.client_id DESC";
    
//     $resQuery = mysqli_query($conn , $selQuery); 
    
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
        <?php include("addClients.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Attendance Report</h2>
                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                    <!-- <button type="button" id="addClientBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addClientModal">Add New Clients</button> -->
                    </div>

                </div>
                   
            </div>


            <div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="dateFilter" class="form-label">Date:</label>
                <input type="date" id="dateFilter" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="roleFilter" class="form-label">Role:</label>
                <select id="roleFilter" class="form-select">
                    <option value="">All Roles</option>
                    <option value="Employee">Employee</option>
                    <option value="Trainee">Trainee</option>
                    <!-- Add more roles as needed -->
                </select>
            </div>
        </div>
    </div>
</div>


        <!-- Table to display the attendance report -->
        <div id="loading">Loading attendance data, please wait...</div>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
                      
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                    <th>ID</th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                    <th>Punch In</th>
                                    <th>Punch out</th>
                                    <th>Role</th>
										
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
	<script src="<?php echo $sweetalert; ?>"></script>
        <!-- Include the function.js -->
        <script src="../assets/js/function.js"></script>

     <!-- Initialize tooltips -->
     <script>
		$(document).ready(function() {
			$('#example2').DataTable();
		  } );
	</script>
	<!-- <script>
		$(document).ready(function() {
			var table = $('#example2').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
        });
		} );
</script> -->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize current date and role filter
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(currentDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        let currentRoleFilter = '';

        // Load data initially
        loadAttendanceData(formattedDate, currentRoleFilter);

        // Add event listeners for filters
        document.getElementById('dateFilter').addEventListener('change', function() {
            const selectedDate = this.value;
            loadAttendanceData(selectedDate, currentRoleFilter);
        });

        document.getElementById('roleFilter').addEventListener('change', function() {
            currentRoleFilter = this.value; // Update the role filter
            if (table) {
                applyFilters(); // Apply the role filter to the existing table
            }
        });
    });

    let table;

    function loadAttendanceData(selectedDate, roleFilter) {
        document.getElementById("loading").style.display = 'block';

        fetch(`https://roririmobileapp.roririsoft.com/cms/punchuser/list/?punch_date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("loading").style.display = 'none';

                if ($.fn.DataTable.isDataTable('#example2')) {
                    $('#example2').DataTable().destroy();
                }

                const tableBody = document.querySelector("#example2 tbody");
                tableBody.innerHTML = '';

                if (data.data.results && data.data.results.length > 0) {
                    let i = 1;
                    data.data.results.forEach(record => {
                        const row = `<tr>
                            <td>${i++}</td>
                            <td>${record.user_detail.full_name}</td>
                            <td>${record.punch_date}</td>
                            <td>${record.punch_in}</td>
                            <td>${record.punch_out ? record.punch_out : 'N/A'}</td>
                            <td>${record.user_detail.role}</td>
                        </tr>`;
                        tableBody.innerHTML += row;
                    });

                    // Initialize DataTable with buttons
                    table = $('#example2').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'print']
                    });
                    $('#example2').DataTable().buttons().container()
                        .appendTo('#example2_wrapper .col-md-6:eq(0)');

                    // Apply role filter if set
                    if (roleFilter) {
                        table.columns(5).search(roleFilter).draw();
                    }
                } else {
                    tableBody.innerHTML = `<tr><td colspan="6">No data found for the selected date.</td></tr>`;
                }
            })
            .catch(error => {
                document.getElementById("loading").style.display = 'none';
                console.error('Error fetching attendance records:', error);
                document.querySelector("#example2 tbody").innerHTML = `<tr><td colspan="6">Error loading data.</td></tr>`;
            });
    }

    function applyFilters() {
        const roleFilter = document.getElementById('roleFilter').value;

        table.columns(5).search(roleFilter).draw(); // Filter by role column (index 5)
    }
</script>





   



	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
</body>

</html>