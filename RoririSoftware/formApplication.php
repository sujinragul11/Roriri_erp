
        <!-- Popup Form Modal -->
        <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="applicationModalLabel">Application Assignment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="applicationForm" enctype="multipart/form-data" novalidate class="needs-validation">
                            <div class="mb-3">
                                <label for="appli_name" class="form-label">Application Name</label>
                                <input type="hidden"  id="intern_id" name="intern_id">
                                <input type="text" class="form-control" id="appli_name" name="appli_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="appli_description" class="form-label">Application Description</label>
                                <div id="editor" style="height: 200px;"></div>
                                <textarea class="form-control" name="appli_description" id="appli_description" style="display:none;"></textarea>
                            </div> 
                            <div class="mb-3">
                                <label for="documents" class="form-label">Task Related Documents</label>
                                <input type="file" class="form-control" id="documents" name="documents[]" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .txt, .xls, .xlsx" multiple>
                            </div>
                            
                            <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitFormBtn">Submit</button>
                    </div>
                            
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
        
        
        <!--Task Edit Popup Form Modal -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel">Edit Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Content -->
                        <form id="applicationFormEdit" enctype="multipart/form-data" novalidate class="needs-validation">
                            <input type="hidden"  id="intern_idEdit" name="intern_idEdit">
                            <input type="hidden"  id="appli_idEdit" name="appli_idEdit">
                            <div class="mb-3">
                                <label for="appli_nameEdit" class="form-label">Application Name</label>
                                <input type="text" class="form-control" id="appli_nameEdit" name="appli_nameEdit" required>
                            </div>
                            <div class="mb-3">
                                <label for="appli_descriptionEdit" class="form-label">Application Description</label>
                                <div id="editorEdit" style="height: 200px;"></div>
                                <textarea class="form-control" name="appli_descriptionEdit" id="appli_descriptionEdit" style="display:none;"></textarea>
                            </div> 
                            <div class="mb-3">
                                <label for="documentsEdit" class="form-label">Task Related Documents</label>
                                <input type="file" class="form-control" id="documentsEdit" name="documentsEdit[]" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .txt, .xls, .xlsx" multiple>
                            </div>
                            <div class="mb-3">
                                <label for="statusEdit" class="form-label">Task Status</label>
                                <select class="form-control" id="statusEdit" name="statusEdit" required>
                                    <option value="">Select Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="taskMark" class="form-label">Task Mark</label>
                                <input type="number" class="form-control" id="taskMark" name="taskMark" min="0" max="10">
                            </div>
                            <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitEditBtn">Submit</button>
                    </div>
                            
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-2" id="viewTaskModalLabel">Task Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Expense Details Content -->
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Task</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewTaskName" class="fs-5"></span>
                            </div>
                        </div>
        
                        <!--<div class="row mb-3">-->
                        <!--    <div class="col-4">-->
                        <!--        <strong class="fs-5">Task Description</strong>-->
                        <!--    </div>-->
                        <!--    <div class="col-1">-->
                        <!--        <strong class="fs-5">:</strong>-->
                        <!--    </div>-->
                        <!--    <div class="col-7">-->
                        <!--        <span id="viewDescription" class="fs-5"></span>-->
                        <!--    </div>-->
                        <!--</div>-->
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Assigned Date</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewAssignedDate" class="fs-5"></span>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Assigned By</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewAssignedBy" class="fs-5"></span>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Task Status</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewTaskStatus" class="fs-5"></span>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Verified Date</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewVerifiedDate" class="fs-5"></span>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Verified Status</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewVerifiedStatus" class="fs-5"></span>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Verified By</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewVerifiedBy" class="fs-5"></span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Task Mark</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <span id="viewTaskMark" class="fs-5"></span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Refer Documents</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <p id="viewReferImages" class="fs-5"></p>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <div class="col-4">
                                <strong class="fs-5">Intern Description</strong>
                            </div>
                            <div class="col-1">
                                <strong class="fs-5">:</strong>
                            </div>
                            <div class="col-7">
                                <p id="viewInternDescript" class="fs-5"></p>
                            </div>
                        </div>
        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>