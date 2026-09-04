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
			    
			    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
			        
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/MOA.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">MOA </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/AOA.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">AOA </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/CERTIFICATE_OF_RECOGNITION.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">Startupindia Recognition</h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/COI.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">COI </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/Ministry_Of_Corporate_Affairs_-_MCA_Services.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">Ministry Of Corporate Affairs</h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/MOU RF & RSS.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">MOU RF & RSS </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/Name_Approval_letter .pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">Name_Approval_letter </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/Roriri Gst invoice.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">Roriri Gst invoice </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/RORIRI MSME.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">RORIRI MSME </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/RORIRI REGISTER CERTIFICATE.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">Roriri Registration</h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/RORIRI_PAN.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">RORIRI_PAN </h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
					</div>
					
					
					<div class="col">
					    <a href="https://asset.inforiya.in/Roririsoft/officialDocuments/SOFT MS RORIRI SOFTWARE SOLUTIONS.pdf" target="_blank">
						<div class="card border-primary border-bottom border-3 border-0">
							<img src="assets/images/gallery/39.png" class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title ">SOFT MS RORIRI</h5>
								<!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
								<hr>
							</div>
						</div>
						</a>
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
</script>
