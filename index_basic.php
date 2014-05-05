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

<?php print('
    <form method="post" action="'.$_SERVER['PHP_SELF'].'">
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
    ');

    try{
        $arrayCampaigns = getCampaigns();
        $numCamp = count($arrayCampaigns);
        $numCamp>1
        ?print($numCamp.' campaigns found.<br/>')
        :print($numCamp.' campaign found.<br/>');

        print('<select name="campaign">');
        print('<option disabled selected>Select Campaign</option>');
        foreach($arrayCampaigns as $campaigns){
            foreach($campaigns as $in=>$name){
                print('<option value="'.$name.' "name="'.$name.'">'.$name.'</option>');
            }
        }
        print('</select>
            <input type="submit" name="enviar" value="Request"/>
            </form>');

        if(isset($_POST['month']) && isset($_POST['campaign'])){
            $month = $_POST['month'];
            $campaign = $_POST['campaign'];

            print('<script>var month = "'.$month.'";
                var campaign = "'.$campaign.'";

                $("option[name="+ month +"]").attr("selected","true");
                $("option[name="+ campaign +"]").attr("selected","true");

                </script>');
            $keyData = starter($month,$campaign);
            drawTable($keyData);
            
            if(isset($_POST['downloadcsv'])){
                downloadCSV($month,$campaign);
                $partes_ruta = pathinfo($_SERVER['REQUEST_URI']);
                $dirname = $partes_ruta['dirname'];
                print('<script>var dirname = "'.$dirname.'/lib/report.csv";alert_download();</script>');
            }
        }else{
            $month=null;
        }

    }catch(Exception $e){
        printf("An error has occurred: %s\n", $e->getMessage());
    }

?>
</body>
</html>