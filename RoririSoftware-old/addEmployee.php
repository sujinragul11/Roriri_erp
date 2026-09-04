<!-- Modal -->

<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="employeeModalLabel">Add New Employee</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddEmployee" id="addEmployee" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="addEmployee">
									<div class="col-md-6">
										<label for="input13" class="form-label">Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" required data-required="true" />
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										<div id="fnameError" class="error-message">Please Enter your name</div>
									</div>
									
									<div class="col-md-6">
										<label for="dob" class="form-label">DOB <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="date" class="form-control" id="dob" name="dob" placeholder="DD-MM-YYYY" required data-required="true"/>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
										<div id="dobError" class="text-danger" style="display: none;">You must be at least 18 years old.</div>
									</div>
									<div class="col-md-6">
										<label for="input19" class="form-label">Gender <span class="text-danger">*</span></label>
										<select id="gender" name="gender" class="form-select" required="required">
											<option selected value="">Choose...</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
										<div id="genderError" class="error-message">Gender is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input15" class="form-label">Phone <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" name="phone" id="phone" pattern="\d{10}"  maxlength="10" placeholder="Phone" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-microphone'></i></span>
											
										</div>
										<div id="phoneError" class="error-message">Phone number is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Personal Email <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="email" class="form-control" id="pemail" name="pemail"  placeholder="Personal Email" required >
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
											
										</div>
										<div id="emailError" class="error-message">Email ID is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input17" class="form-label">Company Email </label>
										<div class="position-relative input-icon">
											<input type="email" class="form-control" id="cemail" name="cemail" placeholder="Company Email" style="text-transform: lowercase;">
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
										</div>
										<div id="cemailError" class="error-message">Email ID is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input19" class="form-label">Role <span class="text-danger">*</span></label>
										<select id="role" name="role" class="form-select" required="required">
											<option selected value="">Choose...</option>
											<?php $sel_role="SELECT * FROM roles WHERE status='Active'";
                                            $res_role = mysqli_query($conn , $sel_role); 
                                            while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                                               $position_id = $row['role_id'];
                                               $position_name = $row['role_name'];
                                               
                                              
                                               echo '<option value="' . $position_id . '">' . $position_name . '</option>';
                                            } ?>
										</select>
										<div id="roleError" class="error-message text-danger" style="display: none;">Role is required.</div>
									</div>
									
									
									<div class="col-md-6">
										<label for="input18" class="form-label">Date of Joining <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="date" class="form-control" id="jDate" name="jDate" placeholder="Date of Joining" required="required">
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
											
										</div>
										<div id="jDateError" class="error-message">Date of joining is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input23" class="form-label">Address <span class="text-danger">*</span></label>
										<textarea class="form-control" id="address" name="address" placeholder="Address ..." rows="3" required></textarea>
										
									</div>
									<div id="addressError" class="error-message">Address is required.</div>
									<div class="col-md-6">
										<label for="input19" class="form-label">Marrital Status <span class="text-danger">*</span></label>
										<select id="ms" name="ms" class="form-select" required="required">
											<option selected value="">Choose...</option>
											<option value="Married">Married</option>
											<option value="Unmarried">Unmarried</option>
										</select>
										<div id="msError" class="error-message">Marrital Status is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input13" class="form-label">Blood Group </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="blood" id="blood" placeholder="Blood Group">
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
										</div>
									</div>
									
								</form>
						</div>
                            <div class="modal-footer">
                                <button type="button" id="" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="submitBtn" class="btn btn-primary">Save changes</button>
                            </div>
						
            </div>
						
				
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->
<!-- Add the Salary modal -->
 <!-- Modal -->

<div class="modal fade" id="addSalaryModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="employeeModalLabel">Add Salary</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddSalary" id="addSalary">
								<input type="hidden" name="hdnAction" value="addSalary">
								<input type="hidden" name="salaryId" id="salaryId">
									<div class="col-md-6">
										<label for="input13" class="form-label">Salary <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" name="salary" id="salary" placeholder="Salary"  oninput="this.value = this.value.slice(0, 5);" required data-required="true"/>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										<div id="salaryError" class="error-message">Please Enter Salary</div>
									</div>
									<div class="col-md-6">
    <label for="input13" class="form-label">Date <span class="text-danger">*</span></label>
    <div class="position-relative input-icon">
        <input type="date" class="form-control" name="date" id="date" placeholder="Date" required data-required="true"/>
        <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
    </div>
    <div id="salDateError" class="error-message" style="display: none; color: red;">Please select the current date or a past date.</div>
</div>

									<div class="col-md-6">
										<label for="input13" class="form-label">Number of days Absent <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" name="days" id="days" max="30" oninput="this.value = this.value.slice(0, 2);" placeholder="Number of days Absent" required data-required="true"/>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										<div id="salDaysError" class="error-message">Please Enter Days</div>
									</div>
									<div class="col-md-6" style="display:none">
										<label for="input13" class="form-label">Bank Account Number </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="bankAcc" id="bankAcc" placeholder="Bank Account Number" />
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										
									</div>
									<div class="col-md-6" style="display:none">
										<label for="input13" class="form-label">IFSC Code </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="ifsc" id="ifsc" placeholder="IFSC Code"  style="text-transform: uppercase;"/>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										
									</div>
									<div class="col-md-6"style="display:none">
										<label for="input13" class="form-label">Branch </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="branch" id="branch" placeholder="Branch Name "  style="text-transform: uppercase;"/>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										
									</div>
									<div class="col-md-6" style="display:none">
										<label for="input13" class="form-label">Years of Experience <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="experience" id="experience" placeholder="Experience" required data-required="true"/>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										<div id="experienceError" class="error-message">Please Enter Experience</div>
									</div>
									
									
								</form>
						</div>
                            <div class="modal-footer">
                                <button type="button" id="" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="submitBtnSalary" class="btn btn-primary">Save changes</button>
                            </div>
						
            </div>
						
				
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->

<script>
document.getElementById('phone').addEventListener('input', function (e) {
    const value = e.target.value;

    // Remove non-numeric characters
    e.target.value = value.replace(/[^0-9]/g, '');

    // Limit the length to 10 digits
    if (value.length > 10) {
        e.target.value = value.slice(0, 10);
    }
});

document.getElementById('date').addEventListener('change', function() {
    const selectedDate = new Date(this.value);
    const today = new Date();

    // Clear time part of the dates
    selectedDate.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    const salDateError = document.getElementById('salDateError');

    if (selectedDate > today) {
        // If the selected date is in the future, show an error
        salDateError.style.display = 'block';
        this.value = ''; // Clear the input value
    } else {
        // If the selected date is today or in the past, hide the error
        salDateError.style.display = 'none';
    }
});

</script>


    


   




    


   
