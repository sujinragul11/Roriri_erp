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
					<h4 class="logo-text">Expenses</h4>
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
                <div class="parent-icon"><i class="lni lni-dashboard me-2"></i></div>
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
                <a href="subCategory.php">
                <div class="parent-icon"><i class="lni lni-layers me-2"></i></div>
                    <div class="menu-title">Sub Category</div>
                </a>
            </li>
            
            <li>
                <a href="expense.php">
                <div class="parent-icon"><i class="lni lni-coin me-2"></i></div>
                    <div class="menu-title">Expenses</div>
                </a>
            </li>

            <li>
                <a href="expenseReport.php">
                <div class="parent-icon"><i class="lni lni-stats-up me-2"></i></div>
                    <div class="menu-title">Expense Report</div>
                </a>
            </li>
            
            <li>
                <a href="futureExpense.php">
                <div class="parent-icon"><i class="lni lni-calendar me-2"></i></div>
                    <div class="menu-title">Future Expense</div>
                </a>
            </li>
            
        <?php 
        } 
        ?>

    </ul>
</div>