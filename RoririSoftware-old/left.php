<div class="sidebar-wrapper" data-simplebar="true">
<div class="sidebar-header">
                <?php if ($_SESSION['is_admin'] === 'True'): ?>
                <a href="../index.php">
                <?php endif; ?>
                	<div>
                		<img src="../assets/img/Logo Roriri.png" class="logo-icon" alt="RORIRI">
                	</div>
                <?php if ($_SESSION['is_admin'] === 'True'): ?>
                </a>
                <?php endif; ?>
				<div>
					<h4 class="logo-text">RORIRI</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			</div>
    <!-- navigation -->
    <ul class="metismenu" id="menu">
        <?php 
        if ($_SESSION['is_admin'] === 'True') {  // Check if the user is an admin
        ?>
                 
            <li >
                <a href="index.php">
                <div class="parent-icon"><i class="lni lni-home me-2"></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>



            <li >
                <a href="enquire.php">
                <div class="parent-icon"><i class="lni lni-customer me-2"></i></div>
                    <div class="menu-title">Enquiry</div>
                </a>
            </li>
            

            
            <li >
                <a href="employee.php">
                <div class="parent-icon"><i class="lni lni-users me-2"></i></div>
                    <div class="menu-title">Employee</div>
                </a>
            </li>


            
            <li >
                <a href="clients.php">
                <div class="parent-icon"><i class="lni lni-customer me-2"></i></div>
                    <div class="menu-title">Clients</div>
                </a>
            </li>


            <li >
                <a href="project.php">
                <div class="parent-icon"><i class="lni lni-notepad me-2"></i></div>
                    <div class="menu-title">Project</div>
                </a>
            </li>

           

            <li >
                <a href="attendance.php">
                <div class="parent-icon"><i class="lni lni-checkmark-circle me-2"></i></div>
                    <div class="menu-title">Attendance</div>
                </a>
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
                <a href="../NexGen_IT_Academy/trainee.php">
                <div class="parent-icon"><i class="lni lni-graduation me-2"></i></div>
                    <div class="menu-title">Trainee</div>
                </a>
            </li>

            <li >
                <a href="../RoririSoftware/coordinator.php">
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
			
            
             
        <?php 
        } 
        ?>
    </ul>
</div>
