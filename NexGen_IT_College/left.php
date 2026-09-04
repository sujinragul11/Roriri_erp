<div class="sidebar-wrapper" data-simplebar="true">
<div class="sidebar-header">
			<a href="../index.php">
				<div>
					<img src="../assets/img/Logo Roriri.png" class="logo-icon" alt="RORIRI">
				</div>
				</a>
				<div>
					<h4 class="logo-text">NexGen College</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			</div>
    <!-- navigation -->
    <ul class="metismenu" id="menu">
        <?php 
        if ($_SESSION['is_admin'] === 'True') {  // Check if the user is an admin
        ?>

                <li>
					<a href="index.php">
						<div class="parent-icon"><i class="lni lni-home me-2"></i></div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>

                <li>
					<a href="student.php">
						<div class="parent-icon"><i class="lni lni-users me-2"></i></div>
						<div class="menu-title">Students</div>
					</a>
				</li>

                <li>
					<a href="course.php">
						<div class="parent-icon"><i class="lni lni-customer me-2"></i></div>
						<div class="menu-title">Course</div>
					</a>
				</li>

                <li>
					<a href="subject.php">
						<div class="parent-icon"><i class="lni lni-notepad me-2"></i></div>
						<div class="menu-title">Subject</div>
					</a>
				</li>
            
            
                <li>
					<a href="enquiry.php">
						<div class="parent-icon"><i class="lni lni-customer me-2"></i></div>
						<div class="menu-title">Enquiry</div>
					</a>
				</li>

				<li>
					<a href="contacts.php">
						<div class="parent-icon"><i class="lni lni-atlassian"></i></div>
						<div class="menu-title">Contacts</div>
					</a>
				</li>


				<li>
					<a href="application.php">
						<div class="parent-icon"><i class="lni lni-android-original"></i></div>
						<div class="menu-title">Application</div>
					</a>
				</li>
           
            
        <?php 
        } else {  // If the user is not an admin
        ?>

                <li>
					<a href="studentDetail.php?id=<?php echo $_SESSION['id']; ?>">
						<div class="parent-icon"><i class="lni lni-user"></i></div>
						<div class="menu-title">Profile</div>
					</a>
				</li>
            
        <?php 
        } 
        ?>
    </ul>
</div>
