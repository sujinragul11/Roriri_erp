<?php
session_start();
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../db/dbConnection.php");
    include("../url.php");
    include("action/function.php");
    
    if(isset($_GET['id']) && $_GET['id'] != '') {
        $proId = $_GET['id'];
    
        // Prepare and execute the SQL query
        $selQuery = "SELECT project_tbl.*,
        client_tbl.*,
        SUM(project_amount.amnt_received)AS total_received 
        FROM project_tbl
        LEFT JOIN 
        client_tbl on client_tbl.client_id=project_tbl.client
        LEFT JOIN 
        project_amount ON project_amount.project_id = project_tbl.project_id
        WHERE project_tbl.project_id='$proId'";
        
        $result1 = $conn->query($selQuery);
    
        if($result1) {
            // Fetch employee details
            $row = mysqli_fetch_array($result1 , MYSQLI_ASSOC);
            $id = $row['project_id']; 
			      $project_name=$row['project_name'];
            $client_name = $row['client_name'];
            $programming = $row['technology'];
            $developers=$row['developers'];
            $duration=$row['duration'];
            $description=$row['description'];
            $email=$row['client_email'];
            $address=$row['client_location'];
            $mobile=$row['client_phone'];
            $start_date=$row['start_date'];
            $pro_status=$row['project_status'];
            $charge=$row['total_pay'];
            $receive=$row['total_received'];
			      $pay_status = $row['pay_status'];
            $programmingArray = json_decode($programming);
            $developerArray=json_decode($developers);
            $balance=$charge-$receive;
            // Check if $programmingArray is an array
            if (is_array($programmingArray)) {
                // Output each element separated by commas
                $pro= implode(', ', $programmingArray);
            } else {
                // Handle case where $programming is not a valid JSON array
                $pro= $programming; // Output as-is (may need additional handling)
            }  
            // Check if $developerArray is an array
            if (is_array($developerArray)) {
                // Output each element separated by commas
                $dev= implode(', ', $developerArray);
            } else {
                // Handle case where $programming is not a valid JSON array
                $dev= $developerArray; // Output as-is (may need additional handling)
            }  
            $empQuery = "SELECT * FROM basic_details WHERE id IN ($dev)";
            $empResult = $conn->query($empQuery);

            $techQuery="SELECT * FROM `technology` WHERE tech_id IN($pro)";
            $techResult=$conn->query($techQuery);

			// Construct the image path
			// $image_path = "image/Employee/" . $emp_img;   
    
        } else {
            echo "Error executing query: " . $conn->error;
        }
    } else {
        // If employee id is not provided, redirect to employees.php
        header("Location: project.php");
        exit(); // Ensure script stops executing after redirection
    }
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>
<?php include("addPayment.php"); ?>
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
		<div class="page-wrapper">
			<div class="page-content">
				
				
<div class="container">
  <div class="main-body">
    <div class="modal-footer d-flex justify-content-between p-2">
      <button type="button" class="btn btn-danger me-auto" onclick="javascript:location.href='project.php'"><i class='bx bx-arrow-back'></i></button>
      <button type="button" id="addPaymentBtn" onclick="goShow(<?php echo $proId;?>);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">Payment</button>
    </div>
    <div class="row mb-5"> <!-- added mb-5 class to set bottom margin -->
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="<?php echo $default_logo; ?>" alt="<?php echo $project_name;?>" class="rounded-circle p-1" width="110">
              <div class="mt-3">
                <h4><?php echo $project_name;?></h4>
                <p class="text-secondary mb-1"><?php echo $description;?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card h-100">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-3">
                <h6 class="mb-0">Client Name</h6>
              </div>
              <div class="col-sm-4 text-secondary">
                <p class="text-secondary mb-1"><?php echo $client_name;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <h6 class="mb-0">Email</h6>
              </div>
              <div class="col-sm-4 text-secondary">
                <p class="text-secondary mb-1"><?php echo $email;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <h6 class="mb-0">Developers</h6>
              </div>
              <div class="col-sm-4 text-secondary">
                <p class="text-secondary mb-1"><?php if ($empResult) {
                      // Fetch associative array of rows
                      while ($row = $empResult->fetch_assoc()) {
                        // Access employee name from each row
                        $empName = $row['name'];
                       
                        
                        // Output or process $employeeName as needed
                        echo " $empName <br>";
                      }
                    } else {
                      // Handle query error
                      echo "Query error: ". $conn->error;
                    }?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <h6 class="mb-0">Programming</h6>
              </div>
              <div class="col-sm-3 text-secondary">
                <p class="text-secondary mb-1"><?php 
                if($techResult){
                  while($rowT=$techResult->fetch_assoc()){
                    $techName=$rowT['tech_name'];
                    echo "$techName <br>";
                  }
                }else{
                    echo "Query error:".$conn->error;
                  }
                
                ?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <h6 class="mb-0">Address</h6>
              </div>
              <div class="col-sm-3 text-secondary">
                <p class="text-secondary mb-1"><?php echo $address;?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <h6 class="mb-0">Total Amount</h6>
              </div>
              <div class="col-sm-3 text-secondary">
                <p class="text-secondary mb-1"><i class="lni lni-rupee"></i><?php echo number_format($charge,2);?></p>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <h6 class="mb-0">Balance Amount</h6>
              </div>
              <div class="col-sm-3 text-secondary">
                <p id="balanceDisplay" class="text-secondary mb-1"><i class="lni lni-rupee"></i><?php echo number_format($balance,2);?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  <!--End Container-->
                <div class="container">
                    <div class="main-body">
                        <div class="row">
                            <div class="col-12"> 
                                <div class="card">
                                    <div class="card-body">
                                    <div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S. NO</th>
										<th>Date</th>
										<th>Received Amount</th>
										<th>Received By</th>
										<th>Payment Mode</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $selPay="SELECT project_tbl.*, project_amount.*
													FROM project_amount
													LEFT JOIN project_tbl ON project_tbl.project_id=project_amount.project_id
                                                    WHERE project_amount.project_id='$proId'
                                                     ORDER BY project_amount.pay_date DESC";
										$resPay = mysqli_query($conn , $selPay); 
										$i=1;
										while($rowPay=mysqli_fetch_array($resPay , MYSQLI_ASSOC)){
											$pID=$rowPay['pro_amt_id'];
											$amtReceived=$rowPay['amnt_received'];
											$date=$rowPay['pay_date'];
											$pay_mode=$rowPay['pay_mode'];
											$received=$rowPay['received_by'];
											$total_pay=$rowPay['total_pay'];
											
											

										
									 ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo formatDate($date); ?></td>
										<td><i class="lni lni-rupee"></i><?php echo number_format($amtReceived,2); ?></td>
										<td><?php echo $received; ?></td>
										<td><?php echo $pay_mode; ?></td>
										<td><button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditPayment(<?php echo $pID; ?>);" data-bs-toggle="modal" data-bs-target="#editPaymentModal"><i class="lni lni-pencil"></i></button></td>
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
                </div> <!--End Container 2-->
			</div> <!--End page-content-->
		</div><!--end page-wrapper-->
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->




	<!--start switcher-->

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
    <script src="<?php echo $sweetalert; ?>"></script>
    <script src="<?php echo $select2; ?>"></script>
    <script src="<?php echo $select2Custom;?>"></script>
    <!--app JS-->
    <script src="<?php echo $app; ?>"></script>
    <!-- Include the function.js -->
    <script src="../assets/js/function.js"></script>
    <script>
        
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

        //Handles fetch the data
	
		function goShow(id) {
    $.ajax({
        url: 'action/actPayment.php',
        method: 'POST',
        data: {
            proId: id
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
			

          $('#proId').val(response.pro_id);
          $('#proName').val(response.project_name);
          $('#overAmnt').val(response.charge);
          $('#amntReceived').val(response.iniPay);
          
		  
   
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });
}

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

                   // Handle programming array
            
                 },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                }
            });
	}
	</script>
    
	<script>
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
          $('#addPayment').trigger('submit'); // Manually trigger the form submit event if validation passes
          console.log("Form submitted"); // Debug message
        }
    });

    // Handle form submission
    $('#addPayment').off('submit').on('submit', function(e) {
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
                        $('#addPaymentModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop
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
    $('#modalCloseBtn').click(function () {
        resetForm('addPayment');
    });

   
});
// Function to reset the form and hide error messages
function resetForm(formId) {
    document.getElementById(formId).reset(); // Reset the form
    $('.error-message').hide(); // Hide all error messages
  }


 //--------------Handles edit Payment-----------------------------//

 document.addEventListener('DOMContentLoaded', function() {
$('#updateBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
       
        // Validate fields
      isValid &= validateField('balanceE', 'amountErrorE');
      isValid &= validateField('dateE', 'dateErrorE');
      isValid &= validateField('payModeE', 'modeErrorE');
      isValid &= validateField('payStatus', 'statusErrorE');
      isValid &= validateName('receivedE', 'receivedErrorE');
      

        if (isValid) {
                        $('#editPayment').trigger('submit'); // Manually trigger the form submit event if validation passes
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
                                text: 'An error occurred while Editing Payment data.'
                            });
                        }
                    });
                });
                $('#editCloseBtn').click(function () {
                    hideErrorMessages(); // Call the function to hide error messages
                });
        });
</script>
	
</body>

</html>