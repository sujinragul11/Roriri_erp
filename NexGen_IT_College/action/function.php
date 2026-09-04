<?php
function formatDate($date) {
		// Create a DateTime object from the input date
		$dateObject = new DateTime($date);
		
		// Format the date as "day month year"
		return $dateObject->format('d F Y');
	}
    ?>