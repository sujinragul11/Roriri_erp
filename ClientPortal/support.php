<?php
include("auth.php");
include("portal_header.php");

$tickets = [];
$tQ = mysqli_query($conn, "SELECT * FROM client_support_tbl WHERE client_id=$clientId ORDER BY ticket_id DESC");
if ($tQ) { while ($t = mysqli_fetch_assoc($tQ)) { $tickets[] = $t; } }
?>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">Raise a Support Ticket</h6></div>
            <div class="card-body">
                <form id="ticketForm">
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tSubject" placeholder="Brief summary of the issue" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Describe the Issue <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="tDesc" rows="4" placeholder="Explain what you need help with..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select class="form-control" id="tPriority">
                            <option value="Low">Low</option>
                            <option value="Normal" selected>Normal</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" id="ticketSubmit">Submit Ticket</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">My Support Tickets</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead><tr><th>#</th><th>Subject</th><th>Priority</th><th>Status</th><th>Date</th><th></th></tr></thead>
                        <tbody>
                        <?php if (count($tickets) === 0): ?>
                            <tr><td colspan="6" class="text-center text-secondary">No tickets yet.</td></tr>
                        <?php else: foreach ($tickets as $tk): ?>
                            <tr>
                                <td>#<?php echo $tk['ticket_id']; ?></td>
                                <td><?php echo htmlspecialchars(mb_strimwidth($tk['subject'], 0, 40, '…')); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($tk['priority']=='High')?'danger':(($tk['priority']=='Low')?'info':'secondary'); ?>"><?php echo htmlspecialchars($tk['priority']); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo ($tk['status']=='Closed')?'success':'warning'; ?>"><?php echo htmlspecialchars($tk['status']); ?></span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($tk['created_at'])); ?></td>
                                <td><button class="btn btn-sm btn-outline-primary" onclick="viewTicket(<?php echo $tk['ticket_id']; ?>)"><i class="bx bx-show"></i></button></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View ticket modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Ticket Details</h6><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body" id="ticketBody"></div>
        </div>
    </div>
</div>

<script>
var tickets = <?php echo json_encode($tickets); ?>;
function viewTicket(id) {
    var tk = tickets.find(function (t) { return t.ticket_id == id; });
    if (!tk) return;
    var html = '<p><strong>Subject:</strong> ' + tk.subject + '</p>' +
               '<p><strong>Description:</strong></p><p style="white-space:pre-wrap;">' + $('<div>').text(tk.description).html() + '</p>' +
               '<p><strong>Priority:</strong> ' + tk.priority + ' &nbsp; <strong>Status:</strong> ' + tk.status + '</p>';
    if (tk.admin_reply) {
        html += '<div class="border rounded p-3 mt-2 bg-light"><strong>Admin Reply:</strong><br>' + $('<div>').text(tk.admin_reply).html() + '</div>';
    }
    $('#ticketBody').html(html);
    $('#ticketModal').modal('show');
}
$(document).ready(function () {
    $('#ticketForm').on('submit', function (e) {
        e.preventDefault();
        var subject = $('#tSubject').val().trim();
        var desc = $('#tDesc').val().trim();
        if (!subject || !desc) { alert('Subject and description are required.'); return; }
        $('#ticketSubmit').prop('disabled', true);
        $.ajax({
            url: 'action/actPortal.php',
            method: 'POST',
            data: { hdnAction: 'addTicket', subject: subject, description: desc, priority: $('#tPriority').val() },
            dataType: 'json',
            success: function (res) {
                $('#ticketSubmit').prop('disabled', false);
                if (res.success) {
                    $('#ticketForm')[0].reset();
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function () { $('#ticketSubmit').prop('disabled', false); alert('An error occurred.'); }
        });
    });
});
</script>
<?php include("portal_footer.php"); ?>
