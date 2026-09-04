<?php
session_start();
include("../db/dbConnection.php");
include("../url.php");
include("action/function.php");

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 'True') {
    // If the user is not an admin, set the empId to the user's ID
    $studid = $_SESSION['id'];
} elseif (isset($_GET['id']) && $_GET['id'] != '') {
    $studid = $_GET['id'];
} else {
    // If no trainee ID is provided, redirect to student.php
    header("Location: student.php");
    exit(); // Ensure the script stops executing after redirection
}

// Prepare and execute the SQL query
$selQuery = "SELECT a.*,
b.*,
c.*,
d.*,
e.*
FROM basic_details AS b
LEFT JOIN additional_details AS a ON a.basic_id=b.id 
LEFT JOIN roles as c ON c.role_id=a.role
LEFT JOIN student_additional_details AS d ON d.basic_id=b.id
LEFT JOIN course_tbl AS e ON e.course_id=d.college_course
WHERE b.id='$studid'";

$result1 = $conn->query($selQuery);

if ($result1) {
    // Fetch trainee details
    $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    $id = $row['id'];
    $student_id = $row['reg_no'];
    $e_id = $row['entity_id'];
    $name = $row['name'];
    $address = $row['address'];
    $email = $row['email'];
    $mobile = $row['phone'];
    $role = $row['role_name'];
    $student_img = $row['image'];
    $usernameStu=$row['username'];
    $password=$row['password'];
    $stud_qr=$row['qr'];
    $course=$row['course_name'];
    $duration=$row['duration'];
    $ten=$row['10th_marksheet'];
    $twelve=$row['12th_marksheet'];
    $course_fee=$row['course_fee'];
    // Construct the image path
    $image_path = $stuView . $student_img;
    $qr_path=$stuQRView.$stud_qr; 
   $ten_path=$stu10thView.$ten;
   $twelve_path=$stu12thView.$twelve;
    
} else {
    echo "Error executing query: " . $conn->error;
}
// Correct the typo in the method name
$balQurey = "SELECT SUM(received_amnt) AS received FROM payment WHERE basic_id='$studid'";
$balRes = $conn->query($balQurey); // Use query() instead of qurey()

if ($balRes) {
    $row1 = mysqli_fetch_array($balRes, MYSQLI_ASSOC);
    $received = $row1['received'];
    // Handle case where no payments have been received
    if ($received === null) {
        $received = 0;
    }
} else {
    echo "Error executing query: " . $conn->error;
}

$balance=$course_fee-$received;
?>
<!doctype html>
<html lang="en">

<?php include("head.php"); ?>
<body>
<?php include("editStudent.php");
include("addStudentdetail.php");
include("addPayment.php"); ?>
<style>
        .error-message {
            color: red;
            display: none;
        }
        .error {
            border-color: red;
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
		<div class="page-wrapper">
			<div class="page-content">
				
				
<div class="container">
  <div class="main-body"> 
	<div class="modal-footer p-2">
  <?php  if ($_SESSION['is_admin'] == 'True'): ?>
        <button type="button" class="btn btn-danger me-auto" onclick="javascript:location.href='student.php'"><i class='bx bx-arrow-back'></i></button>
        <?php else:  ?>
        <button type="button" onclick="goEditProfile(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#editStudentModal" class="btn btn-primary" id="editButton">Edit Password</button>
        <?php endif; ?>
	</div>
    <div class="row">
      <div class="col-lg-4">
        <div class="card h-100" style="height: 450px;">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <?php
            function url($url) {
              $headers = @get_headers($url);
              return is_array($headers) && isset($headers[0]) && stripos($headers[0], "200 OK") ? true : false;
            }// Check if the image exists 

            if (url($image_path)) {
              $display_image = $image_path; // Use the actual image if it exists
            } else {
              $display_image = $default_image; // Use the default image if the actual image doesn't exist
            } ?>
              <img src="<?php echo $display_image;?>" alt="<?php echo $name;?>" class="rounded-circle p-1  img-fluid" style="width: 120px; height: 120px; object-fit: cover; object-position: top; max-width: 120px; max-height: 120px;">
              <div class="mt-3">
                <h4><?php echo $name;?></h4>
                <p class="text-secondary mb-1"><?php echo $student_id;?></p>
                <p class="text-secondary mb-1"><?php echo $course;?></p>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
     <div class="card h-100" style="height: 450px;">
      <div class="card-body">
        <div class="row h-100">
          <!-- Left half of col-lg-8 for trainee details -->
          <div class="col-md-6">
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Full Name</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo $name;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Personal Email</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo $email;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Mobile</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo $mobile;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Address</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo $address;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">User ID</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo $usernameStu;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Password</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1" id="passwordField"><?php echo $password;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Course Duration</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo $duration;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Course Fee</h6>
              </div>
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo number_format($course_fee,2);?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <h6 class="mb-0">Balance</h6>
              </div> 
              <div class="col-sm-6 text-secondary">
                <p class="text-secondary mb-1"><?php echo number_format($balance,2);?></p>
              </div>
            </div>
          </div>

          <!-- Right half of col-lg-8 for QR code image -->
          <div class="col-md-6 d-flex align-items-center justify-content-center">
            <img src="<?php echo $qr_path; ?>" alt="Trainee QR Code" class="img-fluid" style="width: 200px; height: 200px; object-fit: cover;">
          </div>
        </div>
      </div>
    </div>
  </div>
    </div>
	<div class="container mt-5">
    <h2></h2>

    <!-- Tabs navs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <!-- <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Projects</button>
        </li> -->
        
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Payment</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab" aria-controls="detail" aria-selected="false">Detail</button>
        </li>
        <li class="nav-item" role="presentation" style="display:none" >
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
        </li>
    </ul>
    <!-- Tabs navs -->

    <!-- Tabs content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
           <div class="mt-3">
			        <div class="table-responsive">
							<!-- <table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										                    <th>Project Name</th>
                                        <th>Technology</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
										
										
										
									</tr>
								</thead>
								<tbody>
                                <?php 
                //                 $selectPro="SELECT employee_tbl.*,
								// 	project_tbl.*
								// 	FROM employee_tbl
								// 	INNER JOIN project_tbl 
								// 	ON JSON_CONTAINS(project_tbl.developers, CONCAT('\"', employee_tbl.emp_id, '\"'))
								// 	WHERE employee_tbl.emp_id = '$id'";
								// 	$resQuery = mysqli_query($conn , $selectPro); 
								// $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                //             $emp_id   = $row['emp_id'];  
                //             $employee_id=$row['employee_id'];   
                //             $emp_first_name  = $row['emp_first_name'];  
                //             $emp_last_name   = $row['emp_last_name'];  
                //             $programming          = $row['programming'];
                //             $developers        = $row['developers'];   
                //             $project_name        = $row['project_name'];   
                //             $pro_status=$row['project_status'];
                //             $start_date=$row['start_date'];
                //             $end_date = $row['end_date'] === '0000-00-00' ? '-' : $row['end_date'];
                //             $name=$emp_first_name.' '.$emp_last_name;

                //             $programmingArray = json_decode($programming);
                //                 // Check if $programmingArray is an array
                //                 if (is_array($programmingArray)) {
                //                     // Output each element separated by commas
                //                     $pro= implode(', ', $programmingArray);
                //                 } else {
                //                     // Handle case where $programming is not a valid JSON array
                //                     $pro= $programming; // Output as-is (may need additional handling)
                //                 }  
                      ?>
                      <tr>
                       <td></td>
                      <td></td>
                      <td></th>
                      <td></td>
					            <td></td>
					            <td></td>
                      
                      
                    </tr>
                    <?php 
                  // } 
                  ?>   
						</tbody>
								
					</table> -->
						</div>
		 </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p>This is the profile tab content.</p>
        </div>
        <div class="tab-pane fade position-relative p-3 show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        
            <div class="d-flex justify-content-end mb-3">
            <?php  if ($_SESSION['is_admin'] == 'True'): ?>
                  <button type="button" id="addSalaryBtn" class="btn btn-primary position-absolute top-0 end-0" onclick="goShow(<?php echo $id; ?>);" data-bs-toggle="modal" data-bs-target="#payStudentModal">Payment</button>
                  <?php endif; ?> 
              </div> 
              
              <div class="table-responsive">
							 <table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										                    <th>Date</th>
                                        <th>Received Amount</th>
                                        <th>Received By</th>
                                        <th>Payment Mode</th>
                                        <?php  if ($_SESSION['is_admin'] == 'True'): ?>
                                        <th>Action</th>
                                        <?php endif; ?>
                                        
										
										
										
									</tr>
								</thead>
								<tbody>
                                <?php 
                                 $selectPay="SELECT * FROM `payment` WHERE entity_id=2 AND basic_id ='$studid'";
									$resQuery = mysqli_query($conn , $selectPay); 
								$i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                            $id   = $row['basic_id'];
                            $pay_id=$row['pay_id'];  
                            $received_date=$row['received_date'];   
                            $received_amnt  = $row['received_amnt'];  
                            $received_by   = $row['received_by'];  
                            $pay_method     = $row['pay_method'];
                           
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo formatDate($received_date);  ?></td>
                      <td><?php echo number_format($received_amnt,2);  ?></th>
                      <td><?php echo $received_by; ?></td>
					            <td><?php echo $pay_method;  ?></td>
                      <?php  if ($_SESSION['is_admin'] == 'True'): ?>
					            <td><button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditPayment(<?php echo $pay_id; ?>);" data-bs-toggle="modal" data-bs-target="#editPaymentModal"><i class="lni lni-pencil"></i></button></td>
                      <?php endif; ?>
                      
                    </tr>
                    <?php 
                   } 
                  ?>   
						</tbody>
								
					</table> 
						</div>
        </div>
        <div class="tab-pane fade position-relative p-3" id="detail" role="tabpanel" aria-labelledby="profile-tab">
          <div class="d-flex justify-content-end mb-3">
          <?php  if ($_SESSION['is_admin'] == 'True'): ?>
            <button type="button" id="addDetailBtn" onclick="goEditDetails(<?php echo $id; ?>);" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#StudentdetailModal">Add Student Detail</button>
            <?php endif; ?> 
            <div class="container">
              <div class="row">
                  <div class="col-md-4 mb-3">
                      <div class="card">
                          <img src="<?php echo $ten_path; ?>" class="card-img-top" id="tenImage" alt="Image Description">
                      </div>
                  </div>
                  <div class="col-md-4 mb-3">
                      <div class="card">
                          <img src="<?php echo $twelve_path; ?>" class="card-img-top" id="twelveImage" alt="Image Description">
                      </div>
                  </div>
                  
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
    <!-- Tabs content -->

</div>
  </div>
</div><!--end page-wrapper-->
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->

	<!--start switcher-->

	<!--end switcher-->
	<!-- Bootstrap JS -->
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
    <script src="../assets/js/function.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 
          <?php
          if ($_SESSION['is_admin'] == 'True'): ?>
            'copy', 'excel', 'pdf', 'print'
            <?php endif; ?>
          ]

			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)');
		} );

    //Handles fetch the data
     //function to fetch add the  student name and payment details 
    function goShow(id) {
        $.ajax({
            url: 'action/actPayment.php',
            method: 'POST',
            data: {
              studentPay: id
            },
            dataType: 'json', // Specify the expected data type as JSON
            success: function(response) {
              console.log(response); // Log response to ensure it contains the correct data

              $('#payStudent').val(response.id);
              $('#stuName').val(response.student_name);
              $('#overAmnt').val(response.charge);
              $('#amntReceived').val(response.iniPay);
          
      
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error('AJAX request failed:', status, error);
            }
        });
    }
//Function to fetch the username and password
    function goEditProfile(id) 
  
  {
    $.ajax({
        url: 'action/actStudent.php',
        method: 'POST',
        data: {
          studid: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
       
        $('#editUname').val(response.username);
        $('#editPassword').val(response.password);
        $('#profileId').val(response.studid);

   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
//function to fetch edit the payment details
function goEditPayment(id){
		$.ajax({
                url: 'action/actPayment.php',
                method: 'POST',
                data: {
                  editPayId: id
                },
                dataType: 'json',
                success: function(response) {
                
                    $('#editPayId').val(response.pay_amt_id);
                    $('#proNameE').val(response.pro_name);
                    $('#overAmntE').val(response.total_pay);
                    $('#amntReceivedE').val(response.over_pay);
                    $('#balanceE').val(response.amnt_paid);
                    $('#dateE').val(response.date);
                    $('#receivedE').val(response.receivedBy);
                    $('#payModeE').val(response.payModeE);
                    $('#transE').val(response.transE);
                    $('#payStatus').val(response.pay_status);

                   // Handle programming array
            
                 },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                }
            });
	}
//function to fetch the student name and student course for extra details
  function goEditDetails(id) {
        $.ajax({
            url: 'action/actDetails.php',
            method: 'POST',
            data: {
              stuId: id
            },
            dataType: 'json', // Specify the expected data type as JSON
            success: function(response) {
              console.log(response); // Log response to ensure it contains the correct data

              $('#stuId').val(response.stuId);
              $('#name').val(response.name);
              $('#coursefee').val(response.fee);
              $('#course').val(response.course_id);
              $('#fatherName').val(response.father);
              $('#fatherOccupation').val(response.fOcc);
              $('#fatherPhone').val(response.fPhone);
              $('#motherName').val(response.mother);
              $('#motherOccupation').val(response.mOcc);
              $('#motherPhone').val(response.mPhone);
              $('#tenthMark').val(response.ten);
              $('#twelfthMark').val(response.twelve);
              
              
              // Display the image if the URL is provided
         // Display the 10th Marksheet image if the URL is provided
         if (response.tenMark) {
                console.log('10th Marksheet Image URL:', response.tenMark); // Debugging line
                $('#editTen').attr('src', response.tenMark).show();
            } else {
                $('#editTen').hide();
            }

            // Display the 12th Marksheet image if the URL is provided
            if (response.twelveMark) {
                console.log('12th Marksheet Image URL:', response.twelveMark); // Debugging line
                $('#editTwelve').attr('src', response.twelveMark).show();
            } else {
                $('#editTwelve').hide();
            }
      
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error('AJAX request failed:', status, error);
            }
        });
    }


$(document).ready(function () {

  function updateImage(selector, imagePath) {
    // Update the image source with the new path
    $(selector).attr('src', imagePath);
}
    //Fucntion to validate the 10h mark
    function validateTenthMark(fieldId, errorId) {
        var marksInput = $('#' + fieldId);
        var marksError = $('#' + errorId);
        var marks = marksInput.val().trim();
        var marksPattern = /^[0-9]{1,3}$/; // Allows 1-3 digit numbers (0-999)

        // Validate 10th Marks
        if (marks === "") {
            marksError.text("This field cannot be empty.").show();
            return false;
        } else if (!marksPattern.test(marks) || parseInt(marks) > 500 || parseInt(marks) < 100) {
            marksError.text("Please enter a valid mark").show();
            return false;
        } else {
            marksError.hide();
            return true;
        }
    }
    function validateTwelft(fieldId, errorId) {
        var marksInput = $('#' + fieldId);
        var marksError = $('#' + errorId);
        var marks = marksInput.val().trim();
        var marksPattern = /^[0-9]{1,4}$/; // Allows 1-4 digit numbers (0-9999)

        // Validate 12th Marks
        if (marks === "") {
            marksError.hide();
            return true;
        }
        if (!marksPattern.test(marks) || parseInt(marks) > 1200 || parseInt(marks) < 200) {
            marksError.text("Please enter a valid mark").show();
            return false;
        } else {
            marksError.hide();
            return true;
        }
    }


    $('#detailsubmitBtn').click(function (e) {
        e.preventDefault();

        var isValid = true;
        
        isValid &= validateName('fatherName', 'fatherNameError');
        isValid &= validateName('fatherOccupation', 'fatherOccupationError');
        isValid &= validateName('motherName', 'motherNameError');
        isValid &= validatePhoneNumber('fatherPhone', 'fatherPhoneError');
        isValid &= validateName('motherOccupation', 'motherOccupationError');
        isValid &= validateTenthMark('tenthMark', 'tenthMarkError');
        isValid &= validateTwelft('twelfthMark', 'twelftMarkError');
        if (isValid) {
            $('#addDetails').trigger('submit');
        }
    });

    $('#addDetails').off('submit').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            url: "action/actDetails.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function () {
                        $('#StudentdetailModal').modal('hide');
                        $('.modal-backdrop').remove();

                        // Update images in the tab content
                        if (response.img) {
                            if (response.img.ten_img) {
                                updateImage('#tenImage', response.img.ten_img);
                            }
                            if (response.img.twelve_img) {
                                updateImage('#twelveImage', response.img.twelve_img);
                            }
                        }
                    });
                    resetForm('addDetails');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding students data.'
                });
            }
        });
    });

    $('#modalCloseBtnDet').click(function () {
        resetForm('addDetails');
    });

    function resetForm(formId) {
        document.getElementById(formId).reset();
        $('.error-message').hide();
    }
   
});

</script>

<script>
  function hideErrorMessages() {
    $('.error-message').hide(); // Hide all error messages
    }
$(document).ready(function () {

  var today = new Date().toISOString().split('T')[0];
    $('#date').attr('max', today);
     // Function to validate a single field
      function validateField(fieldId, errorId) {
          var value = $('#' + fieldId).val().trim();
              if (value === '') {
                  $('#' + errorId).show();
                  return false;
              } else {
                  $('#' + errorId).hide();
                  return true;
                }
      }
    // Handle submit button click
    $('#submitBtn').click(function (e) {
       
      e.preventDefault(); // Prevent default form submission
      var isValid = true;
      // Validate fields
      isValid &= validateField('balance', 'amountError');
      isValid &= validateField('date', 'dateError');
     
      isValid &= validateField('payMode', 'modeError');
      isValid &= validateName('received', 'receivedError');
      
      
      if (isValid) {
          $('#StudentPayment').trigger('submit'); // Manually trigger the form submit event if validation passes
          console.log("Form submitted"); // Debug message
        }
    });

    // Handle form submission
    $('#StudentPayment').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        
        var formData = new FormData(this);
        $.ajax({
            url: "action/actPayment.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log("AJAX success", response); // Debug message
                if (response.success) {
                 
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#payStudentModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop
                         // Reset the form after success
                         resetForm('StudentPayment');
                        setTimeout(function() {
                            $('#example2').load(location.href + ' #example2 > *', function() {
                              if ($.fn.DataTable.isDataTable('#example2')) {
                                $('#example2').DataTable().destroy();
                            }
                            var table = $('#example2').DataTable({
                                "paging": true,
                                "ordering": true,
                                "searching": true,
                                lengthChange: false,
                                buttons: ['copy', 'excel', 'pdf', 'print']
                            });

                            table.buttons().container()
                                .appendTo('#example2_wrapper .col-md-6:eq(0)');
                            });
                        }, 300);
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
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding Payment data.'
                });
                $('#submitBtn').prop('disabled', false);
            }
        });
    });

    // Reset the form when the close button is clicked
    $('#modalCloseBtnPay').click(function () {
        console.log('Modal close button clicked'); // Debug message
        resetForm('StudentPayment');
    });

   
});
// Function to reset the form and hide error messages
function resetForm(formId) {
                document.getElementById(formId).reset(); // Reset the form
                $('.error-message').hide(); // Hide all error messages
                }


//--------------Handles edit student Payment -----------------------------//

document.addEventListener('DOMContentLoaded', function() {
    // Handle the form submission
    $('#updatePayBtn').click(function (e) {
        e.preventDefault(); // Prevent default button action

        var isValid = true;

        // Validate fields
      isValid &= validateField('balanceE', 'errorBalance');
      isValid &= validateField('payStatus', 'payStatusErrorE');
      isValid &= validateField('payModeE', 'payModeErrorE');
      isValid &= validateName('receivedE', 'receivedErrorE');
      // isValid &= setMaxDate('dateE');
        if (isValid) {
            $('#editPayment').trigger('submit'); // Trigger the form's submit event if validation passes
        }
    });

    // Handle the form submission via AJAX
    $('#editPayment').off('submit').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission

        var formData = new FormData(this);
        $.ajax({
            url: "action/actPayment.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Expect JSON response
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: response.message,
                        timer: 2000
                    }).then(function () {
                        $('#editPaymentModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop
                        setTimeout(function () {
                            $('#example2').load(location.href + ' #example2 > *', function () {
                                if ($.fn.DataTable.isDataTable('#example2')) {
                                    $('#example2').DataTable().destroy();
                                }
                                var table = $('#example2').DataTable({
                                    "paging": true,
                                    "ordering": true,
                                    "searching": true,
                                    lengthChange: false,
                                    buttons: ['copy', 'excel', 'pdf', 'print']
                                });
                                table.buttons().container()
                                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
                            });
                        }, 300);
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while editing Payment data.'
                });
            }
        });
    });

    $('#modalPayCloseBtn').click(function () {
    hideErrorMessages(); // Call the function to hide error messages
});
});



//to update the password field
document.addEventListener('DOMContentLoaded', function() {
    $('#editStudent').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this);
        $.ajax({
            url: "action/actStudent.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#editStudentModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop   
                        // Update the specific field with the new value from response
                        if (response.newPassword) { // Assuming response.newPassword contains the updated password
                            $('#passwordField').text(response.newPassword);
                        }
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
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating password data.'
                });
                $('#updateBtn').prop('disabled', false);
            }
        });
    });
});
	 </script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
  
<script src="../assets/js/form-validation.js"></script>
</body>

</html>