        <!--Add Popup Form Modal -->
        <div class="modal fade" id="addBannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bannerModalLabel">Add Banner Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="bannerForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <div class="mb-2">
                                <label for="image" class="form-label">Promotion Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png" required>
                                <div class="invalid-feedback">
                                    Promotion Image is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="name" class="form-label">Banner Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">
                                    Banner Name is required and cannot be empty.
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
        <div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="bannerEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bannerEditModalLabel">Edit Banner Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="bannerFormEdit" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <input type="hidden" class="form-control" id="bannerId" name="bannerId">
                            <div class="mb-2">
                                <label for="imageEdit" class="form-label">Promotion Image</label>
                                <input type="file" class="form-control" id="imageEdit" name="imageEdit" accept=".jpg, .jpeg, .png">
                                <div class="invalid-feedback">
                                    Promotion Image is required and cannot be empty.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="nameEdit" class="form-label">Banner Name</label>
                                <input type="text" class="form-control" id="nameEdit" name="nameEdit" required>
                                <div class="invalid-feedback">
                                    Banner Name is required and cannot be empty.
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