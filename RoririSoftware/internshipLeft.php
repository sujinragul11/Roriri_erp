
<?php
$trainerRoles = [17]; // Define the Admin of roles
if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { 
// Fetch unread messages for interns
$unreadQuery1 = "
    SELECT DISTINCT intern_id 
    FROM intern_support_tbl 
    WHERE msg_status = 'Unread' 
    AND reply_id = 0 AND status = 'Active'";
$unreadResult1 = mysqli_query($conn, $unreadQuery1);
$hasUnread1 = mysqli_num_rows($unreadResult1) > 0;
} else{
    $unreadQuery1 = "
    SELECT DISTINCT a.intern_id 
    FROM intern_support_tbl AS a 
    LEFT JOIN internship_tbl AS b 
    ON a.intern_id = b.intern_id
    WHERE a.msg_status = 'Unread' 
    AND b.incharge_id = {$_SESSION['id']}
    AND a.reply_id = 0 AND a.status = 'Active'";
$unreadResult1 = mysqli_query($conn, $unreadQuery1);
$hasUnread1 = mysqli_num_rows($unreadResult1) > 0;
}
?>

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
					<h4 class="logo-text">IT Internship</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-menu'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<!-- <li>
					<a href="javascript:void(0);" id="dashboard-btn">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li> -->

				<li>
					<a href="internship.php">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Home</div>
					</a>
				</li>

				<li>
					<a href="internEnquiry.php">
						<div class="parent-icon"><i class="bx bx-book"></i></div>
						<div class="menu-title">Enquiry</div>
					</a>
				</li>

				<li>
					<a href="listOfInternship.php">
						<div class="parent-icon"><i class="bx bx-user-circle"></i></div>
						<div class="menu-title">Candidates</div>
					</a>
				</li>
				
				<li>
					<a href="internCourse.php">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Courses</div>
					</a>
				</li>
				<li>
					<a href="internSupport.php">
						<div class="parent-icon"><i class="bx bx-chat"></i></div>
						<div class="menu-title">Support
						<?php if ($hasUnread1): ?>
                            <span class="badge bg-danger ms-2">Unread</span>
                        <?php endif; ?></div>
					</a>
				</li>
				<?php
                          $trainerRoles = [17]; // Define the Admin of roles
                          if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
				<li>
					<a href="paymentReport.php">
						<div class="parent-icon"><i class='bx bx-wallet'></i>
						</div>
						<div class="menu-title">Payment Report</div>
					</a>
				</li>
				<li>
					<a href="idCard.php">
						<div class="parent-icon"><i class='bx bx-id-card'></i>
						</div>
						<div class="menu-title">ID Card Details</div>
					</a>
				</li>
				<?php } ?>
				<li>
					<a href="internAttendance.php">
						<div class="parent-icon"><i class='bx bx-calendar'></i>
						</div>
						<div class="menu-title">Attendance</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>