<!--Add Project Modal -->

<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="projectModalLabel">Add Payment</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddPayment" id="addPayment" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="addPayment">
								<input type="hidden" name="proId" id="proId">
									<div class="col-md-12">
										<label for="input13" class="form-label">Project Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="proName" id="proName" placeholder="Project Name" required disabled> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-notepad"></i></span>
										</div>
									</div>
                                    <div class="col-md-6">
										<label for="input13" class="form-label">Overall Amount <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="overAmnt" id="overAmnt" placeholder="Overall Amount" required disabled> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="input13" class="form-label">Amount Received <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="amntReceived" id="amntReceived" placeholder="Amount Received" required disabled> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									
									<div class="col-md-6">
										<label for="input13" class="form-label">Amount Paid <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" name="balance" id="balance" placeholder="Enter the Amount" required> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
										<div id="amountError" class="error-message">Amount is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input13" class="form-label">Balance Amount <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" name="remaining" id="remaining" placeholder="Balance Amount" required disabled> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
										<div id="balanceError" class="error-message" style="display:none;">Please check the amount. The balance cannot be negative.</div>
	
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Payment Date <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="date" class="form-control" id="date" name="date" placeholder="Received date" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
										<div id="dateError" class="error-message">Date is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input19" class="form-label">Payment Mode <span class="text-danger">*</span></label>
										<select class="form-select" name="payMode" id="payMode" required>
											<option selected value="">Choose....</option>
											<option value="Cash">Cash</option>
											<option value="Net Banking">Net Banking</option>
											<option value="Online Payment">Online Payment</option>
											<option value="Cheque">Cheque</option>
										</select>
										<div id="modeError" class="error-message">Payment Mode is required.</div>
									</div>
                                    <div class="col-md-6">
										<label for="input16" class="form-label">Receipt/Transation Id </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="trans" name="trans" placeholder=" Receipt/Transaction ID" required>
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
										
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Received By <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="received" name="received" placeholder="Received By" required>
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
										<div id="receivedError" class="error-message">Receiver Name is required.</div>
									</div>
									
									
								</form>
						</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="submitBtn" class="btn btn-primary">Save changes</button>
                            </div>
						
            </div>
						
				
	    </div> <!--end modal dialog-->
      
</div><!--end Modal Fade-->


<!--Edit Project Modal -->

<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="projectModalLabel">Edit Payment</h5>
						<button type="button" class="btn-close" id="editCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmEditPayment" id="editPayment" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="editPayment">
								<input type="hidden" name="editPayId" id="editPayId">
									<div class="col-md-12">
										<label for="input13" class="form-label">Project Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="proNameE" id="proNameE" placeholder="Project Name" required disabled> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-notepad"></i></span>
										</div>
									</div>
                                    <div class="col-md-6">
										<label for="input13" class="form-label">Overall Amount <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="overAmntE" id="overAmntE" placeholder="Overall Amount" required disabled> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									<div class="col-md-6" style="display:none">
										<label for="input13" class="form-label">Amount Received <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="amntReceivedE" id="amntReceivedE" placeholder="Amount Received" required disabled> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></i></span>
										</div>
									</div>
									
									<div class="col-md-6">
										<label for="input13" class="form-label">Amount Paid <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="balanceE" id="balanceE" placeholder="Balance Amount" required> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
										<div id="amountErrorE" class="error-message">Amount is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Payment Date <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="date" class="form-control" id="dateE" name="dateE" placeholder="Received date" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
										<div id="dateErrorE" class="error-message">Date is required.</div>
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
										<div id="modeErrorE" class="error-message">Payment Mode is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input19" class="form-label">Payment Status <span class="text-danger">*</span></label>
										<select class="form-select" name="payStatus" id="payStatus" data-placeholder="Choose anything" required>
											<option selected value="">Choose....</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Completed">Completed</option>
                                             
                                        </select>
										<div id="statusErrorE" class="error-message">Payment Status is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Receipt/Transation Id  </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="transE" name="transE" placeholder=" Receipt/Transaction ID" required>
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Received By <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="receivedE" name="receivedE" placeholder="Received By" required>
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
										<div id="receivedErrorE" class="error-message">Receiver Name is required.</div>
									</div>
									
									
								</form>
						</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="updateBtn" class="btn btn-primary">Save changes</button>
                            </div>
						
            </div>
						
				
	    </div> <!--end modal dialog-->
      
</div><!--end Modal Fade-->

<!-- HTML for Error Message -->
<div id="balanceError" class="error-message" style="display:none;">Please check the amount. The balance cannot be negative.</div>

<!-- JavaScript -->
<script>
function calculateBalance() {
    const overallAmount = parseFloat(document.getElementById('overAmnt').value) || 0;
    const amountReceived = parseFloat(document.getElementById('amntReceived').value) || 0;
    const amountPaid = parseFloat(document.getElementById('balance').value) || 0;

    let balance = overallAmount - amountReceived; // Default balance calculation

    if (amountPaid > 0) {
        balance = overallAmount - (amountReceived + amountPaid);
    }

    if (balance < 0) {
        document.getElementById('remaining').value = ''; // Clear the remaining field
        document.getElementById('balanceError').style.display = 'block'; // Show the error message
    } else {
        document.getElementById('remaining').value = balance.toFixed(2); // Update the remaining field
        document.getElementById('balanceError').style.display = 'none'; // Hide the error message
    }
}

document.getElementById('balance').addEventListener('input', calculateBalance);
document.getElementById('amntReceived').addEventListener('input', calculateBalance);
document.getElementById('overAmnt').addEventListener('input', calculateBalance);
</script>
