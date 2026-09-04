 <!--Add Popup Form Modal -->
        <div class="modal fade" id="addFoodModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clientModalLabel">Add Food Packages</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body p-4">
								<form class="row g-3 needs-validation" id="addFood" novalidate enctype="multipart/form-data">
								    <input type="hidden" name="hdnAction" value="addFood">
								    	<div class="col-md-12">
										<label for="category" class="form-label">Category</label>
										<select id="category" name="category" class="form-select" required>
											<option selected disabled value>--Select Category--</option>
											<option value="Veg">Veg</option>
											<option value="Non-Veg">Non-Veg</option>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid Category.
										</div>
									</div>
									
									<div class="col-md-12">
                                    <label for="formFile">Upload an Image (PNG, JPG, JPEG):</label>
                                        <input class="form-control" type="file" id="formFile" name="image" accept=".png, .jpg, .jpeg" required>
                                        <div class="invalid-feedback">
                                            Please upload a valid image file (PNG, JPG, JPEG).
                                        </div>
									</div>
								<div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter The Name" 
                                       pattern="[A-Za-z\s]+" required>
                                <div class="valid-feedback">
                                    Please Enter a valid Name (only letters).
                                </div>
                                <div class="invalid-feedback">
                                    Name must contain only letters.
                                </div>
                            </div>
								
									<div class="col-md-12">
									 <label for="description" class="form-label">Description</label>
                                    <div id="editor" style="height: 200px;"></div> <!-- Quill editor container -->
                                    <textarea class="form-control" name="description" id="description" style="display:none;"></textarea> <!-- Hidden textarea to store content -->
            
										<div class="invalid-feedback">
											Please Enter the  Description.
										  </div>
									</div>
									<div class="col-md-12">
										<label for="Price" class="form-label">Price</label>
										<input type="number" class="form-control" id="price" name="price" placeholder="Enter The Price" required>
										<div class="invalid-feedback">
											Enter The Price. 
										</div>
									</div>
									
						
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Submit</button>
											<!--<button type="reset" class="btn btn-light px-4">Reset</button>-->
										</div>
									</div>
								</form>
							</div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
        
        
        
        
        
         <!--Add Popup Form Modal -->
        <div class="modal fade" id="editFoodModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Edit Food Packages</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body p-4">
								<form class="row g-3 needs-validation" id="editFood" novalidate enctype="multipart/form-data">
								    <input type="hidden" name="hdnAction" value="editFood">
								    <input type="hidden" name="food_id" id="food_id">
								    	<div class="col-md-12">
										<label for="categoryEdit" class="form-label">Category</label>
										<select id="categoryEdit" name="category" class="form-select" required>
											<option selected disabled value>--Select Category--</option>
											<option value="Veg">Veg</option>
											<option value="Non-Veg">Non-Veg</option>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid Category.
										</div>
									</div>
									
									<div class="col-md-12">
                                    <label for="formFileEdit">Upload an Image (PNG, JPG, JPEG):</label>
                                        <input class="form-control" type="file" id="formFileEdit" name="image" accept=".png, .jpg, .jpeg">
                                        <div class="invalid-feedback">
                                            Please upload a valid image file (PNG, JPG, JPEG).
                                        </div>
									</div>
									
										<div class="col-md-12">
                                <label for="nameEdit" class="form-label">Name</label>
                                <input type="text" class="form-control" id="nameEdit" name="name" placeholder="Enter The Name" 
                                       pattern="[A-Za-z\s]+" required>
                                <div class="valid-feedback">
                                    Please Enter a valid Name (only letters).
                                </div>
                                <div class="invalid-feedback">
                                    Name must contain only letters.
                                </div>
                            </div>
									
								
									<div class="col-md-12">
									 <label for="descriptionEdit" class="form-label">Description</label>
                                    <div id="editorEdit" style="height: 200px;"></div> <!-- Quill editor container -->
                                    <textarea class="form-control" name="description" id="descriptionEdit" style="display:none;"></textarea> <!-- Hidden textarea to store content -->
            
										<div class="invalid-feedback">
											Please Enter the  Description.
										  </div>
									</div>
									<div class="col-md-12">
										<label for="priceEdit" class="form-label">Price</label>
										<input type="number" class="form-control" id="priceEdit" name="price" placeholder="Enter The Price" required>
										<div class="invalid-feedback">
											Enter The Price. 
										</div>
									</div>
									
						
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Submit</button>
											<!--<button type="reset" class="btn btn-light px-4">Reset</button>-->
										</div>
									</div>
								</form>
							</div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <!-- Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Add Course Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="courseForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
          <div class="mb-3">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" required>
            <div class="invalid-feedback">
              Please provide a course name.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseLogo" class="form-label">Logo Image</label>
            <input type="file" class="form-control"  id="courseLogo" accept="image/*" required>
            <div class="invalid-feedback">
              Please upload a logo image.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="saveCourse">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>






<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Edit Course Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editCourseForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden"  id="course_id">
          <div class="mb-3">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="editCourseName" required>
            <div class="invalid-feedback">
              Please provide a course name.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseLogo" class="form-label">Logo Image</label>
            <input type="file" class="form-control"  id="editCourseLogo" accept="image/*" required>
            <div class="invalid-feedback">
              Please upload a logo image.
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="editSaveCourse">Save</button>
      </div>
    </div>
  </div>
</div>



        
        
       
        
        
        
        
     