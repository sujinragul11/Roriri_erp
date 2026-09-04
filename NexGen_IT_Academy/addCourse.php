<!-- Modal -->
<div class="modal fade" id="addCourseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="frmAddStudent" id="addCourse" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addCourse">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Course</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="course_name" class="form-label"><b>Course Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter course Name" name="course_name" id="course_name" required>
                                <div id="fnameError" class="error-message" style="display: none; color: red;">Please enter course_name.</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label><b>Subject</b></label>
                                    <div class="row">
                                     <?php $subQuery = "SELECT * FROM `subject_tbl` WHERE status='Active';"; 
                                       $resQuery = mysqli_query($conn, $subQuery);
                                      $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
									
                                    $sub_id = $row['id']; 
                                    $sub_name=$row['subject_name'];
                                  
                                    ?>
                                        <div class="col-sm-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="html" name="subject[]" value="<?php echo $sub_id; ?>" required>
                                                

                                                <label class="form-check-label" for="html"><?php echo $sub_name; ?></label>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        <?php } ?>
                                        <div id="SubError" class="error-message" style="display: none; color: red;">Select subjects.</div>
                                    </div>
                                    
                                </div>
                            </div>

                        <!-- <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="course_duration" class="form-label"><b>Duration</b></label>
                                <select class="form-control" id="course_duration" name="duration">
                                    <option value="3 months">-- select --</option>
                                    <option value="3 months">3 months</option>
                                    <option value="6 months">6 months</option>
                                    <option value="12 months">12 months</option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="course_fees"><b>Fees</b></label>
                                <input type="text" class="form-control" placeholder="Enter Course Fees" id="course_fees" name="fee">
                            </div>
                        </div>  -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitCoursebtn" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
