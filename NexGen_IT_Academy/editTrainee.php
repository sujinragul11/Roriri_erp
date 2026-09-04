<!-- Modal -->
<div class="modal fade" id="editTraineeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="frmEditTrainee" id="editTrainee" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="editTrainee">
                <?php if ($_SESSION['is_admin'] == 'True'): ?>
                <input type="hidden" name="traineeId" id="traineeId">
                <div class="modal-header">
                    <h4 class="modal-title" id="editTraineeModal">Edit Trainee</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <!-- Basic Details Section -->
                        <div class="col-12">
                            <h5 class="pb-2">Basic Details</h5>
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editName" class="form-label"><b>Name</b><span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Name" name="editName"
                                            id="editName">
                                    </div>
                                </div>
                                <!-- Gender -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editGender" class="form-label"><b>Gender</b><span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" id="editGender" name="editGender">
                                            <option>----select----</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Mobile No -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editPhone" class="form-label"><b>Mobile No</b><span
                                                class="text-danger">*</span></label>
                                        <input type="number" pattern="[0-9]{10}" class="form-control"
                                            placeholder="Enter Mobile No" name="editPhone" id="editPhone">
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editPemail" class="form-label"><b>Email</b><span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" placeholder="Enter Email"
                                            name="editPemail" id="editPemail">
                                    </div>
                                </div>
                                <!-- Date of Birth -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editDob" class="form-label"><b>Date of Birth</b><span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="editDob" id="editDob">
                                    </div>
                                </div>
                                <!-- Address -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editAddress" class="form-label"><b>Address</b><span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter address"
                                            name="editAddress" id="editAddress">
                                    </div>
                                </div>
                                <!-- Blood Group -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editBlood" class="form-label"><b>Blood Group</b></label>
                                        <input type="text" class="form-control" placeholder="Enter blood group"
                                            name="editBlood" id="editBlood">
                                    </div>
                                </div>
                                <!-- Image -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editImage" class="form-label"><b>Image</b></label>
                                        <input type="file" class="form-control" name="editImage" id="editImage"
                                            accept=".jpg, .jpeg, .png">
                                    </div>
                                    <!-- Image preview -->
                                    <img id="editTraineeImg" src="" alt="Employee Image"
                                        style="width: 100px; height: 100px; display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Course Details Section -->
                        <div class="col-12 mt-4">
                            <h5 class="pb-2">Course Details</h5>
                            <div class="row">
                                <!-- Course -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editCourse" class="form-label"><b>Course</b><span
                                                class="text-danger">*</span></label>
                                        <select name="editCourse" class="form-select" id="editCourse" required>
                                            <!-- Course options will be dynamically loaded here -->
                                             <option value="">--Select the Course--</option>

                                            <?php $sql="SELECT * FROM academy_course_details WHERE status='Available'";
                                         $res_role = mysqli_query($conn , $sql); 
                                         while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                                            $course_id = $row['id'];
                                            $course_name = $row['course_name'];
                                           
                                            echo '<option value="' . $course_id . '">' . $course_name . '</option>';
                                         }   ?>


                                        </select>
                                    </div>
                                </div>
                                <!-- Duration -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editDuration" class="form-label"><b>Months Duration</b><span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="editDuration" id="editDuration" class="form-control"
                                            placeholder="Enter the duration" required>
                                    </div>
                                </div>
                                <!-- Actual Fee -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editFee" class="form-label"><b>Actual Fee</b><span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Actual fee" name="editFee"
                                            id="editFee" >
                                    </div>
                                </div>
                                <!-- Discount -->
                                <!--<div class="col-md-4">-->
                                <!--    <div class="form-group pb-3">-->
                                <!--        <label for="editDiscount" class="form-label"><b>Discount</b></label>-->
                                <!--        <input type="number" id="editDiscount" name="editDiscount" class="form-control"-->
                                <!--            oninput="calculateDiscountedFee()">-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!-- Discounted Fee -->
                                <!--<div class="col-md-4">-->
                                <!--    <div class="form-group pb-3">-->
                                <!--        <label for="editDiscountedFee" class="form-label"><b>Discounted Fee</b></label>-->
                                <!--        <input type="text" id="editDiscountedFee" name="editDiscountedFee"-->
                                <!--            class="form-control" readonly>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!-- Discount Amount -->
                                <!--<div class="col-md-4">-->
                                <!--    <div class="form-group pb-3">-->
                                <!--        <label for="editDiscountAmount" class="form-label"><b>Discount-->
                                <!--                Amount</b></label>-->
                                <!--        <input type="text" id="editDiscountAmount" name="editDiscountAmount"-->
                                <!--            class="form-control" readonly>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!-- Joining Date -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editJod" class="form-label"><b>Joining date</b><span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="editJod" id="editJod">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editSlot" class="form-label"><b>Slot Timing</b></label>
                                        <select class="form-control" id="editSlot" name="editSlot" >
                                            <option value="">--Select the Slot Timing--</option>
                                            <option value="9:30 - 1:30">9:30 - 1:30</option>
                                            <option value="1:30 - 5:30">1:30 - 5:30</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="editBatch" class="form-label"><b>Batch</b></label>
                                        <select class="form-control" id="editBatch" name="editBatch" >
                                            <option value="">--Select the Batch--</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Company Email -->
                                <div class="col-md-4">
                                    <div class="form-group pb-3">
                                        <label for="cemail" class="form-label"><b>Company Email</b></label>
                                        <input type="email" class="form-control" placeholder="Enter Email" name="cemail"
                                            id="cemail">
                                    </div>
                                </div>
                                <div class="col-md-4">
                         <div class="form-group pb-3">
                            <label for="employeeEdit" class="form-label"><b>Incharge<span class="text-danger">*</span> :</b></label>
                            <select class="form-control" id="employeeEdit" name="employeeEdit[]" data-placeholder="Choose one Employee" required multiple>
                                <!--<option value="">-- Employee --</option>-->
                                    
                      <?php
                $queryCou = "SELECT id, name FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id LEFT JOIN roles AS c ON b.role = c.role_id WHERE a.status='Active' AND c.role_id != 17 AND b.entity_id = 1;";
                $resultCou = mysqli_query($conn, $queryCou);
            
                if ($resultCou) {
                    while ($row = mysqli_fetch_assoc($resultCou)) {
                        $courseId = $row['id'];
                        $courseName = $row['name'];
                        echo "<option value=\"$courseId\">$courseName</option>";
                    }
                }
            ?>
                            </select>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  else:  ?>
                <input type="hidden" name="profileId" id="profileId">
                <div class="col-md-6">
                    <label for="input13" class="form-label">UserName <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <input type="text" class="form-control" name="editUsername" id="editUsername" placeholder="UserName"
                            required="required" readonly>

                        <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="input14" class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <input type="text" class="form-control" name="editPassword" id="editPassword"
                            placeholder="Password" required="required">
                        <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                
                                       <div class="col-md-4">
    <div class="form-group pb-3">
        <label for="referredByEdit" class="form-label"><b>Referred By</b><span class="text-danger">*</span></label>
        <select class="form-control" id="referredByEdit" name="referredByEdit" onchange="handleReferredByChangeEdit()">
            <option value="">--Select--</option>
            <?php
            $employeeQuery = "SELECT id, name FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id LEFT JOIN roles AS c ON b.role = c.role_id WHERE a.status='Active' AND c.role_id != 16 AND b.entity_id = 1;";
            $result = mysqli_query($conn, $employeeQuery);
            while ($employee = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $employee['id'] . '">' . $employee['name'] . '</option>';
            }
            ?>
            <option value="myself">Myself</option>
            <option value="others">Others</option>
        </select>
        <div id="referredByError" class="error-message">Referred By is required.</div>
    </div>
</div>

                        

<!-- Input for Other Referred Name (Hidden Initially) -->
<div class="col-md-4" id="otherReferredDivEdit" style="display: none;">
    <div class="form-group pb-3">
        <label for="otherReferredNameEdit" class="form-label"><b>Other Referred Name</b><span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Enter Other Referred Name" name="otherReferredNameEdit" id="otherReferredNameEdit">
        <div id="otherReferredNameError" class="error-message">Other referred name is required.</div>
    </div>
</div>


                <?php endif;  ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="updateBtn" class="btn btn-primary">Save changes</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- end modal-->
<script>
    // function calculateDiscountedFee() {
    //     var actualFee = parseFloat(document.getElementById("editFee").value);
    //     var discount = parseFloat(document.getElementById("editDiscount").value);

    //     if (!isNaN(discount) && discount > 0) {
    //         var discountAmount = (actualFee * discount) / 100;
    //         var discountedFee = actualFee - discountAmount;

    //         document.getElementById("editDiscountAmount").value = discountAmount.toFixed(2);
    //         document.getElementById("editDiscountedFee").value = discountedFee.toFixed(2);
    //     } else {
    //         document.getElementById("editDiscountAmount").value = "0.00";
    //         document.getElementById("editDiscountedFee").value = actualFee.toFixed(2);
    //     }
    // }


document.getElementById('editPhone').addEventListener('input', function (e) {
    const value = e.target.value;

    // Remove non-numeric characters
    e.target.value = value.replace(/[^0-9]/g, '');

    // Limit the length to 10 digits
    if (value.length > 10) {
        e.target.value = value.slice(0, 10);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Get today's date
    var today = new Date();
    var yearToday = today.getFullYear();
    var monthToday = String(today.getMonth() + 1).padStart(2, '0');
    var dayToday = String(today.getDate()).padStart(2, '0');
    var maxDateToday = yearToday + '-' + monthToday + '-' + dayToday;

    // Set the max attribute for the joining date input field
    document.getElementById('editJod').setAttribute('max', maxDateToday);

    // Calculate the maximum date for 18 years ago
    var eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    var yearEighteenYearsAgo = eighteenYearsAgo.getFullYear();
    var monthEighteenYearsAgo = String(eighteenYearsAgo.getMonth() + 1).padStart(2, '0');
    var dayEighteenYearsAgo = String(eighteenYearsAgo.getDate()).padStart(2, '0');
    var maxDateEighteenYearsAgo = yearEighteenYearsAgo + '-' + monthEighteenYearsAgo + '-' + dayEighteenYearsAgo;

    // Set the max attribute for the date of birth input field
    document.getElementById('editDob').setAttribute('max', maxDateEighteenYearsAgo);
});
</script>