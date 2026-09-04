<!-- Modal -->

<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clientModalLabel">Add New Department</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
                    <div class="card-body p-4">
    <form class="row g-3" name="frmAddDepartment" id="addDepartment" enctype="multipart/form-data">
        <input type="hidden" name="hdnAction" value="addDepartment">
        <input type="hidden" name="dept_id" id="dept_id">
        <input type="hidden" name="dept_name" id="dept_name">

        <!-- Coordinator Name Field -->
        <div class="col-md-12">
            <label for="coordinatorName" class="form-label">Coordinator Name<span class="text-danger">*</span></label>
            <select class="form-select" name="coordinatorName[]" id="multiple-select-clear-field" data-placeholder="Choose the Coordinator" multiple required>
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

        <!-- Quill Text Editor -->
        <div class="col-md-12">
            <label for="description" class="form-label">Description</label>
            <div id="editor" style="height: 200px;"></div> <!-- Quill editor container -->
            <textarea class="form-control" name="description" id="description" style="display:none;"></textarea> <!-- Hidden textarea to store content -->
        </div>
         <!-- Modal Footer Moved Outside of Form -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="addDepartment" class="btn btn-primary">Save changes</button> <!-- Linked to the form -->
    </div>
    </form>

   
</div>
                            
						
            </div>
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->


<!-- Edit Modal  -->

<!-- Modal -->

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">View Coordinator Details</h5>
                <button type="button" class="btn-close" id="editCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Name :</strong>
                        </div>
                        <div class="col-md-8" id = "viewCoor">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Coordinator :</strong>
                        </div>
                        <div class="col-md-8" id = "viewDept">
                            
                        </div>
                    </div>
                    <hr>

                    <!-- Roles Heading -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h6>Roles And Responsibilities</h6>
                        </div>
                    </div>

                    <!-- Long Text Area for Additional Information -->
                    <div class="row">
                        <div class="col-12">
                            <div class="border p-3" style="max-height: 400px; overflow-y: auto;" id = "viewRoles">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end modal-dialog -->
</div> <!-- end modal fade -->




