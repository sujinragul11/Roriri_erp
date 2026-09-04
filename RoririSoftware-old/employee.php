 <?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT a.*, b.*,c.* , b.status as emp_status
        FROM basic_details AS b
        LEFT JOIN additional_details AS a ON a.basic_id=b.id
        LEFT JOIN emp_additional_details AS c ON c.basic_id=b.id 
        WHERE a.entity_id=1 AND b.status='Active' AND a.add_status='Active'
        ORDER BY 
        b.id DESC";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
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
        <?php include("addEmployee.php");
        include("editEmployee.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Employee</h2>
                    <div class="position-relative" style="height: 80px;"> <!-- Adjust height as needed -->
                    <button type="button" id="addEmployeeBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add New Employee</button>
                    </div>

                </div>
                   
            </div>

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
                            <!-- Dropdown Filter for Status -->
                            <div class="mb-3">
                                <label for="statusFilter" class="form-label">Filter by Status</label>
                                <select id="statusFilter" class="form-select" onchange="filterStatus()">
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Name</th>
                                        <th>ID</th>
                                        <th>Phone</th>
										<!-- <th>Project</th> -->
										<th>Email</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody id="tableBody">
                                <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                        $emp_id  = $row['id'];  
                                        $emp_name=$row['name'];   
                                       // $proName  = $row['project_name'];  
                                        $email   = $row['email'];  
                                        $phone          = $row['phone'];
                                        $address        = $row['address'];   
                                        $username=$row['username'];
                                        $password=$row['password'];
                                        $reg_no=$row['reg_no'];
                                        $status =$row['emp_status'];
                                      
                                
                      ?>
                      <tr>
                       <td><?php echo $i; $i++; ?></td>
                      <td><?php echo $emp_name; ?></td>
                      <td><?php echo $reg_no; ?></td>
                      <td><?php echo $phone; ?></td>
                      <td><?php echo $email; ?></td>
                
                      
                      <td>
                          <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewEmp(<?php echo $emp_id; ?>, '<?php echo $username; ?>');" ><i class="lni lni-eye"></i></button>
                          <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditEmp(<?php echo $emp_id; ?>);" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="lni lni-pencil"></i></button>
                         
                         
                          <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteEmployee(<?php echo $emp_id; ?>);"><i class="lni lni-trash"></i></button>
                          
                      </td>
                    </tr>
                    <?php } ?>   
								</tbody>
								
							</table>
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
    <!-- Include the function.js -->
     <script src="../assets/js/function.js"></script>

     <script>

function filterStatus() {
    var filter = document.getElementById("statusFilter").value; // Get the selected value from dropdown

    $.ajax({
        url: 'action/actEmployee.php', // Change to your PHP file that handles the filtering
        method: 'POST',
        data: {
            status: filter
        },
        dataType: 'json', // Expect JSON response
        success: function(response) {
            // Get the DataTable instance
            var table = $('#example2').DataTable();

            // Clear the existing data in DataTable
            table.clear(); 

            // Check if the response has data
            if (response.length > 0) {
                response.forEach(function(row, index) {
                    // Add new row data using DataTables API
                    table.row.add([
                        index + 1, // S.No.
                        row.name, // Name
                        row.reg_no, // Registration Number
                        row.phone, // Phone
                        row.email, // Email
                        `<button class="btn btn-sm btn-outline-success" 
                                    onclick="goViewEmp(${row.id}, '${row.username}');">
                                <i class="lni lni-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                    onclick="goEditEmp(${row.id});" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editEmployeeModal">
                                <i class="lni lni-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" 
                                    onclick="goDeleteEmployee(${row.id});">
                                <i class="lni lni-trash"></i>
                            </button>`
                    ]).draw(false); // 'false' prevents pagination from resetting
                });
            } else {
                // Optionally, show a message if no records found
                table.row.add([
                    '', '', '', '', '',
                    '<td colspan="6" class="text-center">No records found.</td>'
                ]).draw();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching data: ", textStatus, errorThrown);
        }
    });
}

</script>

     <!-- Initialize tooltips -->

     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script>
        function goViewEmp(id, username) {
          location.href = "employeeDetails.php?id=" + id + "&username=" + username;
        }
        function goEditEmp(id) 
  
  {
    $.ajax({
        url: 'action/actEmployee.php',
        method: 'POST',
        data: {
            empId: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#empId').val(response.emp_id);
          $('#editFname').val(response.first_name);
          $('#editLname').val(response.last_name);
          $('#editPhone').val(response.phone);
          $('#editPemail').val(response.personal_email);
          $('#editCemail').val(response.company_email);
          $('#editDob').val(response.dob);
          $('#editAddress').val(response.address);
          $('#editjDate').val(response.joining_date);
          $('#editRole').val(response.role);
          $('#editms').val(response.married_status);
		  $('#editGender').val(response.gender);
		  
		  // Display the image if the URL is provided
          if (response.img) {
            console.log('Image URL:', response.img); // Debugging line
                $('#editEmpImg').attr('src', response.img).show();
                
            } else {
                $('#editEmpImg').hide();
            }
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
function goDeleteEmployee(id)
{
    //alert(id);
    if(confirm("Are you sure you want to delete Employee?"))
    {
      $.ajax({
        url: 'action/actEmployee.php',
        method: 'POST',
        data: {
          deleteId: id
        },
        //dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
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
            
         // Show SweetAlert based on the response
         if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: response.message,
                        timer: 2000
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
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
    }
}
//Data Table script 
    </script>
	<script>
		$(document).ready(function() {
            filterStatus();
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
</script>

    <!--Handles the Ajax call-->
<!-- JavaScript for Client-Side Validation and AJAX Submission -->
<script>
$(document).ready(function () {
     

    $('#submitBtn').click(function (e) {
        e.preventDefault();
        console.log('Submit button clicked'); // Debugging line
        var isValid = true;

        // Validate fields
        isValid &= validateName('fname', 'fnameError');
        isValid &= validateDOB('dob', 'dobError');
        isValid &= validateField('gender', 'genderError');
        isValid &= validatePhoneNumber('phone', 'phoneError');
        isValid &= validateEmail('pemail', 'emailError');
        isValid &= validateField('role', 'roleError');
        isValid &= validateJoiningDate('jDate', 'jDateError');
        isValid &= validateField('address', 'addressError');
        isValid &= validateField('ms', 'msError');
        isValid &= optionalEmail('cemail', 'cemailError');

        if (isValid) {
            var phone = $('#phone').val().trim();
            var pemail = $('#pemail').val().trim();

            // AJAX request to check for existing records
            $.ajax({
                url: "action/checkEmployee.php", // Your URL to check phone and email
                method: 'POST',
                data: { phone: phone, pemail: pemail },
                dataType: 'json',
                success: function(response) {
                    if (!response.success) {
                        if (response.phoneExists) {
                            $('#phoneError').text("Phone number already exists").show();
                        }
                        if (response.emailExists) {
                            $('#emailError').text("Email already exists").show();
                        }
                    } else {
                        // Submit the form if valid
                        submitForm();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while checking phone and email.'
                    });
                }
            });
        }
    });

    function submitForm() {
        var formData = new FormData($('#addEmployee')[0]);
        $.ajax({
            url: "action/actEmployee.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Ensure you expect a JSON response
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#addEmployeeModal').modal('hide');
                        $('.modal-backdrop').remove();
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
                        // Reset the form after successful submission
                        resetForm('addEmployee');
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
                    text: 'An error occurred while adding Employee data.'
                });
                $('#submitBtn').prop('disabled', false);
            }
        });
    }

    // Reset the form when the close button is clicked
    $('#modalCloseBtn').click(function () {
        resetForm('addEmployee');
    });

    function resetForm(formId) {
        $('#' + formId)[0].reset(); // Reset the form using jQuery
        // Hide all error messages
        $('.error-message').hide();
        $('#dobError').hide(); // Ensure DOB error message is hidden specifically
    }
});

</script>
<script>

//--------------Handles edit student -----------------------------//

document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0];
    $('#editjDate').attr('max', today);
$('#updateBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
       
        // Validate fields
        isValid &= validateName('editFname', 'fnameErrorE');
        isValid &= validateDOB('editDob', 'dobErrorE');
        isValid &= validateField('editGender', 'genderErrorE');
        isValid &= validatePhoneNumber('editPhone', 'phoneErrorE');
        isValid &= validateEmail('editPemail', 'pemailErrorE');
        isValid &= validateField('editRole', 'roleErrorE');
        isValid &= validateField('editAddress', 'addressErrorE');
        isValid &= validateField('editms', 'msErrorE');
        isValid &= optionalEmail('editCemail', 'cemailErrorE');

        if (isValid) {
                        $('#editEmployee').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

                // Handle the form submission via AJAX
                $('#editEmployee').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actEmployee.php",
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
                                    $('#editEmployeeModal').modal('hide'); // Close the modal
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
                                text: 'An error occurred while Editing Employee data.'
                            });
                        }
                    });
                });
                $('#editCloseBtn').click(function () {
                    hideErrorMessages(); // Call the function to hide error messages
                });
        });


</script>

	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
</body>

</html>