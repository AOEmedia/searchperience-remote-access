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
		$testUrl = 'http://google.de/index.php?id=0&searchperience%5Baction%5D=search&searchperience%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search&searchperience%5Bfacetsel%5D%5Boption%5D%5Bbrand_s%5D%5B0%5D=puma&searchperience%5Bfacetsel%5D%5Boption%5D%5Bbrand_s%5D%5B1%5D=nike&searchperience%5Bfacetsel%5D%5Boption%5D%5Bcat_s%5D%5B0%5D=cloth';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setFacetOptionValue('brand_s', 'puma');
		$this->request->setFacetOptionValue('brand_s', 'nike');
		$this->request->setFacetOptionValue('cat_s', 'cloth');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testGetUrlWithRangeFacet() {
		$testUrl = 'http://google.de/index.php?id=0&searchperience%5Baction%5D=search&searchperience%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search&searchperience%5Bfacetsel%5D%5Brange%5D%5Bprice%5D%5Bmin%5D=10&searchperience%5Bfacetsel%5D%5Brange%5D%5Bprice%5D%5Bmax%5D=100';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setFacetRangeOptionValue('price', 'min', 10);
		$this->request->setFacetRangeOptionValue('price', 'max', 100);
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testGetUrlWithCustomPath() {
		$testUrl = 'http://google.de/test/test?searchperience%5Baction%5D=search&searchperience%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setEndpointPath('test/test');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testCanUseDefaultEndPointHost() {
		//$this->markTestSkipped('Instance should also be able to be a number');
		$this->request->setInstance('foo');
		$this->assertEquals($this->request->getUrl(),'http://client.searchperience.me/index.php?id=foo&searchperience%5Baction%5D=search&searchperience%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search');
	}

	/**
	 * @test
	 */
	public function testCanOverwriteNamespace() {
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1%5Baction%5D=search&tx_aoesolr_pi1%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1%5Bfacetsel%5D%5Boption%5D%5Bbrand_s%5D%5B0%5D=puma&tx_aoesolr_pi1%5Bfacetsel%5D%5Boption%5D%5Bbrand_s%5D%5B1%5D=nike&tx_aoesolr_pi1%5Bfacetsel%5D%5Boption%5D%5Bcat_s%5D%5B0%5D=cloth';
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
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1%5Baction%5D=search&tx_aoesolr_pi1%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1%5Bfacetsel%5D%5Boption%5D%5Bbrand_s%5D%5B0%5D=puma&tx_aoesolr_pi1%5Bfacetsel%5D%5Boption%5D%5Bbrand_s%5D%5B1%5D=nike';
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
		$testUrl = 'http://google.de/?searchperience%5Baction%5D=search&searchperience%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setEndpointPath('');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testBuildRequestFromParams() {
		$testUrl = 'http://test.url/?searchperience%5Baction%5D=testSearch&searchperience%5Bcontroller%5D=Search&dataType=html&eID=tx_aoesolr_search&searchperience%5Bfacetsel%5D%5Boption%5D%5Btest%5D%5B0%5D=value&searchperience%5Bfacetsel%5D%5Brange%5D%5Bprice%5D%5Bmin%5D=10&searchperience%5Bfacetsel%5D%5Brange%5D%5Bprice%5D%5Bmax%5D=1000';
		$params = array(
			'searchperience' => array(
				'action'        => 'testSearch',
				'controller'    => 'Search',
				'facetsel'      => array(
					'option'    => array(
						array(
							'test' => array('0' => 'value')
						)
					),
					'range'     => array(
						'price' => array(
							'min' => '10',
							'max' => '1000'
						)
					)
				)
			),
			'dataType'      => 'html',
			'eID'           => 'tx_aoesolr_search'
		);
		$this->request->setEndPointHostname('http://test.url/');
		$this->request->setEndpointPath('');
		$this->request->buildRequestFromParams($params);
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

	/**
	 * @test
	 */
	public function testSetQueryString() {
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1%5Baction%5D=search&tx_aoesolr_pi1%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1%5Bfacetsel%5D%5Boption%5D%5Bcat_s%5D%5B0%5D=cloth&tx_aoesolr_pi1%5Bquerystring%5D=searching';
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
		$testUrl = 'http://google.de/index.php?id=0&tx_aoesolr_pi1%5Baction%5D=search&tx_aoesolr_pi1%5Bcontroller%5D=Search&dataType=jsonp&eID=tx_aoesolr_search&tx_aoesolr_pi1%5Bfacetsel%5D%5Boption%5D%5Bpr_categoryhierarchy%5D%5B0%5D=2-Bellezza%2FAccessori%20di%20Bellezza%2FAccessori';
		$this->request->setEndPointHostname('http://google.de/');
		$this->request->setNamespace('tx_aoesolr_pi1');
		$this->request->setFacetOptionValue('pr_categoryhierarchy','2-Bellezza/Accessori di Bellezza/Accessori');
		$this->assertEquals($testUrl, $this->request->getUrl());
	}

}