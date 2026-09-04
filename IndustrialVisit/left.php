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
					<h4 class="logo-text">Industrial Visit</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			</div>
    <!-- navigation -->
    <ul class="metismenu" id="menu">
        <?php 
        if ($_SESSION['is_admin'] === 'True') {  
        ?>
                 
            <li>
                <a href="dashboard.php">
                <div class="parent-icon"><i class="lni lni-home me-2"></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            
            <li>
                <a href="client.php">
                <div class="parent-icon"><i class="lni lni-users me-2"></i></div>
                    <div class="menu-title">Client Details</div>
                </a>
            </li>
            
            <li>
                <a href="food.php">
                <div class="parent-icon"><i class="lni lni-dinner me-2"></i></div>
                    <div class="menu-title">Food Packages</div>
                </a>
            </li>

            <li>
                <a href="payment.php">
                <div class="parent-icon"><i class="lni lni-credit-cards me-2"></i></div>
                    <div class="menu-title">Payment Details</div>
                </a>
            </li>
            
            <li>
                <a href="enquiry.php">
                <div class="parent-icon"><i class="lni lni-question-circle me-2"></i></div>
                    <div class="menu-title">Enquiry</div>
                </a>
            </li>
            
            <li>
                <a href="registration.php">
                <div class="parent-icon"><i class="lni lni-pencil-alt me-2"></i></div>
                    <div class="menu-title">Registration Details</div>
                </a>
            </li>
            
            <li>
                <a href="banner.php">
                <div class="parent-icon"><i class="lni lni-image me-2"></i></div>
                    <div class="menu-title">Banner</div>
                </a>
            </li>
            
        <?php 
        } 
        ?>

    </ul>
</div>