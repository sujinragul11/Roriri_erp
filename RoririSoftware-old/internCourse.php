<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT a.*, b.* 
    FROM client_tbl AS a
    LEFT JOIN project_tbl as b ON a.client_id=b.client
    WHERE a.client_status='Active'
    GROUP BY a.client_id
    ORDER BY
    a.client_id DESC";
    
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
        <?php include "internshipLeft.php";?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include("top.php");?>
		<!--end header -->
		<!--start page wrapper -->
        <?php include("formCourse.php");?>
		
		<div class="page-wrapper">
			<div class="page-content">


            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Course</h2>
                    <div class="col text-end pb-3">
                    <button type="button" class="btn btn-primary px-5 radius-30" data-bs-toggle="modal" data-bs-target="#courseModal">Add Course</button>
                    </div>

                </div>
                   
            </div>

            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">

           <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="text-center">
                        <div class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3">
                            <i class='bx bx-code-alt'></i> <!-- Full Stack Development Icon -->
                        </div>
                        <h4 class="my-1">24</h4>
                        <p class="mb-0 text-secondary">Full Stack Development</p>
                    </div>
                </div>
            </div>
        </div>

                    <div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="text-center">
									<div class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3"><i class='bx bxl-facebook-square'></i>
									</div>
									<h4 class="my-1">84K</h4>
									<p class="mb-0 text-secondary">Facebook Users</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="text-center">
									<div class="widgets-icons rounded-circle mx-auto bg-light-danger text-danger mb-3"><i class='bx bxl-twitter'></i>
									</div>
									<h4 class="my-1">34M</h4>
									<p class="mb-0 text-secondary">Twitter Followers</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="text-center">
									<div class="widgets-icons rounded-circle mx-auto bg-light-info text-info mb-3"><i class='bx bxl-linkedin-square'></i>
									</div>
									<h4 class="my-1">56K</h4>
									<p class="mb-0 text-secondary">Linkedin Followers</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="text-center">
									<div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i class='bx bxl-youtube'></i>
									</div>
									<h4 class="my-1">38M</h4>
									<p class="mb-0 text-secondary">YouTube Subscribers</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="text-center">
									<div class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3"><i class='bx bxl-dropbox'></i>
									</div>
									<h4 class="my-1">28K</h4>
									<p class="mb-0 text-secondary">Dropbox Users</p>
								</div>
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
            document.getElementById('saveCourse').addEventListener('click', function () {
  var form = document.getElementById('courseForm');
  if (form.checkValidity() === false) {
    form.classList.add('was-validated'); // Add Bootstrap validation class
    return;
  }

  // Extract form data
  var courseName = document.getElementById('courseName').value;
  var courseCategory = document.getElementById('courseCategory').value;
  var courseDuration = document.getElementById('courseDuration').value;
  var courseLevel = document.getElementById('courseLevel').value;

  // Handle form submission here
  console.log('Course Name:', courseName);
  console.log('Course Category:', courseCategory);
  console.log('Course Duration:', courseDuration);
  console.log('Course Level:', courseLevel);

  // Close the modal (if needed)
  var modal = bootstrap.Modal.getInstance(document.getElementById('courseModal'));
  modal.hide();
});

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
        // function goViewClient(id){
            
        //     location.href = "clientDetails.php?id="+id;

        // }
function goEditClient(id) 
  
  {
    $.ajax({
        url: 'action/actClient.php',
        method: 'POST',
        data: {
            editIdClient: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#editIdClient').val(response.client_id);
          $('#CnameE').val(response.client_name);
          $('#compNameE').val(response.comp_name);
          $('#cAddressE').val(response.address);
          $('#cEmailE').val(response.email);
          $('#cPhoneE').val(response.phone);
          $('#gstE').val(response.gst);
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}
function goDeleteClient(id)
{
    //alert(id);
    if(confirm("Are you sure you want to delete Client?"))
    {
      $.ajax({
        url: 'action/actClient.php',
        method: 'POST',
        data: {
          clientdeleteId: id
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
<script>
        $(document).ready(function () {


                // Handle the form submission
                $('#submitBtn').click(function (e) {
                    e.preventDefault(); // Prevent default form submission

                    var isValid = true;

                    // Validate fields
                    isValid &= validateName('Cname', 'nameError');
                    isValid &= validateField('compName', 'companyError');
                    isValid &= validatePhoneNumber('cPhone', 'phoneError');
                    isValid &= validateEmail('cEmail', 'emailError');
                   
                    isValid &= validateField('cAddress', 'addressError');
                    

                    if (isValid) {
                        $('#addClient').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

                // Handle the form submission via AJAX
                $('#addClient').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actClient.php",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json', // Expect JSON response
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 2000
                                }).then(function () {
                                    $('#addClientModal').modal('hide'); // Close the modal
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

                                // Reset the form after successful submission
                                resetForm('addClient');
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
                                text: 'An error occurred while adding Client data.'
                            });
                        }
                    });
                });

                // Reset the form when the close button is clicked
                $('#modalCloseBtn').click(function () {
                    resetForm('addClient');
                });
        });

                // Function to reset the form and hide error messages
                function resetForm(formId) {
                document.getElementById(formId).reset(); // Reset the form
                $('.error-message').hide(); // Hide all error messages
                }

</script>
<script>

//--------------Handles edit Clients-----------------------------//

document.addEventListener('DOMContentLoaded', function() {
$('#updateBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
       
        // Validate fields
        isValid &= validateName('CnameE', 'nameErrorE');
        isValid &= validateField('compNameE', 'comErrorE');
        isValid &= validatePhoneNumber('cPhoneE', 'phoneErrorE');
        isValid &= validateEmail('cEmailE', 'emailErrorE');
        isValid &= validateField('cAddressE', 'addressErrorE');

        if (isValid) {
                        $('#editClient').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

                // Handle the form submission via AJAX
                $('#editClient').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actClient.php",
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
                                    $('#editClientModal').modal('hide'); // Close the modal
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
                                text: 'An error occurred while Editing Clients data.'
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