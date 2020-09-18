<?php

namespace VMaker\Data;

class Sentence
{
    /** @var string */
    private $text;

    /** @var array */
    private $keywords;

    /** @var array */
    private $images = [];

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Sentence
     */
    public function setText(string $text): Sentence
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     *
     * @return Sentence
     */
    public function setKeywords(array $keywords): Sentence
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     *
     * @return Sentence
     */
    public function setImages(array $images): Sentence
    {
        $this->images = $images;
        return $this;
    }
}
