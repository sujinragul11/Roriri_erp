<!-- Modal -->

<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Enquiry</h5>
                <button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmAddClient" id="addClient" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="addEnquiry">

                    <!-- Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                            <div class="invalid-feedback">
                                Name is required.
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" pattern="\d{10}" maxlength="10" required>
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-phone'></i></span>
                            <div class="invalid-feedback">
                                Please enter a valid phone number.
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <div class="position-relative input-icon">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
                            <div class="invalid-feedback">
                                Please enter a valid email.
                            </div>
                        </div>
                    </div>

                    <!-- College Name -->
                    <div class="col-md-6">
                        <label for="collegeName" class="form-label">College Name</label>
                        <div class="position-relative input-icon">
                            <input type="text" class="form-control" name="collegeName" id="collegeName" placeholder="College Name">
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-building'></i></span>
                            <div class="invalid-feedback">
                                College name is required.
                            </div>
                        </div>
                    </div>

                    <!-- Passout Year -->
                    <div class="col-md-6">
                        <label for="passoutYear" class="form-label">Passout Year</label>
                        <input type="number" class="form-control" id="passoutYear" name="passoutYear" placeholder="YYYY">
                        <div class="invalid-feedback">
                            Passout year is required.
                        </div>
                    </div>

                    <!-- Department -->
                    <div class="col-md-6">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" placeholder="Department Name">
                        <div class="invalid-feedback">
                            Department is required.
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Description ..." rows="3"></textarea>
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" placeholder="Address ..." rows="3"></textarea>
                    </div>

                    <!-- Comments -->
                    <div class="col-md-12">
                        <label for="comments" class="form-label">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" placeholder="Enter comments ..." rows="3"></textarea>
                    </div>

                    <!-- Follow-up Date -->
                    <div class="col-md-6">
                        <label for="followUpDate" class="form-label">Follow-up Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="followUpDate" name="followUpDate" required>
                        <div class="invalid-feedback">
                            Follow-up date is required.
                        </div>
                    </div>

                    <!-- Follow Status -->
                    <div class="col-md-6">
                        <label for="followStatus" class="form-label">Follow Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="followStatus" name="followStatus" required>
                            <option value="">Select Status</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Interested">Interested</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Joined">Joined</option>
                            <option value="Call Not Attended">Call Not Attended</option>
                        </select>
                        <div class="invalid-feedback">
                            Follow status is required.
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="enquiryDate" class="form-label">Enquiry Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="enquiryDate" name="enquiryDate" required>
                        <div class="invalid-feedback">
                            Enquiry date is required.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="mode" class="form-label">Mode Status</label>
                        <select class="form-control" id="mode" name="mode">
                            <option value="">Select Mode</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                        <div class="invalid-feedback">
                            Mode status is required.
                        </div>
                    </div>
			<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="addSubmitBtn" class="btn btn-primary">Submit</button>
            </div>
                </form>
            </div>

            
        </div>
    </div> <!-- end modal-dialog -->
</div><!-- end modal fade -->




<!-- Edit Modal  -->

<!-- Modal -->

<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel">Edit Enquiry</h5>
                <button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmEditClient" id="editClient" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="editEnquiry">
                    <input type="hidden" name="enqId" id="enqId">

                    <!-- Name -->
                    <div class="col-md-6">
                        <label for="editName" class="form-label">Name <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="text" class="form-control" name="editName" id="editName" placeholder="Name" required>
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                            <div class="invalid-feedback">
                                Name is required.
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label for="editPhone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="tel" class="form-control" name="editPhone" id="editPhone" placeholder="Phone" pattern="\d{10}" maxlength="10" required>
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-phone'></i></span>
                            <div class="invalid-feedback">
                                Please enter a valid phone number.
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="editEmail" class="form-label">Email</label>
                        <div class="position-relative input-icon">
                            <input type="email" class="form-control" id="editEmail" name="editEmail" placeholder="Email">
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
                            <div class="invalid-feedback">
                                Please enter a valid email.
                            </div>
                        </div>
                    </div>

                    <!-- College Name -->
                    <div class="col-md-6">
                        <label for="editCollegeName" class="form-label">College Name</label>
                        <div class="position-relative input-icon">
                            <input type="text" class="form-control" name="editCollegeName" id="editCollegeName" placeholder="College Name">
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-building'></i></span>
                            <div class="invalid-feedback">
                                College name is required.
                            </div>
                        </div>
                    </div>

                    <!-- Passout Year -->
                    <div class="col-md-6">
                        <label for="editPassoutYear" class="form-label">Passout Year</label>
                        <input type="number" class="form-control" id="editPassoutYear" name="editPassoutYear" placeholder="YYYY">
                        <div class="invalid-feedback">
                            Passout year is required.
                        </div>
                    </div>

                    <!-- Department -->
                    <div class="col-md-6">
                        <label for="editDepartment" class="form-label">Department</label>
                        <input type="text" class="form-control" id="editDepartment" name="editDepartment" placeholder="Department Name">
                        <div class="invalid-feedback">
                            Department is required.
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-md-6">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="editDescription" placeholder="Description ..." rows="3"></textarea>
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label for="editAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="editAddress" name="editAddress" placeholder="Address ..." rows="3"></textarea>
                    </div>

                    <!-- Comments -->
                    <div class="col-md-12">
                        <label for="editComments" class="form-label">Comments</label>
                        <textarea class="form-control" id="editComments" name="editComments" placeholder="Enter comments ..." rows="3"></textarea>
                    </div>

                    <!-- Follow-up Date -->
                    <div class="col-md-6">
                        <label for="editFollowUpDate" class="form-label">Follow-up Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="editFollowUpDate" name="editFollowUpDate" required>
                        <div class="invalid-feedback">
                            Follow-up date is required.
                        </div>
                    </div>

                    <!-- Follow Status -->
                    <div class="col-md-6">
                        <label for="editFollowStatus" class="form-label">Follow Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="editFollowStatus" name="editFollowStatus" required>
                            <option value="">Select Status</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Interested">Interested</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Joined">Joined</option>
                            <option value="Call Not Attended">Call Not Attended</option>
                        </select>
                        <div class="invalid-feedback">
                            Follow status is required.
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="editEnquiryDate" class="form-label">Enquiry Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="editEnquiryDate" name="editEnquiryDate" required>
                        <div class="invalid-feedback">
                            Enquiry date is required.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="editMode" class="form-label">Mode Status</label>
                        <select class="form-control" id="editMode" name="editMode">
                            <option value="">Select Mode</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                        <div class="invalid-feedback">
                            Mode status is required.
                        </div>
                    </div>
			<div class="modal-footer">
                <button type="button" id="editCloseBtn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="editSubmitBtn" class="btn btn-primary">Save changes</button>
            </div>
                </form>
            </div>

            
        </div>
    </div> <!-- end modal-dialog -->
</div><!-- end modal fade -->




<!-- View Client Modal -->
<div class="modal fade" id="viewClientModal" tabindex="-1" aria-labelledby="viewClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewClientModalLabel">View Enquiry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="clientDetails" class="row">
                    <!-- Client details will be dynamically populated here -->
                    <div class="col-12">
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>