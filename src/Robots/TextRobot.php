<?php

namespace VMaker\Robots;

use VMaker\Traits\SharedFunctions;

class TextRobot
{
    use SharedFunctions;
    /**
     * @link https://algorithmia.com/algorithms/web/WikipediaParser
     *
     * @param string $searchTerm
     *
     * @return array
     */
    public function fetchContentFromWikipedia(string $searchTerm)
    {
        $input = new \stdClass();
        $input->articleName = $searchTerm;
        $input->lang = "en";

        $client = \Algorithmia::client($this->getConfig()->getAlgorithmiaKey());
        $algo = $client->algo("web/WikipediaParser/0.1.2");
        $algo->setOptions(["timeout" => 300]); //optional
        return $algo->pipe($input)->result;
    }

    public function sanitizeContent()
    {
    }

    public function breakContentIntoSentences()
    {
    }
}
