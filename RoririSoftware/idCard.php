<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    

    $selQuery = "SELECT
                    a.`idcard_id`,
                    a.`id_number`,
                    b.`returned_date`,
                    c.name
                FROM
                    `intern_idcard_tbl` AS a
                LEFT JOIN 
                    `idcard_track_tbl` AS b
                ON
                    a.idcard_id = b.idcard_id
                LEFT JOIN 
                    `internship_tbl` AS c
                ON
                    b.intern_id = c.intern_id
                WHERE
                    a.`status` = 'Active'
                ORDER BY 
                    a.`idcard_id`";
    $resQuery = mysqli_query($conn , $selQuery); 
    
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
    		<?php include "formIDCard.php";?>
    		<div class="page-wrapper">
    			<div class="page-content" id="idCardTbl">
                    
    				
                <div class="page-title-box">
                    
                    <div class="page-title-right">
                        <h2 class="page-title">ID Card Details</h2>
                        <div class="col text-end pb-3">
                            <button type="button" id="addIDCard" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIDCardModal">
                                <i class="bx bx-plus"></i>Add ID Card
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
    										<th class="col-3 text-center">ID Card</th>
                                            <th class="col-6 text-center">Intern Name</th>
                                            <th class="col-2 text-center">Action</th>
    									</tr>
    								</thead>
    								<tbody>
                                        <?php
                                            $groupedData = []; 
                                            while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                                                $id = $row['idcard_id'];
                                                $idNumber = $row['id_number'];
                                                $intern = !empty($row['name']) ? $row['name'] : 'Not Allocated';
                                                $returnedDate = $row['returned_date'];
                                            
                                                if (!isset($groupedData[$id])) {
                                                    $groupedData[$id] = [];
                                                }
                                            
                                                $groupedData[$id][] = [
                                                    'idNumber' => $idNumber,
                                                    'intern' => $intern,
                                                    'returnedDate' => $returnedDate,
                                                ];
                                            }
                                        $i = 1;
                                        foreach ($groupedData as $id => $records) {
                                            $lastRecord = end($records);
                                            $internName = $lastRecord['intern'];
                                            $returnedDate = $lastRecord['returnedDate'];
    
                                            if ($returnedDate !== '0000-00-00') {
                                                $internName = 'Not Allocated';
                                            }
    
                                            echo "<tr>";
                                            echo "<td class='col-1 text-center'>{$i}</td>";
                                            echo "<td class='col-3 text-center'>{$lastRecord['idNumber']}</td>";
                                            echo "<td class='col-6 text-center'>{$internName}</td>";
                                            echo "<td class='col-2 text-center'>
                                                    <button type='button' class='btn btn-sm btn-outline-primary' onclick='goIssueCard({$id});' data-bs-toggle='tooltip' data-bs-target='#top' title='Issue IDCard'><i class='bx bx-id-card'></i></button>
                                                    <button class='btn btn-sm btn-outline-info' data-bs-toggle='tooltip' data-bs-target='#top' title='View IDCard History' onclick='viewCardHistory({$id});'><i class='bx bx-history'></i></button>
                                                  </td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                        ?>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div><!--end page-content-->
			
			    <div class="page-content" id="idHistoryTbl" style="display: none;">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <h2 class="page-title">ID Card History</h2>
                            <div class="col text-end pb-3">
                                <button type="button" id="backIDCard" class="btn btn-danger">
                                    <i class="lni lni-exit"></i>Back
                                </button>
                            </div>
                        </div>
                           
                    </div>
    
    				<div class="card">
    					<div class="card-body">
    						<div class="table-responsive">
    							<table id="example1" class="table table-striped table-bordered">
    								<thead>
    									<tr>
                                            <th class="col-1 text-center">S. No</th>
    										<th class="col-5 text-center">Intern Name</th>
                                            <th class="col-3 text-center">Issued Date</th>
                                            <th class="col-3 text-center">Returned date</th>
    									</tr>
    								</thead>
    								<tbody>
    								    
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
            form.removeClass('was-validated');
        }
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });

    </script>

	<script>
		$(document).ready(function() {
		    
		    var today = new Date().toISOString().split('T')[0];
            $("#issueDate").attr("max", today);
            $("#returnDate").attr("max", today);
		    
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
				
			var table = $('#example1').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example1_wrapper .col-md-6:eq(0)' );
			
			$('#addIDCard').on('click', function() {
                resetForm('idCardForm'); 
                $('#saveIDCard').prop('disabled', false); 
            });
            
            $('#backIDCard').on('click', function() {
                $('#idHistoryTbl').hide();
                $('#idCardTbl').show(); 
            });
				
			$('#idCardForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 
                
                var idCardNoInput = $('#idCardNo');
                idCardNoInput.val(idCardNoInput.val().trim());
                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; // Stop the submission
                }
        
                var formData = new FormData(this);
                $('#saveIDCard').prop('disabled', true);
                $.ajax({
                    url: "action/actIDCard.php",
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
                                $('#addIDCardModal').modal('hide'); 
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
                            // Reset the form after successful submission
                            resetForm('idCardForm');
                            $('#saveIDCard').prop('disabled', false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                            $('#saveIDCard').prop('disabled', false);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while adding ID Card Number.'
                        });
                        $('#saveIDCard').prop('disabled', false);
                    }
                });
            });
            
            $('#issueCardForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 
                
                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }
        
                var formData = new FormData(this);
                $('#submitFormBtn').prop('disabled', true);
                $.ajax({
                    url: "action/actIDCard.php",
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
                                $('#issueCardModal').modal('hide'); 
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
                            resetForm('issueCardForm');
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
                            text: 'An error occurred while Issuing ID Card.'
                        });
                        $('#submitFormBtn').prop('disabled', false);
                    }
                });
            });
		} );
</script>

<script>
function goIssueCard(cardId) {
    
    $('#submitFormBtn').prop('disabled', false);
    resetForm('issueCardForm');
    
    $.ajax({
        url: 'action/actIDCard.php',
        method: 'POST',
        data: {
            cardId : cardId
        },
        dataType: 'json', 
        success: function(response) {
                $('#cardTrackId').val(response.id);
                $('#issueCardNo').val(response.cardNo);
                $('#internName').val(response.name);
                $('#issueDate').val(response.issueDate);
                $('#returnDate').val(response.returnDate);
                if (response.issueDate) {
                    $('#issueDateField').hide();
                    $('#returnDateField').show();
                    $('#internName').prop('disabled', true);
                    $('#returnDate').prop('required', true);
                } else {
                    $('#issueDateField').show();
                    $('#returnDateField').hide();
                    $('#internName').prop('disabled', false);
                    $('#returnDate').prop('required', false);
                }
                $('#issueCardId').val(cardId);
                $('#issueCardModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

function viewCardHistory(cardId){
    
    $.ajax({
        url: 'action/actIDCard.php',  
        method: 'POST',
        data: { cardHistory: cardId },
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response)) {
                $('#example1').DataTable().clear().destroy();
                $('#example1 tbody').empty();

                $.each(response, function(index, item) {
                    var row = '<tr>' +
                        '<td class="col-1 text-center">' + (index + 1) + '</td>' + 
                        '<td class="col-5 text-center">' + item.name + '</td>' + 
                        '<td class="col-3 text-center">' + item.issue + '</td>' +
                        '<td class="col-3 text-center">' + item.return + '</td>' +
                    '</tr>';
                    $('#example1 tbody').append(row); 
                });

                var table = $('#example1').DataTable({
                    paging: true,
                    ordering: true,
                    searching: true,
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#example1_wrapper .col-md-6:eq(0)');
            } 
            $('#idCardTbl').hide();
            $('#idHistoryTbl').show();
        },
        error: function() {
            alert('There was an error fetching course details.');
        }
    });
}
</script>
	
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>