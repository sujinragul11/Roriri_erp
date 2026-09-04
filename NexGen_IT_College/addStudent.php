       <!-- Modals -->
       <div class="modal fade" id="addStudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="frmAddStudent" id="addStudent" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <input type="hidden" name="hdnAction" value="addStudent">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addStudentModalLabel">Add Student</h4>
                        <button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                  
                <div class="modal-body p-3">
                    <div class="row p-3">
                        <!-- Basic Details Section -->
                        <div class="col-12">
                            <h5 class="pb-2">Basic Details</h5>
                            <div class="row">
                                <!-- Basic details fields here -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="fname" class="form-label"><b>Name</b><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"  pattern="[A-Za-z]+( [A-Za-z]+)?(\.[A-Za-z]+)?" placeholder="Enter Student First Name" name="name" id="name" required="required">
                                        <div id="fnameError" class="error-message">Please Enter your name</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="dob" class="form-label"><b>Date of Birth</b><span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Enter Date of Birth" name="dob" id="dob" required="required">
                                        <div id="dobError" class="text-danger" style="display: none;">You must be at least 18 years old.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="gender" class="form-label"><b>Gender</b><span class="text-danger">*</span></label>
                                        <select class="form-control" id="gender" name="gender" required="required">
                                            <option selected value="">----select----</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <div id="genderError" class="error-message">Gender is required.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="mobile" class="form-label"><b>Mobile No</b><span class="text-danger">*</span></label>
                                        <input type="number" pattern="[0-9]{10}" class="form-control" maxlength="10" placeholder="Enter Mobile No" name="phone" id="phone" required="required">
                                        <div id="phoneError" class="error-message">Phone number is required.</div>
                                    </div>

                                </div>
                               
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="email" class="form-label"><b>Email</b><span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" placeholder="Enter Email" name="email" id="email" required="required">
                                        <div id="emailError" class="error-message">Email ID is required.</div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="aadhar" class="form-label"><b>Aadhar Number</b><span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" pattern="[0-9]{12}" placeholder="Enter Aadhar Number" name="aadhar" id="aadhar" required="required">
                                        <div id="aadharError" class="error-message">Aadhar Number is required.</div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="address" class="form-label"><b>Address</b><span class="text-danger">*</span></label>
                                        <textarea class="form-control" placeholder="Enter address" name="address" id="address" required="required"></textarea>
                                        <div id="addressError" class="error-message">Address is required.</div>
                                    </div>
                                   
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="address" class="form-label"><b>Blood group</b></label>
                                        <input type="text" class="form-control" placeholder="Enter blood group" name="blood_group" id="blood_group">
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        
                        <!-- Course Details Section -->
                        <div class="col-12 mt-4">
                            <h5 class="pb-2">Course Details</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="course_id" class="form-label"><b>Course</b><span class="text-danger">*</span></label>
                                        <select class="form-control" id="course" name="course" required="required">
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
                                    <div id="courseError" class="error-message">Course is required.</div>
                                </div>
                                
                                
                                
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="fee" class="form-label"><b>Course Fees</b><span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Actual fee" name="actual_fee" id="actual_fee" required="required">
                                    </div>
                                    <div id="feeError" class="error-message">Course Fee is required.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="form_type" value="add">
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="studentsubmitBtn" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- end modal-->
 