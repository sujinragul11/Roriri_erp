<?php   session_start(); ?>
<!doctype html>
<html lang="en">

include("../db/dbConnection.php");
include("../url.php");
 include("head.php");?>

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
				
				

				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
					<div class="col">
						<div class="card radius-10">
						    <a href="expenseReport.php?today">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Today Expenses</p>
										<h4 class="my-1">
										<?php
											date_default_timezone_set('Asia/Kolkata');
                                            $currentDate = date('Y-m-d'); 
                                            $selEmp = "SELECT SUM(amount) AS total_amount
                                                       FROM expense_details
                                                       WHERE DATE(date) = '$currentDate' AND status = 'Active'";
											$resultEmp = $conn->query($selEmp);

											if ($resultEmp) {
												$rowEmp = $resultEmp->fetch_assoc();
												$empCount = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency($rowEmp['total_amount'], 'INR');
												echo $empCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>$34 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-dollar-circle"></i>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
						    <a href="expenseReport.php">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Expenses for this Month</p>
										<h4 class="my-1">
										<?php
											$selClient="SELECT SUM(amount) AS total_amount
                                                        FROM expense_details
                                                        WHERE MONTH(date) = MONTH(CURDATE()) 
                                                          AND YEAR(date) = YEAR(CURDATE()) 
                                                          AND status = 'Active';";
											$resultClinet = $conn->query($selClient);

											if ($resultClinet) {
												$rowClient = $resultClinet->fetch_assoc();
												$clientCount = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency($rowClient['total_amount'], 'INR');
												echo $clientCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>$24 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-primary text-primary ms-auto"><i class='bx bxs-calendar'></i>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
						    <a href="expenseReport.php?category=1">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Roriri Software this Month Expenses</p>
										<h4 class="my-1">
										<?php
											$selProject = " SELECT 
                                                                c.`name` AS catname,
                                                                SUM(a.`amount`) AS total_amount
                                                            FROM
                                                                `expense_details` AS a
                                                            LEFT JOIN 
                                                                `expense_subcategory` AS b ON a.`sub_id` = b.`subcat_id`
                                                            LEFT JOIN 
                                                                `expense_category` AS c ON b.`cat_id` = c.`cat_id`
                                                            WHERE
                                                                a.`status` = 'Active'
                                                                AND MONTH(a.`date`) = MONTH(CURDATE())
                                                                AND YEAR(a.`date`) = YEAR(CURDATE())
                                                                AND c.`cat_id` = 1
                                                            GROUP BY 
                                                                c.`cat_id`";
											$resultProject = $conn->query($selProject);

											if ($resultProject) {
												$rowProject = $resultProject->fetch_assoc();
												$projectCount = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency($rowProject['total_amount'], 'INR');
												echo $projectCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
									</div>
									<div class="widgets-icons bg-light-dark text-dark ms-auto"><i class='bx bxs-building-house'></i>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
						    <a href="expenseReport.php?category=2">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">IT Academy this Month Expenses</p>
										<h4 class="my-1">
										<?php
											$selEmp = " SELECT 
                                                            c.`name` AS catname,
                                                            SUM(a.`amount`) AS total_amount
                                                        FROM
                                                            `expense_details` AS a
                                                        LEFT JOIN 
                                                            `expense_subcategory` AS b ON a.`sub_id` = b.`subcat_id`
                                                        LEFT JOIN 
                                                            `expense_category` AS c ON b.`cat_id` = c.`cat_id`
                                                        WHERE
                                                            a.`status` = 'Active'
                                                            AND MONTH(a.`date`) = MONTH(CURDATE())
                                                            AND YEAR(a.`date`) = YEAR(CURDATE())
                                                            AND c.`cat_id` = 2
                                                        GROUP BY 
                                                            c.`cat_id`";
											$resultEmp = $conn->query($selEmp);

											if ($resultEmp) {
												$rowEmp = $resultEmp->fetch_assoc();
												$empCount = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency($rowEmp['total_amount'], 'INR');
												echo $empCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>$34 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="bx bxs-school"></i>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
						    <a href="expenseReport.php?category=3">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">IAS Academy this Month Expenses</p>
										<h4 class="my-1">
										<?php
											$selClient="SELECT 
                                                            c.`name` AS catname,
                                                            SUM(a.`amount`) AS total_amount
                                                        FROM
                                                            `expense_details` AS a
                                                        LEFT JOIN 
                                                            `expense_subcategory` AS b ON a.`sub_id` = b.`subcat_id`
                                                        LEFT JOIN 
                                                            `expense_category` AS c ON b.`cat_id` = c.`cat_id`
                                                        WHERE
                                                            a.`status` = 'Active'
                                                            AND MONTH(a.`date`) = MONTH(CURDATE())
                                                            AND YEAR(a.`date`) = YEAR(CURDATE())
                                                            AND c.`cat_id` = 3
                                                        GROUP BY 
                                                            c.`cat_id`";
											$resultClinet = $conn->query($selClient);

											if ($resultClinet) {
												$rowClient = $resultClinet->fetch_assoc();
												$clientCount = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency($rowClient['total_amount'], 'INR');
												echo $clientCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
										<!-- <p class="mb-0 font-13 text-success"><i class='bx bxs-up-arrow align-middle'></i>$24 from last week</p> -->
									</div>
									<div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-book'></i>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
						    <a href="expenseReport.php?category=4">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Roriri IT Park this Month Expenses</p>
										<h4 class="my-1">
										<?php
											$selProject = " SELECT 
                                                                c.`name` AS catname,
                                                                SUM(a.`amount`) AS total_amount
                                                            FROM
                                                                `expense_details` AS a
                                                            LEFT JOIN 
                                                                `expense_subcategory` AS b ON a.`sub_id` = b.`subcat_id`
                                                            LEFT JOIN 
                                                                `expense_category` AS c ON b.`cat_id` = c.`cat_id`
                                                            WHERE
                                                                a.`status` = 'Active'
                                                                AND MONTH(a.`date`) = MONTH(CURDATE())
                                                                AND YEAR(a.`date`) = YEAR(CURDATE())
                                                                AND c.`cat_id` = 4
                                                            GROUP BY 
                                                                c.`cat_id`";
											$resultProject = $conn->query($selProject);

											if ($resultProject) {
												$rowProject = $resultProject->fetch_assoc();
												$projectCount = (new NumberFormatter('en_IN', NumberFormatter::CURRENCY))->formatCurrency($rowProject['total_amount'], 'INR');
												echo $projectCount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>
										</h4>
									</div>
									<div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-buildings'></i>
									</div>
								</div>
							</div>
							</a>
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