                              <!-- Modal -->
<div class="modal fade" id="editSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="frmEditSubject" id="editSubject" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnAction" value="hdnEditSubject">
                    <input type="hidden" name="editId" value="" id="editId">
                    
                    <div class="modal-header">
                        <h4 class="modal-title" id="staticBackdropLabel">Edit Subject</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="row p-3">
                       
                            <div class="col-sm-6">
                                <div class="form-group pb-3">
                                    <label for="editsub_name" class="form-label"><b>Subject Name</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Subject name" name="editsub_name" id="editsub_name" required="required" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group pb-3">
                                    <label for="edit_duration" class="form-label"><b>Subject Duration</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Subject Duration" name="edit_duration" id="edit_duration" required="required"> 
                                </div>
                            </div>
                        </div>
                        </div>
                        <div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateBtn">Save changes</button>
                    </div>
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->