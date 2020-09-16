<?php

namespace VMaker\Traits;

use VMaker\Config\Config;

trait SharedFunctions
{
    /** @var Config */
    private $config = null;

    public function getConfig(): Config
    {
        if (is_null($this->config)) {
            $this->config = new Config();
        }

        return $this->config;
    }
}
