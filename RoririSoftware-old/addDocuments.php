<!-- Modal -->

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="documentModalLabel">Add Documents</h5>
						<button type="button" class="btn-close" id="docCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddDocument" id="addDocument" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="addDocument">
                                <input type="hidden" name="empId" id="id">
                                <div class="col-md-6">
										<label for="input18" class="form-label">Aadhar Card <span class="text-danger">*</span> </label>
										<div class="position-relative">
											<input type="file" class="form-control" id="aadhar" name="aadhar" accept=".jpg, .jpeg, .png">
											<div id="aadharError" class="error-message">Aadhar is required.</div>
										</div>
                                        <!-- Image preview -->
                        				<img id="aadharPreview" src="" alt="Aadhar Image" style="width: 100px; height: 100px; display: none;">		
								</div>
                                <div class="col-md-6">
										<label for="input18" class="form-label">Bank Passbook <span class="text-danger">*</span> </label>
										<div class="position-relative">
											<input type="file" class="form-control" id="bank" name="bank" accept=".jpg, .jpeg, .png">
											<div id="bankError" class="error-message">Bank is required.</div>
										</div>
                                        <!-- Image preview -->
                        				<img id="bankPreview" src="" alt="Bank Passbook" style="width: 100px; height: 100px; display: none;">		
								</div>
                                <div class="col-md-6">
										<label for="input18" class="form-label">PAN Card <span class="text-danger">*</span> </label>
										<div class="position-relative">
											<input type="file" class="form-control" id="pan" name="pan" accept=".jpg, .jpeg, .png">
											<div id="panError" class="error-message">Pan Card is required.</div>
										</div>
                                        <!-- Image preview -->
                        				<img id="panPreview" src="" alt="PAN Card Image" style="width: 100px; height: 100px; display: none;">		
								</div>
									
									
									
								</form>
						</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitBtnDoc" class="btn btn-primary">Save changes</button>
                            </div>
						
            </div>
						
				
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->
