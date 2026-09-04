<!-- Modal -->

<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="projectModalLabel">Add Project</h5>
						<button type="button" class="btn-close" id="modalCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				
						<div class="card-body p-4">
								
								<form class="row g-3" name="frmAddProject" id="addProject" enctype="multipart/form-data">
								<input type="hidden" name="hdnAction" value="addProject">
									<div class="col-md-6">
										<label for="input13" class="form-label">Project Name <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" name="pname" id="pname" placeholder="Project Name" required> 
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-notepad"></i></span>
										</div>
										<div id="nameError" class="error-message">Name is required.</div>
									</div>
                                    <div class="col-md-6">
										<label for="input23" class="form-label">Description </label>
										<textarea class="form-control" id="description" name="description" placeholder="Description ..." rows="2"></textarea>
									</div>
									<div class="col-md-6">
										<label for="input18" class="form-label">Client Name <span class="text-danger">*</span></label>
										
											<select class="form-select" name="clientName" id="clientName" required>
												<option selected value="">Choose....</option>
												<?php
												$selClinet="SELECT * FROM `client_tbl` WHERE client_status='Active'";
												$res_client=mysqli_query($conn,$selClinet);
												while($rowClient=mysqli_fetch_array($res_client,MYSQLI_ASSOC)){
													$client_id=$rowClient['client_id'];
													$client_name=$rowClient['client_name'];
													echo '<option value="'.$client_id.'">'.$client_name.'</option>';
												}
												
												?>

											</select>	
											<div id="clientError" class="error-message">Client Name is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input19" class="form-label">Services <span class="text-danger">*</span></label>
										<select class="form-select" name="service[]"  id="service" data-placeholder="Choose anything" multiple required>
											
											<?php $sel_service="SELECT * FROM `services` WHERE status='Active'";
												$res_service = mysqli_query($conn , $sel_service); 
												while($rowService = mysqli_fetch_array($res_service , MYSQLI_ASSOC)) { 
												$service_id = $rowService['service_id'];
												$service_name = $rowService['service_name'];
												echo '<option value="' . $service_id . '">' . $service_name . '</option>';
											} ?>
                                        </select>
										<div id="ServiceError" class="error-message">Service is required.</div>
									</div>
									<div class="col-md-12">
										<label for="input19" class="form-label">Technology <span class="text-danger">*</span></label>
										<select class="form-select" name="programming[]" id="multiple-select-clear-field" data-placeholder="Choose anything" multiple required>
											
										<?php $sel_role="SELECT * FROM `technology` WHERE STATUS='Active'";
                                            $res_role = mysqli_query($conn , $sel_role); 
                                            while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                                               $tech_id = $row['tech_id'];
                                               $tech_name = $row['tech_name'];
                                              
                                               echo '<option value="' . $tech_id . '">' . $tech_name . '</option>';
                                            } ?>
                                        </select>
										<div id="technologyError" class="error-message">Technology is required.</div>
									</div>
									<div class="col-md-12">
										<label for="input14" class="form-label">Developers<span class="text-danger">*</span></label>
                                        
                                            <select class="form-select" name="developers[]" id="multiple-select-custom-field" data-placeholder="Choose anything"  multiple required>
												
											<?php $sel_role="SELECT basic_details.*,
															additional_details.*
															FROM basic_details
															LEFT JOIN additional_details ON additional_details.basic_id=basic_details.id
															WHERE additional_details.entity_id=1 AND basic_details.status='Active'";
                                            $res_role = mysqli_query($conn , $sel_role); 
                                            while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                                               $emp_id = $row['id'];
                                               $name = $row['name'];
                                              
                                               echo '<option value="' . $emp_id . '">' . $name . '</option>';
                                            } ?>
                                            </select>
											<div id="developersError" class="error-message">Developers is required.</div>
                                        
									</div>
									
									
                                    <div class="col-md-6">
										<label for="input18" class="form-label">Start Date <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start date" required>
											<span class="position-absolute top-50 translate-middle-y"><i class='bx bx-calendar'></i></span>
										</div>
										<div id="dateError" class="error-message">Enter the date</div>
									</div>
									
                                    <div class="col-md-6">
										<label for="input17" class="form-label">Duration <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" id="duration" name="duration" placeholder="Hours">
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-timer"></i></span>
										</div>
										<div id="durationError" class="error-message">Duration is required.</div>
									</div>
									<div class="col-md-6">
										<label for="input16" class="form-label">Charge <span class="text-danger">*</span></label>
										<div class="position-relative input-icon">
											<input type="number" class="form-control" id="charge" name="charge" placeholder="Total amount" required>
											<span class="position-absolute top-50 translate-middle-y"><i class="lni lni-rupee"></i></span>
										</div>
										<div id="chargeError" class="error-message">Total Amount is required.</div>
									</div>
									
									<div class="col-md-6">
										<label for="input19" class="form-label">Project Status <span class="text-danger">*</span></label>
										<select id="proStatus" name="proStatus" class="form-select" required>
											<option selected value="">Choose...</option>
											<option value="New">New</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
										</select>
										<div id="projectError" class="error-message">Project Status is required.</div>
									</div>
									
								</form>
						</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="submitBtn" class="btn btn-primary">Save changes</button>
                            </div>
						
            </div>
						
				
	    </div> <!--end modal dialog-->
      
</div><!--end Modal Fade-->


<!-- Edit Project start -->




<script>
  $(document).ready(function() {
    $('#multiple-select-clear-field').select2();
    $('#multiple-select-custom-field').select2();
	$('.selectpicker').selectpicker();
  });
</script>
