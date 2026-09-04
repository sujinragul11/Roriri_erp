<!-- Modal -->

<div class="modal fade" id="addEnquireModal" tabindex="-1" aria-labelledby="addEnquireModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="enquireModalLabel">Add New Enquiry</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddEnquire" id="addEnquire" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="addEnquire">
									<div class="col-md-6">
										<label for="input13" class="form-label">Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
										</div>
										<div id="nameError" class="error-message">Name is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input14" class="form-label">Company Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="compName" id="compName" placeholder="Company Name" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
										</div>
										<div id="companyError" class="error-message">Company Name is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Email </label>
										<div class="position-relative input-icon">
											<input type="email" class="form-control" id="eEmail" name="eEmail" placeholder="Email" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
										<div id="emailError" class="error-message">Email is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input15" class="form-label">Phone <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="tel" class="form-control" name="ePhone" id="ePhone" placeholder="Phone"  pattern="\d{10}"  maxlength="10" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-microphone'></i></span>
										</div>
										<div id="phoneError" class="error-message">Phone is required.</div>
									</div>
									
                                    <div class="col-md-6">
										<label for="input23" class="form-label">Address <span class="text-danger">*</span></label>
										<textarea class="form-control" id="eAddress" name="eAddress" placeholder="Address ..." rows="3" required></textarea>
										<div id="addressError" class="error-message">Address is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Enquiry Details <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
                                        <textarea class="form-control" id="details" name="details" placeholder="Enquire Details ..." rows="3" required></textarea>
										<div id="enquiryError" class="error-message">Enquiry required.</div>
										</div>
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
<script>
document.getElementById('ePhone').addEventListener('input', function (e) {
    const value = e.target.value;

    // Remove non-numeric characters
    e.target.value = value.replace(/[^0-9]/g, '');

    // Limit the length to 10 digits
    if (value.length > 10) {
        e.target.value = value.slice(0, 10);
    }
});
</script>

<!-- Edit Modal  -->

<!-- Modal -->

<div class="modal fade" id="editEnquireModal" tabindex="-1" aria-labelledby="editEnquireModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="enquireModalLabel">Edit Enquiry</h5>
						<button type="button" class="btn-close" id="modalCloseBtnEdit" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmEditEnquire" id="editEnquire" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="editEnquire">
                                <input type="hidden" name="editIdEnquire" id="editIdEnquire" value="">
									<div class="col-md-6">
										<label for="input13" class="form-label">Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="EnameE" id="EnameE" placeholder="Client Name" required>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
										</div>
										<div id="nameErrorE" class="error-message">Name is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input14" class="form-label">Company Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="compNameE" id="compNameE" placeholder="Company Name" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
										</div>
										<div id="companyErrorE" class="error-message">Company Name is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Email </label>
										<div class="position-relative input-icon">
											<input type="email" class="form-control" id="EmailE" name="EmailE" placeholder="Email" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
										<div id="emailErrorE" class="error-message">Email is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input15" class="form-label">Phone <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="tel" class="form-control" name="PhoneE" id="PhoneE" placeholder="Phone"  pattern="\d{10}"  maxlength="10" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-microphone'></i></span>
										</div>
										<div id="phoneErrorE" class="error-message">Phone is required.</div>
									</div>
							
                                    <div class="col-md-6">
										<label for="input23" class="form-label">Address <span class="text-danger">*</span></label>
										<textarea class="form-control" id="AddressE" name="AddressE" placeholder="Address ..." rows="3" required></textarea>
										<div id="addressErrorE" class="error-message">Address is required.</div>
									</div>
                                    <div class="col-md-6">
										<label for="input16" class="form-label">Enquiry Details <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
                                        <textarea class="form-control" id="detailsE" name="detailsE" placeholder="Enquire Details ..." rows="3" required></textarea>
										</div>
										<div id="enquiryErrorE" class="error-message">Enquiry required.</div>
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