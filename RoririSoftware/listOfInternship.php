<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");
include("action/function.php"); 




   $selQuery = "SELECT 
                    a.`intern_id`,
                    a.`name`,
                    a.`phone`,
                    a.`email`,
                    a.`mode`,
                    a.`gender`,
                    a.`joining_date`,
                    a.`inte_cou_id`,
                    a.`duration`,
                    a.`payment`,
                    b.`intern_course_name`,
                    IFNULL(payment_summary.totalAmount, 0) AS totalAmount
                FROM 
                    `internship_tbl` AS a 
                LEFT JOIN 
                    `inter_course_tbl` AS b ON a.`inte_cou_id` = b.`inte_cou_id`
                LEFT JOIN 
                    (
                        SELECT 
                            intern_id, 
                            SUM(inter_amount) AS totalAmount
                        FROM 
                            intern_payment 
                        WHERE 
                            status = 'Active' 
                        GROUP BY 
                            intern_id
                    ) AS payment_summary ON a.`intern_id` = payment_summary.intern_id
                WHERE 
                    a.`status` = 'Active' AND a.intern_id !=5
                ORDER BY 
                    a.`joining_date` DESC";
    
    $resQuery = mysqli_query($conn , $selQuery); 

    
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
<style>
        .error-message {
            color: red;
            display: none;
        }
        .error {
            border-color: red;
        }
        .bg-custom-success {
            background-color: #c2f5bc; /* Replace with your desired color */
        }
        .bg-custom-danger {
            background-color: #f9b7bc; 
        }
        .bg-custom-warning {
            background-color: #f9f4b7; 
        }
    </style>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
        <?php include "internshipLeft.php";?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include "top.php";?>
		<!--end header -->
		<!--start page wrapper -->
        <?php include "formInternship.php";?>
        <?php include "formInternPayment.php";?>
        <?php include "formApplication.php";?>
		
		<div class="page-wrapper">
        <div class="page-content">

<div class="page-title-box">
    <div class="row">
        <div class="col">
            <h2 class="page-title" id="catHeading">Candidates</h2>
        </div>
        <div class="col text-end pb-3">
            <!-- Add Candidates Button -->
            <?php
                  $trainerRoles = [17]; // Define the Admin of roles
                  if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
            <button type="button" id="addCondidates" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
                <i class="bx bx-plus"></i>Add Candidate
            </button>
            <?php } ?>
            <!-- Back Button, initially hidden -->
            <button type="button" id="backBtnView" class="btn btn-danger radius-10" style="display: none;"><i class="lni lni-exit"></i>Back</button>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center">
    <button type="button" id="backBtnTask" class="btn btn-secondary custom-btn me-auto m-2" style="display: none;">
        <i class="lni lni-exit"></i> Back
    </button>
    <button type="button" id="addTask" class="btn btn-primary custom-btn m-2" style="display: none;" data-bs-toggle="modal" data-bs-target="#applicationModal">
        <i class="lni lni-plus"></i> Add
    </button>
</div>

<!-- Candidates Table -->
<div class="card" id="condidateTable">
    <div class="card-body">
           <div class="row mb-4">
            <div class="col-md-2">
                <label for="reportStartDate">Start Date</label>
                <input type="date" id="reportStartDate" class="form-control">
                 <span id="startDateError" class="text-danger medium"></span>
            </div>
            <div class="col-md-2">
                <label for="endDate">End Date</label>
                <input type="date" id="endDate" class="form-control">
                  <span id="endDateError" class="text-danger medium"></span>
            </div>
            <div class="col-md-2">
                <label for="daysInput">Enter Duration</label>
                <input type="number" id="daysInput" class="form-control" min="0" placeholder="Enter number of days">
                <span id="daysError" class="text-danger medium"></span>
            </div>

            <div class="col-md-2">
                <label for="durationOption">Select Duration</label>
                <select id="durationOption" class="form-control">
                    <option value="">--Select the Duration--</option>
                    <option value="Day">Days</option>
                    <option value="Week">Weeks</option>
                    <option value="Month">Months</option>
                </select>
                <span id="durationError" class="text-danger medium"></span>
            </div>
            
            <div class="col-md-2">
                <label for="modeFilter">Select Mode</label>
                <select id="modeFilter" class="form-control">
                    <option value="">--Select the Mode--</option>
                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="courseFilter">Select Course</label>
                <select id="courseFilter" class="form-control">
                    <option value="">--Select the Course--</option>
                    <?php
                    $queryCou = "SELECT inte_cou_id, intern_course_name FROM inter_course_tbl WHERE status = 'Active'";
                    $resultCou = mysqli_query($conn, $queryCou);
                
                    if ($resultCou) {
                        while ($row = mysqli_fetch_assoc($resultCou)) {
                            $courseId = $row['inte_cou_id'];
                            $courseName = $row['intern_course_name'];
                
                            echo "<option value=\"$courseId\">$courseName</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2 mt-2">
                <label for="inchargeFilter">Select Incharge</label>
                <select id="inchargeFilter" class="form-control">
                    <option value="">--Select the Incharge--</option>
                    <?php
                        $sqlPerson2 = "SELECT
                                            a.`id`,
                                            a.`name`  
                                        FROM
                                            `basic_details` AS a
                                        LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                        LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                        WHERE
                                            a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                    $resultPer2 = $conn->query($sqlPerson2);
                    while ($row = $resultPer2->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php
                          $trainerRoles = [17]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
            <div class="col-md-2 mt-2">
                <label for="paymentFilter">Payment Status</label>
                <select id="paymentFilter" class="form-control">
                    <option value="">--Select the Payment Status--</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
           <?php } ?>
            <div class="col-md-1 mt-4 pt-1">
                <button id="filterBtn" class="btn btn-primary">Apply</button>
                </div>
            <div class="col-md-1 mt-4 pt-1">
                <button id="clearBtn" class="btn btn-primary">Reset</button>
            </div>
        </div>
        
        
        
        <div class="table-responsive">
            <!-- Dropdown Filter for Status -->
                            <div class="mb-3 col-sm-2">
                                <label for="statusFilter" class="form-label">Filter by Status</label>
                                <select id="statusFilter" class="form-select bg-custom-success text-black" onchange="filterStatus()">
                                    <option value="Active" class="bg-custom-success text-white" selected>Active</option>
                                    <option value="Inactive" class="bg-custom-danger text-black">Completed</option>
                                    <option value="Discontinued" class="bg-custom-warning text-black">Discontinued</option>
                                </select>
                            </div>
            <table id="example2" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Name</th>
                        <th>Joining Date</th>
                        <th>Phone</th>
                        <th>Course Name</th>
                        <?php
                          $trainerRoles = [17]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                        <th>Payment Status</th>
                        <th>Fees</th>
                        <th>Pending</th>
                        <?php } ?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; while($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) { 
                        $id         = $row['intern_id'];  
                        $name       = $row['name'];   
                        $phone      = $row['phone'];  
                        $course     = $row['intern_course_name'];
                        $payStatus  = ($row['payment'] - $row['totalAmount'] == 0) ? 'Completed' : 'Pending';
                        $join_date  = date('d M Y', strtotime($row['joining_date']));   
                        $fees       = $row['payment'];
                        $balance    = number_format($row['payment'] - $row['totalAmount']);
                        $formatFees = number_format($fees);
                    ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $join_date; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $course; ?></td>
                        <?php
                          $trainerRoles = [17]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                        <td><?php echo $payStatus; ?></td>
                        <td class="text-end">â‚¹<?php echo $formatFees; ?></td>
                        <td class="text-end">â‚¹<?php echo $balance; ?></td>
                        <?php } ?>
                        <td>
                            <?php
                  $trainerRoles = [17]; // Define the array of roles

                  if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewCandiaadate(<?php echo $id; ?>);">
                                <i class="lni lni-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" id="editSaveCandidate" onclick="goEditClient(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                <i class="lni lni-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Status" onclick="goDeleteClient(<?php echo $id; ?>);">
                                <i class="lni lni-reload"></i>
                            </button>
                            <?php } ?>
                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Task" onclick="showTaskTable(<?php echo $id; ?> ,'<?php echo $name; ?>')">
                                <i class="lni lni-radio-button"></i>
                            </button>
                            
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Candidate Detail View -->
<div class="container" id="nextDivId" style="display: none;">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img id="viewImage" src="" alt="Candidate Image" class="rounded-circle p-1 bg-primary" width="110" height="110" style="object-fit: cover;" />
                            <div class="mt-3">
                                <h4 id="viewName"></h4>
                                <p class="text-secondary mb-1" id="viewCourse"></p>
                                <p class="text-muted font-size-sm" id="viewAddress"></p>
                                <?php if ($_SESSION['is_admin'] === 'True'): ?>
                                <button id="btnCertificate" onclick="goCertificate()" class="btn btn-primary">Issue Certificate</button>
                                <a id="previewBtn" href="" target="_blank"><button class="btn btn-primary">Preview</button></a>   
                                    <?php endif; ?>
               
                            </div>
                        </div>
                        <hr class="my-4" />
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
        					<div class="col">
        						<div class="card radius-10">
        							<div class="card-body">
        							    <div class="text-center fw-bold">Performance</div>
        								<div id="chart6"></div>
        							</div>
        						</div>
        					</div>
        					<div class="col">
        						<div class="card radius-10">
        							<div class="card-body">
        							    <div class="text-center fw-bold">Attendance</div>
        								<div id="chart7"></div>
        							</div>
        						</div>
        					</div>
        				</div>
        				<div class="row mt-3">
                            <div class="col text-center">
                                <div>
                                    <span style="color: #28a745;">&#11044;</span> Good: Above 85%.
                                </div>
                                <div>
                                    <span style="color: #ffc107;">&#11044;</span> Average: Between 60% and 85%.
                                </div>
                                <div>
                                    <span style="color: #dc3545;">&#11044;</span> Bad: Below 60%.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Fees</h6>
                                <input type="hidden" id="userId">
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewFees"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Duration</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewDuration"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Incharge Person</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewIncharge"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Gender</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewGender"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mode</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewMode"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewPhone"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewMail"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Joining Date</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewJoiningDate"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Course Completed Date</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewEndDate"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Username</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewUsername"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Password</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p class="form-control" id="viewPassword"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            <div id="navTable" style="display: none;">
            <!-- Tabs navs -->
            <ul class="nav nav-tabs fs-6" id="myTab" role="tablist"> <!-- 'fs-5' is for slightly larger text -->
                            
                <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Payment Details</button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                    role="tab" aria-controls="contact" aria-selected="false">Document</button>
                </li> -->
                <!-- <?php if ($_SESSION['is_admin'] == 'True'): ?>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                    role="tab" aria-controls="login" aria-selected="false">Login History</button>
                </li>
                <?php endif; ?> -->
            </ul>
            <!-- Tabs navs -->


                 <!-- Tabs content -->
              <div class="tab-content" id="myTabContent">
               
               <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                 <div class="d-flex justify-content-end mb-3">
                   <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 'True'): ?>
                   <button type="button" id="addPayBtn" class="btn btn-primary mt-2" data-bs-toggle="modal"
                     onclick="goView(<?php echo $id; ?>);" data-bs-target="#PaymenttraineeModal"><i class="lni lni-plus"></i>Add Payment</button>
                   <?php  endif; ?>
                 </div>

                 <div class="table-responsive">
                 <table id="example3" class="table table-striped table-bordered">
            <thead>
                <tr>
                <th>S. No</th>
                 <th>Date</th>
                 <th>Received Amount</th>
                 <th>Payment Mode</th>
                 <th>Received By</th>
                 <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
            </table>

                 </div>
               </div>
             
   
           
           
           
         </div>
         <!-- Tabs content -->




            </div><!--nav table-->

        <!--Task Container-->
        <div class="card" id="taskTable" style="display: none;">
					<div class="card-body">
						<ul class="nav nav-pills mb-3" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-home" role="tab" aria-selected="true">
									<div class="d-flex align-items-center">
										<div class="tab-icon"><i class='bx bx-calendar-event font-18 me-1'></i>
										</div>
										<div class="tab-title">Task Details </div>
									</div>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a class="nav-link" data-bs-toggle="pill" href="#primary-pills-profile" role="tab" aria-selected="false">
									<div class="d-flex align-items-center">
										<div class="tab-icon"><i class='bx bx-calendar-check font-18 me-1'></i>
										</div>
										<div class="tab-title">Daily Work Details</div>
									</div>
								</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="primary-pills-home" role="tabpanel">
								<div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example4" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Task</th>
                                                        <th>Assigned Date</th>
                                                        <th>Task Status</th>
                                                        <th>Assigned By</th>
                                                        <th>Verified Date</th>
                                                        <th>Verified Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $intId = isset($_SESSION['int_id']) ? $_SESSION['int_id'] : 0;
                                                        if ($intId > 0) {
                                                            $taskQuery = "SELECT
                                                                                a.`appli_id`,
                                                                                a.`intern_id`,
                                                                                a.`appli_name`,
                                                                                a.`appli_description`,
                                                                                a.`intern_status`,
                                                                                a.`trainer_status`,
                                                                                a.`created_at`,
                                                                                a.`verified_time`,
                                                                                b.`name`
                                                                            FROM
                                                                                `intern_appli_track` AS a
                                                                            LEFT JOIN 
                                                                            	`basic_details` AS b
                                                                            ON
                                                                                a.assigned_by = b.id
                                                                            WHERE
                                                                                a.`status` = 'Active' AND a.`intern_id` = ?";
                                                
                                                            if ($stmt = mysqli_prepare($conn, $taskQuery)) {
                                                                mysqli_stmt_bind_param($stmt, 'i', $intId); 
                                                                mysqli_stmt_execute($stmt);
                                                                $resultTask = mysqli_stmt_get_result($stmt);
                                                
                                                                $i = 1;
                                                                while ($row = mysqli_fetch_array($resultTask, MYSQLI_ASSOC)) {
                                                                    $appli_id = htmlspecialchars_decode($row['appli_id'], ENT_QUOTES);
                                                                    $intern_id = htmlspecialchars_decode($row['intern_id'], ENT_QUOTES);
                                                                    $appli_name = htmlspecialchars_decode($row['appli_name'], ENT_QUOTES);
                                                                    $appli_description = htmlspecialchars_decode($row['appli_description'], ENT_QUOTES);
                                                                    $intern_status = htmlspecialchars_decode($row['intern_status'], ENT_QUOTES);
                                                                    $assignedBy = htmlspecialchars_decode($row['name'], ENT_QUOTES);
                                                                    $trainer_status = htmlspecialchars_decode($row['trainer_status'], ENT_QUOTES);
                                                                    $created_at = htmlspecialchars_decode($row['created_at'], ENT_QUOTES);  
                                                                    $date = new DateTime($created_at);
                                                                    $formatted_date = $date->format('d M Y, h:i A');
                                                                    $verified_time = htmlspecialchars_decode($row['verified_time'], ENT_QUOTES);
                                                                    $verified_time_display = ($verified_time == '0000-00-00 00:00:00' || $verified_time == null) ? 'Not Verified' : $verified_time;
                                                                    $formatted_updated_at = ($verified_time_display == 'Not Verified') ? $verified_time_display : (new DateTime($verified_time_display))->format('d M Y, h:i A');
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; $i++; ?></td>
                                                        <td><?php echo $appli_name; ?></td>
                                                        <td><?php echo $formatted_date; ?></td>
                                                        <td><?php echo $intern_status; ?></td>
                                                        <td><?php echo $assignedBy; ?></td>
                                                        <td><?php echo $formatted_updated_at; ?></td>
                                                        <td><?php echo $trainer_status; ?></td> 
                                                        
                                                        <td>
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-sm btn-outline-warning" 
                                                                id="editTask" 
                                                                onclick="goEditTask(<?php echo $appli_id; ?>);" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editTaskModal"
                                                                // <?php
                                                                // if ($trainer_status === 'Completed') echo 'disabled';
                                                                // ?> 
                                                            >
                                                                <i class="lni lni-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#viewTaskModal" onclick="goViewTask(<?php echo $appli_id; ?>);">
                                                                <i class="lni lni-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                                }
                                                                mysqli_stmt_close($stmt);
                                                            } else {
                                                                echo "Query preparation failed: " . mysqli_error($conn);
                                                            }
                                                        } 
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
							</div>
							<div class="tab-pane fade" id="primary-pills-profile" role="tabpanel">
								<div class="card">
                					<div class="card-body">
                						<div class="table-responsive">
                							<table id="example" class="table table-striped table-bordered">
                								<thead>
                									<tr>
                                                        <th class="col-1">S. No</th>
                										<th class="col-2">Date</th>
                										<th class="col-9">Work Details</th>
                									</tr>
                								</thead>
                								<tbody>
                                                <?php
                                                        $intId = isset($_SESSION['int_id']) ? $_SESSION['int_id'] : 0;
                                                        if ($intId > 0) {
                                                            $dailyQuery = "SELECT `id`, `date`, `task` FROM `intern_task_update` WHERE `status` = 'Active' AND `created_by` = ?";
                                                
                                                            if ($stmt = mysqli_prepare($conn, $dailyQuery)) {
                                                                mysqli_stmt_bind_param($stmt, 'i', $intId); // Bind the parameter as an integer
                                                                mysqli_stmt_execute($stmt);
                                                                $resultDaily = mysqli_stmt_get_result($stmt);
                                                
                                                                $i = 1;
                                                                while ($row = mysqli_fetch_array($resultDaily, MYSQLI_ASSOC)) {
                                                                    $date = (new DateTime(htmlspecialchars_decode($row['date'], ENT_QUOTES)))->format('d M Y');
                                                                    $task = htmlspecialchars_decode($row['task'], ENT_QUOTES);
                                                    ?>
                                                <tr>
                                                    <td class="col-1"><?php echo $i; $i++; ?></td>
                                                    <td class="col-2"><?php echo $date; ?></td>
                                                    <td class="col-9"><?php echo $task; ?></td>
                                                </tr>
                                                <?php
                                                                }
                                                                mysqli_stmt_close($stmt);
                                                            } else {
                                                                echo "Query preparation failed: " . mysqli_error($conn);
                                                            }
                                                        } 
                                                    ?>  
                								</tbody>
                							</table>
                						</div>
                					</div>
                				</div>
							</div>
						</div>
					</div>
				</div>
        

        </div><!-- end page-content -->
		</div>
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include "footer.php"; ?>
	</div>
	<!--end wrapper-->
<div id="loader" class="justify-content-center align-items-center" style="display: none;">
	<div class="card-body text-center">
		<div class="spinner-grow text-primary" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-secondary" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-success" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-danger" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-warning" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-info" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-light" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-dark" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
	</div>
</div>

	



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
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
        $(document).ready(function() {
            // Hide the #addTask button initially if the daily work details tab is active
            $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href"); // Get the href of the activated tab
                if (target === "#primary-pills-profile") {
                    $('#addTask').hide(); // Hide when "Daily Work Details" tab is active
                } else {
                    $('#addTask').show(); // Show when "Task Details" tab is active
                }
            });
            
            $('#clearBtn').click(function () {
                $('#reportStartDate').val('');
                $('#endDate').val('');
                $('#daysInput').val('');
                $('#durationOption').val('');
                $('#modeFilter').val('');
                $('#courseFilter').val('');
                $('#inchargeFilter').val('');
                $('#paymentFilter').val('');
        
                $('#startDateError').text('');
                $('#endDateError').text('');
                $('#daysError').text('');
                $('#durationError').text('');
            });
        });


var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['link', 'blockquote', 'code-block', 'image'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['clean']
        ]
    }
});

var quillEdit = new Quill('#editorEdit', {
        theme: 'snow', // You can also use 'bubble' theme
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['link', 'blockquote', 'code-block', 'image'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['clean'] // Removes formatting
            ]
        }
    });
     
// Function to validate date inputs and display error messages
function validateDateInputs() {
    const today = new Date().toISOString().split('T')[0]; // Today's date in YYYY-MM-DD format
    const reportStartDate = $('#reportStartDate').val();
    const endDate = $('#endDate').val();
    const daysInput = $('#daysInput').val();
    const durationOption = $('#durationOption').val();

    let isValid = true; // Flag to track overall validity

    // Clear previous error messages
    $('#startDateError').text('');
    $('#endDateError').text('');
    $('#daysError').text('');
    $('#durationError').text('');

    // Date validation

    // Check if Start Date is in the future
    if (reportStartDate && reportStartDate > today) {
        $('#startDateError').text("Start Date cannot be in the future.");
        isValid = false;
    }

    // Check if End Date is in the future
    if (endDate && endDate > today) {
        $('#endDateError').text("End Date cannot be in the future.");
        isValid = false;
    }

    // Ensure End Date is not before Start Date
    if (reportStartDate && endDate && endDate < reportStartDate) {
        $('#endDateError').text("End Date cannot be earlier than Start Date.");
        isValid = false;
    }

    // Duration validation

    // Check if both fields are either empty or both are filled
    if ((daysInput && !durationOption) || (!daysInput && durationOption)) {
        if (!daysInput) {
            $('#daysError').text("Please enter the number of days.");
        }
        if (!durationOption) {
            $('#durationError').text("Please select a duration option.");
        }
        isValid = false;
    }

    return isValid; // Return overall validity
}

        
    //       function setTodayMaxDate(inputId) {
    // const today = new Date().toISOString().split('T')[0];
    // document.getElementById(inputId).setAttribute("max", today);
    // }

    // // setTodayMaxDate('assetDate');
    // // setTodayMaxDate('editAssetDate');
    // // setTodayMaxDate('startDate');
    // setTodayMaxDate('reportStartDate');
    // setTodayMaxDate('endDate');
    
    
 function formatCurrency(value) {
    return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(value);
}

// Helper function to format the date
        function formatDate(dateString) {
            // Return 'N/A' if date is null, undefined, or empty
            if (!dateString) return 'N/A'; 
        
            const date = new Date(dateString);
            
            // Check if the date is valid
            if (isNaN(date.getTime())) return 'N/A'; // If date is invalid, return 'N/A'
        
            // Create an array of month abbreviations
            const monthNames = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            
            const day = String(date.getDate()).padStart(2, '0');
            const month = monthNames[date.getMonth()]; // Get the month abbreviation
            const year = date.getFullYear();
 
            return `${day} ${month} ${year}`; // Format as d-MMM-Y
        }


      // Filter button click event
    $('#filterBtn').on('click', function() {
    if (!validateDateInputs()) {
        return; // Stop if validation fails
    }

    var reportStartDate = $('#reportStartDate').val();
    var endDate = $('#endDate').val();
    var daysInput = $('#daysInput').val();
    var durationOption = $('#durationOption').val();
    var mode = $('#modeFilter').val();
    var course = $('#courseFilter').val();
    var payment = $('#paymentFilter').val();
    var incharge = $('#inchargeFilter').val();
    var combinedDuration = '';
    var statusFilter = $('#statusFilter').val();
    
    if (daysInput.trim() !== '' && durationOption.trim() !== '') {
        combinedDuration = daysInput + " " + durationOption;
    }
    
    if (!reportStartDate && !endDate && !combinedDuration && !mode && !statusFilter && !course && !payment) {
        console.log("All filters are empty. AJAX request will not be triggered.");
        return; // Stop if all variables are empty
    }

    // Perform AJAX request
    $.ajax({
        url: 'action/actCandidate.php', // Update with your server-side script to fetch data
        type: 'GET',
        data: {
            report_start_date: reportStartDate,
            end_date: endDate,
            duration: combinedDuration,
            mode: mode,
            course: course,
            payment: payment,
            incharge: incharge,
            status: statusFilter
        },
        dataType: 'json',
        success: function(data) {
            $('#example2').DataTable().destroy();
            $('#example2 tbody').empty();

            // Loop through the returned data and append rows to the table
            data.forEach(function(item, index) {
                const balance = parseFloat(item.payment) - parseFloat(item.totalAmount);
                const paystatus = balance === 0 ? 'Completed' : 'Pending';
                
                // Conditionally display Edit and Delete buttons based on status filter
                const buttonsHTML = (statusFilter === 'Active') ? `
                    <button type="button" class="btn btn-sm btn-outline-warning"
                            id="editSaveCandidate" onclick="goEditClient(${item.intern_id});" 
                            data-bs-toggle="modal" data-bs-target="#editClientModal">
                        <i class="lni lni-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Change Status" 
                            onclick="goDeleteClient(${item.intern_id});">
                        <i class="lni lni-reload"></i>
                    </button>
                ` : '';

                const rowHTML = `
                    <tr>
                        <td>${index + 1}</td> 
                        <td>${item.name}</td> 
                        <td>${formatDate(item.joining_date)}</td> 
                        <td>${item.phone}</td>
                        <td>${item.intern_course_name}</td> 
                        <?php
                            $trainerRoles = [17]; // Define the Admin of roles
                            if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                                <td>${paystatus}</td> 
                                <td class="text-end">${formatCurrency(item.payment)}</td>
                                <td class="text-end">${formatCurrency(balance)}</td>
                        <?php } ?>
                        <td>
                            <?php
                                if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                                    <button class="btn btn-sm btn-outline-success"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View" 
                                            onclick="goViewCandiaadate(${item.intern_id});">
                                        <i class="lni lni-eye"></i>
                                    </button>
                                    ${buttonsHTML}
                                <?php } ?>
                                
                                <button class="btn btn-sm btn-outline-info" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Task" 
                                        onclick="showTaskTable(${item.intern_id}, '${item.name}')">
                                    <i class="lni lni-radio-button"></i>
                                </button>
                        </td>
                    </tr>`;
                
                // Append the new row to the table body
                $('#example2 tbody').append(rowHTML);
            });

            var table = $('#example2').DataTable({
                "paging": true,
                "ordering": true,
                "searching": true,
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            // Move the button container to a specific location
            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
});

function filterStatus() {
    var filter = document.getElementById("statusFilter").value;
    var statusFilter = document.getElementById("statusFilter");

    statusFilter.classList.remove('bg-custom-success', 'bg-custom-danger', 'bg-custom-warning');
    
    if (filter === 'Active') {
        statusFilter.classList.add('bg-custom-success');
    } else if (filter === 'Inactive') {
        statusFilter.classList.add('bg-custom-danger');
    } else if (filter === 'Discontinued') {
        statusFilter.classList.add('bg-custom-warning'); 
    }

    $.ajax({
        url: 'action/actCandidate.php',
        method: 'POST',
        data: { status: filter },
        dataType: 'json',
        success: function(response) {
            var table = $('#example2').DataTable();
            table.clear();

            <?php
            $trainerRoles = [17];
            $isTrainerOrAdmin = (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') ? 'true' : 'false';
            ?>

            const isTrainerOrAdmin = <?php echo $isTrainerOrAdmin; ?>;

            if (response.length > 0) {
                response.forEach(function(row, index) {
                    const balance = parseFloat(row.payment) - parseFloat(row.totalAmount);
                    const paystatus = balance === 0 ? 'Completed' : 'Pending';
                    const formattedBalance = 'â‚¹ ' + balance.toLocaleString('en-US');
                    const formattedPayment = 'â‚¹ ' + parseFloat(row.payment).toLocaleString('en-US');
                    const formattedJoiningDate = new Date(row.joining_date).toLocaleDateString('en-GB', {
                        day: '2-digit', month: 'short', year: 'numeric'
                    });

                    let actionButtons = '';

                    if (isTrainerOrAdmin) {
                        actionButtons += `<button class="btn btn-sm btn-outline-success" title="View" onclick="goViewCandidate(${row.intern_id});">
                                            <i class="lni lni-eye"></i>
                                          </button>`;
                    }

                    if (filter === "Active" && isTrainerOrAdmin) {
                        actionButtons += `<button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditClient(${row.intern_id});" data-bs-toggle="modal" data-bs-target="#editClientModal">
                                            <i class="lni lni-pencil"></i>
                                          </button>
                                          <button class="btn btn-sm btn-outline-danger" title="Change Status" onclick="goDeleteClient(${row.intern_id});">
                                            <i class="lni lni-reload"></i>
                                          </button>`;
                    }

                    actionButtons += `<button class="btn btn-sm btn-outline-info" title="Task" onclick="showTaskTable(${row.intern_id}, '${row.name}')">
                                        <i class="lni lni-radio-button"></i>
                                      </button>`;

                    let rowData = [
                        index + 1,                           
                        row.name,                            
                        formattedJoiningDate,                 
                        row.phone,                          
                        row.intern_course_name,              
                        isTrainerOrAdmin ? paystatus : '',   
                        isTrainerOrAdmin ? formattedPayment : '', 
                        isTrainerOrAdmin ? formattedBalance : '', 
                        actionButtons           
                    ];

                    table.row.add(rowData).draw(false);
                });
            } 
            $('#filterBtn').click();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching data: ", textStatus, errorThrown);
        }
    });
}

</script>

        

        <script>
    // Function to set up date validations
    function setDateValidations() {
        // Get today's date
        const today = new Date();
        
        // Set the maximum date for the joining date inputs to today
        const formattedToday = today.toISOString().split("T")[0]; // yyyy-mm-dd format
        document.getElementById('joiningDate').setAttribute('max', formattedToday);
        document.getElementById('joiningDateEdit').setAttribute('max', formattedToday); // For edit modal

        // Calculate the date for 18 years ago for the DOB
        const eighteenYearsAgo = new Date();
        eighteenYearsAgo.setFullYear(today.getFullYear() - 18);
        const formattedDOB = eighteenYearsAgo.toISOString().split("T")[0]; // yyyy-mm-dd format
        
        // Set the max attribute of the DOB inputs to 18 years ago
        document.getElementById('dob').setAttribute('max', formattedDOB);
        document.getElementById('dobEdit').setAttribute('max', formattedDOB); // For edit modal
    }

    // Call the function to set validations when the page loads
    window.onload = setDateValidations;
</script>
     


    <script>

$('#username').on('input', function() {
    var username = $(this).val().trim();
    
    // Define the pattern for validation
    var pattern = /^[a-z]+_?[0-9]{0,5}$/;
    
    // Check if the username matches the pattern
    if (username === '') {
        $('#usernameError').text("Username is required").show();
        $('#submitBtn').prop('disabled', true);
    } else if (!pattern.test(username)) {
        $('#usernameError').text("Username must consist of lowercase letters, optionally one underscore, and up to 5 numbers.").show();
        $('#submitBtn').prop('disabled', true);
    } else {
        // Proceed with AJAX check if pattern matches
        $.ajax({
            url: 'action/checkIntern.php', // The PHP script that checks the username
            method: 'POST',
            data: { username: username },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    // Username exists, show error and disable submit button
                    $('#username').addClass('is-invalid'); // Add is-invalid class
                    $('#usernameError').text("Username already exists").show();
                    $('#submitBtn').prop('disabled', true); // Disable submit button if username exists
                } else {
                    // Username is available, remove error and enable submit button
                    $('#username').removeClass('is-invalid'); // Remove is-invalid class
                    $('#usernameError').hide();
                    $('#submitBtn').prop('disabled', false); // Enable submit button if username is available
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('#usernameError').text("An error occurred while checking the username").show();
            }
        });
    }
});

        

        // Back button click event
        document.getElementById('backBtnView').addEventListener('click', function() {
            // Show Add Candidates button
            document.getElementById("addCondidates").style.display = "inline-block";
            
            $('#catHeading').text("Candidates");
            // Hide Back button
            document.getElementById("backBtnView").style.display = "none";

            // Show candidate table and hide detailed view (you can customize this part)
            document.getElementById("condidateTable").style.display = "block";
            document.getElementById("navTable").style.display = "none";
            document.getElementById("nextDivId").style.display = "none";
        });




    function goEditClient(id) 
  
  {
    $('#usernameEdit').prop('disabled', true);
    $.ajax({
        url: 'action/actCandidate.php',
        method: 'POST',
        data: {
            editIdClient: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#EditId').val(response.id);
          $('#nameEdit').val(response.name);
          $('#inchargeEdit').val(response.incharge === "0" ? "" : response.incharge);
          $('#courseEdit').val(response.course_id);
          $('#feesEdit').val(response.fees);
          $('#durationNoEdit').val(response.durationNO);
          $('#durationEdit').val(response.duration);
          $('#genderEdit').val(response.gender);
          $('#modeEdit').val(response.mode);
          $('#phoneEdit').val(response.phone);
          $('#emailEdit').val(response.email);
          $('#addressEdit').val(response.address);
          $('#joiningDateEdit').val(response.join_date);
          $('#usernameEdit').val(response.username);
          $('#passwordEdit').val(response.password);
         
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    }


    //---view function --------


    function goViewCandiaadate(id) 
                {   
document.getElementById("loader").style.display = "flex";
                // Hide Add Candidates button
            document.getElementById("addCondidates").style.display = "none";

            // Show Back button
            document.getElementById("backBtnView").style.display = "inline-block";

            // Hide candidate table and show detailed view (you can customize this part)
            document.getElementById("condidateTable").style.display = "none";
            
            $('#catHeading').text("Candidate Details");

            // Use PHP to set the base URL for the images
    var baseUrl = "<?php echo $internImageView; ?>"; // Ensure this variable is set in PHP
    var defaultUrl = "<?php echo $default_image; ?>"; // Ensure this variable is set in PHP
    $('#PayTrainee').val(id);


    $.ajax({
        url: 'action/actCandidate.php',
        method: 'POST',
        data: {
            viewIdClient: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {

            // Check if the image property exists and is not empty
        if (response.image && response.image.trim() !== '') {
            // Set the src attribute of the img tag to the actual image
            $('#viewImage').attr('src', baseUrl + response.image);
        } else {
            // Set the src attribute to the default image
            $('#viewImage').attr('src', defaultUrl);
        }
              var performanceValue = parseFloat(response.performance);
              var attendanceValue  = parseFloat(response.attendance);
              updatePerformanceChart(performanceValue, attendanceValue);
              let fees = parseFloat(response.fees).toLocaleString('en-IN');
              let balance = (parseFloat(response.fees) - (parseFloat(response.totalAmount) || 0)).toLocaleString('en-IN');

              $('#userId').val(response.id);
              $('#viewName').text(response.name);
              $('#viewIncharge').text(response.incharge === null ? "Not Allocated" : response.incharge);
              $('#viewCourse').text(response.course_id);
              $('#viewFees').text(fees + " (Balance: " + balance + ")");
              var remainingDays = response.remaining_days > 0 ? response.remaining_days : 0;
              $('#viewDuration').text(response.durationNO + " " + response.duration + " (Remaining: " + remainingDays + " days)");
              $('#viewGender').text(response.gender);
              $('#viewMode').text(response.mode);
              $('#viewPhone').text(response.phone);
              $('#viewMail').text(response.email);
              $('#viewAddress').text(response.address);
              $('#viewJoiningDate').text(response.join_date);
              $('#viewEndDate').text(response.end_date);
              $('#viewUsername').text(response.username);
              $('#viewPassword').text(response.password);
         
              $('#payStudent').val(response.inter_paym_id);
              $('#traineeName').val(response.name);
              $('#overAmnt').val(response.fees);
              $('#amntReceived').val(response.totalAmount);
                if (balance === "0") {
                    $('#addPayBtn').prop('disabled', true);
                } else {
                    $('#addPayBtn').prop('disabled', false); 
                }
                if (response.certificate_status === 'Active') {
                    $('#btnCertificate')
                        .text('Issued') 
                        .prop('disabled', true); 
                } else {
                    $('#btnCertificate')
                        .text('Issue Certificate')
                        .prop('disabled', false);
                }
                $('#previewBtn').attr('href', `../Internship/certifcate.php?id=${response.id}`);
              // Calculate the balance amount
              var balanceAmount = response.fees - response.totalAmount;
                
              // Set the balance amount in the #remaining field
              $('#remaining').val(balanceAmount);
		    // Now trigger payment table load
            loadPaymentDetails(id); // Call function to load payment table
            document.getElementById("nextDivId").style.display = "block";
            document.getElementById("navTable").style.display = "block";
            document.getElementById("loader").style.display = "none";
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
            document.getElementById("loader").style.display = "none";
        }
    });
    }

    let chart1, chart2; // Declare these globally if needed to track chart instances
    
    function updatePerformanceChart(performanceValue, attendanceValue) {
        // Destroy existing charts if present
        if (chart1) {
            chart1.destroy();
            chart1 = null; // Clear reference
        }
        if (chart2) {
            chart2.destroy();
            chart2 = null; // Clear reference
        }
    
        // Reset the chart container
        document.querySelector("#chart6").innerHTML = '';
        document.querySelector("#chart7").innerHTML = '';
    
        // Function to determine the chart color based on percentage
        function getPerformanceColor(percentage) {
            if (percentage > 85) return '#28a745'; // Green for Good
            if (percentage > 60) return '#ffc107'; // Yellow for Average
            return '#dc3545'; // Red for Poor
        }
    
        // Chart options with 0% as the initial value
        const options1 = {
            series: [0], // Start with 0 for the animation
            chart: {
                height: 500,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    startAngle: 0,
                    endAngle: 360,
                    track: {
                        background: '#f0f0f0',
                        strokeWidth: '100%',
                        margin: 1,
                    },
                    hollow: {
                        margin: 5,
                        size: '75%',
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            fontSize: '20px',
                            show: true,
                            formatter: function (val) {
                                return val + "%";
                            },
                        },
                    },
                },
            },
            fill: {
                colors: [getPerformanceColor(0)], // Start with default color
            },
        };
    
        // Create the chart instance with initial options
        chart1 = new ApexCharts(document.querySelector("#chart6"), options1);
        chart1.render();
        
        const options2 = {
        series: [0], // Start with 0 for the animation
        chart: {
            height: 500,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                startAngle: 0,
                endAngle: 360,
                track: {
                    background: '#f0f0f0',
                    strokeWidth: '100%',
                    margin: 1,
                },
                hollow: {
                    margin: 5,
                    size: '75%',
                },
                dataLabels: {
                    name: {
                        show: false,
                    },
                    value: {
                        fontSize: '20px',
                        show: true,
                        formatter: function (val) {
                            return val + "%";
                        },
                    },
                },
            },
        },
        fill: {
            colors: [getPerformanceColor(0)], // Start with default color
        },
    };

    // Create chart2 (Attendance chart)
    chart2 = new ApexCharts(document.querySelector("#chart7"), options2);
    chart2.render();
    
        // Add a slight delay to reset and then update the chart
        setTimeout(() => {
            // Dynamically update the chart with the new value
            chart1.updateOptions({
                series: [performanceValue],
                fill: {
                    colors: [getPerformanceColor(performanceValue)], // Update with the actual color
                },
            });
            chart2.updateOptions({
                series: [attendanceValue],
                fill: {
                    colors: [getPerformanceColor(attendanceValue)], // Update with the actual color
                },
            });
        }, 500); // Delay of 500ms to reset the chart
    }

    function loadPaymentDetails(intern_id) {
    $.ajax({
        url: 'action/actCandidate.php',  // URL of your PHP file that handles fetching payments
        method: 'POST',
        data: { internId: intern_id },    // Pass the intern_id to fetch payments
        dataType: 'json',
        success: function(response) {
            var paymentTable = $('#example3 tbody');
            paymentTable.empty();  // Clear existing table rows

            if (response.length > 0) {
                // Loop through the payments and append rows to the table
               $.each(response, function(index, payment) {
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + payment.formatted_date + '</td>' +
                            '<td>â‚¹ ' + payment.formatted_amount + '</td>' +
                            '<td>' + payment.pay_mode + '</td>' +
                            '<td>' + payment.received_by + '</td>' +
                            '<td>' +
                                '<button class="btn btn-sm btn-outline-danger" ' +
                                'onclick="deletePayment(' + payment.inter_paym_id + ');">' +
                                '<i class="lni lni-trash"></i></button>' +
                                '<a href="../Internship/receiptIntern.php?id=' + payment.inter_paym_id + '" target="_blank">' +
                                '<button class="btn btn-primary btn-sm m-1"><i class="ph ph-download"></i>Bill PDF</button>' +
                                '</a>' +
                            '</td>' +
                            '</tr>';
                        paymentTable.append(row);
                    });
            } else {
                // Handle case where no payments are found
                paymentTable.append('<tr><td colspan="5">No payment records found</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading payment details:', status, error);
        }
    });
}


function deletePayment(payment_id) {
    if (confirm('Are you sure you want to delete this payment?')) {
        $.ajax({
            url: 'action/actCandidate.php',  
            method: 'POST',
            data: { paymentId: payment_id },  
            success: function(response) {
               if (response.success) {
                    // Find the table row that contains the payment_id and remove it
                    $('#example3 tbody tr').each(function() {
                        // Assuming payment_id is stored in a data attribute for easy retrieval
                        if ($(this).find('button').attr('onclick').includes(payment_id)) {
                            $(this).remove();  // Remove the matching row
                        }
                    });
                    alert('Payment deleted successfully.');
                } else {
                    alert('Error deleting payment: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting payment:', status, error);
            }
        });
    }
}


function goDeleteClient(id) {
    // Open the modal
    $('#deleteClientModal').modal('show');

    // Add an event listener for the "Delete" button inside the modal
    $('#confirmDeleteBtn').off('click').on('click', function() {
        // Get the selected status from the dropdown
        var selectedStatus = $('#deleteStatus').val();

        // Close the modal
        $('#deleteClientModal').modal('hide');

        // Perform the AJAX request to delete the candidate with the selected status
        $.ajax({
            url: 'action/actCandidate.php',
            method: 'POST',
            data: {
                clientdeleteId: id,
                status: selectedStatus  // Pass the selected status to the server
            },
            success: function(response) {
                // Reload the table
                $('#example2').load(location.href + ' #example2 > *', function() {
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

                // Show SweetAlert based on the response
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Changed',
                        text: response.message,
                        timer: 2000
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
                console.error('AJAX request failed:', status, error);
            }
        });
    });
}


    function goCertificate() {
        var id = $('#userId').val();
    
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to issue the certificate?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, issue it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'action/actCandidate.php',
                    method: 'POST',
                    data: {
                        certificate: id
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Certificate issued successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        });
                        $('#btnCertificate')
                        .text('Issued') 
                        .prop('disabled', true);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error issuing the certificate.',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                        console.error('AJAX request failed:', status, error);
                    }
                });
            }
        });
    }


//Data Table script 
    </script>
	
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
				
			var table = $('#example').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example_wrapper .col-md-6:eq(0)' );
                
		} );
</script>

    <!--Handles the Ajax call-->
<script>
        $(document).ready(function () {

// Handle the form submission via AJAX
$('#candidatesForm').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission

    var form = document.getElementById('candidatesForm');

    // Check form validity using the HTML5 built-in validation
    if (form.checkValidity() === false) {
        e.stopPropagation(); // Stop submission if form is invalid
        form.classList.add('was-validated'); // Bootstrap's way of showing validation feedback
        return; // Exit the function, don't proceed with the AJAX request
    }
    // Concatenate duration number and unit
    var durationNo = $('#durationNo').val();
    var durationUnit = $('#duration').val();
    var fullDuration = durationNo + " " + durationUnit; // Example: "5 Day"

    // Create a new FormData object
    var formData = new FormData(this);
    formData.append('fullDuration', fullDuration); // Add the concatenated duration to FormData

    // Disable the submit button to prevent double submission
    const submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true);

    
    $.ajax({
        url: "action/actCandidate.php",
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
                    $('#addClientModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
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

                // Reset the form after successful submission
                resetForm('candidatesForm');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            // Re-enable the submit button on error
            submitButton.prop('disabled', false);
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding Candidate data.'
            });
        }
    });
});




    // edit form --------------

// Handle the form submission via AJAX
$('#EditcandidatesForm').off('submit').on('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission
    
    var form = document.getElementById('EditcandidatesForm');
    
    // Check form validity using the HTML5 built-in validation
    if (form.checkValidity() === false) {
        e.stopPropagation(); // Stop submission if form is invalid
        form.classList.add('was-validated'); // Bootstrap's way of showing validation feedback
        return; // Exit the function, don't proceed with the AJAX request
    }

    // Concatenate duration number and unit
    var durationNo = $('#durationNoEdit').val();
    var durationUnit = $('#durationEdit').val();
    var fullDuration = durationNo + " " + durationUnit; // Example: "5 Day"

    // Create a new FormData object
    var formData = new FormData(this);
    formData.append('fullDuration', fullDuration); // Add the concatenated duration to FormData

    // Manually append the username if the input is readonly
    var username = $('#usernameEdit').val();
    formData.append('usernameEdit', username); // Add username manually to FormData

    // Disable the submit button to prevent double submission
    const submitButton = $(this).find('button[type="submit"]');
    submitButton.prop('disabled', true);

    
    $.ajax({
        url: "action/actCandidate.php",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json', // Expect JSON response
        success: function (response) {
            // Re-enable the submit button after success or error
            submitButton.prop('disabled', false);

            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 2000
                }).then(function () {
                    $('#editClientModal').modal('hide'); // Close the modal
                    $('.modal-backdrop').remove(); // Remove the backdrop
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

                // Reset the form after successful submission
                resetForm('EditcandidatesForm');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            // Re-enable the submit button on error
            submitButton.prop('disabled', false);
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while adding Candidate data.'
            });
        }
    });
});







    // Reset the form when the 'Add Candidates' button is clicked
    $('#addCondidates').click(function () {
        resetForm('candidatesForm');
        $('#username').removeClass('is-invalid is-valid'); // Remove is-invalid class
        $('#submitBtn').prop('disabled', false);
    });
    });

    // Function to reset the form and hide error messages
    function resetForm(formId) {
    var form = document.getElementById(formId);
    form.reset(); // Reset the form
    form.classList.remove('was-validated'); // Remove validation styling
    $('.error-message').hide(); // Hide all error messages (if any custom ones exist)
    }

</script>


<script>
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
  
   $('#remaining').prop('disabled', false);

  $.ajax({
    url: "action/actCandidate.php",
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

          var id = $('#PayTrainee').val();
          loadPaymentDetails(id); // Call function to load payment table
          $('#remaining').prop('disabled', true);
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: response.message
        });
        $('#remaining').prop('disabled', true);
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
      $('#remaining').prop('disabled', true);
    }
  });
});

function resetForm(formId) {
  document.getElementById(formId).reset();
  $('.error-message').hide();
}
});
</script>

<!--Task jQuery-->
<script>
    function showTaskTable(id , name) {
        
        
        
        $.ajax({
            url: 'action/actCandidate.php', // The PHP file to handle the session setting
            type: 'POST',
            data: {int_id: id},
            success: function(response) {
                $('#example4').load(location.href + ' #example4 > *', function() {
                    $('#example4').DataTable().destroy();
                    $('#example4').DataTable({
                        "paging": true,
                        "ordering": true,
                        "searching": true
                    });
                });
                $('#example').load(location.href + ' #example > *', function() {
                    $('#example').DataTable().destroy();
                    $('#example').DataTable({
                        "paging": true,
                        "ordering": true,
                        "searching": true
                    });
                });
                $('a[data-bs-toggle="pill"][href="#primary-pills-home"]').tab('show');
                $('#catHeading').text(name +" "+"Task Details");
                $('#condidateTable').hide();  
                $('#addCondidates').hide();
                $('#intern_id').val(id);
                $('#intern_idEdit').val(id);
                $('#taskTable').show(); 
                $('#addTask').show();
                $('#backBtnTask').show();
                
            },
            error: function(xhr, status, error) {
                console.error("Error setting session: " + error);
            }
        });
    }
    
    //Fetch the details for Edit Task
    function goEditTask(id) {
        quillEdit.root.innerHTML = '';
        $.ajax({
            url: 'action/actCandidate.php', // The PHP file to handle the session setting
            type: 'POST',
            data: { appli_id: id },
            dataType: 'json',
            success: function(taskDetails) {

                $('#appli_idEdit').val(taskDetails.id);
                $('#appli_nameEdit').val(taskDetails.name);
                if (taskDetails.appli_description) {
                    quillEdit.root.innerHTML = taskDetails.appli_description;
                    $('#appli_descriptionEdit').val(taskDetails.appli_description); 
                }
                // $('#appli_descriptionEdit').val(taskDetails.appli_description);
                $('#statusEdit').val(taskDetails.trainer_status);
                $('#taskMark').val(taskDetails.task_mark);
            },
            error: function(xhr, status, error) {
                console.error("Error setting session: " + error);
            }
        });
    }
    
    function goViewTask(id){
        $('#loader').show();
        $.ajax({
                url: 'action/actCandidate.php', 
                method: 'POST',
                data: { viewTaskId: id },
                dataType: 'json',
                success: function(response) {
                    $('#viewTaskName').text(response.task);
                    $('#viewAssignedDate').text(response.assignDate);
                    $('#viewAssignedBy').text(response.assignBy);
                    $('#viewTaskStatus').text(response.taskStatus);
                    $('#viewVerifiedDate').text(response.verifyDate || '-');
                    $('#viewVerifiedStatus').text(response.verifyStatus || '-');
                    $('#viewVerifiedBy').text(response.verifyBy || '-');
                    $('#viewTaskMark').text(response.taskMark || '-');
                    $('#viewReferImages').html(response.referImages ? '<a href="https://asset.inforiya.in/ERP/ERP_image/internTask/' + response.referImages + '" target="_blank">' + response.referImages + '</a>' : '-');
                    $('#viewInternDescript').text(response.internDescript || '-');

                    $('#loader').hide(); 
                    $('#viewTaskModal').modal('show'); 
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    $('#loader').hide();
                    alert('Failed to fetch task details.');
                }
            });
    }
    
    $(document).ready(function() {
        $('#backBtnTask').on('click', function() {
            $('#catHeading').text("Candidates");
            $('#taskTable').hide(); 
            $('#addTask').hide();
            $('#backBtnTask').hide();
            $('#condidateTable').show();  
            $('#addCondidates').show();
        });
    
    $('#addTask').click(function() {
        // Reset the form
        $('#applicationForm')[0].reset();
        quill.root.innerHTML = '';
    });
    
    // Handle the task Add event
    $('#applicationForm').off('submit').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission
    
        const editorContent = quill.root.innerHTML; 
        $('#appli_description').val(editorContent);
        
        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
    
        $.ajax({
            url: "action/actCandidate.php",
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
                        $('#applicationModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop
                            $('#example4').load(location.href + ' #example4 > *', function() {
                                $('#example4').DataTable().destroy();
                                $('#example4').DataTable({
                                    "paging": true,
                                    "ordering": true,
                                    "searching": true
                                });
                            });
                    });
    
                    resetForm('applicationForm');
                    quill.root.innerHTML = '';
                    $('#submitFormBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                // Re-enable the submit button on error
                $('#submitFormBtn').prop('disabled', false);
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding Task data.'
                });
            }
        });
    });
    
    document.getElementById('statusEdit').addEventListener('change', function () {
        const taskMarkField = document.getElementById('taskMark');
        if (this.value === 'Completed') {
            taskMarkField.setAttribute('required', 'required'); // Add the required attribute
        } else {
            taskMarkField.removeAttribute('required'); // Remove the required attribute
        }
    });
        
    document.getElementById('taskMark').addEventListener('input', function (e) {
        let value = parseInt(e.target.value, 10);
    
        // Check if the value exceeds the max limit (10)
        if (value > 10) {
            e.target.value = 10; // Set the value to 10
        } else if (value < 0 || isNaN(value)) {
            e.target.value = ''; // Clear invalid inputs like negatives or non-numeric
        }
    });
    
    // Handle the Edit Form Submit
    $('#applicationFormEdit').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        const editorContent = quillEdit.root.innerHTML; 
        $('#appli_descriptionEdit').val(editorContent);
        
        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        
        $.ajax({
            url: "action/actCandidate.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function () {
                        $('#editTaskModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop
                            $('#example4').load(location.href + ' #example4 > *', function() {
                                $('#example4').DataTable().destroy();
                                $('#example4').DataTable({
                                    "paging": true,
                                    "ordering": true,
                                    "searching": true
                                });
                            });
                    });
    
                    resetForm('applicationFormEdit');
                    quillEdit.root.innerHTML = '';
                    $('#submitEditBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                // Re-enable the submit button on error
                $('#submitEditBtn').prop('disabled', false);
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating Task data.'
                });
            }
        });
    });
});   
$(document).ready(function() {
    $('#togglePassword').on('click', function() {
        const passwordInput = $('#password');
        const eyeIcon = $('#eyeIcon');

        // Check the type of input and toggle
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text'); // Change type to text
            eyeIcon.removeClass('bx-hide').addClass('bx-show'); // Change icon to show
        } else {
            passwordInput.attr('type', 'password'); // Change type back to password
            eyeIcon.removeClass('bx-show').addClass('bx-hide'); // Change icon back to hide
        }
    });
    $('#togglePasswordEdit').on('click', function() {
        const passwordInput = $('#passwordEdit');
        const eyeIcon = $('#eyeIconEdit');

        // Check the type of input and toggle
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text'); // Change type to text
            eyeIcon.removeClass('bx-hide').addClass('bx-show'); // Change icon to show
        } else {
            passwordInput.attr('type', 'password'); // Change type back to password
            eyeIcon.removeClass('bx-show').addClass('bx-hide'); // Change icon back to hide
        }
    });
});

</script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>

<script>
                  
    function handleStatus(status) {
        // Assign the status value to the dropdown or input field with id 'modeFilter'
        $('#modeFilter').val(status);    
        
        // Trigger the button click on the element with id 'filterBtn'
        $('#filterBtn').click();
    }
    function handleView(status) {
        // Assign the status value to the dropdown or input field with id 'modeFilter'
        $('#statusFilter').val(status);    
        $('#statusFilter').removeClass('bg-custom-success').addClass('bg-custom-danger');
        // Trigger the button click on the element with id 'filterBtn'
        $('#filterBtn').click();
    }
</script>
<script type="text/javascript">
$(document).ready(function() {
    var canSetInchargeFilter = <?php 
        $trainerRoles = [1,2,3,4,5,6,7,8,9,12,13,14,15,16];
        echo (in_array($_SESSION['role'], $trainerRoles)) ? 'true' : 'false';
    ?>;

    if (canSetInchargeFilter) {
        var currentUserId = <?php echo $_SESSION['id']; ?>; 
        $('#inchargeFilter').val(currentUserId); 
        
        $('#filterBtn').click();
    }
});
</script>
        <?php
        
        if (isset($_GET['dash_status'])) {
    $status = $_GET['dash_status'];

    // You can trigger your logic based on the status value
    if ($status === 'Online') {
        // Handle the 'online' status case
        echo "<script>handleStatus('Online');</script>";
    } 
    if ($status === 'Offline') {
        // Handle the 'offline' status case
        echo "<script>handleStatus('Offline');</script>";
    }
        }
        if (isset($_GET['active_status'])) {
            $status = $_GET['active_status'];

            if ($status === 'Completed') {
                echo "<script>handleView('Inactive');</script>";
            }
        }
        ?>
