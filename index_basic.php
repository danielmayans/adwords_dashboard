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
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <select name="month">
            <option disabled selected>Select Month</option>
            <option name="jan" value="jan">January</option>
            <option name="feb" value="feb">February</option>
            <option name="mar" value="mar">March</option>
            <option name="apr" value="apr">April</option>
            <option name="may" value="may">May</option>
            <option name="jun" value="jun">June</option>
            <option name="jul" value="jul">July</option>
            <option name="aug" value="aug">August</option>
            <option name="sep" value="sep">September</option>
            <option name="oct" value="oct">October</option>
            <option name="nov" value="nov">November</option>
            <option name="dec" value="dec">December</option>
        </select>
        <input type="submit" name="enviar" value="GO!"/>
    </form>
<?php

    try{
        if(isset($_POST['month'])){
            $month = $_POST['month'];
            print('<script>var month = "'.$month.'";
                $("option[name="+ month +"]").attr("selected","true");
                </script>');
            $keyData = starter($month);
            drawTable($keyData);

            print('<script>starter();</script>');
        }else{
            $month=null;
        }
    }catch(Exception $e){
        printf("An error has occurred: %s\n", $e->getMessage());
    }

?>
</body>
</html>