<?php
include("auth.php");
include("portal_header.php");
?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">My Profile</h6></div>
            <div class="card-body">
                <form id="profForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pname" value="<?php echo htmlspecialchars($me['client_name']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="pcompany" value="<?php echo htmlspecialchars($me['client_company']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="pemail" value="<?php echo htmlspecialchars($me['client_email']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="pphone" value="<?php echo htmlspecialchars($me['client_phone']); ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Location / Address</label>
                            <input type="text" class="form-control" id="plocation" value="<?php echo htmlspecialchars($me['client_location']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($me['client_username']); ?>" disabled>
                            <div class="form-text">Username can only be changed by the admin.</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary" id="profSubmit">Save Changes</button>
                        <a href="change_password.php" class="btn btn-outline-secondary">Change Password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#profForm').on('submit', function (e) {
        e.preventDefault();
        var data = {
            hdnAction: 'updateProfile',
            pname: $('#pname').val().trim(),
            pcompany: $('#pcompany').val().trim(),
            pemail: $('#pemail').val().trim(),
            pphone: $('#pphone').val().trim(),
            plocation: $('#plocation').val().trim()
        };
        $('#profSubmit').prop('disabled', true);
        $.ajax({
            url: 'action/actPortal.php',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (res) {
                $('#profSubmit').prop('disabled', false);
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message }).then(function () { location.reload(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function () { $('#profSubmit').prop('disabled', false); alert('An error occurred.'); }
        });
    });
});
</script>
<?php include("portal_footer.php"); ?>
