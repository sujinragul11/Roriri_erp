
                                  



                                  <!-- Modal -->
<div class="modal fade" id="editCourseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="frmEditCourse" id="editCourse" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="hdnEditCourse">
                <input type="hidden" name="editId" value="" id="editId">

                <div class="modal-header">
                    <h4 class="modal-title" id="editCourseModalLabel">Edit Course</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row p-3">
                        <div class="col-sm-6">
                            <div class="form-group pb-3">
                                <label for="edit_name" class="form-label"><b>Course Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter course name" name="edit_name" id="edit_name" readonly>
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
                                                <input type="checkbox" class="form-check-input" id="html"  id="editSubject" name="subject[]" value="<?php echo $sub_id; ?>">
                                                <label class="form-check-label" for="html"><?php echo $sub_name; ?></label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    
                                </div>
                            </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateBtn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
