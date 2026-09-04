<!-- Modal -->
<div class="modal fade" id="addSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddStudent" id="addSubject" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addSubject">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Subject</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="sub_name" class="form-label"><b>Subject Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter Subject Name" name="sub_name" id="sub_name" required >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="sub_duration" class="form-label"><b>Subject Duration</b></label>
                                <input type="text" class="form-control" placeholder="Enter Subject Duration" name="sub_duration" id="sub_duration" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clientModalLabel">Study Material</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
                    <div class="card-body p-4">
<form class="row g-3 needs-validation" name="frmAddDepartment" id="addDepartment" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="hdnAction" value="addDepartment">
    <input type="hidden" name="EditRecordId" id="EditRecordId" >
    
    <!-- Image Upload Field -->
<div class="col-md-12">
    <label for="projectImage" class="form-label">Study Material</label>
    <input 
        type="file" 
        class="form-control" 
        name="projectMaterial[]" 
        id="projectMaterial" 
        accept=".jpg,.jpeg,.png,.gif,.bmp,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.mp4,.avi,.mkv,.txt,.zip,.rar" 
        multiple>
    <div class="invalid-feedback">Please upload at least one file.</div>
</div>

<!-- Display Existing Images with Remove Option -->
                    <div class="col-md-12">
                        <label class="form-label">Existing Meterial</label>
                        <div id="existingImagesContainer"></div>
                    </div>

    <!-- Description Field with Quill Editor -->
    <div class="col-md-12">
        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
        <div id="editor" style="height: 200px;"></div>
        <textarea class="form-control" name="description" id="description" style="display:none;" required></textarea>
        <div class="invalid-feedback">Please enter a description.</div>
    </div>



    

    <!-- Modal Footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

</div>
                            
						
            </div>
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->