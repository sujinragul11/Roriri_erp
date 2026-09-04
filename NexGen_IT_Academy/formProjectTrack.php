<!-- Modal -->
<div class="modal fade" id="addApplicationtrackModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddStudent" id="addApplicationForm" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addApplicationTrack">
                <input type="hidden" name="app_id" id="app_form_id">
                <input type="hidden" name="traineeId" id="traineeId">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Change Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        
                      <div class="col-sm-12">
                           <div class="form-group pb-3">
                                
                                <label for="application_status" class="form-label"><b>Project status</b></label> 
                                <select class="form-control" id="application_status" name="application_status" >
                                        <option value="">----Work Not Started----</option> 
                                        <option value="inprogress">In Progress</option> 
                                         <option value="Complete">Completed</option> 

                                    </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitCoursebtn" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
