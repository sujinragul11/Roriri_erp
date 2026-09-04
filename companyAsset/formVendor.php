        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addVendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vendorModalLabel">Add Vendor Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="vendorForm" class="row g-3 needs-validation" novalidate>
                            <div class="mb-2">
                                <label for="vendorName" class="form-label">Vendor Name</label>
                                <input type="text" class="form-control" id="vendorName" name="vendorName" required pattern="^(?! )[A-Za-z]*(\.[A-Za-z]+)?( [A-Za-z]+)*[a-z]*$">
                                <div class="invalid-feedback">
                                    Vendor Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="comName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="comName" name="comName">
                                <div class="invalid-feedback">
                                    Company Name cannot be empty.
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
                                <label for="location" class="form-label">Location</label>
                                <textarea class="form-control" id="location" name="location" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Location cannot be empty.
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
        
        
        <!--Room Edit Popup Form Modal -->
        <div class="modal fade" id="editVendorModal" tabindex="-1" aria-labelledby="vendorEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vendorEditModalLabel">Edit Vendor Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="vendorFormEdit" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="vendorId" name="vendorId">
                            <div class="mb-2">
                                <label for="vendorNameEdit" class="form-label">Vendor Name</label>
                                <input type="text" class="form-control" id="vendorNameEdit" name="vendorNameEdit" required pattern="^(?! )[A-Za-z]*(\.[A-Za-z]+)?( [A-Za-z]+)*[a-z]*$">
                                <div class="invalid-feedback">
                                    Vendor Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="comNameEdit" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="comNameEdit" name="comNameEdit">
                                <div class="invalid-feedback">
                                    Company Name cannot be empty.
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
                                <label for="locationEdit" class="form-label">Location</label>
                                <textarea class="form-control" id="locationEdit" name="locationEdit" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Location cannot be empty.
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
        
        <!--Vendor View Popup Form Modal -->
        <div class="modal fade" id="viewVendorModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">View Vendor Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="fs-6"> 
                                    <td class="fw-bold w-25">Vendor Name</td> 
                                    <td class="w-5">:</td> 
                                    <td class="w-70" id="viewName"></td> 
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Company Name</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewCompany"></td>
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Phone</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewPhone"></td>
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Email</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewEmail"></td>
                                </tr>
                                <tr class="fs-6">
                                    <td class="fw-bold w-25">Location</td>
                                    <td class="w-5">:</td>
                                    <td class="w-70" id="viewLocation"></td>
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