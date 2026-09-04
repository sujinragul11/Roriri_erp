
<?php
session_start();


if (isset($_REQUEST['logout'])) {
    session_destroy();
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
   <?php include "head.php"; ?>


    <body class="fixed-left">

        <div class="wrapper-page">
             
        </div>
        <div class="wrapper-page">

            <div class="card">
                <div class="card-body">

                    <div class="text-center m-b-15">
                        <a href="index.html" class="logo logo-admin">    <img src="assets/images/logo.png" height="60" width="auto" alt="logo">
                        </a>
                    </div>

                    <div class="p-3">
                       <form class="form-horizontal m-t-20 needs-validation" action="action/actLogin.php" method="post" novalidate>

    <!-- Username Input -->
    <div class="form-group row">
        <div class="col-12">
            <input class="form-control" type="text" name="username" placeholder="Username" required>
            <div class="invalid-feedback">
                Please enter your username.
            </div>
        </div>
    </div>

    <!-- Password Input -->
    <div class="form-group row">
        <div class="col-12">
            <input class="form-control" type="password" name="password" placeholder="Password" required>
            <div class="invalid-feedback">
                Please enter your password.
            </div>
        </div>
    </div>


    <!-- Submit Button -->
    <div class="form-group text-center row m-t-20">
        <div class="col-12">
            <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Log In</button>
        </div>
    </div>

</form>
                    </div>

                </div>
            </div>
        </div>


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    <script src="../assets/js/form-validation.js"></script>
</body>
</html>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>