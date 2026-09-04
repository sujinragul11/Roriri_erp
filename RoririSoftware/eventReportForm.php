
<!-- Add Report Modal -->

<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Add Event / Meeting</h5>
                <button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmAddDepartment" id="addDepartment" novalidate>
                    <input type="hidden" name="hdnAction" value="addDepartment">

                    <!-- Event Date -->
                    <div class="col-md-6 form-group">
                        <label for="eventDate">Date: <span class="text-danger">*</span></label>
                        <input type="date" id="eventDate" name="eventDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        <div class="invalid-feedback">Please select a date.</div>
                    </div>

                    <!-- Category Field -->
                    <div class="col-md-6 form-group">
                        <label for="category">Category: <span class="text-danger">*</span></label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="">--Select Category--</option>
                            <option value="Event">Event</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Games">Games</option>
                        </select>
                        <div class="invalid-feedback">Please select a category.</div>
                    </div>

                    <!-- Subcategory Field -->
                    <div class="col-md-6 form-group">
                        <label for="subcategory">Subcategory: <span class="text-danger">*</span></label>
                        <select id="subcategory" name="subcategory" class="form-control" required>
                            <option value="">--Select Subcategory--</option>
                            <option value="Intership">Intership</option>
                            <option value="Mega Job Fair">Mega Job Fair</option>
                            <option value="Blueprint">Blueprint</option>
                        </select>
                        <div class="invalid-feedback">Please select a subcategory.</div>
                    </div>

                    <!-- Participants -->
                    <div class="col-md-6">
                        <label for="multiple-select-clear-field" class="form-label">Participants</label>
                        <select class="form-select" id="multiple-select-clear-field" data-placeholder="Choose participants" multiple>
                            <option value="Vasanth">Vasanth</option>
                            <option value="Rajkumar">Rajkumar</option>
                            <option value="Sriram">Sriram</option>
                            <option value="Nobel">Nobel</option>
                            <option value="Maariraj">Maariraj</option>
                        </select>
                    </div>

                    <!-- Hours Field -->
                    <div class="col-md-6">
                        <label for="hours" class="form-label">Hours <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="hours" id="hours" min="0" step="0.1" placeholder="Enter number of hours spent" required>
                        <div class="invalid-feedback">Please provide the hours spent.</div>
                    </div>

                    <!-- Place Field -->
                    <div class="col-md-6">
                        <label for="place" class="form-label">Place<span class="text-danger">*</span></label>
                        <select class="form-control" name="place" id="place" required>
                            <option value="">--Select--</option>
                            <option value="Employee Room">Employee Room</option>
                            <option value="Conference Room">Conference Room</option>
                            <option value="Trainee Room">Trainee Room</option>
                            <option value="Gorden">Gorden</option>
                        </select>
                        <div class="invalid-feedback">Please select a place.</div>
                    </div>

                    <!-- Guest Field -->
                    <div class="col-md-12">
                        <label for="guest" class="form-label">Guest</label>
                        <textarea class="form-control" id="guest" name="guest" placeholder="Guest ..." rows="3"></textarea>
                    </div>

                    <!-- Description Field with Quill Editor -->
                    <div class="col-md-12">
                        <label for="description" class="form-label">Description </label>
                        <div id="editor" style="height: 200px;"></div>
                        <textarea class="form-control" name="description" id="description" style="display:none;"></textarea>
                    </div>

                    <!-- Status Field -->
                    <div class="col-md-12">
                        <label for="projectStatus" class="form-label">Status<span class="text-danger">*</span></label>
                        <select class="form-control" name="projectStatus" id="projectStatus" required>
                            <option value="">--Select--</option>
                            <option value="Complete">Completed</option>
                            <option value="In Progress">Upcoming</option>
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Report Modal -->

<div class="modal fade" id="editReportModal" tabindex="-1" aria-labelledby="editReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event / Meeting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4">
                <form class="row g-3 needs-validation" name="frmEditDepartment" id="editDepartment" novalidate>
                    <input type="hidden" name="hdnAction" value="editDepartment">
                    <input type="hidden" name="editReportId" id="editReportId">

                    <!-- Event Date -->
                    <div class="col-md-6 form-group">
                        <label for="eventDateEdit">Date: <span class="text-danger">*</span></label>
                        <input type="date" id="eventDateEdit" name="eventDateEdit" class="form-control" required>
                        <div class="invalid-feedback">Please select a date.</div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 form-group">
                        <label for="categoryEdit">Category: <span class="text-danger">*</span></label>
                        <select id="categoryEdit" name="categoryEdit" class="form-control" required>
                            <option value="">--Select Category--</option>
                            <option value="Event">Event</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Games">Games</option>
                        </select>
                        <div class="invalid-feedback">Please select a category.</div>
                    </div>

                    <!-- Subcategory -->
                    <div class="col-md-6 form-group">
                        <label for="subcategoryEdit">Subcategory: <span class="text-danger">*</span></label>
                        <select id="subcategoryEdit" name="subcategoryEdit" class="form-control" required>
                            <option value="">--Select Subcategory--</option>
                            <option value="Intership">Intership</option>
                            <option value="Mega Job Fair">Mega Job Fair</option>
                            <option value="Blueprint">Blueprint</option>
                        </select>
                        <div class="invalid-feedback">Please select a subcategory.</div>
                    </div>

                    <!-- Participants -->
                    <div class="col-md-6">
                        <label class="form-label">Participants</label>
                        <select class="form-select" id="participantsEdit" data-placeholder="Choose participants" multiple>
                            <option value="Vasanth">Vasanth</option>
                            <option value="Rajkumar">Rajkumar</option>
                            <option value="Sriram">Sriram</option>
                            <option value="Nobel">Nobel</option>
                            <option value="Maariraj">Maariraj</option>
                        </select>
                    </div>

                    <!-- Hours -->
                    <div class="col-md-6">
                        <label for="hoursEdit" class="form-label">Hours <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="hoursEdit" id="hoursEdit" min="0" step="0.1" required>
                        <div class="invalid-feedback">Please provide the hours spent.</div>
                    </div>

                    <!-- Place -->
                    <div class="col-md-6">
                        <label for="placeEdit" class="form-label">Place<span class="text-danger">*</span></label>
                        <select class="form-control" name="placeEdit" id="placeEdit" required>
                            <option value="">--Select--</option>
                            <option value="Employee Room">Employee Room</option>
                            <option value="Conference Room">Conference Room</option>
                            <option value="Trainee Room">Trainee Room</option>
                            <option value="Gorden">Gorden</option>
                        </select>
                        <div class="invalid-feedback">Please select a place.</div>
                    </div>

                    <!-- Guest -->
                    <div class="col-md-12">
                        <label for="guestEdit" class="form-label">Guest</label>
                        <textarea class="form-control" id="guestEdit" name="guestEdit" placeholder="Guest ..." rows="3"></textarea>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label for="descriptionEdit" class="form-label">Description</label>
                        <div id="editorEdit" style="height: 200px;"></div>
                        <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" style="display:none;"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-md-12">
                        <label for="projectStatusEdit" class="form-label">Status<span class="text-danger">*</span></label>
                        <select class="form-control" name="projectStatusEdit" id="projectStatusEdit" required>
                            <option value="">--Select--</option>
                            <option value="Complete">Completed</option>
                            <option value="In Progress">Upcoming</option>
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- View Report Modal -->

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Event / Meeting Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Date:</strong>
                        <p id="viewDate"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Category:</strong>
                        <p id="viewCategory"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Subcategory:</strong>
                        <p id="viewSubcategory"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Participants:</strong>
                        <p id="viewParticipants"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Hours:</strong>
                        <p id="viewHours"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Place:</strong>
                        <p id="viewPlace"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Guest:</strong>
                        <p id="viewGuest"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p id="viewStatus"></p>
                    </div>
                    <div class="col-md-12">
                        <strong>Description:</strong>
                        <p id="viewDescription"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
