  <!-- Add Subject Modal -->
  <div class="modal fade" id="addSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addSubjectModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="frmEditStudent" id="addSubject" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnAction" value="addSubject">
                    <div class="modal-header">
                        <h4 class="modal-title" id="subjectModelLabel">Add Subject</h4>
                        <button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <h5>Subject Details</h5>
                            <div class="row p-3">
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="subject" class="form-label"><b>Subject</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Subject" name="subject" id="subject">
                                    </div>
                                    <div id="nameError" class="error-message">Subject is required.</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="duration" class="form-label"><b>Duration</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Duration" name="duration" id="duration">
                                    </div>
                                    <div id="durationError" class="error-message">Duration is required.</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="course_id" class="form-label"><b>Course</b></label>
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">-- Select Course --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div><!-- end modal-->

  <!-- Edit Subject Modal -->
  <div class="modal fade" id="editSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editSubjectModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="frmEditStudent" id="editSubject" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnAction" value="editSubject">
                    <input type="hidden" name="editIdSubject" id="editIdSubject">
                    <div class="modal-header">
                        <h4 class="modal-title" id="subjectModelLabel">Edit Subject</h4>
                        <button type="button" class="btn-close" id="editCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                    <h5>Subject Details</h5>
                        <div class="row p-3">
                            <div class="col-md-4">
                                <div class="form-group pb-3">
                                    <label for="eSubject" class="form-label"><b>Subject</b></label>
                                   <input type="text" class="form-control" placeholder="Enter Subject" name="eSubject" id="eSubject">
                                </div>
                                <div id="nameErrorE" class="error-message">Subject is required.</div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group pb-3">
                                    <label for="editDuration" class="form-label"><b>Duration</b></label>
                                   <input type="text" class="form-control" placeholder="Enter Duration" name="editDuration" id="editDuration">
                                </div>
                                <div id="durationErrorE" class="error-message">Duration is required.</div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group pb-3">
                                    <label for="editCourse" class="form-label"><b>Course</b></label>
                                    <select class="form-control" name="editCourse" id="editCourse">
                                        <option value="">-- Select Course --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div><!-- end modal-->
