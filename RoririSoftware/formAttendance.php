<!-- Modal -->
<div class="modal fade" id="addAttendanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form name="addAttendanceForm" id="addAttendanceForm" novalidate class="needs-validation">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Add Attendance</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group pb-3">
                                <label for="date" class="form-label"><b>Attendance Date</b></label>
                                <input type="date" class="form-control" id="date" name="date" max="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>">
                                <input type="hidden" id="allIds" name="allIds">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group pb-3">
                                <label for="inchargeName" class="form-label"><b>Incharge Name</b></label>
                                <select id="inchargeName" name="inchargeName" class="form-control">
                                    <option value="All">--All Interns--</option>
                                    <?php
                                        $sqlPerson2 = "SELECT
                                                            a.`id`,
                                                            a.`name`  
                                                        FROM
                                                            `basic_details` AS a
                                                        LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                                        LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                                        WHERE
                                                            a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                                    $resultPer2 = $conn->query($sqlPerson2);
                                    while ($row = $resultPer2->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label><b>Interns Name</b></label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="selectAllInterns">
                                    <label class="form-check-label" for="selectAllInterns"><b>Select All Interns</b></label>
                                </div>
                                <div class="row" id="internList">
                                    <!-- Interns will be dynamically loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitAttendance" class="btn btn-primary" disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editAttendanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form name="editAttendanceForm" id="editAttendanceForm" novalidate class="needs-validation">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Edit Attendance</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group pb-3">
                                <label for="dateEdit" class="form-label"><b>Attendance Date</b></label>
                                <input type="date" class="form-control" id="dateEdit" name="dateEdit" max="<?= date('Y-m-d'); ?>">
                                <input type="hidden" id="atdIdEdit" name="atdIdEdit">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group pb-3">
                                <label for="inchargeNameEdit" class="form-label"><b>Incharge Name</b></label>
                                <select id="inchargeNameEdit" name="inchargeNameEdit" class="form-control">
                                    <option value="All">--All Interns--</option>
                                    <?php
                                        $sqlPerson2 = "SELECT
                                                            a.`id`,
                                                            a.`name`  
                                                        FROM
                                                            `basic_details` AS a
                                                        LEFT JOIN `additional_details` AS b ON a.`id` = b.`basic_id`
                                                        LEFT JOIN `roles` AS c ON b.`role` = c.`role_id`
                                                        WHERE
                                                            a.`status` = 'Active' AND c.`role_id` NOT IN (10, 11)";
                                    $resultPer2 = $conn->query($sqlPerson2);
                                    while ($row = $resultPer2->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group pb-3">
                                <label><b>Interns Name</b></label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="selectAllInternsEdit">
                                    <label class="form-check-label" for="selectAllInternsEdit"><b>Select All Interns</b></label>
                                </div>
                                <div class="row" id="internListEdit">
                                    <!-- Interns will be dynamically loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitAttendEdit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
