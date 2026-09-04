<div class="sidebar-wrapper" data-simplebar="true">
<div class="sidebar-header">
                <?php if ($_SESSION['is_admin'] === 'True'): ?>
                <a href="../index.php">
                <?php endif; ?>
                	<div>
                		<img src="../assets/images/favicon-32x32.png" class="logo-icon" alt="RORIRI">
                	</div>
                <?php if ($_SESSION['is_admin'] === 'True'): ?>
                </a>
                <?php endif; ?>
				<div>
					<h4 class="logo-text">RORIRI</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-menu'></i>
				</div>
			</div>
    <!-- navigation -->
    <ul class="metismenu" id="menu">
        <?php
                          $trainerRoles = [17]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') 
                          {
              ?>
                 
            <li >
                <a href="index.php">
                <div class="parent-icon"><i class="lni lni-home me-2"></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>


    <li>
		<a href="#" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-message-detail"></i>
			</div>
			<div class="menu-title">Enquiry Details</div>
		</a>
		<ul>
            <li >
                <a href="enquire.php">
                <div class="parent-icon"><i class="bx bx-conversation me-2"></i></div>
                    <div class="menu-title">Project Enquiry</div>
                </a>
            </li>
            
            <li >
                <a href="allEnquiries.php">
                <div class="parent-icon"><i class="lni lni-comments me-2"></i></div>
                    <div class="menu-title">All Enquiries</div>
                </a>
            </li>
        </ul>
    </li>
            
            <li >
                <a href="employee.php">
                <div class="parent-icon"><i class="lni lni-users me-2"></i></div>
                    <div class="menu-title">Employee</div>
                </a>
            </li>

            <li >
                <a href="attendance.php">
                <div class="parent-icon"><i class="lni lni-checkmark-circle me-2"></i></div>
                    <div class="menu-title">Attendance</div>
                </a>
            </li>
            
            <li >
                <a href="clients.php">
                <div class="parent-icon"><i class="lni lni-customer me-2"></i></div>
                    <div class="menu-title">Clients</div>
                </a>
            </li>

            <li >
                <a href="clientManage.php">
                <div class="parent-icon"><i class="lni lni-users me-2"></i></div>
                    <div class="menu-title">Client Portal</div>
                </a>
            </li>
            
            <li>
        		<a href="#" class="has-arrow">
        			<div class="parent-icon"><i class="bx bx-folder"></i>
        			</div>
        			<div class="menu-title">Project Details</div>
        		</a>
		        <ul>
                    <li >
                        <a href="project.php">
                        <div class="parent-icon"><i class="lni lni-notepad me-2"></i></div>
                            <div class="menu-title">Live Projects</div>
                        </a>
                    </li>
                    
                    <li >
                        <a href="https://projects.roririsoft.com/" target="_blank">
                        <div class="parent-icon"><i class="bx bx-desktop me-2"></i></div>
                            <div class="menu-title">Demo Projects</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li >
                <a href="coordinator.php">
                <div class="parent-icon"><i class="lni lni-crown me-2"></i></div>
                    <div class="menu-title">Coordinator</div>
                </a>
            </li>
          
            <li >
                <a href="internship.php">
                <div class="parent-icon"><i class="lni lni-star me-2"></i></div>
                    <div class="menu-title">Internship</div>
                </a>
            </li>
            
            <li>
                <a href="mou.php">
                    <div class="parent-icon"><i class="bx bx-book"></i></div> <!-- Book icon -->
                    <div class="menu-title">MOU</div>
                </a>
            </li>
            
                <li>
					<a href="#" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-task"></i>
						</div>
						<div class="menu-title">Task Details</div>
					</a>
					<ul>
                         <li>
                            <a href="addReportTask.php">
                                <div class="parent-icon"><i class="fadeIn animated bx bx-book-add"></i></div>
                                <div class="menu-title">Add Task</div>
                            </a>
                        </li>
                         <li>
                            <a href="taskAssign.php">
                                <div class="parent-icon"><i class="fadeIn animated bx bx-user-check"></i></div>
                                <div class="menu-title">Assign Task</div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="dailyReport.php">
                                <div class="parent-icon"><i class="bx bx-line-chart me-2"></i></div>
                                <div class="menu-title">Daily Report</div>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="eventReport.php">
                        <div class="parent-icon"><i class="bx bx-calendar-event"></i>
                        </div>
                        <div class="menu-title">Meeting / Event</div>
                    </a>
                </li>
    
        <?php 
        } else {  // If the user is not an admin
        ?>

            <li >
                <a href="../RoririSoftware/employeeDetails.php?id=<?php echo $_SESSION['id']; ?>">
                <div class="parent-icon"><i class="lni lni-user"></i></div>
                    <div class="menu-title">Profile</div>
                </a>
            </li>

            <li >
                <a href="../RoririSoftware/coordinator.php">
                <div class="parent-icon"><i class="lni lni-crown me-2"></i></div>
                    <div class="menu-title">Coordinator</div>
                </a>
            </li>
            
            <li>
					<a href="#" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-task"></i>
						</div>
						<div class="menu-title">Trainees Details</div>
					</a>
					<ul>

                        <li >
                            <a href="../NexGen_IT_Academy/trainee.php">
                            <div class="parent-icon"><i class="lni lni-graduation me-2"></i></div>
                                <div class="menu-title">Trainee</div>
                            </a>
                        </li>
                        
                        <li >
                            <a href="../NexGen_IT_Academy/assignApplication.php">
                            <div class="parent-icon"><i class="lni lni-stackoverflow me-2"></i></div>
                                <div class="menu-title">Application</div>
                            </a>
                        </li>
                    </ul>
            </li>

            <li >
                <a href="../RoririSoftware/internship.php">
                <div class="parent-icon"><i class="lni lni-star me-2"></i></div>
                    <div class="menu-title">Internship</div>
                </a>
            </li>
            
			<li >
                <a href="../RoririSoftware/allEnquiries.php">
                <div class="parent-icon"><i class="lni lni-comments me-2"></i></div>
                    <div class="menu-title">All Enquiries</div>
                </a>
            </li>
            
                <li>
					<a href="#" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-task"></i>
						</div>
						<div class="menu-title">Task Details</div>
					</a>
					<ul>
                        <li>
                            <a href="../RoririSoftware/addReportTask.php">
                                <div class="parent-icon"><i class="fadeIn animated bx bx-book-add"></i></div>
                                <div class="menu-title">Add Task</div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="../RoririSoftware/taskAssign.php">
                                <div class="parent-icon"><i class="fadeIn animated bx bx-user-check"></i></div> 
                                <div class="menu-title">Assign Task</div>
                            </a>
                        </li>
                                
                        <li>
                            <a href="../RoririSoftware/dailyReport.php">
                                <div class="parent-icon"><i class="bx bx-line-chart me-2"></i></div>
                                <div class="menu-title">Daily Report</div>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="../RoririSoftware/eventReport.php">
                        <div class="parent-icon"><i class="bx bx-calendar-event"></i>
                        </div>
                        <div class="menu-title">Meeting / Event</div>
                    </a>
                </li>
    
                <li>
                    <a href="../credit-debit/index.php">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-money"></i></div> <!-- Money icon -->
                        <div class="menu-title">Credit And Debit</div>
                    </a>
                </li>

            
             
        <?php 
        } 
        ?>
    </ul>
</div>
