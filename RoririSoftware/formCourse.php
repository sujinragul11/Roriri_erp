<!-- Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Add Course Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="courseForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
          <div class="mb-3">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" required>
            <div class="invalid-feedback">
              Please provide a course name.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseLogo" class="form-label">Logo Image</label>
            <input type="file" class="form-control"  id="courseLogo" accept="image/*" required>
            <div class="invalid-feedback">
              Please upload a logo image.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="saveCourse">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Edit Course Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editCourseForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
          <input type="hidden"  id="course_id">
          <div class="mb-3">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="editCourseName" required>
            <div class="invalid-feedback">
              Please provide a course name.
            </div>
          </div>
          <div class="mb-3">
            <label for="courseLogo" class="form-label">Logo Image</label>
            <input type="file" class="form-control"  id="editCourseLogo" accept="image/*" required>
            <div class="invalid-feedback">
              Please upload a logo image.
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="editSaveCourse">Save</button>
      </div>
    </div>
  </div>
</div>

<!--PPT Add Modal -->
<div class="modal fade" id="pptModal" tabindex="-1" aria-labelledby="pptModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pptModalLabel">Upload PPT Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="pptForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
            <input type="hidden" id="courseId" name="courseId">
          <div class="mb-3">
            <label for="contentTitle" class="form-label">Content Title</label>
            <input type="text" class="form-control" id="contentTitle" name="contentTitle" required>
            <div class="invalid-feedback">
              Please provide a Content Title.
            </div>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            <div class="invalid-feedback">
                Please provide the Description.
            </div>
          </div>
          <div class="mb-3">
            <label for="ppt" class="form-label">Upload PPT</label>
            <input type="file" class="form-control" id="ppt" name="ppt" accept=".ppt,.pptx,.pdf,.doc,.docx,.txt" required>
            <div class="invalid-feedback">
                Please upload a valid PPT, PDF, Word, or TXT file.
            </div>
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

<!--PPT Edit Modal -->
<div class="modal fade" id="pptModalEdit" tabindex="-1" aria-labelledby="pptModalLabelEdit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pptModalLabelEdit">Edit PPT Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="pptFormEdit" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
            <input type="hidden" id="courseIdEdit" name="courseIdEdit">
            <input type="hidden" id="pptIdEdit" name="pptIdEdit">
          <div class="mb-3">
            <label for="contentTitleEdit" class="form-label">Content Title</label>
            <input type="text" class="form-control" id="contentTitleEdit" name="contentTitleEdit" required>
            <div class="invalid-feedback">
              Please provide a Content Title.
            </div>
          </div>
          <div class="mb-3">
            <label for="descriptionEdit" class="form-label">Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="4"></textarea>
            <div class="invalid-feedback">
                Please provide the Description.
            </div>
          </div>
          <div class="mb-3">
            <label for="pptEdit" class="form-label">Upload PPT</label>
            <input type="file" class="form-control" id="pptEdit" name="pptEdit" accept=".ppt,.pptx,.pdf,.doc,.docx,.txt">
            <div class="invalid-feedback">
                Please upload a valid PPT, PDF, Word, or TXT file.
            </div>
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
