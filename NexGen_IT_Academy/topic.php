<?php 
session_start();
include("C:\\xampp\\htdocs\\ERP\\db\\dbConnection.php");
include("../url.php");
$selQuery = "SELECT subject_tbl.*,
       topic_tbl.*
      FROM topic_tbl
      LEFT JOIN subject_tbl ON subject_tbl.sub_id = topic_tbl.sub_id
      WHERE subject_tbl.sub_status='Active' AND topic_tbl.topic_status='Active'";
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
        <div class="page-wrapper">
            <div class="page-content">


                <div class="page-title-box">

                    <div class="page-title-right">
                        <h4 class="page-title">Topic</h4>
                        <div class="position-relative" style="height: 80px;">
                            <!-- Adjust height as needed -->
                            <button type="button" id="addTopicBtn" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Add Topic
                            </button>
                        </div>

                    </div>

                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dt-buttons btn-group">
                                            <button class="btn btn-outline-secondary buttons-copy buttons-html5"
                                                tabindex="0" aria-controls="example2"
                                                type="button"><span>Copy</span></button>
                                            <button class="btn btn-outline-secondary buttons-excel buttons-html5"
                                                tabindex="0" aria-controls="example2"
                                                type="button"><span>Excel</span></button> <button
                                                class="btn btn-outline-secondary buttons-pdf buttons-html5" tabindex="0"
                                                aria-controls="example2" type="button"><span>PDF</span></button> <button
                                                class="btn btn-outline-secondary buttons-print" tabindex="0"
                                                aria-controls="example2" type="button"><span>Print</span></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="example2_filter" class="dataTables_filter"><label>Search:<input
                                                    type="search" class="form-control form-control-sm" placeholder=""
                                                    aria-controls="example2"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="scroll-horizontal-datatable" class="table table-striped table-bordered dataTable"
                                            role="grid" aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="S. No: activate to sort column descending"
                                                        style="width: 100.828px;">S. No</th>

                                                    <th class="sorting" tabindex="0" aria-controls="example2"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Mobile: activate to sort column ascending"
                                                        style="width: 147.938px;">Topic</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Email: activate to sort column ascending"
                                                        style="width: 285.125px;">Duration</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Name: activate to sort column ascending"
                                                        style="width: 124.953px;">Course</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Action: activate to sort column ascending"
                                                        style="width: 303.766px;">Action</th>
                                                </tr>
                                            </thead>
                                            <?php $i=1; while($row = mysqli_fetch_array($resQuery , MYSQLI_ASSOC)) { 
									
                        $topic_id = $row['topic_id']; 
					
                        $topic_name=$row['topic_name'];
                        $sub_name=$row['sub_name'];
                        $topic_duration = $row['topic_duration'];
                        ?>
                                            <tbody>
                                                <tr role="row" class="odd">
                                                    <td class="sorting_1"><?php echo $i; $i++; ?></td>

                                                    <td><?php echo $topic_name; ?></td>
                                                    <td><?php echo $topic_duration; ?></td>
                                                    <td><?php echo $sub_name; ?></td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-circle btn-warning text-white modalBtn"
                                                            onclick="goEditTopic(<?php echo $topic_id; ?>);"
                                                            data-bs-toggle="modal" data-bs-target="#editTopicModal"><i
                                                                class='bx bx-pencil'></i></button>
                                                        <button class="btn btn-circle btn-danger text-white"
                                                            onclick="goDeleteTopic(<?php echo $topic_id; ?>);"><i
                                                                class="bx bx-trash"></i></button>
                                                        <button class="btn btn-circle btn-danger text-white"
                                                            onclick="goDeleteTopic(<?php echo $topic_id; ?>);">View Topic</button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="example2_info" role="status"
                                            aria-live="polite">Showing 1 to 3 of 3 entries</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled"
                                                    id="example2_previous">
                                                    <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0"
                                                        class="page-link">Prev</a>
                                                </li>
                                                <li class="paginate_button page-item active">
                                                    <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0"
                                                        class="page-link">1</a>
                                                </li>
                                                <li class="paginate_button page-item next disabled" id="example2_next">
                                                    <a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0"
                                                        class="page-link">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <footer class="page-footer">
        <p class="mb-0">Copyright Â© 2024. All right reserved.</p>
    </footer>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="<?php echo $bootsrapBundle; ?>"></script>
	<!--plugins-->
	<script src="<?php echo $js; ?>"></script>
	<script src="<?php echo $simplebar;?>"></script>
	<script src="<?php echo $mentimenu; ?>"></script>
	<script src="<?php echo $perfectScrolbar;  ?>"></script>
	<script src="<?php echo $datatbaleBootstrap;?>"></script>
     <!-- Include Bootstrap JS (with Popper) -->
    <script src="<?php echo $popper;?>"></script>
    <script src="<?php echo $bootStackPath;?>"></script>
	<script src="<?php echo $sweetalert; ?>"></script>
    <script>
    $(document).ready(function() {
        $('#addTopicBtn').click(function() {
            $('#addTopicModal').modal('show'); // Show the modal
            resetForm('addTopic'); // Reset the form
        });

        function resetForm(formId) {
            document.getElementById(formId).reset(); // Reset the form
        }


        $('#addTopic').off('submit').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = new FormData(this);
            $.ajax({
                url: "action/actTopic.php",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000
                        }).then(function() {
                            resetForm('addTopic');
                            $('#addTopicModal').modal('hide');
                            $('#scroll-horizontal-datatable').load(location.href +
                                ' #scroll-horizontal-datatable > *',
                                function() {
                                    $('#scroll-horizontal-datatable')
                                    .DataTable().destroy();
                                    $('#scroll-horizontal-datatable')
                                .DataTable({
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
                    // Handle error response
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while adding Task data.'
                    });
                    // Re-enable the submit button on error
                    $('#submitBtn').prop('disabled', false);
                }
            });
        });
    });
   // ajax edit course
   function goEditTopic(editId)

{
    $.ajax({
        url: 'action/actTopic.php',
        method: 'POST',
        data: {
            editId: editId
        },
        dataType: 'json', // Specify the expected data type as JSON
        success: function(response) {
            // alert(editId);
            //     console.log(response.sub_id);
            // alert(response.course_name);

            $('#editId').val(response.topic_id);

            // alert(response.topic_name);
             $('#edit_sub_name').val(response.sub_name);

            $('#edit_topic_name').val(response.topic_name);
            $('#edit_topic_duration').val(response.topic_duration);
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX request failed:', status, error);
        }
    });

}
document.addEventListener('DOMContentLoaded', function() {
    $('#editTopic').off('submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this);
        $.ajax({
            url: "action/actTopic.php",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                // Handle success response

                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000
                    }).then(function() {
                        $('#editTopicModal').modal('hide'); // Close the modal

                        $('.modal-backdrop').remove(); // Remove the backdrop   
                        $('#scroll-horizontal-datatable').load(location.href +
                            ' #scroll-horizontal-datatable > *',
                            function() {

                                $('#scroll-horizontal-datatable')
                                    .DataTable().destroy();

                                $('#scroll-horizontal-datatable')
                                    .DataTable({
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
                // Handle error response
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while Edit Task data.'
                });
                // Re-enable the submit button on error
                $('#updateBtn').prop('disabled', false);
            }
        });
    });
});
function goDeleteTopic(deleteId) {
        //alert(id);
        if (confirm("Are you sure you want to delete Topic?")) {
            $.ajax({
                url: 'action/actTopic.php',
                method: 'POST',
                data: {
                    deleteId: deleteId
                },
                //dataType: 'json', // Specify the expected data type as JSON
                success: function(response) {
                    $('#scroll-horizontal-datatable').load(location.href +
                        ' #scroll-horizontal-datatable > *',
                        function() {

                            $('#scroll-horizontal-datatable').DataTable().destroy();

                            $('#scroll-horizontal-datatable').DataTable({
                                "paging": true, // Enable pagination
                                "ordering": true, // Enable sorting
                                "searching": true // Enable searching
                            });
                        });


                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('AJAX request failed:', status, error);
                }
            });
        }
    }
    </script>
    <script src="<?php echo $app; ?>"></script> 
<script src="../assets/js/form-validation.js"></script>
</body>

</html>
<?php include("addTopic.php");?>
<?php include("editTopic.php");?>