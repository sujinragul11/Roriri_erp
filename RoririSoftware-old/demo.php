<?php
session_start();
include("C:\\xampp\\htdocs\\ERP\\db\\dbConnection.php");
include("url.php");
$selQuery = "SELECT project_tbl.*,
client_tbl.* FROM project_tbl
LEFT JOIN client_tbl ON client_tbl.client_id=project_tbl.client
WHERE project_tbl.status='Active'
";

$resQuery = mysqli_query($conn , $selQuery); 
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <?php include("left.php");?>
        <!--end sidebar wrapper -->
        <!--start header -->
        <?php include("top.php");?>
        <!--end header -->
        <!--start page wrapper -->
        <?php include("addProject.php");?>
        
        <div class="page-wrapper">
            <div class="page-content">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <h4 class="page-title">Projects</h4>
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
                                        <th>Project Status</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                        $project_id = $row['project_id'];     
                                        $project_name = $row['project_name'];  
                                        $programming = $row['programming'];  
                                        $developers = $row['developers'];
                                        $client = $row['client_name'];   
                                        $startDate = $row['start_date'];
                                        $endDate=$row['end_date'];
                                        $duration=$row['duration'];
                                        
                                        $charge=$row['total_pay'];
                                        $pro_status=$row['project_status'];  
                                        $pay_status=$row['pay_status'];
                                        
                                        $programmingArray = json_decode($programming);
                                        $developerArray=json_decode($developers);

                                        

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
                                        <td><?php echo $charge; ?></td>
                                        <td><?php echo $pro_status; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success" onclick="goViewProject(<?php echo $project_id; ?>);"><i class="lni lni-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditProject(<?php echo $project_id; ?>);" data-bs-toggle="modal" data-bs-target="#editProjectModal"><i class="lni lni-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="goDeleteProject(<?php echo $project_id; ?>);"><i class="lni lni-trash"></i></button>
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
    <?php include("theme.php");?>
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
    <script src="<?php echo $sweetalert ?>"></script>
    <script src="<?php echo $select2; ?>"></script>
    <script src="<?php echo $select2Custom;?>"></script>
    <!--app JS-->
    <script src="<?php echo $app; ?>"></script>

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
        $(document).ready(function () {
            // $('#example2').DataTable({
            //     "paging": true,
            //     "ordering": true,
            //     "searching": true
            // });

            $('#submitBtn').click(function () {
                $('#addProject').submit();
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
                                        $('#example2').DataTable().destroy();
                                        $('#example2').DataTable({
                                            "paging": true,
                                            "ordering": true,
                                            "searching": true
                                        });
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

            // Function to reset the form
            function resetForm(formId) {
                document.getElementById(formId).reset(); // Reset the form
            }

            
        });

        //--------------Handles edit Project-----------------------------//

document.addEventListener('DOMContentLoaded', function() {
    $('#editProject').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this);
        $.ajax({
            url: "action/actProject.php",
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
                        $('#editProjectModal').modal('hide'); // Close the modal
                        $('.modal-backdrop').remove(); // Remove the backdrop   
                        $('#example2').load(location.href + ' #example2 > *', function() {
                            $('#example2').DataTable().destroy();
                            $('#example2').DataTable({
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
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating Project data.'
                });
                $('#updateBtn').prop('disabled', false);
            }
        });
    });
    $('#updateBtn').on('click', function() {
        $('#editProject').submit();
    });
});


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
                    $('#editPro').val(response.pro_id);
                    $('#pnameE').val(response.project_name);
                    $('#descriptionE').val(response.description);
                    $('#multiple-select-clear-field').val(response.programming);
                    $('#multiple-select-custom-field').val(response.developers);
                    $('#iniPayE').val(response.iniPay);
                    $('#proStatusE').val(response.pro_status);
                    $('#chargeE').val(response.charge);
                    $('#startDateE').val(response.startDate);
                    $('#clientNameE').val(response.client);
                    $('#durationE').val(response.duration);
                   // Handle programming array
            const programmingArray = JSON.parse(response.programming);
            $('#multiple-select-optgroup-field').val(programmingArray).trigger('change'); // Use trigger to update select field

            // Handle developers array
            const developersArray = JSON.parse(response.developers);
            $('#multiple-select-field').val(developersArray).trigger('change'); // Use trigger to update select field
                 },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
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
                            $('#example2').DataTable().destroy();
                            $('#example2').DataTable({
                                "paging": true,
                                "ordering": true,
                                "searching": true
                            });
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
