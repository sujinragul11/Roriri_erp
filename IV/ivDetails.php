
<?php
session_start();

include("../db/dbConnection.php");
include("../url.php");    
   $selQuery = "CALL get_iv_details_user('', 'Active');";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
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

                            <div class="row p-3">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-left">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">Industrial Visit Details</a></li>
                                              
                                            </ol>
                                        </div>
                                        <div class="btn-group float-right">
                                            <button onclick="back()" id="viewBackBtn" class="btn btn-outline-primary ms-2"  style="display:none;"><i class="dripicons-arrow-left"></i>  Back</button>
                                    </div>
                                                            </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            

                           <!--end row-->
            
                            <div class="row" id="allCard">
                                
                             <?php  
                             
                             if (mysqli_num_rows($resQuery) > 0) {
                                 
                             while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                                 
                 $iv_id        = $row['iv_id'];  
                 $iv_date = $row['iv_date']; // Assuming it's in 'Y-m-d' format
                 $date = date('d-M-Y', strtotime($iv_date));
                 $department   =$row['department'];
                 $batch   =$row['batch'];
                 $stu_count   =$row['stu_count'];
                 $staff_count   =$row['staff_count'];
                 $incharge_name   =$row['incharge_name'];
                 $incharge_phone   =$row['incharge_phone'];
                 $iv_status   =$row['iv_status'];
                 
            ?>   
                                
  <!-- Your existing cards go here -->
  <div class="col-md-4 mb-4">
    <div class="card shadow-lg border-0 rounded-lg" style="border-radius: 10px;">
      <div class="card-body p-4">
        <h4 class="card-title font-20 mb-3">
          <span class="text-primary">Date:</span> 
          <span class="text-dark"><?php echo $date ?></span>
        </h4>
        <p class="font-14 text-muted mb-2"><strong class="text-primary">Department:</strong> <span class="text-dark"><?php echo $department ?></span></p>
        <p class="font-14 text-muted mb-2"><strong class="text-primary">Student Count:</strong> <span class="text-dark"><?php echo $stu_count ?></span></p>
        <p class="font-14 text-muted mb-2"><strong class="text-primary">Staff Count:</strong> <span class="text-dark"><?php echo $staff_count ?></span></p>
        <p class="font-14 text-muted mb-3"><strong class="text-primary">In-Charge Staff Name:</strong> <span class="text-dark"><?php echo $incharge_name ?></span></p>
        <p class="font-14 text-muted mb-3"><strong class="text-primary">In-Charge Staff Phone:</strong> <span class="text-dark"><?php echo $incharge_phone ?></span></p>
        <p class="font-14 text-muted mb-3"><strong class="text-primary">IV Status:</strong> <span class="text-dark"><?php echo $iv_status ?></span></p>
        <div class="row">
          <div class="col-6">
            <button 
                            onclick="view(<?php echo $iv_id ?>)" 
                            class="btn btn-outline-primary w-100 view-details" 
                            style="font-size: 24px;" 
                            id="viewDetailsBtn" 
                            data-toggle="tooltip" 
                            title="View Details">
                            <i class="dripicons-preview"></i>
                        </button>
          </div>
          <div class="col-6">
             <button 
                            class="btn btn-outline-primary w-100" 
                            style="font-size: 24px;" 
                            id="viewGalleryBtn" 
                            data-toggle="tooltip" 
                            title="View Gallery"
                            onclick="showGallery()">
                            <i class="dripicons-photo-group"></i>
                        </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php
                     } 
                                 
                             } else {
      echo "<p>No records found.</p>";
  };
  ?> 
  
  
 
  
  
</div>

<!-- Pagination controls -->
<div class="row">
  <div class="col-12 text-center">
    <nav aria-label="Card pagination">
      <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
  </div>
</div>


  <!-- Expanded Details Section -->
              <div id="detailsSection" style="display:none;">
        <div class="details-container">
           <div class="card mt-3 shadow-lg border-0 rounded-custom">
    <div class="card-body p-4">
        <h4 class="card-title font-weight-bold">Details Overview</h4>
        <div class="row">
            <div class="col-md-4 mb-1">
                <p class="font-14 text-muted">
                    <strong class="text-primary">Date:</strong> 
                    <span class="text-dark" id="viewDate"></span>
                </p>
            </div>
            <div class="col-md-4 mb-1">
                <p class="font-14 text-muted">
                    <strong class="text-primary">Department:</strong> 
                    <span class="text-dark" id="viewDept"></span>
                </p>
            </div>
            <div class="col-md-4 mb-1">
                <p class="font-14 text-muted">
                    <strong class="text-primary">Student Count:</strong> 
                    <span class="text-dark" id="viewStuCount"></span>
                </p>
            </div>
            <div class="col-md-4 mb-1">
                <p class="font-14 text-muted">
                    <strong class="text-primary">Staff Count:</strong> 
                    <span class="text-dark" id="viewstaCount"></span>
                </p>
            </div>
            
            <div class="col-md-4 mb-1">
                <p class="font-14 text-muted">
                    <strong class="text-primary">In-Charge Staff Name:</strong> 
                    <span class="text-dark" id="viewstaName"></span>
                </p>
            </div>
            
            <div class="col-md-4 mb-1">
                <p class="font-14 text-muted">
                    <strong class="text-primary">In-Charge Staff Phone:</strong> 
                    <span class="text-dark" id="viewstaPhone"></span>
                </p>
            </div>
            
            <div class="col-md-4 mb-1">
                <p class="font-14 text-muted">
                    <strong class="text-primary">IV Status:</strong> 
                    <span class="text-dark" id="viewStatus"></span>
                </p>
            </div>
           
        </div>
    </div>
</div>

            <div class="card-body p-4">
                <h5 class="card-title">Student List</h5>
                  <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">Add Student</button>
            </div>
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Certificate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                  
                         
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
    <!-- Gallery Section -->
    <div id="gallerySection" class="mt-3" style="display:none;">
        <h5 class="text-center">Gallery</h5>
         <button class="btn btn-success w-100 mt-3 mb-3" onclick="document.getElementById('imageInput').click();">Add Image</button>
                <input type="file" id="imageInput" accept="image/*" style="display:none;" onchange="addImage(event)">
        <div class="row" id="galleryImages">
            <!-- Images will be populated here dynamically -->
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
    const itemsPerPage = 6; // Number of cards per page
const allCards = document.querySelectorAll('#allCard .col-md-4'); // Get all the card elements
const totalPages = Math.ceil(allCards.length / itemsPerPage); // Calculate total pages

function showPage(page) {
  const start = (page - 1) * itemsPerPage;
  const end = start + itemsPerPage;

  allCards.forEach((card, index) => {
    if (index >= start && index < end) {
      card.style.display = 'block'; // Show the cards for the current page
    } else {
      card.style.display = 'none'; // Hide other cards
    }
  });
}

// Create pagination controls
function createPagination(totalPages) {
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = ''; // Clear any existing pagination

  for (let i = 1; i <= totalPages; i++) {
    const li = document.createElement('li');
    li.classList.add('page-item');
    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    
    li.addEventListener('click', (e) => {
      e.preventDefault();
      const page = parseInt(e.target.textContent);
      showPage(page);
      updateActivePage(page);
    });

    pagination.appendChild(li);
  }
}

// Update the active page link
function updateActivePage(page) {
  const paginationLinks = document.querySelectorAll('#pagination .page-item');
  paginationLinks.forEach((link, index) => {
    if (index === page - 1) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
}

// Initialize the pagination
createPagination(totalPages);
showPage(1); // Show the first page by default
updateActivePage(1); // Set the first page as active
</script>


<script>

 $(document).ready(function(){
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip(); 
    });
           function view(id) {
    // Hide all card sections
    $('#allCard').hide(); // Ensure that #allCard is the correct ID
    $('#viewBackBtn').show();
    $('#pagination').hide();
    // Show the specific detail section
    $('#detailsSection').show(); // Adjust if necessary
    $('#iv_id_form').val(id);
    
    $.ajax({
        url: 'action/actIvDetails.php',
        method: 'POST',
        data: {
            iv_edit : id
        },
        dataType: 'json', 
        success: function(response) {
            
                $('#viewDate').text(response.iv_date);
                $('#viewDept').text(response.department);
                $('#viewstaCount').text(response.staff_count);
                $('#viewStuCount').text(response.stu_count);
                
                $('#viewstaName').text(response.incharge_name);
                $('#viewstaPhone').text(response.incharge_phone);
                $('#viewStatus').text(response.iv_status);
                
                    
                    
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
    
    loadData();
     
    
}


 function loadData(){
     
     var id =$('#iv_id_form').val();
     
      // Perform AJAX request
        $.ajax({
            url: 'action/actIvDetails.php', // Update with your server-side script to fetch data
            type: 'GET',
            data: {
                date_get: 'table_value',
                id : id
            },
            dataType: 'json',
            success: function(data) {
            var currentPage = $('#datatable-buttons').DataTable().page();
        $('#datatable-buttons').DataTable().destroy();
        $('#datatable-buttons tbody').empty();

                   // Loop through the returned data and append rows to the table
        data.forEach(function(item, index) {
             const rowHTML = `
                <tr>
                    <td>${index + 1}</td> <!-- Serial number -->
                    <td>${item.name}</td> <!-- Subcategory -->
                    <td>${item.phone}</td> <!-- Category name -->
                    <td>${item.email}</td> <!-- Product number -->
                    <td>${item.address}</td> <!-- Product name -->
                    <td>${item.certificate_status}</td> <!-- Vendor name -->
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="loadEditAssetData(${item.assetpro_id});">
                            <i class="lni lni-pencil"></i>
                        </button>
                        
                    </td>
                </tr>`;
            
            // Append the new row to the table body
            $('#datatable-buttons tbody').append(rowHTML);
        });
        
        
         //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        table.page(currentPage).draw(false);
      
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
     
 }

function back(){
                // Hide all detail sections
            $('#allCard').show();
            $('#detailsSection').hide();
            $('#viewBackBtn').hide();
            $('#gallerySection').hide();
            $('#pagination').show();
            
            }
            
            
       // Function to handle form validation and submission
function addStudent() {
    var form = document.getElementById("studentForm");
    var submitButton = document.querySelector("#studentForm .btn-primary"); // Adjust selector if needed

    // Trim whitespace from all input fields
    Array.from(form.elements).forEach(function(element) {
        if (element.type === "text" || element.type === "email" || element.type === "textarea" || element.type === "number") {
            element.value = element.value.trim();
        }
    });

    // Check validity and prevent submission if invalid
    if (form.checkValidity() === false) {
        form.classList.add("was-validated");
         return; // Stop the submission
    } else {
        // Disable the button to prevent multiple clicks
        submitButton.disabled = true;

        // Collect form data
        var formData = new FormData(form);

        // AJAX call to submit form data
        $.ajax({
            url: 'action/actIvDetails.php', // Update with the correct server-side script URL
            method: 'POST',
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function(response) {
                 if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function () {
                        $('#addStudentModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                      
         
                             loadData();
                        
                    });
                    
                   // Optional: Reset the form after successful submission
                form.reset();
                form.classList.remove("was-validated"); // Clear validation styling
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                    submitButton.disabled = false;
                }
                
                
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error("AJAX request failed:", error);
            },
            complete: function() {
                // Re-enable the button after the request is complete (success or error)
                submitButton.disabled = false;
            }
        });
    }
}
            
    function showGallery() {
        // Show the gallery section
         $('#allCard').hide();
        $('#gallerySection').show();
        $('#viewBackBtn').show();
        $('#pagination').hide();
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