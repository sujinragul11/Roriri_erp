<?php
session_start();
include "url.php";
include "db/dbConnection.php";

  
    
?>
<!doctype html>
<html lang="en">

<?php include "head.php";?>

<body>
<style>
        .error-message {
            color: red;
            display: none;
        }
        .error {
            border-color: red;
        }
    </style>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
			<?php include "left.php";?>
		<!--end sidebar wrapper -->
		<!--start header -->
			<?php include "top.php";?>
		<!--end header -->
		<!--start page wrapper -->
        <!-- Modal -->
        <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Edit Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="passwordForm" class="row g-3 needs-validation" novalidate>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['username'] ?>" required readonly>
            <div class="invalid-feedback">
              Please provide a Username.
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group" id="show_hide_password">
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $_SESSION['password'] ?>" required>
            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
            </div>
            <div class="invalid-feedback">
              Please provide a Password.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="savePassword">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include "formContact.php";?>
		
		<div class="page-wrapper">
			<div class="page-content">
			

			
				
				
				<div class="card">
							<div class="card-body">
								<ul class="nav nav-pills mb-3" role="tablist">
								    <li class="nav-item" role="presentation">
										<a class="nav-link active" data-bs-toggle="pill" href="#gmail" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='lni lni-google'></i>
												</div>
												<div class="tab-title">Gmail</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="pill" href="#instagram" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='lni lni-instagram'></i>
												</div>
												<div class="tab-title">Instagram</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="pill" href="#linkedin" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='lni lni-linkedin-original'></i>
												</div>
												<div class="tab-title">Linkedin</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="pill" href="#facebook" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='lni lni-facebook-original'></i>
												</div>
												<div class="tab-title">Facebook</div>
											</div>
										</a>
									</li>
									
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="pill" href="#youtube" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='lni lni-youtube'></i>
												</div>
												<div class="tab-title">Youtube</div>
											</div>
										</a>
									</li>
									
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="pill" href="#whatsapp" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='lni lni-whatsapp'></i>
												</div>
												<div class="tab-title">Whatsapp</div>
											</div>
										</a>
									</li>
									
										<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="pill" href="#whatsappchannel" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='lni lni-world'></i>
												</div>
												<div class="tab-title">Whatsapp Channel</div>
											</div>
										</a>
									</li>
									
								
								</ul>
								<div class="tab-content" id="pills-tabContent">
								    <div class="tab-pane fade show active" id="gmail" role="tabpanel">
                    					<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                    			    	<div class="col">
                                            <div class="card radius-10 bg-primary bg-gradient">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <p class="mb-0 text-white">RORIRI SOFTWARE SOLUTIONS</p>
                                                            <h6 class="my-1 text-white">
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    					<div class="col">
                    						<div class="card radius-10 bg-danger bg-gradient">
                    							<div class="card-body">
                    								<div class="d-flex align-items-center">
                    									<div>
                    										<p class="mb-0 text-white">NEXGEN IT COLLEGE</p>
                    										<h6 class="my-1 text-white">
                                                            </h6>
                    									</div>
                    									
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    					<div class="col">
                    						<div class="card radius-10 bg-warning bg-gradient">
                    							<div class="card-body">
                    								<div class="d-flex align-items-center">
                    									<div>
                    										<p class="mb-0 text-dark">NEXGEN IT ACADEMY</p>
                    										<h6 class="my-1 text-white">
                                                            </h6>
                    									</div>
                    									
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    					<div class="col">
                    						<div class="card radius-10 bg-success bg-gradient">
                    							<div class="card-body">
                    								<div class="d-flex align-items-center">
                    									<div>
                    										<p class="mb-0 text-white">RORIRI FOUNDATION</p>
                    										<h6 class="my-1 text-white">
                                                            </h6>
                    									</div>
                    									
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    					<div class="col">
                    						<div class="card radius-10 bg-success">
                    							<div class="card-body">
                    								<div class="d-flex align-items-center">
                    									<div>
                    										<p class="mb-0 text-white">RIYA IT CONSULTANCY</p>
                    										<h6 class="my-1 text-white">
                                                            </h6>
                    									
                    									</div>
                    								
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    					<div class="col">
                    						<div class="card radius-10 bg-info">
                    							<div class="card-body">
                    								<div class="d-flex align-items-center">
                    									<div>
                    										<p class="mb-0 text-dark">RIYA IAS ACADEMY</p>
                    										<h6 class="my-1 text-white">
                                                            </h6>
                    										
                    									</div>
                    									
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    					<div class="col">
                    						<div class="card radius-10 bg-danger">
                    							<div class="card-body">
                    								<div class="d-flex align-items-center">
                    									<div>
                    										<p class="mb-0 text-white">NEXEMY</p>
                    										<h6 class="my-1 text-white">
                                                            </h6>
                    									
                    									</div>
                    									
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    					<div class="col">
                    						<div class="card radius-10 bg-warning">
                    							<div class="card-body">
                    								<div class="d-flex align-items-center">
                    									<div>
                    										<p class="mb-0 text-dark">RITHISH FARMS</p>
                    										<h6 class="my-1 text-white">
                                                            </h6>
                    										
                    									</div>
                    								
                    								</div>
                    							</div>
                    						</div>
                    					</div>
                    				</div>
									</div>
									<div class="tab-pane fade" id="instagram" role="tabpanel">
					<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			    	<div class="col">
                        <div class="card radius-10 bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">RORIRI SOFTWARE SOLUTIONS</p>
                                        <h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/roriri_soft/profilecard/?igsh=MWpzbWV2N2dndjkwcA==" target="_blank" class="text-white d-inline">https://www.instagram.com/roriri_soft/profilecard/?igsh=MWpzbWV2N2dndjkwcA==</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col">
						<div class="card radius-10 bg-danger bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXGEN IT COLLEGE</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/nexgen_it_college/profilecard/?igsh=c3o3NXV1N2VvbGgw" target="_blank" class="text-white d-inline">https://www.instagram.com/nexgen_it_college/profilecard/?igsh=c3o3NXV1N2VvbGgw</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">NEXGEN IT ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/nexgenitacademy17?igsh=MTFsN2NtOHF5bnJ4OA==" target="_blank" class="text-white d-inline">https://www.instagram.com/nexgenitacademy17?igsh=MTFsN2NtOHF5bnJ4OA==</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI FOUNDATION</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/roriri_foundations/profilecard/?igsh=OHhoNDJncDhvc2g2" target="_blank" class="text-white d-inline">https://www.instagram.com/roriri_foundations/profilecard/?igsh=OHhoNDJncDhvc2g2</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RIYA IT CONSULTANCY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/riyaitconsultancy/profilecard/?igsh=enY2Z3N4ZjcyYTI3" target="_blank" class="text-white d-inline">https://www.instagram.com/riyaitconsultancy/profilecard/?igsh=enY2Z3N4ZjcyYTI3</a>
                                        </h6>
									
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RIYA IAS ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/riya_ias_academy_tvl?igsh=MWJzMDZhZzB6YThzNg==" target="_blank" class="text-white d-inline">https://www.instagram.com/riya_ias_academy_tvl?igsh=MWJzMDZhZzB6YThzNg==</a>
                                        </h6>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/nexemy_online?igsh=OWJsYXF3YzI4bHdm" target="_blank" class="text-white d-inline">https://www.instagram.com/nexemy_online?igsh=OWJsYXF3YzI4bHdm</a>
                                        </h6>
									
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RITHISH FARMS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.instagram.com/rithish_farms_/profilecard/?igsh=MXExNzRnNHMxcm8zbg==" target="_blank" class="text-white d-inline">https://www.instagram.com/rithish_farms_/profilecard/?igsh=MXExNzRnNHMxcm8zbg==</a>
                                        </h6>
										
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
									</div>
									<div class="tab-pane fade" id="linkedin" role="tabpanel">
											<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			    	<div class="col">
                        <div class="card radius-10 bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">RORIRI SOFTWARE SOLUTIONS</p>
                                        <h6 class="my-1 text-white">
                                            <a href="https://www.linkedin.com/company/roriri-software-solutions-pvt-ltd/" target="_blank" class="text-white d-inline">https://www.linkedin.com/company/roriri-software-solutions-pvt-ltd/</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col">
						<div class="card radius-10 bg-danger bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXGEN IT COLLEGE</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.linkedin.com/company/nexgen-it-college/" target="_blank" class="text-white d-inline">https://www.linkedin.com/company/nexgen-it-college/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">NEXGEN IT ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI FOUNDATION</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI GROUPS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RIYA IAS ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RITHISH FARMS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
									</div>
									<div class="tab-pane fade" id="facebook" role="tabpanel">
											<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			    	<div class="col">
                        <div class="card radius-10 bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">RORIRI SOFTWARE SOLUTIONS</p>
                                        <h6 class="my-1 text-white">
                                            <a href="https://www.facebook.com/share/12AMr63mTqx/" target="_blank" class="text-white d-inline">https://www.facebook.com/share/12AMr63mTqx/</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col">
						<div class="card radius-10 bg-danger bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXGEN IT COLLEGE</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.facebook.com/share/18Bv6yGbaE/" target="_blank" class="text-white d-inline">https://www.facebook.com/share/18Bv6yGbaE/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">NEXGEN IT ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI FOUNDATION</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI GROUPS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RIYA IAS ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RITHISH FARMS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
									</div>
									<div class="tab-pane fade" id="youtube" role="tabpanel">
											<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			    	<div class="col">
                        <div class="card radius-10 bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">RORIRI SOFTWARE SOLUTIONS</p>
                                        <h6 class="my-1 text-white">
                                            <a href="https://www.youtube.com/@Roriri_soft" target="_blank" class="text-white d-inline">https://www.youtube.com/@Roriri_soft</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col">
						<div class="card radius-10 bg-danger bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXGEN IT COLLEGE</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.youtube.com/@NexGenITcollege" target="_blank" class="text-white d-inline">https://www.youtube.com/@NexGenITcollege</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">NEXGEN IT ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.youtube.com/@NexGenITAcademy" target="_blank" class="text-white d-inline">https://www.youtube.com/@NexGenITAcademy</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI FOUNDATION</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI GROUPS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RIYA IAS ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.youtube.com/@Nexemy-online" target="_blank" class="text-white d-inline">https://www.youtube.com/@Nexemy-online</a>
                                        </h6>
									
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RITHISH FARMS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.youtube.com/@RithishFarms-p4m" target="_blank" class="text-white d-inline">https://www.youtube.com/@RithishFarms-p4m</a>
                                        </h6>
										
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
									</div>
									
									<div class="tab-pane fade" id="whatsapp" role="tabpanel">
										<	<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			    	<div class="col">
                        <div class="card radius-10 bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">RORIRI SOFTWARE SOLUTIONS</p>
                                        <h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col">
						<div class="card radius-10 bg-danger bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXGEN IT COLLEGE</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">NEXGEN IT ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI FOUNDATION</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI GROUPS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RIYA IAS ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RITHISH FARMS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
									</div>
									
									<div class="tab-pane fade" id="whatsappchannel" role="tabpanel">
											<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
			    	<div class="col">
                        <div class="card radius-10 bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">RORIRI SOFTWARE SOLUTIONS</p>
                                        <h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col">
						<div class="card radius-10 bg-danger bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXGEN IT COLLEGE</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">NEXGEN IT ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success bg-gradient">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI FOUNDATION</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">RORIRI GROUPS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RIYA IAS ACADEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">NEXEMY</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
									
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">RITHISH FARMS</p>
										<h6 class="my-1 text-white">
                                            <a href="https://www.roririsoft.com/" target="_blank" class="text-white d-inline">https://www.roririsoft.com/</a>
                                        </h6>
										
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
                
			
		
        

				
			</div><!--end page-content-->
		</div>
			
		<!--end page wrapper -->
		<!--start overlay-->
		 <?php include "footer.php"; ?>
	</div>
	<!--end wrapper-->
	<!--start switcher-->

	<!--end switcher-->
	<!-- Bootstrap JS -->
	<!-- Bootstrap JS -->
	<script src="assets/js/jquery.min.js"></script>
	<!--plugins-->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script src="assets/plugins/select2/js/select2-custom.js"></script>
	<script src="assets/js/app.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="assets/js/index.js"></script>
	<script src="assets/js/editPassword.js"></script>
<script>

        function resetForm(formId) {
            $(formId)[0].reset();
        
            $(formId).removeClass('was-validated');
            $(formId).addClass('needs-validation');
        }
        
        function goDeleteContact(contactId) {
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
                        url: 'action/actContact.php',  
                        method: 'POST',
                        data: { delId: contactId },  
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
                                text: 'An error occurred while deleting the Contact Details.',  
                                icon: 'error', 
                                showConfirmButton: false, 
                                timer: 3000  
                            });
                        }
                    });
                }
            });
        }
        
        function goEditContact(contactId) {
            resetForm('#editContactForm');
            $('#submitEditBtn').prop('disabled', false);
            $('#loader').show();
            $.ajax({
                url: 'action/actContact.php',
                method: 'POST',
                data: {
                    contactId : contactId
                },
                dataType: 'json', 
                success: function(response) {
                        $('#editContactId').val(response.id); 
                        $('#inchargeNameEdit').val(response.name);
                        $('#departmentEdit').val(response.department);
                        $('#contactEdit').val(response.contact);
                        $('#urlEdit').val(response.url);
                        $('#loader').hide();
                        $('#editContactModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    $('#loader').hide();
                }
            });
        }

$(document).ready(function() {
    // Initialize DataTable
    var table = $('#example2').DataTable({
        "paging": true,
        "ordering": true,
        "searching": true,
        "lengthChange": false,
        "pageLength": 10, // Set default records per page
        "buttons": ['copy', 'excel', 'pdf', 'print'],
    });

    // Append buttons to DataTable
    table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
        
            $('#addContact').on('click', function() {
			    $('#submitFormBtn').prop('disabled', false);
                resetForm('#addContactForm');
            });
        
            $('#addContactForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }
        
                var formData = new FormData(this);
                $('#submitFormBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actContact.php",
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
                                $('#addContactModal').modal('hide'); 
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
                            resetForm('#addContactForm');
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
                            text: 'An error occurred while adding Contact details.'
                        });
                        $('#submitFormBtn').prop('disabled', false);
                    }
                });
            });
            
            $('#editContactForm').off('submit').on('submit', function (e) {
                e.preventDefault(); 

                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return; 
                }
        
                var formData = new FormData(this);
                $('#submitEditBtn').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: "action/actContact.php",
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
                                $('#editContactModal').modal('hide'); 
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
                            resetForm('#editContactForm');
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
                            text: 'An error occurred while adding Contact details.'
                        });
                        $('#submitEditBtn').prop('disabled', false);
                    }
                });
            });

   
});
</script>
