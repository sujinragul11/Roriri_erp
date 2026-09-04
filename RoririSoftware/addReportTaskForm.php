
<!-- Modal Structure -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="categoryForm" novalidate class="needs-validation">
                    <!-- Category Form Fields -->
                    <div class="mb-3">
                        <input type="hidden" name="hdnAction" value="addCategory">
                        <input type="text" class="form-control" placeholder="Category Name" name="categoryName" required>
                        <div class="invalid-feedback">Category name is required.</div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addCategory()">Add Category</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal Structure -->
<div class="modal fade" id="subcategoryModal" tabindex="-1" aria-labelledby="subcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="subcategoryModalLabel">Add Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="subcategoryForm" novalidate class="needs-validation">
                    <!-- Category Dropdown -->
                    <div class="mb-3">
                        <label for="categorySelect" class="form-label">Category</label>
                        <select class="form-control" id="categorySelect" name="categoryId" required>
                            <option value="">Select Category</option>
                            <!-- Options dynamically loaded via JavaScript -->
                        </select>
                        <div class="invalid-feedback">
                            Please select a category.
                        </div>
                    </div>
                    
                    <!-- Subcategory Text Input -->
                    <div class="mb-3">
                        <label for="subcategoryName" class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" placeholder="Subcategory Name" name="subcategoryName" id="subcategoryName" required>
                        <div class="invalid-feedback">
                            Subcategory name is required.
                        </div>
                    </div>
                    <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Add Subcategory</button>
            </div>
                </form>
            </div>

            
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Task Form -->
                <form id="taskFormAdd" novalidate class="needs-validation">
                    <input type="hidden" name="action" value="addTaskFrom">

                    <!-- Category Dropdown -->
                    <div class="mb-3">
                        <label for="categorySelectTask" class="form-label">Category</label>
                        <select class="form-control" id="categorySelectTask" name="categoryId" required>
                            <option value="">Select Category</option>
                        </select>
                        <div class="invalid-feedback">Please select a category.</div>
                    </div>

                    <!-- SubCategory Dropdown -->
                    <div class="mb-3">
                        <label for="subcategorySelectTask" class="form-label">SubCategory</label>
                        <select class="form-control" id="subcategorySelectTask" name="subcategoryId" required>
                            <option value="">Select SubCategory</option>
                        </select>
                        <div class="invalid-feedback">Please select a subcategory.</div>
                    </div>

                    <!-- Task Name -->
                    <div class="mb-3">
                        <label for="taskName" class="form-label">Task Name</label>
                        <input type="text" class="form-control" placeholder="Task Name" name="taskName" id="taskName" required>
                        <div class="invalid-feedback">Please enter a task name.</div>
                    </div>

                    <!-- Hours -->
                    <div class="mb-3">
                        <label for="hours" class="form-label">Hours <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="hours" id="hours" min="0" step="any" placeholder="Enter number of hours assign" required>
                        <div class="invalid-feedback">Please provide the hours assign on this task.</div>
                    </div>

                    <!-- Add Task Button -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary mb-2">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>