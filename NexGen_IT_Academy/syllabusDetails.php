<?php
session_start();
include("action/config.php");
$course_id = $_SESSION['course_id'];
$userId = $_SESSION['user_id'];
?>
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-md-3 section" id="syllabus">
            <h4>Syllabus</h4>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $sub_id = $_POST['subject'];

                // Define your query
                $query = "SELECT topic_tbl.* 
                          FROM topic_tbl 
                          WHERE topic_tbl.topic_status='Active' 
                          AND topic_tbl.section='syllabus' 
                          AND sub_id='$sub_id'";
                $resQuery = $conn->query($query);

                // Check for query errors
                if (!$resQuery) {
                    die("Query failed: " . $conn->error);
                }

                while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                    $id = $row['topic_id'];
                    $topic = $row['topic_name'];
                    echo "<div class='card' data-id='$id' data-sub-id='$sub_id' draggable='true'>$topic</div>";
                }
            
            ?>
        </div>

        <div class="col-md-3 section" id="evaluation1">
            <h4>Evaluation 1</h4>
            <?php
            // Fetch evaluation1 data from the database
            $query = "SELECT evaluation_tbl.*, topic_tbl.*
                      FROM topic_tbl
                      LEFT JOIN evaluation_tbl ON evaluation_tbl.topic_id = topic_tbl.topic_id
                      WHERE evaluation_tbl.section='evaluation1' 
                      AND topic_tbl.topic_status='Active' AND evaluation_tbl.sub_id='$sub_id'";
            $resQuery = $conn->query($query);

            // Check for query errors
            if (!$resQuery) {
                die("Query failed: " . $conn->error);
            }

            while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                $id = $row['topic_id'];
                $topic = $row['topic_name'];
                $sub_id = $row['sub_id']; // Assuming sub_id is part of the evaluation_tbl
                echo "<div class='card' data-id='$id' data-sub-id='$sub_id' draggable='true'>$topic</div>";
            }
            ?>
        </div>

        <div class="col-md-3 section" id="evaluation2">
            <h4>Evaluation 2</h4>
            <?php
            // Fetch evaluation2 data from the database
            $query = "SELECT evaluation_tbl.*, topic_tbl.*
                      FROM topic_tbl
                      LEFT JOIN evaluation_tbl ON evaluation_tbl.topic_id = topic_tbl.topic_id
                      WHERE evaluation_tbl.section='evaluation2' 
                      AND topic_tbl.topic_status='Active' AND evaluation_tbl.sub_id='$sub_id'";
            $resQuery = $conn->query($query);

            // Check for query errors
            if (!$resQuery) {
                die("Query failed: " . $conn->error);
            }

            while ($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
                $id = $row['topic_id'];
                $topic = $row['topic_name'];
                $sub_id = $row['sub_id']; // Assuming sub_id is part of the evaluation_tbl
                echo "<div class='card' data-id='$id' data-sub-id='$sub_id' draggable='true'>$topic</div>";
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
            const topicId = draggingCard.getAttribute('data-id');
            const sectionId = section.id;
            const subId = draggingCard.getAttribute('data-sub-id'); // Get subId
            updateDatabase(topicId, sectionId, subId);
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

function updateDatabase(topicId, sectionId, subId) {
    const formData = new FormData();
    formData.append('topic_id', topicId);
    formData.append('section', sectionId);
    formData.append('sub_id', subId);
    fetch('update.php', {
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
