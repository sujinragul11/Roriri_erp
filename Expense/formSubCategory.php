
        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addSubCategoryModal" tabindex="-1" aria-labelledby="addSubCatModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSubCatModalLabel">Add Sub Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addSubCatForm" class="row g-3 needs-validation" novalidate>
                            <div class="mb-2">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <select class="form-control" id="categoryName" name="categoryName" required>
                                    <option value="">--Select Category--</option>
                                    <?php
                                    $query = "SELECT `cat_id`, `name` FROM `expense_category` WHERE `status` = 'Active'";
                                    $result = $conn->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['cat_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Category Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="subCatName" class="form-label">SubCategory Name</label>
                                <input type="text" class="form-control" id="subCatName" name="subCatName" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                <div class="invalid-feedback">
                                    SubCategory Name is required and cannot be empty.
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
        <div class="modal fade" id="editSubCatModal" tabindex="-1" aria-labelledby="editSubCatModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubCatModalLabel">Edit SubCategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editSubCatForm" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" id="subCategoryId" name="subCategoryId">
                            <div class="mb-2">
                                <label for="categoryNameEdit" class="form-label">Category Name</label>
                                <select class="form-control" id="categoryNameEdit" name="categoryNameEdit" required disabled>
                                    <option value="">--Select Category--</option>
                                    <?php
                                    $query = "SELECT `cat_id`, `name` FROM `expense_category` WHERE `status` = 'Active'";
                                    $result = $conn->query($query);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['cat_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Category Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="subCatNameEdit" class="form-label">SubCategory Name</label>
                                <input type="text" class="form-control" id="subCatNameEdit" name="subCatNameEdit" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                <div class="invalid-feedback">
                                    SubCategory Name is required and cannot be empty.
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