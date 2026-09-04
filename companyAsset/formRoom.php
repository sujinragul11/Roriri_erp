
        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roomModalLabel">Add Room Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="roomForm" class="row g-3 needs-validation" novalidate>
                            <div class="mb-3">
                        <label for="roomName" class="form-label">Room Name</label>
                        <input type="text" class="form-control" id="roomName" name="roomName" 
                               pattern="^(?!\s*$)[A-Za-z\s]+$" 
                               title="Please enter only letters and spaces. The name cannot start with a space or be empty/whitespace-only." 
                               required>
                        <div class="invalid-feedback">
                            Please provide a valid room name (letters and spaces only, cannot start with a space).
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
        <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="roomEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roomEditModalLabel">Edit Room Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="roomEditForm" class="row g-3 needs-validation" novalidate>
                            <input type="hidden" class="form-control" id="roomId" name="roomId">
                            <div class="mb-3">
                            <label for="editName" class="form-label">Room Name</label>
                            <input type="text" class="form-control" id="editName" name="editName" 
                                   pattern="^(?!\s*$)[A-Za-z\s]+$" 
                                   title="Please enter only letters and spaces. The name cannot start with a space or be empty/whitespace-only." 
                                   required>
                            <div class="invalid-feedback">
                                Please provide a valid room name (letters and spaces only, cannot start with a space).
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