<?php
session_start();
include("../db/dbConnection.php");
include("../url.php");
include("action/function.php");

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 'True') {
  // If the user is not an admin, set the empId to the user's ID
  if ( $_SESSION['role'] == '10') {
    $empId = $_SESSION['id'];
    $username1 = $_SESSION['username'];
  } elseif (isset($_GET['id']) && $_GET['id'] != '') {
    $empId = $_GET['id'];
  }
  
  // $empId = $_GET['TraineeId'];
} elseif (isset($_GET['id']) && $_GET['id'] != '') {
  $empId = $_GET['id'];
  $username1 = $_GET['username'];
} else {
  // If no employee ID is provided, redirect to employees.php
  header("Location: trainee.php");
  exit(); // Ensure the script stops executing after redirection
}

// total amount get ------------
$amount_sql="SELECT SUM(a.received_amnt) AS received_amount FROM `payment` AS a LEFT JOIN basic_details AS b ON a.basic_id = b.id WHERE b.id=$empId;";
$amount_sql_res = $conn->query($amount_sql);
$row_pay = mysqli_fetch_array($amount_sql_res, MYSQLI_ASSOC);

// Prepare and execute the SQL query
$selQuery = "SELECT additional_details.*, basic_details.*,roles.*,a.course_name,b.*
FROM basic_details
LEFT JOIN additional_details ON additional_details.basic_id=basic_details.id 
LEFT JOIN roles ON roles.role_id=additional_details.role 
LEFT JOIN trainee_additional_details AS b ON b.basic_id=basic_details.id
LEFT JOIN academy_course_details AS a ON a.id =b.course_id
WHERE basic_details.id='$empId'";

$result1 = $conn->query($selQuery);

if ($result1) {
    // Fetch trainee details
    $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    
   
    
    $id = $row['id'];
    $trainee_id = $row['reg_no'];
    $gender = $row['gender'];
    $blood_group = $row['blood_group'];
    $dob = date('d-M-Y', strtotime($row['dob']));
    $course_fullname = $row['course_name'];
    $duration = $row['duration'];
    $course_fee = $row['course_fee'];
    $received_amount = $row_pay['received_amount'];
    $balance = $course_fee - $received_amount;
    // $course_fee = $row['course_fee'];
    $e_id = $row['entity_id'];
    $name = $row['name'];
    $address = $row['address'];
    $personal_email = $row['email'];
    $mobile = $row['phone'];
    $role = $row['role_name'];
    $cmail = $row['company_email'];
    $slot = $row['slot_timing'];
    $batch = $row['batch'];
    $joining_date = date('d-M-Y', strtotime($row['joining_date']));
    $trainee_img = $row['image'];
    $username1=$row['username'];
    $password=$row['password'];
    $trainee_qr=$row['qr'];
    $bank=$row['bank'];
    $pan=$row['pan'];
    $aadhar=$row['aadhar'];
    
    $inchargeName=Employee_name($conn ,$row['incharge_name']);
    
    // Construct the image path
    $image_path = !empty($trainee_img) ? $traineeImageView . $trainee_img : $default_image;
    $qr_path=$traineeQRView.$trainee_qr;
    $aadhar_path = !empty($aadhar) ? $aadharView . $aadhar : $default_image;
    $bank_path = !empty($bank) ? $bankView . $bank : $default_image;
    $pan_path = !empty($pan) ? $panView . $pan : $default_image;
    
   // Convert the formatted joining date to a DateTime object
    $joinDate = new DateTime($row['joining_date']); // Use raw date from the database for calculations
    
    // Calculate the end date of the course
    $endDate = clone $joinDate; // Clone to preserve original joining date
    $endDate->modify("+$duration months");
    
    // Get today's date
    $today = new DateTime();
    
    // Calculate the difference between today's date and the course end date
    $interval = $today->diff($endDate);
    
    // Determine if the course is completed or still ongoing
    if ($interval->invert == 1) {
        // If invert is 1, it means the end date is in the past
        $daysAgo = $interval->format('%a');
        $message = "Course completed $daysAgo days ago";
    } else {
        // If invert is 0, it means the end date is in the future
        $daysLeft = $interval->format('%a');
        $message = "$daysLeft days left";
    }
    
} else {
    echo "Error executing query: " . $conn->error;
}
?>
<!doctype html>
<html lang="en">

<?php include("head.php");
include("editTrainee.php"); 
include("addTrainee.php"); 
include("formEditPassword.php"); ?>

<body>
  <!--wrapper-->
  <div class="wrapper">
    <!--sidebar wrapper -->
    <?php
			 if ( $_SESSION['role'] == '10' ||$_SESSION['is_admin'] == 'True') {
				 include("left.php");
             } else{
                include("../RoririSoftware/left.php");
             }
					?>
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
            <div class="modal-footer p-2">
              <?php   if ($_SESSION['is_admin'] == 'True'): ?>
              <!-- If role is 1 (admin), show the Back button -->
              <button type="button" class="btn btn-danger me-auto" onclick="javascript:location.href='trainee.php'"><i
                  class='bx bx-arrow-back'></i></button>

                  <?php elseif ($_SESSION['role'] == '6'): ?>
    <!-- If user is staff, show the Back button -->
    <button type="button" class="btn btn-danger me-auto" onclick="javascript:location.href='trainee.php'">
        <i class='bx bx-arrow-back'></i>
    </button>
              <?php  else:  ?>
              <!-- If role is not 1 (not admin), show the Edit button -->
              <button type="button"  data-bs-toggle="modal"onclick="goEditPassword(<?php echo $id ?>)"
                data-bs-target="#editPasswordModule" class="btn btn-primary" id="editButton">Edit Password</button>
              <?php endif; ?>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <div class="card h-100" style="height: 450px;">
                  <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                      <img src="<?php echo $image_path;?>" alt="<?php echo $name;?>"
                        class="rounded-circle p-1 bg-primary img-fluid"
                        style="width: 120px; height: 120px; object-fit: cover; object-position: top; max-width: 120px; max-height: 120px;">
                      <div class="mt-3">
                        <h4>
                          <?php echo $name;?>
                        </h4>
                        <p class="text-secondary mb-1">
                          <?php echo $trainee_id;?>
                        </p>
                        <p class="text-secondary mb-1">
                          <?php echo $gender;?>
                        </p>
                        <p class="text-secondary mb-1">
                          <?php echo $blood_group;?>
                        </p>
                        <p class="text-secondary mb-1">
                          <?php echo $role;?>
                        </p>
                        <p class="text-secondary mb-1">
                        <?php echo $personal_email;?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="card h-100" style="height: 450px;">
                  <div class="card-body">
                    <div class="row h-100">
                      <!-- Left half of col-lg-8 for trainee details -->
                      <div class="col-md-8">

                       

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Company Email</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                            <?php echo ($cmail)?$cmail :"No Email";?>
                              
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Mobile</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $mobile;?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Address</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $address;?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">User ID</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $username1;?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Password</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1" id="passwordField">
                              <?php echo $password;?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Date Of Joining</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $joining_date . ' <span style="color: red;">(' . $message . ')</span>'; ?>
                            </p>
                          </div>
                        </div>

                        

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Date Of Birth</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $dob;?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Course Name</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $course_fullname;?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Course Duration</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $duration ." Months";?>
                            </p>
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Slot Timing</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $slot ;?>
                            </p>
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Batch</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $batch ;?>
                            </p>
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Incharge Name</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php echo $inchargeName ;?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Total Fees</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php
                              if ($_SESSION['id'] == 86) {
                                echo "-";  
                              } else {
                                echo "â‚¹ " . number_format($course_fee, 2);  
                              }
                              ?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Total Paid Amount</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-secondary mb-1">
                              <?php 
                              if ($_SESSION['id'] == 86) {
                                echo "-";  
                              } else {
                                echo "â‚¹ " . number_format($received_amount, 2);  
                              }
                              ?>
                            </p>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-sm-4">
                            <h6 class="mb-0">Balance Amount</h6>
                          </div>
                          <div class="col-sm-8 text-secondary">
                            <p class="text-danger mb-1">
                              <?php 
                              if ($_SESSION['id'] == 86) {
                                echo "-";  
                              } else {
                                echo "â‚¹ " . number_format($balance, 2);  
                              }
                              ?>
                            </p>
                          </div>
                        </div>
                      </div>

                      <!-- Right half of col-lg-8 for QR code image -->
                      <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <img src="<?php echo $qr_path; ?>" alt="Trainee QR Code" class="img-fluid"
                          style="width: 200px; height: 200px; object-fit: cover;">
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
                  <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Payment</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                    role="tab" aria-controls="contact" aria-selected="false">Document</button>
                </li>
                <!--<li class="nav-item" role="presentation">-->
                <!--    <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">Attendance</button>-->
                <!--</li>-->
                <?php if ($_SESSION['is_admin'] == 'True'): ?>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                    role="tab" aria-controls="login" aria-selected="false">Login Histroy</button>
                </li>
                <?php endif; ?>
                <!--<li class="nav-item" role="presentation">-->
                <!--  <button class="nav-link" id="application-tab" data-bs-toggle="tab" data-bs-target="#application" type="button"-->
                <!--    role="tab" aria-controls="application" aria-selected="false">Application</button>-->
                <!--</li>-->
              </ul>
              <!-- Tabs navs -->

              <!-- Tabs content -->
              <div class="tab-content" id="myTabContent">
               
                  <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="d-flex justify-content-end mb-3">
                      <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 'True'): ?>
                      <button type="button" id="addPayBtn" class="btn btn-primary" data-bs-toggle="modal"
                        onclick="goView(<?php echo $id; ?>);" data-bs-target="#PaymenttraineeModal">Add Payment</button>
                      <?php  endif; ?>
                    </div>

                    <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>S. No</th>
            <th>Date</th>
            <th>Received Amount</th>
            <th>Received By</th>
            <th>Payment Mode</th>
             <th>Action</th> 
            <?php if ($_SESSION['is_admin'] == 'True'): ?>
            <!-- <th>Action</th> -->
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php  
            $selectPay = "SELECT d.pay_id, d.received_date, d.received_amnt, d.received_by, d.pay_method, b.name AS empName 
FROM  payment AS d LEFT JOIN basic_details AS b ON d.received_by = b.id WHERE d.entity_id = 3 AND d.basic_id = '$empId'
ORDER BY d.received_date DESC
";
            $resQuery = mysqli_query($conn , $selectPay); 
            $i = 1; 
            while ($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
              
             
                $idStu = $row['basic_id'];
                $pay_id = $row['pay_id'];  
                $date = $row['received_date'];
                $formatted_date = date('d-M-Y', strtotime($date));
                $received_amnt = $row['received_amnt'];  
                $formatted_amount = number_format($received_amnt, 2, '.', ',');
                $received_by = $row['empName'];  
                $pay_method = $row['pay_method'];
  
        ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo $formatted_date ?></td>
          <td><?php echo "â‚¹ ".$formatted_amount?> </td>
          <td><?php echo  $received_by ?></td>
          <td><?php echo  $pay_method ?></td>
          <td><a href="traineeRecipt.php?id=<?php echo $pay_id ?>" target="_blank">
                                <button class="btn btn-primary btn-sm m-1"><i class="ph ph-download"></i>Bill PDF</button>
                                </a>
                                </td>
        
            
            <?php if ($_SESSION['is_admin'] == 'True'): ?>
            <!--<td>-->
            <!--     <button type="button" class="btn btn-sm btn-outline-warning"-->
            <!--            data-bs-toggle="modal" -->
            <!--            data-bs-target="#editPaymentModal">-->
            <!--        <i class="lni lni-pencil"></i>-->
            <!--    </button> -->
            <!--</td>-->
            <?php endif; ?>
        </tr>
        <?php } ?>
    </tbody>
</table>

                    </div>
                  </div>
                
              
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              <div class="d-flex justify-content-end mb-5">
          <?php  if ($_SESSION['is_admin'] == 'True'): ?>
            <button type="button" id="addDocumentBtn" class="btn btn-primary" onclick="goDocuments(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#addDocumentModal">Add Documents</button>
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
             
              
              <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
                   <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
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
              
             <!-- <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">-->
             <!--      <div class="mt-3">-->
        			  <!--      <div class="table-responsive">-->
             <!--                   <table id="example3" class="table table-striped table-bordered">-->
        					<!--		<thead>-->
        					<!--			<tr>-->
             <!--                               <th>S. No</th>-->
             <!--                               <th>Name</th>-->
        					<!--				<th>Date</th>-->
             <!--                               <th>Punch In</th>-->
             <!--                               <th>Punch Out</th>-->
             <!--                               <th>Role</th>-->
        					<!--			</tr>-->
        					<!--		</thead>-->
        					<!--		<tbody>-->
                                           
        					<!--	    </tbody>-->
        								
        					<!--    </table>-->
        			  <!--      </div>-->
        		   <!--</div>-->
             <!-- </div>-->
              
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
    <script>
      $(document).ready(function () {
        $('#example').DataTable();
        $('#example3').DataTable();
      });
    </script>
    <script>
      $(document).ready(function () {
        var table = $('#example2').DataTable({
          lengthChange: false,
          buttons: ['copy', 'excel', 'pdf', 'print']
        });

        table.buttons().container()
          .appendTo('#example2_wrapper .col-md-6:eq(0)');
      });
      
      $('#addDocumentBtn').click(function() {
        $('#addDocumentModal form')[0].reset(); // Reset the form inside the modal
      });

      function goEditProfile(id) {
        $.ajax({
          url: 'action/actTrainee.php',
          method: 'POST',
          data: {
            traineeId: id
          },
          dataType: 'json',
          success: function (response) {
            console.log(response);
            if (response.success) {
              // Process the successful response
              $('#editUsername').val(response.username);
              $('#editPassword').val(response.password);
              $('#profileId').val(response.emp_id);

              if (response.img) {
                $('#editImage').attr('src', response.img).show();
              } else {
                $('#editImage').hide();
              }
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message
              });
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX request failed:', status, error);
            console.log('Response Text:', xhr.responseText); // Log the raw response
          }
        });
      }



      function goView(id) {
        $('#PayTrainee').val(id);
        $.ajax({
          url: 'action/actPay.php',
          method: 'POST',
          data: {
            TraineePay: id  // Ensure TraineePay is correctly passed
          },
          dataType: 'json',
          success: function (response) {
            console.log(response); // Inspect the returned response
            if (response.id) {
              $('#payStudent').val(response.id);
              $('#traineeName').val(response.Trainee_name);
              $('#overAmnt').val(response.charge);
              $('#amntReceived').val(response.iniPay);
              // Calculate the balance amount
              var balanceAmount = response.charge - response.iniPay;
                
              // Set the balance amount in the #remaining field
              $('#remaining').val(balanceAmount);
            } else {
              console.error('Invalid response data');
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX request failed:', status, error);
          }
        });
      }


      function goEditPassword(id) {
        $.ajax({
          url: 'action/actTrainee.php',
          method: 'POST',
          data: {
            studid: id
          },
          dataType: 'json', // Specify the expected data type as JSON
          success: function (response) {
            
            // $('#editUname').val(response.username);
            $('#editPassword_input').val(response.password);
            $('#profileId_input').val(response.id);


          },
          error: function (xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
          }
        });
      }


      //--------------Handles edit trainee-----------------------------//

      document.addEventListener('DOMContentLoaded', function () {
        $('#editTrainee').off('submit').on('submit', function (e) {
          e.preventDefault(); // Prevent the form from submitting normally

          var formData = new FormData(this);
          $.ajax({
            url: "action/actTrainee.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
              console.log(response);
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response.message,
                  timer: 2000
                }).then(function () {
                  $('#editTraineeModal').modal('hide'); // Close the modal
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
            error: function (xhr, status, error) {
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


      //--edit password ajax -----------------------------

      document.addEventListener('DOMContentLoaded', function () {
        $('#editPassword_form').off('submit').on('submit', function (e) {
          e.preventDefault(); // Prevent the form from submitting normally

          var formData = new FormData(this);
          $('#password_change').prop('disabled', true);
          $.ajax({
            url: "action/actTrainee.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
              console.log(response);
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response.message,
                  timer: 2000
                }).then(function () {
                  $('#editPasswordModule').modal('hide'); // Close the modal
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
                $('#password_change').prop('disabled', false);
              }
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating password data.'
              });
              $('#password_change').prop('disabled', false);
            }
          });
        });
      });







      $(document).ready(function () {

        var today = new Date().toISOString().split('T')[0];
        $('#date').attr('max', today);

        function validateField(fieldId, errorId) {
          var value = $('#' + fieldId).val().trim();
          if (value === '') {
            $('#' + errorId).show();
            return false;
          } else {
            $('#' + errorId).hide();
            return true;
          }
        }

        $('#TraineeSubmitBtn').click(function (e) {
          e.preventDefault();
          var isValid = true;
          isValid = validateField('balance', 'amountError') && isValid;
          isValid = validateField('date', 'dateError') && isValid;
          isValid = validateField('payMode', 'modeError') && isValid;
          isValid = validateField('received', 'receivedError') && isValid;

          if (isValid) {
            $('#TraineePayment').trigger('submit');
            console.log("Form submitted");
          }
        });

        $('#TraineePayment').off('submit').on('submit', function (e) {
          e.preventDefault();
          var formData = new FormData(this);

          formData.forEach(function (value, key) {
            console.log(key + ": " + value);
          });

          $.ajax({
            url: "action/actPay.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              console.log("AJAX success:", response);
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response.message,
                  timer: 2000
                }).then(function () {
                  $('#PaymenttraineeModal').modal('hide');
                  $('.modal-backdrop').remove();
                  resetForm('TraineePayment');
                  setTimeout(function () {
                    $('#example2').load(location.href + ' #example2 > *', function () {
                      if ($.fn.DataTable.isDataTable('#example2')) {
                        $('#example2').DataTable().destroy();
                      }
                      var table = $('#example2').DataTable({
                        "paging": true,
                        "ordering": true,
                        "searching": true,
                        lengthChange: false,
                        buttons: ['copy', 'excel', 'pdf', 'print']
                      });

                      table.buttons().container()
                        .appendTo('#example2_wrapper .col-md-6:eq(0)');
                    });
                  }, 300);
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
              console.error("AJAX error:", xhr.responseText);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding Payment data.'
              });
              $('#TraineeSubmitBtn').prop('disabled', false);
            }
          });
        });

        function resetForm(formId) {
          document.getElementById(formId).reset();
          $('.error-message').hide();
        }
      });
      
    function goDocuments(id)  {
    $.ajax({
        url: 'action/actTrainee.php',
        method: 'POST',
        data: {
          docStu: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
        
       
        $('#stuId').val(response.stuId);
        


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

// Handle the form submission via AJAX
$('#addDocument').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var formData = new FormData(this);
    $.ajax({
        url: "action/actTrainee.php",
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
                text: 'An error occurred while adding Student documents.'
            });
        }
    });
});

function updateImage(selector, imagePath) {
    // Update the image source with the new path
    $(selector).attr('src', imagePath);
}

$(document).ready(function () {
    $('#submitBtnDoc').click(function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Check if at least one file input has a value
        var isAadharFilled = $('#aadhar').val() !== '';
        var isBankFilled = $('#bank').val() !== '';
        var isPanFilled = $('#pan').val() !== '';

        if (isAadharFilled || isBankFilled || isPanFilled) {
            // If at least one file is selected, submit the form
            $('#addDocument').submit();
        } else {
            // If no file is selected, show an alert or an error message
            alert('Please upload at least one document before submitting.');
        }
    });
});

    </script>
    <!--app JS-->
    <script src="<?php echo $app; ?>"></script>
    
    <script>

    document.addEventListener("DOMContentLoaded", function() {

        // Output PHP variable to JavaScript
    const username1 = "<?php echo $username1; ?>";
    // Check the username value
    console.log("Username:", username1);
    
        // Load data initially
        // loadAttendanceData(username1);

    });

    let table;

    // function loadAttendanceData(username) {
        

    //     fetch(`https://roririmobileapp.roririsoft.com/cms/punch/list/${username}/`)
    //         .then(response => response.json())
    //         .then(data => {
                

    //             if ($.fn.DataTable.isDataTable('#example3')) {
    //                 $('#example3').DataTable().destroy();
    //             }
          
    //             const tableBody = document.querySelector("#example3 tbody");
    //             tableBody.innerHTML = '';

    //             if (data.data.results && data.data.results.length > 0) {
    //                 let i = 1;
    //                 data.data.results.forEach(record => {
    //                     const row = `<tr>
    //                         <td>${i++}</td>
    //                         <td>${record.user_detail.full_name}</td>
    //                         <td>${record.punch_date}</td>
    //                         <td>${record.punch_in}</td>
    //                         <td>${record.punch_out ? record.punch_out : 'N/A'}</td>
    //                         <td>${record.user_detail.role}</td>
    //                     </tr>`;
    //                     tableBody.innerHTML += row;
    //                 });

    //                 // Initialize DataTable with buttons
    //                 table = $('#example3').DataTable({
    //                     lengthChange: false,
    //                     buttons: ['copy', 'excel', 'pdf', 'print']
    //                 });
    //                 $('#example3').DataTable().buttons().container()
    //                     .appendTo('#example3_wrapper .col-md-6:eq(0)');

    //             } else {
    //                 tableBody.innerHTML = `<tr><td colspan="6">No data found for the selected date.</td></tr>`;
    //             }
    //         })
    //         .catch(error => {
    //             document.getElementById("loading").style.display = 'none';
    //             console.error('Error fetching attendance records:', error);
    //             document.querySelector("#example3 tbody").innerHTML = `<tr><td colspan="6">Error loading data.</td></tr>`;
    //         });
    // }

    
</script>


<script src="../assets/js/form-validation.js"></script>
</body>

</html>