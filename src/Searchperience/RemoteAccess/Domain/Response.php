<?php


namespace Searchperience\RemoteAccess\Domain;

/**
 * @package Searchperience\Tests\RemoteAccess\Domain
 */
class Response {

	/**
	 * @var \Searchperience\RemoteAccess\Domain\Request
	 */
	protected $request;

	/**
	 * @var string
	 */
	protected $rawResponse;

	/**
	 * @var integer
	 */
	protected $httpStatus;

	/**
	 * @param int $httpStatus
	 */
	public function setHttpStatus($httpStatus) {
		$this->httpStatus = $httpStatus;
	}

	/**
	 * @return int
	 */
	public function getHttpStatus() {
		return $this->httpStatus;
	}

	/**
	 * @param string $rawResponse
	 */
	public function setRawResponse($rawResponse) {
		$this->rawResponse = $rawResponse;
	}

	/**
	 * @return string
	 */
	public function getRawResponse() {
		return $this->rawResponse;
	}

	/**
	 * @param \Searchperience\RemoteAccess\Domain\Request $request
	 */
	public function setRequest(\Searchperience\RemoteAccess\Domain\Request $request) {
		$this->request = $request;
	}

	/**
	 * @return \Searchperience\RemoteAccess\Domain\Request
	 */
	public function getRequest() {
		return $this->request;
	}
}