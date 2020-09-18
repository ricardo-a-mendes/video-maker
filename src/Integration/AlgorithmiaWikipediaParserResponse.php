<?php

namespace VMaker\Integration;

use stdClass;

class AlgorithmiaWikipediaParserResponse
{
    private $title;
    private $content;

    public static function create(stdClass $algorithmiaResponse): AlgorithmiaWikipediaParserResponse
    {
        return (new AlgorithmiaWikipediaParserResponse())
            ->setTitle($algorithmiaResponse->title)
            ->setContent($algorithmiaResponse->content);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return AlgorithmiaWikipediaParserResponse
     */
    protected function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return AlgorithmiaWikipediaParserResponse
     */
    protected function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}
