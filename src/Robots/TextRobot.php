<?php

namespace VMaker\Robots;

use Algorithmia;
use stdClass;
use VMaker\Integration\AlgorithmiaWikipediaParserResponse;
use VMaker\Integration\IBMNaturalLanguageUnderstandingResponse;
use VMaker\Traits\SharedFunctions;

class TextRobot
{
    use SharedFunctions;

    /**
     * Searches for a wikipedia content
     *
     * @link https://algorithmia.com/algorithms/web/WikipediaParser
     *
     * @param string $searchTerm
     *
     * @return AlgorithmiaWikipediaParserResponse
     */
    public function fetchContentFromWikipedia(string $searchTerm): AlgorithmiaWikipediaParserResponse
    {
        $input = new stdClass();
        $input->articleName = $searchTerm;
        $input->lang = "en";

        $client = Algorithmia::client($this->getConfig()->getAlgorithmiaKey());
        $algo = $client->algo("web/WikipediaParser/0.1.2");
        $algo->setOptions(["timeout" => 300]); //optional
        return AlgorithmiaWikipediaParserResponse::create($algo->pipe($input)->result);
    }

    /**
     * Clean up the text by removing:
     *  - Blank lines
     *  - Lines starting with ==
     *  - Removing content surrounded by parentheses
     *
     * @param string $dirtyText
     *
     * @return string
     */
    public function sanitizeContent(string $dirtyText): string
    {
        $dirtyArray = explode("\n", $dirtyText);
        $cleanArray = array_filter(
            $dirtyArray,
            function ($dirty) {
                if ($dirty == '' || strpos($dirty, '==') === 0) {
                    return false;
                }
                return true;
            }
        );

        $cleanString = implode(' ', $cleanArray);
        $cleanString = preg_replace('/\([^)]*\)/', "", $cleanString);

        return $cleanString;
    }

    /**
     * Splits input string into sentences which are returned as a list of strings.
     *
     * @link https://algorithmia.com/algorithms/StanfordNLP/SentenceSplit
     *
     * @param string $fullText
     *
     * @return array
     */
    public function breakContentIntoSentences(string $fullText): array
    {
        $client = Algorithmia::client($this->getConfig()->getAlgorithmiaKey());
        $algo = $client->algo("StanfordNLP/SentenceSplit/0.1.0");
        $algo->setOptions(["timeout" => 300]);
        return $algo->pipe($fullText)->result;
    }

    /**
     * @param string $sentence
     * @param int $maxKeywords
     *
     * @return IBMNaturalLanguageUnderstandingResponse
     * @link https://cloud.ibm.com/apidocs/natural-language-understanding#analyzeget
     *
     * Available Features:
     * categories,concepts,emotion,entities,keywords,metadata,relations,semantic_roles,sentiment,summarization (experimental),syntax
     */
    public function fetchKeywords(string $sentence, int $maxKeywords = 10): IBMNaturalLanguageUnderstandingResponse
    {
        $args = [
            'text' => $sentence,
//            'url' => 'http://newsroom.ibm.com/Guerbet-and-IBM-Watson-Health-Announce-Strategic-Partnership-for-Artificial-Intelligence-in-Medical-Imaging-Liver',
            'features' => [
                'keywords' => ['limit' => $maxKeywords]
            ],
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->getConfig()->getIbmCloudNLUURL());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
        curl_setopt($ch, CURLOPT_USERPWD, "apikey:{$this->getConfig()->getIBMCloudNLUKey()}");

        $headers = [];
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return IBMNaturalLanguageUnderstandingResponse::create(json_decode($result));
    }
}
