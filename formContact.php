        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContactModalLabel">Add Contact Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addContactForm" class="row needs-validation" novalidate>
                            <div class="mb-2">
                                    <label for="inchargeName" class="form-label">Incharge Name<span class="text-danger">*</span></label>
                                    <select class="form-control" id="inchargeName" name="inchargeName" required>
                                        <option value="">--Select Incharge Name--</option>
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
                            
                            <div class="mb-2">
                                    <label for="department" class="form-label">Department<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="department" name="department" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Department is required and cannot be empty.
                                    </div>
                            </div>
                        
                            <div class="mb-2">
                                    <label for="contact" class="form-label">Contact No.<span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="contact" name="contact" required pattern="^[0-9]{10}$" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    <div class="invalid-feedback">
                                        Contact No. is required and cannot be empty.
                                    </div>
                            </div>
                        
                            <div class="mb-2">
                                    <label for="url" class="form-label">URL</label>
                                    <input type="text" class="form-control" id="url" name="url" pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        URL link is required and cannot be empty.
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
        <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editContactModalLabel">Edit Contact Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editContactForm" class="row needs-validation" novalidate>
                            <input type="hidden" id="editContactId" name="editContactId">
                            <div class="mb-2">
                                    <label for="inchargeNameEdit" class="form-label">Incharge Name<span class="text-danger">*</span></label>
                                    <select class="form-control" id="inchargeNameEdit" name="inchargeNameEdit" required>
                                        <option value="">--Select Incharge Name--</option>
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
                            
                            <div class="mb-2">
                                    <label for="departmentEdit" class="form-label">Department<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="departmentEdit" name="departmentEdit" required pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        Department is required and cannot be empty.
                                    </div>
                            </div>
                        
                            <div class="mb-2">
                                    <label for="contactEdit" class="form-label">Contact No.<span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="contactEdit" name="contactEdit" required pattern="^[0-9]{10}$" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    <div class="invalid-feedback">
                                        Contact No. is required and cannot be empty.
                                    </div>
                            </div>
                        
                            <div class="mb-2">
                                    <label for="urlEdit" class="form-label">URL</label>
                                    <input type="text" class="form-control" id="urlEdit" name="urlEdit" pattern="^[^\s]+(\s+[^\s]+)*$">
                                    <div class="invalid-feedback">
                                        URL link is required and cannot be empty.
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