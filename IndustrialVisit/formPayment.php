 <!--Add Popup Form Modal -->
        <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clientModalLabel">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body p-4">
								<form class="row g-3 needs-validation" id="addPayment" novalidate enctype="multipart/form-data">
								    <input type="hidden" name="hdnAction" value="addPayment">
								    	<div class="col-md-12">
										<label for="visit" class="form-label">IV Details</label>
										<select id="visit" name="visit" class="form-select" required>
											<option selected disabled value>--Select IV Details--</option>
											
											<?php 
											$select_qry ="SELECT
                                                        a.iv_id,
                                                        b.name,
                                                        a.iv_date
                                                    FROM
                                                        `iv_details_tbl` AS a
                                                    LEFT JOIN iv_client_tbl AS b
                                                    ON
                                                        a.college_id = b.id
                                                    WHERE
                                                        a.status = 'Active' AND a.iv_status = 'Upcoming';";
                                                        
                                                        $result =$conn->query($select_qry);
                                                        
                                                        while ($row = $result->fetch_assoc()) {
											
											?>
										<option value="<?php echo $row['iv_id']; ?>">
                                            <?php echo $row['name'] . " (" . date("d-M-Y", strtotime($row['iv_date'])) . ")"; ?>
                                        </option>
                                        											
											<?php } ?>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid IV Details.
										</div>
									</div>
									
									<div class="col-md-12">
										<label for="reason" class="form-label">Reason</label>
										<select id="reason" name="reason" class="form-select" required>
											<option selected disabled value>--Select Reason--</option>
											<option value="IV">IV</option>
											<option value="Food">Food</option>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid Reason.
										</div>
									</div>
									
									<div class="col-md-12">
										<label for="amount" class="form-label">Amount</label>
										<input type="number" class="form-control" id="amount" name="amount" placeholder="Enter The Amount" required>
										<div class="invalid-feedback">
											Enter The Amount. 
										</div>
									</div>
									
									<div class="col-md-12">
										<label for="paymentMethod" class="form-label">Payment Method</label>
										<select id="paymentMethod" name="paymentMethod" class="form-select" required>
											<option selected disabled value>--Select Payment Method--</option>
											<option value="GPay">GPay</option>
											<option value="PhonePay">PhonePay</option>
											<option value="Cash">Cash</option>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid Payment Method.
										</div>
									</div>
									

									
									<div class="col-md-12">
										<label for="transactionId" class="form-label">Transaction Id</label>
										<input type="text" class="form-control" id="transactionId" name="transactionId" placeholder="Enter The Transaction Id" >
										<div class="invalid-feedback">
											Enter The Transaction Id. 
										</div>
									</div>
									
										<div class="col-md-12">
										<label for="date" class="form-label">Paid Date</label>
										<input type="date" class="form-control" id="date" name="date" placeholder="Enter The Paid Date" required>
										<div class="invalid-feedback">
											Enter The Paid Date. 
										</div>
									</div>
							
                                    
						
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" id="submitFormBtn" class="btn btn-primary px-4">Submit</button>
											<!--<button type="reset" class="btn btn-light px-4">Reset</button>-->
										</div>
									</div>
								</form>
							</div>
                </div>
            </div>
        </div>
        
        
         <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Edit Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body p-4">
								<form class="row g-3 needs-validation" id="editPayment" novalidate enctype="multipart/form-data">
								    <input type="hidden" name="hdnAction" value="editPayment">
								    <input type="hidden" name="editPaymentId" id="editPaymentId"  value="editPayment">
								    	<div class="col-md-12">
										<label for="visitEdit" class="form-label">IV Details</label>
										<select id="visitEdit" name="visit" class="form-select" required>
											<option selected disabled value>--Select IV Details--</option>
											
											<?php 
											$select_qry ="SELECT
                                                        a.iv_id,
                                                        b.name,
                                                        a.iv_date
                                                    FROM
                                                        `iv_details_tbl` AS a
                                                    LEFT JOIN iv_client_tbl AS b
                                                    ON
                                                        a.college_id = b.id
                                                    WHERE
                                                        a.status = 'Active' AND a.iv_status = 'Upcoming';";
                                                        
                                                        $result =$conn->query($select_qry);
                                                        
                                                        while ($row = $result->fetch_assoc()) {
											
											?>
										<option value="<?php echo $row['iv_id']; ?>">
                                            <?php echo $row['name'] . " (" . date("d-M-Y", strtotime($row['iv_date'])) . ")"; ?>
                                        </option>
                                        											
											<?php } ?>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid IV Details.
										</div>
									</div>
									
									<div class="col-md-12">
										<label for="reasonEdit" class="form-label">Reason</label>
										<select id="reasonEdit" name="reason" class="form-select" required>
											<option selected disabled value>--Select Reason--</option>
											<option value="IV">IV</option>
											<option value="Food">Food</option>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid Reason.
										</div>
									</div>
									
									<div class="col-md-12">
										<label for="amountEdit" class="form-label">Amount</label>
										<input type="number" class="form-control" id="amountEdit" name="amount" placeholder="Enter The Amount" required>
										<div class="invalid-feedback">
											Enter The Amount. 
										</div>
									</div>
									
									<div class="col-md-12">
										<label for="paymentMethodEdit" class="form-label">Payment Method</label>
										<select id="paymentMethodEdit" name="paymentMethod" class="form-select" required>
											<option selected disabled value>--Select Payment Method--</option>
											<option value="GPay">GPay</option>
											<option value="PhonePay">PhonePay</option>
											<option value="Cash">Cash</option>
											
										</select>
										<div class="invalid-feedback">
										   Please select a valid Payment Method.
										</div>
									</div>
									

									
									<div class="col-md-12">
										<label for="transactionIdEdit" class="form-label">Transaction Id</label>
										<input type="text" class="form-control" id="transactionIdEdit" name="transactionId" placeholder="Enter The Transaction Id" >
										<div class="invalid-feedback">
											Enter The Transaction Id. 
										</div>
									</div>
									
										<div class="col-md-12">
										<label for="dateEdit" class="form-label">Paid Date</label>
										<input type="date" class="form-control" id="dateEdit" name="date" placeholder="Enter The Paid Date" required>
										<div class="invalid-feedback">
											Enter The Paid Date. 
										</div>
									</div>
							
                                    
						
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" id="submitEditBtn" class="btn btn-primary px-4">Submit</button>
											<!--<button type="reset" class="btn btn-light px-4">Reset</button>-->
										</div>
									</div>
								</form>
							</div>
                </div>
            </div>
        </div>