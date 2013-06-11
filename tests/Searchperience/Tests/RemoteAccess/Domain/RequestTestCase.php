<?php


namespace Searchperience\Tests\RemoteAccess\Domain;

use Searchperience\RemoteAccess\Domain;


/**
 * Class RequestTestCase
 * @package Searchperience\Tests\RemoteAccess\Domain
 */
class RequestTestCase extends \Searchperience\Tests\BaseTestCase{
    /**
     * \Searchperience\RemoteAccess\Domain\Request $request
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
        $this->request->setEndPointHostname("http://google.de/");
        $this->request->setFacetOptionValue("brand_s", "puma");
        $this->request->setFacetOptionValue("brand_s", "nike");
        $this->request->setFacetOptionValue("cat_s", "cloth");
        $url = $this->request->getUrl();
        $this->assertEquals('http://google.de/index.php?id=0&dataType=jsonp&eID=tx_aoesolr_search&searchperience[facetsel][option][brand_s][0]=puma&searchperience[facetsel][option][brand_s][1]=nike&searchperience[facetsel][option][cat_s][0]=cloth', $url);
	}
}