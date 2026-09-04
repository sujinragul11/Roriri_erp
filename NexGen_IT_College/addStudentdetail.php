<div class="modal fade" id="StudentdetailModal" tabindex="-1" aria-labelledby="StudentdetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="StudentdetailModalLabel">Student Detail</h5>
                <button type="button" class="btn-close" id="modalCloseBtnDet" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmAddPayment" id="addDetails" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="addDetails">
                    <input type="hidden" name="stuId" id="stuId">

                    <div class="col-md-12">
                        <b><label for="name" class="form-label">Student Name <span class="text-danger">*</span></label></b>
                        <div class="position-relative">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Student Name" required readonly>
                        </div>
                    </div>

                    <!-- First row of three fields -->
                    <div class="row p-2">
                        <div class="col-md-4">
                            <b><label for="College_Course" class="form-label">College Course <span class="text-danger">*</span></label></b>
                            <div class="position-relative ">
                                <select class="form-control" id="course" name="course" required="required" readonly>
                                            <option selected value="">--Select--</option>
                                            <?php $sel_course="SELECT * FROM course_tbl WHERE status='Active'";
                                                $res_course = mysqli_query($conn , $sel_course); 
                                                while($row = mysqli_fetch_array($res_course , MYSQLI_ASSOC)) { 
                                                $course_id = $row['course_id'];
                                                $course_name = $row['course_name'];
                                                
                                                echo '<option value="' . $course_id . '">' . $course_name . '</option>';
                                                } ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b><label for="coursefee" class="form-label">Course Fee <span class="text-danger">*</span></label></b>
                            <div class="position-relative">
                                <input type="text" class="form-control" name="coursefee" id="coursefee" placeholder="Course fee" required readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b><label for="fatherName" class="form-label">Father Name <span class="text-danger">*</span></label></b>
                            <div class="position-relative">
                                <input type="text" class="form-control" name="fatherName" id="fatherName" placeholder="Father name" required>
                                <div id="fatherNameError" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Second row of three fields -->
                    <div class="row p-2">
                        <div class="col-md-4">
                            <b><label for="fatherOccupation" class="form-label">Father Occupation <span class="text-danger">*</span></label></b>
                            <div class="position-relative ">
                                <input type="text" class="form-control" name="fatherOccupation" id="fatherOccupation" placeholder="Father occupation" required>
                                <div id="fatherOccupationError" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b><label for="fatherPhone" class="form-label">Father Phone Number <span class="text-danger">*</span></label></b>
                            <div class="position-relative ">
                                <input type="number" class="form-control" name="fatherPhone" id="fatherPhone" placeholder="Father phone no." required>
                                <div id="fatherPhoneError" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b><label for="motherName" class="form-label">Mother Name <span class="text-danger">*</span></label></b>
                            <div class="position-relative ">
                                <input type="text" class="form-control" name="motherName" id="motherName" placeholder="Mother name" required>
                                <div id="motherNameError" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Third row of three fields -->
                    <div class="row p-2">
                        <div class="col-md-4">
                            <b><label for="motherOccupation" class="form-label">Mother Occupation <span class="text-danger">*</span></label></b>
                            <div class="position-relative ">
                                <input type="text" class="form-control" id="motherOccupation" name="motherOccupation" placeholder="Mother occupation" required>
                                <div id="motherOccupationError" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b><label for="motherPhone" class="form-label">Mother Phone Number</label></b>
                            <div class="position-relative">
                                <input type="number" class="form-control" id="motherPhone" name="motherPhone" placeholder="Mother phone no." required>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b><label for="tenthMark" class="form-label">10th Mark <span class="text-danger">*</span></label></b>
                            <div class="position-relative ">
                                <input type="number" class="form-control" id="tenthMark" name="tenthMark" placeholder="10th mark" required>
                                <div id="tenthMarkError" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Fourth row of three fields -->
                    <div class="row p-2">
                        
                        <div class="col-md-4">
                            <b><label for="twelfthMark" class="form-label">12th Mark </label></b>
                            <div class="position-relative">
                                <input type="number" class="form-control" id="twelfthMark" name="twelfthMark" placeholder="12th mark" required>
                                <div id="twelftMarkError" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b><label for="tenthMarksheet" class="form-label">10th Marksheet </label></b>
                            <div class="position-relative ">
                                <input type="file" class="form-control" id="tenthMarksheet" name="tenthMarksheet" accept="image/*" required>
                                <img id="editTen" src="" alt="10th MarkSheet" style="width: 100px; height: 100px;">
                            </div>
                            
                        </div>
                        <div class="col-md-4">
                            <b><label for="twelfthMarksheet" class="form-label">12th Marksheet </label></b>
                            <div class="position-relative ">
                                <input type="file" class="form-control" id="twelfthMarksheet" name="twelfthMarksheet" accept="image/*" required>
                                <img id="editTwelve" src="" alt="12th MarkSheet" style="width: 100px; height: 100px;">
                            </div>
                            
                        </div>
                        
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="detailsubmitBtn" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
