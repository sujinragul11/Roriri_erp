  <!-- Modal -->
  <div class="modal fade" id="addCourseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCourseModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="frmEditStudent" id="addCourse" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnAction" value="addCourse">
                    
                    <div class="modal-header">
                        <h4 class="modal-title" id="courseModelLabel">Add Course</h4>
                        <button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <h5>Course Details</h5>
                            <div class="row p-3">
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="Course" class="form-label"><b>Course</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Course" name="course" id="course">
                                    </div>
                                    <div id="nameError" class="error-message">Name is required.</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="Course" class="form-label"><b>Duration</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Duration" name="duration" id="duration">
                                    </div>
                                    <div id="durationError" class="error-message">Duration is required.</div>
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


<!-- Edit Course -->
      <!-- Modal -->
  <div class="modal fade" id="editCourseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCourseModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="frmEditStudent" id="editCourse" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnAction" value="editCourse">
                    <input type="hidden" name="editIdCourse" id="editIdCourse">
                    <div class="modal-header">
                        <h4 class="modal-title" id="courseModelLabel">Edit Course</h4>
                        <button type="button" class="btn-close"  id="editCloseBtn"  data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                    <h5>Course Details</h5>
                        <div class="row p-3">
                            <div class="col-md-4">
                                <div class="form-group pb-3">
                                    <label for="Course" class="form-label"><b>Course</b></label>
                                   <input type="text" class="form-control" placeholder="Enter Course" name="eCourse" id="eCourse">
                                </div>
                                <div id="nameErrorE" class="error-message">Name is required.</div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group pb-3">
                                    <label for="Course" class="form-label"><b>Duration</b></label>
                                   <input type="text" class="form-control" placeholder="Enter Duration" name="editDuration" id="editDuration">
                                </div>
                                <div id="durationErrorE" class="error-message">Duration is required.</div>
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
