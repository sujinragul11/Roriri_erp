
        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addExpenseForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="expenseDate" class="form-label">Expense Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="expenseDate" name="expenseDate" required max="<?= date('Y-m-d'); ?>">
                                    <div class="invalid-feedback">
                                        Expense Date is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="categoryName" class="form-label">Category Name<span class="text-danger">*</span></label>
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
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="subCatName" class="form-label">SubCategory Name<span class="text-danger">*</span></label>
                                    <select class="form-control" id="subCatName" name="subCatName" required>
                                        <option value="">--Select SubCategory--</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        SubCategory Name is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="receiverName" class="form-label">Receiver Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="receiverName" name="receiverName" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Receiver Name is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">Amount<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amount" name="amount" required min="0">
                                    <div class="invalid-feedback">
                                        Amount is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="mode" class="form-label">Transaction Mode<span class="text-danger">*</span></label>
                                    <select class="form-control" id="mode" name="mode" required>
                                        <option value="">Select Transaction Mode</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Gpay">Gpay</option>
                                        <option value="Phonepe">Phonepe</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Paytm">Paytm</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Transaction Mode is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="transcationId" class="form-label">Transaction ID</label>
                                    <input type="text" class="form-control" id="transcationId" name="transcationId" pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Transaction ID is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bill" class="form-label">Bill</label>
                                    <input type="file" class="form-control" id="bill" name="bill" accept=".jpg, .jpeg, .png, .pdf">
                                    <div class="invalid-feedback">
                                        Bill is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" pattern="^[^\s]+(\s+[^\s]+)*$"></textarea>
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
        <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editExpenseForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <input type="hidden" id="expenseId" name="expenseId">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="expenseDateEdit" class="form-label">Expense Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="expenseDateEdit" name="expenseDateEdit" required max="<?= date('Y-m-d'); ?>">
                                    <div class="invalid-feedback">
                                        Expense Date is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="categoryNameEdit" class="form-label">Category Name<span class="text-danger">*</span></label>
                                    <select class="form-control" id="categoryNameEdit" name="categoryNameEdit" required>
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
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="subCatNameEdit" class="form-label">SubCategory Name<span class="text-danger">*</span></label>
                                    <select class="form-control" id="subCatNameEdit" name="subCatNameEdit" required>
                                        <option value="">--Select SubCategory--</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        SubCategory Name is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="receiverNameEdit" class="form-label">Receiver Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="receiverNameEdit" name="receiverNameEdit" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Receiver Name is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="amountEdit" class="form-label">Amount<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amountEdit" name="amountEdit" required min="0">
                                    <div class="invalid-feedback">
                                        Amount is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="modeEdit" class="form-label">Transaction Mode<span class="text-danger">*</span></label>
                                    <select class="form-control" id="modeEdit" name="modeEdit" required>
                                        <option value="">Select Transaction Mode</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Gpay">Gpay</option>
                                        <option value="Phonepe">Phonepe</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Paytm">Paytm</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Transaction Mode is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="transcationIdEdit" class="form-label">Transaction ID</label>
                                    <input type="text" class="form-control" id="transcationIdEdit" name="transcationIdEdit" pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Transaction ID is required and cannot be empty.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="billEdit" class="form-label">Bill</label>
                                    <input type="file" class="form-control" id="billEdit" name="billEdit" accept=".jpg, .jpeg, .png, .pdf">
                                    <div class="invalid-feedback">
                                        Bill is required and cannot be empty.
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="descriptionEdit" class="form-label">Description</label>
                                    <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" pattern="^[^\s]+(\s+[^\s]+)*$"></textarea>
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
        <div class="modal fade" id="viewExpenseModal" tabindex="-1" aria-labelledby="viewExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2" id="viewExpenseModalLabel">Expense Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Expense Details Content -->
                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Expense Date</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewExpenseDate" class="fs-5"></span>
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
                        <strong class="fs-5">Subcategory Name</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewSubCategoryName" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Receiver Name</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewReceiverName" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Amount</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewAmount" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Payment Mode</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewMode" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Transaction ID</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewTransactionId" class="fs-5"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <strong class="fs-5">Bill</strong>
                    </div>
                    <div class="col-1">
                        <strong class="fs-5">:</strong>
                    </div>
                    <div class="col-7">
                        <span id="viewBill" class="fs-5"></span>
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

