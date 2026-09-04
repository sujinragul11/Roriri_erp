<?php 
session_start();
include("../db/dbConnection.php");
include("../url.php"); 
include("action/function.php");
 $subject_id =$_GET['syllabusId'];
//  $traineeId =$_GET['traineeId'];
 
//  $user_id = $_SESSION['id'];

if(isset($_GET['traineeId']) && $_GET['traineeId'] != ''){
    $trainee_id = $_GET['traineeId'];
    $verified_id = $_SESSION['id'];
}else{
    $trainee_id = $_SESSION['id'];
    // $verified_id = $user_id;
}

function checkApplication($id, $conn,$course_id,$user_id) {
    global $verified_id1; // Declare the global variable inside the function
    $sql_track = "
     SELECT 
        jt.status,
        jt.verified_id,
        jt.role
    FROM 
        syllabus_track AS a,
        JSON_TABLE(a.syl_track_details, '$[*]' COLUMNS (
            syllabus_id VARCHAR(255) PATH '$.syllabus_id',
            course_id VARCHAR(255) PATH '$.course_id',
            verified_id VARCHAR(255) PATH '$.verified_id',
            status VARCHAR(255) PATH '$.status',
            role VARCHAR(255) PATH '$.role',
            timestamp VARCHAR(255) PATH '$.timestamp'
        )) AS jt
    WHERE 
        jt.syllabus_id = '$id' AND jt.course_id = '$course_id' AND a.syl_student_id='$user_id'
    ORDER BY
        jt.timestamp DESC
    LIMIT 1;
    ";
    
    $sql_track_res = mysqli_query($conn, $sql_track);
    $row_track = $sql_track_res->fetch_assoc();
    
    if ($row_track) {
        $status = $row_track['status'];
        $role = $row_track['role'];
         // Set the global variable instead of session
         $verified_id1 = $row_track['verified_id'];
        
        if ($status == 'inprogress' && $role == '10') {
            return 'tableproceess'; // Yellow background
        }
        if ($status == 'Complete' && $role == '10') {
            return 'tablecomplete'; // Blue background
        }
        $trainerRoles = [1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16]; // Define the array of roles

        if ($status == 'inprogress' && in_array($role, $trainerRoles)) {
            return 'tableproceess'; // Yellow background
        }
        if ($status == 'Complete' && in_array($role, $trainerRoles)) {
            return 'trainerTablecomplete'; // Green background
        }
    }
    return ''; // Return an empty string if condition is not met
}


//user namr get function ---

function getUserIdByAppId($id, $conn,$course_id,$trainee_id,$verified_id1) {
    $sql = "
    SELECT 
        jt.verified_id
    FROM 
        syllabus_track AS a,
        JSON_TABLE(
            a.syl_track_details, 
            '$[*]' COLUMNS (
                user_id VARCHAR(255) PATH '$.user_id',
                syllabus_id VARCHAR(255) PATH '$.syllabus_id',
                course_id VARCHAR(255) PATH '$.course_id',
                verified_id VARCHAR(255) PATH '$.verified_id',
                status VARCHAR(255) PATH '$.status',
                role VARCHAR(255) PATH '$.role',
                timestamp VARCHAR(255) PATH '$.timestamp'
            )
        ) AS jt
    WHERE 
        jt.syllabus_id = '$id' AND jt.course_id = '$course_id' AND jt.verified_id = '$verified_id1' AND a.syl_student_id='$trainee_id'
    ORDER BY
        jt.timestamp DESC
    LIMIT 1;
    ";
    
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    
    if ($row) {
        return $row['verified_id'];
    }
    return ''; // Return an empty string if no result is found
}

// timestamp get funtion 
function getTimestampByAppId($id, $conn,$course_id,$trainee_id,$verified_id1) {
    $sql = "
    SELECT 
        jt.timestamp
    FROM 
        syllabus_track AS a,
        JSON_TABLE(
            a.syl_track_details, 
            '$[*]' COLUMNS (
                user_id VARCHAR(255) PATH '$.user_id',
                syllabus_id VARCHAR(255) PATH '$.syllabus_id',
                course_id VARCHAR(255) PATH '$.course_id',
                verified_id VARCHAR(255) PATH '$.verified_id',
                status VARCHAR(255) PATH '$.status',
                role VARCHAR(255) PATH '$.role',
                timestamp VARCHAR(255) PATH '$.timestamp'
            )
        ) AS jt
    WHERE 
        jt.syllabus_id = '$id' AND jt.course_id = '$course_id' AND jt.verified_id = '$verified_id1' AND a.syl_student_id='$trainee_id'
    ORDER BY
        jt.timestamp DESC
    LIMIT 1;
    ";
    
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    
    if ($row) {
        return $row['timestamp'];
    }
    return ''; // Return an empty string if no result is found
}

?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
    <style>
    .truncated-text {
    max-width: 200px;
    height: 50px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.coustome_btn {
    margin: 5px;
    padding: 2px 6px;
    border: none;
    border-radius: 6px;  /* Corrected border-radius */
    transition: background-color 0.3s, transform 0.3s;
}

/* Add hover effect for better user experience */
.coustome_btn:hover {
    background-color: #f0f0f0; /* Light background on hover */
    transform: scale(1.05); /* Slightly enlarge the button */
}
table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
tr{
    height: 50px;
    max-height: 50px; /* Fixed row height */
}
th, td {
    padding: 8px;
    text-align: left;
    vertical-align: middle;
}
/* Tooltip Styling */
[data-bs-toggle="tooltip"] {
    cursor: pointer;
}
@media (max-width: 768px) {
    th, td {
        padding: 10px;
    }

    button.coustome_btn {
        padding: 5px 10px;
    }
}
</style>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
   
        <?php
			 if ( $_SESSION['role'] == '10' ||$_SESSION['is_admin'] == 'True') {
				 include("left.php");
             } else{
                include("../RoririSoftware/left.php");
             }
					?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php
			 if ( $_SESSION['role'] == '10' ||$_SESSION['is_admin'] == 'True') {
				 include("top.php");
             } else{
                include("../RoririSoftware/top.php");
             }
					?>
		<!--end header -->
        <?php include("formSyllabus.php")?>
		<!--start page wrapper -->
		<div class="page-wrapper">
        <div class="page-content">
    <div class="page-title-box">
        <div class="page-title-right">
            <h4 class="page-title">Topics </h4>
        </div>
    </div>
    <!-- Add some space between the title and the button -->
    <div style="margin-top: 20px;">
        <!-- Back button -->
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Back</button>
    </div>
    </div>
    
          <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                
                                    <div class="row">
                                        
                                      
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12">
                                      <table id="example3" class="table-responsive table-striped table-bordered w-100" style="display:none;">
                                          <thead>
                                              <tr role="row">
                                                  <th>S. No</th>
                                                  <!--<th class="sorting" tabindex="0" aria-controls="scroll-horizontal-datatable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 124.953px;">Course</th>-->
                                                  <th >Syllabus Name</th>
                                                   <th >Description</th>  
                                                   <th >Date</th>  
                                              
                                            <th>Verified By</th>
                                            <?php
                                           if ($_SESSION['is_admin'] !== 'True') { 
                                             ?>
                                             <th>Action</th>
                                             <?php }
                                                 ?>
                                                 </tr
                                             
                                          </thead>
        
<tbody class="border">
<?php
$selQuery = "SELECT topic_id, topic_name, description FROM topic_tbl WHERE topic_status = 'Active' AND topic_sub_id = $subject_id";

$resQuery = mysqli_query($conn, $selQuery);

if (!$resQuery) {
    // Print the error message
    die("SQL Error: " . mysqli_error($conn));
}

// Display the results
$i = 1;
while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) { 
    $topic_id = $row['topic_id'];
    $topic_name = $row['topic_name'];
    $description = $row['description'];

    $course_id=$_SESSION['course_id'];
    // Call the function and get the CSS class
    $rowClass = checkApplication($topic_id, $conn,$course_id,$trainee_id);
    $user_id = getUserIdByAppId($topic_id, $conn,$course_id,$trainee_id,$verified_id1);
    $date_time = getTimestampByAppId($topic_id, $conn,$course_id,$trainee_id,$verified_id1);
?>
  
    <tr role="row" class="odd <?php echo $rowClass; ?>">
        <td class="border"><?php echo $i; ?></td>
        <td class="border"><?php echo $topic_name; ?></td>
        <td class="border"><?php echo $description; ?></td>
        <td class="border"><?php echo $date_time ?></td>
        <td class="border">
                <?php 
                    echo  trainerName($user_id); 
                
                ?>
            </td>
        
            <?php if ($_SESSION['is_admin'] !== 'True') : ?>
    <td class="border">
        <?php 
        // Check if the user is not a trainer (role '10') or, if the user is a trainer, ensure that the row is not complete
        if ($_SESSION['role'] !== '10' || ($rowClass !== "trainerTablecomplete" && $_SESSION['role'] === '10')) : 
        ?>
            <button type="button" class="coustome_btn text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" 
                    data-colorCode="<?php echo $rowClass; ?>" 
                    onclick="goEditSyllabus('<?php echo $topic_id; ?>', this, '<?php echo $trainee_id; ?>')"
                    <?php echo $rowClass === "trainerTablecomplete" ? '' : ''; // Disable if rowClass is complete ?>>
                <i class='bx bx-pencil'></i>
            </button>
             <button class="coustome_btn text-success" data-bs-toggle="tooltip" onclick="openViewModal(<?php echo $topic_id; ?>)" data-bs-placement="top" title="Topic Material"><i class="bi bi-folder custom-icon"></i></button>
        <?php endif; ?>
    </td>
<?php endif; ?>
        
        
           
    </tr>
    <?php
    $i++; // Increment $i after printing
    }
    ?>
</tbody>
<?php
?>

                                       
                                        </table>
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
			  <div id="loader" style="display:none;">
    <div class="loader-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
	</div>
	<!--end wrapper-->
    <!-- end search modal -->
	<!--end switcher-->
	<!-- Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

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
    var existingImages = [];  // Declare globally before usage 

function openViewModal(topicId) {
    // Show the loader before sending the request
$('#loader').show();
    // Fetch topic data via AJAX
    $.ajax({
        url: 'action/actSubject.php', // Backend script to fetch data
        type: 'GET',
        data: { topic_id: topicId },
        dataType: 'json',
        success: function(response) {
            $('#loader').hide();
            if (response.status === 'success') {
                    // Populate the modal with the description
                $('#topicDescription').html(response.data.topic_description);

                // Generate cards for topic materials
                const materials = response.data.topic_meterial.split(',');
                const materialsContainer = $('#topicMaterials');
                materialsContainer.empty(); // Clear previous cards if any
                
                const url ="<?php echo $meterialView ?>";
                
                materials.forEach(material => {
                    const fileUrl = `${url}${material}`;
                    const isImage = /\.(png|jpe?g|gif|bmp)$/i.test(material);
                    const isVideo = /\.(mp4|avi|mov|mkv)$/i.test(material);

                    const card = `
                        <div class="card" style="width: 150px; cursor: pointer;">
                          ${isImage ? `<img src="${fileUrl}" class="card-img-top" alt="${material}">` : ''}
                          ${isVideo ? `<video class="card-img-top" controls style="height: 100px;"><source src="${fileUrl}" type="video/mp4">Your browser does not support video.</video>` : ''}
                          <div class="card-body text-center">
                            <p class="card-text">${material}</p>
                          </div>
                        </div>
                    `;

                    const $card = $(card);
                    $card.on('click', function() {
                        window.open(fileUrl, '_blank');
                    });

                    materialsContainer.append($card);
                });

                // Show the modal
                $('#viewTopicModal').modal('show');
            } else {
                $('#loader').hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            $('#loader').hide();
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching the topic material.'
            });
        }
    });
}

$(document).ready(function() {
    // Show loader
   
    $('#example3').hide(); // Hide the table initially
   
    // Initialize DataTable
    var table = $('#example3').DataTable({
        "paging": true, // Enable pagination
        "ordering": true, // Enable sorting
        "searching": true, // Enable searching
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "processing": true, // Show processing indicator
        "drawCallback": function() {
           
            $('#example3').show();
        }
    });

});
</script>
    <script>

     //edit load ----------
        
        function goEditSyllabus(id,element,traineeId) {
    // alert(id);

    var colorCode = $(element).attr('data-colorCode'); // Access the colorCode attribute
        
    if(colorCode =="tableproceess"){
        // alert("if");
        $('#syllabus_status').val("inprogress");
        } else if(colorCode =="tablecomplete"){
            $('#syllabus_status').val("Complete");
        };

        $('#app_id').val(id); // Correctly set the value of the element
        $('#traineeId').val(traineeId);
    // $('#addSyllabusTrack')[0].reset(); // Reset the form
      $('#addsyllabusModal').modal('show'); // Bootstrap method to show the modal
    
}


   // Ajax form submission
       $('#addSyllabusTrack').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var form = this; // Get the form element
            // if (form.checkValidity() === false) {
            //     // If the form is invalid, display validation errors
            //     form.reportValidity();
            //     return;
            // }

            var formData = new FormData(form);
            // Re-enable the submit button on error
            $('#submitSyllabusbtn').prop('disabled', true);

            $.ajax({
                url: 'action/actSyllabusTrack.php',
                type: 'POST',
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
            $('#addsyllabusModal').modal('hide');
            // Remove the backdrop after hiding the modal
        $('.modal-backdrop').remove();
            $('#example3').load(location.href + ' #example3 > *', function() {
              $('#example3').DataTable().destroy();
              $('#example3').DataTable({
                "paging": true, // Enable pagination
                "ordering": true, // Enable sorting
                "searching": true // Enable searching
              });
            });
            $('#submitSyllabusbtn').prop('disabled', false);
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
          });
          $('#submitSyllabusbtn').prop('disabled', false);
        }
      },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error response
                    alert('Error adding university: ' + textStatus);
                }
            });
        });
        
        
       


    

 







    


    </script>
     <script src="<?php echo $app; ?>"></script> 
<script src="../assets/js/form-validation.js"></script>
</body>
</html>