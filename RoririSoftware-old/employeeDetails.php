<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");
include("action/function.php");



if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['username']) && !empty($_GET['username'])) {

    
    // Use GET parameters if both id and username are provided
    $empId = $_GET['id'];
    $username1 = $_GET['username'];
    
} elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] !== 'True') {
    // If the user is not an admin, use session values for empId and username
    $empId = $_SESSION['id'];
    $username1 = $_SESSION['username'];
} else {
    // If neither GET nor SESSION values are available, redirect
    header("Location: employee.php");
    exit();
}



// Prepare and execute the SQL query
$selQuery = "SELECT additional_details.*, basic_details.*,emp_additional_details.*,roles.*
FROM basic_details
LEFT JOIN additional_details ON additional_details.basic_id=basic_details.id
LEFT JOIN emp_additional_details ON emp_additional_details.basic_id=basic_details.id 
LEFT JOIN roles ON roles.role_id=additional_details.role
WHERE basic_details.id='$empId'";

$result1 = $conn->query($selQuery);

if ($result1) {
    // Fetch employee details
    $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    $id = $row['id'];
    $employee_id = $row['reg_no'];
    $gender = $row['gender'];
    $blood_group = $row['blood_group'];
    $marrital_status = $row['marrital_status'];
    $dob = date('d-M-Y', strtotime($row['dob']));
    $e_id = $row['entity_id'];
    $name = $row['name'];
   
    $address = $row['address'];
    $personal_email = $row['email'];
    $company_email = $row['company_email'];
    
    $mobile = $row['phone'];
    $role = $row['role_name'];
    $joining_date = date('d-M-Y', strtotime($row['joining_date']));
    $pay_role = $row['payroll'];
    $emp_img = $row['image'];
    $usname=$row['username'];
    $password=$row['password'];
    $emp_qr=$row['qr'];
    $bank=$row['bank'];
    $pan=$row['pan'];
    $aadhar=$row['aadhar'];
    
    // Construct the image path QR
    $qr_path=$qrView.$emp_qr;
  // Construct the image path Employee
  $image_path = $imageView . $emp_img;
  $aadhar_path=$aadharView.$aadhar;
  $bank_path=$bankView.$bank;
  $pan_path=$panView.$pan;

} else {
    echo "Error executing query: " . $conn->error;
}
 ?>
<!doctype html>
<html lang="en">

<?php include("head.php");

 ?>

<body>
<style>
        .error-message {
            color: red;
            display: none;
        }
        .error {
            border-color: red;
        }
    </style>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php require_once("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php require_once("top.php");?>
      <?php include("addDocuments.php"); ?>
      <?php include("addEmployee.php"); ?>
      <?php include("editEmployee.php"); ?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				
				
<div class="container">
  <div class="main-body"> 
	<div class="modal-footer p-2">
  <?php  if ($_SESSION['is_admin'] == 'True'): ?>
        <!-- If role is 1 (admin), show the Back button -->
        <button type="button" class="btn btn-danger me-auto" onclick="javascript:location.href='employee.php'"><i class='bx bx-arrow-back'></i></button>
    <?php else:  ?>
        <!-- If role is not 1 (not admin), show the Edit button -->
        <button type="button" onclick="goEditProfile(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#editEmployeeModal" class="btn btn-primary" id="editButton">Edit Password</button>
    <?php endif; ?>
	</div>
    <div class="row">
      <div class="col-lg-4">
        
        <div class="card h-100" style="height: 450px;"> 
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center"> <?php 
            function url($url) {
              $headers = @get_headers($url);
              return stripos($headers[0], "200 OK") ? true : false;
            }// Check if the image exists
                                                                                  if (url($image_path)) {
                                                                                    $display_image = $image_path; // Use the actual image if it exists
                                                                                  } else {
                                                                                    $display_image = $default_image; // Use the default image if the actual image doesn't exist
                                                                                  } ?>
              <img src="<?php echo $display_image; ?>" alt="<?php echo $name;?>" class="rounded-circle p-1  img-fluid" style="width: 120px; height: 120px; object-fit: cover; object-position: top; max-width: 120px; max-height: 120px;">
              <div class="mt-3">
                <h4><?php echo $name;?></h4>
                <p class="text-secondary mb-1"><?php echo $employee_id;?></p>
                <p class="text-secondary mb-1"><?php echo $gender;?></p>
                <p class="text-secondary mb-1"><?php echo $role;?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
    <div class="card h-100" style="height: 450px;">
      <div class="card-body">
        <div class="row h-100">
          <!-- Left half of col-lg-8 for employee details -->
          <div class="col-md-8">
            
            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Company Email</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo $company_email;?></p>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Personal Email</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo $personal_email;?></p>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Blood Group</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo $blood_group;?></p>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Marrital Status</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo $marrital_status;?></p>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Mobile</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo $mobile;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Address</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo $address;?></p>
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Date Of Birth</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo formatDate($dob);?></p>
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Joining Date</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo formatDate($joining_date);?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">User ID</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1"><?php echo $usname;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <h6 class="mb-0">Password</h6>
              </div>
              <div class="col-sm-8 text-secondary">
                <p class="text-secondary mb-1" id="passwordField"><?php echo $password;?></p>
              </div>
            </div>
          </div>

          <!-- Right half of col-lg-8 for QR code image -->
          <div class="col-md-4 d-flex align-items-center justify-content-center">
            <img src="<?php echo $qr_path; ?>" alt="Employee QR Code" class="img-fluid" style="width: 200px; height: 200px; object-fit: cover;">
          </div>
        </div>
      </div>
    </div>
  </div>
    </div>
	<div class="container mt-5">
    <h2></h2>

    <!-- Tabs navs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Projects</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">PayRoll </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Documents</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="contact" aria-selected="false">Attendance</button>
        </li>
        <?php if ($_SESSION['is_admin'] == 'True'): ?>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                    role="tab" aria-controls="login" aria-selected="false">Login Histroy</button>
                </li>
        <?php endif; ?>
    </ul>
    <!-- Tabs navs -->

    <!-- Tabs content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
           <div class="mt-3">
			        <div class="table-responsive">
              <table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										                    <th>Project Name</th>
                                        <th>Services</th>
                                        <th>Technology</th>
                                        <th>Status</th>
                                        <th>Start Date</th>

									</tr>
								</thead>
								<tbody>
                                <?php $selectPro="SELECT 
                                                  basic_details.*, 
                                                  additional_details.*, 
                                                  project_tbl.*
                                              FROM 
                                                  basic_details
                                              LEFT JOIN 
                                                  additional_details ON additional_details.basic_id = basic_details.id
                                              LEFT JOIN 
                                                  project_tbl ON JSON_CONTAINS(project_tbl.developers, JSON_QUOTE(CAST(basic_details.id AS CHAR)), '$')
                                              WHERE 
                                                  basic_details.status = 'Active' 
                                                  AND JSON_CONTAINS(project_tbl.developers, JSON_QUOTE('$empId'), '$')
                                                  GROUP BY project_tbl.project_id
                                                  ORDER BY project_tbl.start_date DESC
                                              ";
									$resQuery = mysqli_query($conn , $selectPro); 
								$i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                            $emp_id   = $row['id'];  
                            $employee_id=$row['reg_no'];   
                            $name  = $row['name'];  
                           
                            $programming          = $row['technology'];
                            $developers        = $row['developers'];   
                            $project_name        = $row['project_name'];   
                            $pro_status=$row['project_status'];
                            $start_date=$row['start_date'];
                            $services=$row['services'];
                           

                            
                          // Get the technology names using the function
                          $pro = getTechnologyNames($conn, $programming);
                          $service=getServiceName($conn,$services);
                      ?>
                      <tr>
                       <!-- Table row is place in this place -->
                       <td><?php echo $i; $i++; ?></td>
                       <td><?php echo $project_name; ?></td>
                       <td><?php echo $service; ?></td>
                       <td><?php echo $pro; ?></td>
                       <td><?php echo $pro_status; ?></td>
                       <td><?php echo formatDate($start_date); ?></td>
                      
                    </tr>
                    <?php } ?>   
						</tbody>
								
					</table>
			        </div>
		       </div>
        </div>
        <div class="tab-pane fade position-relative p-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="d-flex justify-content-end mb-3">
            <?php  if ($_SESSION['is_admin'] == 'True'): ?>
              <button type="button" id="addSalaryBtn" class="btn btn-primary position-absolute top-0 end-0" onclick="goSalary(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#addSalaryModal">Add Salary</button>
              <?php endif; ?> 
              
            </div>
            <div class="mt-3">
              <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										                    <th>Salary</th>
                                        <th>Date</th>
                                        <th>Absent</th>

										
									</tr>
								</thead>
								<tbody>
                             <?php $selectPro="SELECT * FROM `salary_tbl` WHERE basic_id='$empId'
                                              ";
									$resQuery = mysqli_query($conn , $selectPro); 
								$i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                            $salaryId   = $row['salary_id'];  
                            $basic_id=$row['basic_id'];   
                            $salary  = $row['salary'];  
                            $date    = $row['month'];
                            $days=$row['days'];
                            

                      
                      ?>
                      <tr>
                       <!-- Table row is place in this place -->
                       <td><?php echo $i; $i++; ?></td>
                       <td><?php echo number_format($salary,2); ?></td>
                       <td><?php echo formatDate($date); ?></td>
                       <td><?php echo $days; ?></td>
                      
                    </tr>
                    <?php } ?>   
						</tbody>
								
					</table>
              </div>
            </div>
        </div>

        <div class="tab-pane fade position-relative p-3" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="d-flex justify-content-end mb-5">
          <?php  if ($_SESSION['is_admin'] == 'True'): ?>
            <button type="button" id="addDocumentBtn" class="btn btn-primary position-absolute top-0 end-0" onclick="goDocuments(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#addDocumentModal">Add Documents</button>
            <?php endif; ?>
          </div>
          
          <div class="container">
              <div class="row">
                  <div class="col-md-4 mb-3">
                      <div class="card">
                          <img src="<?php echo $aadhar_path; ?>" class="card-img-top" id="aadharImage" alt="Image Description">
                      </div>
                  </div>
                  <div class="col-md-4 mb-3">
                      <div class="card">
                          <img src="<?php echo $bank_path; ?>" class="card-img-top" id="bankImage" alt="Image Description">
                      </div>
                  </div>
                  <div class="col-md-4 mb-3">
                      <div class="card">
                          <img src="<?php echo $pan_path; ?>" class="card-img-top" id="panImage" alt="Image Description">
                      </div>
                  </div>
              </div>
            </div>
        </div>

        <!-- -----attendanse report start -->
        <div class="tab-pane fade show " id="attendance" role="tabpanel" aria-labelledby="home-tab">
           <div class="mt-3">
			        <div class="table-responsive">
              <table id="example3" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
                                        <th>Name</th>
										<th>Date</th>
                                        <th>Punch In</th>
                                        <th>Punch Out</th>
                                        <th>Role</th>
                                    

									</tr>
								</thead>
								<tbody>
                                   
						</tbody>
								
					</table>
			        </div>
		       </div>
        </div>
        <!-- -----attendanse report end -->
        <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
                   <div class="table-responsive">
                        <table id="example5" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Browser Name</th>
                                    <th>Device Type</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $selectPay = "SELECT 
                                                    `system_info`
                                                FROM `login_history`
                                                WHERE `status` = 'Active' AND `basic_id` = '$empId'";
                                    
                                    $resQuery = mysqli_query($conn , $selectPay); 
                                    $i = 1; 
                    
                                    while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                                        // Decode the JSON data from the system_info field
                                        $systemInfoJson = $row['system_info'];
                                        $systemInfoArray = json_decode($systemInfoJson, true);
                    
                                        // Handle JSON decoding error
                                        if (json_last_error() !== JSON_ERROR_NONE) {
                                            echo "Error decoding JSON: " . json_last_error_msg();
                                            continue;
                                        }
                    
                                        // Check if system_info is an array and process each entry
                                        if (is_array($systemInfoArray)) {
                                            foreach ($systemInfoArray as $entry) {
                                                // Extract and format the data
                                                $loginTime = isset($entry['login_time']) ? strtotime($entry['login_time']) : null;
                                                $date = $loginTime ? date('d-M-Y', $loginTime) : 'N/A';
                                                $time = $loginTime ? date('h:i:s A', $loginTime) : 'N/A';
                                                
                                                $systemInfo = isset($entry['system_info']) ? json_decode($entry['system_info'], true) : [];
                                                $browserName = isset($systemInfo['userAgent']) ? $systemInfo['userAgent'] : 'N/A';
                                                $deviceType = isset($systemInfo['deviceType']) ? $systemInfo['deviceType'] : 'N/A';
                                                $location = ($entry['location'] != '') ? $entry['location'] : 'N/A';
                    
                                                // Display the data in a new row
                                                echo "<tr>";
                                                echo "<td>{$i}</td>";
                                                echo "<td>{$date}</td>";
                                                echo "<td>{$time}</td>";
                                                echo "<td>{$browserName}</td>";
                                                echo "<td>{$deviceType}</td>";
                                                echo "<td>{$location}</td>";
                                                echo "</tr>";
                    
                                                $i++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No valid data found</td></tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                  </div>
    </div>
    <!-- Tabs content -->

</div>
  </div>
</div><!--end page-wrapper-->
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->

	<!--start switcher-->

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
    <script src="<?php echo $sweetalert; ?>"></script>
    <!-- Include the function.js -->
    <script src="../assets/js/function.js"></script>
   

    
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
			$('#example5').DataTable();
		  } );
	</script>
  <script>
    		$(document).ready(function() {
    var table = $('#example3').DataTable({
        lengthChange: false,
        buttons: [
          <?php
          if ($_SESSION['is_admin'] == 'True'): ?>
            ,'copy' , 'excel', 'pdf', 'print'
            <?php endif ?>
        ]
    });

    table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
});
  </script>


	<script>
		$(document).ready(function() {
    var table = $('#example2').DataTable({
        lengthChange: false,
        buttons: [
          <?php
          if ($_SESSION['is_admin'] == 'True'): ?>
            ,'copy' , 'excel', 'pdf', 'print'
            <?php endif ?>
        ]
    });

    table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
});

    function goEditProfile(id) 
  
  {
    $.ajax({
        url: 'action/actEmployee.php',
        method: 'POST',
        data: {
            empId: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
        
        $('#editUname').val(response.username);
        $('#editPassword').val(response.password);
        $('#profileId').val(response.emp_id);

		  // Display the image if the URL is provided
          if (response.img) {
            console.log('Image URL:', response.img); // Debugging line
                $('#editImage').attr('src', response.img).show();
            } else {
                $('#editImage').hide();
            }
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
function goSalary(id) 
  
  {
    $.ajax({
        url: 'action/actEmployee.php',
        method: 'POST',
        data: {
          salaryId: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
        
        
        $('#salaryId').val(response.salaryid);
        
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
function goDocuments(id) 
  
  {
    $.ajax({
        url: 'action/actDocuments.php',
        method: 'POST',
        data: {
          doc: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
        
       
        $('#id').val(response.empId);
        // $('#bank').val(response.bank);
        // $('#pan').val(response.pan);
        // $('#aadhar').val(response.aadhar);


        console.log('Aadhar Path:', response.aadhar_path);
        console.log('Bank Path:', response.bank_path);
        console.log('PAN Path:', response.pan_path);
        // Show preview images if paths are available
        // Show preview images if paths are available
        if (response.bank_path) {
                $('#bankPreview').attr('src', response.bank_path).show();
            } else {
                $('#bankPreview').hide();
            }

            if (response.pan_path) {
                $('#panPreview').attr('src', response.pan_path).show();
            } else {
                $('#panPreview').hide();
            }

            if (response.aadhar_path) {
                $('#aadharPreview').attr('src', response.aadhar_path).show();
            } else {
                $('#aadharPreview').hide();
            }
        
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
//--------------Handles edit employee password-----------------------------//

document.addEventListener('DOMContentLoaded', function() {
    $('#editEmployee').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this);
        $.ajax({
            url: "action/actEmployee.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#editEmployeeModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop   
                        // Update the specific field with the new value from response
                        if (response.newPassword) { // Assuming response.newPassword contains the updated password
                            $('#passwordField').text(response.newPassword);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating password data.'
                });
                $('#updateBtn').prop('disabled', false);
            }
        });
    });
});
</script>
<script>
//--------------Handles edit employee Document-----------------------------//

$(document).ready(function () {


// Handle the form submission
$('#submitBtnDoc').click(function (e) {
    e.preventDefault(); // Prevent default form submission

    var isValid = true;

    // Validate fields
    isValid &= validateField('aadhar', 'aadharError');
    isValid &= validateField('bank', 'bankError');
    isValid &= validateField('pan', 'panError');
    

    if (isValid) {
        $('#addDocument').trigger('submit'); // Manually trigger the form submit event if validation passes
    }
});

// Handle the form submission via AJAX
$('#addDocument').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var formData = new FormData(this);
    $.ajax({
        url: "action/actDocuments.php",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json', // Expect JSON response
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 2000
                }).then(function () {
                    $('#addDocumentModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
                    // Update images in the tab content
                        if (response.data) {
                                if (response.data.aadhar_path) {
                                    updateImage('#aadharImage', response.data.aadhar_path);
                                }
                                if (response.data.bank_path) {
                                    updateImage('#bankImage', response.data.bank_path);
                                }
                                if (response.data.pan_path) {
                                    updateImage('#panImage', response.data.pan_path);
                                }
                            }
                });

                // Reset the form after successful submission
                resetForm('addDocument');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding Client data.'
            });
        }
    });
});

// Reset the form when the close button is clicked
$('#docCloseBtn').click(function () {
    resetForm('addDocument');
});
});

// Function to reset the form and hide error messages
function updateImage(selector, imagePath) {
    // Update the image source with the new path
    $(selector).attr('src', imagePath);
}
</script>


<script>
 $(document).ready(function () {
    console.log('Document is ready');
    function validateField(fieldId, errorId) {
    var fieldValue = $('#' + fieldId).val().trim();
    if (!fieldValue) {
        $('#' + errorId).show();
        return false;
    } else {
        $('#' + errorId).hide();
        return true;
    }
}

function validateDate() {
    var dateInput = $('#date').val();
    var currentDate = new Date().toISOString().split('T')[0]; // Get current date in 'YYYY-MM-DD' format
    
    if (!dateInput || dateInput > currentDate) {
        $('#salDateError').show();
        return false;
    } else {
        $('#salDateError').hide();
        return true;
    }
}

function validateDays(fieldId, errorId) {
    var daysValue = $('#' + fieldId).val().trim();
    if (!daysValue || isNaN(daysValue) || daysValue < 0 || daysValue > 30) {
        $('#' + errorId).show();
        return false;
    } else {
        $('#' + errorId).hide();
        return true;
    }
}

    $('#submitBtnSalary').click(function (e) {
    e.preventDefault();
    console.log('Submit button clicked');
    
    var isValid = true;
    
    isValid = validateField('salary', 'salaryError') && isValid;
    isValid = validateDate() && isValid;
    isValid = validateDays('days', 'salDaysError') && isValid;
    
    console.log('Form validation status:', isValid);
    
    if (isValid) {
        console.log('Form is valid, triggering submit.');
        $('#addSalary').trigger('submit');
    }
});  
    $('#addSalary').off('submit').on('submit', function (e) {
        e.preventDefault();
        console.log('Form is being submitted via AJAX');
        
        var formData = new FormData(this);
        $.ajax({
            url: "action/actEmployee.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                console.log('AJAX success response:', response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function () {
                        $('#addSalaryModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#example').load(location.href + ' #example>*', function() {
                            if ($.fn.DataTable.isDataTable('#example')) {
                                $('#example').DataTable().destroy();
                            }
                            var table = $('#example').DataTable({
                                "paging": true,
                                "ordering": true,
                                "searching": true,
                            });
                        });
                        resetForm('addSalary');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error response:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding Salary data.'
                });
            }
        });
    });
    
    $('#modalCloseBtn').click(function () {
        resetForm('addSalary');
    });
});

function resetForm(formId) {
    document.getElementById(formId).reset();
    $('.error-message').hide();
}


    // Function to reset the form and hide error messages
    function resetForm(formId) {
        document.getElementById(formId).reset(); // Reset the form
        $('.error-message').hide(); // Hide all error messages
    }
</script>

	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
  <?php
  function getTechnologyNames($conn, $programming) {
    // Decode the JSON array
    $technologyIds = json_decode($programming, true);

    // Check if it's a valid array
    if (!is_array($technologyIds)) {
        return ''; // Return an empty string if not valid
    }

    // Convert array to a comma-separated string of IDs
    $ids = implode(',', array_map('intval', $technologyIds));

    // Fetch technology names from the technology table
    $query = "SELECT tech_name FROM technology WHERE tech_id IN ($ids)";
    $result = mysqli_query($conn, $query);

    $technologyNames = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $technologyNames[] = $row['tech_name'];
    }

    // Return names joined by commas
    return implode(', ', $technologyNames);
}

function getServiceName($conn, $services) {
  // Decode the JSON array
  $sericeIds = json_decode($services, true);

  // Check if it's a valid array
  if (!is_array($sericeIds)) {
      return ''; // Return an empty string if not valid
  }

  // Convert array to a comma-separated string of IDs
  $serviceIds = implode(',', array_map('intval', $sericeIds));

  // Fetch technology names from the technology table
  $queryService = "SELECT service_name FROM `services` WHERE service_id in($serviceIds)";
  $resultService = mysqli_query($conn, $queryService);

  $servicesNames = [];
  while ($row = mysqli_fetch_assoc($resultService)) {
      $servicesNames[] = $row['service_name'];
  }

  // Return names joined by commas
  return implode(', ', $servicesNames);
}
?>
</body>

<script>

    document.addEventListener("DOMContentLoaded", function() {

        // Output PHP variable to JavaScript
    const username1 = "<?php echo $username1; ?>";
    // Check the username value
    console.log("Username:", username1);
    
        // Load data initially
        loadAttendanceData(username1);

    });

    let table;

    function loadAttendanceData(username) {
        

        fetch(`https://roririmobileapp.roririsoft.com/cms/punch/list/${username}/`)
            .then(response => response.json())
            .then(data => {
                

                if ($.fn.DataTable.isDataTable('#example3')) {
                    $('#example3').DataTable().destroy();
                }
          
                const tableBody = document.querySelector("#example3 tbody");
                tableBody.innerHTML = '';

                if (data.data.results && data.data.results.length > 0) {
                    let i = 1;
                    data.data.results.forEach(record => {
                        const row = `<tr>
                            <td>${i++}</td>
                            <td>${record.user_detail.full_name}</td>
                            <td>${record.punch_date}</td>
                            <td>${record.punch_in}</td>
                            <td>${record.punch_out ? record.punch_out : 'N/A'}</td>
                            <td>${record.user_detail.role}</td>
                        </tr>`;
                        tableBody.innerHTML += row;
                    });

                    // Initialize DataTable with buttons
                    table = $('#example3').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'print']
                    });
                    $('#example3').DataTable().buttons().container()
                        .appendTo('#example3_wrapper .col-md-6:eq(0)');

                } else {
                    tableBody.innerHTML = `<tr><td colspan="6">No data found for the selected date.</td></tr>`;
                }
            })
            .catch(error => {
                document.getElementById("loading").style.display = 'none';
                console.error('Error fetching attendance records:', error);
                document.querySelector("#example3 tbody").innerHTML = `<tr><td colspan="6">Error loading data.</td></tr>`;
            });
    }

    
</script>

</html>