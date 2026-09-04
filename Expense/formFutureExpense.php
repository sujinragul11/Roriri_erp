
        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpenseModalLabel">Add Future Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addExpenseForm" class="row g-3 needs-validation" novalidate>
                                <div class="mb-2">
                                    <label for="reason" class="form-label">Reason<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reason" name="reason" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Reason is required and cannot be empty.
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="amount" class="form-label">Amount(₹)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amount" name="amount" required min="0">
                                    <div class="invalid-feedback">
                                        Amount is required and cannot be empty.
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <label for="priority" class="form-label">Priority<span class="text-danger">*</span></label>
                                    <select class="form-control" id="priority" name="priority" required>
                                        <option value="">--Select Priority--</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Priority is required and cannot be empty.
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" pattern="^[^\s]+(\s+[^\s]+)*$"></textarea>
                                    <div class="invalid-feedback">
                                        Description is required and cannot be empty.
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExpenseModalLabel">Edit Future Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editExpenseForm" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" id="expenseId" name="expenseId">
                                <div class="mb-2">
                                    <label for="reasonEdit" class="form-label">Reason<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reasonEdit" name="reasonEdit" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Reason is required and cannot be empty.
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="amountEdit" class="form-label">Amount(₹)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amountEdit" name="amountEdit" required min="0">
                                    <div class="invalid-feedback">
                                        Amount is required and cannot be empty.
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <label for="priorityEdit" class="form-label">Priority<span class="text-danger">*</span></label>
                                    <select class="form-control" id="priorityEdit" name="priorityEdit" required>
                                        <option value="">--Select Priority--</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Priority is required and cannot be empty.
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="descriptionEdit" class="form-label">Description</label>
                                    <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" pattern="^[^\s]+(\s+[^\s]+)*$"></textarea>
                                    <div class="invalid-feedback">
                                        Description is required and cannot be empty.
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
        
