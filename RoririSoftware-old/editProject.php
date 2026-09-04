<!-- Modal -->

<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel">Edit Project</h5>
                <button type="button" class="btn-close" id="editCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="card-body p-4">
                <form class="row g-3" name="frmEditProject" id="editProject" enctype="multipart/form-data">
                    <input type="hidden" name="EhdnAction" value="editProject">
                    <input type="hidden" name="editPro" id="editPro" value="">

                    <div class="col-md-6">
                        <label for="pnameE" class="form-label">Project Name <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="text" class="form-control" name="pnameE" id="pnameE" placeholder="Project Name" required>
                            <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-notepad"></i></span>
                        </div>
                        <div id="nameErrorE" class="error-message">Please Enter your name</div>
                    </div>

                    <div class="col-md-6">
                        <label for="descriptionE" class="form-label">Description</label>
                        <textarea class="form-control" id="descriptionE" name="descriptionE" placeholder="Description ..." rows="2"></textarea>
                        <div id="descriptionError" class="error-message">Please Enter Description</div>
                    </div>

                    <div class="col-md-6">
                        <label for="clientNameE" class="form-label">Client Name <span class="text-danger">*</span></label>
                        <select class="form-select" name="clientNameE" id="clientNameE" required>
                            <option selected value="">Choose...</option>
                            <?php
                            $selClinet = "SELECT * FROM `client_tbl` WHERE client_status='Active'";
                            $res_client = mysqli_query($conn, $selClinet);
                            while ($rowClient = mysqli_fetch_array($res_client, MYSQLI_ASSOC)) {
                                $client_id = $rowClient['client_id'];
                                $client_name = $rowClient['client_name'];
                                echo '<option value="' . $client_id . '">' . $client_name . '</option>';
                            }
                            ?>
                        </select>
                        <div id="clientErrorE" class="error-message">Please Select Client</div>
                    </div>

                    <div class="col-md-6">
						<label for="input19" class="form-label">Service <span class="text-danger">*</span></label>
						<select id="editService" name="serviceE[]" class="form-select" multiple required>
						<option value=""></option>	
						<?php $sel_role="SELECT * FROM `services` WHERE status='Active'";
                            $res_role = mysqli_query($conn , $sel_role); 
                            while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                                $service_id = $row['service_id'];
                                $service_name = $row['service_name'];
                                              
                                echo '<option value="' . $service_id . '">' . $service_name . '</option>';
                        } ?>
						</select>
                        <div id="serviceErrorE" class="error-message">Please Select Services</div>
					</div>

                    <div class="col-md-12">
                        <label for="multiple-select-optgroup-field" class="form-label">Technology <span class="text-danger">*</span></label>
                        <select class="form-select" name="programmingE[]" id="multiple-select-optgroup-field" data-placeholder="Choose technologies" multiple required>
                            <?php
                            $sel_role = "SELECT * FROM `technology` WHERE STATUS='Active'";
                            $res_role = mysqli_query($conn, $sel_role);
                            while ($row = mysqli_fetch_array($res_role, MYSQLI_ASSOC)) {
                                $tech_id = $row['tech_id'];
                                $tech_name = $row['tech_name'];
                                echo '<option value="' . $tech_id . '">' . $tech_name . '</option>';
                            }
                            ?>
                        </select>
                        <div id="technologyErrorE" class="error-message">Please Select Technology</div>
                    </div>

                    <div class="col-md-12">
                        <label for="multiple-select-field" class="form-label">Developers<span class="text-danger">*</span></label>
                        <select class="form-select" name="developersE[]" id="multiple-select-field" data-placeholder="Choose developers" multiple required>
                            <?php
                            $sel_role = "SELECT basic_details.*, additional_details.* FROM basic_details LEFT JOIN additional_details ON additional_details.basic_id=basic_details.id WHERE additional_details.entity_id=1 AND basic_details.status='Active'";
                            $res_role = mysqli_query($conn, $sel_role);
                            while ($row = mysqli_fetch_array($res_role, MYSQLI_ASSOC)) {
                                $emp_id = $row['id'];
                                $name = $row['name'];
                                echo '<option value="' . $emp_id . '">' . $name . '</option>';
                            }
                            ?>
                        </select>
                        <div id="developersErrorE" class="error-message">Please Select Developers</div>
                    </div>

                    <div class="col-md-6">
                        <label for="startDateE" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="date" class="form-control" id="startDateE" name="startDateE" placeholder="Start date" required>
                            <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
                        </div>
                        <div id="startErrorE" class="error-message">Please Select date</div>
                    </div>

                    <div class="col-md-6">
                        <label for="durationE" class="form-label">Duration <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="text" class="form-control" id="durationE" name="durationE" placeholder="Duration">
                            <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-timer"></i></span>
                        </div>
                        <div id="durationErrorE" class="error-message">Please Enter duration</div>
                    </div>

                    <div class="col-md-6">
                        <label for="chargeE" class="form-label">Charge <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="text" class="form-control" id="chargeE" name="chargeE" placeholder="Total amount" required>
                            <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
                        </div>
                        <div id="chargeErrorE" class="error-message">Please Enter total amount</div>
                    </div>

                    <div class="col-md-6">
                        <label for="proStatusE" class="form-label">Project Status <span class="text-danger">*</span></label>
                        <select id="proStatusE" name="proStatusE" class="form-select" required>
                            <option selected value="">Choose...</option>
                            <option value="New">New</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <div id="statusErrorE" class="error-message">Please Select Project Status</div>
                    </div>
                    
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="updateBtn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        // Initialize select2 for multi-select fields
        $('#multiple-select-optgroup-field').select2();
        $('#multiple-select-field').select2();
        $('.selectpicker').selectpicker();
    });
</script> 

