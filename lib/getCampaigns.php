<?php
function getCampaigns(){
  function GetCampaignsExample(AdWordsUser $user) {
    // Get the service, which loads the required classes.
    $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);

    // Create selector.
    $selector = new Selector();
    $selector->fields = array('Id', 'Name');
    $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

    // Create paging controls.
    $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

    $arrayCampaigns = array();

    do {
      // Make the get request.
      $page = $campaignService->get($selector);

      // Display results.
      if (isset($page->entries)) {
        foreach ($page->entries as $index=>$campaign) {
          /*
          printf("Campaign with name '%s' and ID '%s' was found.</br>\n",
              $campaign->name, $campaign->id);
          */
          $arrayCampaigns[$index] = array($campaign->id=>$campaign->name);
        }

        return $arrayCampaigns;

      } else {
        print "No campaigns were found.\n";
      }

      // Advance the paging index.
      $selector->paging->startIndex += AdWordsConstants::RECOMMENDED_PAGE_SIZE;
    } while ($page->totalNumEntries > $selector->paging->startIndex);
  }

  try {
    // Get AdWordsUser from credentials in "../auth.ini"
    // relative to the AdWordsUser.php file's directory.
    $user = new AdWordsUser();

    // Log every SOAP XML request and response.
    $user->LogAll();

    // Run the example.
    return GetCampaignsExample($user);

  } catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
  }
}

?>