<?php
$couquery = "SELECT inte_cou_id, intern_course_name FROM inter_course_tbl WHERE status = 'Active'";
$resultcou = mysqli_query($conn, $couquery);

// Store the courses in an array
$courses = [];
while ($row = mysqli_fetch_assoc($resultcou)) {
    $courses[] = $row;
}
?>
<!-- Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-dialog and modal-lg for large modal -->
        <div class="modal-content"> <!-- Added modal-content -->
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Starts Here -->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card">
                           
                            <div class="card-body p-4">
                                <form class="row g-3 needs-validation" id="candidatesForm" novalidate>
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="hidden" name="hdnAction" value="addCandidate">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required 
                                            pattern="[A-Za-z\s]+" title="Please enter a valid name (letters and spaces only)">
                                        <div class="invalid-feedback">
                                            Please enter a valid Name.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="incharge" class="form-label">Incharge Person</label>
                                        <select id="incharge" name="incharge" class="form-select" required>
                                            <option value="" selected>Choose the Person</option>
                                            <?php
                                            $sqlPerson = "SELECT
                                                            a.`id`,
                                                            a.`name`  
                                                        FROM
                                                            `basic_details` AS a
                                                            LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                                            LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                                        WHERE
                                                            a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                                            $resultPer = $conn->query($sqlPerson);
                                            while ($row = $resultPer->fetch_assoc()) {
                                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">Please enter a valid Person Name.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="course" class="form-label">Course Name</label>
                                        <select id="course" name="course" class="form-select" required>
                                            <option value="" selected>Choose Course</option>
                                            <?php foreach ($courses as $course): ?>
                                                <option value="<?= $course['inte_cou_id'] ?>"><?= $course['intern_course_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please enter a valid Course Name.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="fees" class="form-label">Fees</label>
                                        <input type="number" class="form-control" name="fees" id="fees" placeholder="Enter the Fees" required 
                                            pattern="^[0-9]{10}$" title="Please enter a valid Fees.">
                                        <div class="invalid-feedback">
                                            Please enter a valid Fees.
                                        </div>
                                    </div>
        
                                    <div class="mb-3">
                                    <label for="durationNo" class="form-label">Duration</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="durationNo" id="durationNo" placeholder="Duration No" required>
                                        <select id="duration" name="duration" class="form-select" required>
                                            <option value="" selected>Choose unit</option>
                                            <option value="Day">Day</option>
                                            <option value="Week">Week</option>
                                            <option value="Month">Month</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid Duration number and unit.
                                    </div>
                                </div>

                                    <div class="col-md-6">
										<label for="gender" class="form-label">Gender</label>
										<select id="gender" name="gender" class="form-select" required>
											<option value="" selected>Choose Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Others">Others</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please enter a valid Gender.
                                        </div>
									</div>

                                   


                                    <div class="col-md-6">
                                        <label for="mode" class="form-label">Mode</label>
										<select id="mode" name="mode" class="form-select" required>
											<option value="" selected>Choose the Mode</option>
											<option value="Online">Online</option>
											<option value="Offline">Offline</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please select the Mode.
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required 
                                    pattern="^[0-9]{10}$" title="Please enter a valid 10-digit phone number.">
                                <div class="invalid-feedback">
                                    Please enter a valid phone number.
                                </div>
                            </div>

                                    <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required 
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address.">
                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                </div>
                            </div>



                                    <div class="col-md-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="address" placeholder="Address ..." rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Please enter a valid address.
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="image" id="image" accept=".png, .jpg, .jpeg" >
                                    <div class="invalid-feedback">
                                        Please select an image.
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="joiningDate" class="form-label">Joining Date</label>
                                        <input type="date" class="form-control" name="joiningDate" id="joiningDate" placeholder="Joining Date" required>
                                        <div class="invalid-feedback">
                                            Please select Joining Date.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="username" class="form-label">User Name</label>
                                        <input type="text" class="form-control" pattern="^[a-z]+_?[0-9]{0,5}$" placeholder="Enter the Username" name="username" id="username" required>
                                        <div id="usernameError" class="error-message"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                            <a href="javascript:;" class="input-group-text bg-transparent" id="togglePassword">
                                                <i class="bx bx-hide" id="eyeIcon"></i>
                                            </a>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please choose a password.
                                        </div>
                                    </div>
                                    
                                         
                                    
                                 
                                    <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 ms-auto justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="submitBtn" class="btn btn-primary px-4">Submit</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--end Modal Fade-->

<!-- edit madule -->


<!-- Modal -->
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-dialog and modal-lg for large modal -->
        <div class="modal-content"> <!-- Added modal-content -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Starts Here -->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card">
                           
                            <div class="card-body p-4">
                                <form class="row g-3 needs-validation" id="EditcandidatesForm" novalidate>
                                    <div class="col-md-6">
                                        <label for="nameEdit" class="form-label">Name</label>
                                        <input type="hidden" name="hdnAction" value="EditCandidate">
                                        <input type="hidden" name="EditId" id="EditId">
                                        <input type="text" class="form-control" name="nameEdit" id="nameEdit" placeholder="Enter Name" required 
                                            pattern="[A-Za-z\s]+" title="Please enter a valid name (letters and spaces only)">
                                        <div class="invalid-feedback">
                                            Please enter a valid Name.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="inchargeEdit" class="form-label">Incharge Person</label>
                                        <select id="inchargeEdit" name="inchargeEdit" class="form-select" required>
                                            <option value="">Choose the Person</option>
                                            <?php
                                            $sqlPerson1 = "SELECT
                                                            a.`id`,
                                                            a.`name`  
                                                        FROM
                                                            `basic_details` AS a
                                                            LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                                            LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                                        WHERE
                                                            a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                                            $resultPer1 = $conn->query($sqlPerson1);
                                            while ($row = $resultPer1->fetch_assoc()) {
                                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">Please enter a valid Person Name.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="courseEdit" class="form-label">Course Name</label>
                                        <select id="courseEdit" name="courseEdit" class="form-select" required>
                                            <option value="" selected>Choose Course</option>
                                            <?php foreach ($courses as $course): ?>
                                                <option value="<?= $course['inte_cou_id'] ?>"><?= $course['intern_course_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please enter a valid Course Name.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="feesEdit" class="form-label">Fees</label>
                                        <input type="number" class="form-control" name="feesEdit" id="feesEdit" placeholder="Fess" required 
                                            pattern="^[0-9]{10}$" title="Please enter a valid  Fess.">
                                        <div class="invalid-feedback">
                                            Please enter a valid Fees.
                                        </div>
                                    </div>
        
                                    <div class="mb-3">
                                    <label for="durationNoEdit" class="form-label">Duration</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="durationNoEdit" id="durationNoEdit" placeholder="Duration No" required>
                                        <select id="durationEdit" name="durationEdit" class="form-select" required>
                                            <option value="" selected>Choose unit</option>
                                            <option value="Day">Day</option>
                                            <option value="Week">Week</option>
                                            <option value="Month">Month</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid Duration number and unit.
                                    </div>
                                </div>

                                    <div class="col-md-6">
										<label for="genderEdit" class="form-label">Gender</label>
										<select id="genderEdit" name="genderEdit" class="form-select" required>
											<option value="" selected>Choose Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Others">Others</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please enter a valid Gender.
                                        </div>
									</div>

                                   


                                    <div class="col-md-6">
                                        <label for="modeEdit" class="form-label">Mode</label>
										<select id="modeEdit" name="modeEdit" class="form-select" required>
											<option value="" selected>Choose the Mode</option>
											<option value="Online">Online</option>
											<option value="Offline">Offline</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please select the Mode.
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                <label for="phoneEdit" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phoneEdit" id="phoneEdit" placeholder="Phone" required 
                                    pattern="^[0-9]{10}$" title="Please enter a valid 10-digit phone number.">
                                <div class="invalid-feedback">
                                    Please enter a valid phone number.
                                </div>
                            </div>

                                    <div class="col-md-6">
                                <label for="emailEdit" class="form-label">Email</label>
                                <input type="email" class="form-control" name="emailEdit" id="emailEdit" placeholder="Email" required 
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address.">
                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                </div>
                            </div>



                                    <div class="col-md-12">
                                        <label for="addressEdit" class="form-label">Address</label>
                                        <textarea class="form-control" name="addressEdit" id="addressEdit" placeholder="Address ..." rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Please enter a valid address.
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                    <label for="imageEdit" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="imageEdit" id="imageEdit" accept=".png, .jpg, .jpeg" >
                                    <div class="invalid-feedback">
                                        Please select an image.
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="joiningDateEdit" class="form-label">Joining Date</label>
                                        <input type="date" class="form-control" name="joiningDateEdit" id="joiningDateEdit" placeholder="Joining Date" required>
                                        <div class="invalid-feedback">
                                            Please select Joining Date.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="usernameEdit" class="form-label">User Name</label>
                                        <input type="text" class="form-control" pattern="^[a-z]+_?[0-9]{0,5}$" placeholder="Enter the Username" name="usernameEdit" id="usernameEdit" readonly required>
                                        <div id="usernameError" class="error-message"></div>
                                        <div class="invalid-feedback">
                                            Please choose a Username.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="passwordEdit" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="passwordEdit" id="passwordEdit" placeholder="Password" required>
                                            <a href="javascript:;" class="input-group-text bg-transparent" id="togglePasswordEdit">
                                                <i class="bx bx-hide" id="eyeIconEdit"></i>
                                            </a>
                                        </div>
                                        <div class="invalid-feedback">
                                            Please choose a password.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 ms-auto justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="saveCandidateEdit" class="btn btn-primary px-4">Submit</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- //view page  -->



<div class="modal fade" id="PaymenttraineeModal" tabindex="-1" aria-labelledby="PaymenttraineeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
                    <h5 class="modal-title" id="PaymenttraineeModalLabel">Add Payment</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div id="alertContainer"></div>
						<div class="card-body p-4">
								<form class="row g-3 needs-validation" name="frmAddPayment" id="TraineePayment" enctype="multipart/form-data" novalidate>
								<input type="hidden" name="hdnAction" value="TraineePayment">
								<input type="hidden" name="TraineePay" id="PayTrainee">

									<div class="col-md-12">
										<label for="traineeName" class="form-label">Intern Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="traineeName" id="traineeName" placeholder="Student Name" required readonly> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-notepad"></i></span>
										</div>
									</div>
                                    <div class="col-md-6">
										<label for="overAmnt" class="form-label">Overall Amount <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="overAmnt" id="overAmnt" placeholder="Overall Amount" required readonly> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									<div class="col-md-6 ">
										<label for="amntReceived" class="form-label">Amount Received <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="amntReceived" id="amntReceived" placeholder="Amount Received" required readonly> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									
									<div class="col-md-6">
										<label for="balance" class="form-label">Amount Paid <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" pattern="[0-9]*" name="balance" id="balance" placeholder="Enter the Amount" required min="0"> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="remaining" class="form-label">Balance Amount <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" name="remaining" id="remaining" placeholder="Balance Amount" required readonly> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="date" class="form-label">Payment Date <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="date" class="form-control" id="date" name="date" placeholder="Received date" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
									</div>
									
									<div class="col-md-6">
										<label for="payMode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
										<select class="form-select" name="payMode" id="payMode" required>
											<option selected value="">Choose....</option>
											<option value="Cash">Cash</option>
											<option value="Net Banking">Net Banking</option>
											<option value="Online Payment">Online Payment</option>
											<option value="Cheque">Cheque</option>
										</select>
									</div>
                                    <div class="col-md-6">
										<label for="trans" class="form-label">Receipt/Transation Id  </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="trans" name="trans" placeholder=" Receipt/Transaction ID" >
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-credit-card'></i></span>
										</div>
									</div>
						</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
						</form>
            </div>
						
				
	    </div> <!--end modal dialog-->
      
</div><!--end Modal Fade-->

<!-- HTML for Error Message --> 
<div id="balanceError" class="error-message" style="display:none;">Please check the amount. The balance cannot be negative.</div>

<!-- Modal for Deletion Confirmation -->
<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteClientModalLabel">Candidate Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to change this candidate status?</p>
        <div class="form-group">
          <label for="deleteStatus">Select Status</label>
          <select id="deleteStatus" class="form-control">
            <option value="Inactive">Completed</option>
            <option value="Discontinued">Discontinued</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Submit</button>
      </div>
    </div>
  </div>
</div>


<!-- JavaScript -->
<script>
function calculateBalance() {
    const overallAmount = parseFloat(document.getElementById('overAmnt').value) || 0;
    const amountReceived = parseFloat(document.getElementById('amntReceived').value) || 0;
    const amountPaidInput = document.getElementById('balance');
    const amountPaid = parseFloat(amountPaidInput.value) || 0;

    let balance = overallAmount - amountReceived; // Default balance calculation

    if (amountPaid > 0) {
        balance = overallAmount - (amountReceived + amountPaid);

        // If the amountPaid is greater than the remaining balance, show alert and adjust values
        if (balance < 0) {
            balance = 0;
            amountPaidInput.value = overallAmount - amountReceived; // Adjust the amountPaid to the remaining balance

            // Display a custom Bootstrap alert
            const alertContainer = document.getElementById('alertContainer');
            alertContainer.innerHTML = `
                <div id="balanceAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> The amount paid exceeds the remaining balance. The amount has been adjusted.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            // Auto-hide the alert after 5 seconds (5000 milliseconds)
            setTimeout(() => {
                const alertElement = document.getElementById('balanceAlert');
                if (alertElement) {
                    alertElement.classList.remove('show');
                    alertElement.classList.add('fade');
                    setTimeout(() => alertElement.remove(), 150); // Remove after fade out
                }
            }, 3000);
        }
    }

    document.getElementById('remaining').value = balance; // Update the remaining field
}

document.getElementById('balance').addEventListener('input', calculateBalance);
// jQuery script to toggle password visibility
</script>


