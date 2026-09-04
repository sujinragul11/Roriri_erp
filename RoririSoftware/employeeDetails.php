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

$corQuery = "SELECT name, log FROM coordinator WHERE JSON_CONTAINS(log, JSON_OBJECT('id', '$empId', 'status', 'active'), '$')";

$resultCor = $conn->query($corQuery);
if ($resultCor) {
    if ($resultCor->num_rows > 0) {
        $coordinatorNames = [];

        while ($row = mysqli_fetch_array($resultCor, MYSQLI_ASSOC)) {
            $coordinatorNames[] = $row['name'] . " Coordinator"; 
        }

        $namesList = implode("<br>", $coordinatorNames); 
    } else {
        $namesList = "No coordinator."; 
    }
} else {
    $namesList = "Error executing query: " . $conn->error; 
}

// Prepare and execute the SQL query
$selQuery = "SELECT additional_details.entity_id ,additional_details.entity_id ,additional_details.role,additional_details.image , additional_details.qr,additional_details.bank,additional_details.pan,additional_details.aadhar,additional_details.offerLetter,additional_details.experience as ex_image,additional_details.paySlip, basic_details.*,emp_additional_details.*,roles.* ,additional_details.joining_date
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
    $employee_id = $row['reg_no'] ?? '';
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
    // $joining_date = $row['joining_date'];
    $pay_role = $row['payroll'];
    $emp_img = $row['image'];
    $usname=$row['username'];
    $password=$row['password'];
    $emp_qr=$row['qr'];
    $bank=$row['bank'];
    $pan=$row['pan'];
    $aadhar=$row['aadhar'];
    
    $experience=$row['ex_image'];
     
    $paySlip=$row['paySlip'];
   
    $offerLetter=$row['offerLetter'];
    
    // Construct the image path QR
    $qr_path=$qrView.$emp_qr;
  // Construct the image path Employee
  $image_path = $imageView . $emp_img;
  $aadhar_path=$aadharView.$aadhar;
  $bank_path=$bankView.$bank;
  $pan_path=$panView.$pan;
  
  $pay_path = $paySlipView.$paySlip;
  $off_path = $offerLetterView.$offerLetter;
  $experience_path = $experienceView.$experience;

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
    <h3 class="page-title">Employee/View</h3>
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
              if ($headers !== false && isset($headers[0])) {
                return stripos($headers[0], "200 OK") ? true : false;
              }
              return false;
            }
              if (url($image_path)) {
                $display_image = $image_path; 
              } else {
                $display_image = $default_image; 
              } ?>
              <img src="<?php echo $display_image; ?>" alt="<?php echo $name;?>" class="rounded-circle p-1  img-fluid" style="width: 120px; height: 120px; object-fit: cover; object-position: top; max-width: 120px; max-height: 120px;">
              <div class="mt-3">
                <h4><?php echo $name;?></h4>
                <p class="text-secondary mb-1"><?php echo $employee_id;?></p>
                <p class="text-secondary mb-1"><?php echo $gender;?></p>
                <p class="text-secondary mb-1"><?php echo $role;?></p>
                <p class="text-success mb-1"><?php echo $namesList; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
    <div class="card h-100" style="height: 450px;">
      <div class="card-body">
        <div class="row h-100">
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
                <p class="text-secondary mb-1"><?php echo $joining_date;?></p>
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
        <!--<li class="nav-item" role="presentation">-->
        <!--    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="contact" aria-selected="false">Attendance</button>-->
        <!--</li>-->
        <?php if ($_SESSION['is_admin'] == 'True'): ?>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                    role="tab" aria-controls="login" aria-selected="false">Login Histroy</button>
                </li>
        <?php endif; ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="coordinator-tab" data-bs-toggle="tab" data-bs-target="#coordinator" type="button" role="tab" aria-controls="coordinator" aria-selected="false">Coordinator</button>
        </li>
        
        
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
            <h5>Aadhar</h5>
            <div class="card">
                <img src="<?php echo !empty($aadhar) ? $aadhar_path : $doc_def_img; ?>" class="card-img-top" id="aadharImage" alt="Aadhar Image">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Bank</h5>
            <div class="card">
                <img src="<?php echo !empty($bank) ? $bank_path : $doc_def_img; ?>" class="card-img-top" id="bankImage" alt="Bank Image">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <h5>PAN</h5>
            <div class="card">
                <img src="<?php echo !empty($pan) ? $pan_path : $doc_def_img; ?>" class="card-img-top" id="panImage" alt="PAN Image">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Experience</h5>
            <div class="card">
                <img src="<?php echo !empty($experience) ? $experience_path : $doc_def_img; ?>" class="card-img-top" id="exImage" alt="Experience Image">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Offer Letter</h5>
            <div class="card">
                <img src="<?php echo !empty($offerLetter) ? $off_path : $doc_def_img; ?>" class="card-img-top" id="offerImage" alt="Offer Letter Image">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Pay Slip</h5>
            <div class="card">
                <img src="<?php echo !empty($paySlip) ? $pay_path : $doc_def_img; ?>" class="card-img-top" id="payImage" alt="Pay Slip Image">
            </div>
        </div>
    </div>
</div>

        </div>

        <!-- -----attendanse report start -->
     <!--   <div class="tab-pane fade show " id="attendance" role="tabpanel" aria-labelledby="home-tab">-->
     <!--      <div class="mt-3">-->
			  <!--      <div class="table-responsive">-->
     <!--         <table id="example3" class="table table-striped table-bordered">-->
					<!--			<thead>-->
					<!--				<tr>-->
     <!--                                   <th>S. No</th>-->
     <!--                                   <th>Name</th>-->
					<!--					<th>Date</th>-->
     <!--                                   <th>Punch In</th>-->
     <!--                                   <th>Punch Out</th>-->
     <!--                                   <th>Role</th>-->
                                    

					<!--				</tr>-->
					<!--			</thead>-->
					<!--			<tbody>-->
                                   
					<!--	</tbody>-->
								
					<!--</table>-->
			  <!--      </div>-->
		   <!--    </div>-->
     <!--   </div>-->
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
                                                WHERE `basic_id` = '$empId'";
                                    
                                    $resQuery = mysqli_query($conn , $selectPay); 
                                    $i = 1; 
                    
                                    if ($resQuery) while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
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
                  
                   <div class="tab-pane fade position-relative p-3" id="coordinator" role="tabpanel" aria-labelledby="coordinator-tab">
            <div class="d-flex justify-content-end mb-3">
            <?php
                // $trainerRoles = [17]; 
                // if (!in_array($_SESSION['role'], $trainerRoles) && $_SESSION['is_admin'] !== 'True') { 
                ?>
              <button type="button" id="addWorkBtn" class="btn btn-primary position-absolute top-0 end-0"  data-bs-toggle="modal" data-bs-target="#addWorkModal">Add Work</button>
              <?php 
            //   }
              ?> 
              
            </div>
            <div class="mt-3">
              <div class="table-responsive">
              <table id="example7" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
                                        <th>Department Name</th>
                                        <!--<th>Coordinator Name</th>-->
                                        <th>Assigned Date</th>
                                        <th>Work</th>
                                        <th>Completed Date</th>
                                        <th>Assigned By</th>
                                        <th>Action</th>

										
									</tr>
								</thead>
								<tbody>
                      <?php $selectPro="SELECT
                                            a.assigned_date,
                                            a.rep_id,
                                            a.report,
                                            a.completed_date,
                                            b.name AS dept_name,
                                            c.name AS user_name,
                                            d.name as assign_name
                                        FROM
                                            `coordinator_report` AS a
                                        LEFT JOIN coordinator AS b
                                        ON
                                            a.dept_id = b.id
                                            LEFT JOIN basic_details AS c ON a.coordinator_id =c.id
                                            LEFT JOIN basic_details as d ON a.assign_by = d.id
                                        WHERE
                                            a.status = 'Active' AND a.coordinator_id ='$empId'
                                        ORDER BY
                                            a.created_at DESC;";
                                    
									$resQuery = mysqli_query($conn , $selectPro); 
								$i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
								    $rep_id      = $row['rep_id'];
                            $dept_name   = $row['dept_name'];
                            $user_name   = $row['user_name'];
                            $assigned_date        = $row['assigned_date'];
                            
                            $completed_date        = $row['completed_date'];    
                            
                            $assign_name        = $row['assign_name'] ?? '--';
                            $report      = htmlspecialchars_decode($row['report']);
                            
                      
                      ?>
                      <tr>
                       <!-- Table row is place in this place -->
                       <td class="col-1 text-center"><?php echo $i; $i++; ?></td>
                       <td class="col-3"><?php echo $dept_name; ?></td>
                       <!--<td></td>-->
                       <td class="col-2"><?php echo ($assigned_date == '0000-00-00') ? '---' : formatDate($assigned_date); ?></td>
                       <td class="col-6 text-wrap"><?php echo $report; ?></td>
                       <td class="col-2"><?php echo ($completed_date == '0000-00-00') ? '---' : formatDate($completed_date); ?></td>
                       <td class="col-2"><?php echo $assign_name; ?></td>
                       <td><button class="btn btn-outline-primary btn-sm" onclick="openEditModal(<?php echo $rep_id ;?>)" title="Edit"><i class="lni lni-pencil"></i></button></td>
                      
                    </tr>
                    <?php } ?>  
						</tbody>
								
					</table>
              </div>
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
   <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    // Initialize Quill editor
    var quill = new Quill('#quillEditor', {
        theme: 'snow'
    });

    // Sync content to hidden textarea for form submission
    quill.on('text-change', function() {
        document.querySelector('#workDescription').value = quill.root.innerHTML;
    });
    
    
    // Initialize Quill editor
    var quillEdit = new Quill('#quillEditorEdit', {
        theme: 'snow'
    });

    // Sync content to hidden textarea for form submission
    // quill.on('text-change', function() {
    //     document.querySelector('#workDescriptionEdit').value = quill.root.innerHTML;
    // });
    
    
    function openEditModal(recordId) {
    // Show loading spinner
    $('#editModal .modal-body').html('<div class="text-center py-5"><div class="spinner-border" role="status"></div></div>');

    // Perform AJAX call to fetch record data
    $.ajax({
        url: 'action/actEmployee.php',
        type: 'GET',
        dataType: 'json',
        data: { recordId: recordId },
        success: function(response) {
            
            // Populate the form with fetched data
            $('#record_edit_id').val(response.rep_id);
            $('#deptIdEdit').val(response.dept_id);
            $('#workDateEdit').val(response.completed_date);
       // Decode HTML entities for Quill
        function decodeHtmlEntities(str) {
            var textArea = document.createElement('textarea');
            textArea.innerHTML = str;
            return textArea.value;
        }
          let decodedContent = decodeHtmlEntities(response.report); // Decode HTML entities
            quillEdit.root.innerHTML = decodedContent;

    

            // $('#workDescriptionEdit').val(response.report);
            $('#statusEdit').val(response.work_ststus);

            // Show the modal
            $('#editWorkModal').modal('show');
        },
        error: function() {
            alert('Failed to fetch record data.');
        }
    });
}


// Handle the form submission via AJAX
$('#editWork').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission
    var form = this;

    form.classList.remove('was-validated');
    if (form.checkValidity() === false) {
        form.classList.add('was-validated');
        return;
    }

    if (quillEdit) {
    $('#workDescriptionEdit').val(quillEdit.root.innerHTML);
} else {
    console.error('Quill Editor not initialized.');
} 
    
    $('#submitBtnWorkEdit').prop('disabled', true);  // Disable submit button

    var formData = new FormData(form);

    $.ajax({
        url: "action/actEmployee.php",
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
                    timer: 1500
                }).then(function () {
                    $('#editWorkModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    $('#example7').load(location.href + ' #example7 > *', function () {
                        if ($.fn.DataTable.isDataTable('#example7')) {
                            $('#example7').DataTable().clear().destroy();
                        }
                        var table7 = $('#example7').DataTable({
                            lengthChange: false
                        });
                        table7.buttons().container().appendTo('#example7_wrapper .col-md-6:eq(0)');
                    });
                });

                resetForm('editWork');
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
                text: 'An error occurred while updating Work data.'
            });
        },
        complete: function() {
            $('#submitBtnWorkEdit').prop('disabled', false);
        }
    });
});
</script>
    
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
			$('#example5').DataTable();
		  } );
	</script>
  <script>
    $(document).ready(function() {
        var table3 = $('#example3').DataTable({
            lengthChange: false,
            buttons: [
              <?php if ($_SESSION['is_admin'] == 'True'): ?>
                'copy', 'excel', 'pdf', 'print'
              <?php endif; ?>
            ]
        });
        table3.buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(document).ready(function() {
        var table7 = $('#example7').DataTable({
            lengthChange: false,
            buttons: [
              <?php if ($_SESSION['is_admin'] == 'True'): ?>
                'copy', 'excel', 'pdf', 'print'
              <?php endif; ?>
            ]
        });
        table7.buttons().container().appendTo('#example7_wrapper .col-md-6:eq(0)');
    });
    
    
     $(document).ready(function() {
        var table8 = $('#dailyReport_table').DataTable({
            lengthChange: false,
            buttons: [
              <?php if ($_SESSION['is_admin'] == 'True'): ?>
                'copy', 'excel', 'pdf', 'print'
              <?php endif; ?>
            ]
        });
        table8.buttons().container().appendTo('#dailyReport_table_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(document).ready(function() {
        var table2 = $('#example2').DataTable({
            lengthChange: false,
            buttons: [
              <?php if ($_SESSION['is_admin'] == 'True'): ?>
                'copy', 'excel', 'pdf', 'print'
              <?php endif; ?>
            ]
        });
        table2.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
    
    function resetForm(formId) {
    var form = document.getElementById(formId);
    form.reset();
    form.classList.remove('was-validated');
    $('.error-message').hide(); // Hide any error messages if applicable
    $('#deptId').val('').trigger('change'); // Reset specific select elements if necessary
}
    
  $('#addWorkBtn').on('click', function(){
            
          $('#addWork').removeClass('was-validated');
        $('#addWork').addClass('needs-validation');
        $('#addWork')[0].reset(); // Reset the form $('#addCourse').removeClass('was-validated');
    
    });
    
// Handle the form submission via AJAX
$('#addWork').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var form = this;

    // Check if the form is valid
    if (form.checkValidity() === false) {
        // If the form is invalid, show native HTML5 validation messages
        form.classList.add('was-validated');
        return;
    }

    // Disable the submit button to prevent double submission
    $('#submitBtnWork').prop('disabled', true);

    var formData = new FormData(form);
    $.ajax({
        url: "action/actEmployee.php",
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
                    timer: 1500
                }).then(function () {
                    $('#addWorkModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop

                    $('#example7').load(location.href + ' #example7 > *', function () {
                        if ($.fn.DataTable.isDataTable('#example7')) {
                            $('#example7').DataTable().destroy();
                        }
                        var table7 = $('#example7').DataTable({
                            lengthChange: false,
                            buttons: [
                                'copy', 'excel', 'pdf', 'print'
                            ]
                        });
                        table7.buttons().container().appendTo('#example7_wrapper .col-md-6:eq(0)');
                    });
                });

                // Reset the form after successful submission
                resetForm('addWork'); // Change 'addAssetForm' to 'addWork'
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
                text: 'An error occurred while adding Asset data.'
            });
        },
        complete: function() {
            // Re-enable the submit button after the request is complete
            $('#submitBtnWork').prop('disabled', false);
        }
    });
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
             if (response.paySlip_path) {
                $('#paySlipPreview').attr('src', response.paySlip_path).show();
            } else {
                $('#paySlipPreview').hide();
            }
             if (response.offerLetter_path) {
                $('#offerLetterPreview').attr('src', response.offerLetter_path).show();
            } else {
                $('#offerLetterPreview').hide();
            }
             if (response.experience_path) {
                $('#experiencePreview').attr('src', response.experience_path).show();
            } else {
                $('#experiencePreview').hide();
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
function updateImage(selector, path) {
    $(selector).attr('src', path);
}
$(document).ready(function () {


// Handle the form submission
// $('#submitBtnDoc').click(function (e) {
//     e.preventDefault(); // Prevent default form submission

//     var isValid = true;

//     // Validate fields
//     // isValid &= validateField('aadhar', 'aadharError');
//     // isValid &= validateField('bank', 'bankError');
//     // isValid &= validateField('pan', 'panError');
    

//     if (isValid) {
//         $('#addDocument').trigger('submit'); // Manually trigger the form submit event if validation passes
//     }
// });

// Handle the form submission via AJAX
$('#addDocument').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var form = $(this);
    var submitButton = form.find('button[type="submit"]'); // Find the submit button
    var originalButtonText = submitButton.html(); // Save the original button text
    
    // Disable the button and show loading spinner
    submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

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

                  if (response.data) {
                        // Check and update each document field individually
                        if (response.data.aadhar) {
                            var aadharPath = 'https://asset.inforiya.in/ERP/ERP_image/Documents/Aadhar/';
                            updateImage('#aadharImage', aadharPath + response.data.aadhar.name);
                        }
                        if (response.data.bank) {
                            var bankPath = 'https://asset.inforiya.in/ERP/ERP_image/Documents/Bank/';
                            updateImage('#bankImage', bankPath + response.data.bank.name);
                        }
                        if (response.data.pan) {
                            var panPath = 'https://asset.inforiya.in/ERP/ERP_image/Documents/Pan/';
                            updateImage('#panImage', panPath + response.data.pan.name);
                        }
                        if (response.data.experience) {
                            var experiencePath = 'https://asset.inforiya.in/ERP/ERP_image/Documents/experience/';
                            updateImage('#experImage', experiencePath + response.data.experience.name);
                        }
                        if (response.data.offerLetter) {
                            var offerLetterPath = 'https://asset.inforiya.in/ERP/ERP_image/Documents/offerLetter/';
                            updateImage('#oferImage', offerLetterPath + response.data.offerLetter.name);
                        }
                        if (response.data.paySlip) {
                            var paySlipPath = 'https://asset.inforiya.in/ERP/ERP_image/Documents/paySlip/';
                            updateImage('#payslipImage', paySlipPath + response.data.paySlip.name);
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
        },
        complete: function () {
            // Re-enable the button and restore original text
            submitButton.prop('disabled', false).html(originalButtonText);
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
<script src="../assets/js/form-validation.js"></script>
</body>

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
<script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('workDate').setAttribute('max', today);
</script>

</html>