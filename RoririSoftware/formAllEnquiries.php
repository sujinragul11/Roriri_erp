<div class="modal fade" id="addEnquireModal" tabindex="-1" aria-labelledby="addEnquireModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="enquireModalLabel">Add New Enquiry</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3 needs-validation" name="frmAddClient" id="addClient" enctype="multipart/form-data" novalidate>
                                    <input type="hidden" name="hdnAction" value="addEnquiry">
                
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                            <div class="invalid-feedback">
                                                Name is required.
                                            </div>
                                    </div>
                
                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" pattern="\d{10}" maxlength="10" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid phone number.
                                            </div>
                                    </div>
                
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                            <div class="invalid-feedback">
                                                Please enter a valid email.
                                            </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category<span class="text-danger">*</span></label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            $sql = "SELECT enq_category_id, category_name FROM enq_category";
                                            $result = $conn->query($sql);
                                    
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    // Check if the category ID is 6
                                                    $selected = ($row['enq_category_id'] == 6) ? 'selected' : '';
                                                    echo '<option value="' . $row['enq_category_id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No categories available</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Category is required.
                                        </div>
                                    </div>
                                    
                                    <div class="row pt-2">
                                        <div class="col-md-6">
                                            <label for="enquiryDate" class="form-label">Enquiry Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="enquiryDate" name="enquiryDate" required>
                                            <div class="invalid-feedback">
                                                Enquiry date is required.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6" id="career_guidance_jobathon_fields" class="category-fields" style="display: none;">
                                            <label for="experience_type" class="form-label">Experience or Fresher</label>
                                            <select class="form-control" id="experience_type" name="experience_type">
                                                <option value="">---Select Type---</option>
                                                <option value="fresher">Fresher</option>
                                                <option value="experienced">Experienced</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select experience type.
                                            </div>
                                        </div>
                                    </div>
                
                                    <!-- Description -->
                                    <div class="col-md-6">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" placeholder="Description ..." rows="3"></textarea>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" placeholder="Address ..." rows="3"></textarea>
                                    </div>
                
                                    <!-- Follow-up Date -->
                                    <div class="col-md-6">
                                        <label for="followUpDate" class="form-label">Follow-up Date</label>
                                        <input type="date" class="form-control" id="followUpDate" name="followUpDate">
                                        <div class="invalid-feedback">
                                            Follow-up date is required.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="followStatus" class="form-label">Follow Status</label>
                                        <select class="form-control" id="followStatus" name="followStatus">
                                            <option value="">Select Status</option>
                                            <option value="Not Interested">Not Interested</option>
                                            <option value="Interested">Interested</option>
                                            <option value="Confirmed">Confirmed</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Follow status is required.
                                        </div>
                                    </div>
                
                                    <div class="col-md-12">
                                        <label for="comments" class="form-label">Comments</label>
                                        <textarea class="form-control" id="comments" name="comments" placeholder="Enter comments ..." rows="3"></textarea>
                                    </div>

                                        <!-- Fresher Fields -->
                                        <div id="fresher_fields" class="experience-fields" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="college_name" class="form-label">College Name</label>
                                                    <input type="text" class="form-control" id="college_name" name="college_name" placeholder="College Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="passed_out_year" class="form-label">Passed Out Year</label>
                                                    <input type="number" class="form-control" id="passed_out_year" name="passed_out_year" placeholder="Passed Out Year">
                                                </div>
                                            </div>
                                    
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="degree" class="form-label">Degree</label>
                                                    <input type="text" class="form-control" id="degree" name="degree" placeholder="Degree">
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Experienced Fields -->
                                        <div id="experienced_fields" class="experience-fields" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="company_name" class="form-label">Previous Company Name</label>
                                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="role" class="form-label">Role</label>
                                                    <input type="text" class="form-control" id="role" name="role" placeholder="Role">
                                                </div>
                                            </div>
                                    
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="ctc" class="form-label">CTC</label>
                                                    <input type="number" class="form-control" id="ctc" name="ctc" placeholder="CTC">
                                                </div>
                                            </div>
                                        </div>

                                    <!-- Internship Fields -->
                                    <div id="internship_fields" class="category-fields" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="college_name_internship" class="form-label">College Name</label>
                                                <input type="text" class="form-control" id="college_name_internship" name="college_name_internship" placeholder="College Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="passed_out_year_internship" class="form-label">Passed Out Year</label>
                                                <input type="number" class="form-control" id="passed_out_year_internship" name="passed_out_year_internship" placeholder="Passed Out Year">
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="degree_internship" class="form-label">Degree</label>
                                                <input type="text" class="form-control" id="degree_internship" name="degree_internship" placeholder="Degree">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- NexGen IT Academy/Nexemy Fields -->
                                    <div id="nexgen_nexemy_fields" class="category-fields" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="course_name" class="form-label">Course Name</label>
                                                <input type="text" class="form-control" id="course_name" name="course_name" placeholder="Course Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="course_duration" class="form-label">Course Duration</label>
                                                <input type="text" class="form-control" id="course_duration" name="course_duration" placeholder="Duration">
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="course_mode" class="form-label">Mode</label>
                                                <select class="form-control" id="course_mode" name="course_mode">
                                                    <option value="Online">Online</option>
                                                    <option value="Offline">Offline</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                  
                			<div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="addSubmitBtn" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
						</div>
            </div>
						
				
	    </div> <!--end modal dialog-->
</div>

<!-- Edit Enquiry Modal -->
<div class="modal fade" id="editEnquireModal" tabindex="-1" aria-labelledby="editEnquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEnquiryModalLabel">Edit Enquiry</h5>
                <button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmEditEnquiry" id="editEnquiry" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="editEnquiry">
                    <input type="hidden" name="enquiryId" id="enquiryId" value=""> <!-- Hidden field for the enquiry ID -->

                    <!-- Name -->
                    <div class="col-md-6">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="editName" id="editName" placeholder="Name">
                        <div class="invalid-feedback">
                            Name is required.
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label for="editPhone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="editPhone" id="editPhone" placeholder="Phone" pattern="\d{10}" maxlength="10" required>
                        <div class="invalid-feedback">
                            Please enter a valid phone number.
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" placeholder="Email">
                        <div class="invalid-feedback">
                            Please enter a valid email.
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="editCategory" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="editCategory" name="editCategory" required>
                            <option value="">Select Category</option>
                            <?php
                            $sql = "SELECT enq_category_id, category_name FROM enq_category";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['enq_category_id'] . '">' . $row['category_name'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No categories available</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Category is required.
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-6">
                            <label for="editEnquiryDate" class="form-label">Enquiry Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="editEnquiryDate" name="editEnquiryDate" required>
                            <div class="invalid-feedback">
                                Enquiry date is required.
                            </div>
                        </div>

                        <div class="col-md-6" id="career_guidance_jobathon_fields_edit" class="category-fields" style="display: none;">
                            <label for="editExperienceType" class="form-label">Experience or Fresher</label>
                            <select class="form-control" id="editExperienceType" name="editExperienceType">
                                <option value="">---Select Type---</option>
                                <option value="fresher">Fresher</option>
                                <option value="experienced">Experienced</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select experience type.
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-md-6">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="editDescription" placeholder="Description ..." rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="editAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="editAddress" name="editAddress" placeholder="Address ..." rows="3"></textarea>
                    </div>

                    <!-- Follow-up Date -->
                    <div class="col-md-6">
                        <label for="editFollowUpDate" class="form-label">Follow-up Date</label>
                        <input type="date" class="form-control" id="editFollowUpDate" name="editFollowUpDate">
                        <div class="invalid-feedback">
                            Follow-up date is required.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="editFollowStatus" class="form-label">Follow Status</label>
                        <select class="form-control" id="editFollowStatus" name="editFollowStatus">
                            <option value="">Select Status</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Interested">Interested</option>
                            <option value="Confirmed">Confirmed</option>
                        </select>
                        <div class="invalid-feedback">
                            Follow status is required.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="editComments" class="form-label">Comments</label>
                        <textarea class="form-control" id="editComments" name="editComments" placeholder="Enter comments ..." rows="3"></textarea>
                    </div>

                    <!-- Fresher Fields -->
                    <div id="fresher_fields_edit" class="experience-fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="editCollegeName" class="form-label">College Name</label>
                                <input type="text" class="form-control" id="editCollegeName" name="editCollegeName" placeholder="College Name">
                            </div>
                            <div class="col-md-6">
                                <label for="editPassedOutYear" class="form-label">Passed Out Year</label>
                                <input type="number" class="form-control" id="editPassedOutYear" name="editPassedOutYear" placeholder="Passed Out Year">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="editDegree" class="form-label">Degree</label>
                                <input type="text" class="form-control" id="editDegree" name="editDegree" placeholder="Degree">
                            </div>
                        </div>
                    </div>

                    <!-- Experienced Fields -->
                    <div id="experienced_fields_edit" class="experience-fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="editCompanyName" class="form-label">Previous Company Name</label>
                                <input type="text" class="form-control" id="editCompanyName" name="editCompanyName" placeholder="Company Name">
                            </div>
                            <div class="col-md-6">
                                <label for="editRole" class="form-label">Role</label>
                                <input type="text" class="form-control" id="editRole" name="editRole" placeholder="Role">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="editCTC" class="form-label">CTC</label>
                                <input type="number" class="form-control" id="editCTC" name="editCTC" placeholder="CTC">
                            </div>
                        </div>
                    </div>

                    <!-- Internship Fields -->
                    <div id="internship_fields_edit" class="category-fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="editCollegeNameInternship" class="form-label">College Name</label>
                                <input type="text" class="form-control" id="editCollegeNameInternship" name="editCollegeNameInternship" placeholder="College Name">
                            </div>
                            <div class="col-md-6">
                                <label for="editPassedOutYearInternship" class="form-label">Passed Out Year</label>
                                <input type="number" class="form-control" id="editPassedOutYearInternship" name="editPassedOutYearInternship" placeholder="Passed Out Year">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="editDegreeInternship" class="form-label">Degree</label>
                                <input type="text" class="form-control" id="editDegreeInternship" name="editDegreeInternship" placeholder="Degree">
                            </div>
                        </div>
                    </div>

                    <!-- NexGen IT Academy/Nexemy Fields -->
                    <div id="nexgen_nexemy_fields_edit" class="category-fields" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="edit_course_name" class="form-label">Course Name</label>
                                                <input type="text" class="form-control" id="edit_course_name" name="edit_course_name" placeholder="Course Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="edit_course_duration" class="form-label">Course Duration</label>
                                                <input type="text" class="form-control" id="edit_course_duration" name="edit_course_duration" placeholder="Duration">
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="edit_course_mode" class="form-label">Mode</label>
                                                <select class="form-control" id="edit_course_mode" name="edit_course_mode">
                                                    <option value="Online">Online</option>
                                                    <option value="Offline">Offline</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="editSubmitBtn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- view enquiry madule -->


<!-- Client Details Modal -->
<div class="modal fade" id="viewEnquireModal" tabindex="-1" aria-labelledby="viewEnquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewEnquiryModalLabel">View Enquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p id="viewName" class="form-text"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Phone:</label>
                        <p id="viewPhone" class="form-text"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p id="viewEmail" class="form-text"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category:</label>
                        <p id="viewCategory" class="form-text"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Enquiry Date:</label>
                        <p id="viewEnquiryDate" class="form-text"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p id="viewDescription" class="form-text"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Address:</label>
                        <p id="viewAddress" class="form-text"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Follow-up Date:</label>
                        <p id="viewFollowupDate" class="form-text"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Follow Status:</label>
                        <p id="viewFollowStatus" class="form-text"></p>
                    </div>

                    
                    <!-- Comments -->
                    <div class="col-6 mb-3">
                        <label class="form-label fw-bold">Comments:</label>
                        <p id="viewComments" class="form-text">Great interest in the courses.</p>
                    </div>

                    <!-- Fresher Fields -->
                    <div class="col-md-6 mb-3" id="fresherFields" style="display: none;">
                        <label class="form-label fw-bold">College Name:</label>
                        <p id="viewCollegeName" class="form-text"></p>
                        <label class="form-label fw-bold">Passed Out Year:</label>
                        <p id="viewPassedOutYear" class="form-text"></p>
                        <label class="form-label fw-bold">Degree:</label>
                        <p id="viewDegree" class="form-text"></p>
                    </div>

                    <!-- Experienced Fields -->
                    <div class="col-md-6 mb-3" id="experiencedFields" style="display: none;">
                        <label class="form-label fw-bold">Previous Company Name:</label>
                        <p id="viewCompanyName" class="form-text"></p>
                        <label class="form-label fw-bold">Role:</label>
                        <p id="viewRole" class="form-text"></p>
                        <label class="form-label fw-bold">CTC:</label>
                        <p id="viewCTC" class="form-text"></p>
                    </div>

                    <!-- Internship Fields -->
                    <div class="col-md-6 mb-3" id="internshipFields" style="display: none;">
                        <label class="form-label fw-bold">Internship College Name:</label>
                        <p id="viewInternCollegeName" class="form-text"></p>
                        <label class="form-label fw-bold">Internship Passed Out Year:</label>
                        <p id="viewInternPassedOutYear" class="form-text"></p>
                        <label class="form-label fw-bold">Internship Degree:</label>
                        <p id="viewInternDegree" class="form-text"></p>
                    </div>

                    <!-- Nexemy Fields -->
                    <div class="col-md-6 mb-3" id="NexemyFields" style="display: none;">
                        <label class="form-label fw-bold">Course Name:</label>
                        <p id="viewNexemyCourseNmae" class="form-text"></p>
                        <label class="form-label fw-bold">Course Duration:</label>
                        <p id="viewNexemyDurarion" class="form-text"></p>
                        <label class="form-label fw-bold">Mode:</label>
                        <p id="viewMode" class="form-text"></p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
