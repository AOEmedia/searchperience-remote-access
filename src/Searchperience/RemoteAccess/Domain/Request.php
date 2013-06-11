<?php


namespace Searchperience\RemoteAccess\Domain;
use Searchperience\RemoteAccess\Domain\Exeption\FacetExeption;
use Searchperience\RemoteAccess\Domain\Exeption\UrlExeption;

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

	/**
	 * @var string
	 */
	private $action = 'search';

	/**
	 * @var string
	 */
	private $controller = 'Search';

	const FACET_MARKER = '[facetsel][option]';

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
		return '&eID=' . $this->eid;
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
		return '&dataType='. $this->dataType;
	}

	/**
	 * @param string $endPointHostname
	 */
	public function setEndPointHostname($endPointHostname)
	{
		if(!filter_var($endPointHostname, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
			throw new UrlExeption("wrong hostname format");
		}

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
		if (preg_match('/[^A-Za-z0-9_\-]/', $option)) {
			throw new FacetExeption("illegal charecter detected in facet option");
		}

		if (preg_match('/[^A-Za-z0-9\-]/', $value)) {
			throw new FacetExeption("illegal charecter detected in facet value");
		}

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
		return $this;
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
	private function getAction() {
		return $this->getNamespace() . '[action]=' . $this->action;
	}

	/**
	 * @return string
	 */
	private function getController() {
		return '&'. $this->getNamespace() . '[controller]=' . $this->controller;
	}

	/**
	 * @return string
	 */
	public function generateFacetParams()
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
			$facet .= '&' . $this->getNamespace() . self::FACET_MARKER . '[' . $facets[0] .  ']' .
				'[' . $tmpFacetCount  . ']' . '=' . $facets[1];
			$tmpFacetCount = 0;
		}
		return $facet;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		$path = '';
		if(strstr($this->getEndpointPath(), '###instance###')) {
			$path = str_replace('###instance###', $this->getInstance(), $this->getEndpointPath()) . '&';
		} else {
			$path .= $this->getEndpointPath() . '?';
		}
		return $path;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		$this->url = $this->getEndPointHostname()
			. $this->getPath()
			. $this->getAction()
			. $this->getController()
			. $this->getDataType()
			. $this->getEid()
			. $this->generateFacetParams();
		return $this->url;
	}
}