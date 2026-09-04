<!-- Modal -->
<div class="modal fade" id="addSyllabusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddStudent" id="addSyllabus" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addSyllabus">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Subject</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                    <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="course_name" class="form-label"><b>Course Name</b></label>
                                <select class="form-control" id="course_name" name="course_name" required="required">
                                        <option>----select----</option>

                                        <?php  
                                        $select_course="SELECT * FROM `course_tbl` WHERE course_status='Active'AND entity_id=3";
                                        $res_course = mysqli_query($conn , $select_course); 
                                             while($row = mysqli_fetch_array($res_course , MYSQLI_ASSOC)) { 
                                                $course_id = $row['course_id'];
                                                $course_name = $row['course_name'];
                                                
                                               
                                                echo '<option value="' . $course_id . '">' . $course_name . '</option>';
                                             }
                                        ?> 
                                        
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="sub_name" class="form-label"><b>Subject Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter topic name" name="sub_name" id="sub_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="sub_duration" class="form-label"><b>Subject Duration</b></label>
                                <input type="text" class="form-control" placeholder="Enter last name" name="sub_duration" id="sub_duration">
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
