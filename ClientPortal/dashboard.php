<?php
include("auth.php");
include("portal_header.php");

// Stats
$points = (int)$me['client_points'];
$projectCount = 0;
$pQ = mysqli_query($conn, "SELECT COUNT(*) c FROM project_tbl WHERE client=$clientId AND status='Active'");
if ($pQ && $pRow = mysqli_fetch_assoc($pQ)) { $projectCount = (int)$pRow['c']; }

$msgCount = 0;
$mQ = mysqli_query($conn, "SELECT COUNT(*) c FROM client_message_tbl WHERE client_id=$clientId");
if ($mQ && $mRow = mysqli_fetch_assoc($mQ)) { $msgCount = (int)$mRow['c']; }

$refCount = 0;
$rQ = mysqli_query($conn, "SELECT COUNT(*) c FROM client_referral_tbl WHERE referring_client_id=$clientId");
if ($rQ && $rRow = mysqli_fetch_assoc($rQ)) { $refCount = (int)$rRow['c']; }

// Projects list
$projects = [];
$pjQ = mysqli_query($conn, "SELECT * FROM project_tbl WHERE client=$clientId AND status='Active' ORDER BY project_id DESC");
if ($pjQ) { while ($pj = mysqli_fetch_assoc($pjQ)) { $projects[] = $pj; } }
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Welcome, <?php echo htmlspecialchars($me['client_name']); ?></h4>
        <small class="text-secondary"><?php echo htmlspecialchars($me['client_company']); ?> &middot; <?php echo htmlspecialchars($me['client_email']); ?></small>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3"><i class="bx bx-star"></i></div>
                <div><div class="fs-4 fw-bold"><?php echo $points; ?></div><div class="text-secondary small">Points Balance</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success me-3"><i class="bx bx-briefcase"></i></div>
                <div><div class="fs-4 fw-bold"><?php echo $projectCount; ?></div><div class="text-secondary small">Projects</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info me-3"><i class="bx bx-chat"></i></div>
                <div><div class="fs-4 fw-bold"><?php echo $msgCount; ?></div><div class="text-secondary small">Messages</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3"><i class="bx bx-gift"></i></div>
                <div><div class="fs-4 fw-bold"><?php echo $refCount; ?></div><div class="text-secondary small">Referrals Made</div></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card stat-card">
            <div class="card-header bg-transparent"><h6 class="mb-0">My Projects</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead><tr><th>Project</th><th>Technology</th><th>Total Pay</th><th>Status</th></tr></thead>
                        <tbody>
                        <?php if (count($projects) === 0): ?>
                            <tr><td colspan="4" class="text-center text-secondary">No projects yet.</td></tr>
                        <?php else: foreach ($projects as $pj): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pj['project_name']); ?></td>
                                <td><?php echo htmlspecialchars(trim($pj['technology'], '[]"') ); ?></td>
                                <td>₹ <?php echo number_format((float)$pj['total_pay']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($pj['project_status']=='Completed')?'success':(($pj['project_status']=='In Progress')?'warning':'secondary'); ?>">
                                        <?php echo htmlspecialchars($pj['project_status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("portal_footer.php"); ?>
