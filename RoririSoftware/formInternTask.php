<!-- Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Add Task </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="courseForm" class="row g-3 needs-validation" novalidate>
          <div class="mb-3">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" required>
            <div class="invalid-feedback">
              Please provide a course name.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseCategory" class="form-label">Category</label>
            <select class="form-select" id="courseCategory" required>
              <option value="" selected disabled>Select a category</option>
              <option value="1">Science</option>
              <option value="2">Arts</option>
              <option value="3">Commerce</option>
            </select>
            <div class="invalid-feedback">
              Please select a category.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseDuration" class="form-label">Duration</label>
            <select class="form-select" id="courseDuration" required>
              <option value="" selected disabled>Select duration</option>
              <option value="1">1 Month</option>
              <option value="3">3 Months</option>
              <option value="6">6 Months</option>
              <option value="12">1 Year</option>
            </select>
            <div class="invalid-feedback">
              Please select a duration.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseLevel" class="form-label">Level</label>
            <select class="form-select" id="courseLevel" required>
              <option value="" selected disabled>Select level</option>
              <option value="beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="advanced">Advanced</option>
            </select>
            <div class="invalid-feedback">
              Please select a level.
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary" id="saveTask">Save</button>
      </div>
    </div>
  </div>
</div>



<!-- edit modal -->

<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Edit Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="courseForm" class="row g-3 needs-validation" novalidate>
          <div class="mb-3">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" required>
            <div class="invalid-feedback">
              Please provide a course name.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseCategory" class="form-label">Category</label>
            <select class="form-select" id="courseCategory" required>
              <option value="" selected disabled>Select a category</option>
              <option value="1">Science</option>
              <option value="2">Arts</option>
              <option value="3">Commerce</option>
            </select>
            <div class="invalid-feedback">
              Please select a category.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseDuration" class="form-label">Duration</label>
            <select class="form-select" id="courseDuration" required>
              <option value="" selected disabled>Select duration</option>
              <option value="1">1 Month</option>
              <option value="3">3 Months</option>
              <option value="6">6 Months</option>
              <option value="12">1 Year</option>
            </select>
            <div class="invalid-feedback">
              Please select a duration.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseLevel" class="form-label">Level</label>
            <select class="form-select" id="courseLevel" required>
              <option value="" selected disabled>Select level</option>
              <option value="beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="advanced">Advanced</option>
            </select>
            <div class="invalid-feedback">
              Please select a level.
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="ediSaveTask">Save</button>
      </div>
    </div>
  </div>
</div>
