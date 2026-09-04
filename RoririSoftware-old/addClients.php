<!-- Modal -->

<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clientModalLabel">Add New Client</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddClient" id="addClient" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="addClient">
									<div class="col-md-6">
										<label for="input13" class="form-label">Client Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="Cname" id="Cname" placeholder="Client Name" required>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										<div id="nameError" class="error-message">Name is required.</div>
										
									</div>
									<div class="col-md-6">
										<label for="input14" class="form-label">Company Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="compName" id="compName" placeholder="Last Name" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
											
										</div>
										<div id="companyError" class="error-message">Company name is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Email <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="email" class="form-control" id="cEmail" name="cEmail" placeholder="Email" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
											
										</div>
										<div id="emailError" class="error-message">Email is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input15" class="form-label">Phone <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="tel" class="form-control" name="cPhone" id="cPhone" placeholder="Phone"  pattern="\d{10}"  maxlength="10" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-microphone'></i></span>
											
										</div>
										<div id="phoneError" class="error-message">Phone is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">GST </label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="gst" name="gst" placeholder="GST" >
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
										</div>
									</div>
                                    <div class="col-md-6">
										<label for="input23" class="form-label">Address <span class="text-danger">*</span></label>
										<textarea class="form-control" id="cAddress" name="cAddress" placeholder="Address ..." rows="3" required></textarea>
										<div id="addressError" class="error-message">Address is required.</div>
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


<!-- Edit Modal  -->

<!-- Modal -->

<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clientModalLabel">Edit Client</h5>
						<button type="button" class="btn-close" id="editCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddClient" id="editClient" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="editClient">
                                <input type="hidden" name="editIdClient" id="editIdClient" value="">
									<div class="col-md-6">
										<label for="input13" class="form-label">Client Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="CnameE" id="CnameE" placeholder="Client Name" required>
                                           
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
										</div>
										<div id="nameErrorE" class="error-message">Name is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input14" class="form-label">Company Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="compNameE" id="compNameE" placeholder="Last Name" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
										</div>
										<div id="comErrorE" class="error-message">This is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Email <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="email" class="form-control" id="cEmailE" name="cEmailE" placeholder="Email" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
										<div id="emailErrorE" class="error-message">Email is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input15" class="form-label">Phone <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="tel" class="form-control" name="cPhoneE" id="cPhoneE" placeholder="Phone"  pattern="\d{10}"  maxlength="10" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-microphone'></i></span>
										</div>
										<div id="phoneErrorE" class="error-message">This is required</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">GST <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="gstE" name="gstE" placeholder="GST" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
										</div>
									</div>
                                    <div class="col-md-6">
										<label for="input23" class="form-label">Address <span class="text-danger">*</span></label>
										<textarea class="form-control" id="cAddressE" name="cAddressE" placeholder="Address ..." rows="3" required></textarea>
										<div id="addressErrorE" class="error-message">Address is required.</div>
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
<script>
document.getElementById('cPhone').addEventListener('input', function (e) {
    const value = e.target.value;

    // Remove non-numeric characters
    e.target.value = value.replace(/[^0-9]/g, '');

    // Limit the length to 10 digits
    if (value.length > 10) {
        e.target.value = value.slice(0, 10);
    }
});
</script>
<script>
document.getElementById('cPhoneE').addEventListener('input', function (e) {
    const value = e.target.value;

    // Remove non-numeric characters
    e.target.value = value.replace(/[^0-9]/g, '');

    // Limit the length to 10 digits
    if (value.length > 10) {
        e.target.value = value.slice(0, 10);
    }
});
</script>