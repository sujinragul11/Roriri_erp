<?php
session_start();
include "../db/dbConnection.php";
include "../url.php";

$week_1 = "SELECT COUNT(*) AS student_count FROM `internship_tbl` WHERE duration = '1 Week' AND `status` ='Active' AND intern_id !=5";
$week_2 = "SELECT COUNT(*) AS student_count FROM `internship_tbl` WHERE duration = '2 Week' AND `status` ='Active' AND intern_id !=5";
$month_1 = "SELECT COUNT(*) AS student_count FROM `internship_tbl` WHERE duration = '1 Month' AND `status` ='Active' AND intern_id !=5";
$month_3 = "SELECT COUNT(*) AS student_count FROM `internship_tbl` WHERE duration = '3 Month' AND `status` ='Active' AND intern_id !=5";
$income = "SELECT SUM(inter_amount) AS total_amount , MONTHNAME(CURDATE()) AS month_name
FROM `intern_payment` WHERE `status` = 'Active' AND YEAR(`received_date`) = YEAR(CURDATE()) AND MONTH(`received_date`) = MONTH(CURDATE());"; // Fixed single quote

$enquiry = "SELECT COUNT(*) as enquiry FROM `Intern_enquiry` WHERE `status` ='Active';";
$total_rev = "SELECT SUM(inter_amount) AS total_amount FROM `intern_payment` WHERE `status` = 'Active';";
$con_active = "SELECT COUNT(*) as con FROM `internship_tbl` WHERE `status`='Active' AND intern_id !=5;";
$con_complete = "SELECT COUNT(*) as con FROM `internship_tbl` WHERE `status`='Inactive';";
$course_total = "SELECT COUNT(*) as course FROM `inter_course_tbl` WHERE `status`='Active';";

$con_online = "SELECT COUNT(*) as con FROM `internship_tbl` WHERE `mode` = 'Online' AND `status` = 'Active' AND intern_id !=5;";
$con_offline = "SELECT COUNT(*) as con FROM `internship_tbl` WHERE `mode` = 'Offline' AND `status` = 'Active' AND intern_id !=5;";
$enquiry_month = "SELECT COUNT(*) AS enquiry_count FROM `Intern_enquiry`WHERE `status` = 'Active' AND YEAR(`enq_date`) = YEAR(CURDATE()) AND MONTH(`enq_date`) = MONTH(CURDATE());";


		// Execute the query
$week_1_result = mysqli_query($conn, $week_1);
$week_2_result = mysqli_query($conn, $week_2);
$month_1_month = mysqli_query($conn, $month_1);
$month_3_result = mysqli_query($conn, $month_3);
$income_result = mysqli_query($conn, $income);
$enquiry_result = mysqli_query($conn, $enquiry);
$total_rev_res = mysqli_query($conn, $total_rev);
$con_active_res = mysqli_query($conn, $con_active);
$con_complete_res = mysqli_query($conn, $con_complete);
$course_total_res = mysqli_query($conn, $course_total);
$con_online_res = mysqli_query($conn, $con_online);
$con_offline_res = mysqli_query($conn, $con_offline);
$enquiry_month_res = mysqli_query($conn, $enquiry_month);


$row_1 = mysqli_fetch_assoc($week_1_result);
$row_2 = mysqli_fetch_assoc($week_2_result);
$row_3 = mysqli_fetch_assoc($month_1_month);
$row_4 = mysqli_fetch_assoc($month_3_result);
$row_5 = mysqli_fetch_assoc($income_result);
$row_6 = mysqli_fetch_assoc($enquiry_result);
$row_7 = mysqli_fetch_assoc($total_rev_res);
$row_8 = mysqli_fetch_assoc($con_active_res);
$row_9 = mysqli_fetch_assoc($con_complete_res);
$row_10 = mysqli_fetch_assoc($course_total_res);
$row_11 = mysqli_fetch_assoc($con_online_res);
$row_12 = mysqli_fetch_assoc($con_offline_res);
$row_13 = mysqli_fetch_assoc($enquiry_month_res);


$week1 = $row_1['student_count'];
$week2 = $row_2['student_count'];
$week3 = $row_3['student_count'];
$week4 = $row_4['student_count'];

$total_amount = number_format($row_5['total_amount'], 2, '.', ',');
$total_amount_month = $row_5['month_name'];

$enq = $row_6['enquiry'];
$total_rev_total = number_format($row_7['total_amount'], 2, '.', ',');
$active_con = $row_8['con'];
$inactive_con = $row_9['con'];
$total_course = $row_10['course'];
$online_con = $row_11['con'];
$offline_con = $row_12['con'];
$count_enq = $row_13['enquiry_count'];

?>

<!doctype html>
<html lang="en">

<?php include "head.php";?>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<?php include "internshipLeft.php";?>
		<!--end sidebar wrapper -->
		<!--start header -->
		<?php include "top.php";?>
		<!--end header -->
		<!--start page wrapper -->

		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<!-- Facebook Card -->
					<div class="col-md-4">
					    <a href="listOfInternship.php">
						<div class="card fb-card">
							<div class="card-header" style="background-color: #008cff;">
								<!-- <i class="icofont icofont-social-facebook"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Week</h5>
									<span style="color: #ffff;">Joining as an Internship</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
										<h2><?php echo $week1 ?></h2>
										<p class="text-muted">1 Week</p>
									</div>
									<div style="border: 1px solid #e1e1e1; height: 75px;"></div>
									<div class="col-6">
										<h2><?php echo $week2 ?></h2>
										<p class="text-muted">2 Week</p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<!-- Dribbble Card -->
					<div class="col-md-4">
					    <a href="listOfInternship.php">
						<div class="card dribble-card">
							<div class="card-header" style="background-color: #008cff">
								<!-- <i class="icofont icofont-social-dribbble"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Overall</h5>
									<span style="color: #ffff;">Joining as an Internship</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
										<h2><?php echo $week3 ?></h2>
										<p class="text-muted">1 month</p>
									</div>
									<div style="border: 1px solid #e1e1e1; height: 75px;"></div>
									<div class="col-6">
										<h2><?php echo $week4 ?></h2>
										<p class="text-muted">3 month</p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					
					<?php
                 

                  if ($_SESSION['is_admin'] === 'True') { ?>
						
					<!-- Twitter Card -->
					<div class="col-md-4">
						<div class="card twitter-card">
							<div class="card-header" style="background-color: #f98f1e;">
								<!-- <i class="icofont icofont-social-twitter"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Total</h5>
									<span style="color: #ffff;">Total amount for this <?php echo $total_amount_month ?> month</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div class="row"
									style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
									    <a href="paymentReport.php">
										<h2><?php echo "â‚¹" . $total_amount; ?></h2>
										<p class="text-muted">Revenue</p>
										</a>
									</div>
									<!-- <div class="col-6">
							  <h2>450+</h2>
							  <p class="text-muted">Followers</p>
							</div> -->
								</div>
							</div>
						</div>
					</div>
					
			
					<?php } ?>
					
						<!-- Twitter Card -->
						
						
						
						<div class="col-md-4">
						    <a href="internEnquiry.php">
						<div class="card dribble-card">
							<div class="card-header" style="background-color: #008cff">
								<!-- <i class="icofont icofont-social-dribbble"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Total Enquiry</h5>
									<span style="color: #ffff;">Total Enquiry for this Month / Overall</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
										<h2><?php echo $enq ?></h2>
										<p class="text-muted">Total Enquiry</p>
									</div>
									<div style="border: 1px solid #e1e1e1; height: 75px;"></div>
									<div class="col-6">
										<h2><?php echo $count_enq ?></h2>
										<p class="text-muted">Month Enquiry</p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
						
				
					
					
					
				
					
					
					
						<!-- Twitter Card -->
					<div class="col-md-4">
						<div class="card fb-card">
							<div class="card-header" style="background-color: #008cff;">
								<!-- <i class="icofont icofont-social-facebook"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Candidates</h5>
									<span style="color: #ffff;">Joining as an Internship</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
					                    <a href="listOfInternship.php">
										<h2><?php echo $active_con ?></h2>
										<p class="text-success">Active</p>
										</a>
									</div>
									<div style="border: 1px solid #e1e1e1; height: 75px;"></div>
									<div class="col-6">
					                    <a href="listOfInternship.php?active_status=Completed">
										<h2><?php echo $inactive_con ?></h2>
										<p class="text-danger">Completed</p>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					 <?php

                  if ($_SESSION['is_admin'] === 'True') { ?>
						
						<!-- Twitter Card -->
					<div class="col-md-4">
						<div class="card twitter-card">
							<div class="card-header" style="background-color: #f98f1e;">
								<!-- <i class="icofont icofont-social-twitter"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Overall Income</h5>
									<span style="color: #ffff;">Overall Income from Intern</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div class="row"
									style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
									    <a href="paymentReport.php">
										<h2><?php echo "â‚¹" . $total_rev_total; ?></h2>
										<p class="text-muted">Revenue</p>
										</a>
									</div>
							
								</div>
							</div>
						</div>
					</div>
					
					<?php } ?>
					
						<!-- Twitter Card -->
					<div class="col-md-4">
					    <a href="internCourse.php">
						<div class="card twitter-card">
							<div class="card-header" style="background-color: #008cff;">
								<!-- <i class="icofont icofont-social-twitter"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Total Course</h5>
									<!--<span style="color: #ffff;">Total amount for this month</span>-->
								</div>
							</div>
							<div class="card-block text-center">
								<div class="row"
									style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
										<h2><?php echo $total_course; ?></h2>
										<p class="text-muted">Course</p>
									</div>
									<!-- <div class="col-6">
							  <h2>450+</h2>
							  <p class="text-muted">Followers</p>
							</div> -->
								</div>
							</div>
						</div>
						</a>
					</div>
					
					
						<!-- Twitter Card -->
					<div class="col-md-4">
					    
						<div class="card fb-card">
							<div class="card-header" style="background-color: #008cff;">
								<!-- <i class="icofont icofont-social-facebook"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Mode Of Candidates</h5>
									
								</div>
							</div>
							<div class="card-block text-center">
								<div style="display: flex; justify-content: center; align-items: center; padding: 8px;">
								    
									<div class="col-6 b-r-default">
									    <a href="listOfInternship.php?dash_status=Online">
										<h2><?php echo $online_con ?></h2>
										<p class="text-success">Online</p>
										</a>
									</div>
									
									<div style="border: 1px solid #e1e1e1; height: 75px;"></div>
									
									<div class="col-6">
									    <a href="listOfInternship.php?dash_status=Offline">
										<h2><?php echo $offline_con ?></h2>
										<p class="text-danger">Offline</p>
										</a>
									</div>
									
								</div>
							</div>
						</div>
						
					</div>
					
					
				</div>

			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<?php include "footer.php"; ?>
	</div>
	<!--end wrapper-->

	<!-- search modal -->
	
	<!-- end search modal -->



	
	<!--end switcher-->
	<!-- Bootstrap JS -->
    <script src="<?php  echo $bootsrapBundle; ?>"></script>
    <!--plugins-->
    <script src="<?php echo $js; ?>"></script>
    <script src="<?php echo $simplebar;?>"></script>
    <script src="<?php echo $mentimenu; ?>"></script>
    <script src="<?php echo $perfectScrolbar;  ?>"></script>
    <script src="<?php echo $datatableMin; ?>"></script>
    <script src="<?php echo $datatbaleBootstrap;?>"></script>
    <script src="<?php echo $sweetalert ?>"></script>
    <script src="<?php echo $select2; ?>"></script>
    <script src="<?php echo $select2Custom;?>"></script>
    <!--app JS-->
    <script src="<?php echo $app; ?>"></script>
    <!-- Include the function.js -->
    <script src="../assets/js/function.js"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>