
<!-- Modal -->
<div class="modal fade" id="addProjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddProject" id="frmAddProject" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addProject">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Mini Project</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="course" class="form-label"><b>Course Name</b></label>
                                <select name="course" class="form-select" id="course" required>
                                        <option value="">--Select the Course--</option>
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
                                <label for="projectName" class="form-label"><b>Project Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter Project Name" id="projectName" name="projectName" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="duration" class="form-label"><b>Duration (Hrs)</b></label>
                                <input type="number" class="form-control" placeholder="Enter Duration in Hours" id="duration" name="duration" min="0" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="description" class="form-label"><b>Project Description</b></label>
                                <textarea class="form-control" placeholder="Enter Project Description" id="description" name="description" rows="3"></textarea>
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


    <div class="modal fade" id="editProjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="frmEditProject" id="frmEditProject" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnAction" value="hdnEditProject">
                    <input type="hidden" name="editId" value="" id="editId">
                    
                    <div class="modal-header">
                        <h4 class="modal-title" id="staticBackdropLabel">Edit Project</h4>
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
                                    <label for="projectNameEdit" class="form-label"><b>Project Name</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Project Name" id="projectNameEdit" name="projectNameEdit" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="durationEdit" class="form-label"><b>Duration (Hrs)</b></label>
                                    <input type="number" class="form-control" placeholder="Enter Duration in Hours" id="durationEdit" name="durationEdit" min="0" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="descriptionEdit" class="form-label"><b>Description</b></label>
                                    <textarea class="form-control" placeholder="Enter Project Description" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
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