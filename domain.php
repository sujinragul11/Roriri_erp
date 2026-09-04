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
			    
			 <!--   <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">-->
			        
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-primary">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-9.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Petchimuthu</h5>-->
				<!--					<p class="mb-1 text-white">Riya Ias Academy</p>-->
				<!--					<a href="tel:9363701010">-->
    <!--                                <h5 class="mb-0 mt-0 text-white">9363701010</h5>-->
    <!--                                </a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-danger">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-15.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Sheeba</h5>-->
				<!--					<p class="mb-1 text-white">Nexgen It College</p>-->
				<!--					<a href="tel:9994292150">-->
    <!--                                <h5 class="mb-0 mt-0 text-white">9994292150</h5>-->
    <!--                                </a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-warning">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-7.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Mukila</h5>-->
				<!--					<p class="mb-1 text-white">Riya Ias Academy</p>-->
				<!--					<a href="tel:7810012668">-->
				<!--					<h5 class="mb-0 mt-0 text-white">7810012668</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-info">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-8.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Jebastin</h5>-->
				<!--					<p class="mb-1 text-white">Roriri Software Solutions</p>-->
				<!--					<a href="tel:9363980121">-->
				<!--					<h5 class="mb-0 mt-0 text-white">9363980121</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-1 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-primary">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-1.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Asha</h5>-->
				<!--					<p class="mb-1 text-white">Management</p>-->
				<!--					<a href="tel:9677018421">-->
				<!--					<h5 class="mb-0 mt-0 text-white">9677018421</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-danger">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-2.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Prabhavathi</h5>-->
				<!--					<p class="mb-1 text-white">Nexgen It Academy</p>-->
				<!--					<a href="tel:9360759742">-->
				<!--					<h5 class="mb-0 mt-0 text-white">9360759742</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--		<div class="col">-->
				<!--		<div class="card radius-15 bg-info">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-2.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Prabhavathi</h5>-->
				<!--					<p class="mb-1 text-white">------</p>-->
				<!--					<a href="tel:8778528630">-->
				<!--					<h5 class="mb-0 mt-0 text-white">8778528630</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-warning">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-3.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Srinivas</h5>-->
				<!--					<p class="mb-1 text-white">Internship</p>-->
				<!--					<a href="tel:8778265821">-->
				<!--					<h5 class="mb-0 mt-0 text-white">8778265821</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-0 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
				<!--	<div class="col">-->
				<!--		<div class="card radius-15 bg-info">-->
				<!--			<div class="card-body text-center">-->
				<!--				<div class="p-4 radius-15">-->
				<!--					<img src="assets/images/avatars/avatar-4.png" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">-->
				<!--					<h5 class="mb-0 mt-3 text-white">Digital Media</h5>-->
				<!--					<p class="mb-1 text-white">Social Media Team</p>-->
				<!--					<a href="tel:7338941579">-->
				<!--					<h5 class="mb-0 mt-0 text-white">7338941579</h5>-->
				<!--					</a>-->
									<!--<p class="mb-0 mt-1 text-white">petchimuthu@roririsoft.com</p>-->
				
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
					
					
					
				<!--</div>-->
				
				
				
				
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								 <thead>
            <tr>
                <th>#</th>
                <th>Domain</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Roriri Software Solutions</td>
                <td><a href="https://domain.roririsoft.com/" target="_blank">https://domain.roririsoft.com/</a></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Plans</td>
                <td><a href="https://plans.roririsoft.com/" target="_blank">https://plans.roririsoft.com/</a></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Course Enquiry</td>
                <td><a href="https://course.nexgenitacademy.com" target="_blank">https://course.nexgenitacademy.com</a></td>
            </tr>
            <tr>
                <td>4</td>
                <td>For Client</td>
                <td><a href="http://client.roririsoft.com/index.html" target="_blank">http://client.roririsoft.com/index.html</a></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Placement Officer</td>
                <td><a href="https://placementofficer.roririsoft.com/" target="_blank">https://placementofficer.roririsoft.com/</a></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Parents</td>
                <td><a href="https://parents.nexgenitacademy.com/" target="_blank">https://parents.nexgenitacademy.com/</a></td>
            </tr>
            <tr>
                <td>7</td>
                <td>College Students</td>
                <td><a href="https://5050developers.roririsoft.com/" target="_blank">https://5050developers.roririsoft.com/</a></td>
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
document.addEventListener('DOMContentLoaded', function() {
    $('#passwordForm').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; // Stop the submission
                }
        var formData = new FormData(this);
        $('#savePassword').prop('disabled', true);
        $.ajax({
            url: "actLogin.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#editPasswordModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop   
                        if (response.newPassword) {
                            $('#password').val(response.newPassword);
                            $('#savePassword').prop('disabled', false);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#savePassword').prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating password data.'
                });
                $('#savePassword').prop('disabled', false);
            }
        });
    });
    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        const passwordInput = $('#show_hide_password input');
        const toggleIcon = $('#show_hide_password i');
    
        if (passwordInput.attr("type") === "text") {
            passwordInput.attr('type', 'password');
            toggleIcon.addClass("bx-hide");
            toggleIcon.removeClass("bx-show");
        } else if (passwordInput.attr("type") === "password") {
            passwordInput.attr('type', 'text');
            toggleIcon.removeClass("bx-hide");
            toggleIcon.addClass("bx-show");
        }
    });
});
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
