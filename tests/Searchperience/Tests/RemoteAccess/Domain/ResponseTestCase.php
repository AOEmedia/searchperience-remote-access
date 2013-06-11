<?php


namespace Searchperience\Tests\RemoteAccess\Domain;

use Searchperience\RemoteAccess\Domain;

/**
 * Class RequestTestCase
 * @package Searchperience\Tests\RemoteAccess\Domain
 */
class ResponseTestCase extends \Searchperience\Tests\BaseTestCase {

	/**
	 * @var \Searchperience\RemoteAccess\Domain\Response
	 */
	protected $response;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->setFixtureBasePath(__DIR__);
		$this->response = new Domain\Response();
	}

	/**
	 * @test
	 */
	public function setRawResponse() {
		$this->response->setRawResponse('foo');
		$this->assertEquals($this->response->getRawResponse(),'foo');
	}

}