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
	public function testGetUrlWithCustomPath() {
		$testUrl = 'http://google.de/test/test?searchperience[action]=search&searchperience[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setEndpointPath('test/test');
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



	/**
	 * @test
	 */
	public function testCanChain() {
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1[action]=search&tx_aoesolr_pi1[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1[facetsel][option][brand_s][0]=puma&tx_aoesolr_pi1[facetsel][option][brand_s][1]=nike';
		$this->request->setEndPointHostname('http://google.de/')
				->setFacetOptionValue('brand_s', 'puma')
				->setFacetOptionValue('brand_s', 'nike')
				->setNamespace('tx_aoesolr_pi1');
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

	/**
	 * @test
	 */
	public function testBuildRequestFromParams() {
		$testUrl = 'http://test.url/?searchperience[action]=testSearch&searchperience[controller]=Search&dataType=html&eID=tx_aoesolr_search&searchperience[facetsel][option][test][0]=value';
		$params = array(
			'searchperience' => array(
				'action'        => 'testSearch',
				'controller'    => 'Search',
				'facetsel'      => array(
					'option'    => array(
						array(
							'test' => array('0' => 'value')
						)
					)
				)
			),
			'dataType'      => 'html',
			'eID'           => 'tx_aoesolr_search'
		);
		//$testUrl = 'http://test.url/' . '?' . http_build_query($params);
		$this->request->setEndPointHostname('http://test.url/');
		$this->request->setEndpointPath('');
		$this->request->buildRequestFromParams($params);
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testSetQueryString() {
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1[action]=search&tx_aoesolr_pi1[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1[facetsel][option][cat_s][0]=cloth&tx_aoesolr_pi1[querystring]=searching';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setFacetOptionValue('cat_s', 'cloth');
		$this->request->setNamespace('tx_aoesolr_pi1');
		$this->request->setQueryString('searching');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testCanSetHierarchicalFacetValue() {
		$this->markTestIncomplete('Open');
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1[action]=search&tx_aoesolr_pi1[controller]=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1[facetsel][option][pr_categoryhierarchy][0]=2-Bellezza%2FAccessori+di+Bellezza%2FAccessori';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setNamespace('tx_aoesolr_pi1');
		$this->request->setFacetOptionValue('pr_categoryhierarchy','2-Bellezza/Accessori di Bellezza/Accessori');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

}