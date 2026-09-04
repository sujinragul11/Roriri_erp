<?php
include("auth.php");
include("portal_header.php");

$reqs = [];
$rQ = mysqli_query($conn, "SELECT * FROM client_project_req_tbl WHERE client_id=$clientId ORDER BY req_id DESC");
if ($rQ) { while ($r = mysqli_fetch_assoc($rQ)) { $reqs[] = $r; } }
?>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">Submit a Project Requirement</h6></div>
            <div class="card-body">
                <form id="reqForm">
                    <div class="mb-3">
                        <label class="form-label">Project Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="reqTitle" placeholder="e.g. College Management Website" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reqDesc" rows="4" placeholder="Describe what you need..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Budget (optional)</label>
                        <input type="number" class="form-control" id="reqBudget" min="0" step="0.01" placeholder="e.g. 50000">
                    </div>
                    <button type="submit" class="btn btn-primary" id="reqSubmit">Submit Requirement</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">My Submitted Requirements</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead><tr><th>Title</th><th>Description</th><th>Budget</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php if (count($reqs) === 0): ?>
                            <tr><td colspan="5" class="text-center text-secondary">No requirements submitted yet.</td></tr>
                        <?php else: foreach ($reqs as $r): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r['project_title']); ?></td>
                                <td><?php echo htmlspecialchars(mb_strimwidth($r['description'], 0, 60, '…')); ?></td>
                                <td><?php echo $r['budget'] !== null ? '₹ ' . number_format((float)$r['budget']) : '—'; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($r['status']=='Approved')?'success':(($r['status']=='Rejected')?'danger':'secondary'); ?>">
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
    $('#reqForm').on('submit', function (e) {
        e.preventDefault();
        var title = $('#reqTitle').val().trim();
        var desc = $('#reqDesc').val().trim();
        if (!title || !desc) { alert('Title and description are required.'); return; }
        $('#reqSubmit').prop('disabled', true);
        $.ajax({
            url: 'action/actPortal.php',
            method: 'POST',
            data: {
                hdnAction: 'addRequirement',
                title: title,
                description: desc,
                budget: $('#reqBudget').val()
            },
            dataType: 'json',
            success: function (res) {
                $('#reqSubmit').prop('disabled', false);
                if (res.success) {
                    $('#reqForm')[0].reset();
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function () { $('#reqSubmit').prop('disabled', false); alert('An error occurred.'); }
        });
    });
});
</script>
<?php include("portal_footer.php"); ?>
