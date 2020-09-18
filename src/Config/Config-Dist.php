<?php

namespace VMaker\Config;

class ConfigDist
{
    /*
     * Algorithmia
     */
    private $algorithmiaKey = '';

    /*
     * IBM
     */
    private $ibmCloudNLUKey = '';
    private $ibmCloudNLUURL = '';
    private $ibmCloudNLUVersion = '';

    /**
     * @return string
     */
    public function getAlgorithmiaKey(): string
    {
        return $this->algorithmiaKey;
    }

    /**
     * IBM: Natural Language Understanding (NLU)
     *
     * @return string
     */
    public function getIBMCloudNLUKey(): string
    {
        return $this->ibmCloudNLUKey;
    }

    /**
     * IBM: Natural Language Understanding (NLU)
     *
     * @return string
     */
    public function getIbmCloudNLUURL(): string
    {
        return $this->ibmCloudNLUURL;
    }

    /**
     * IBM: Natural Language Understanding (NLU)
     *
     * @return string
     */
    public function getIbmCloudNLUVersion(): string
    {
        return $this->ibmCloudNLUVersion;
    }
}
