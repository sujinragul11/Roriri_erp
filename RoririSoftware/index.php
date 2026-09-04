<?php
session_start();
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
					    <a href="employee.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Employees</p>
										<h4 class="my-1">
										<?php
											$selEmp = "SELECT count(b.id) as emp_count
                                        FROM basic_details AS b
                                        LEFT JOIN additional_details AS a ON a.basic_id=b.id
                                        LEFT JOIN emp_additional_details AS c ON c.basic_id=b.id 
                                        WHERE a.entity_id=1 AND b.status='Active' AND a.add_status='Active'";
											$resultEmp = $conn->query($selEmp);

											if ($resultEmp) {
												$rowEmp = $resultEmp->fetch_assoc();
												$empCount = $rowEmp['emp_count'];
												echo $empCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>$34 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-id-card"></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					    <a href="clients.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total client</p>
										<h4 class="my-1">
										<?php
											$selClient = "SELECT COUNT(client_id) as client_count FROM client_tbl where client_status='Active'";
											$resultClinet = $conn->query($selClient);

											if ($resultClinet) {
												$rowClient = $resultClinet->fetch_assoc();
												$clientCount = $rowClient['client_count'];
												echo $clientCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>$24 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-user'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					     <a href="project.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Projects</p>
										<h4 class="my-1">
										<?php
											$selProject = "SELECT COUNT(project_id)as project_count FROM project_tbl where status='Active'";
											$resultProject = $conn->query($selProject);

											if ($resultProject) {
												$rowProject = $resultProject->fetch_assoc();
												$projectCount = $rowProject['project_count'];
												echo $projectCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i>$34 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-briefcase'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
					     <a href="enquire.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Project Enquiry</p>
										<h4 class="my-1">
										<?php
											$selEnquire = "SELECT COUNT(enquire_id)as enquire_count FROM `enquire_tbl` WHERE enquire_status='Active'";
											$resultEnquire = $conn->query($selEnquire);

											if ($resultEnquire) {
												$rowEnquire = $resultEnquire->fetch_assoc();
												$enquireCount = $rowEnquire['enquire_count'];
												echo $enquireCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i>12.2% from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-question-mark'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					
						<div class="col">
						    <a href="project.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Ongoing Project</p>
										<h4 class="my-1">
										<?php
											$selEnquire = "SELECT COUNT(project_id) as count_project FROM `project_tbl` WHERE status = 'Active' AND project_status ='In Progress';";
											$resultEnquire = $conn->query($selEnquire);

											if ($resultEnquire) {
												$rowEnquire = $resultEnquire->fetch_assoc();
												$enquireCount = $rowEnquire['count_project'];
												echo $enquireCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i>12.2% from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-question-mark'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					
					
						<div class="col">
						    <a href="project.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Completed Project</p>
										<h4 class="my-1">
										<?php
											$selEnquire = "SELECT COUNT(project_id) as count_project FROM `project_tbl` WHERE status = 'Active' AND project_status ='Completed';";
											$resultEnquire = $conn->query($selEnquire);

											if ($resultEnquire) {
												$rowEnquire = $resultEnquire->fetch_assoc();
												$enquireCount = $rowEnquire['count_project'];
												echo $enquireCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i>12.2% from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-question-mark'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					
					
					<div class="col">
					    <a href="project.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Income for This Month</p>
										<h4 class="my-1">
										<?php
											$selEmp = "SELECT
                                                SUM(amnt_received) AS project_amount
                                            FROM
                                                project_amount
                                            WHERE
                                                pay_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                                                AND pay_date < DATE_FORMAT(
                                                    DATE_ADD(CURDATE(), INTERVAL 1 MONTH),
                                                    '%Y-%m-01'
                                                );";
                                              
											$resultEmp = $conn->query($selEmp);

											if ($resultEmp) {
												$rowEmp = $resultEmp->fetch_assoc();
												$empCount = $rowEmp['project_amount'];
												// Format the amount and add rupee symbol
                                                $formattedAmount = 'â‚¹ ' . number_format($empCount, 2);
                                                echo $formattedAmount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-danger"><i class='bx bxs-down-arrow align-middle'></i>12.2% from last week</p> -->
									</div>
								<div class="text-warning ms-auto font-35"><i class='bx bxs-folder'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
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