<?php

session_start();
include("../db/dbConnection.php");
include("../url.php");    
    $selQuery = "SELECT
                    `banner_id`,
                    `name`,
                    `image_name`
                FROM
                    `iv_banner_tbl`
                WHERE
                    `status` = 'Active'";
    
    $resQuery = mysqli_query($conn , $selQuery); 
    
?>
<!doctype html>
<html lang="en">

<?php include("head.php");?>

<body>
<?php include("formBanner.php");?>
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
                    <h2 class="page-title text-muted text-decoration-underline">Banner Details</h2>
                    <div class="d-flex justify-content-end">
                        <button type="button" id="addBannerBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addBannerModal"><i class="lni lni-upload me-1"></i>Add Banner</button>
                    </div>
                </div>
            </div>

			<div class="row row-cols-1 row-cols-md-3 row-cols-xl-5" id="bannerContainer">

                    <?php  while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
                         $id        = $row['banner_id'];  
                         $name      = $row['name'];   
                         $image     = $row['image_name']; 
                    ?>
                    <div class="col">
                        <div class="card border-primary border-bottom border-3 border-0">
                            <div class="ratio ratio-4x3">
                                <img src="https://asset.inforiya.in/ERP/ERP_image/IVBanner/<?php echo $image; ?>" class="card-img-top img-fluid object-fit-contain" alt="Promotion Banner">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h4 class="my-1 text-center text-truncate" style="max-width: 100%;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $name; ?>">
                                    <?php echo $name; ?>
                                </h4>
                                <hr>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button class="btn btn-primary" id="editBannerBtn" data-bs-toggle="modal" data-bs-target="#editBannerModal" data-banner-id="<?php echo $id; ?>" data-banner-name="<?php echo $name; ?>">
                                        <i class='bx bx-pencil'></i> 
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-target="#top" title="Delete Banner" onclick="goDeleteBanner(<?php echo $id; ?>)">
                                        <i class='bx bx-trash'></i> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php } ?>
					</div>
			</div><!--end page-content-->
		</div>
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include("footer.php"); ?>
	</div>
	<!--end wrapper-->

<div id="loader" style="display: none;">
	<div class="card-body">
		<div class="spinner-grow text-primary" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-secondary" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-success" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-danger" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-warning" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-info" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-light" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
		<div class="spinner-grow text-dark" role="status"> <span class="visually-hidden">Loading...</span>
		</div>
	</div>
</div>
	



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
		function resetForm(formId) {
            var form = $('#' + formId);
            form[0].reset();
            form.removeClass('was-validated');
        }
</script>
<script>
$(document).ready(function() {
    
    $('#addBannerBtn').on('click', function() {
        resetForm('bannerForm');  
        $('#submitFormBtn').prop('disabled', false); 
    });
 
    // Handle the form submission via AJAX for Add Banner
    $('#bannerForm').off('submit').on('submit', function (e) {
        e.preventDefault(); 
        
        $(this).find("input[required], textarea[required]").each(function () {
            $(this).val($(this).val().trim());
        });
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitFormBtn').prop('disabled', true);
        $('#loader').show();
        $.ajax({
            url: "action/actBanner.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function (response) {
                $('#loader').hide();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function () {
                        $('#addBannerModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                        setTimeout(function () {
                            $('#bannerContainer').load(location.href + ' #bannerContainer > *');
                        }, 300);
                    });
                    // Reset the form after successful submission
                    resetForm('bannerForm');
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
                $('#loader').hide();
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding Banner details.'
                });
                $('#submitFormBtn').prop('disabled', false);
            }
        });
    });
    
    // Handle the form submission via AJAX for Edit Banner
    $('#bannerFormEdit').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        $(this).find("input[required], textarea[required]").each(function () {
            $(this).val($(this).val().trim());
        });
        if (!this.checkValidity()) {
            $(this).addClass('was-validated');
            return; // Stop the submission
        }

        var formData = new FormData(this);
        $('#submitEditBtn').prop('disabled', true);
        $('#loader').show();
        $.ajax({
            url: "action/actBanner.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', 
            success: function (response) {
                $('#loader').hide();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1000
                    }).then(function () {
                        $('#editBannerModal').modal('hide'); 
                        $('.modal-backdrop').remove(); 
                        setTimeout(function () {
                            $('#bannerContainer').load(location.href + ' #bannerContainer > *');
                        }, 300);
                    });
                    // Reset the form after successful submission
                    resetForm('bannerFormEdit');
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
                $('#loader').hide();
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating Banner Details.'
                });
                $('#submitEditBtn').prop('disabled', false);
            }
        });
    });
    
    $('#editBannerModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); 
        var bannerId = button.data('banner-id'); 
        var name = button.data('banner-name');

        $('#bannerId').val(bannerId);
        $('#nameEdit').val(name);
    });
});
</script>
<script>

//Function to handle the deletion of a banner.
function goDeleteBanner(bannerId) {
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
            $('#loader').show();
            $.ajax({
                url: 'action/actBanner.php',  
                method: 'POST',
                data: { delId: bannerId },  
                dataType: 'json',  
                success: function(response) {
                    $('#loader').hide();
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
                            setTimeout(function () {
                                $('#bannerContainer').load(location.href + ' #bannerContainer > *');
                            }, 300);
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
                    $('#loader').hide();
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',  
                        text: 'An error occurred while deleting the Banner.',  
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