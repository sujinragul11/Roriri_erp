<?php include("C:\\xampp\\htdocs\\ERP\\db\\dbConnection.php");
include("../url.php");
$selQuery = "SELECT *
      FROM application_tbl
      WHERE application_tbl.application_status='Active'";
$resQuery = mysqli_query($conn , $selQuery); 
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>
<style>
        .section {
            padding: 10px;
            border: 1px solid #ccc;
            margin: 5px;
            overflow-y: auto;
            height: 100%; /* Fill the available height */
        }
        .card {
            margin: 5px 0;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ccc;
            cursor: grab;
        }
        .dragging {
            opacity: 0.5;
        }
    </style>
<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php include("left.php");?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
        
		<!--start page wrapper -->
		<div class="page-wrapper">
        <div class="page-content">
                
				
                <div class="page-title-box">
                    <?php 
                    $i = 1; 
                    $displayedSubjects = array(); // Array to keep track of displayed subjects

                    while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) { 
                        $id = $row['application_id']; 
                        $application_subject = $row['application_subject'];

                        // Check if the subject has already been displayed
                        if (in_array($application_subject, $displayedSubjects)) {
                            continue; // Skip this iteration if the subject name has already been displayed
                        }

                        $displayedSubjects[] = $application_subject; // Add the subject name to the array of displayed subjects
                        ?>
                        <button class="btn btn-circle btn-success text-white modalBtn" onclick="goApplication(<?php echo $id; ?>);" style="width:100px;"><?php echo htmlspecialchars($application_subject, ENT_QUOTES, 'UTF-8'); ?></button>
                    <?php 
                    } 
                    ?>
   
                    <div class="page-title-right">
                        <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
						

                        </div>
                        <div id="studentDetail"></div>
    </div>
                    </div>
                       
                </div>
    
                
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap5">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                       
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="example2_filter" class="dataTables_filter">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                        <div class="col-sm-12">
            </div>
        </div>
        
        <div class="row">
            
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
               
            </div>
        </div>
    </div>
</div>
                            </div>
                        </div>
                    </div>
                    
</div>
                </div>
                
		</div>
    
		<!--end page wrapper -->
		<!--start overlay-->
		 <div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright Â© 2024. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->


	<!-- search modal -->
    <div class="modal" id="SearchModal" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
		  <div class="modal-content">
			<div class="modal-header gap-2">
			  <div class="position-relative popup-search w-100">
				<input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search" placeholder="Search">
				<span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i class='bx bx-search'></i></span>
			  </div>
			  <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="search-list">
				   <p class="mb-1">Html Templates</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action active align-items-center d-flex gap-2 py-1"><i class='bx bxl-angular fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vuejs fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-magento fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-shopify fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Web Designe Company</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-windows fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-dropbox fs-4' ></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-opera fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-wordpress fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Software Development</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-mailchimp fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-zoom fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-sass fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vk fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Online Shoping Portals</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-slack fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-skype fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-twitter fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vimeo fs-4'></i>eCommerce Html Templates</a>
				   </div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
    <!-- end search modal -->




	<!--start switcher-->
	<div class="switcher-wrapper">
		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr/>
			<h6 class="mb-0">Theme Styles</h6>
			<hr/>
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
					<label class="form-check-label" for="lightmode">Light</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
					<label class="form-check-label" for="darkmode">Dark</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
					<label class="form-check-label" for="semidark">Semi Dark</label>
				</div>
			</div>
			<hr/>
			<div class="form-check">
				<input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
				<label class="form-check-label" for="minimaltheme">Minimal Theme</label>
			</div>
			<hr/>
			<h6 class="mb-0">Header Colors</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator headercolor1" id="headercolor1"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor2" id="headercolor2"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor3" id="headercolor3"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor4" id="headercolor4"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor5" id="headercolor5"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor6" id="headercolor6"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor7" id="headercolor7"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor8" id="headercolor8"></div>
					</div>
				</div>
			</div>
			<hr/>
			<h6 class="mb-0">Sidebar Colors</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end switcher-->
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        initializeDragAndDrop();
    });

    function initializeDragAndDrop() {
        const draggables = document.querySelectorAll('.card');
        const sections = document.querySelectorAll('.section');

        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });

            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
                refreshSyllabusOrder();
            });
        });

        sections.forEach(section => {
            section.addEventListener('dragover', e => {
                e.preventDefault();
                const draggingCard = document.querySelector('.dragging');
                section.appendChild(draggingCard);
            });

            section.addEventListener('drop', e => {
                e.preventDefault();
                const draggingCard = document.querySelector('.dragging');
                section.appendChild(draggingCard);
                updateDatabase(draggingCard.getAttribute('data-id'), section.id);
            });
        });

        function refreshSyllabusOrder() {
            const syllabusSection = document.getElementById('syllabus');
            const syllabusCards = syllabusSection.querySelectorAll('.card');
            syllabusCards.forEach((card, index) => {
                // Update data or perform other operations if needed
            });
        }

        function updateDatabase(topicId, sectionId) {
            const formData = new FormData();
            formData.append('evaluation_id', topicId);
            formData.append('section', sectionId);

            fetch('applicationUpdate.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                // Refresh sections after updating database
                // location.reload();
            })
            .catch(error => console.error('Error updating database:', error));
        }
    }
</script>
<script>
   function goApplication(id) {
    alert(id);
    $.ajax({
        url: 'applicationDetails.php',
        method: 'POST',
        data: {
            id: id
        },
        success: function(response) {
            $('#StuContent').hide();
            $('#studentDetail').html(response);

            // After loading student details, initialize drag-and-drop
            initializeDragAndDrop();
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

function initializeDragAndDrop() {
    const draggables = document.querySelectorAll('.card');
    const sections = document.querySelectorAll('.section');

    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', () => {
            draggable.classList.add('dragging');
        });

        draggable.addEventListener('dragend', () => {
            draggable.classList.remove('dragging');
        });
    });

    sections.forEach(section => {
        section.addEventListener('dragover', e => {
            e.preventDefault();
            const afterElement = getDragAfterElement(section, e.clientY);
            const draggingCard = document.querySelector('.dragging');
            if (afterElement == null) {
                section.appendChild(draggingCard);
            } else {
                section.insertBefore(draggingCard, afterElement);
            }
        });

        section.addEventListener('drop', e => {
            e.preventDefault();
            const draggingCard = document.querySelector('.dragging');
            updateDatabase(draggingCard.getAttribute('data-id'), section.id);
        });
    });
}

function getDragAfterElement(section, y) {
    const draggableElements = [...section.querySelectorAll('.card:not(.dragging)')];

    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

function updateDatabase(topicId, sectionId) {
    const formData = new FormData();
    formData.append('id', topicId);
    formData.append('section', sectionId);

    fetch('applicationUpdate.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
                    console.log(data);
                    // Refresh sections after updating database
                    // location.reload();
                })
                .catch(error => console.error('Error updating database:', error));
}

</script>
<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>
<?php include("addTopic.php");?>
<?php include("editTopic.php");?>