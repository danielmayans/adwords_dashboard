<?php

error_reporting(E_STRICT | E_ALL);

// Include the initialization file
include 'lib/getCampaigns.php';
include 'lib/tables.php';

require_once 'lib/class/KeywordData.class.php';
require_once 'lib/class/AdWordsAdapter.class.php';
require_once 'lib/credentialHandler.php';
require_once 'init.php';

require_once ADWORDS_UTIL_PATH . '/ReportUtils.php';

function init_dashboard(){
try{
    print('
    <form method="post" action="'.$_SERVER['PHP_SELF'].'">
        <input type="checkbox" name=" []" value="Id"> KeyWordID
        <input type="checkbox" name="check_list[]" value="Criteria"> KeyWord Name
        <input type="checkbox" name="check_list[]" value="CriteriaType"> CriteriaType</br>
        <input type="checkbox" name="check_list[]" value="CampaignId"> CampaignID
        <input type="checkbox" name="check_list[]" value="CampaignName"> Campaign Name
        <input type="checkbox" name="check_list[]" value="AdGroupId"> AdgroupID</br>
        <input type="checkbox" name="check_list[]" value="Impressions"> Impressions
        <input type="checkbox" name="check_list[]" value="Clicks"> Clicks
        <input type="checkbox" name="check_list[]" value="Cost"> Costs</br>
	
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
        </select></br>
    ');

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
            
            print('<script>	
            	var month = "'.$month.'";
				var campaign = "'.$campaign.'";

				$("option[name="+ month +"]").attr("selected","true");
				$("option[name="+ campaign +"]").attr("selected","true");
			</script>');

			if(!empty($_POST['check_list'])) {
			    $op_checked = $_POST['check_list'];
	            $keyData = starter($month,$campaign,$op_checked);
	            drawTable($keyData);
			}
            
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
}

function starter($month,$campaign,$op_checked){
	try {

	checkLogout();
	$credentials = getCredentials();
	$CLIENT_ID = $credentials[0];
	$CLIENT_SECRET = $credentials[1];
	$REFRESH_TOKEN = $credentials[2];
	$DEVELOPER_TOKEN = $credentials[3];
	$CLIENT_CUSTOMER_ID = $credentials[4];

	$adwordsData = new AdWordsAdapter($CLIENT_ID,$CLIENT_SECRET,$REFRESH_TOKEN,$DEVELOPER_TOKEN,$CLIENT_CUSTOMER_ID);

	saveSession();

	$oauth2Info = array(
	  'client_id' => $CLIENT_ID,
	  'client_secret' => $CLIENT_SECRET,
	  'refresh_token' => $REFRESH_TOKEN
	);

	// See AdWordsUser constructor
	$user = new AdWordsUser(NULL, NULL, NULL, $DEVELOPER_TOKEN, NULL, NULL,
	    $CLIENT_CUSTOMER_ID, NULL, NULL, $oauth2Info);

	$user->LogAll();

	// Get the OAuth2 credential.
	RunExample($user);

	// Download the report to a file in the same directory as the example.
	$filePath = dirname(__FILE__) . '/report.xml';
	$reportFormat = 'XML';

	// Run the example.
	//$month="jan";

	$keyData = DownloadCriteriaReportWithAwqlExample($user, $filePath, $reportFormat, $month, $campaign,$op_checked);

	print("<script>var filePath = \"".$filePath."\"</script>");

	return $keyData;

	} catch (Exception $e) {
	printf("An error has occurred: %s\n", $e->getMessage());
	session_destroy();
	}
}

function downloadCSV($month,$campaign){
	try {

	checkLogout();
	$credentials = getCredentials();
	$CLIENT_ID = $credentials[0];
	$CLIENT_SECRET = $credentials[1];
	$REFRESH_TOKEN = $credentials[2];
	$DEVELOPER_TOKEN = $credentials[3];
	$CLIENT_CUSTOMER_ID = $credentials[4];

	$adwordsData = new AdWordsAdapter($CLIENT_ID,$CLIENT_SECRET,$REFRESH_TOKEN,$DEVELOPER_TOKEN,$CLIENT_CUSTOMER_ID);

	saveSession();

	$oauth2Info = array(
	  'client_id' => $CLIENT_ID,
	  'client_secret' => $CLIENT_SECRET,
	  'refresh_token' => $REFRESH_TOKEN
	);

	// See AdWordsUser constructor
	$user = new AdWordsUser(NULL, NULL, NULL, $DEVELOPER_TOKEN, NULL, NULL,
	    $CLIENT_CUSTOMER_ID, NULL, NULL, $oauth2Info);

	$user->LogAll();

	// Get the OAuth2 credential.
	RunExample($user);

	// Download the report to a file in the same directory as the example.

	$filePath = dirname(__FILE__) . '/report.csv';

	$reportFormat = 'CSV';
		
	// Run the example.
	//$month="jan";

	DownloadCriteriaReportWithAwqlExample($user, $filePath, $reportFormat, $month, $campaign);
	

	} catch (Exception $e) {
	printf("An error has occurred: %s\n", $e->getMessage());
	session_destroy();
	}
}
	
?>