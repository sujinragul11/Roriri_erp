<?php 
session_start();
include("../db/dbConnection.php");
include("../url.php");
$selQuery = "SELECT
                a.*,
                b.course_name,
                c.name AS empName
            FROM
                `trainee_mini_project` AS a
            LEFT JOIN `academy_course_details` AS b
            ON
                a.course_id = b.id
            LEFT JOIN `basic_details` AS c
            ON
                a.updated_by = c.id
            WHERE
                a.status = 'Active'";
$resQuery = mysqli_query($conn , $selQuery); 

?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php
        if ($_SESSION['role'] == '10' || $_SESSION['is_admin'] == 'True') {
            include("top.php");
        } else {
            include("../RoririSoftware/top.php");
        }
        ?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php
        if ($_SESSION['role'] == '10' || $_SESSION['is_admin'] == 'True') {
            include("left.php");
        } else {
            include("../RoririSoftware/left.php");
        }
        ?>
		<!--end header -->
        
		<!--start page wrapper -->
		<div class="page-wrapper">
        <div class="page-content">
                
				
                <div class="page-title-box">
                    
                    <div class="page-title-right">
                        <h4 class="page-title">Mini Project</h4>
                        <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                                        <button type="button" id="addProjectBtn" class="btn btn-primary position-absolute end-0" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                                            Add  Mini Project
                                        </button>
                        </div>
    
                    </div>
                       
                </div>
    
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4">
                        <div class="col-md-2">
                            <label for="courseFilter">Course Name</label>
                            <select id="courseFilter" class="form-control">
                                <option value="">--Select the Course--</option>
                                <?php
                                $queryCou = "SELECT id, course_name FROM academy_course_details WHERE status = 'Available'";
                                $resultCou = mysqli_query($conn, $queryCou);

                                if ($resultCou) {
                                    while ($row = mysqli_fetch_assoc($resultCou)) {
                                        $courseId = $row['id'];
                                        $courseName = $row['course_name'];

                                        echo "<option value=\"$courseId\">$courseName</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>  
                        
                        <div class="col-md-2">
                            <label for="empFilter">Employee Name</label>
                            <select id="empFilter" class="form-control">
                                <option value="">--Select the Employee--</option>
                                <?php
                                    $sqlPerson2 = "SELECT
                                                        a.`id`,
                                                        a.`name`  
                                                    FROM
                                                        `basic_details` AS a
                                                    LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                                    LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                                    WHERE
                                                        a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                                $resultPer2 = $conn->query($sqlPerson2);
                                while ($row = $resultPer2->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
              

                        <div class="col-md-1 mt-3 pt-1">
                            <button id="filterBtn" class="btn btn-primary">Apply</button>
                        </div>
                        <div class="col-md-1 mt-3 pt-1">
                            <button id="clearBtn" class="btn btn-primary">Reset</button>
                        </div>
                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <div class="table-responsive">      
                                        <table id="example3" class="table table-responsive table-striped table-bordered w-100" style="display:none;">
                                    <thead>
                                        <tr role="row">
                                            <th class="col-1 text-center">S. No</th>
                                            <th class="col-1 text-center">Course Name</th>
                                            <th class="col-2 text-center">Project Name</th>
                                            <th class="col-1 text-center">Duration</th>
                                            <th class="col-5 text-center">Description</th>
                                            <th class="col-1 text-center">Created By</th>
                                            <th class="col-1 text-center">Action</th></tr>
                                    </thead>
                              
                                    <tbody>
                                    <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                    $projectId = $row['project_id'];
                                    $project_name = $row['project_name'];
                                    $duration = $row['duration'];
                                    $description = $row['description'];
                                    $course       = $row['course_name'];
                                    $createdBy    = $row['empName'];
                                    ?>
                                      <tr class="odd">
                                      <td class="col-1 text-center align-middle"><?php echo $i; $i++; ?></td>
                                      <td class="col-1 text-center align-middle"><?php echo $course; ?></td>
                                      <td class="col-2 text-wrap align-middle"><?php echo $project_name; ?></td>
                                      <td class="col-1 text-center align-middle"><?php echo $duration; ?> Hrs</td>
                                      <td class="col-5 text-wrap align-middle"><?php echo $description; ?></td>
                                      <td class="col-1 text-center align-middle"><?php echo $createdBy; ?></td>
                                      <td class="col-1 text-center align-middle">
                                          <button type="button" class="btn btn-sm btn-outline-warning modalBtn" onclick="goEditProject(<?php echo $projectId; ?>);" data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                            <i class='bx bx-pencil'></i>
                                          </button>
                                          <button class="btn btn-sm btn-outline-danger" onclick="goDeleteProject(<?php echo $projectId; ?>);"><i class="bx bx-trash"></i></button>
                                          
                                      </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                </table>
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
$(document).ready(function() {
    // Show loader
   
    $('#example3').hide(); // Hide the table initially
   
    // Initialize DataTable
    var table = $('#example3').DataTable({
        "paging": true, // Enable pagination
        "ordering": true, // Enable sorting
        "searching": true, // Enable searching
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "processing": true, // Show processing indicator
        "drawCallback": function() {
           
            $('#example3').show();
        }
    });
    
    $('#clearBtn').click(function () {
        // Clear all input fields
        $('#courseFilter').val('');
        $('#empFilter').val('');
    });
    
    $('#filterBtn').on('click', function () {

    // Retrieve filter values
    var courseFilter = $('#courseFilter').val();
    var empFilter = $('#empFilter').val();

    // Validate if all filters are empty
    // if (!reportStartDate && !endDate && !duration && !course && !slot) {
    //     alert("Please select at least one filter to proceed.");
    //     return; // Stop further execution
    // }

    // Perform AJAX request
    $.ajax({
        url: 'action/actMiniProject.php', 
        type: 'GET',
        data: {
            courseFilter: courseFilter,
            empFilter: empFilter
        },
        dataType: 'json',
        success: function (data) {
            // Destroy and refresh the DataTable
            $('#example3').DataTable().destroy();
            $('#example3 tbody').empty();

            // Append rows dynamically based on returned data
            data.forEach(function (item, index) {

                const rowHTML = `
                    <tr>
                        <td class="col-1 text-center align-middle">${index + 1}</td> 
                        <td class="col-1 text-center align-middle">${item.course_name}</td> 
                        <td class="col-2 text-wrap align-middle">${item.project_name}</td> 
                        <td class="col-1 text-center align-middle">${item.duration}</td>
                        <td class="col-5 text-wrap align-middle">${item.description}</td>
                        <td class="col-1 text-center align-middle">${item.empName}</td> 
                        <td class="col-1 text-center align-middle">
                            <button type="button" class="btn btn-sm btn-outline-warning modalBtn" onclick="goEditProject(${item.project_id});" data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                <i class='bx bx-pencil'></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="goDeleteProject(${item.project_id});"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>`;

                // Append the new row
                $('#example3 tbody').append(rowHTML);
            });

            // Reinitialize the DataTable
           var table = $('#example3').DataTable({
                "paging": true, // Enable pagination
                "ordering": true, // Enable sorting
                "searching": true, // Enable searching
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing": true, // Show processing indicator
                "drawCallback": function() {
                   
                    $('#example3').show();
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("An error occurred while processing the request.");
        }
    });
});

});
</script>
    <script>
    function resetForm(formId) {
            document.getElementById(formId).reset(); // Reset the form
        }
    $(document).ready(function () {
          $('#addProjectBtn').click(function () {
            resetForm('frmAddProject'); // Reset the form
          });
  
  $('#frmAddProject').off('submit').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting normally

    var formData = new FormData(this);
    $.ajax({
      url: "action/actMiniProject.php",
      method: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        // Handle success response
        console.log(response);
        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message,
            timer: 2000
          }).then(function() {
            resetForm('frmAddProject');
            $('#addProjectModal').modal('hide');
                    var table = $('#example3').DataTable();
                    var currentPage = table.page();

                    // Destroy and recreate the table
                    table.destroy();
                    $('#example3').load(location.href + ' #example3 > *', function() {
                        $('#example3').DataTable({
                            "paging": true, // Enable pagination
                            "ordering": true, // Enable sorting
                            "searching": true, // Enable searching
                        }).page(currentPage).draw(false); // Show the same page
                    });
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
          });
        }
      },
      error: function(xhr, status, error) {
        // Handle error response
        console.error(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while adding Project data.'
        });
        // Re-enable the submit button on error
        $('#submitBtn').prop('disabled', false);
      }
    });
  });
});
// ajax edit course
function goEditProject(editId) {
    $.ajax({
        url: 'action/actMiniProject.php',
        method: 'POST',
        data: { editId: editId },
        dataType: 'json',
        success: function(response) {
            $('#editId').val(response.project_id);
            $('#courseEdit').val(response.course_id);
            $('#projectNameEdit').val(response.project_name);
            $('#durationEdit').val(response.duration);
            $('#descriptionEdit').val(response.description);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    $('#frmEditProject').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this);
        $.ajax({
            url: "action/actMiniProject.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                // Handle success response

                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#editProjectModal').modal('hide'); // Close the modal

                        $('.modal-backdrop').remove(); // Remove the backdrop
                        var table = $('#example3').DataTable();
                        var currentPage = table.page();
    
                        // Destroy and recreate the table
                        table.destroy();
                        $('#example3').load(location.href + ' #example3 > *', function() {
                            $('#example3').DataTable({
                                "paging": true, // Enable pagination
                                "ordering": true, // Enable sorting
                                "searching": true, // Enable searching
                            }).page(currentPage).draw(false); // Show the same page
                        });
                        resetForm('frmEditProject');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while Edit Project data.'
                });
                // Re-enable the submit button on error
                $('#updateBtn').prop('disabled', false);
            }
        });
    });
});
// delete the course
function goDeleteProject(deleteId) {
    //alert(id);
    if (confirm("Are you sure you want to delete Mini Project?")) {
        $.ajax({
            url: 'action/actMiniProject.php',
            method: 'POST',
            data: {
                deleteId: deleteId
            },
            //dataType: 'json', // Specify the expected data type as JSON
            success: function(response) {
                    var table = $('#example3').DataTable();
                    var currentPage = table.page();

                    // Destroy and recreate the table
                    table.destroy();
                    $('#example3').load(location.href + ' #example3 > *', function() {
                        $('#example3').DataTable({
                            "paging": true, // Enable pagination
                            "ordering": true, // Enable sorting
                            "searching": true, // Enable searching
                        }).page(currentPage).draw(false); // Show the same page
                    });


            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error('AJAX request failed:', status, error);
            }
        });
    }
}
</script>
<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>
</html>
<?php include("formMiniProject.php"); ?>
