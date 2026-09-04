<?php
session_start();
include("../db/dbConnection.php");
?>
<!DOCTYPE html>
<html lang="en">
   <?php include "head.php"; ?>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <?php include "left.php" ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <?php include "right.php" ?>
                    <!-- Top Bar End -->

<div class="page-content-wrapper ">

<section class="portfolio_section layout_padding">
  <div class="container">

    <!-- Image Upload Input at the Top -->
    <div class="row mb-4 mt-3">
  <div class="col-md-12 text-center">
    <label for="file-input" class="btn btn-primary btn-lg">
      Upload an Image
      <input type="file" id="file-input" class="d-none" accept="image/*" onchange="uploadImage()">
    </label>
  </div>
</div>

    <div class="heading_container">
      <h2>Our portfolio</h2>
      <p>minim veniam, quis nostrud exercitation ullamco laboris nisi</p>
    </div>

  <div class="container py-4">
  <div class="row g-3">
    <!-- Gallery Item 1 -->
    
    <?php 
    
    $id = $_SESSION['id'];
    $folder = $_SESSION['username'];
    
    $select_qry = "SELECT a.name FROM `iv_gallery_tbl` as a LEFT JOIN iv_client_tbl as b on a.visit_id = b.id WHERE b.id = $id AND a.status ='Active';";
    $resQuery = mysqli_query($conn , $select_qry);
    
     if (mysqli_num_rows($resQuery) > 0) {
                                 
                             while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                 
                 $name        = $row['name']; 
    
    ?>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card">
        <a href="https://asset.inforiya.in/ERP/ERP_image/IV/<?php echo $folder ; ?>/<?php echo $name ; ?>" target="_blank">
          <img src="https://asset.inforiya.in/ERP/ERP_image/IV/<?php echo $folder ; ?>/<?php echo $name ; ?>" class="card-img-top" alt="Image 1">
        </a>
      </div>
    </div>
    
    <?php
      }
         
     }
    ?>

    <!-- Gallery Item 2 -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card">
        <a href="images/p-2.jpg" target="_blank">
          <img src="images/p-2.jpg" class="card-img-top" alt="Image 2">
        </a>
      </div>
    </div>

    <!-- Gallery Item 3 -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card">
        <a href="images/p-3.jpg" target="_blank">
          <img src="images/p-3.jpg" class="card-img-top" alt="Image 3">
        </a>
      </div>
    </div>

    <!-- Gallery Item 4 -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card">
        <a href="images/p-4.jpg" target="_blank">
          <img src="images/p-4.jpg" class="card-img-top" alt="Image 4">
        </a>
      </div>
    </div>

    <!-- Gallery Item 5 -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card">
        <a href="images/p-5.jpg" target="_blank">
          <img src="images/p-5.jpg" class="card-img-top" alt="Image 5">
        </a>
      </div>
    </div>

    <!-- Gallery Item 6 -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card">
        <a href="images/p-6.jpg" target="_blank">
          <img src="images/p-6.jpg" class="card-img-top" alt="Image 6">
        </a>
      </div>
    </div>
  </div>

  <!-- See More Button -->
  <div class="text-center mt-4">
    <a href="#" class="btn btn-secondary">See More</a>
  </div>
</div>
  </div>
</section>
            <!-- Course Tab End -->
             
        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    Â© 2023 IV by RoririSoft.
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


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

        <script src="assets/plugins/chart.js/chart.min.js"></script>
        <script src="assets/pages/dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        

    <script src="../assets/js/form-validation.js"></script>
</body>
</html>

<script>
    function uploadImage() {
  const fileInput = document.getElementById('file-input');
  
  // Check if a file was selected
  if (fileInput.files.length > 0) {
    const formData = new FormData();
    formData.append('file', fileInput.files[0]);  // Append the selected file

    // AJAX request to upload the image
    $.ajax({
      url: 'action/actImage.php',  // Your PHP script to handle the image upload
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        // Handle success - maybe show a success message or update UI
        alert('Image uploaded successfully');
        console.log(response);  // Optional: check server response in the console
      },
      error: function(error) {
        // Handle error - display error message
        alert('Error uploading image');
        console.error(error);
      }
    });
  } else {
    alert('Please select an image to upload');
  }
}
</script>