<?php
session_start();
include("C:\\xampp\\htdocs\\ERP\\db\\dbConnection.php");
?>
<div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-3 section" id="syllabus">
                <h4>Application</h4>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $application_id = $_POST['id'];
                    // Define your query
                                $query = "SELECT *
                                FROM application_tbl
                                WHERE application_tbl.application_status='Active' 
                                AND application_tbl.section='syllabus' AND  application_id = '$application_id' 
                    ";
                    $resQuery = $conn->query($query);

                    // Check for query errors
                    if (!$resQuery) {
                        die("Query failed: " . $conn->error);
                    }

                    while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                        $application_id = $row['application_id'];
                        $application_discription = $row['application_discription'];
                        echo "<div class='card' data-id='$application_id' draggable='true'>$application_discription</div>";
                    }
                ?>
            </div>

            <div class="col-md-3 section" id="evaluation1">
                <h4>Evaluation 1</h4>
                <?php
                // Fetch evaluation1 data from the database
                $query = "SELECT app_evaluation_tbl.*,
                                application_tbl.*
                                FROM app_evaluation_tbl
                                LEFT JOIN application_tbl ON application_tbl.application_id = app_evaluation_tbl.application_id
                                WHERE app_evaluation_tbl.section='evaluation1' AND application_tbl.application_status='Active' 
                                AND app_evaluation_tbl.application_id='$application_id'";
                $resQuery = $conn->query($query);

                // Check for query errors
                if (!$resQuery) {
                    die("Query failed: " . $conn->error);
                }

                while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                    $id = $row['application_id'];
                    $application_discription = $row['application_discription'];
                    echo "<div class='card' data-id='$id' draggable='true'>$application_discription</div>";
                }
                ?>
            </div>
            <div class="col-md-3 section" id="evaluation2">
                <h4>Evaluation 2</h4>
                <?php
                // Fetch evaluation2 data from the database
                $query = "SELECT app_evaluation_tbl.*,
                                application_tbl.*
                                FROM app_evaluation_tbl
                                LEFT JOIN application_tbl ON application_tbl.application_id = app_evaluation_tbl.application_id
                                WHERE app_evaluation_tbl.section='evaluation2' AND application_tbl.application_status='Active'
                                AND app_evaluation_tbl.application_id='$application_id'";
                $resQuery = $conn->query($query);

                // Check for query errors
                if (!$resQuery) {
                    die("Query failed: " . $conn->error);
                }

                while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                    $id = $row['application_id'];
                    $application_discription = $row['application_discription'];
                    echo "<div class='card' data-id='$id' draggable='true'>$application_discription</div>";
                }
            }
                ?>
            </div>
    </div>
                    </div>
                    <script>
    document.addEventListener('DOMContentLoaded', () => {
    initializeDragAndDrop();
});

function initializeDragAndDrop() {
    const draggables = document.querySelectorAll('.card');
    const sections = document.querySelectorAll('.section');

    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', () => {
            draggable.classList.add('dragging');
        });

        draggable.addEventListener('dragend', () => {
            draggable.classList.remove('dragging');
        });
    });

    sections.forEach(section => {
        section.addEventListener('dragover', e => {
            e.preventDefault();
            const afterElement = getDragAfterElement(section, e.clientY);
            const draggingCard = document.querySelector('.dragging');
            if (afterElement == null) {
                section.appendChild(draggingCard);
            } else {
                section.insertBefore(draggingCard, afterElement);
            }
        });

        section.addEventListener('drop', e => {
            e.preventDefault();
            const draggingCard = document.querySelector('.dragging');
            updateDatabase(draggingCard.getAttribute('data-id'), section.id);
        });
    });
}

function getDragAfterElement(section, y) {
    const draggableElements = [...section.querySelectorAll('.card:not(.dragging)')];

    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

function updateDatabase(topicId, sectionId) {
    const formData = new FormData();
    formData.append('application_id', topicId);
    formData.append('section', sectionId);

    fetch('applicationUpdate.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        // Optionally refresh sections after updating database
    })
    .catch(error => console.error('Error updating database:', error));
}


</script>