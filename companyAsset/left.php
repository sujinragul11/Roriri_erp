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
                 
            <li>
                <a href="dashboard.php">
                <div class="parent-icon"><i class="lni lni-home me-2"></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            
            <li>
                <a href="category.php">
                <div class="parent-icon"><i class="lni lni-folder me-2"></i></div>
                    <div class="menu-title">Category</div>
                </a>
            </li>

            <li>
                <a href="room.php">
                <div class="parent-icon"><i class="lni lni-apartment me-2"></i></div>
                    <div class="menu-title">Room</div>
                </a>
            </li>
            
            <li>
                <a href="vendor.php">
                <div class="parent-icon"><i class="lni lni-users me-2"></i></div>
                    <div class="menu-title">Vendor Details</div>
                </a>
            </li>

            <li>
                <a href="assetDetails.php">
                <div class="parent-icon"><i class="lni lni-display me-2"></i></div>
                    <div class="menu-title">Asset Details</div>
                </a>
            </li>
            
            <li>
                <a href="service.php">
                <div class="parent-icon"><i class="lni lni-cog me-2"></i></div>
                    <div class="menu-title">Service Details</div>
                </a>
            </li>
            
        <?php 
        } 
        ?>

    </ul>
</div>