<?php
session_start();
include "url.php";
include "db/dbConnection.php";

?>
<!doctype html>
<html lang="en">

<?php include "head.php";?>

<body>

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
			    <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h2 class="page-title" id="catHeading">Our Academy Fees Details</h2>
                        </div>
                    </div>
                    <a href="datas.php">
                        <button type="button" id="backBtn" class="btn btn-danger mb-2">
                            <i class="lni lni-exit"></i> Back
                        </button>
                    </a>
                </div>

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
									    <th class="col-1 text-center">S.No</th>
										<th class="col-3 text-center">Course Duration</th>
										<th class="col-8 text-center">Course Details</th>
									</tr>
								</thead>
								<tbody>
                                    <tr>
                                        <td class="col-1 text-center">1</td>
                                        <td class="col-3 text-center">2 Years Course Details</td>
                                        <td class="col-8 text-center"><a href="https://asset.inforiya.in/ERP/ERP_image/data/2 years Course.png" target="blank">https://asset.inforiya.in/ERP/ERP_image/data/2 years Course.png</a></td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">2</td>
                                        <td class="col-3 text-center">1 Year Course Details</td>
                                        <td class="col-8 text-center"><a href="https://asset.inforiya.in/ERP/ERP_image/data/1 YEAR COURSE.png" target="blank">https://asset.inforiya.in/ERP/ERP_image/data/1 YEAR COURSE.png</a></td>
                                    </tr>
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
            });
        
            // Append buttons to DataTable
            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
	    });
	</script>
</body>
</html>