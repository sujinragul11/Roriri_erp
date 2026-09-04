
<!-- Modal -->
<div class="modal fade" id="addTraineeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="frmAddTrainee" id="addTrainee"  enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addTrainee">
                <div class="modal-header">
                    <h4 class="modal-title" id="addTraineeModal">Add Trainee</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row p-3">
                        <!-- Basic Details Section -->
                        <div class="col-12">
                            <h5 class="pb-2">Basic Details</h5>
                            <div class="row">
                                <!-- Basic details fields here -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="name" class="form-label"><b>Name</b><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Name" name="name" id="name">
                                        <div id="fnameError"  style="color: red" class="error-message">Name is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="gender" class="form-label"><b>Gender</b><span class="text-danger">*</span></label>
                                        <select class="form-control" id="gender" name="gender" >
                                            <option selected value="">--Select the Gender--</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <div id="genderError" class="error-message">Gender is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="phone" class="form-label"><b>Mobile No</b><span class="text-danger">*</span></label>
                                        <input type="number" pattern="[0-9]{10}" class="form-control" placeholder="Enter Mobile No" name="phone" id="phone">
                                        <div id="phoneError" class="error-message">Phone is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="pemail" class="form-label"><b>Email</b><span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" placeholder="Enter Email" name="pemail" id="pemail">
                                        <div id="emailError" class="error-message">Email ID is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="dob" class="form-label"><b>Date of Birth</b><span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Enter Date of Birth" name="dob" id="dob">
                                        <div id="dobError" class="error-message">You must be at least 18 years old.</div>
                                    </div>
                                   
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="address" class="form-label"><b>Address</b><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter address" name="address" id="address" required>
                                        <div id="addressError" class="error-message" >Address is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="blood" class="form-label"><b>Blood Group</b></label>
                                        <input type="text" class="form-control" placeholder="Enter blood group" name="blood" id="blood">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="image" class="form-label"><b>Image</b></label>
                                        <input type="file" class="form-control" placeholder="choose" name="image" id="image">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="username" class="form-label"><b>Username</b><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" pattern="^[a-z]+_?[0-9]{0,5}$" placeholder="Enter the Username" name="username" id="username" required>
                                        <div id="usernameError" class="error-message"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Course Details Section -->
                        <div class="col-12 mt-4">
                            <h5 class="pb-2">Course Details</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="course_id" class="form-label"><b>Course</b><span class="text-danger">*</span></label>
                                        <select name="course_name" class="form-select" id="course_name">
                                            <option value="">--Select the Course--</option>
                                        <?php $sql="SELECT * FROM academy_course_details WHERE status='Available'";
                                         $res_role = mysqli_query($conn , $sql); 
                                         while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                                            $course_id = $row['id'];
                                            $course_name = $row['course_name'];
                                           
                                            echo '<option value="' . $course_id . '">' . $course_name . '</option>';
                                         }   ?>
                                        <!-- <input type="text" class="form-control" placeholder="Course " name="course_name" id="course" required> -->
                                        </select>
                                        <div id="courseError" class="error-message">Course is required.</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="duration" class="form-label"><b>Months Duration </b><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Duration" name="duration" id="duration" required>
                                        <div id="durationError" class="error-message">Duration is required.</div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="fee" class="form-label"><b>Actual Fee</b><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Actual fee" name="actual_fee" id="actual_fee">
                                        <div id="feeError" class="error-message" >Fee is required.</div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3" style="display:none">
                                        <label for="discount" class="form-label"><b>Discount %</b></label>
                                        <input type="number" id="iscount" name="discount_fee" class="form-control" placeholder="Enter discount " step="0.01" min="0" max="100" onclick="calculateDiscountedFee()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3" style="display:none">
                                        <label for="discount_amount" class="form-label"><b>Discount Amount</b></label>
                                        <input type="text" class="form-control" placeholder="discounted amount" name="discounted_amount" id="diiiscounted_amount" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3" style="display:none">
                                        <label for="fee" class="form-label"><b>Discounted Fee</b></label>
                                        <input type="text" class="form-control" placeholder="Enter Fee" name="fee" id="feez" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="jDate" class="form-label"><b>Joining date</b><span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Enter Date of Birth" name="jDate" id="jDate">
                                        <div id="jDateError" class="error-message"> Date of Joining is required.</div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="slot" class="form-label"><b>Slot Timing</b></label>
                                        <select class="form-control" id="slot" name="slot" >
                                            <option value="">--Select the Slot Timing--</option>
                                            <option value="9:30 - 1:30">9:30 am - 1:30 pm</option>
                                            <option value="1:30 - 5:30">1:30 pm - 5:30 pm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="batch" class="form-label"><b>Batch</b></label>
                                        <select class="form-control" id="batch" name="batch" >
                                            <option value="">--Select the Batch--</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                    <div class="form-group pb-3">
                        <label for="referredBy" class="form-label"><b>Referred By</b><span class="text-danger">*</span></label>
                        <select class="form-control" id="referredBy" name="referredBy" onchange="handleReferredByChange()">
                            <option value="">--Select--</option>
                            <?php
                            $employeeQuery = "SELECT id, name FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id LEFT JOIN roles AS c ON b.role = c.role_id WHERE a.status='Active' AND c.role_id != 17 AND b.entity_id = 1;";
                            $result = mysqli_query($conn, $employeeQuery);
                            while ($employee = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $employee['id'] . '">' . $employee['name'] . '</option>';
                            }
                            ?>
                            <option value="myself">Myself</option>
                            <option value="others">Others</option>
                        </select>
                        <div id="referredByError" class="error-message">Referred By is required.</div>
                    </div>
                    </div>
                    
                     <div class="col-md-4">
                         <div class="form-group pb-3">
                            <label for="employee" class="form-label"><b>Incharge<span class="text-danger">*</span> :</b></label>
                            <select class="form-control" id="employee" name="employee[]" data-placeholder="Choose one Employee" required multiple>
                                <option value="">-- Employee --</option>
                                    
                      <?php
                $queryCou = "SELECT id, name FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id LEFT JOIN roles AS c ON b.role = c.role_id WHERE a.status='Active' AND c.role_id != 17 AND b.entity_id = 1;";
                $resultCou = mysqli_query($conn, $queryCou);
            
                if ($resultCou) {
                    while ($row = mysqli_fetch_assoc($resultCou)) {
                        $courseId = $row['id'];
                        $courseName = $row['name'];
                        echo "<option value=\"$courseId\">$courseName</option>";
                    }
                }
            ?>
                            </select>
                            </div>
                        </div>

<!-- Input for Other Referred Name (Hidden Initially) -->
<div class="col-md-4" id="otherReferredDiv" style="display: none;">
    <div class="form-group pb-3">
        <label for="otherReferredName" class="form-label"><b>Other Referred Name</b><span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Enter Other Referred Name" name="otherReferredName" id="otherReferredName">
        <div id="otherReferredNameError" class="error-message">Other referred name is required.</div>
    </div>
</div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="form_type" value="add">
                    
                    <div class="modal-footer">
                        <button type="button" id="" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submitBtn" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="documentModalLabel">Add Documents</h5>
						<button type="button" class="btn-close" id="docCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3 needs-validation" name="frmAddDocument" id="addDocument" enctype="multipart/form-data" novalidate>
								<input type="hidden" name="hdnAction" value="addDocument">
                                <input type="hidden" name="stuId" id="stuId">
                                <div class="col-md-6">
										<label for="input18" class="form-label">Aadhar Card <span class="text-danger">*</span> </label>
										<div class="position-relative">
											<input type="file" class="form-control" id="aadhar" name="aadhar" accept=".jpg, .jpeg, .png"> 
										</div>
                                        <!-- Image preview -->
                        				<img id="aadharPreview" src="" alt="Aadhar Image" style="width: 100px; height: 100px; display: none;">		
								</div>
                                <div class="col-md-6">
										<label for="input18" class="form-label">Bank Passbook </label>
										<div class="position-relative">
											<input type="file" class="form-control" id="bank" name="bank" accept=".jpg, .jpeg, .png">
										</div>
                                        <!-- Image preview -->
                        				<img id="bankPreview" src="" alt="Bank Passbook" style="width: 100px; height: 100px; display: none;">		
								</div>
                                <div class="col-md-6">
										<label for="input18" class="form-label">PAN Card  </label>
										<div class="position-relative">
											<input type="file" class="form-control" id="pan" name="pan" accept=".jpg, .jpeg, .png">
										</div>
                                        <!-- Image preview -->
                        				<img id="panPreview" src="" alt="PAN Card Image" style="width: 100px; height: 100px; display: none;">		
								</div>
									
									
									
								
						</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitBtnDoc" class="btn btn-primary">Save changes</button>
                            </div>
						</form>
            </div>
						
				
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->


<!-- payment model -->

 <!--Add Project Modal -->

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
										<label for="traineeName" class="form-label">Trainee Name <span class="text-danger">*</span></label>
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


<!--Edit Payment Modal -->

 <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="projectModalLabel">Edit Payment</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3 needs-validation" name="frmEditPayment" id="editPayment" enctype="multipart/form-data" novalidate>
								<input type="hidden" name="hdnAction" value="editPayment">
								<input type="hidden" name="editPayId" id="editPayId">
									<div class="col-md-12">
										<label for="input13" class="form-label">Project Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="proNameE" id="proNameE" placeholder="Project Name" required readonly> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-notepad"></i></span>
										</div>
									</div>
                                    <div class="col-md-6">
										<label for="input13" class="form-label">Overall Amount <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="overAmntE" id="overAmntE" placeholder="Overall Amount" required readonly> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									<div class="col-md-6" style="display:none">
										<label for="input13" class="form-label">Amount Received <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="amntReceivedE" id="amntReceived" placeholder="Amount Received" required readonly> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									
									<div class="col-md-6">
										<label for="input13" class="form-label">Amount Paid <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="balanceE" id="balanceE" placeholder="Balance Amount" required> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Payment Date <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="date" class="form-control" id="dateE" name="dateE" placeholder="Received date" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
									</div>
									
									<div class="col-md-6">
										<label for="input19" class="form-label">Payment Mode <span class="text-danger">*</span></label>
										<select class="form-select" name="payModeE" id="payModeE" data-placeholder="Choose anything" required>
											<option selected value="">Choose....</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Net Banking">Net Banking</option>
                                            <option value="Online Payment">Online Payment</option>
                                            <option value="Cheque">Cheque</option>
                                        </select>
									</div>
									<div class="col-md-6">
										<label for="input19" class="form-label">Payment Status <span class="text-danger">*</span></label>
										<select class="form-select" name="payStatus" id="payStatus" data-placeholder="Choose anything" required>
											<option selected>Choose....</option>
                                            <option value="Unpaid">Unpaid</option>
                                            <option value="Partially Paid">Partially Paid</option>
                                            <option value="Paid">Paid</option>   
                                        </select>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Receipt/Transation Id  </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="transE" name="transE" placeholder=" Receipt/Transaction ID" >
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
										<div id="receiptError" class="error-message">Id is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Received By <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="receivedE" name="receivedE" placeholder="Received By" required>
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
									</div>
									
									
								</form>
						</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="updateBtn" class="btn btn-primary">Save changes</button>
                            </div>
						
            </div> 
						
				
	     </div> <!--end modal dialog -->
      
</div><!--end Modal Fade-->

<!-- HTML for Error Message --> 
<div id="balanceError" class="error-message" style="display:none;">Please check the amount. The balance cannot be negative.</div>

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

</script>

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

document.addEventListener('DOMContentLoaded', function() {
    // Get today's date
    var today = new Date();
    var yearToday = today.getFullYear();
    var monthToday = String(today.getMonth() + 1).padStart(2, '0');
    var dayToday = String(today.getDate()).padStart(2, '0');
    var maxDateToday = yearToday + '-' + monthToday + '-' + dayToday;

    // Set the max attribute for the joining date input field
    document.getElementById('jDate').setAttribute('max', maxDateToday);

    // Calculate the maximum date for 18 years ago
    var eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    var yearEighteenYearsAgo = eighteenYearsAgo.getFullYear();
    var monthEighteenYearsAgo = String(eighteenYearsAgo.getMonth() + 1).padStart(2, '0');
    var dayEighteenYearsAgo = String(eighteenYearsAgo.getDate()).padStart(2, '0');
    var maxDateEighteenYearsAgo = yearEighteenYearsAgo + '-' + monthEighteenYearsAgo + '-' + dayEighteenYearsAgo;

    // Set the max attribute for the date of birth input field
    document.getElementById('dob').setAttribute('max', maxDateEighteenYearsAgo);
});

document.getElementById('balance').addEventListener('input', function (e) {
    // Remove non-digit characters
    this.value = this.value.replace(/[^0-9]/g, '');
});
 document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').value = today;
    });
</script>
 <!-- end modal-->


