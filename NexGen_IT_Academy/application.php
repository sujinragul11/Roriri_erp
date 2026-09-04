<?php 
include("C:\\xampp\\htdocs\\ERP\\db\\dbConnection.php");
include("../url.php");
// $courseid = $_SESSION['courseid'];
// $userId = $_SESSION['user_id'];

$selQuery = "SELECT *
      FROM application_tbl
      WHERE application_tbl.application_status='Active' 
      AND application_tbl.course_id = '$courseid'";
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
                        $level = $row['level'];
                        ?>
                        <button class="btn btn-circle btn-success text-white modalBtn" onclick="goApplication(<?php echo $id; ?>);" style="width:100px;"><?php echo htmlspecialchars($level, ENT_QUOTES, 'UTF-8'); ?></button>
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
		<?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->

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