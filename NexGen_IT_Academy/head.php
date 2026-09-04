<?php 
       if(!isset($_SESSION['username']))
    {
        header("Location:../login.php");
        exit();
    } 
?>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="../assets/images/favicon-32x32.png" type="image/png"/>
	<!--plugins-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
	<link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet"/>
	<link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="../assets/css/pace.min.css" rel="stylesheet"/>
	<script src="../assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="../assets/css/app.css" rel="stylesheet">
	<link href="../assets/css/icons.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="../assets/css/dark-theme.css"/>
	<link rel="stylesheet" href="../assets/css/semi-dark.css"/>
	<link rel="stylesheet" href="../assets/css/header-colors.css"/>
		<!-- Include Quill's CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href='https://cdn.jsdelivr.net/npm/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<!-- Import Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

	<title>NEXGEN IT ACADEMY</title>
	<style>
	.tableproceess{
		background-color: #e2eb98;
	}
	.tablecomplete{
		background-color: #98b9eb;
	}
	.trainerTablecomplete{
		background-color: #6df15e;
	}
	        /* Loader overlay to cover the entire screen */
#loader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    display: none; /* Initially hidden */
    z-index: 9998; /* Ensure loader is above background but behind modal */
}

/* Center the loader spinner */
.loader-overlay {
    position: absolute;
    top: 50%; /* Move to the middle vertically */
    left: 50%; /* Move to the middle horizontally */
    transform: translate(-50%, -50%); /* Center the spinner perfectly */
    z-index: 9999; /* Ensure spinner is above background */
}

/* Spinner size */
.spinner-border {
    width: 3rem;
    height: 3rem;
}


    
    <!-- Custom CSS -->
 
        /* Apply Poppins font globally */
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px; /* Optional: Set a default font size */
            line-height: 1.6; /* Optional: Improve readability */
        }

        /* Ensure headings and strong text inherit */
        h1, h2, h3, h4, h5, h6, strong {
            font-weight: 600;
        }

        /* Add styling for tables */
        table {
            font-size: 14px; /* Optional: Adjust table text size */
        }
    
	</style>
	

</head>