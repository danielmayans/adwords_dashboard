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
function myFunction($month){
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

	$keyData = DownloadCriteriaReportWithAwqlExample($user, $filePath, $reportFormat, $month);

	print("<script>var filePath = \"".$filePath."\"</script>");

	return $keyData;

	} catch (Exception $e) {
	printf("An error has occurred: %s\n", $e->getMessage());
	session_destroy();
	}
}
	
?>