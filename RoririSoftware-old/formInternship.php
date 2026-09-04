<!-- Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-dialog and modal-lg for large modal -->
        <div class="modal-content"> <!-- Added modal-content -->
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Starts Here -->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card">
                           
                            <div class="card-body p-4">
                                <form class="row g-3 needs-validation" id="candidatesForm" novalidate>
                                <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="hidden" name="hdnAction" value="addCandidate">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required 
                                    pattern="[A-Za-z\s]+" title="Please enter a valid name (letters and spaces only)">
                                <div class="invalid-feedback">
                                    Please enter a valid Name.
                                </div>
                            </div>

                                    <div class="col-md-6">
										<label for="course" class="form-label">Course Name</label>
										<select id="course" name="course" class="form-select" required>
											<option value="" selected>Choose Course</option>
											<option value="1">PHP</option>
											<option value="2">React</option>
											<option value="3">Python</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please enter a valid Course Name.
                                        </div>
									</div>

                                    <div class="col-md-6">
                                <label for="fees" class="form-label">Fees</label>
                                <input type="number" class="form-control" name="fees" id="fees" placeholder="fees" required 
                                    pattern="^[0-9]{10}$" title="Please enter a valid Fees.">
                                <div class="invalid-feedback">
                                    Please enter a valid Fees.
                                </div>
                            </div>

                            <div class="mb-3">
                            <label for="durationNo" class="form-label">Duration</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="durationNo" id="durationNo" placeholder="Duration No" required>
                                <select id="duration" name="duration" class="form-select" required>
                                    <option value="" selected>Choose unit</option>
                                    <option value="Day">Day</option>
                                    <option value="Week">Week</option>
                                    <option value="Month">Month</option>
                                    <option value="Year">Year</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid Duration number and unit.
                            </div>
                        </div>

                                    <div class="col-md-6">
										<label for="gender" class="form-label">Gender</label>
										<select id="gender" name="gender" class="form-select" required>
											<option value="" selected>Choose Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Others">Others</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please enter a valid Gender.
                                        </div>
									</div>

                                   


                                    <div class="col-md-6">
                                        <label for="mode" class="form-label">Mode</label>
										<select id="mode" name="mode" class="form-select" required>
											<option value="" selected>Choose the Mode</option>
											<option value="Online">Online</option>
											<option value="Offline">Offline</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please select the Mode.
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required 
                                    pattern="^[0-9]{10}$" title="Please enter a valid 10-digit phone number.">
                                <div class="invalid-feedback">
                                    Please enter a valid phone number.
                                </div>
                            </div>

                                    <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required 
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address.">
                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                </div>
                            </div>



                                    <div class="col-md-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="address" placeholder="Address ..." rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Please enter a valid address.
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="image" id="image" accept=".png, .jpg, .jpeg" required>
                                    <div class="invalid-feedback">
                                        Please select an image.
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="joiningDate" class="form-label">Joining Date</label>
                                        <input type="date" class="form-control" name="joiningDate" id="joiningDate" placeholder="Joining Date" required>
                                        <div class="invalid-feedback">
                                            Please select Joining Date.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="username" class="form-label">User Name</label>
                                        <input type="text" class="form-control" pattern="^[a-z]+_?[0-9]{0,5}$" placeholder="Enter the Username" name="username" id="username" required>
                                        <div class="invalid-feedback">
                                            Please choose a Username.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                        <div id="usernameError" class="error-message"></div>
                                        <div class="invalid-feedback">
                                            Please choose a password.
                                        </div>
                                    </div>
                                    
                                         
                                    
                                 
                                    <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 ms-auto justify-content-end">
                                        <button type="submit" id="saveCandidate" class="btn btn-primary px-4">Submit</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--end Modal Fade-->

<!-- edit madule -->


<!-- Modal -->
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-dialog and modal-lg for large modal -->
        <div class="modal-content"> <!-- Added modal-content -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Starts Here -->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card">
                           
                            <div class="card-body p-4">
                                <form class="row g-3 needs-validation" id="EditcandidatesForm" novalidate>
                                <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="hidden" name="hdnAction" value="EditCandidate">
                                <input type="hidden" name="EditId" id="EditId">
                                <input type="text" class="form-control" name="nameEdit" id="nameEdit" placeholder="Enter Name" required 
                                    pattern="[A-Za-z\s]+" title="Please enter a valid name (letters and spaces only)">
                                <div class="invalid-feedback">
                                    Please enter a valid Name.
                                </div>
                            </div>

                                    <div class="col-md-6">
										<label for="courseEdit" class="form-label">Course Name</label>
										<select id="courseEdit" name="courseEdit" class="form-select" required>
											<option value="" selected>Choose Course</option>
											<option value="1">PHP</option>
											<option value="2">React</option>
											<option value="3">Python</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please enter a valid Course Name.
                                        </div>
									</div>

                                    <div class="col-md-6">
                                <label for="feesEdit" class="form-label">Fees</label>
                                <input type="number" class="form-control" name="feesEdit" id="feesEdit" placeholder="Fess" required 
                                    pattern="^[0-9]{10}$" title="Please enter a valid  Fess.">
                                <div class="invalid-feedback">
                                    Please enter a valid Fees.
                                </div>
                            </div>

                            <div class="mb-3">
                            <label for="durationNoEdit" class="form-label">Duration</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="durationNoEdit" id="durationNoEdit" placeholder="Duration No" required>
                                <select id="durationEdit" name="durationEdit" class="form-select" required>
                                    <option value="" selected>Choose unit</option>
                                    <option value="Day">Day</option>
                                    <option value="Week">Week</option>
                                    <option value="Month">Month</option>
                                    <option value="Year">Year</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">
                                Please enter a valid Duration number and unit.
                            </div>
                        </div>

                                    <div class="col-md-6">
										<label for="genderEdit" class="form-label">Gender</label>
										<select id="genderEdit" name="genderEdit" class="form-select" required>
											<option value="" selected>Choose Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Others">Others</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please enter a valid Gender.
                                        </div>
									</div>

                                   


                                    <div class="col-md-6">
                                        <label for="modeEdit" class="form-label">Mode</label>
										<select id="modeEdit" name="modeEdit" class="form-select" required>
											<option value="" selected>Choose the Mode</option>
											<option value="Online">Online</option>
											<option value="Offline">Offline</option>
										</select>
                                        <div class="invalid-feedback">
                                            Please select the Mode.
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                <label for="phoneEdit" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phoneEdit" id="phoneEdit" placeholder="Phone" required 
                                    pattern="^[0-9]{10}$" title="Please enter a valid 10-digit phone number.">
                                <div class="invalid-feedback">
                                    Please enter a valid phone number.
                                </div>
                            </div>

                                    <div class="col-md-6">
                                <label for="emailEdit" class="form-label">Email</label>
                                <input type="email" class="form-control" name="emailEdit" id="emailEdit" placeholder="Email" required 
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address.">
                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                </div>
                            </div>



                                    <div class="col-md-12">
                                        <label for="addressEdit" class="form-label">Address</label>
                                        <textarea class="form-control" name="addressEdit" id="addressEdit" placeholder="Address ..." rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Please enter a valid address.
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                    <label for="imageEdit" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="imageEdit" id="imageEdit" accept=".png, .jpg, .jpeg" >
                                    <div class="invalid-feedback">
                                        Please select an image.
                                    </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="joiningDateEdit" class="form-label">Joining Date</label>
                                        <input type="date" class="form-control" name="joiningDateEdit" id="joiningDateEdit" placeholder="Joining Date" required>
                                        <div class="invalid-feedback">
                                            Please select Joining Date.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="usernameEdit" class="form-label">User Name</label>
                                        <input type="text" class="form-control" pattern="^[a-z]+_?[0-9]{0,5}$" placeholder="Enter the Username" name="usernameEdit" id="usernameEdit" required>
                                        <div class="invalid-feedback">
                                            Please choose a Username.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="passwordEdit" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="passwordEdit" id="passwordEdit" placeholder="Password" required>
                                        <div id="usernameError" class="error-message"></div>
                                        <div class="invalid-feedback">
                                            Please choose a password.
                                        </div>
                                    </div>
                                    
                                         
                                    
                                 
                                    <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 ms-auto justify-content-end">
                                        <button type="submit" id="saveCandidateEdit" class="btn btn-primary px-4">Submit</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- //view page  -->


