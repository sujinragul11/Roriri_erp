<!-- Add Asset Modal -->
<div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssetModalLabel">Add Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAssetForm" novalidate class="needs-validation">
                    <!-- Hidden Field for htnName -->
                    <input type="hidden" id="htnName" name="htnName" value="addAsset" required>
                    
                    <!-- Row for Category and Subcategory -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="categorySelect" class="form-label">Select Category</label>
                            <select class="form-select" id="categorySelect" name="category_id" required onchange="loadSubCategories(this.value)">
                                <option value="" disabled selected>Select a category</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a category.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="subCategorySelect" class="form-label">Select Subcategory</label>
                            <select class="form-select" id="subCategorySelect" name="sub_category_id" required>
                                <option value="" disabled selected>Select a subcategory</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a subcategory.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row for Asset ID and Asset Name -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="assetId" class="form-label">Asset ID</label>
                            <input type="text" class="form-control" id="assetId" name="asset_id" required>
                            <div class="invalid-feedback">
                                Please enter a valid Asset ID.
                            </div>
                        </div>
                        <div class="col-md-6">
                    <label for="assetName" class="form-label">Asset Name</label>
                    <input type="text" class="form-control" id="assetName" name="asset_name" 
                           pattern="^(?!\s*$)[A-Za-z\s]+$" 
                           title="Please enter only letters and spaces. The name cannot start with a space or be empty/whitespace-only.">
                    <div class="invalid-feedback">
                        Please provide a valid asset name (letters and spaces only, cannot start with a space).
                    </div>
                </div>
                    </div>

                    <!-- Row for Vendor and Status -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="vendorSelect" class="form-label">Select Vendor</label>
                            <select class="form-select" id="vendorSelect" name="vendor_id">
                                <option value="" selected>Select a vendor</option>
                              <?php
                                $sql = "SELECT `vendor_id`, `vendor_name` FROM `asset_vendor` WHERE `status` = 'Active'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['vendor_id'] . '">' . $row['vendor_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No categories available</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a vendor.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="statusSelect" class="form-label">Status</label>
                            <select class="form-select" id="statusSelect" name="status" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="Assigned">Assigned</option>
                                <option value="Not in Use">Not in Use</option>
                                <option value="Repair">Repair</option>
                                <option value="Broken">Broken</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select the asset status.
                            </div>
                        </div>
                    </div>

                    <!-- Row for Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <!-- Row for Asset Date -->
                    <div class="mb-3">
                        <label for="assetDate" class="form-label">Buy Date</label>
                        <input type="date" class="form-control" id="assetDate" name="asset_date">
                        <div class="invalid-feedback">
                            Please select a date for the asset.
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Add Asset</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Asset Modal -->
<div class="modal fade" id="editAssetModal" tabindex="-1" aria-labelledby="editAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAssetModalLabel">Edit Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAssetForm" novalidate class="needs-validation">
                    <!-- Hidden Asset ID -->
                    <input type="hidden" id="editAssetId" name="assetpro_id">
                    <input type="hidden" name="htnName" value="editAsset" required>

                    <!-- Category and Subcategory Dropdowns -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editCategorySelect" class="form-label">Select Category</label>
                            <select class="form-select" id="editCategorySelect" name="category_id" required onchange="editLoadSubCategories(this.value)">
                                <option value="" disabled selected>Select a category</option>
                                <?php
                                $sql = "SELECT `assetcate_id`, `category_name` FROM `asset_category` WHERE `category_status` = 'Active'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['assetcate_id'] . '">' . $row['category_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No categories available</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a category.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="editSubCategorySelect" class="form-label">Select Subcategory</label>
                            <select class="form-select" id="editSubCategorySelect" name="sub_category_id" required>
                                <option value="" disabled selected>Select a subcategory</option>
                                <!-- Subcategory options populated via AJAX -->
                            </select>
                            <div class="invalid-feedback">
                                Please select a subcategory.
                            </div>
                        </div>
                    </div>

                    <!-- Asset ID and Name Inputs -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editAssetNo" class="form-label">Asset ID</label>
                            <input type="text" class="form-control" id="editAssetNo" name="asset_id" required>
                            <div class="invalid-feedback">
                                Please enter the asset ID.
                            </div>
                        </div>
                        <div class="col-md-6">
                        <label for="editAssetName" class="form-label">Asset Name</label>
                        <input type="text" class="form-control" id="editAssetName" name="asset_name" 
                               pattern="^(?!\s*$)[A-Za-z\s]+$" 
                               title="Please enter only letters and spaces. The name cannot start with a space or be empty/whitespace-only.">
                        <div class="invalid-feedback">
                            Please enter a valid asset name (letters and spaces only, cannot start with a space).
                        </div>
                    </div>
                    </div>

                    <!-- Vendor and Status Dropdowns -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editVendorSelect" class="form-label">Select Vendor</label>
                            <select class="form-select" id="editVendorSelect" name="vendor_id">
                                <option value="" selected>Select a vendor</option>
                                <?php
                                $sql = "SELECT `vendor_id`, `vendor_name` FROM `asset_vendor` WHERE `status` = 'Active'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['vendor_id'] . '">' . $row['vendor_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No categories available</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a vendor.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="editStatusSelect" class="form-label">Status</label>
                            <select class="form-select" id="editStatusSelect" name="status" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="Assigned">Assigned</option>
                                <option value="Not in Use">Not in Use</option>
                                <option value="Repair">Repair</option>
                                <option value="Broken">Broken</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select the asset status.
                            </div>
                        </div>
                    </div>

                    <!-- Description and Buy Date -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="editAssetDate" class="form-label">Buy Date</label>
                            <input type="date" class="form-control" id="editAssetDate" name="asset_date">
                            <div class="invalid-feedback">
                                Please select a date for the asset.
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Asset</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- View Asset Modal -->
<div class="modal fade" id="viewAssetModal" tabindex="-1" role="dialog" aria-labelledby="viewAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAssetModalLabel">Asset Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="viewAssetForm" novalidate class="needs-validation">
                    <div class="row">
                       
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="viewCategorySelect">Category</label>
                                <input type="text" class="form-control" id="viewCategorySelect" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="viewSubCategorySelect">Subcategory</label>
                                <input type="text" class="form-control" id="viewSubCategorySelect" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="viewAssetNo">Product Number</label>
                                <input type="text" class="form-control" id="viewAssetNo" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewAssetName">Product Name</label>
                        <input type="text" class="form-control" id="viewAssetName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewVendorSelect">Vendor</label>
                        <input type="text" class="form-control" id="viewVendorSelect" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewStatusSelect">Status</label>
                        <input type="text" class="form-control" id="viewStatusSelect" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewDescription">Description</label>
                        <textarea class="form-control" id="viewDescription" rows="3" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="viewAssetDate">Purchase Date</label>
                        <input type="text" class="form-control" id="viewAssetDate" readonly>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>



<!-- Add Assign Modal -->
<div class="modal fade" id="addAssignModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssignModalLabel">Assign Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAssignForm" novalidate class="needs-validation">
                    <!-- Hidden Field for htnName -->
                    <input type="hidden" id="assignHtnName" name="htnName" value="addAssign" required>
                    <input type="hidden" id="assignAssetId" name="assignAssetId" required>
                    
                    <!-- Row for Name and Room -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <select class="form-select" id="name" name="name" required>
                                <option value="" disabled selected>Select a Name</option>
                                <?php
                                $sql = "SELECT `id`, `username` FROM `basic_details` WHERE `status`= 'Active';";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No Name available</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Name.
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="room" class="form-label">Room</label>
                            <select class="form-select" id="room" name="room" required>
                                <option value="" disabled selected>Select a Room</option>
                                <?php
                                $sql = "SELECT `room_id`, `room_name` FROM `room_tbl` WHERE `room_status` ='Active'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['room_id'] . '">' . $row['room_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No Room available</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Room.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row for Start Date and End Date -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="asign_start_date" required>
                            <div class="invalid-feedback">
                                Please select a Start Date.
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Description Field -->
                    <div class="mb-3">
                        <label for="assignDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="assignDescription" name="assignDescription" rows="3"></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Add Asset</button>
                </form>
            </div>
        </div>
    </div>
</div>

