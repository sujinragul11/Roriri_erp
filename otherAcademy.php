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
                            <h2 class="page-title" id="catHeading">Other Academy Details</h2>
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
										<th class="col-2 text-center">Academy Name</th>
										<th class="col-2 text-center">Course Name</th>
										<th class="col-2 text-center">Mode</th>
										<th class="col-1 text-center">Amount</th>
										<th class="col-4 text-center">Duration</th>
									</tr>
								</thead>
								<tbody>
                                    <tr>
                                        <td class="col-1 text-center">1</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 47,200</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">2</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 47,200</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">3</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 15,000</td>
                                        <td class="col-4 text-center">30 Days</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">4</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 15,000</td>
                                        <td class="col-4 text-center">30 Days</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">5</td>
                                        <td class="col-2 text-center">Uniq</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 30,000</td>
                                        <td class="col-4 text-center">4 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">6</td>
                                        <td class="col-2 text-center">Uniq</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 30,000</td>
                                        <td class="col-4 text-center">4 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">7</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 15,000</td>
                                        <td class="col-4 text-center">50 Hrs</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">8</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">Python</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">Only Bundle</td>
                                        <td class="col-4 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">9</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">Flutter</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 47,200</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">10</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">Flutter</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 47,200</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">11</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">Flutter</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">12</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">Flutter</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">13</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">Data Analysis</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 35,400</td>
                                        <td class="col-4 text-center">2 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">14</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">Data Analysis</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 35,400</td>
                                        <td class="col-4 text-center">2 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">15</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">Data Analysis</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 30,000</td>
                                        <td class="col-4 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">16</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">Data Analysis</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 30,000</td>
                                        <td class="col-4 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">17</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">Data Analysis</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 94,999</td>
                                        <td class="col-4 text-center">3-5 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">18</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">Data Analysis</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 94,999</td>
                                        <td class="col-4 text-center">3-5 Months</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">19</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 47,000</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">20</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 47,000</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">21</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 35,000</td>
                                        <td class="col-4 text-center">3 Months (2Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">22</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 35,000</td>
                                        <td class="col-4 text-center">3 Months (2Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">23</td>
                                        <td class="col-2 text-center">Uniq</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 40,000</td>
                                        <td class="col-4 text-center">4 Months (1.5Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">24</td>
                                        <td class="col-2 text-center">Uniq</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 40,000</td>
                                        <td class="col-4 text-center">4 Months (1.5Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">25</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">26</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">MERN</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">27</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 47,000</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">28</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 47,000</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">29</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 35,000</td>
                                        <td class="col-4 text-center">3 Months (2Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">30</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 35,000</td>
                                        <td class="col-4 text-center">3 Months (2Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">31</td>
                                        <td class="col-2 text-center">Uniq</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 40,000</td>
                                        <td class="col-4 text-center">4 Months (1.5Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">32</td>
                                        <td class="col-2 text-center">Uniq</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 40,000</td>
                                        <td class="col-4 text-center">4 Months (1.5Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">33</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">34</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">ReactJs</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">35</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">UI/UX</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 47,200</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">36</td>
                                        <td class="col-2 text-center">Besant</td>
                                        <td class="col-2 text-center">UI/UX</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 47,200</td>
                                        <td class="col-4 text-center">4 Months WeekDays(1.5Hrs) Weekend(3Hrs)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">37</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">UI/UX</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 30,000</td>
                                        <td class="col-4 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">38</td>
                                        <td class="col-2 text-center">Green Tech</td>
                                        <td class="col-2 text-center">UI/UX</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 30,000</td>
                                        <td class="col-4 text-center">-</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">39</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">UI/UX</td>
                                        <td class="col-2 text-center">Online</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
                                    </tr>
                                    <tr>
                                        <td class="col-1 text-center">40</td>
                                        <td class="col-2 text-center">Guvi</td>
                                        <td class="col-2 text-center">UI/UX</td>
                                        <td class="col-2 text-center">Offline</td>
                                        <td class="col-1 text-end">₹ 76,800</td>
                                        <td class="col-4 text-center">1 year (8Hrs/Week)</td>
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