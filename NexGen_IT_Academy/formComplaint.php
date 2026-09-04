<!-- Modal -->

<div class="modal fade" id="addComplainModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clientModalLabel">Add New Complaint</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
                    <div class="card-body p-4">
                    <form  name="frmAddDepartment" id="addDepartment" enctype="multipart/form-data" novalidate class="needs-validation">
                        <input type="hidden" name="hdnAction" value="addComplaint">
                    
                        <!-- Coordinator Name Field -->
                        <div class="col-md-12">
                            <label for="trainerName" class="form-label">Trainer Name<span class="text-danger">*</span></label>
                            <select class="form-select" name="trainerName[]" id="multiple-select-clear-field" data-placeholder="Choose the Complaint" multiple required <?php if ($_SESSION['id'] == 86) echo 'disabled'; ?>>
                                <?php 
                                $sel_role = "SELECT `id`, `name` FROM `basic_details` WHERE `status` = 'Active'";
                                $res_role = mysqli_query($conn, $sel_role); 
                                while($row = mysqli_fetch_array($res_role, MYSQLI_ASSOC)) { 
                                    $emp_id = $row['id'];
                                    $name = $row['name'];
                                    echo '<option value="' . $emp_id . '">' . $name . '</option>';
                                } 
                                ?>
                            </select>
                           
                        </div>
                        <div class="mb-3">
                                    <label for="complaint" class="form-label">Complaint</label>
                                    <textarea class="form-control" name="complaint" id="complaint" pattern="[A-Za-z0-9., !?]+" required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter a valid complaint. Only letters, numbers, and certain punctuation marks are allowed.
                                    </div>
                                </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" <?php if ($_SESSION['id'] == 86) echo 'disabled'; ?>>Save changes</button> <!-- Linked to the form -->
                        </div>
                    </form>
                    
                       
                    </div>
                            
						
            </div>
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->












<!-- Edit Complaint Modal -->
<div class="modal fade" id="editComplainModal" tabindex="-1" aria-labelledby="editComplainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editComplainModalLabel">Edit Complaint</h5>
                <button type="button" class="btn-close" id="modalCloseBtnEdit" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4">
            <form class="row g-3 needs-validation" name="frmEditComplaint" id="editComplaintForm" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="hdnAction" value="editComplaint">
                <input type="hidden" name="complantId" id="complantId">

                <!-- Coordinator Name Field -->
                <div class="col-md-12">
                    <label for="trainerNameEdit" class="form-label">Trainer Name<span class="text-danger">*</span></label>
                    <select class="form-select" name="trainerNameEdit[]" id="multiple-select-field" data-placeholder="Choose the Complaint" multiple required>
                        <?php 
                        $sel_role = "SELECT `id`, `name` FROM `basic_details` WHERE `status` = 'Active'";
                        $res_role = mysqli_query($conn , $sel_role); 
                        while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                            $emp_id = $row['id'];
                            $name = $row['name'];
                            echo '<option value="' . $emp_id . '">' . $name . '</option>';
                        } 
                        ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="complaintEdit" class="form-label">Complaint</label>                        
                    <textarea class="form-control" name="complaint" id="complaintEdit"></textarea> 
                </div>

                <div class="col-md-12">
                <label for="complaintReply" class="form-label">Complaint Reply</label>                        
                <input type="text" class="form-control" name="complaintReply" id="complaintReply" pattern="[A-Za-z0-9., !?]+" required>
                <div class="invalid-feedback">
                    Please enter a valid reply. Spaces are not allowed.
                </div>
            </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</div>


 <!-- view page  -->


 <!-- Modal HTML -->
<!-- Modal HTML -->
<!-- Edit Complaint Modal -->
<div class="modal fade" id="viewComplaintModal" tabindex="-1" aria-labelledby="editComplainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editComplainModalLabel">View Complaint</h5>
                <button type="button" class="btn-close" id="modalCloseBtnEdit" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmEditComplaint" id="editComplaintForm" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="editComplaint">
                    <input type="hidden" name="complantId" id="complantId" >

                    
                    <div class="col-md-12">
                        <label for="traineeName" class="form-label">Trainee Name</label>

                        <div class="form-control" id="traineeName"></div>
                    </div>

                    <div class="col-md-12">
                        <label for="trainerName" class="form-label">Trainer Name</label>

                        <div class="form-control" id="trainerName"></div>
                    </div>

                    <div class="col-md-12">
                        <label for="complaintView" class="form-label">Complaint Details</label>

                        <div class="form-control" id="complaintView"></div>
                    </div>

                    <div class="col-md-12">
                        <label for="dateView" class="form-label">Reply Date</label>

                        <div class="form-control" id="dateView"></div>
                        </div>

                    <div class="col-md-12">
                        <label for="replyView" class="form-label">Reply Details</label>

                        <div class="form-control" id="replyView"></div>
                    </div>
                    
        
                    
                    
                </form>
            </div>
        </div>
    </div>
</div>