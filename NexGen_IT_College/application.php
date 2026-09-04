<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");

$selQuery = "SELECT a.*, c.category_name FROM `allenquiry_tbl` AS a LEFT JOIN `enq_category` AS c ON a.enq_category_id = c.enq_category_id WHERE a.status='Active' ORDER BY a.event_id DESC";
$resQuery = mysqli_query($conn, $selQuery);
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
        
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Application Report</h2>

                </div>
                   
            </div>


            <!-- <div class="container mt-4">
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
                    
                </select>
            </div>
        </div>
    </div>
</div> -->


        <!-- Table to display the application report -->
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
                      
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Description</th>
										
									</tr>
								</thead>
							<tbody>
							<?php if ($resQuery && mysqli_num_rows($resQuery) > 0): ?>
							<?php $i = 1; while ($row = mysqli_fetch_assoc($resQuery)): ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo htmlspecialchars($row['name']); ?></td>
									<td><?php echo htmlspecialchars($row['email']); ?></td>
									<td><?php echo htmlspecialchars($row['phone']); ?></td>
									<td><?php echo htmlspecialchars($row['category_name'] ?: $row['enq_category_id']); ?></td>
									<td><?php echo htmlspecialchars($row['description']); ?></td>
								</tr>
							<?php endwhile; ?>
							<?php else: ?>
								<tr><td colspan="6">No applications found.</td></tr>
							<?php endif; ?>
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
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#example2').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print']
    });
    $('#example2').DataTable().buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
});
</script>





   



	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>