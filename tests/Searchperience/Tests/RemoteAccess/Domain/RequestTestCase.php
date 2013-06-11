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
	public function testGetUrlWithSimpleFacet() {
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
	public function testCanUseDefaultEndPointHost() {
		$this->markTestSkipped('Instance should also be able to be a number');
		$this->request->setInstance('foo');
		$this->assertEquals($this->request->getUrl(),'http://client.searchperience.me/index.php?id=foo&searchperience[action]=search&searchperience[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search');
	}

	/**
	 * @test
	 */
	public function testCanOverwriteNamespace() {
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1[action]=search&tx_aoesolr_pi1[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1[facetsel][option][brand_s][0]=puma&tx_aoesolr_pi1[facetsel][option][brand_s][1]=nike&tx_aoesolr_pi1[facetsel][option][cat_s][0]=cloth';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setFacetOptionValue('brand_s', 'puma');
		$this->request->setFacetOptionValue('brand_s', 'nike');
		$this->request->setFacetOptionValue('cat_s', 'cloth');
		$this->request->setNamespace('tx_aoesolr_pi1');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}
}