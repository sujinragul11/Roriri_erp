<?php
session_start();
include "../db/dbConnection.php";
include "../url.php";

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
										<h2>23</h2>
										<p class="text-muted">1 Week</p>
									</div>
									<div style="border: 1px solid #e1e1e1; height: 75px;"></div>
									<div class="col-6">
										<h2>3</h2>
										<p class="text-muted">2 Week</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Dribbble Card -->
					<div class="col-md-4">
						<div class="card dribble-card">
							<div class="card-header" style="background-color: #008cff">
								<!-- <i class="icofont icofont-social-dribbble"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">month</h5>
									<span style="color: #ffff;">Joining as an Internship</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
										<h2>23</h2>
										<p class="text-muted">1 month</p>
									</div>
									<div style="border: 1px solid #e1e1e1; height: 75px;"></div>
									<div class="col-6">
										<h2>3</h2>
										<p class="text-muted">3 month</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Twitter Card -->
					<div class="col-md-4">
						<div class="card twitter-card">
							<div class="card-header" style="background-color: #008cff;">
								<!-- <i class="icofont icofont-social-twitter"></i> -->
								<div class="d-inline-block" style="padding: 5px;">
									<h5 style="color: #ffff;">Total</h5>
									<span style="color: #ffff;">Total amount for this month</span>
								</div>
							</div>
							<div class="card-block text-center">
								<div class="row"
									style="display: flex; justify-content: center; align-items: center; padding: 8px;">
									<div class="col-6 b-r-default">
										<h2>3,12500</h2>
										<p class="text-muted">Revenue</p>
									</div>
									<!-- <div class="col-6">
							  <h2>450+</h2>
							  <p class="text-muted">Followers</p>
							</div> -->
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
</body>

</html>