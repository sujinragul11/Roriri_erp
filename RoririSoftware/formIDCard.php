<!-- Modal -->
<div class="modal fade" id="addIDCardModal" tabindex="-1" aria-labelledby="idCardModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="idCardModalLabel">Add ID Card</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="idCardForm" class="row g-3 needs-validation" novalidate>
          <div class="mb-3">
            <label for="idCardNo" class="form-label">ID Card Number</label>
            <input type="text" class="form-control" id="idCardNo" name="idCardNo" required>
            <div class="invalid-feedback">
              Please provide a ID Card Number.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="saveIDCard">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Issue Modal -->
<div class="modal fade" id="issueCardModal" tabindex="-1" aria-labelledby="issueModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="issueModalLabel">Issue ID Card</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="issueCardForm" class="row g-3 needs-validation" novalidate>
          <input type="hidden" id="issueCardId" name="issueCardId">
          <input type="hidden" id="cardTrackId" name="cardTrackId">
          <div class="mb-2">
            <label for="issueCardNo" class="form-label">ID Card Number</label>
            <input type="text" class="form-control" id="issueCardNo" name="issueCardNo" required disabled>
            <div class="invalid-feedback">
              Please provide a ID Card Number.
            </div>
          </div>
          <div class="mb-2">
            <label for="internName" class="form-label">Intern Name</label>
            <select class="form-control" id="internName" name="internName" required>
                <option value="">--Select an Intern--</option>
            <?php 
                $sel_role = "SELECT `intern_id`, `name` FROM `internship_tbl` WHERE `status` = 'Active'";
                $res_role = mysqli_query($conn , $sel_role); 
                while($row = mysqli_fetch_array($res_role , MYSQLI_ASSOC)) { 
                    $intern_id = $row['intern_id'];
                    $name   = $row['name'];
                    echo '<option value="' . $intern_id . '">' . $name . '</option>';
                } 
            ?>
            </select>
            <div class="invalid-feedback">
              Please select the Intern Name.
            </div>
          </div>
          <div class="mb-2" id="issueDateField">
            <label for="issueDate" class="form-label">Issued Date</label>
            <input type="date" class="form-control" id="issueDate" name="issueDate" required>
            <div class="invalid-feedback">
              Please provide a Issued Date.
            </div>
          </div>
          <div class="mb-2" id="returnDateField" style="display: none;">
            <label for="returnDate" class="form-label">Returned Date</label>
            <input type="date" class="form-control" id="returnDate" name="returnDate">
            <div class="invalid-feedback">
              Please provide a Returned Date.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="submitFormBtn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>