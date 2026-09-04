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
					<h4 class="logo-text">IT Internship</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
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

				<li class="menu-label">Elements</li>
				<li>
					<a href="internship.php">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Home</div>
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
					<a href="internTask.php">
						<div class="parent-icon"><i class='bx bx-code-alt'></i>
						</div>
						<div class="menu-title">Task</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>