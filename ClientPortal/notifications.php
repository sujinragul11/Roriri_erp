<?php
include("auth.php");

mysqli_query($conn, "UPDATE client_notification_tbl SET is_read=1 WHERE client_id=$clientId AND is_read=0");
include("portal_header.php");

$notifs = [];
$nQ = mysqli_query($conn, "SELECT * FROM client_notification_tbl WHERE client_id=$clientId ORDER BY notif_id DESC");
if ($nQ) { while ($n = mysqli_fetch_assoc($nQ)) { $notifs[] = $n; } }
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card stat-card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Notifications</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php if (count($notifs) === 0): ?>
                        <li class="list-group-item text-center text-secondary">No notifications yet.</li>
                    <?php else: foreach ($notifs as $n): ?>
                        <li class="list-group-item d-flex">
                            <div class="me-3 fs-4">
                                <i class="bx <?php echo $n['type']=='welcome'?'bx-smile':($n['type']=='credentials'?'bx-lock-alt':'bx-bell'); ?>"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold"><?php echo htmlspecialchars($n['title']); ?></div>
                                <div class="text-secondary small"><?php echo nl2br(htmlspecialchars($n['message'])); ?></div>
                                <div class="text-muted small mt-1"><?php echo date('d M Y h:i A', strtotime($n['created_at'])); ?></div>
                            </div>
                        </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include("portal_footer.php"); ?>
