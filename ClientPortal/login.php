<?php
session_start();
include("../db/dbConnection.php");

if (isset($_REQUEST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM client_tbl WHERE client_username=? AND client_password=? AND client_status='Active'");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $_SESSION['client_id'] = $row['client_id'];
        $_SESSION['client_name'] = $row['client_name'];
        $_SESSION['client_company'] = $row['client_company'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Portal - RORIRI</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="../assets/css/icons.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <div class="section-authentication-cover">
        <div class="row g-0">
            <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">
                <div class="card shadow-none bg-transparent rounded-0 mb-0">
                    <div class="card-body text-center">
                        <img src="../assets/images/login-images/login-cover.svg" class="img-fluid auth-img-cover-login" width="520" alt=""/>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                    <div class="card-body p-sm-5">
                        <div class="mb-3 text-center">
                            <h4>Client Portal</h4>
                            <p class="text-secondary mb-0">RORIRI Software Solutions</p>
                        </div>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="login.php" class="row g-3 needs-validation" novalidate>
                            <div class="col-12">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Client Username" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <a href="../login.php" class="small">Employee / Admin Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
