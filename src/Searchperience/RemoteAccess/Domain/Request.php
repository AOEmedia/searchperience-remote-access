<?php


namespace Searchperience\RemoteAccess\Domain;
use Searchperience\RemoteAccess\Domain\Exeption\FacetExeption;
use Searchperience\RemoteAccess\Domain\Exeption\UrlExeption;

/**
 * The searchperience request is responsible to generate an url that can be used to
 * retrieve valid results from a searchperience remote system.
 *
 * @package Searchperience\Tests\RemoteAccess\Domain
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
	 * @var array
	 */
	private $facetRangeOptionValue = array();

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
	private $queryString = null;

	/**
	 * @var string
	 */
	private $controller = 'Search';

	const FACET_MARKER = '[facetsel][option]';

	const RANGE_FACET_MARKER = '[facetsel][range]';

	/**
	 * @var array key/count
	 */
	private $addedFacests = array();

	/**
	 * @param string $action
	 * @return Request
	 */
	public function setAction($action) {
		$this->action = $action;
		return $this;
	}

	/**
	 * @param string $controller
	 * @return Request
	 */
	public function setController($controller) {
		$this->controller = $controller;
		return $this;
	}

	/**
	 * @param string $eid
	 * @return Request
	 */
	public function setEid($eid) {
		$this->eid = $eid;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEidUrlPart() {
		return '&eID=' . $this->eid;
	}

	/**
	 * @param string $dataType
	 * @return Request
	 */
	public function setDataType($dataType) {
		$this->dataType = $dataType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDataTypeUrlPart() {
		return $this->buildEncodedUrlParamPart('&', '', 'dataType', $this->dataType);
	}

	/**
	 * @param string $endPointHostname
	 * @return Request
	 *
	 */
	public function setEndPointHostname($endPointHostname) {
		if(!filter_var($endPointHostname, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
			throw new UrlExeption("wrong hostname format");
		}

		$this->endPointHostname = $endPointHostname;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEndPointHostname() {
		return $this->endPointHostname;
	}

	/**
	 * @param string $endpointPath
	 * @return Request
	 */
	public function setEndpointPath($endpointPath) {
		$this->endpointPath = $endpointPath;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEndpointPath() {
		return $this->endpointPath;
	}

	/**
	 * @param $option
	 * @param $value
	 * @return Request
	 */
	public function setFacetOptionValue($option, $value) {
		if (preg_match('/[^A-Za-z0-9_\-]/', $option)) {
			throw new FacetExeption("illegal charecter detected in facet option");
		}

		/*
		if (preg_match('/[^A-Za-z0-9\-]/', $value)) {
			throw new FacetExeption("illegal charecter detected in facet value");
		}
		*/

		$this->facetOptionValue[] = array($option, $value);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getFacetOptionValue() {
		return $this->facetOptionValue;
	}

	/**
	 * @param int $instance
	 * @return Request
	 */
	public function setInstance($instance) {
		$this->instance = $instance;
		return $this;
	}

	/**
	 * @return int
	 * @return Request
	 */
	public function getInstance() {
		return $this->instance;
	}

	/**
	 * @param string $namespace
	 * @return Request
	 */
	public function setNamespace($namespace) {
		$this->namespace = $namespace;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNamespace() {
		return $this->namespace;
	}

	/**
	 * @return string
	 */
	private function getActionUrlPart() {
		return $this->buildEncodedUrlParamPart('', $this->getNamespace(), '[action]', $this->action);
	}

	/**
	 * @return string
	 */
	private function getControllerUrlPart() {
		return $this->buildEncodedUrlParamPart('&', $this->getNamespace(), '[controller]', $this->controller);
	}

	/**
	 * @param $queryString
	 * @return Request
	 */
	public function setQueryString($queryString) {
		$this->queryString = $queryString;
		return $this;
	}

	/**
	 * @return string
	 */
	private function getQueryStringUrlPart() {
		if(!is_string($this->queryString)) {
			return  '';
		}

		return $this->buildEncodedUrlParamPart('&', $this->getNamespace(), '[querystring]', $this->queryString);
	}

	/**
	 * @param array $facetRangeOptionValue
	 */
	public function setFacetRangeOptionValue($option, $key, $value)
	{
		if (preg_match('/[^A-Za-z0-9_\-]/', $option)) {
			throw new FacetExeption("illegal charecter detected in facet range option");
		}

		if (preg_match('/[^A-Za-z0-9_\-]/', $key)) {
			throw new FacetExeption("illegal charecter detected in facet range key");
		}

		/*
		if (preg_match('/[^A-Za-z0-9\-]/', $value)) {
			throw new FacetExeption("illegal charecter detected in facet range value");
		}
		*/

		$this->facetRangeOptionValue[$option][] = array($key, $value);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getFacetRangeOptionValue()
	{
		return $this->facetRangeOptionValue;
	}

	/**
	 * @return string
	 */
	public function generateFacetUrlParts() {
		$facet = '';
		$tmpFacetCount = 0;
		$this->addedFacests = array();

		foreach($this->getFacetOptionValue() as $facets) {
			if(array_key_exists($facets[0], $this->addedFacests)) {
				$this->addedFacests[$facets[0]] = $this->addedFacests[$facets[0]] + 1;
				$tmpFacetCount = $this->addedFacests[$facets[0]];
			} else {
				$this->addedFacests[$facets[0]] = 0;
			}
			$facet .= $this->buildEncodedUrlParamPart('&', $this->getNamespace(), self::FACET_MARKER . '[' . $facets[0] .  ']' .
				'[' . $tmpFacetCount  . ']', $facets[1]);
			$tmpFacetCount = 0;
		}
		return $facet;
	}

	/**
	 * @return string
	 */
	public function generateFacetRangeUrlParts() {
		$facetStr = '';
		foreach($this->getFacetRangeOptionValue() as $facetsKey => $facetRange) {
			foreach($facetRange as $facet) {
				$facetStr .= $this->buildEncodedUrlParamPart('&', $this->getNamespace(), self::RANGE_FACET_MARKER . '[' . $facetsKey .  ']' .
					'[' . $facet[0]  . ']', $facet[1]);
			}
		}
		return $facetStr;
	}

	/**
	 * @return string
	 */
	public function getPathUrlPart() {
		$path = '';
		if(strstr($this->getEndpointPath(), '###instance###')) {
			$path = str_replace('###instance###', $this->getInstance(), $this->getEndpointPath()) . '&';
		} else {
			$path .= $this->getEndpointPath() . '?';
		}
		return $path;
	}

	/**
	 * @param array $params
	 */
	public function buildRequestFromParams($params = array()) {
		foreach ($params as $key => $value) {
			switch($key) {
				case 'dataType':
					$this->setDataType($value);
					break;
				case 'eID':
					$this->setEid($value);
					break;
				case 'action':
					$this->setAction($value);
					break;
				case 'controller':
					$this->setController($value);
					break;
				case 'option':
					foreach($value as $facetMap) {
						foreach($facetMap as $facetKey => $facetValue) {
							$this->setFacetOptionValue($facetKey, $facetValue[0]);
						}
					}
					break;
				case 'range':
					foreach($value as $facetOption => $facetMap) {
						foreach($facetMap as $facetKey => $facetValue) {
							$this->setFacetRangeOptionValue($facetOption, $facetKey, $facetValue);
						}
					}
					break;
				default:
					$this->buildRequestFromParams($value);
			}
		}
	}

	/**
	 * @param $glue
	 * @param $namespace
	 * @param $key
	 * @param $value
	 * @return string
	 */
	private function buildEncodedUrlParamPart($glue, $namespace, $key, $value) {
		$url = $glue . rawurlencode($namespace . $key) . '='  . rawurlencode($value);
		return $url;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		$this->url = $this->getEndPointHostname()
			. $this->getPathUrlPart()
			. $this->getActionUrlPart()
			. $this->getControllerUrlPart()
			. $this->getDataTypeUrlPart()
			. $this->getEidUrlPart()
			. $this->generateFacetUrlParts()
			. $this->generateFacetRangeUrlParts()
			. $this->getQueryStringUrlPart();
		return $this->url;
	}
}