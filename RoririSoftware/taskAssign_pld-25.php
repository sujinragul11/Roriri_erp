<?php

session_start();

include("../db/dbConnection.php");

include("../url.php");


?>

<!doctype html>

<html lang="en">



<?php include("head.php");?>



<body>
    <style>
/* Default desktop styles */
.task-board-container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

.task-column {
    width: 45%;
    border: 2px solid #ccc;
    padding: 10px;
    min-height: 300px;
    background-color: #f9f9f9;
}

.task-card {
    border: 1px solid #ddd;
    padding: 10px;
    margin: 10px 0;
    background-color: #fff;
    cursor: move;
}

.task-card.dragging {
    opacity: 0.5;
}

.task-column.drop-target {
    background-color: #e9e9e9;
    border: 2px dashed #007bff;
}

/* Mobile styles */
@media (max-width: 768px) {
    .task-board-container {
        flex-direction: column;
        align-items: center;
        padding: 10px;
    }

    .task-column {
        width: 90%;
        margin-bottom: 15px;
        min-height: 250px;
    }
    
    .task-card {
        margin: 10px 0;
        font-size: 14px; /* Make text a bit smaller */
    }

    .task-column.drop-target {
        background-color: #f1f1f1;
        border: 2px dashed #007bff;
    }
}

/* Very small screen (like mobile phones in portrait mode) */
@media (max-width: 480px) {
    .task-card {
        font-size: 12px; /* Make text even smaller on very small screens */
        padding: 8px;
    }

    .task-column {
        width: 100%;
        min-height: 200px;
    }
}

    </style>


	<!--wrapper-->

	<div class="wrapper">

		<!--sidebar wrapper -->

			<?php include("left.php");?>

		<!--end sidebar wrapper -->

		<!--start header -->

			<?php include("top.php");?>

		<!--end header -->

		<!--start page wrapper -->

        <?php include("assignTaskForm.php");?>

		

		<div class="page-wrapper">
		    
	

			<div class="page-content">

                

				

            <div class="page-title-box">

                

                <div class="page-title-right">

                    <h2 class="page-title">Task Assign</h2>

                    <div class="position-relative mb-2" style="height: 40px;"> <!-- Adjust height as needed -->
                     <?php
                        //   $trainerRoles = [17]; // Define the Admin of roles
                        //   if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') 
                        //   {
                         ?>


                    <button type="button" id="addEnquireBtn" class="btn btn-primary position-absolute top-0 end-0 " data-bs-toggle="modal" data-bs-target="#addReportModal"><i class="lni lni-plus"></i>New </button>
                
                      <?php 
                    //   }
                      ?>
             
                    </div>



                </div>

                   

            </div>



				<div class="card">

					<div class="card-body">

	
   

    <div class="task-board-container">
    <!-- Left Column for Active Tasks -->
    <div class="task-column" id="activeTasks">
        <h3>Active Tasks</h3>
        <!-- Tasks will be injected here -->
    </div>

    <!-- Right Column for Completed Tasks -->
    <div class="task-column" id="completedTasks">
        <h3>Completed Tasks</h3>
        <!-- Completed Tasks will be dropped here -->
    </div>
</div>

					</div>

				</div>

			</div><!--end page-content-->

		</div>

			

		<!--end page wrapper -->
		
		

		<!--start overlay-->

		 <?php include("footer.php"); ?>

	</div>

	<!--end wrapper-->

	  <div id="loader" style="display:none;">
    <div class="loader-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>



	<!--start switcher-->



	<!--end switcher-->

	<!-- Bootstrap JS -->

	<!-- Bootstrap JS -->

	<script src="<?php echo $bootsrapBundle; ?>"></script>

	<!--plugins-->

	<script src="<?php echo $js; ?>"></script>

	<script src="<?php echo $simplebar;?>"></script>

	<script src="<?php echo $mentimenu; ?>"></script>

	<script src="<?php echo $perfectScrolbar; ?>"></script>

	<script src="<?php echo $datatableMin; ?>"></script>

	<script src="<?php echo $datatbaleBootstrap;?>"></script>

     <!-- Include Bootstrap JS (with Popper) -->

    <script src="<?php echo $popper;?>"></script>

    <script src="<?php echo $bootStackPath;?>"></script>

	<script src="<?php echo $sweetalert; ?>"></script>
	<script src="<?php echo $select2; ?>"></script>
	<script src="<?php echo $select2Custom;?>"></script>

     <!-- Include the function.js -->

     
     <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

	<!--app JS-->

	<script src="<?php echo $app; ?>"></script>

<script src="../assets/js/form-validation.js"></script>
</body>



</html>


<script>

 function loadAjaxData(){
        
        var id =<?php echo $_SESSION['id'] ?>
    // AJAX call to fetch tasks
    $.ajax({
        url: 'action/actTaskAssign.php', // Replace with your actual API endpoint
        type: 'GET',
        data: {"getData":"getData" ,
            id :id
        },
        dataType: 'json',
        success: function (response) {
            // Assume response is an array of task objects
            response.forEach(task => {
                // Call addTask for each task item
                addTask(task.id ,task.category, task.subcategory, task.date, task.task ,task.task_status ,task.name);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching tasks:', error);
        }
    });
    }


    // Call the AJAX function on page load
$(document).ready(function () {
    
    loadAjaxData()
    
   
    
    
    
      document.getElementById('addDepartment').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    var form = this;
    
    // Set the content of the hidden textarea to the Quill editor content
    $('#description').val(quill.root.innerHTML);

    // Check form validity, including the textarea updated with the editor content
    if (!this.checkValidity() || !quill.getText().trim()) {
        $(this).addClass('was-validated');
        
        // Custom validation feedback for Quill editor
        if (!quill.getText().trim()) {
            $('#editor').addClass('is-invalid'); // Add an invalid class to the editor if empty
            $('#editor').siblings('.invalid-feedback').show();
        } else {
            $('#editor').removeClass('is-invalid'); // Remove the invalid class if content is present
            $('#editor').siblings('.invalid-feedback').hide();
        }
        return; // Stop the submission
    }
  
var formData = new FormData(form);

// Show the loader before sending the request
$('#loader').show();



$.ajax({
    url: 'action/actTaskAssign.php',
    type: 'POST',
    data: formData,
    dataType: 'json', // Specify the expected data type as JSON
    processData: false, // Prevent jQuery from processing the data
    contentType: false, // Allow the content type to be set automatically (multipart/form-data)
    success: function (response) {
        // Hide the loader when the request completes
        $('#loader').hide();

        if (response.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
                timer: 1000
            }).then(function() {
                $('#addReportModal').modal('hide'); // Close the modal
                $('.modal-backdrop').remove(); // Remove the backdrop

               // Remove any modal-related styles or classes
                    $('body').removeClass('modal-open').css('overflow', '');

                window.location.reload();  // This will reload the page

             
                    
            });
            
            form.reset();
            quill.root.innerHTML = ''; // Clear Quill editor content
            form.classList.remove('was-validated'); // Reset validation styling
        } else {
            // Hide the loader if there's an error
            $('#loader').hide();
            // Show error message from response
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message
            });
        }
    },
    error: function (error) {
        // Hide the loader if there's an error
        $('#loader').hide();
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
    }
});
});

});

// Initialize Quill editor
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['link', 'blockquote', 'code-block', 'image'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['clean']
        ]
    }
});



function updateTaskStatus(taskId, newStatus) {
    $.ajax({
        url: 'action/actTaskAssign.php', // Replace with your actual API endpoint for updating status
        type: 'POST',
        dataType: 'json', // Specify the expected data type as JSON
        data: {
            drag_id: taskId,
            drag_status: newStatus
        },
        success: function (response) {
            // Handle success response
            if (response.success) {
                console.log(`Task ${taskId} status updated to ${newStatus}`);
                 loadAjaxData();
            } else {
                console.error('Failed to update task status:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error updating task status:', error);
        }
    });
}

 
</script>

<script>
// Variables to hold task data and the dragged task
let draggedTask = null;

// Allow drop function to enable dragging over valid targets
function allowDrop(e) {
    e.preventDefault();
    
}

// Handle drag start
function dragStart(e) {
    draggedTask = e.target;
    draggedTask.classList.add('dragging');
    e.dataTransfer.setData("text", draggedTask.dataset.id); // Store task id in dataTransfer
}

// Handle drag end
function dragEnd(e) {
    e.target.classList.remove('dragging');
    draggedTask = null; // Clear dragged task after drop
}

// Add event listeners for dragging and dropping
const columns = document.querySelectorAll('.task-column');
columns.forEach(column => {
     column.addEventListener('dragover', allowDrop); // For desktop
    column.addEventListener('drop', dropTask); // For desktop
    column.addEventListener('touchstart', touchStart); // For mobile
    column.addEventListener('touchmove', touchMove); // For mobile
    column.addEventListener('touchend', touchEnd); // For mobile
});


// Handle touch events for drag (for mobile)
function touchStart(e) {
    draggedTask = e.target;
    draggedTask.classList.add('dragging');
    e.preventDefault();
}

function touchMove(e) {
    if (draggedTask) {
        const touch = e.touches[0]; // Get the touch position
        draggedTask.style.position = 'absolute';
        draggedTask.style.left = touch.pageX - draggedTask.offsetWidth / 2 + 'px';
        draggedTask.style.top = touch.pageY - draggedTask.offsetHeight / 2 + 'px';
    }
}

function touchEnd(e) {
    if (draggedTask) {
        const targetColumn = e.target.closest('.task-column');
        if (targetColumn) {
            const newStatus = targetColumn.id === 'completedTasks' ? 'Complete' : 'In Progress';
            targetColumn.appendChild(draggedTask);
            updateTaskStatus(draggedTask.dataset.id, newStatus);
        }
        draggedTask = null;
    }
}



// Handle the drop event and update status
function dropTask(e) {
    e.preventDefault();

    // Ensure the target is the task column itself, not a child element inside it
    const targetColumn = e.target.closest('.task-column'); // This will ensure the parent task-column is selected

    // Check if the task was dropped on a valid column
    if (!targetColumn) return;

    // Determine the new status based on the target column
    const newStatus = targetColumn.id === 'completedTasks' ? 'Complete' : 'In Progress';

    // Append the dragged task to the target column
    targetColumn.appendChild(draggedTask);

    // Get the task ID
    const taskId = draggedTask.dataset.id;

    // Update the task's status with AJAX
    updateTaskStatus(taskId, newStatus);

    // Clear the dragged task variable
    draggedTask = null;
}

// Add auto-scroll when dragging tasks near the top or bottom of the viewport
document.addEventListener('dragover', function (event) {
    const scrollThreshold = 50; // Distance from the edge to trigger scrolling
    const scrollSpeed = 10;     // Scroll speed

    if (event.clientY < scrollThreshold) {
        // Scroll up
        window.scrollBy(0, -scrollSpeed);
    } else if (window.innerHeight - event.clientY < scrollThreshold) {
        // Scroll down
        window.scrollBy(0, scrollSpeed);
    }
});


// Function to create a task card and add it to the appropriate column based on the status
function createTask(id ,category, subcategory, taskDate, taskName, status ,name) {
    const taskCard = document.createElement('div');
    taskCard.classList.add('task-card');
    taskCard.setAttribute('draggable', 'true');
    taskCard.dataset.id = id; // Set the task ID as a data attribute
    taskCard.dataset.status = status || 'active'; // Default to 'active' if no status is provided
    taskCard.dataset.date = taskDate;
    taskCard.innerHTML = `
        <h5>${category}</h5>
        <p>Subcategory: ${subcategory}</p>
        <p>Task: ${taskName}</p>
        <p>Date: ${taskDate}</p>
        <p>Name: ${name}</p>
        <p>Status: ${status}</p>
    `;

    // Add drag events if needed
    taskCard.addEventListener('dragstart', dragStart);
    taskCard.addEventListener('dragend', dragEnd);

    // Select the target column based on the task status
    const targetColumn = (status && status.toLowerCase() === 'complete') ? 
                         document.getElementById('completedTasks') : 
                         document.getElementById('activeTasks');

    // Append the task card to the determined column
    targetColumn.appendChild(taskCard);
}

// Function to add a task card by calling `createTask`
function addTask(id ,category, subcategory, taskDate, taskName, status ,name) {
    createTask(id ,category, subcategory, taskDate, taskName, status ,name);
}



  // Load subcategories when a category is selected
    $('#category').on('change', function() {
        let categoryId = $(this).val();
        $('#subcategory').empty().append('<option value="">--Select Subcategory--</option>');
        $('#task').empty().append('<option value="">--Select Task--</option>'); // Reset task dropdown
        $('#hours').val('');

        if (categoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_category_id: categoryId },
                success: function(response) {
                    let subcategories = response.subcategories;
                    $.each(subcategories, function(index, subcategory) {
                        $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.subcategory + '</option>');
                    });
                }
            });
        }
    });

    // Load tasks when a subcategory is selected
    $('#subcategory').on('change', function() {
        let subcategoryId = $(this).val();
        $('#task').empty().append('<option value="">--Select Task--</option>');
        $('#hours').val('');

        if (subcategoryId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_subcategory_id: subcategoryId },
                success: function(response) {
                    let tasks = response.tasks;
                    $.each(tasks, function(index, task) {
                        $('#task').append('<option value="' + task.id + '">' + task.task + '</option>');
                    });
                }
            });
        }
    });
    
    
    
      // Load tasks when a subcategory is selected
    $('#task').on('change', function() {
        let taskId = $(this).val();

        if (taskId) {
            $.ajax({
                url: 'action/actDailyReport.php',
                method: 'POST',
                dataType: 'json', // Ensure JSON dataType
                data: { get_task_id: taskId },
                success: function(response) {
                    let hours = response.hours;
                    
                    $('#hours').val(hours);
                    
                }
            });
        }
        $('#hours').val('');
    });
    
    
    



</script>




