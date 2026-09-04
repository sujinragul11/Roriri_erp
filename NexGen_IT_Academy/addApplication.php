
<!-- Modal -->
<div class="modal fade" id="addApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddStudent" id="addApplication" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addApplication">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Application</h4>
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
                                <label for="application_name" class="form-label"><b>Application Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter Application Name" id="application_name" name="application_name" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="application_duration" class="form-label"><b>Duration</b></label>
                                <input type="text" class="form-control" placeholder="Enter Duration in Hours" id="application_duration" name="application_duration" min="0" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="application_discription" class="form-label"><b>Application Description</b></label>
                                <textarea class="form-control" placeholder="Enter Application Description" id="application_discription" name="application_discription" rows="3"></textarea>
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
