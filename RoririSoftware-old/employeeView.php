<?php
session_start();

include("../url.php");
include($db);
$username=$_SESSION['username'] ;
$position=$_SESSION['position_name'] ;
$user_id=$_SESSION['user_id'] ;  // Store user ID in session

$selQuery = "SELECT employee_tbl.*,
emp_additional_tbl.*,
position_tbl.*,
admin_tbl.*
FROM employee_tbl
LEFT JOIN emp_additional_tbl ON emp_additional_tbl.emp_id = employee_tbl.emp_id 
LEFT JOIN position_tbl ON position_tbl.position_id = employee_tbl.emp_role 
LEFT JOIN admin_tbl ON admin_tbl.id=employee_tbl.emp_user_id
WHERE employee_tbl.emp_status='Active' AND employee_tbl.emp_id='$user_id'";

        
        $result1 = $conn->query($selQuery);
    
        if($result1) {
            // Fetch employee details
            $row = mysqli_fetch_array($result1 , MYSQLI_ASSOC);
            $id = $row['emp_id']; 
			$employee_id=$row['employee_id'];
            $e_id = $row['entity_id'];
            $fname = $row['emp_first_name'];
            $lname=$row['emp_last_name'];
            $location=$row['emp_address'];
            $personal_email=$row['emp_personal_email'];
            $company_email=$row['emp_company_email'];
            $address=$row['emp_address'];
            $mobile=$row['emp_mobile'];
            $role=$row['position_name'];
            $joining_date=$row['emp_joining_date'];
            $pay_role=$row['emp_pay_role'];
			$emp_img = $row['emp_img'];
            $user=$row['user_name'];
            $pass=$row['pass'];
            $name=$fname." ".$lname; 
			// Construct the image path
			//$image_path = $imageView . $emp_img;  

			$imagePathPng = $imageView . $emp_img . ".png";
			$imagePathJpg = $imageView . $emp_img . ".jpg";
				
					if (file_exists($imagePathPng)) {
						$userImage = $imageView . $emp_img . ".png";
					} elseif (file_exists($imagePathJpg)) {
						$userImage = $imageView . $emp_img . ".jpg";
					} else {
						$userImage = $default_image;
					}
    
        } else {
            echo "Error executing query: " . $conn->error;
        }
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php include("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<!-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Tables</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div> -->
				<!--end breadcrumb-->
				
<div class="container">
  <div class="main-body">
    
    <div class="row">
      <div class="col-lg-4">
        <div class="card h-100" style="height: 450px;">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="<?php echo $userImage;?>" alt="<?php echo $name;?>" class="rounded-circle p-1 bg-primary img-fluid" style="width: 120px; height: 120px; object-fit: cover; object-position: top; max-width: 120px; max-height: 120px;">
              <div class="mt-3">
                <h4><?php echo $name;?></h4>
                <p class="text-secondary mb-1"><?php echo $employee_id;?></p>
                <p class="text-secondary mb-1"><?php echo $role;?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card h-100" style="height: 450px; ">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-2">
                <h6 class="mb-0">Full Name</h6>
              </div>
              <div class="col-sm-2 text-secondary">
                <p class="text-secondary mb-1"><?php echo $name;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <h6 class="mb-0">Email</h6>
              </div>
              <div class="col-sm-4 text-secondary">
                <p class="text-secondary mb-1"><?php echo $company_email;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <h6 class="mb-0">Personal Email</h6>
              </div>
              <div class="col-sm-4 text-secondary">
                <p class="text-secondary mb-1"><?php echo $personal_email;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <h6 class="mb-0">Mobile</h6>
              </div>
              <div class="col-sm-3 text-secondary">
                <p class="text-secondary mb-1"><?php echo $mobile;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <h6 class="mb-0">Address</h6>
              </div>
              <div class="col-sm-3 text-secondary">
                <p class="text-secondary mb-1"><?php echo $address;?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!--end page-wrapper-->
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->


	<!-- search modal -->
    <!-- <div class="modal" id="SearchModal" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
		  <div class="modal-content">
			<div class="modal-header gap-2">
			  <div class="position-relative popup-search w-100">
				<input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search" placeholder="Search">
				<span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i class='bx bx-search'></i></span>
			  </div>
			  <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="search-list">
				   <p class="mb-1">Html Templates</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action active align-items-center d-flex gap-2 py-1"><i class='bx bxl-angular fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vuejs fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-magento fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-shopify fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Web Designe Company</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-windows fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-dropbox fs-4' ></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-opera fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-wordpress fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Software Development</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-mailchimp fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-zoom fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-sass fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vk fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Online Shoping Portals</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-slack fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-skype fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-twitter fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vimeo fs-4'></i>eCommerce Html Templates</a>
				   </div>
				</div>
			</div>
		  </div>
		</div>
	  </div> -->
    <!-- end search modal -->




	<!--start switcher-->
	<?php include("theme.php");?>
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<!-- Bootstrap JS -->
	<script src="<?php echo $bootsrapBundle; ?>"></script>
	<!--plugins-->
	<script src="<?php echo $js; ?>"></script>
	<script src="<?php echo $simplebar;?>"></script>
	<script src="<?php echo $mentimenu; ?>"></script>
	<script src="<?php echo $perfectScrolbar;  ?>"></script>
	<script src="<?php echo $datatableMin; ?>"></script>
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
     <!-- Include Bootstrap JS (with Popper) -->
    <script src="<?php echo $popper;?>"></script>
    <script src="<?php echo $bootStackPath;?>"></script>
    <script>
        function goViewEmp(id){
            alert(id);
            location.href = "employeeDetails.php?id="+id;

        }
    </script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
</body>

</html>