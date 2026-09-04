<?php
session_start();
include "url.php";
include "db/dbConnection.php";

if (isset($_SESSION['entity_id'])) {
    $id = $_SESSION['entity_id'];

    if (empty($id)) {
        header("Location: index.php");
        exit();
    }

    // Map entity IDs to corresponding redirect URLs
    $redirects = [
        1 => "RoririSoftware/employeeDetails.php?id=".$_SESSION['id'],
        3 => "NexGen_IT_Academy/index.php",
    ];

    // Check if the ID exists in the redirect array
    if (array_key_exists($id, $redirects)) {
        header("Location: " . $redirects[$id]);
        exit();
    }
}

$total_rev = "SELECT SUM(inter_amount) AS total_amount , MONTHNAME(CURDATE()) AS month_name
FROM `intern_payment` WHERE `status` = 'Active' AND YEAR(`received_date`) = YEAR(CURDATE()) AND MONTH(`received_date`) = MONTH(CURDATE())";

$total_rev_res = mysqli_query($conn, $total_rev);


$row_7 = mysqli_fetch_assoc($total_rev_res);


$total_rev_total = number_format($row_7['total_amount'], 2, '.', ',');
    
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
			    	    <a href="RoririSoftware/project.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Projects</p>
										<h5 class="my-1">₹ 0,00</h5>
									</div>
									
									  <div class="text-warning ms-auto font-35"><i class='bx bxs-briefcase'></i>
									</div>
								
								</div>
							</div>
						</div>
							</a>
					</div>
					
					
					<div class="col">
					       <a href="RoririSoftware/listOfInternship.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Internship this Month</p>
										<h5 class="my-1" ><?php echo " ₹ " . $total_rev_total ;?></h5><span id="intershipAmount" data-amount="<?php echo $row_7['total_amount']; ?>"></span>
									</div>
									
									    <div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-graduation'></i>
									</div>
									
								</div>
							</div>
						</div>
						</a>
					</div>
					
					
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Workshop</p>
										<h5 class="my-1">₹ 0,00</h5>
									</div>
									<div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-cog'></i>
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
										<p class="mb-0 text-secondary">Industrial Visit Revenue</p>
										<h5 class="my-1">₹ 0,00</h5>
									</div>
									<div class="widgets-icons bg-light-warning text-primary ms-auto"><i class="bx bxs-building-house"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!--<div class="col">-->
					<!--	<div class="card radius-10">-->
					<!--		<div class="card-body">-->
					<!--			<div class="d-flex align-items-center">-->
					<!--				<div>-->
					<!--					<p class="mb-0 text-secondary">Course</p>-->
					<!--					<h4 class="my-1">₹ 0,00</h4>-->
					<!--				</div>-->
					<!--				<a href="NexGen_IT_Academy/course.php"><div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-graduation'></i></a>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					
					<div class="col">
					    <a href="NexGen_IT_Academy/index.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">NexGen IT Academy this Month</p>
										<h5 class="my-1" >
										<?php
											$selEmp = "SELECT SUM(received_amnt) AS total_income
                                            FROM payment
                                            WHERE entity_id = 3
                                              AND received_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
                                              AND received_date < DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-01')";
											$resultEmp = $conn->query($selEmp);

											if ($resultEmp) {
												$rowEmp = $resultEmp->fetch_assoc();
												$empCount = $rowEmp['total_income'];
												// Format the amount and add rupee symbol
                                                $formattedAmount = '₹ ' . number_format($empCount, 2);
                                                echo $formattedAmount;
											} else {
												echo "Error: " . $conn->error;
											}
											?>	
										</h5>
										<span id="academyAmount" data-amount="<?php echo $empCount; ?>"></span>
									</div>
									<a href="NexGen_IT_Academy/index.php"><div class="text-warning ms-auto font-35"><i class='bx bxs-school'></i></a>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">NexGen IT College</p>
										<h5 class="my-1">₹ 0,00</h5>
									</div>
									<a href="NexGen_IT_College/index.php"><div class="widgets-icons bg-light-success text-danger ms-auto"><i class='bx bxs-book'></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
						<div class="col">
						    <a href="https://admin.nexemy.com/" target="_blank">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Nexemy</p>
										<h5 class="my-1" id="nexemyAmount"></h5>
									</div>
									<div class="text-success ms-auto font-35"><i class='bx bx-target-lock'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
				
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Riya IAS Academy</p>
										<h5 class="my-1">₹ 0,00</h5>
									</div>
									<div class="text-info ms-auto font-35"><i class='bx bx-book-open'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
						<div class="col">
					    <a href="https://rithishfarms.in/" target="blank">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Income For Rithish Farms </p>
										<h5 class="my-1" id="">₹ 0,00</h5>
									</div>
									<div class="text-warning ms-auto font-35"><i class='bx bx-store'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					
						<div class="col">
					    <a href="https://roririfoundation.org/" target="blank">
					    
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Income For Roriri Foundation</p>
										<h5 class="my-1" id="">₹ 0,00</h5>
									</div>
									<div class="text-danger ms-auto font-35"><i class='bx bx-heart'></i>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
					
					
						<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Income For The Month</p>
										<h5 class="my-1" id="totalMonthAmount"></h5>
									</div>
									<div class="text-success ms-auto font-35"><i class='bx bx-wallet'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col">
					    <a href="Expense/dashboard.php">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Expenses For The Month</p>
										<h5 class="my-1" id="totalMonthExpense"><?php
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
											?></h5>
									</div>
									<div class="text-danger ms-auto font-35"><i class='bx bx-money-withdraw'></i>
									</div>
								</div>
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

function totalSum() {
    // Retrieve values as numbers from elements and parse them
    const intershipAmount = parseFloat($('#intershipAmount').data('amount')) || 0;
    console.log('Academy Amount:', intershipAmount);
     const academyAmount = parseFloat($('#academyAmount').data('amount')) || 0;
       
    const nexemyAmount = parseFloat($('#nexemyAmount').data('amount')) || 0;

    // Calculate the total
    const total = intershipAmount + academyAmount + nexemyAmount;

    // Format the total in Indian currency format
    const formattedTotal = new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR'
    }).format(total);

    // Set the formatted total to the element
    $('#totalMonthAmount').text(formattedTotal);
}

$(document).ready(function () {
    // Fetch data via AJAX
    $.ajax({
        url: 'https://backendlive.nexemy.com/cms/dashboard/', // Replace with your server endpoint
        type: 'GET',
        success: function (response) {
            if (response && response.data && typeof response.data.payment_amount !== 'undefined') {
                const paymentAmount = parseFloat(response.data.payment_amount);

                // Save raw numeric value in a data attribute
                $('#nexemyAmount').data('amount', paymentAmount);

                // Format and display the payment amount
                const formattedAmount = new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR'
                }).format(paymentAmount);

                $('#nexemyAmount').text(formattedAmount);

                // Calculate and update the total
                totalSum();
            } else {
                console.error('Unexpected Response Format:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                error: error
            });
        }
    });
});

</script>

	
