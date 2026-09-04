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
    <input type="hidden" name="empId" id="id">

    <!-- Aadhar Card -->
    <div class="col-md-12 d-flex align-items-center">
        <div class="me-3">
            <label for="aadhar" class="form-label">Aadhar Card </label>
            <input type="file" class="form-control" id="aadhar" name="aadhar" accept=".jpg, .jpeg, .png">
            <div id="aadharError" class="error-message text-danger mt-1">Aadhar is required.</div>
        </div>
        <img id="aadharPreview" src="" alt="Aadhar Image" style="width: 200px; height: 100px; display: none; border: 1px solid #ddd;">
    </div>

    <!-- Bank Passbook -->
    <div class="col-md-12 d-flex align-items-center">
        <div class="me-3">
            <label for="bank" class="form-label">Bank Passbook </label>
            <input type="file" class="form-control" id="bank" name="bank" accept=".jpg, .jpeg, .png">
            <div id="bankError" class="error-message text-danger mt-1">Bank Passbook is required.</div>
        </div>
        <img id="bankPreview" src="" alt="Bank Passbook" style="width: 200px; height: 100px; display: none; border: 1px solid #ddd;">
    </div>

    <!-- PAN Card -->
    <div class="col-md-12 d-flex align-items-center">
        <div class="me-3">
            <label for="pan" class="form-label">PAN Card </label>
            <input type="file" class="form-control" id="pan" name="pan" accept=".jpg, .jpeg, .png">
            <div id="panError" class="error-message text-danger mt-1">PAN Card is required.</div>
        </div>
        <img id="panPreview" src="" alt="PAN Card Image" style="width: 200px; height: 100px; display: none; border: 1px solid #ddd;">
    </div>
    
     <!-- Experiense Card -->
    <div class="col-md-12 d-flex align-items-center">
        <div class="me-3">
            <label for="experience" class="form-label">Experience Certificate </label>
            <input type="file" class="form-control" id="experience" name="experience" accept=".jpg, .jpeg, .png ,pdf">
            <div id="exError" class="error-message text-danger mt-1">Experience Certificate is required.</div>
        </div>
        <img id="experiencePreview" src="" alt="Experience Certificate Image" style="width: 200px; height: 100px; display: none; border: 1px solid #ddd;">
    </div>
    
      <div class="col-md-12 d-flex align-items-center">
        <div class="me-3">
            <label for="offerLetter" class="form-label">Offer Letter </label>
            <input type="file" class="form-control" id="offerLetter" name="offerLetter" accept=".jpg, .jpeg, .png ,pdf">
            <div id="offerLetterError" class="error-message text-danger mt-1">Offer Letter is required.</div>
        </div>
        <img id="offerLetterPreview" src="" alt="Offer Letter Image" style="width: 200px; height: 100px; display: none; border: 1px solid #ddd;">
    </div>
    
      <div class="col-md-12 d-flex align-items-center">
        <div class="me-3">
            <label for="paySlip" class="form-label">Pay Slip</label>
            <input type="file" class="form-control" id="paySlip" name="paySlip" accept=".jpg, .jpeg, .png ,pdf">
            <div id="paySlipError" class="error-message text-danger mt-1">Pay Slip is required.</div>
        </div>
        <img id="paySlipPreview" src="" alt="Pay Slip Image" style="width: 200px; height: 100px; display: none; border: 1px solid #ddd;">
    </div>
    <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitBtnDoc" class="btn btn-primary">Save changes</button>
                            </div>
</form>

						</div>
                            
						
            </div>
						
				
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->
