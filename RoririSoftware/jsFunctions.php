
<?php
header('Content-Type: application/javascript');
?>
<script>
function validateField(fieldId, errorId) {
        var value = $('#' + fieldId).val().trim();
        if (value === '') {
            $('#' + errorId).show();
            return false;
        } else {
            $('#' + errorId).hide();
            return true;
        }
    }
</script>