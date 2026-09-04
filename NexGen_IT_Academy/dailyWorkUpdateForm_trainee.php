
<!-- Modal -->

<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="clientModalLabel">Add Work</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
                    <div class="card-body p-4">
<form class="row g-3 needs-validation" name="frmAddDepartment" id="addDepartment" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="hdnAction" value="addDepartment">
    
   
    <div class="col-md-6 d-none">
    <label for="workDate" class="form-label">Work Date <span class="text-danger">*</span></label>
    <input type="date" class="form-control" id="workDate" name="workDate" value="<?= date('Y-m-d') ?>" required>
    <div class="invalid-feedback">Please select a Work date.</div>
</div>

    <!-- Description Field with Quill Editor -->
    <div class="col-md-12">
        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
        <div id="editor" style="height: 200px;"></div>
        <textarea class="form-control" name="description" id="description" style="display:none;" required></textarea>
        <div class="invalid-feedback">Please enter a description.</div>
    </div>
    
    <!-- Hours Field -->
    <div class="col-md-12">
        <label for="hours" >Hours </label>
        <input type="number" class="form-control" name="hours" id="hours" min="0" step="any" placeholder="Enter number of hours Assign" required>
        <div class="invalid-feedback">Please provide the hours Worked on this task.</div>
    </div>

   

    <!-- URL Field -->
    <div class="col-md-12">
        <label for="projectURL" class="form-label">Worked URL </label>
        <input type="url" class="form-control" name="projectURL" id="projectURL" placeholder="Enter the project URL">
        <div class="invalid-feedback">Please provide a valid Worked URL.</div>
    </div>

    <!-- Image Upload Field -->
    <div class="col-md-12">
        <label for="projectImage" class="form-label">Worked Images </label>
        <input type="file" class="form-control" name="projectImage[]" id="projectImage" accept="image/*" multiple>
        <div class="invalid-feedback">Please upload at least one image.</div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Work</button>
    </div>
</form>



   
</div>
                            
						
            </div>
	    </div> <!--end modal dialog-->
</div><!--end Modal Fade-->


<!-- Edit Modal  -->


<!-- Modal -->

<div class="modal fade" id="editReportModal" tabindex="-1" aria-labelledby="editReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Edit Task Update ( <span id="setName"></span> )</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmAddDepartment" id="editDepartment" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="hdnAction" value="editDepartment">
                    <input type="hidden" name="editReportId" id="editReportId">
                    <input type="hidden" name="dateEdit" id="dateEdit">
                    <input type="hidden" name="nameEdit" id="nameEdit">
                    
<!--                     <div class="col-md-4">-->
<!--    <label for="workingDate" class="form-label">Working Date ( <span id="assignDate"></span> )<span class="text-danger">*</span></label>-->
<!--    <input type="date" class="form-control" id="workingDate" name="workingDate" value="<?= date('Y-m-d') ?>" required>-->
<!--    <div class="invalid-feedback">Please select a Working date.</div>-->
<!--</div>-->

        <!--            <div class="col-md-6 d-none">-->
        <!--<label for="categoryEdit" class="form-label">Category <span class="text-danger">*</span></label>-->
        <!--<select id="categoryEdit" name="categoryEdit" class="form-control" required>-->
        <!--    <option value="">--Select Category--</option>-->
            <?php
                // $queryCategory = "SELECT id, category FROM report_category_tbl WHERE status = 'Active'";
                // $resultCategory = mysqli_query($conn, $queryCategory);
                // if ($resultCategory) {
                //     while ($row = mysqli_fetch_assoc($resultCategory)) {
                //         echo "<option value=\"" . $row['id'] . "\">" . $row['category'] . "</option>";
                //     }
                // }
            ?>
    <!--    </select>-->
    <!--    <div class="invalid-feedback">Please select a category.</div>-->
    <!--</div>-->
    
    <!--<div class="col-md-6 d-none">-->
    <!--    <label for="subcategoryEdit" class="form-label">Subcategory <span class="text-danger">*</span></label>-->
    <!--    <select id="subcategoryEdit" name="subcategoryEdit" class="form-control" required>-->
    <!--        <option value="">--Select Subcategory--</option>-->
    <!--    </select>-->
    <!--    <div class="invalid-feedback">Please select a subcategory.</div>-->
    <!--</div>-->
    <!--<div class="col-md-6 d-none">-->
    <!--    <label for="taskEdit" class="form-label">Task <span class="text-danger">*</span></label>-->
    <!--    <select id="taskEdit" name="taskEdit" class="form-control" required>-->
    <!--        <option value="">--Select Task--</option>-->
    <!--    </select>-->
    <!--    <div class="invalid-feedback">Please select a task.</div>-->
    <!--</div>-->
    
   
    <!-- Status Field -->
                    <!--<div class="col-md-4">-->
                    <!--    <label for="projectStatusEdit" class="form-label">Status<span class="text-danger">*</span></label>-->
                    <!--    <select class="form-control" name="projectStatusEdit" id="projectStatusEdit" required>-->
                    <!--        <option value="">--Select--</option>-->
                    <!--        <option value="Completed">Completed</option>-->
                    <!--        <option value="In Progress">In Progress</option>-->
                    <!--    </select>-->
                    <!--    <div class="invalid-feedback">Please select a status.</div>-->
                    <!--</div>-->

                    <!-- Description Field with Quill Editor -->
                    <div class="col-md-12">
                        <label for="descriptionEdit" class="form-label">Description<span class="text-danger">*</span></label>
                        <div id="editorEdit" style="height: 200px;"></div>
                        <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" style="display:none;" required></textarea>
                        <div class="invalid-feedback">Please enter a description.</div>
                    </div>
                    
                     <div class="col-md-12">
        <label for="hoursEdit" class="form-label">Hours </label>
        <input type="number" class="form-control" name="hoursEdit" id="hoursEdit" min="0" step="any" placeholder="Enter number of hours spent">
        <div class="invalid-feedback">Please enter the number of hours this Work.</div>
    </div>

                    <!-- Project URL Field -->
                    <div class="col-md-12">
                        <label for="projectURLEdit" class="form-label">Worked URL</label>
                        <input type="url" class="form-control" name="projectURLEdit" id="projectURLEdit" placeholder="Enter the project URL">
                        <div class="invalid-feedback">Please enter a valid URL.</div>
                    </div>

                    <!-- Display Existing Images with Remove Option -->
                    <div class="col-md-12">
                        <label class="form-label">Existing Worked Images</label>
                        <div id="existingImagesContainer"></div>
                    </div>
                    

                    <!-- Multiple Image Upload Field for New Images -->
                    <div class="col-md-12">
                        <label for="newImageInput" class="form-label">Add New Worked Images</label>
                        <input type="file" class="form-control" name="newImageInput[]" id="newImageInput" accept="image/*" multiple >
                        <div class="invalid-feedback">Please upload at least one image.</div>
                    </div>

                    

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-primary">Update Work Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">View Work Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Name -->
          <div class="col-md-6">
            <strong>Name:</strong>
            <p id="taskName"></p>
          </div>
          <!-- Hours -->
          <div class="col-md-6">
            <strong>Hours:</strong>
            <p id="taskHours"></p>
          </div>
          <!-- Category -->
          <!--<div class="col-md-6">-->
          <!--  <strong>Category:</strong>-->
          <!--  <p id="taskCategory"></p>-->
          <!--</div>-->
          <!-- Subcategory -->
          <!--<div class="col-md-6">-->
          <!--  <strong>Subcategory:</strong>-->
          <!--  <p id="taskSubcategory"></p>-->
          <!--</div>-->
          
          <!--<div class="col-md-12">-->
          <!--  <strong>Task:</strong>-->
          <!--  <p id="taskTask"></p>-->
          <!--</div>-->
          <!-- Task -->
          <div class="col-md-12">
            <strong>Description:</strong>
            <p id="taskDescription"></p>
          </div>
          
          <div class="col-md-12">
            <strong>URL:</strong>
            <p id="taskUrl" class="text-wrap text-break"></p>
          </div>
          
          <!--status-->
          <!--<div class="col-md-6">-->
          <!--  <strong>Task Status:</strong>-->
          <!--  <p id="taskStatus"></p>-->
          <!--</div>-->
          
          <div id="taskImagesContainer" style="display: none;">
    <!-- Multiple images will be appended here -->
            </div>
            
         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





