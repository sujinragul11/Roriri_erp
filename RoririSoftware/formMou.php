
        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addMOUModal" tabindex="-1" aria-labelledby="addMOUModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMOUModalLabel">Add MOU</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addMOUForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="college" class="form-label">College Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="college" name="college" required>
                                    <div class="invalid-feedback">
                                        College Name is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="categoryName" class="form-label">Category Name<span class="text-danger">*</span></label>
                                    <select class="form-control" id="categoryName" name="categoryName" required>
                                        <option value="">--Select Category--</option>
                                        <option value="Arts & Science">Arts & Science</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="Diploma">Diploma</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Category Name is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="date" class="form-label">MOU Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date" name="date" required max="<?= date('Y-m-d'); ?>">
                                    <div class="invalid-feedback">
                                        MOU Date is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inchargeName" class="form-label">Incharge Name<span class="text-danger">*</span></label>
                                    <select id="inchargeName" name="inchargeName" class="form-control" required>
                                        <option value="">--Select the Incharge--</option>
                                        <?php
                                            $sqlPerson2 = "SELECT
                                                                a.`id`,
                                                                a.`name`  
                                                            FROM
                                                                `basic_details` AS a
                                                            LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                                            LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                                            WHERE
                                                                a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                                        $resultPer2 = $conn->query($sqlPerson2);
                                        while ($row = $resultPer2->fetch_assoc()) {
                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Incharge Name is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="mouStatus" class="form-label">MOU Status</label>
                                    <select class="form-control" id="mouStatus" name="mouStatus" required>
                                        <option value="">--Select Status--</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        MOU Status is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="documents" class="form-label">Documents</label>
                                    <input type="file" class="form-control" id="documents" name="documents[]" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .txt, .xls, .xlsx" multiple>
                                    <div class="invalid-feedback">
                                        Documents is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <div id="editor" style="height: 200px;"></div>
                                    <textarea class="form-control" name="description" id="description" style="display:none;"></textarea>
                                    <div class="invalid-feedback">
                                        Description is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitFormBtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Edit Popup Form Modal -->
        <div class="modal fade" id="editMOUModal" tabindex="-1" aria-labelledby="editMOUModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMOUModalLabel">Edit MOU</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMOUForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <input type="hidden" id="MOUId" name="MOUId">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="collegeEdit" class="form-label">College Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="collegeEdit" name="collegeEdit" required>
                                    <div class="invalid-feedback">
                                        College Name is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="categoryNameEdit" class="form-label">Category Name<span class="text-danger">*</span></label>
                                    <select class="form-control" id="categoryNameEdit" name="categoryNameEdit" required>
                                        <option value="">--Select Category--</option>
                                        <option value="Arts & Science">Arts & Science</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="Diploma">Diploma</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Category Name is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="dateEdit" class="form-label">MOU Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dateEdit" name="dateEdit" required max="<?= date('Y-m-d'); ?>">
                                    <div class="invalid-feedback">
                                        MOU Date is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inchargeNameEdit" class="form-label">Incharge Name<span class="text-danger">*</span></label>
                                    <select id="inchargeNameEdit" name="inchargeNameEdit" class="form-control" required>
                                        <option value="">--Select the Incharge--</option>
                                        <?php
                                            $sqlPerson2 = "SELECT
                                                                a.`id`,
                                                                a.`name`  
                                                            FROM
                                                                `basic_details` AS a
                                                            LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                                            LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                                            WHERE
                                                                a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                                        $resultPer2 = $conn->query($sqlPerson2);
                                        while ($row = $resultPer2->fetch_assoc()) {
                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Incharge Name is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="mouStatusEdit" class="form-label">MOU Status</label>
                                    <select class="form-control" id="mouStatusEdit" name="mouStatusEdit" required>
                                        <option value="">--Select Status--</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        MOU Status is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="documentsEdit" class="form-label">Documents</label>
                                    <input type="file" class="form-control" id="documentsEdit" name="documentsEdit[]" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .txt, .xls, .xlsx" multiple>
                                    <div class="invalid-feedback">
                                        Documents is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="descriptionEdit" class="form-label">Description</label>
                                    <div id="editorEdit" style="height: 200px;"></div>
                                    <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" style="display:none;"></textarea>
                                    <div class="invalid-feedback">
                                        Description is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitEditBtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Expense Details Modal -->
        <div class="modal fade" id="viewMOUModal" tabindex="-1" aria-labelledby="viewMOUModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2" id="viewMOUModalLabel">View MOU Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Expense Details Content -->
                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">College Name</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewName" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Category Name</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewCategoryName" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">MOU Date</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewDate" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Incharge Name</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewInchargeName" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">MOU Status</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewStatus" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Documents</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewDocuments" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Description</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <p id="viewDescription" class="fs-5"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

