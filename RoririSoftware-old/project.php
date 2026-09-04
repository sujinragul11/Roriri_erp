<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");
$selQuery = "SELECT 
    project_tbl.*, 
    client_tbl.*, 
    SUM(project_amount.amnt_received) AS total_received 
FROM 
    project_tbl
LEFT JOIN 
    client_tbl ON client_tbl.client_id = project_tbl.client
LEFT JOIN 
    project_amount ON project_amount.project_id = project_tbl.project_id
    WHERE project_tbl.status='Active'
GROUP BY 
    project_tbl.project_id, client_tbl.client_id 
ORDER BY
    project_tbl.project_id DESC
";

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
        <?php include("addProject.php");
         include("editProject.php");?>
        
        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <h2 class="page-title">Projects</h2>
                        <div class="position-relative" style="height: 80px;">
                            <!-- Adjust height as needed -->
                            <button type="button" id="addProjectBtn" class="btn btn-primary position-absolute top-0 end-0" data-bs-toggle="modal" data-bs-target="#addProjectModal">Add Project</button>
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
                                        <th>Project Name</th>
                                        <th>Client Name</th>
                                        <th>Total Payment</th>
                                        <th>Balance</th>
                                        <th>Project Status</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                    
                                    $i=1; 
                                    while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                        $project_id = $row['project_id'];     
                                        $project_name = $row['project_name'];  
                                        $programming = $row['technology'];  
                                        $developers = $row['developers'];
                                        $client = $row['client_name'];   
                                        $startDate = $row['start_date'];
                                        $services=$row['services'];
                                        // $endDate=$row['end_date'];
                                        $duration=$row['duration'];
                                        $rec=$row['total_received'];
                                        $charge=$row['total_pay'];
                                        $pro_status=$row['project_status'];  
                                        $pay_status=$row['pay_status'];
                                        // $rec=$row['amnt_received'];
                                        $programmingArray = json_decode($programming);
                                        $developerArray=json_decode($developers);
                                        $balance=$charge-$rec;
                                        

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
                                        
                                        
                                    ?>
                                    <tr>
                                        <td><?php echo $i; $i++; ?></td>
                                        <td><?php echo $project_name; ?></td>
                                        <td><?php echo $client; ?></td>
                                        <td><i class="lni lni-rupee"></i><?php echo number_format($charge,2); ?></td>
                                        <td><i class="lni lni-rupee"></i><?php echo number_format($balance,2); ?></td>
                                        <td><?php echo $pro_status; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="goViewProject(<?php echo $project_id; ?>);"><i class="lni lni-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditProject(<?php echo $project_id; ?>);" data-bs-toggle="modal" data-bs-target="#editProjectModal"><i class="lni lni-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="goDeleteProject(<?php echo $project_id; ?>);"><i class="lni lni-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php  } ?>
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
    <script src="<?php  echo $bootsrapBundle; ?>"></script>
    <!--plugins-->
    <script src="<?php echo $js; ?>"></script>
    <script src="<?php echo $simplebar;?>"></script>
    <script src="<?php echo $mentimenu; ?>"></script>
    <script src="<?php echo $perfectScrolbar;  ?>"></script>
    <script src="<?php echo $datatableMin; ?>"></script>
    <script src="<?php echo $datatbaleBootstrap;?>"></script>
    <script src="<?php echo $sweetalert ?>"></script>
    <script src="<?php echo $select2; ?>"></script>
    <script src="<?php echo $select2Custom;?>"></script>
    <!--app JS-->
    <script src="<?php echo $app; ?>"></script>
    <!-- Include the function.js -->
    <script src="../assets/js/function.js"></script>
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

    <script>
        function validateField(fieldId, errorId) {
                var value = $('#' + fieldId).val();
                if (value === null || value.length === 0 || (Array.isArray(value) && value[0] === '')) {
                    $('#' + errorId).show();
                    return false;
                } else {
                    $('#' + errorId).hide();
                    return true;
                }
            }
        $(document).ready(function () {
            


            // Handle the form submission
            $('#submitBtn').click(function (e) {
                    e.preventDefault(); // Prevent default form submission

                    var isValid = true;

                    // Validate fields
                    isValid &= validateField('pname', 'nameError');
                    isValid &= validateField('clientName', 'clientError');
                    isValid &= validateField('service', 'ServiceError');
                    isValid &= validateField('multiple-select-clear-field', 'technologyError');
                    isValid &= validateField('multiple-select-custom-field', 'developersError');
                    isValid &= validateField('startDate', 'dateError');
                    isValid &= projectDuration('duration', 'durationError');
                    isValid &= projectAmount('charge', 'chargeError');
                    isValid &= validateField('proStatus', 'projectError');
                    

                    if (isValid) {
                        $('#addProject').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

            $('#addProject').off('submit').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting normally

                var formData = new FormData(this);
                $.ajax({
                    url: "action/actProject.php",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 2000
                            }).then(function() {
                                $('#addProjectModal').modal('hide'); // Close the modal
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
                            resetForm('addProject');

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
                            text: 'An error occurred while adding Project data.'
                        });
                        $('#submitBtn').prop('disabled', false);
                    }
                });
            });

            // Reset the form when the close button is clicked
            $('#modalCloseBtn').click(function () {
                resetForm('addProject');
            });
            
        });
        // Function to reset the form and hide error messages
        function resetForm(formId) {
        $('#' + formId)[0].reset(); // Reset the form using jQuery
        // Reset the Select2 multiselect fields
    $('#multiple-select-clear-field').val(null).trigger('change'); // Reset Technology multiselect
    $('#multiple-select-custom-field').val(null).trigger('change'); // Reset Developers multiselect
        // Hide all error messages
        $('.error-message').hide();
       
    }

        //--------------Handles edit Project-----------------------------//

        document.addEventListener('DOMContentLoaded', function() {
        $('#updateBtn').click(function(e) {
        e.preventDefault();
        var isValid = true;
        // Validate fields
       
        // Validate fields
        isValid &= validateField('pnameE', 'nameErrorE');
        isValid &= validateField('clientNameE', 'clientErrorE');
        isValid &= validateField('editService', 'serviceErrorE');
        isValid &= validateField('multiple-select-optgroup-field', 'technologyErrorE');
        isValid &= validateField('multiple-select-field', 'developersErrorE');
        isValid &= validateField('startDateE', 'startErrorE');
        isValid &= projectDuration('durationE', 'durationErrorE');
        isValid &= projectAmount('chargeE', 'chargeErrorE');
        isValid &= validateField('proStatusE', 'statusErrorE');

        if (isValid) {
                        $('#editProject').trigger('submit'); // Manually trigger the form submit event if validation passes
                    }
                });

                // Handle the form submission via AJAX
                $('#editProject').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent normal form submission

                    var formData = new FormData(this);
                    $.ajax({
                        url: "action/actProject.php",
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
                                    $('#editProjectModal').modal('hide'); // Close the modal
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
                                text: 'An error occurred while Editing Projects data.'
                            });
                        }
                    });
                });
                $('#editCloseBtn').click(function () {
                    hideErrorMessages(); // Call the function to hide error messages
                });
        });
</script>
<script>

        function goViewProject(id) {
           
            location.href = "projectDetails.php?id=" + id;
        }
        
        function goEditProject(id) {
    $.ajax({
        url: 'action/actProject.php',
        method: 'POST',
        data: {
            editPro: id
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            // Set the form fields with the response data
            $('#editPro').val(response.pro_id);
            $('#pnameE').val(response.project_name);
            $('#descriptionE').val(response.description);
            $('#chargeE').val(response.charge);
            $('#startDateE').val(response.startDate);
            $('#durationE').val(response.duration);
            $('#proStatusE').val(response.pro_status);
            $('#clientNameE').val(response.client).trigger('change');

            // Handle programming array
            const programmingArray = JSON.parse(response.programming);
            $('#multiple-select-optgroup-field').val(programmingArray).trigger('change');
            

            // Handle developers array
            const developersArray = JSON.parse(response.developers);
            $('#multiple-select-field').val(developersArray).trigger('change');

            const servicesArray = JSON.parse(response.services);
                    console.log(servicesArray); // Log parsed array
                    $('#editService').val(servicesArray).trigger('change');
                    $('#editService').selectpicker('refresh');

    
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching the project data.'
            });
        }
    });
}


        function goDeleteProject(id) {
            if (confirm("Are you sure you want to delete Project?")) {
                $.ajax({
                    url: 'action/actProject.php',
                    method: 'POST',
                    data: {
                        deleteId: id
                    },
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
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                    }
                });
            }
        }
    </script>




</body>
</html>
