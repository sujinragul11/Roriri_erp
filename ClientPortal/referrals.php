<?php
include("auth.php");
include("portal_header.php");

$points = (int)$me['client_points'];

$refs = [];
$rQ = mysqli_query($conn, "SELECT * FROM client_referral_tbl WHERE referring_client_id=$clientId ORDER BY ref_id DESC");
if ($rQ) { while ($r = mysqli_fetch_assoc($rQ)) { $refs[] = $r; } }
?>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card stat-card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3"><i class="bx bx-star"></i></div>
                <div>
                    <div class="fs-2 fw-bold"><?php echo $points; ?> Points</div>
                    <div class="text-secondary small">15 points = 1% of the credited client's first project amount</div>
                </div>
            </div>
        </div>
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">Refer Another Client</h6></div>
            <div class="card-body">
                <form id="refForm">
                    <div class="mb-3">
                        <label class="form-label">Client Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="refName" placeholder="e.g. Kumar Enterprises" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone (optional)</label>
                        <input type="text" class="form-control" id="refPhone" placeholder="e.g. 9876543210">
                    </div>
                    <button type="submit" class="btn btn-primary" id="refSubmit">Submit Referral</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">My Referrals</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead><tr><th>Referred Client</th><th>Points</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php if (count($refs) === 0): ?>
                            <tr><td colspan="4" class="text-center text-secondary">No referrals yet.</td></tr>
                        <?php else: foreach ($refs as $r): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r['referred_name']); ?></td>
                                <td><?php echo (int)$r['points']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($r['status']=='Credited')?'success':(($r['status']=='Pending')?'secondary':'warning'); ?>">
                                        <?php echo htmlspecialchars($r['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#refForm').on('submit', function (e) {
        e.preventDefault();
        var name = $('#refName').val().trim();
        if (!name) { alert('Referred client name is required.'); return; }
        $('#refSubmit').prop('disabled', true);
        $.ajax({
            url: 'action/actPortal.php',
            method: 'POST',
            data: {
                hdnAction: 'addReferral',
                refName: name,
                refPhone: $('#refPhone').val().trim()
            },
            dataType: 'json',
            success: function (res) {
                $('#refSubmit').prop('disabled', false);
                if (res.success) {
                    $('#refForm')[0].reset();
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function () { $('#refSubmit').prop('disabled', false); alert('An error occurred.'); }
        });
    });
});
</script>
<?php include("portal_footer.php"); ?>
