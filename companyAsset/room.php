<?php

session_start();
include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "SELECT
                    `room_id`,
                    `room_name`
                FROM
                    `room_tbl`
                WHERE
                    `room_status` = 'Active'";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
<?php include("formRoom.php");?>
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
        <?php include("top.php"); ?>
		<!--end sidebar wrapper -->
		<!--start header -->
        <?php include("left.php"); ?>
			
		<!--end header -->
		<!--start page wrapper -->
		
		<div class="page-wrapper">

          
			<div class="page-content">
                
				
            <div class="page-title-box">
                <div class="page-title-right pb-3">
                    <h2 class="page-title text-muted text-decoration-underline">Room Details</h2>
                    <div class="d-flex justify-content-end">
                        <?php if ($_SESSION['is_admin'] === 'True') { ?> 
                        <button type="button" id="addRoomBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addRoomModal"><i class="lni lni-upload me-1"></i>Add Room</button>
                        <?php } ?>
                    </div>
                </div>
            </div>

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Room Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                <?php
                                $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                           
                                $room_id          = $row['room_id'];  
                                $room_name = htmlspecialchars($row['room_name'], ENT_QUOTES);

                                ?>
                                <tr>
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $room_name; ?></td>
                                <td>
                                     <?php
                                        if ($_SESSION['is_admin'] == 'True') { ?>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditRoom(<?php echo $room_id; ?>, '<?php echo $room_name; ?>');" data-bs-toggle="modal" data-bs-target="#editRoomModal"><i class="lni lni-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteRoom(<?php echo $room_id; ?>);"><i class="lni lni-trash"></i></button>
                                    <?php }?>
                                </td>
                                </tr>
                    <?php
                 } 
                 ?>   
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

     <!-- Initialize tooltips -->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <!--app JS-->
	<script src="<?php echo $app; ?>"></script>
    
<script src="../assets/js/form-validation.js"></script>
</body>

<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
		function resetForm(formId) {
            var form = $('#' + formId);
            form[0].reset();
            form.removeClass('was-validated');
        }
</script>
<script>
$(document).ready(function() {
    
    $('#addRoomBtn').on('click', function() {
        resetForm('roomForm');  // Reset the form fields
        $('#submitFormBtn').prop('disabled', false); // Enable the submit button
    });
    // Handle the form submission via AJAX for Add Room
    $('#roomForm').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; 
        }

        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
        $.ajax({
            url: "action/actRoom.php",
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
                        $('#addRoomModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
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
                    resetForm('roomForm');
                    $('#submitFormBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#submitFormBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding Room data.'
                });
                $('#submitFormBtn').prop('disabled', false);
            }
        });
    });
    
    // Handle the form submission via AJAX for Edit Room
    $('#roomEditForm').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        $.ajax({
            url: "action/actRoom.php",
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
                        $('#editRoomModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
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
                    resetForm('roomEditForm');
                    $('#submitEditBtn').prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    $('#submitEditBtn').prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating Room data.'
                });
                $('#submitEditBtn').prop('disabled', false);
            }
        });
    });
});
</script>
<script>
//Function to populate the edit form with the room details for editing.
function goEditRoom(roomId, roomName) {
    resetForm('roomEditForm');  
    
    $('#submitEditBtn').prop('disabled', false); 
    $('#roomId').val(roomId);
    $('#editName').val(roomName);
}

//Function to handle the deletion of a room.
function goDeleteRoom(roomId) {
    // Show confirmation dialog before deletion
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,  
        confirmButtonColor: '#3085d6',  
        cancelButtonColor: '#d33',  
        confirmButtonText: 'Yes, delete it!',  
        reverseButtons: true 
    }).then((result) => {
        // If the user confirmed the deletion
        if (result.isConfirmed) {
            $.ajax({
                url: 'action/actRoom.php',  
                method: 'POST',
                data: { delId: roomId },  
                dataType: 'json',  
                success: function(response) {
                    // If the deletion was successful
                    if (response.success) {
                        Swal.fire({
                            title: 'Deleted!',  
                            text: response.message,  
                            icon: 'success',  
                            timer: 3000,  
                            showConfirmButton: false 
                        }).then(() => {
                            // Reload the table or data after deletion
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
                        });
                    } else {
                        // Show error message if deletion failed
                        Swal.fire({
                            title: 'Error!',  
                            text: response.message,  
                            icon: 'error',  
                            timer: 3000,  
                            showConfirmButton: false 
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message if AJAX request failed
                    Swal.fire({
                        title: 'Error!',  
                        text: 'An error occurred while deleting the room.',  
                        icon: 'error', 
                        showConfirmButton: false, 
                        timer: 3000  
                    });
                }
            });
        }
    });
}

</script>
</html>