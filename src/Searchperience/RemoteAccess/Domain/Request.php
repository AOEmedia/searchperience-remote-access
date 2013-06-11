<?php


namespace Searchperience\RemoteAccess\Domain;

/**
 * The searchperience request is responsible to generate an url that can be used to
 * retrieve valid results from a searchperience remote system.
 *
 * @author Pavlo Bogomolenko <pavlo.bogomolenko@aoemedia.de>
 * @author Timo Schmidt <timo.schmidt@aoemedia.de>
 */
class Request {
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $endPointHostname = 'http://client.searchperience.me/';

    /**
     * @var string
     */
    private $endpointPath = 'index.php?id=###instance###';

    /**
     * @var string
     */
    private $instance = '0';

    /**
     * @var string
     */
    private $namespace = 'searchperience';

    /**
     * @var array
     */
    private $facetOptionValue = array();

    /**
     * @var string
     */
    private $dataType = 'jsonp';

    /**
     * @var string
     */
    private $eid = 'tx_aoesolr_search';

    const FACET_MARKER = 'searchperience[facetsel][option]';

    /**
     * @var array key/count
     */
    private $addedFacests = array();

    /**
     * @param string $eid
     */
    public function setEid($eid)
    {
        $this->eid = $eid;
    }

    /**
     * @return string
     */
    public function getEid()
    {
        return $this->eid;
    }

    /**
     * @param string $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param string $endPointHostname
     */
    public function setEndPointHostname($endPointHostname)
    {
        $this->endPointHostname = $endPointHostname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndPointHostname()
    {
        return $this->endPointHostname;
    }

    /**
     * @param string $endpointPath
     */
    public function setEndpointPath($endpointPath)
    {
        $this->endpointPath = $endpointPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndpointPath()
    {
        return $this->endpointPath;
    }

    /**
     * @param $option
     * @param $value
     * @return $this
     */
    public function setFacetOptionValue($option, $value)
    {
        $this->facetOptionValue[] = array($option, $value);
        return $this;
    }

    /**
     * @return array
     */
    public function getFacetOptionValue()
    {
        return $this->facetOptionValue;
    }

    /**
     * @param int $instance
     */
    public function setInstance($instance)
    {
        $this->instancePid = $instance;
        return this;
    }

    /**
     * @return int
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    private function generateFacetParams()
    {
        $facet = '';
        $tmpFacetCount = 0;
        $this->addedFacests = array();
        foreach($this->getFacetOptionValue() as $facets){
            if(array_key_exists($facets[0], $this->addedFacests)) {
                $this->addedFacests[$facets[0]] = $this->addedFacests[$facets[0]] + 1;
                $tmpFacetCount = $this->addedFacests[$facets[0]];
            } else {
                $this->addedFacests[$facets[0]] = 0;
            }
            $facet .= '&' . self::FACET_MARKER . '[' . $facets[0] .  ']' .
                '[' . $tmpFacetCount  . ']' . '=' . $facets[1];
            $tmpFacetCount = 0;
        }
        return $facet;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $this->generateFacetParams();
        $path = str_replace('###instance###', $this->getInstance(), $this->getEndpointPath());
        $this->url = $this->getEndPointHostname()
            . $path
            . '&dataType='. $this->getDataType()
            . '&eID=' . $this->getEid()
            . $this->generateFacetParams();
        return $this->url;
    }

}