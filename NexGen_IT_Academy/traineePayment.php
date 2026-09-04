<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
    
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
		<div class="page-wrapper">
			<div class="page-content">
                
				
            <div class="page-title-box">
                
                <div class="page-title-right">
                    <h2 class="page-title">Payment Report</h2>
                </div>
                   
            </div>

				<div class="card">
					<div class="card-body">
					     <div class="row mb-4">
                            <div class="col-md-2">
                                <label for="reportStartDate">Start Date</label>
                                <input type="date" id="reportStartDate" class="form-control">
                                 <span id="startDateError" class="text-danger medium"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="endDate">End Date</label>
                                <input type="date" id="endDate" class="form-control">
                                  <span id="endDateError" class="text-danger medium"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="durationFilter">Duration(In Months)</label>
                                <input type="number" id="durationFilter" class="form-control" placehoder="Enter the Duration" min="1">
                            </div>
                            <div class="col-md-2">
                                <label for="courseFilter">Course Name</label>
                                <select id="courseFilter" class="form-control">
                                    <option value="">--Select the Course--</option>
                                    <?php
                                    $queryCou = "SELECT id, course_name FROM academy_course_details WHERE status='Available'";
                                    $resultCou = mysqli_query($conn, $queryCou);
                                
                                    if ($resultCou) {
                                        while ($row = mysqli_fetch_assoc($resultCou)) {
                                            $courseId = $row['id'];
                                            $courseName = $row['course_name'];
                                
                                            echo "<option value=\"$courseId\">$courseName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="traineeFilter">Trainee Name</label>
                                <select id="traineeFilter" class="form-control">
                                    <option value="">--Select the Trainee--</option>
                                    <?php
                                    $queryTrainee = "SELECT a.id, a.name FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id WHERE a.status = 'Active' AND b.role = 10";
                                    $resultTrainee = mysqli_query($conn, $queryTrainee);
                                
                                    if ($resultTrainee) {
                                        while ($row = mysqli_fetch_assoc($resultTrainee)) {
                                            $traineeId = $row['id'];
                                            $traineeName = $row['name'];
                                
                                            echo "<option value=\"$traineeId\">$traineeName</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-2 mt-3 pt-1">
                                <button id="filterBtn" class="btn btn-primary">Apply</button>
                                </div>
                        </div>
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
                                        <th>S. No</th>
										<th>Date</th>
                                        <th>Name</th>
										<th>Payment Mode</th>
										<th>Received By</th>
                                        <th>Amount</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
								<tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Overall Total</strong></td>
                                        <td class="text-end"></td>
                                    </tr>
                                </tfoot>
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
     function validateDateInputs() {
    const today = new Date().toISOString().split('T')[0]; // Today's date in YYYY-MM-DD format
    const reportStartDate = $('#reportStartDate').val();
    const endDate = $('#endDate').val();

    let isValid = true; // Flag to track overall validity

    // Clear previous error messages
    $('#startDateError').text('');
    $('#endDateError').text('');

    // Check if Start Date is in the future
    if (reportStartDate && reportStartDate > today) {
        $('#startDateError').text("Start Date cannot be in the future.");
        isValid = false;
    }

    // Check if End Date is in the future
    if (endDate && endDate > today) {
        $('#endDateError').text("End Date cannot be in the future.");
        isValid = false;
    }

    // Ensure End Date is not before Start Date
    if (reportStartDate && endDate && endDate < reportStartDate) {
        $('#endDateError').text("End Date cannot be earlier than Start Date.");
        isValid = false;
    }

    return isValid; // Return overall validity
}

// Helper function to format the date
    function formatDate(dateString) {
    // Return 'N/A' if date is null, undefined, or empty
    if (!dateString) return 'N/A'; 
    
    // Check if the date is in the format of 'yyyy-mm-dd'
    const isoFormat = /^\d{4}-\d{2}-\d{2}$/;
    if (isoFormat.test(dateString)) {
        const [year, month, day] = dateString.split('-');
        return formatValidDate(day, month, year);
    }

    // Check if the date is in the format of 'dd-mm-yyyy'
    const customFormat = /^\d{2}-\d{2}-\d{4}$/;
    if (customFormat.test(dateString)) {
        const [day, month, year] = dateString.split('-');
        return formatValidDate(day, month, year);
    }

    // If the format is incorrect, return 'N/A'
    return 'N/A';
}

function formatValidDate(day, month, year) {
    const parsedDay = parseInt(day, 10);
    const parsedMonth = parseInt(month, 10) - 1; // JavaScript months are 0-based
    const parsedYear = parseInt(year, 10);

    // Create a Date object
    const date = new Date(parsedYear, parsedMonth, parsedDay);

    // Check if the date is valid
    if (isNaN(date.getTime())) return 'N/A'; // If date is invalid, return 'N/A'

    // Create an array of month abbreviations
    const monthNames = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    const formattedDay = String(date.getDate()).padStart(2, '0');
    const formattedMonth = monthNames[date.getMonth()]; // Get the month abbreviation
    const formattedYear = date.getFullYear();

    return `${formattedDay} ${formattedMonth} ${formattedYear}`; // Format as d-MMM-Y
}

      // Filter button click event
    $('#filterBtn').on('click', function() {
        if (!validateDateInputs()) {
            return; 
        }
        
        var reportStartDate = $('#reportStartDate').val();
        var endDate = $('#endDate').val();
        var durationFilter = $('#durationFilter').val();
        var courseFilter = $('#courseFilter').val();
        var traineeFilter = $('#traineeFilter').val();
        if (!reportStartDate && !endDate && !durationFilter && !courseFilter && !traineeFilter) {
            console.log("All filters are empty. AJAX request will not be triggered.");
            return; // Stop if all variables are empty
        }
        
        // Perform AJAX request
        $.ajax({
            url: 'action/actTraineePayment.php',
            type: 'GET',
            data: {
                report_start_date: reportStartDate,
                end_date: endDate,
                durationFilter: durationFilter,
                courseFilter: courseFilter,
                traineeFilter: traineeFilter
            },
            dataType: 'json',
            success: function(data) {
                $('#example2').DataTable().destroy();
                $('#example2 tbody').empty();
    
                // Append rows to the table body
                data.forEach(function(item, index) {
                    const rowHTML = `
                        <tr>
                            <td>${index + 1}</td> 
                            <td>${formatDate(item.received_date)}</td> 
                            <td><a href="https://erp.inforiya.in/NexGen_IT_Academy/traineeDetails.php?id=${item.basic_id}" target="_blank">${item.basic_name}</a></td>
                            <td>${item.pay_method}</td> 
                            <td>${item.receiver_name}</td>
                            <td class="text-end">â‚¹${Number(item.received_amnt).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>`;
                    
                    // Append the new row to the table body
                    $('#example2 tbody').append(rowHTML);
                });
    
                // Initialize DataTable with footerCallback for total
                $('#example2').DataTable({
                    paging: true,
                    ordering: true,
                    searching: true,
                    lengthChange: false,
                    buttons: [
                        'copy', {
                            extend: 'excel',
                            customize: function (xlsx) {
                                let totalAmount = data.reduce((sum, item) => sum + parseFloat(item.received_amnt), 0);
                                let formattedTotal = totalAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                $(xlsx.xl.worksheets['sheet1.xml']).find('row:last').after(
                                    `<row>
                                        <c t="inlineStr" s="42"></c>
                                        <c t="inlineStr" s="42"></c>
                                        <c t="inlineStr" s="42"></c>
                                        <c t="inlineStr" s="42"></c>
                                        <c t="inlineStr" s="42"><is><t>Overall Total</t></is></c>
                                        <c t="inlineStr" s="42" r="6"><is><t>â‚¹${formattedTotal}</t></is></c>
                                    </row>`
                                );
                            }
                        }, {
                            extend: 'pdf',
                            customize: function (doc) {
                                let totalAmount = data.reduce((sum, item) => sum + parseFloat(item.received_amnt), 0);
                                let formattedTotal = totalAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                doc.content[1].table.body.forEach(function(row, index) {
                                    if (index > 0) { 
                                        row[5].alignment = 'right';
                                    }
                                });
                                doc.content[1].table.body.push([
                                    { text: 'Overall Total', alignment: 'right', colSpan: 5, bold: true },
                                    {}, {}, {}, {},
                                    { text: `â‚¹${formattedTotal}`, alignment: 'right', bold: true }
                                ]);
                            }
                        }, {
                            extend: 'print',
                            customize: function (win) {
                                let totalAmount = data.reduce((sum, item) => sum + parseFloat(item.received_amnt), 0);
                                let formattedTotal = totalAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                $(win.document.body).find('table').append(
                                    `<tr><td colspan="5" class="text-end"><strong>Overall Total</strong></td>
                                     <td class="text-end"><strong>â‚¹${formattedTotal}</strong></td></tr>`
                                );
                                $(win.document.body).find('table').css('width', '100%');
                                $(win.document.body).find('table tbody td:last-child').css('text-align', 'right');
                            }
                        }
                    ],
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api();
                        var total = api.column(5).data()
                            .reduce(function(a, b) {
                                return a + parseFloat(b.replace(/â‚¹|,/g, '') || 0);
                            }, 0);
                        var indianCurrencyFormat = total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        $(api.column(5).footer()).html(`<strong>â‚¹${indianCurrencyFormat}</strong>`);
                    }
                });
                
                // Move the button container to a specific location
                var table = $('#example2').DataTable();
                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    });  
    
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });

    </script>

	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
				
			var today = new Date().toISOString().split('T')[0];
            $('#reportStartDate').attr('max', today);
            $('#endDate').attr('max', today);   
		} );
		$(document).ready(function() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const startOfMonth = `${year}-${month}-01`; 
            
            $('#reportStartDate').val(startOfMonth); 
            // Trigger the filter button click
            $('#filterBtn').click();
        });
</script>
	<!--app JS-->
	<script src="<?php echo $app; ?>"></script>
<script src="../assets/js/form-validation.js"></script>
</body>

</html>