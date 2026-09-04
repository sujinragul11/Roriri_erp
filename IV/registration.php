
<?php
session_start();
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
            <?php include "formStudent.php"; ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <?php include "right.php"; ?>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                           <!-- Card for Industrial Visit Registration -->
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-body">
            <h4 class="card-title text-primary">Industrial Visit Registration (Welcome <?php echo $_SESSION['name'] ?> )</h4>
            
            <!-- Form Inside the Card -->
            <form id="visitForm" class="needs-validation" novalidate>
    <div class="form-group">
        <label for="visitDate">Date</label>
        <input type="date" class="form-control" id="visitDate" name="visitDate" required>
        <div class="invalid-feedback">Please select a date. You cannot select a past date.</div>
    </div>

    <div class="form-group">
        <label for="department">Department</label>
        <input type="text" class="form-control" id="department" name="department" placeholder="Enter department" required>
        <div class="invalid-feedback">Please enter the department.</div>
    </div>

    <div class="form-group">
        <label for="batch">Batch</label>
        <input type="text" class="form-control" id="batch" name="batch" placeholder="Enter Batch" required>
        <div class="invalid-feedback">Please enter the Batch.</div>
    </div>

    <div class="form-group">
        <label for="studentCount">Student Count</label>
        <input type="number" class="form-control" id="studentCount" name="studentCount" placeholder="Enter number of students" min="1" required>
        <div class="invalid-feedback">Please enter a valid number of students (positive number).</div>
    </div>

    <div class="form-group">
        <label for="staffCount">Staff Count</label>
        <input type="number" class="form-control" id="staffCount" name="staffCount" placeholder="Enter number of staff" min="1" required>
        <div class="invalid-feedback">Please enter a valid number of staff (positive number).</div>
    </div>

    <div class="form-group">
        <label for="inchargeName">Incharge Name</label>
        <input type="text" class="form-control" id="inchargeName" name="inchargeName" placeholder="Enter Incharge name" pattern="^[A-Za-z\s]+$" required>
        <div class="invalid-feedback">Please enter a valid Incharge name (letters only, no numbers).</div>
    </div>

    <div class="form-group">
        <label for="inchargePhone">Incharge Phone</label>
        <input type="tel" class="form-control" id="inchargePhone" name="inchargePhone" placeholder="Enter Incharge phone number" pattern="^\d{10}$" required>
        <div class="invalid-feedback">Please enter a valid phone number (10 digits only).</div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary w-100">Register</button>
</form>
        </div>
    </div>
</div>
    
</div>
            
        </div>

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

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script src="<?php echo $sweetalert; ?>"></script>
   

    <script src="../assets/js/form-validation.js"></script>
</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Disable past dates
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('visitDate').setAttribute('min', today);

    // Form submission handler
    document.getElementById('visitForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Trim whitespace from text fields
        var inputs = ['department', 'batch', 'inchargeName'];
        inputs.forEach(function(id) {
            var inputField = document.getElementById(id);
            inputField.value = inputField.value.trim();
        });

        // Prevent spaces in phone number field
        document.getElementById('inchargePhone').value = document.getElementById('inchargePhone').value.replace(/\D/g, ''); // Remove non-numeric characters

        // Prevent numbers in the name field
        document.getElementById('inchargeName').value = document.getElementById('inchargeName').value.replace(/[^a-zA-Z\s]/g, ''); // Only allow letters and spaces

        // Check if form is valid
        if (!this.checkValidity()) {
            event.stopPropagation(); // Stop further propagation if the form is invalid
            this.classList.add('was-validated'); // Add Bootstrap validation styles
            return; // Stop submission
        }

        // Form is valid, prepare data for AJAX
        var formData = $(this).serialize(); // Serialize the form data
         var submitButton = $(this).find('button[type="submit"]'); // Find the submit button
    submitButton.prop('disabled', true); // Disable the submit button to prevent double-clicks

        // Send AJAX request
        $.ajax({
            url: 'action/actRegistration.php', // Replace with your server-side processing URL
            method: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                // Optionally, disable the submit button to prevent multiple submissions
                $('#visitForm button[type="submit"]').prop('disabled', true);
            },
            success: function(response) {
                 if (response.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
                timer: 1000
            }).then(function () {
                // Optionally reset the form
                $('#visitForm')[0].reset();
                $('#visitForm').removeClass('was-validated');
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
                // Handle error response
                alert('Form submission failed: ' + error);
            },
            complete: function() {
                // Re-enable the submit button after the request completes
                $('#visitForm button[type="submit"]').prop('disabled', false);
            }
        });
    });
});
</script>




<script>

 $(document).ready(function(){
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip(); 
    });
           function view() {
    // Hide all card sections
    $('#allCard').hide(); // Ensure that #allCard is the correct ID
    $('#viewBackBtn').show();
    
    // Show the specific detail section
    $('#detailsSection').show(); // Adjust if necessary
}

function back(){
                // Hide all detail sections
            $('#allCard').show();
            $('#detailsSection').hide();
            $('#viewBackBtn').hide();
            $('#gallerySection').hide();
            }
            
            
            // Function to handle form submission
            window.addStudent = function() {
                // Get student details from the form
                const name = $('#studentName').val();
                const age = $('#studentAge').val();
                const studentClass = $('#studentClass').val();
                const studentCount = $('#datatable-buttons tbody tr').length + 1; // Update count

                // Add new row to the student table
                $('#datatable-buttons tbody').append(`
                    <tr>
                        <td>${studentCount}</td>
                        <td>${name}</td>
                        <td>${age}</td>
                        <td>${studentClass}</td>
                    </tr>
                `);

                // Close the modal and reset the form
                $('#addStudentModal').modal('hide');
                $('#studentForm')[0].reset();
            };
            
            
    function showGallery() {
        // Show the gallery section
         $('#allCard').hide();
        $('#gallerySection').show();
        $('#viewBackBtn').show();
        // Clear any existing images
        $('#galleryImages').empty();

        // Add images to the gallery (you can change the image URLs to your own)
        const images = [
            'https://via.placeholder.com/150',
            'https://via.placeholder.com/150/0000FF',
            'https://via.placeholder.com/150/FF0000'
        ];

        // Populate the gallery
        images.forEach(image => {
            $('#galleryImages').append(`
                <div class="col-md-4 mb-3">
                    <a href="${image}" target="_blank">
                        <img src="${image}" class="gallery-image img-fluid" alt="Gallery Image">
                    </a>
                </div>
            `);
        });
    }
    
    function addImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Append the new image to the gallery
                $('#galleryImages').append(`
                    <div class="col-md-4 mb-3">
                        <a href="${e.target.result}" target="_blank">
                            <img src="${e.target.result}" class="gallery-image img-fluid" alt="New Gallery Image">
                        </a>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        }
    }
        
   
</script>