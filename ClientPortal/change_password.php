<?php
include("auth.php");
include("portal_header.php");
?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">Change Password</h6></div>
            <div class="card-body">
                <form id="cpForm">
                    <div class="mb-3">
                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="oldPassword" autocomplete="current-password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="newPassword" autocomplete="new-password" required>
                        <div class="form-text">Minimum 6 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="confirmPassword" autocomplete="new-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="cpSubmit">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#cpForm').on('submit', function (e) {
        e.preventDefault();
        var oldP = $('#oldPassword').val();
        var newP = $('#newPassword').val();
        var confP = $('#confirmPassword').val();
        if (!oldP || !newP || !confP) { alert('All fields are required.'); return; }
        if (newP.length < 6) { alert('New password must be at least 6 characters.'); return; }
        if (newP !== confP) { alert('New password and confirmation do not match.'); return; }
        $('#cpSubmit').prop('disabled', true);
        $.ajax({
            url: 'action/actPortal.php',
            method: 'POST',
            data: { hdnAction: 'changePassword', oldPassword: oldP, newPassword: newP, confirmPassword: confP },
            dataType: 'json',
            success: function (res) {
                $('#cpSubmit').prop('disabled', false);
                if (res.success) {
                    $('#cpForm')[0].reset();
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function () { $('#cpSubmit').prop('disabled', false); alert('An error occurred.'); }
        });
    });
});
</script>
<?php include("portal_footer.php"); ?>
