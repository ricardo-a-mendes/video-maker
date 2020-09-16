<?php

namespace VMaker\Data;

class Content
{
    /** @var string */
    private $searchTerm;

    /** @var string */
    private $prefix;

    /** @var string */
    private $sourceContentOriginal;

    /** @var string */
    private $sourceContentSanitized;

    /** @var Sentences */
    private $sentences;

    /**
     * @return string
     */
    public function getSearchTerm(): string
    {
        return $this->searchTerm;
    }

    /**
     * @param string $searchTerm
     *
     * @return Content
     */
    public function setSearchTerm(string $searchTerm): Content
    {
        $this->searchTerm = $searchTerm;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     *
     * @return Content
     */
    public function setPrefix(string $prefix): Content
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceContentOriginal(): string
    {
        return $this->sourceContentOriginal;
    }

    /**
     * @param string $sourceContentOriginal
     *
     * @return Content
     */
    public function setSourceContentOriginal(string $sourceContentOriginal): Content
    {
        $this->sourceContentOriginal = $sourceContentOriginal;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceContentSanitized(): string
    {
        return $this->sourceContentSanitized;
    }

    /**
     * @param string $sourceContentSanitized
     *
     * @return Content
     */
    public function setSourceContentSanitized(string $sourceContentSanitized): Content
    {
        $this->sourceContentSanitized = $sourceContentSanitized;
        return $this;
    }

    /**
     * @return Sentences
     */
    public function getSentences(): Sentences
    {
        return $this->sentences;
    }

    /**
     * @param Sentences $sentences
     *
     * @return Content
     */
    public function setSentences(Sentences $sentences): Content
    {
        $this->sentences = $sentences;
        return $this;
    }
}
