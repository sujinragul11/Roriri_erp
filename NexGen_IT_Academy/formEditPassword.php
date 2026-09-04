<!-- Modal -->
<div class="modal fade" id="editPasswordModule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddStudent" id="editPassword_form" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="editPassword">
                <input type="hidden" name="profileId" id="profileId_input">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Change Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        
                    <div class="col-md-12">
                                    <div class="form-group pb-3">
                                        <label for="editPassword" class="form-label"><b>Password</b><span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter password" name="editPassword"
                                            id="editPassword_input">
                                    </div>
                                </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="password_change" class="btn btn-primary" <?php if ($_SESSION['id'] == 86) echo 'disabled'; ?>>Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
