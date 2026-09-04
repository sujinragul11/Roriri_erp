<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" novalidate class="needs-validation">
                   <div class="mb-3">
                    <label for="categoryName" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" 
                           pattern="^(?!\s*$)[A-Za-z\s]+$" 
                           title="Please enter only letters and spaces. The name cannot start with a space or be empty/whitespace-only." 
                           required>
                    <input type="hidden" id="htnName" name="htnName" value="AddCategory" required>
                    <div class="invalid-feedback">
                        Please provide a valid category name (letters and spaces only, cannot start with a space).
                    </div>
                </div>
                                    
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Subcategory Modal -->
<div class="modal fade" id="addSubCategoryModal" tabindex="-1" aria-labelledby="addSubCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubCategoryModalLabel">Add Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSubCategoryForm" novalidate class="needs-validation">
                    <div class="mb-3">
                        <input type="hidden" id="htnName" name="htnName" value="addSubCategory" required>
                        <label for="categorySelect" class="form-label">Select Category</label>
                        <select class="form-select" id="categorySelect" name="category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            <!-- Category options will be populated here via AJAX -->
                        </select>
                        <div class="invalid-feedback">
                            Please select a category.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subcategoryName" class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" id="subcategoryName" name="subcategory_name" 
                               pattern="^(?!\s*$)[A-Za-z\s]+$" 
                               title="Please enter only letters and spaces. The name cannot start with a space or be empty/whitespace-only." 
                               required>
                        <div class="invalid-feedback">
                            Please provide a valid subcategory name (letters and spaces only, cannot start with a space).
                        </div>
                    </div>
                                        <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                        <div class="invalid-feedback">
                            Please enter a valid quantity.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subcategory</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Subcategory Modal -->
<div class="modal fade" id="editSubCategoryModal" tabindex="-1" aria-labelledby="editSubCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubCategoryModalLabel">Edit Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSubCategoryForm" novalidate class="needs-validation">
                    <div class="mb-3">
                        <input type="hidden" id="editSubcatId" name="subcat_id" required> <!-- Hidden field to hold the subcategory ID -->
                        <input type="hidden" id="htnName" name="htnName" value="editSubCategory" required>
                        <label for="editCategorySelect" class="form-label">Select Category</label>
                        <select class="form-select" id="editCategorySelect" name="category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            <!-- Category options will be populated here via AJAX -->
                        </select>
                        <div class="invalid-feedback">
                            Please select a category.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editSubcategoryName" class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" id="editSubcategoryName" name="subcategory_name" 
                               pattern="^(?!\s*$)[A-Za-z\s]+$" 
                               title="Please enter only letters and spaces. The name cannot start with a space or be empty/whitespace-only." 
                               required>
                        <div class="invalid-feedback">
                            Please provide a valid subcategory name (letters and spaces only, cannot start with a space).
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="editQuantity" name="quantity" required min="1">
                        <div class="invalid-feedback">
                            Please enter a valid quantity.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </form>
            </div>
        </div>
    </div>
</div>