<?php
// Portal header + sidebar/nav for client pages.
// Requires auth.php already included (provides $me, $conn, $clientId).
$unreadCount = 0;
$cQ = mysqli_query($conn, "SELECT COUNT(*) c FROM client_message_tbl WHERE client_id=$clientId AND sender='admin' AND is_read=0");
if ($cQ && $cRow = mysqli_fetch_assoc($cQ)) { $unreadCount = (int)$cRow['c']; }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Portal</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="../assets/css/icons.css" rel="stylesheet">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background: #f4f6fb; }
        .portal-navbar { background: #1e2a4a; }
        .portal-navbar .navbar-brand { color: #fff; font-weight: 600; }
        .portal-navbar .nav-link { color: #c3cbe4; }
        .portal-navbar .nav-link.active, .portal-navbar .nav-link:hover { color: #fff; }
        .stat-card { border: 0; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.05); }
        .stat-card .stat-icon { width: 52px; height: 52px; border-radius: 12px; display:flex; align-items:center; justify-content:center; font-size:22px; }
        .chat-box { height: 420px; overflow-y: auto; background:#fff; border-radius:12px; padding:16px; }
        .bubble { max-width:75%; padding:10px 14px; border-radius:12px; margin-bottom:10px; }
        .bubble.client { background:#1e2a4a; color:#fff; margin-left:auto; }
        .bubble.admin { background:#e9ecf5; color:#222; }
        .msg-time { font-size:11px; opacity:.7; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg portal-navbar ps-0 pe-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Client Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#portalNav" aria-controls="portalNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="portalNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bx bx-home"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="messages.php"><i class="bx bx-chat"></i> Messages <?php if($unreadCount>0): ?><span class="badge bg-danger"><?php echo $unreadCount; ?></span><?php endif; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="requirements.php"><i class="bx bx-task"></i> Project Requirements</a></li>
                <li class="nav-item"><a class="nav-link" href="referrals.php"><i class="bx bx-gift"></i> Referrals & Points</a></li>
                <li class="nav-item"><a class="nav-link" href="support.php"><i class="bx bx-support"></i> Support</a></li>
                <li class="nav-item"><a class="nav-link" href="feedback.php"><i class="bx bx-message-rounded-dots"></i> Feedback</a></li>
                <li class="nav-item"><a class="nav-link" href="notifications.php"><i class="bx bx-bell"></i> Alerts</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user-circle"></i> <?php echo htmlspecialchars($_SESSION['client_name']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDrop">
                        <li><a class="dropdown-item" href="profile.php"><i class="bx bx-user"></i> My Profile</a></li>
                        <li><a class="dropdown-item" href="change_password.php"><i class="bx bx-lock"></i> Change Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.php?logout=1"><i class="bx bx-log-out"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container-fluid py-4 px-4">
