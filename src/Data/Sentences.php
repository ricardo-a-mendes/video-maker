<?php

namespace VMaker\Data;

class Sentences
{
    /** @var string */
    private $text;

    /** @var string */
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
     * @return Sentences
     */
    public function setText(string $text): Sentences
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     *
     * @return Sentences
     */
    public function setKeywords(string $keywords): Sentences
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
     * @return Sentences
     */
    public function setImages(array $images): Sentences
    {
        $this->images = $images;
        return $this;
    }
}
