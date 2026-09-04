 <!-- Modal for Adding Student -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form id="studentForm" novalidate class="needs-validation">
                      <input type="hidden" name="action" value="addStudent" >
                      <input type="hidden" name="iv_id_form"  id="iv_id_form" >
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required pattern="^[A-Za-z\s]+$">
                        <div class="invalid-feedback">Please enter a valid name (letters only).</div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required pattern="^\d{10}$">
                        <div class="invalid-feedback">Please enter a 10-digit phone number.</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                        <div class="invalid-feedback">Please enter an address.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addStudent()">Add Student</button>
                    </div>
                </form>
                                </div>
                
            </div>
        </div>
    </div>
</div>