<?php
session_start();
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../db/dbConnection.php");
include("../url.php");   
include("action/function.php");
    
    if(isset($_GET['id']) && $_GET['id'] != '') {
        $empId = $_GET['id'];
    
        // Prepare and execute the SQL query
        $selQuery = "SELECT * FROM `client_tbl` WHERE client_id='$empId'";
        
        $result1 = $conn->query($selQuery);
    
        if($result1) {
            // Fetch employee details
            $row = mysqli_fetch_array($result1 , MYSQLI_ASSOC);
            $id = $row['client_id']; 
			$name=$row['client_name'];
            $compName=$row['client_company'];
            $email=$row['client_email'];
            $phone=$row['client_phone'];
            $address= $row['client_location'];

			
        } else {
            echo "Error executing query: " . $conn->error;
        }
    } else {
        // If employee id is not provided, redirect to employees.php
        header("Location: client.php");
        exit(); // Ensure script stops executing after redirection
    }

?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php include("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				
				<!--end breadcrumb-->
				
				<div class="container">
					<div class="main-body">
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-danger me-auto" onclick="javascript:location.href='clients.php'"><i class='bx bx-arrow-back'></i></button>
                    </div>
						<div class="row">
							
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-sm-2">
												<h6 class="mb-0">Full Name</h6>
											</div>
											<div class="col-sm-4 text-secondary">
											<p class="text-secondary mb-1"><?php echo $name;?></p>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-2">
												<h6 class="mb-0">Company Name</h6>
											</div>
											<div class="col-sm-4 text-secondary">
											<p class="text-secondary mb-1"><?php echo $compName;?></p>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-2">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="col-sm-4 text-secondary">
											<p class="text-secondary mb-1"><?php echo $email;?></p>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-2">
												<h6 class="mb-0">Mobile</h6>
											</div>
											<div class="col-sm-3 text-secondary">
											<p class="text-secondary mb-1"><?php echo $phone;?></p>
											
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-2">
												<h6 class="mb-0">Address</h6>
											</div>
											<div class="col-sm-3 text-secondary">
											<p class="text-secondary mb-1"><?php echo $address;?></p>
											
											</div>
										</div>
										
									</div>
								</div>
								
							</div>
						</div>
					</div><!--End Container-->
					<div class="container">
                    <div class="main-body">
                        <div class="row">
                            <div class="col-12"> 
                                <div class="card">
                                    <div class="card-body">
                                    <div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S. NO</th>
										<th>Date</th>
										<th>Project Name</th>
										<th>Total Amount</th>
										<th>Payment Status</th>
										
									</tr>
								</thead>
								<tbody>
									<?php $selPay="SELECT project_tbl.*,
													client_tbl.*
													FROM project_tbl
													LEFT JOIN client_tbl ON client_tbl.client_id=project_tbl.client
													WHERE client_tbl.client_id='$empId'
													ORDER BY project_tbl.start_date DESC";
										$resPay = mysqli_query($conn , $selPay); 
										$i=1;
										while($rowPay=mysqli_fetch_array($resPay , MYSQLI_ASSOC)){
											$pID=$rowPay['project_id'];
											$amtReceived=$rowPay['client_name'];
											$date=$rowPay['start_date'];
											$project_name=$rowPay['project_name'];
											$status=$rowPay['pay_status'];
											
											$total_pay=$rowPay['total_pay'];
											
											

										
									 ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo formatDate($date); ?></td>
										<td><?php echo $project_name; ?></td>
										<td><i class="lni lni-rupee"><?php echo number_format($total_pay,2); ?></td>
										<td><?php echo $status; ?></td>

										
										
									</tr>
									
									<?php } ?>
									
									
								</tbody>
								
							</table>
						</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!--End Container 2-->
				</div>
			</div> <!--End page-content-->
		</div><!--end page-wrapper-->
			
		<!--end page wrapper -->
		<!--start overlay-->
		 
	</div>
	<!--end wrapper-->


	<!-- search modal -->
    
    <!-- end search modal -->




	<!--start switcher-->
	<?php include("theme.php");?>
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
    <script>
        function goViewEmp(id){
            alert(id);
            location.href = "employeeDetails.php?id="+id;

        }
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
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
	
</body>

</html>