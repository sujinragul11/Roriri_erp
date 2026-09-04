<!-- Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" id="editCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmEditStudent" id="editStudent" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="editStudent">
                    <?php if ($_SESSION['is_admin'] == 'True'): ?>
                        <input type="hidden" name="studid" id="studid">
                        
                        <!-- Basic Details Section -->
                        <div class="col-md-6">
                            <label for="editFname" class="form-label">Name <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" name="editFname" id="editFname" placeholder="Enter Student First Name" required="required" oninput="validateName('editFname', 'fnameError')">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                            </div>
                            <div id="fnameErrorE" class="error-message">Please Enter your name</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editDob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="date" class="form-control" name="editDob" id="editDob" required="required">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
                            </div>
                            <div id="dobErrorE" class="text-danger" style="display: none;">You must be at least 18 years old.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editGender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select id="editGender" name="editGender" class="form-select" required="required">
                                <option selected value="">----select----</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <div id="genderErrorE" class="error-message">Gender is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editPhone" class="form-label">Mobile <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="number" class="form-control" name="editPhone" id="editPhone" placeholder="Enter Mobile" required="required">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-phone'></i></span>
                            </div>
                            <div id="phoneErrorE" class="error-message">Phone number is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editemail" class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="email" class="form-control" name="editemail" id="editemail" placeholder="Enter Email" required="required">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
                            </div>
                            <div id="emailErrorE" class="error-message">Email ID is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editAadhar" class="form-label">Aadhar <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="number" class="form-control" name="editAadhar" id="editAadhar" placeholder="Enter Aadhar Number" required="required">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-id-card'></i></span>
                            </div>
                            <div id="aadharErrorE" class="error-message">Aadhar Number is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editAddress" class="form-label">Address <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" name="editAddress" id="editAddress" placeholder="Enter Address" required="required">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-home'></i></span>
                            </div>
                            <div id="addressErrorE" class="error-message">Address is required.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="editImage" class="form-label">Image</label>
                            <input type="file" class="form-control" name="editImage" id="editImage" accept="image/*">
                            <!-- Image preview -->
                            <img id="editStuImg" src="" alt="Student Image" style="width: 100px; height: 100px; display: none;">
                        </div>

                        <div class="col-md-6">
                            <label for="editBlood" class="form-label">Blood Group</label>
                            <input type="text" class="form-control" name="editBlood" id="editBlood" placeholder="Enter blood group">
                        </div>

                        <!-- Course Details Section -->
                        <div class="col-md-6">
                            <label for="editCourse" class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-control" id="editCourse" name="editCourse" required="required">
                                        <option selected value="">--Select--</option>
                                        <?php $sel_course="SELECT * FROM course_tbl WHERE status='Active'";
                                            $res_course = mysqli_query($conn , $sel_course); 
                                            while($row = mysqli_fetch_array($res_course , MYSQLI_ASSOC)) { 
                                               $course_id = $row['course_id'];
                                               $course_name = $row['course_name'];
                                              
                                               echo '<option value="' . $course_id . '">' . $course_name . '</option>';
                                            } ?>
                                        </select>
                            <div id="courseErrorE" class="error-message">Course is required.</div>
                        </div>

                        

                        <div class="col-md-6">
                            <label for="editFee" class="form-label">Course Fee <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="editFee" id="editFee" placeholder="Enter Fee" required="required">
                            <div id="feeErrorE" class="error-message">Course Fee is required.</div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="profileId" id="profileId">
                        <div class="col-md-6">
                            <label for="editUname" class="form-label">UserName <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" name="editUname" id="editUname" placeholder="UserName" required="required" readonly>
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="editPassword" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" name="editPassword" id="editPassword" placeholder="Password" required="required">
                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="updateBtn" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
var editPhoneEl = document.getElementById('editPhone');
if (editPhoneEl) {
    editPhoneEl.addEventListener('input', function (e) {
        const value = e.target.value;
        e.target.value = value.replace(/[^0-9]/g, '');
        if (value.length > 10) {
            e.target.value = value.slice(0, 10);
        }
    });
}
var editAadharEl = document.getElementById('editAadhar');
if (editAadharEl) {
    editAadharEl.addEventListener('input', function (e) {
        const value = e.target.value;
        e.target.value = value.replace(/[^0-9]/g, '');
        if (value.length > 12) {
            e.target.value = value.slice(0, 12);
        }
    });
}

</script>
<script>
var editDurationEl = document.getElementById('editDuration');
if (editDurationEl) {
    editDurationEl.addEventListener('input', function (e) {
        const value = e.target.value;
        e.target.value = value.replace(/[^0-9]/g, '');
        if (e.target.value.length > 1) {
            e.target.value = e.target.value.slice(0, 1);
        }
    });
}
</script>



