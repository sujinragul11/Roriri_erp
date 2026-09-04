<?php
include("auth.php");
include("portal_header.php");

$projects = [];
$pjQ = mysqli_query($conn, "SELECT project_id, project_name FROM project_tbl WHERE client=$clientId AND status='Active' ORDER BY project_id DESC");
if ($pjQ) { while ($pj = mysqli_fetch_assoc($pjQ)) { $projects[] = $pj; } }

$feedbacks = [];
$fQ = mysqli_query($conn, "SELECT f.*, p.project_name FROM client_feedback_tbl f LEFT JOIN project_tbl p ON f.project_id=p.project_id WHERE f.client_id=$clientId ORDER BY f.feedback_id DESC");
if ($fQ) { while ($f = mysqli_fetch_assoc($fQ)) { $feedbacks[] = $f; } }
?>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">Submit Feedback</h6></div>
            <div class="card-body">
                <form id="fbForm">
                    <div class="mb-3">
                        <label class="form-label">Project (optional)</label>
                        <select class="form-control" id="fbProject">
                            <option value="">-- Select Project --</option>
                            <?php foreach ($projects as $p): ?>
                                <option value="<?php echo $p['project_id']; ?>"><?php echo htmlspecialchars($p['project_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select class="form-control" id="fbRating">
                            <option value="">-- Select --</option>
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Good</option>
                            <option value="3">3 - Good</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comments</label>
                        <textarea class="form-control" id="fbComments" rows="4" placeholder="Share your experience..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="fbSubmit">Submit Feedback</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">My Feedback</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead><tr><th>Project</th><th>Rating</th><th>Comments</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php if (count($feedbacks) === 0): ?>
                            <tr><td colspan="4" class="text-center text-secondary">No feedback submitted yet.</td></tr>
                        <?php else: foreach ($feedbacks as $f): ?>
                            <tr>
                                <td><?php echo $f['project_name'] ? htmlspecialchars($f['project_name']) : '—'; ?></td>
                                <td><?php echo $f['rating'] ? str_repeat('★', (int)$f['rating']) . str_repeat('☆', 5 - (int)$f['rating']) : '—'; ?></td>
                                <td><?php echo htmlspecialchars(mb_strimwidth($f['comments'], 0, 50, '…')); ?></td>
                                <td><?php echo date('d M Y', strtotime($f['created_at'])); ?></td>
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
    $('#fbForm').on('submit', function (e) {
        e.preventDefault();
        var rating = $('#fbRating').val();
        var comments = $('#fbComments').val().trim();
        if (!rating && !comments) { alert('Please provide a rating or some comments.'); return; }
        $('#fbSubmit').prop('disabled', true);
        $.ajax({
            url: 'action/actPortal.php',
            method: 'POST',
            data: { hdnAction: 'addFeedback', projectId: $('#fbProject').val(), rating: rating, comments: comments },
            dataType: 'json',
            success: function (res) {
                $('#fbSubmit').prop('disabled', false);
                if (res.success) {
                    $('#fbForm')[0].reset();
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function () { $('#fbSubmit').prop('disabled', false); alert('An error occurred.'); }
        });
    });
});
</script>
<?php include("portal_footer.php"); ?>
