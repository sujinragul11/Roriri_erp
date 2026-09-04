<?php

session_start();



include("../db/dbConnection.php");

include("../url.php");    

    $selQuery = "SELECT

                    a.`mou_id`,

                    a.`name`,

                    a.`category`,

                    a.`date`,

                    a.`incharge`,

                    a.`moustatus`,

                    b.name AS empName

                FROM

                    `mou_tbl` AS a LEFT JOIN `basic_details` AS b ON a.`incharge` = b.`id`

                WHERE

                    a.`status` = 'Active'";
    

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

		

		<!-- Loader -->



        <?php include "formMou.php";?>

		

		<div class="page-wrapper">

			<div class="page-content">

            <div class="page-title-box">

                <div class="page-title-right pb-3">

                    <h2 class="page-title text-muted text-decoration-underline">MOU Details</h2>

                    <div class="d-flex justify-content-end">

                        <!-- Button for Category -->

                        <button type="button" id="addMOUBtn" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addMOUModal">

                            <i class="fadeIn animated bx bx-bookmark-plus"></i>Add MOU

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

										<th class="col-2 text-center">College Name</th>

                                        <th class="col-2 text-center">Category</th>

										<th class="col-2 text-center">Date</th>

										<th class="col-2 text-center">Incharge</th>

										<th class="col-1 text-center">Status</th>

										<th class="col-2 text-center">Action</th>

									</tr>

								</thead>

								<tbody>

                                    <?php

                                    $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 

                                    $id             = $row['mou_id']; 

                                    $date           = date('d M Y', strtotime(htmlspecialchars($row['date'], ENT_QUOTES)));

                                    $name           = htmlspecialchars($row['name'], ENT_QUOTES);

                                    $category_name  = htmlspecialchars($row['category'], ENT_QUOTES);

                                    $empName        = htmlspecialchars($row['empName'], ENT_QUOTES);

                                    $receiver_name  = htmlspecialchars(($row['cash_handler'] ?? ''), ENT_QUOTES);

                                    $moustatus      = htmlspecialchars($row['moustatus'], ENT_QUOTES);

                                    ?>

                                    <tr>

                                        <td class="col-1 text-center"><?php echo $i; $i++; ?></td>

                                        <td class="col-2 text-center"><?php echo $name; ?></td>

                                        <td class="col-2 text-center"><?php echo $category_name; ?></td>

                                        <td class="col-2 text-center"><?php echo $date; ?></td>

                                        <td class="col-2 text-center"><?php echo $empName; ?></td>

                                        <td class="col-1 text-end"><?php echo $moustatus; ?></td>

                                        <td class="col-2 text-center">

                                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-target="#top" title="View MOU details" onclick="viewMOU(<?php echo $id; ?>);" ><i class="lni lni-eye"></i></button>

                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="goEditMOU(<?php echo $id; ?>);" data-bs-toggle="tooltip" title="Edit MOU details" data-bs-target="#top"><i class="lni lni-pencil"></i></button>

                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete MOU details" data-bs-target="#top" onclick="goDeleteMOU(<?php echo $id; ?>);"><i class="lni lni-trash"></i></button>

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

<div id="loader" class="justify-content-center align-items-center" style="display: none;">

	<div class="card-body d-flex justify-content-center align-items-center text-center" style="height: 100vh;">

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

</div>	<!--start switcher-->



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

        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>



     <!-- Initialize tooltips -->

    

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {

                return new bootstrap.Tooltip(tooltipTriggerEl)

            })

        });



        function resetForm(formId) {

            // Reset the form fields

            $(formId)[0].reset();

        

            $(formId).removeClass('was-validated');

            $(formId).addClass('needs-validation');

        }

        

        function goDeleteMOU(mouId) {

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

                if (result.isConfirmed) {

                    $('#loader').show();

                    $.ajax({

                        url: 'action/actMOU.php',  

                        method: 'POST',

                        data: { delId: mouId },  

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

                                        $('#example2 [data-bs-toggle="tooltip"]').tooltip();

                                    });

                                });

                            } else {

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

                                text: 'An error occurred while deleting the MOU Details.',  

                                icon: 'error', 

                                showConfirmButton: false, 

                                timer: 3000  

                            });

                        }

                    });

                }

            });

        }

        

        function goEditMOU(mouId) {

            quillEdit.root.innerHTML = '';

            resetForm('#editMOUForm');

            $('#submitEditBtn').prop('disabled', false);

            $('#loader').show();

            $.ajax({

                url: 'action/actMOU.php',

                method: 'POST',

                data: {

                    mouId : mouId

                },

                dataType: 'json', 

                success: function(response) {

                        $('#MOUId').val(response.id); 

                        $('#collegeEdit').val(response.name);

                        $('#categoryNameEdit').val(response.category);

                        $('#dateEdit').val(response.date);

                        $('#inchargeNameEdit').val(response.incharge);

                        $('#mouStatusEdit').val(response.moustatus);

                        if (response.descript) {

                            quillEdit.root.innerHTML = response.descript;

                            $('#descriptionEdit').val(response.descript); 

                        }

                        $('#loader').hide();

                        $('#editMOUModal').modal('show');

                },

                error: function(xhr, status, error) {

                    console.error('AJAX request failed:', status, error);

                    $('#loader').hide();

                }

            });

        }

        

        function viewMOU(mouId) {

            $('#loader').show(); 

        

            $.ajax({

                url: 'action/actMOU.php', 

                method: 'POST',

                data: { view_expId: mouId },

                dataType: 'json',

                success: function(response) {

                    $('#viewName').text(response.name);

                    $('#viewCategoryName').text(response.catName);

                    $('#viewDate').text(response.date);

                    $('#viewInchargeName').text(response.incharge);

                    $('#viewStatus').text(response.status);

                    if (response.documents) {
                        // Split the comma-separated string
                        const images = response.documents.split(',');

                        // Generate HTML for each image as a link
                        let linksHTML = images.map(image => 
                            `<a href="https://asset.inforiya.in/ERP/ERP_image/MOU/${image.trim()}" target="_blank">${image.trim()}</a><br>`
                        ).join('');

                        // Set the HTML to the #viewDocuments element
                        $('#viewDocuments').html(linksHTML);
                    } else {
                        $('#viewDocuments').html('-');
                    }

                    $('#viewDescription').html(response.descript || '-');

        

                    $('#loader').hide(); 

                    $('#viewMOUModal').modal('show'); 

                },

                error: function(xhr, status, error) {

                    console.error('AJAX request failed:', status, error);

                    $('#loader').hide();

                    alert('Failed to fetch MOU details.');

                }

            });

        }

        

        var quill = new Quill('#editor', {

            theme: 'snow',

            modules: {

                toolbar: [

                    [{ 'header': [1, 2, false] }],

                    ['bold', 'italic', 'underline'],

                    ['link', 'blockquote', 'code-block', 'image'],

                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],

                    [{ 'align': [] }],

                    ['clean']

                ]

            }

        });

        

        var quillEdit = new Quill('#editorEdit', {

            theme: 'snow', // You can also use 'bubble' theme

            modules: {

                toolbar: [

                    [{ 'header': [1, 2, false] }],

                    ['bold', 'italic', 'underline'],

                    ['link', 'blockquote', 'code-block', 'image'],

                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],

                    [{ 'align': [] }],

                    ['clean'] // Removes formatting

                ]

            }

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

				

			$('#addMOUBtn').on('click', function() {

			    $('#submitFormBtn').prop('disabled', false);

                resetForm('#addMOUForm');

                quill.root.innerHTML = '';

            });

            



		    $('#addMOUForm').off('submit').on('submit', function (e) {

                e.preventDefault(); 

                

                $(this).find("input[required], textarea[required]").each(function () {

                    $(this).val($(this).val().trim());

                });



                if (!this.checkValidity()) {

                    $(this).addClass('was-validated');

                    return; 

                }

                

                const editorContent = quill.root.innerHTML; 

                $('#description').val(editorContent);

        

                var formData = new FormData(this);

                $('#submitFormBtn').prop('disabled', true);

                $('#loader').show();

                $.ajax({

                    url: "action/actMOU.php",

                    method: 'POST',

                    data: formData,

                    contentType: false,

                    processData: false,

                    dataType: 'json', 

                    success: function (response) {

                        if (response.status === "success") {

                            Swal.fire({

                                icon: 'success',

                                title: 'Success',

                                text: response.message,

                                timer: 1000

                            }).then(function () {

                                $('#addMOUModal').modal('hide'); 

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

                                        $('#example2 [data-bs-toggle="tooltip"]').tooltip();

                                    });

                                

                            });

                            // Reset the form after successful submission

                            $('#loader').hide();

                            resetForm('#addMOUForm');

                            $('#submitFormBtn').prop('disabled', false);

                        } else {

                            Swal.fire({

                                icon: 'error',

                                title: 'Error',

                                text: response.message

                            });

                            $('#submitFormBtn').prop('disabled', false);

                            $('#loader').hide();

                        }

                    },

                    error: function (xhr, status, error) {

                        $('#loader').hide();

                        console.error(xhr.responseText);

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: 'An error occurred while adding MOU details.'

                        });

                        $('#submitFormBtn').prop('disabled', false);

                    }

                });

            });

            

            $('#editMOUForm').off('submit').on('submit', function (e) {

                e.preventDefault(); 

                $(this).find("input[required], textarea[required]").each(function () {

                $(this).val($(this).val().trim());

                });

                if (!this.checkValidity()) {

                    $(this).addClass('was-validated');

                    return; 

                }

                const editorContent = quillEdit.root.innerHTML; 

                $('#descriptionEdit').val(editorContent);

                var formData = new FormData(this);

                $('#submitEditBtn').prop('disabled', true);

                $('#loader').show();

                $.ajax({

                    url: "action/actMOU.php",

                    method: 'POST',

                    data: formData,

                    contentType: false,

                    processData: false,

                    dataType: 'json', 

                    success: function (response) {

                        if (response.status === "success") {

                            Swal.fire({

                                icon: 'success',

                                title: 'Success',

                                text: response.message,

                                timer: 1000

                            }).then(function () {

                                $('#editMOUModal').modal('hide'); 

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

                                        $('#example2 [data-bs-toggle="tooltip"]').tooltip();

                                    });

                                

                            });

                            // Reset the form after successful submission

                            $('#loader').hide();

                            resetForm('#editMOUForm');

                            $('#submitEditBtn').prop('disabled', false);

                        } else {

                            Swal.fire({

                                icon: 'error',

                                title: 'Error',

                                text: response.message

                            });

                            $('#submitEditBtn').prop('disabled', false);

                            $('#loader').hide();

                        }

                    },

                    error: function (xhr, status, error) {

                        $('#loader').hide();

                        console.error(xhr.responseText);

                        Swal.fire({

                            icon: 'error',

                            title: 'Error',

                            text: 'An error occurred while updating MOU details.'

                        });

                        $('#submitEditBtn').prop('disabled', false);

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