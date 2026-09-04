
<?php  
session_start();
include("../db/dbConnection.php");
include("../url.php");
?>
<!DOCTYPE html>
<html lang="en">
   
<?php include "head.php"; ?>

    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <?php include "left.php"; ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <?php include "right.php"; ?>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid" id="food_div">

                          
                            <!-- end page title end breadcrumb -->
                            

                           <!--end row-->
                           <?php
                           // Query to fetch active food packages
$sql = "SELECT `id`, `category`, `image`, `name`, `price` FROM `food_packages_tbl` WHERE status ='Active'";
$result = $conn->query($sql);
?>

                           
                           <div class="container mt-5">
    <h2 class="text-center mb-3">Food Packages</h2>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <!-- Image at the top with fixed height -->
                        <img src="../IndustrialVisit/image/food/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                            <p class="card-text"><strong>Price:</strong> â‚¹<?php echo htmlspecialchars($row['price']); ?></p>
                            <button class="btn btn-primary" onclick="openModal('<?php echo htmlspecialchars($row['name']); ?>', <?php echo htmlspecialchars($row['id']); ?> , <?php echo htmlspecialchars($row['price']); ?>)">Buy Now</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>No food packages available at this time.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
            
                          

<!-- Modal for Purchase Details -->
<!-- Modal for Purchase Details -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseModalLabel">Purchase Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="purchaseForm" novalidate class="needs-validation">
                    <input type="hidden" id="food_id">
                    <input type="hidden" id="price">
                    <div class="form-group">
                        <label for="studentCount">Student Count</label>
                        <select class="select2 form-control mb-3 custom-select" id="ivSelect" style="width: 100%; height:36px;">
                                            <option value="">Select</option>
                                                	<?php 
                                                	
                                                	$id=$_SESSION['id'] ;
                                                	
											$select_qry ="SELECT
                                                        a.iv_id,
                                                        b.name,
                                                        a.iv_date
                                                    FROM
                                                        `iv_details_tbl` AS a
                                                    LEFT JOIN iv_client_tbl AS b
                                                    ON
                                                        a.college_id = b.id
                                                    LEFT JOIN iv_payment_tbl AS c
                                                    ON
                                                        a.iv_id = c.visit_id
                                                    WHERE
                                                        a.status = 'Active'
                                                        AND a.iv_status = 'Upcoming'
                                                        AND a.college_id = $id
                                                        AND (c.pay_status IS NULL OR c.pay_status != 'Paid');";
                                                                                                                
                                                        $result =$conn->query($select_qry);
                                                        
                                                        while ($row = $result->fetch_assoc()) {
											
											?>
										<option value="<?php echo $row['iv_id']; ?>">
                                            <?php echo $row['name'] . " (" . date("d-M-Y", strtotime($row['iv_date'])) . ")"; ?>
                                        </option>
                                        											
											<?php } ?>
                                            
                                        </select>
                        <div class="invalid-feedback">Please enter a valid student count.</div>
                    </div>
              
                    <div class="form-group">
                        <label for="totalAmount">Total Amount</label>
                        
                        <input type="text" class="form-control" id="totalAmount" disabled>
                    </div>
                    <button type="button" class="btn btn-primary" id="paymentBtn" onclick="proceedToPayment()">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>



                            <!--<ul class="nav nav-pills nav-justified" role="tablist">-->
                            <!--        <li class="nav-item waves-effect waves-light">-->
                            <!--            <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">Live History</a>-->
                            <!--        </li>-->
                            <!--        <li class="nav-item waves-effect waves-light">-->
                            <!--            <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">Complete History</a>-->
                            <!--        </li>-->
                                    <!--<li class="nav-item waves-effect waves-light">-->
                                    <!--    <a class="nav-link" data-toggle="tab" href="#settings-1" role="tab">Settings</a>-->
                                    <!--</li>-->
                            <!--    </ul>-->
                                
                                
                                
                                
                                <!--<div class="tab-content">-->
                                <!--    <div class="tab-pane active p-3" id="home-1" role="tabpanel">-->
                                <!--       <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">-->
                                <!--    <thead>-->
                                <!--    <tr>-->
                                <!--        <th>Name</th>-->
                                <!--        <th>Position</th>-->
                                <!--        <th>Office</th>-->
                                <!--        <th>Age</th>-->
                                <!--        <th>Start date</th>-->
                                <!--        <th>Salary</th>-->
                                <!--    </tr>-->
                                <!--    </thead>-->


                                <!--    <tbody>-->
                                        
                                <!--    <tr>-->
                                <!--        <td>Tiger Nixon</td>-->
                                <!--        <td>System Architect</td>-->
                                <!--        <td>Edinburgh</td>-->
                                <!--        <td>61</td>-->
                                <!--        <td>2011/04/25</td>-->
                                <!--        <td>$320,800</td>-->
                                <!--    </tr>-->
                                   
                                <!--    </tbody>-->
                                <!--</table>-->
                                <!--    </div>-->
                                <!--    <div class="tab-pane p-3" id="profile-1" role="tabpanel">-->
                                <!--       <table id="completeHistory" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">-->
                                <!--    <thead>-->
                                <!--    <tr>-->
                                <!--        <th>Name</th>-->
                                <!--        <th>Position</th>-->
                                <!--        <th>Office</th>-->
                                <!--        <th>Age</th>-->
                                <!--        <th>Start date</th>-->
                                <!--        <th>Salary</th>-->
                                <!--    </tr>-->
                                <!--    </thead>-->


                                <!--    <tbody>-->
                                <!--    <tr>-->
                                <!--        <td>Tiger Nixon</td>-->
                                <!--        <td>System Architect</td>-->
                                <!--        <td>Edinburgh</td>-->
                                <!--        <td>61</td>-->
                                <!--        <td>2011/04/25</td>-->
                                <!--        <td>$320,800</td>-->
                                <!--    </tr>-->
                                   
                                <!--    </tbody>-->
                                <!--</table>-->
                                <!--    </div>-->
                                   
                                <!--</div>-->




                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    Â© 2022 IV by RoririSoft.
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    <script src="../assets/js/form-validation.js"></script>
</body>
</html>


<script>
    $(document).ready(function() {
        $('#ivSelect').change(function() {
            var ivId = $(this).val();
            var price = $('#price').val();
            
            if (ivId) { // Ensure iv_id is selected
            // $('#preloader').show();
                $.ajax({
                    url: 'action/actFood.php', // The PHP file that fetches the amount
                    type: 'POST',
                    data: { iv_id: ivId,
                            price :price
                            },
                    dataType: 'json', 
                    success: function(response) {
                        
                        $('#totalAmount').val(response); // Display the amount
                        // $('#preloader').hide();
                    },
                    error: function() {
                        $('#totalAmount').val('Error fetching amount');
                    }
                });
            } else {
                $('#totalAmount').val('0'); // Reset if no iv_id is selected
            }
        });
    });
</script>

<script>
$(document).ready(function() {
    var table2 = $('#completeHistory').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    // Ensure the buttons are appended after initialization
    table2.buttons().container()
        .appendTo('#completeHistory_wrapper .col-md-6:eq(0)');
});
</script>

<script>
    let foodPrice;

    function openModal(foodName, id , price) {
        // foodPrice = price; // Store the price of the selected food
        $('#purchaseModalLabel').text(`Purchase ${foodName}`);
        $('#price').val(price); // Clear previous value
        $('#ivSelect').val(''); // Clear previous value
        $('#totalAmount').val(''); // Clear previous value
        $('#food_id').val(id); // Clear previous value
        $('#purchaseModal').modal('show');
    }

    
    
    // Function to validate the purchase form
function validateForm() {
    const form = document.getElementById('purchaseForm');
    const studentCount = document.getElementById('studentCount');
    const staffCount = document.getElementById('staffCount');

    // Check if the form is valid
    if (form.checkValidity() === false) {
        form.classList.add('was-validated'); // Add Bootstrap validation class
        return false; // Form is not valid
    } else {
        form.classList.remove('was-validated'); // Remove validation class if valid
        return true; // Form is valid
    }
}

function proceedToPayment() {
    var totalAmount = $('#totalAmount').val();
    var visit_id = $('#ivSelect').val();
    var food_id = $('#food_id').val();
    

    if (totalAmount && totalAmount > 0) {
        $.ajax({
            url: 'createOrder.php', // Server-side script to create Razorpay order
            type: 'POST',
            data: { amount: totalAmount * 100 }, // Amount in paise for Razorpay
            success: function(orderId) {
                var options = {
                    key: 'rzp_test_sYDXizFjDxb4Vw', // Enter the Razorpay API key here
                    amount: totalAmount * 100, // Amount in paise
                    currency: "INR",
                    name: "Roriri Soft",
                    description: "IV Order Payment",
                    order_id: orderId, // Order ID generated by Razorpay
                    handler: function(response) {
                        // Payment success
                        $.ajax({
                            url: 'storePayment.php', // Server-side script to store payment data
                            type: 'POST',
                            data: {
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                amount: totalAmount,
                                id: visit_id,
                                food_id: food_id
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Payment successful!",
                                    icon: "success",
                                    timer: 2000, // Auto-close after 2 seconds
                                    showConfirmButton: false
                                });

                                setTimeout(function() {
                                    $('#purchaseModal').modal('hide'); // Hide the modal after 2 seconds
                                    $('#food_div').load(location.href + ' #food_div > *');
                                }, 2000);
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to store payment details.",
                                    icon: "error",
                                    confirmButtonText: "Try Again",
                                    timer: 2000, // Auto-close after 2 seconds
                                    showConfirmButton: false
                                });
                            }
                        });
                    },
                    prefill: {
                        name: "Vasanth",
                        email: "your-email@example.com",
                        contact: "989468891"
                    },
                    theme: {
                        color: "#3399cc"
                    }
                };

                var rzp1 = new Razorpay(options);
                rzp1.open();
            },
            error: function() {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to initiate payment.",
                    icon: "error",
                    timer: 2000, // Auto-close after 2 seconds
                    showConfirmButton: false
                });
            }
        });
    } else {
        Swal.fire({
            title: "Invalid Amount",
            text: "Please select a valid amount.",
            icon: "warning",
            timer: 2000, // Auto-close after 2 seconds
            showConfirmButton: false
        });
    }
}


</script>