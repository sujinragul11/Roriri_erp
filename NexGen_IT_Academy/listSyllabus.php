<?php 
session_start();
include("../db/dbConnection.php");
include("../url.php");

// $id=$_SESSION['id'];

if(isset($_GET['traineeId']) && $_GET['traineeId'] != ''){
  $trainee_id = $_GET['traineeId'];
  $verified_id = $_SESSION['id'];
}else{
  $trainee_id = $_SESSION['id'];
  // $verified_id = $user_id;
}

$select_subject ="SELECT 
a.id,a.course_name
, a.subject_id
, b.course_id
, c.name FROM `academy_course_details` AS a
LEFT JOIN trainee_additional_details AS b ON a.id =b.course_id 
LEFT JOIN basic_details AS c ON c.id =b.basic_id 
WHERE c.id=$trainee_id AND a.status='Available';";

$select_subject_res = mysqli_query($conn, $select_subject);



?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
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
        
		<!--start page wrapper -->
		<div class="page-wrapper">
    <div class="page-content" id="subject-content">
        <div class="page-title-box">
            <div class="page-title-right">
                <h4 class="page-title">Subject</h4>
                <?php
                  $trainerRoles = [1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16]; // Define the array of roles

                  if (in_array($_SESSION['role'], $trainerRoles) || $_SESSION['is_admin'] === 'True') { ?>
                  <button type="button" class="btn btn-danger me-auto" onclick="javascript:location.href='trainee.php'"><i
                  class='bx bx-arrow-back'></i></button>
                  <?php } ?>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- Loop to generate cards -->
<?php
$rows = mysqli_fetch_assoc($select_subject_res);

// Get the subject_id string (e.g., "5,6,7,8")
$subject_ids = $rows['subject_id'];
$_SESSION['course_id'] =$rows['course_id'];
$subject_ids; // For debugging: display the subject IDs

// Convert the comma-separated string into an array
$subject_ids_array = explode(',', $subject_ids); // Split the string by commas

// Check if the conversion was successful and the result is an array
if (is_array($subject_ids_array)) {
    // Iterate through each subject_id in the array
    foreach ($subject_ids_array as $subject_id) {
        // Trim whitespace from each ID to avoid query errors
        $subject_id = trim($subject_id);

        // Use the fetched subject ID to fetch details from subject_tbl
        $selQuery = "SELECT * FROM subject_tbl WHERE status='Active' AND id=$subject_id;";
        $resQuery = mysqli_query($conn, $selQuery);

        // Check for query errors
        if (!$resQuery) {
            echo "Error: " . mysqli_error($conn);
            continue; // Skip to the next iteration if the query fails
        }

        // Fetch the subject details
        $row_sub = mysqli_fetch_assoc($resQuery);

        // Check if data is available
        if ($row_sub) { 
            $sub_id = $row_sub['id'];
            $sub_name = $row_sub['subject_name'];
            $sub_duration = $row_sub['duration'];
            
            ?>
            <!-- Display the card with subject details -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($sub_name); ?></h5>
                        <p class="card-text">Duration: <?php echo htmlspecialchars($sub_duration); ?></p>
                      
                       <a href="showTopic.php?syllabusId=<?php echo $sub_id; ?>&traineeId=<?php echo $trainee_id; ?>"> <button type="button"  class="btn btn-success text-white" >
                            <i class='bx bx-book-open'></i> Syllabus
                        </button></a>
                    </div>
                </div>
            </div>
            <?php
        } else {
            // If no subject found, handle it accordingly
            echo "<p>No active subject .</p>";
        }
    }
} else {
    echo "<p>Invalid subject IDs format for course.</p>";
}
?>
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
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
	<script src="<?php echo $datatableMin; ?>"></script>
     <!-- Include Bootstrap JS (with Popper) -->
    <script src="<?php echo $popper;?>"></script>
    <script src="<?php echo $bootStackPath;?>"></script>
	<script src="<?php echo $sweetalert; ?>"></script>
   
  <script>
  $(document).ready(function () {
  $('#addSubjectBtn').click(function () {
    $('#addSubjectModal').modal('show'); // Show the modal
    resetForm('addSubject'); // Reset the form
  });
  
 
//       function goAddSyllabus1(subId) {
//     alert("hai");
//     // Hide the subject content and show the syllabus content
//     document.getElementById('subject-content').style.display = 'none';
//     document.getElementById('syllabus-content').style.display = 'block';
//     // document.getElementById('subId').value = subId;
    

//     // Make an AJAX request to store subId in the session
//     $.ajax({
//         url: 'getSyllabus.php',
//         method: 'POST',
//         data: { subId: subId },
//         success: function(response) {
//             console.log("SubId set in session: " + response);
//             // Optionally, you can reload the syllabus content based on the subId
//             $('#example2').load(location.href + ' #example2 > *', function() {
//                 $('#example2').DataTable().destroy();
//                 $('#example2').DataTable({
//                     "paging": true,
//                     "ordering": true,
//                     "searching": true
//                 });
//             });
//         },
//         error: function(xhr, status, error) {
//             console.error('Failed to set SubId in session:', status, error);
//         }
//     });
// }
  
  // Ajax form submission
       $('#addSyllabusTrack').submit(function(event) {
            event.preventDefault(); // Prevent default form submission
    alert("hai");
            var form = this; // Get the form element
            // if (form.checkValidity() === false) {
            //     // If the form is invalid, display validation errors
            //     form.reportValidity();
            //     return;
            // }

            var formData = new FormData(form);

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
            $('#scroll-horizontal-datatable').load(location.href + ' #scroll-horizontal-datatable > *', function() {
              $('#scroll-horizontal-datatable').DataTable().destroy();
              $('#scroll-horizontal-datatable').DataTable({
                "paging": true, // Enable pagination
                "ordering": true, // Enable sorting
                "searching": true // Enable searching
              });
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
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error response
                    alert('Error adding university: ' + textStatus);
                }
            });
        });
        
    

  function resetForm(formId) {
    document.getElementById(formId).reset(); // Reset the form
  }

  $('#addSubject').off('submit').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting normally

    var formData = new FormData(this);
    $.ajax({
      url: "action/actSubject.php",
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
            resetForm('addSubject');
            $('#addSubjectModal').modal('hide'); // Hide the modal
            location.reload(); // Reload the page after modal is hidden
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
          text: 'An error occurred while adding Task data.'
        });
        // Re-enable the submit button on error
        $('#submitBtn').prop('disabled', false);
      }
    });
  });
});

// ajax edit course
function goEditSubject(editId)
{ 
      $.ajax({
        url: 'action/actSubject.php',
        method: 'POST',
        data: {
          editId: editId
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			// alert(editId);
      //     console.log(response.sub_id);
          // alert(response.course_name);

          $('#editId').val(response.sub_id);
          $('#edit_name').val(response.edit_name);
          $('#editsub_name').val(response.editsub_name);
          $('#edit_duration').val(response.edit_duration); 
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    
}
document.addEventListener('DOMContentLoaded', function() {
    $('#editSubject').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this);
        $.ajax({
            url: "action/actSubject.php",
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
                      $('#editSubjectModal').modal('hide'); // Close the modal
                        
                        $('.modal-backdrop').remove(); // Remove the backdrop 
                        location.reload();  
                          $('#scroll-horizontal-datatable').load(location.href + ' #scroll-horizontal-datatable > *', function() {
                               
                              $('#scroll-horizontal-datatable').DataTable().destroy();
                               
                                $('#scroll-horizontal-datatable').DataTable({
                                   "paging": true, // Enable pagination
                                   "ordering": true, // Enable sorting
                                    "searching": true // Enable searching
                               });
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
                    text: 'An error occurred while Edit Task data.'
                });
                // Re-enable the submit button on error
                $('#updateBtn').prop('disabled', false);
            }
        });
    });
});




function goBackToSubjects() {
    // Show the subject content and hide the syllabus content
    document.getElementById('subject-content').style.display = 'block';
    document.getElementById('syllabus-content').style.display = 'none';
}

 $(document).ready(function () {
  $('#addTopicBtn').click(function () {
    resetForm('addTopic'); // Reset the form
  });

  function resetForm(formId) {
    document.getElementById(formId).reset(); // Reset the form
  }

     $('#addTopic').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
    
        var formData = new FormData(this);
        var submitButton = $('#topicSubmitBtn');
        submitButton.prop('disabled', true); // Disable the submit button
    
        $.ajax({
          url: "action/actTopic.php",
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
                resetForm('addTopic');
                submitButton.prop('disabled', false); // Re-enable the submit button
                $('#addTopicModal').modal('hide'); // Hide the modal
                $('#example2').load(location.href + ' #example2 > *', function() {
                    $('#example2').DataTable().destroy();
                    $('#example2').DataTable({
                        "paging": true,
                        "ordering": true,
                        "searching": true
                    });
                });
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message
              });
              submitButton.prop('disabled', false); // Re-enable the submit button on error
            }
          },
          error: function(xhr, status, error) {
            // Handle error response
            console.error(xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while adding Topic data.'
            });
            submitButton.prop('disabled', false); // Re-enable the submit button on error
          }
        });
    });
});


   //edit load ----------
        
        function goEditApplication(id) {
    alert(id);
    $('#app_id').val(id); // Corrected line: added the dot before `val`
}


   
        
        
</script>
<script src="<?php echo $app; ?>"></script> 
<script src="../assets/js/form-validation.js"></script>
</body>

</html>
<?php include("formSyllabus.php");?>
<?php include("addTopic.php");?>
