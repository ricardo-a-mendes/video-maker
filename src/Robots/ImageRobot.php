<?php

namespace VMaker\Robots;

use Google_Service_Customsearch;
use Google_Service_Customsearch_Search;
use VMaker\Traits\SharedFunctions;

class ImageRobot
{
    use SharedFunctions;

    /**
     * Search for the images
     *
     * @param $term
     *
     * @return Google_Service_Customsearch_Search
     */
    public function searchImages($term): Google_Service_Customsearch_Search
    {
        $client = new \Google_Client();
        $client->setApplicationName("Video Maker");
        $client->setDeveloperKey($this->getConfig()->getGoogleApiKey());

        $service = new Google_Service_Customsearch($client);
        $resp = $service->cse->listCse([
                'cx' => $this->getConfig()->getGoogleSearchEngineId(),
                'q' => $term,
                'num' => 3,
                'searchType' => 'image'
            ]
        );

        return $resp;
    }
}
