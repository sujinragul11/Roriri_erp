<!-- Modal -->
<div class="modal fade" id="editTopicModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="frmEditTopic" id="editTopic" enctype="multipart/form-data" novalidate class="needs-validation">
                    <input type="hidden" name="hdnEditAction" value="hdnEditTopic">
                    <input type="hidden" name="editId" id="editTopicId">
                    
                    <div class="modal-header">
                        <h4 class="modal-title" id="staticBackdropLabel">Edit Topic</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="row p-3">
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="edit_topic_name" class="form-label"><b>Topic Name</b></label>
                                    <input type="text" class="form-control" placeholder="Enter topic name" name="edit_topic_name" id="edit_topic_name" required="required">
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="edit_description" class="form-label"><b>Topic Description</b></label>
                                    <textarea class="form-control" placeholder="Enter Topic Description" name="edit_description" id="edit_description" rows="4"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="form-group pb-3">
                                    <label for="edit_topic_duration" class="form-label"><b>Topic Duration</b></label>
                                    <input type="text" class="form-control" placeholder="Enter topic name" name="edit_topic_duration" id="edit_topic_duration" required="required"> 
                                </div>
                            </div>
                        </div>
                        </div>
                        <div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateBtn">Save changes</button>
                    </div>
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->