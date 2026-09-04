<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
date_default_timezone_set('Asia/Kolkata');
$todayDate = date('Y-m-d');

    $selQuery = "SELECT
                    a.`intern_id`,
                    a.`name`,
                    a.`total_workingdays`,
                    b.`intern_course_name`,
                    c.`name` AS empName
                FROM
                    `internship_tbl` AS a
                LEFT JOIN 
                	`inter_course_tbl` AS b
                ON
                    a.`inte_cou_id` = b.`inte_cou_id`
                LEFT JOIN 
                	`basic_details` AS c
                ON
                    a.`incharge_id` = c.`id`
                WHERE
                    a.`status` = 'Active';";
    $resQuery = mysqli_query($conn , $selQuery); 
    
    $attendanceQuery = "SELECT 
                            date, 
                            present_ids 
                        FROM 
                            intern_attendance
                        WHERE 
                            date = '$todayDate' 
                            AND status = 'Active'";

    $attendanceResult = mysqli_query($conn, $attendanceQuery);
    $presentIds = [];
    if ($attendanceResult && mysqli_num_rows($attendanceResult) > 0) {
        $attendanceRow = mysqli_fetch_assoc($attendanceResult);
        $presentIds = json_decode($attendanceRow['present_ids'], true); // Decode JSON data into an array
    }else {
        $presentIds = null;
    }
    ?>
    <!doctype html>
    <html lang="en">
    
    <?php include("head.php");?>
    
    <body>
    
    	<!--wrapper-->
    	<div class="wrapper">
    		<!--sidebar wrapper -->
    			<?php include("internshipLeft.php");?>
    		<!--end sidebar wrapper -->
    		<!--start header -->
    			<?php include("top.php");?>
    		<!--end header -->
    		<!--start page wrapper -->
    		<?php include "formAttendance.php";?>
    		<div class="page-wrapper">
    			<div class="page-content" id="attendanceTbl">
                    
    				
                <div class="page-title-box">
                    
                    <div class="page-title-right">
                        <h2 class="page-title">Attendance Details</h2>
                        <div class="col text-end pb-3">
                            <?php if ($presentIds === null): ?>
                            <button type="button" id="addAttendance" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
                                <i class="bx bx-plus"></i>Add Attendance
                            </button>
                            <?php endif; ?>
                            <button type="button" id="editAttendance" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAttendanceModal" onclick="editAttendance('<?php echo date('Y-m-d'); ?>')" <?php if ($presentIds === null) echo 'disabled'; ?>>
                                <i class="bx bx-pencil"></i>Edit Attendance
                            </button>
                        </div>
                    </div>
                       
                </div>
    
    				<div class="card">
    					<div class="card-body">
    						<div class="table-responsive">
    							<table id="example2" class="table table-striped table-bordered">
    								<thead>
    									<tr>
                                            <th class="col-1 text-center">S. No</th>
    										<th class="col-2 text-center">Date</th>
                                            <th class="col-2 text-center">Intern Name</th>
                                            <th class="col-2 text-center">Course Name</th>
                                            <th class="col-2 text-center">Incharge Name</th>
                                            <th class="col-2 text-center">Attendance</th>
                                            <th class="col-1 text-center">Total</th>
    									</tr>
    								</thead>
    								<tbody>
                                        <?php $i=1; while($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) { 
                                            $id         = $row['intern_id'];  
                                            $name       = $row['name'];   
                                            $course     = $row['intern_course_name'];
                                            $empName    = !empty($row['empName']) ? $row['empName'] : '-';
                                            $date       = date('d M Y');
                                            $workDays   = $row['total_workingdays'];
                                            $attendance = ($presentIds === null) ? '-' : (in_array($id, $presentIds) ? 'Present' : 'Absent');
                                        ?>
                                        <tr>
                                            <td class="col-1 text-center"><?php echo $i; $i++; ?></td>
                                            <td class="col-2 text-center"><?php echo $date; ?></td>
                                            <td class="col-2 text-center"><?php echo $name; ?></td>
                                            <td class="col-2 text-center"><?php echo $course; ?></td>
                                            <td class="col-2 text-center"><?php echo $empName; ?></td>
                                            <td class="col-2 text-center"><?php echo $attendance; ?></td>
                                            <td class="col-1 text-center"><?php echo $workDays; ?></td>
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
		 <?php include "footer.php"; ?>
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

     <!-- Initialize tooltips -->
     <script>
     function resetForm(formId) {
            var form = $('#' + formId);
            form[0].reset();
        }
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });

    </script>

	<script>
	
	        function editAttendance(date) {
                loadInternsEdit('All', true);
                resetForm('editAttendanceForm');
                $('#inchargeNameEdit').val('All');
                // Fetch the attendance data for the given date
                $.ajax({
                    url: 'action/actAttendance.php', 
                    type: 'POST',
                    data: { dateFetch : date },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            const presentInterns = response.presentInterns || [];
                            const absentInterns = response.absentInterns || [];
                            $('#dateEdit').val(date);
                            presentInterns.forEach(function (internId) {
                                $(`#internEdit${internId}`).prop('checked', true);
                            });
            
                            absentInterns.forEach(function (internId) {
                                $(`#internEdit${internId}`).prop('checked', false);
                            });
                        } else {
                            alert('Failed to fetch attendance data for the specified date.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while fetching the attendance data.');
                    }
                });
            }
            
            function loadInternsEdit(inchargeId, isEditAttendance = false) {
                $.ajax({
                    url: 'action/actAttendance.php', // PHP file to fetch interns
                    type: 'POST',
                    data: { inchargeId: inchargeId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#internListEdit .form-check').show();
                            if (inchargeId === "All" && isEditAttendance) {
                                let html = '';
                                response.data.forEach(function (intern) {
                                    html += `
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="internEdit${intern.id}" name="internsEdit[]" value="${intern.id}">
                                                <label class="form-check-label" for="internEdit${intern.id}">${intern.name}</label>
                                            </div>
                                        </div>`;
                                });
                                $('#internListEdit').html(html);
                                $('#selectAllInternsEdit').closest('.form-check').show();
                                $('#selectAllInternsEdit').prop('checked', false);
                                $('#selectAllInternsEdit').change(function() {
                                    const isChecked = $(this).prop('checked');
                                    $('#internListEdit .form-check-input').prop('checked', isChecked);
                                });
                            } else if (inchargeId === "All" && !isEditAttendance) {
                                // If "All" comes from #inchargeNameEdit, show only matched checkboxes
                                $('#internListEdit .form-check').each(function () {
                                    const checkboxId = $(this).find('.form-check-input').val(); // Get the ID of the checkbox
                                    const isMatched = response.data.some(function (intern) {
                                        return intern.id == checkboxId; // Check if the checkbox ID matches any ID in the response data
                                    });
                        
                                    if (isMatched) {
                                        $(this).closest('.col-md-3').show(); // Show the matched checkbox
                                    } else {
                                        $(this).closest('.col-md-3').hide(); // Hide unmatched checkboxes
                                    }
                                });
                                $('#selectAllInternsEdit').closest('.form-check').show();
                                $('#selectAllInternsEdit').prop('checked', false);
                                $('#selectAllInternsEdit').change(function() {
                                    const isChecked = $(this).prop('checked');
                                    $('#internListEdit .form-check-input').prop('checked', isChecked);
                                });
                            } else {
                                $('#internListEdit .form-check-input').each(function () {
                                    const checkboxId = $(this).val(); 
                                    const isMatched = response.data.some(function (intern) {
                                        return intern.id == checkboxId;
                                    });
                            
                                    if (isMatched) {
                                        $(this).closest('.col-md-3').show();
                                    } else {
                                        $(this).closest('.col-md-3').hide();
                                    }
                                });
                                $('#selectAllInternsEdit').closest('.form-check').hide();
                            }
                        } else {
                            $('#internListEdit .form-check').hide();
                            $('#selectAllInternsEdit').closest('.form-check').hide();
                        }
                    },
                    error: function () {
                        alert('Failed to fetch interns. Please try again.');
                    }
                });
            }
	
		$(document).ready(function() {
		    
		    $('#internList').on('change', '.form-check-input', function () {
                const isChecked = $('.form-check-input:checked').length > 0;
        
                $('#submitAttendance').prop('disabled', !isChecked);
            });
		    
            loadInterns('All');
                
            $('#inchargeName').change(function () {
                const selectedIncharge = $(this).val();
                loadInterns(selectedIncharge);
            });
                
            function loadInterns(inchargeId) {
                $.ajax({
                    url: 'action/actAttendance.php', // PHP file to fetch interns
                    type: 'POST',
                    data: { inchargeId: inchargeId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            let html = '';
                            response.data.forEach(function (intern) {
                                html += `
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="intern${intern.id}" name="interns[]" value="${intern.id}">
                                            <label class="form-check-label" for="intern${intern.id}">${intern.name}</label>
                                        </div>
                                    </div>`;
                            });
                            $('#internList').html(html);
                            $('#selectAllInterns').closest('.form-check').show();
                            $('#selectAllInterns').prop('checked', false);
                            $('#submitAttendance').prop('disabled', true);
                            if (response.allInternIds) {
                                $('#allIds').val(response.allInternIds.join(','));
                            }
                            $('#selectAllInterns').change(function() {
                                const isChecked = $(this).prop('checked');
                                $('#internList .form-check-input').prop('checked', isChecked);
                                $('#submitAttendance').prop('disabled', !isChecked);
                            });
                        } else {
                            $('#internList').html(`<div class="col-md-12"><p>${response.message}</p></div>`);
                            $('#selectAllInterns').closest('.form-check').hide();
                            $('#submitAttendance').prop('disabled', true);
                        }
                    },
                    error: function () {
                        alert('Failed to fetch interns. Please try again.');
                    }
                });
            }
            
            $('#internListEdit').on('change', '.form-check-input', function () {
                const isChecked = $('.form-check-input:checked').length > 0;
        
            });
            
            $('#inchargeNameEdit').change(function () {
                const selectedIncharge = $(this).val();
                loadInternsEdit(selectedIncharge, false);
            });
                
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
			
			$('#addAttendance').on('click', function() {
                resetForm('addAttendanceForm');
                loadInterns('All');
            });
				
			$('#addAttendanceForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 
                
                if ($('.form-check-input:checked').length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please select at least one intern before submitting.',
                    });
                    return; 
                }

                var formData = new FormData(this);
                $('#submitAttendance').prop('disabled', true);
                $.ajax({
                    url: "action/actAttendance.php",
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
                                timer: 1000
                            }).then(function () {
                                $('#addAttendanceModal').modal('hide'); 
                                $('.modal-backdrop').remove(); 
                                $('#addAttendance').hide(); 
                                $('#editAttendance').prop('disabled', false);
                                var currentPage = $('#example2').DataTable().page();
                               
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
                                        table.page(currentPage).draw(false);
                                    });
                                
                            });
                            // Reset the form after successful submission
                            resetForm('addAttendanceForm');
                            $('#submitAttendance').prop('disabled', false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                            $('#submitAttendance').prop('disabled', false);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while adding Attendance.'
                        });
                        $('#submitAttendance').prop('disabled', false);
                    }
                });
            });
            
            $('#editAttendanceForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 
                
                var formData = new FormData(this);
                $('#submitAttendEdit').prop('disabled', true);
                $.ajax({
                    url: "action/actAttendance.php",
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
                                timer: 1000
                            }).then(function () {
                                $('#editAttendanceModal').modal('hide'); 
                                $('.modal-backdrop').remove(); 
                                var currentPage = $('#example2').DataTable().page();
                               
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
                                        table.page(currentPage).draw(false);
                                    });
                                
                            });
                            resetForm('editAttendanceForm');
                            $('#submitAttendEdit').prop('disabled', false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                            $('#submitAttendEdit').prop('disabled', false);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while Updating Attendance.'
                        });
                        $('#submitAttendEdit').prop('disabled', false);
                    }
                });
            });
		} );
</script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>