
        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm" class="row g-3 needs-validation" novalidate>
                            <div class="mb-2">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                <div class="invalid-feedback">
                                    Category Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitFormBtn">Save Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Edit Popup Form Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editCategoryForm" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" id="categoryId" name="categoryId">
                            <div class="mb-2">
                                <label for="categoryNameEdit" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryNameEdit" name="categoryNameEdit" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                <div class="invalid-feedback">
                                    Category Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitEditBtn">Save Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>