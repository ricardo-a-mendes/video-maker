<?php

namespace VMaker\Integration;

class AlgorithmiaResponse
{
    private $title;
    private $content;

    public static function create(\stdClass $algorithmiaResponse): AlgorithmiaResponse
    {
        return (new AlgorithmiaResponse())
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
     * @return AlgorithmiaResponse
     */
    public function setTitle($title)
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
     * @return AlgorithmiaResponse
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}
