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
                
			
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">College</p>
										<h4 class="my-1">5</h4>
									</div>
									<div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bx-building"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!--<div class="col">-->
					<!--       <a href="RoririSoftware/listOfInternship.php">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Data 2</p>-->
					<!--					<h4 class="my-1">2</h4>	-->
					<!--				</div>-->
					<!--				<a href="#"><div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-briefcase'></i>-->
					<!--				</div>-->
					<!--				</a>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--	</a>-->
					<!--</div>-->
					<!--<div class="col">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Data 3</p>-->
					<!--					<h4 class="my-1">3</h4>-->
					<!--				</div>-->
					<!--				<a href="#"><div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-graduation'></i>-->
					<!--				</div>-->
					<!--				</a>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<!--<div class="col">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Data 4</p>-->
					<!--					<h4 class="my-1">4</h4>-->
					<!--				</div>-->
					<!--				<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bxs-group'></i>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<!--<div class="col">-->
					<!--    <a href="#">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Data 5</p>-->
					<!--					<h4 class="my-1">5</h4>-->
					<!--				</div>-->
					<!--				<a href="#"><div class="text-primary ms-auto font-35"><i class='bx bxs-network-chart'></i>-->
					<!--				</div>-->
					<!--				</a>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--	</a>-->
					<!--</div>-->
					<!--<div class="col">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Data 6</p>-->
					<!--					<h4 class="my-1">6</h4>-->
					<!--				</div>-->
					<!--				<a href="#"><div class="text-danger ms-auto font-35"><i class='bx bxs-book'></i>-->
					<!--				</div>-->
					<!--				</a>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<!--<div class="col">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Data 7</p>-->
					<!--					<h4 class="my-1">7</h4>-->
					<!--				</div>-->
					<!--				<a href="#"><div class="text-warning ms-auto font-35"><i class='bx bxs-folder'></i>-->
					<!--				</div>-->
					<!--				</a>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<!--<div class="col">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Data 8</p>-->
					<!--					<h4 class="my-1">8</h4>-->
					<!--				</div>-->
					<!--				<div class="text-success ms-auto font-35"><i class='lni lni-target'></i>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
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


	
