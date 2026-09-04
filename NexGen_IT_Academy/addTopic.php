<!-- Modal -->
<div class="modal fade" id="addTopicModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="frmAddStudent" id="addTopic" enctype="multipart/form-data" novalidate class="needs-validation">
                <input type="hidden" name="hdnAction" value="addTopic">
                <input type="hidden" name="hdnSubId" id="subId">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Topic</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="topic_name" class="form-label"><b>Topic Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter Topic Name" name="topic_name" id="topic_name" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="description" class="form-label"><b>Topic Description</b></label>
                                <textarea class="form-control" placeholder="Enter Topic Description" name="description" id="description" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label for="topic_duration" class="form-label"><b>Topic Duration</b></label>
                                <input type="text" class="form-control" placeholder="Enter Topic Duration" name="topic_duration" id="topic_duration" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="topicSubmitBtn" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewTopicModal" tabindex="-1" aria-labelledby="viewTopicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewTopicModalLabel">Topic Material</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <div class="modal-body">
  <div class="border border-dark p-2 mb-2">
      <h5>Description</h5>
      <p id="topicDescription"></p>
  </div>
  <div>
      <h5 >Meterial</h5>
      <div id="topicMaterials" class="d-flex flex-wrap gap-3">
    <!-- Cards will be dynamically added here -->
  </div>
  </div>
  
</div>
    </div>
  </div>
</div>


