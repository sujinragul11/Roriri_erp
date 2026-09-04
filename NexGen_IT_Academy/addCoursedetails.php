<?php
$selQuery = "SELECT course_tbl.*,
       subject_tbl.*
      FROM subject_tbl
      LEFT JOIN course_tbl ON course_tbl.course_id = subject_tbl.course_id
      WHERE course_tbl.course_status='Active' AND entity_id=3 AND subject_tbl.sub_status='Active'";
$resQuery = mysqli_query($conn , $selQuery); 

?>
<!-- Modal -->
<div class="modal fade" id="addCourseDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddStudent" id="addCourseDetails" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addCourseDetails">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Course</h4>
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
                                <label for="course_duration" class="form-label"><b>Duration</b></label>
                                <select class="form-control" id="course_duration" name="course_duration">
                                    <option value="3 months">-- select --</option>
                                    <option value="3 months">3 months</option>
                                    <option value="6 months">6 months</option>
                                    <option value="12 months">12 months</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="course_fees"><b>Fees</b></label>
                                <input type="text" class="form-control" placeholder="Enter Course Fees" id="course_fees" name="course_fees">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label><b>Subject</b></label>
                                    <div class="row">
                                        <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                        
                                        $sub_id = $row['sub_id']; 
                                    
                                        $course_name=$row['course_name'];
                                        $sub_name=$row['sub_name'];
                                        $sub_duration = $row['sub_duration'];
                                        ?>
                                        <div class="col-sm-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="html" name="subject[]" value="<?php echo $sub_id; ?>">
                                                <label class="form-check-label" for="html"><?php echo $sub_name; ?></label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    
                                </div>
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
