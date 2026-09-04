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