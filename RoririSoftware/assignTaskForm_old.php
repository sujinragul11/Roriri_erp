
<!-- Modal -->

<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clientModalLabel">Add Task</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
                    <div class="card-body p-4">
<form class="row g-3 needs-validation" name="frmAddDepartment" id="addDepartment" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="hdnAction" value="addDepartment">
    
    <?php
        // $trainerRoles = [17]; // Define the Admin of roles
        // if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') {
    ?>
    
    <div class="col-md-6">
    <label for="taskDate" class="form-label">Task Date <span class="text-danger">*</span></label>
    <input type="date" class="form-control" id="taskDate" name="taskDate" value="<?= date('Y-m-d') ?>" required>
    <div class="invalid-feedback">Please select a task date.</div>
</div>
    
    <div class="col-md-6">
        <label for="employee" class="form-label">Employee</label>
        <select class="form-select" id="employee" name="employee" required>
            <option value="">--Select--</option>
            <?php
                $queryCou = "SELECT id, name FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id LEFT JOIN roles AS c ON b.role = c.role_id WHERE a.status='Active' AND c.role_id != 16 AND b.entity_id = 1;";
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
        <div class="invalid-feedback">Please select an employee.</div>
    </div>
    
    <?php 
    // } 
    ?>

    <div class="col-md-6">
        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
        <select id="category" name="category" class="form-control" required>
            <option value="">--Select Category--</option>
            <?php
                $queryCategory = "SELECT id, category FROM report_category_tbl WHERE status = 'Active'";
                $resultCategory = mysqli_query($conn, $queryCategory);
                if ($resultCategory) {
                    while ($row = mysqli_fetch_assoc($resultCategory)) {
                        echo "<option value=\"" . $row['id'] . "\">" . $row['category'] . "</option>";
                    }
                }
            ?>
        </select>
        <div class="invalid-feedback">Please select a category.</div>
    </div>

    <div class="col-md-6">
        <label for="subcategory" class="form-label">Subcategory <span class="text-danger">*</span></label>
        <select id="subcategory" name="subcategory" class="form-control" required>
            <option value="">--Select Subcategory--</option>
        </select>
        <div class="invalid-feedback">Please select a subcategory.</div>
    </div>
    
    <div class="col-md-6">
        <label for="task" class="form-label">Task <span class="text-danger">*</span></label>
        <select id="task" name="task" class="form-control" required>
            <option value="">--Select Task--</option>
        </select>
        <div class="invalid-feedback">Please select a task.</div>
    </div>

    <div class="col-md-6">
        <label for="hours" class="form-label">Hours <span class="text-danger">*</span></label>
        <input type="number" class="form-control" name="hours" id="hours" min="0" step="0.1" placeholder="Enter number of hours Assign" required>
        <div class="invalid-feedback">Please enter the number of hours Assign.</div>
    </div>

    <div class="col-md-12">
        <label for="description" class="form-label">Description</label>
        <div id="editor" style="height: 200px;"></div>
        <textarea class="form-control" name="description" id="description" style="display:none;" required></textarea>
        <div class="invalid-feedback">Please enter a description.</div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>


   
</div>
                            
						
            </div>
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->

