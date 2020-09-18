<?php

namespace VMaker\Integration;

use stdClass;

class IBMNaturalLanguageUnderstandingResponse
{
    private $keywords = [];

    public static function create(stdClass $nluResponse): IBMNaturalLanguageUnderstandingResponse
    {
        return (new IBMNaturalLanguageUnderstandingResponse())
            ->setKeywords($nluResponse->keywords);
    }

    /**
     * @param array $keywords
     *
     * @return IBMNaturalLanguageUnderstandingResponse
     */
    protected function setKeywords(array $keywords): IBMNaturalLanguageUnderstandingResponse
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }
}
