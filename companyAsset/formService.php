        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceModalLabel">Add Service Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="serviceForm" class="needs-validation" novalidate>
                            <div class="mb-2">
                                <label for="subCatName" class="form-label">Category Name</label>
                                <select class="form-control" id="subCatName" name="subCatName" required>
                                    <option value="">--Select a Category--</option>
                                    <?php
                                    $subCatSql = "SELECT
                                                    `subcat_id`,
                                                    `Subcategory`
                                                FROM
                                                    `asset_subcategory`
                                                WHERE
                                                    `staus` = 'Active'";
                                    $subCatResult = $conn->query($subCatSql);
                                    
                                    if ($subCatResult->num_rows > 0) {
                                        while ($row = $subCatResult->fetch_assoc()) {
                                            echo '<option value="' . $row['subcat_id'] . '">' . $row['Subcategory'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Categories available</option>';
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a category. This field is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="proName" class="form-label">Product Name</label>
                                <select class="form-control" id="proName" name="proName" required>
                                    <option value="">--Select a Product Name--</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a product name. This field is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="serDate" class="form-label">Service Date</label>
                                <input type="date" class="form-control" id="serDate" name="serDate" required>
                                <div class="invalid-feedback">
                                    Service date is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                <div class="invalid-feedback">
                                    Description cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="retDate" class="form-label">Return Date</label>
                                <input type="date" class="form-control" id="retDate" name="retDate">
                                <div class="invalid-feedback">
                                    Return date is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="amount" class="form-label">Service Charge (₹)</label>
                                <input type="number" class="form-control" id="amount" name="amount" min="1">
                                <div class="invalid-feedback">
                                    Service charge must be a valid positive number.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitFormBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!--Service Edit Popup Form Modal -->
        <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="serviceEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceEditModalLabel">Edit Service Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="serviceFormEdit" class="needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="serviceId" name="serviceId">
                            <div class="mb-2">
                                <label for="subCatNameEdit" class="form-label">Category Name</label>
                                <select class="form-control" id="subCatNameEdit" name="subCatNameEdit" required>
                                    <option value="">--Select a Category--</option>
                                    <?php
                                    $subCatSql = "SELECT
                                                    `subcat_id`,
                                                    `Subcategory`
                                                FROM
                                                    `asset_subcategory`
                                                WHERE
                                                    `staus` = 'Active'";
                                    $subCatResult = $conn->query($subCatSql);
                                    
                                    if ($subCatResult->num_rows > 0) {
                                        while ($row = $subCatResult->fetch_assoc()) {
                                            echo '<option value="' . $row['subcat_id'] . '">' . $row['Subcategory'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No Categories available</option>';
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a category. This field is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="proNameEdit" class="form-label">Product Name</label>
                                <select class="form-control" id="proNameEdit" name="proNameEdit" required>
                                    <option value="">--Select a Product Name--</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a product name. This field is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="serDateEdit" class="form-label">Service Date</label>
                                <input type="date" class="form-control" id="serDateEdit" name="serDateEdit" required>
                                <div class="invalid-feedback">
                                    Service date is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="descriptionEdit" class="form-label">Description</label>
                                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3" required></textarea>
                                <div class="invalid-feedback">
                                    Description cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="retDateEdit" class="form-label">Return Date</label>
                                <input type="date" class="form-control" id="retDateEdit" name="retDateEdit">
                                <div class="invalid-feedback">
                                    Return date is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="amountEdit" class="form-label">Service Charge (₹)</label>
                                <input type="number" class="form-control" id="amountEdit" name="amountEdit" min="1">
                                <div class="invalid-feedback">
                                    Service charge must be a valid positive number.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitEditBtn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Service View Popup Form Modal -->
        <div class="modal fade" id="viewServiceModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">View Service Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="fs-6"> 
                                    <td class="fw-bold w-25">Product Name</td> 
                                    <td class="w-5">:</td> 
                                    <td class="w-70" id="viewName"></td> 
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Service Date</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewSerDate"></td>
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Description</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewDescription"></td>
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Return Date</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewRetDate"></td>
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Amount</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewAmount"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>