<?php


namespace Searchperience\Tests\RemoteAccess\Domain;

use Searchperience\RemoteAccess\Domain;

/**
 * Class RequestTestCase
 * @package Searchperience\Tests\RemoteAccess\Domain
 */
class RequestTestCase extends \Searchperience\Tests\BaseTestCase {

    /**
     * @var \Searchperience\RemoteAccess\Domain\Request
     */
    protected $request;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->setFixtureBasePath(__DIR__);
		$this->request = new Domain\Request();
	}

	/**
	 * @test
	 */
	public function testGetUrl() {
		$testUrl = 'http://google.de/index.php?id=0&searchperience[action]=search&searchperience[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search&searchperience[facetsel][option][brand_s][0]=puma&searchperience[facetsel][option][brand_s][1]=nike&searchperience[facetsel][option][cat_s][0]=cloth';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setFacetOptionValue('brand_s', 'puma');
		$this->request->setFacetOptionValue('brand_s', 'nike');
		$this->request->setFacetOptionValue('cat_s', 'cloth');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testGetUrlWithCustomPath() {
		$testUrl = 'http://google.de/test/test?searchperience[action]=search&searchperience[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setEndpointPath('test/test');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testGetUrlWithEmptyPath() {
		$testUrl = 'http://google.de/?searchperience[action]=search&searchperience[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setEndpointPath('');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}
}