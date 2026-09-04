
<!-- Modal -->
    <div class="modal fade" id="editAssignApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="frmEditAssignApplication" id="editAssignApplication" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnAction" value="hdnEditAssignApplication">
                    <input type="hidden" name="editId" value="" id="editId">
                    
                    <div class="modal-header">
                        <h4 class="modal-title" id="staticBackdropLabel">Edit Application</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="row p-3">
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="courseEdit" class="form-label"><b>Course Name</b></label>
                                    <select name="courseEdit" class="form-select" id="courseEdit" required>
                                        <option value="0">--Select the Course--</option>
                                        <?php $sql="SELECT id, course_name FROM academy_course_details WHERE status='Available'";
                                         $res_role = mysqli_query($conn , $sql); 
                                         while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                                            $course_id = $row['id'];
                                            $course_name = $row['course_name'];
                                           
                                            echo '<option value="' . $course_id . '">' . $course_name . '</option>';
                                         }   ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="edit_application_name" class="form-label"><b>Application Name</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Application Name" id="edit_application_name" name="edit_application_name" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="edit_application_duration" class="form-label"><b>Duration</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Duration in Hours" id="edit_application_duration" name="edit_application_duration" min="0" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="edit_application_discription" class="form-label"><b>Application Description</b></label>
                                    <textarea class="form-control" placeholder="Enter Application Description" id="edit_application_discription" name="edit_application_discription" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateBtn">Save changes</button>
                    </div>
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->