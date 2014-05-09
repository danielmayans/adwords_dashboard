<?php
session_start();
include 'lib/login_report.php';
?>
<!DOCTYPE html>
<html>
	<head>		
    	<script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/alerts.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
	</head>
<body>
<!--
    Silence is gold or almost.
-->
<?php init_dashboard(); ?>
</body>
</html>