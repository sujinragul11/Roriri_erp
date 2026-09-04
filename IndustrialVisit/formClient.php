        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clientModalLabel">Add Client Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="clientForm" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="htnName" name="htnName" value="addClient">
                            <div class="mb-2">
                                <label for="clientName" class="form-label">College Name</label>
                                <input type="text" class="form-control" id="clientName" name="clientName" required pattern="^(?! )[A-Za-z]*(\.[A-Za-z]+)?( [A-Za-z]+)*[a-z]*$">
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
                                <label for="location" class="form-label">Location</label>
                                <textarea class="form-control" id="location" name="location" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Location cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <div class="invalid-feedback">
                                    Username is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">
                                    Password is required and cannot be empty.
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
        <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="clientEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clientEditModalLabel">Edit Client Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="clientFormEdit" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="editClient" name="htnName" value="editClient">
                            <input type="hidden" class="form-control" id="clientId" name="clientId">
                            <div class="mb-2">
                                <label for="clientNameEdit" class="form-label">College Name</label>
                                <input type="text" class="form-control" id="clientNameEdit" name="clientNameEdit" required pattern="^(?! )[A-Za-z]*(\.[A-Za-z]+)?( [A-Za-z]+)*[a-z]*$">
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
                                <label for="locationEdit" class="form-label">Location</label>
                                <textarea class="form-control" id="locationEdit" name="locationEdit" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Location cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="passwordEdit" class="form-label">Password</label>
                                <input type="text" class="form-control" id="passwordEdit" name="passwordEdit" required>
                                <div class="invalid-feedback">
                                    Password is required and cannot be empty.
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
        
        <!--Add Student details Form Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentModalLabel">Add Student Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="studentForm" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="htnVisitId" name="htnVisitId">
                            <div class="mb-2">
                                <label for="studentName" class="form-label">Student Name</label> 
                                <input type="text" class="form-control" id="studentName" name="studentName" required pattern="^(?! )[A-Za-z]*(\.[A-Za-z]+)?( [A-Za-z]+)*[a-z]*$">
                                <div class="invalid-feedback">
                                    Student Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="stuPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="stuPhone" name="stuPhone" required pattern="^[0-9]{10}$" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <div class="invalid-feedback">
                                    Phone number must be 10 digits.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="stuEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="stuEmail" name="stuEmail"  pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="stuLocation" class="form-label">Location</label>
                                <textarea class="form-control" id="stuLocation" name="stuLocation" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Location cannot be empty.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="stuSubmitBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Edit Student details Form Modal -->
        <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="studentEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentEditModalLabel">Edit Student Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="studentFormEdit" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="editVisitId" name="editVisitId">
                            <input type="hidden" class="form-control" id="editStuId" name="editStuId">
                            <div class="mb-2">
                                <label for="studentNameEdit" class="form-label">Student Name</label> 
                                <input type="text" class="form-control" id="studentNameEdit" name="studentNameEdit" required pattern="^(?! )[A-Za-z]*(\.[A-Za-z]+)?( [A-Za-z]+)*[a-z]*$">
                                <div class="invalid-feedback">
                                    Student Name is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="stuPhoneEdit" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="stuPhoneEdit" name="stuPhoneEdit" required pattern="^[0-9]{10}$" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <div class="invalid-feedback">
                                    Phone number must be 10 digits.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="stuEmailEdit" class="form-label">Email</label>
                                <input type="email" class="form-control" id="stuEmailEdit" name="stuEmailEdit"  pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="stuLocationEdit" class="form-label">Location</label>
                                <textarea class="form-control" id="stuLocationEdit" name="stuLocationEdit" rows="3" ></textarea>
                                <div class="invalid-feedback">
                                    Location cannot be empty.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="stuEditSubmitBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        