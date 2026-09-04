<?php   session_start();
include("../db/dbConnection.php");
include("../url.php");
include("head.php");
?>
<!doctype html>
<html lang="en">

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
				
				

				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Not Recevied Products</p>
										<h4 class="my-1">
										<?php
											$selEmp = " SELECT
                                                            COUNT(*) AS not_received_count
                                                        FROM
                                                            asset_service
                                                        WHERE
                                                            return_date = '0000-00-00' AND
                                                        STATUS
                                                            = 'Active'";
											$resultEmp = $conn->query($selEmp);

											if ($resultEmp) {
												$rowEmp = $resultEmp->fetch_assoc();
												$empCount = $rowEmp['not_received_count'];
												echo $empCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>$34 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-truck"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Repaired Products</p>
										<h4 class="my-1">
										<?php
											$selClient="SELECT
                                                            COUNT(*) AS total_repair_products
                                                        FROM
                                                            asset_product
                                                        WHERE
                                                            asset_status = 'Repair' AND
                                                        STATUS
                                                            = 'Active'";
											$resultClinet = $conn->query($selClient);

											if ($resultClinet) {
												$rowClient = $resultClinet->fetch_assoc();
												$clientCount = $rowClient['total_repair_products'];
												echo $clientCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>$24 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-wrench'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Not Assigned Products</p>
										<h4 class="my-1">
										<?php
											$selProject = " SELECT
                                                                COUNT(*) AS total_notUsed_products
                                                            FROM
                                                                asset_product
                                                            WHERE
                                                                asset_status = 'Not in Use' AND
                                                            STATUS
                                                                = 'Active'";
											$resultProject = $conn->query($selProject);

											if ($resultProject) {
												$rowProject = $resultProject->fetch_assoc();
												$projectCount = $rowProject['total_notUsed_products'];
												echo $projectCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
									</div>
									<div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-package'></i>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

				
				<!--end row-->
				
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->



	<!--start switcher-->
	
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="<?php echo $bootsrapBundle; ?>"></script>
	<!--plugins-->
	<script src="<?php echo $js; ?>"></script>
	<script src="<?php echo $simplebar;?>"></script>
	<script src="<?php echo $mentimenu; ?>"></script>
	<script src="<?php echo $perfectScrolbar;  ?>"></script>
	<script src="<?php echo $charts;  ?>"></script>
	<script src="<?php echo $datatableMin; ?>"></script>
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
	
	<script src="<?php echo $index;?>"></script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>