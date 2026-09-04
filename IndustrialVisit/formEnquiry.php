        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addEnquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="enquiryModalLabel">Add Enquiry Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="enquiryForm" class="row g-3 needs-validation" novalidate>
                            <div class="mb-2">
                                <label for="name" class="form-label">College Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">
                                    College Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required pattern="^[0-9]{10}$" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <div class="invalid-feedback">
                                    Phone number must be 10 digits.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"  pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="date" class="form-label">IV Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                                <div class="invalid-feedback">
                                    IV Date is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Description cannot be empty.
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
        
        <!--Edit Popup Form Modal -->
        <div class="modal fade" id="editEnquiryModal" tabindex="-1" aria-labelledby="enquiryEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="enquiryEditModalLabel">Edit Enquiry Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="enquiryFormEdit" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" id="enquiryId" name="enquiryId">
                            <div class="mb-2">
                                <label for="nameEdit" class="form-label">College Name</label>
                                <input type="text" class="form-control" id="nameEdit" name="nameEdit" required>
                                <div class="invalid-feedback">
                                    College Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="phoneEdit" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phoneEdit" name="phoneEdit" required pattern="^[0-9]{10}$" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <div class="invalid-feedback">
                                    Phone number must be 10 digits.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="emailEdit" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailEdit" name="emailEdit"  pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="dateEdit" class="form-label">IV Date</label>
                                <input type="date" class="form-control" id="dateEdit" name="dateEdit" required>
                                <div class="invalid-feedback">
                                    IV Date is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="descriptionEdit" class="form-label">Description</label>
                                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Description cannot be empty.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitEditBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>