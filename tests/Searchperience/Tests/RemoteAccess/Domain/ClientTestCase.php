<?php

namespace Searchperience\Tests\RemoteAccess\Domain;

/**
 * Class client testcase.
 *
 * @package Searchperience\Tests\RemoteAccess\Domain
 */
class ClientTestCase extends \Searchperience\Tests\BaseTestCase {

	/**
	 * @return void
	 */
	public function setUp() {
		$this->setFixtureBasePath(__DIR__);
	}

	/**
	 * @return array
	 */
	public function fetchDataProvider() {
		return array(
			array(
				'url' => 'http://www.searchperience.me/index.php?id=100',
				'content' => '<html>test</html>'
			),
			array(
				'url' => 'http://www.searchperience.me/index.php?id=100',
				'content' => 'jQuery15103808427831544715_1370878934306("\n\n\n\n<span id=\"foo\"></span>)'
			)
		);
	}

	/**
	 * @dataProvider fetchDataProvider
	 * @test
	 */
	public function fetch($fixtureUrl,$fixtureContent) {
		$searchperienceClient 		= new \Searchperience\RemoteAccess\Domain\Client();
			/** @var  $requestMock \Searchperience\RemoteAccess\Domain\Request */
		$requestMock 	= $this->getMutedMock('\Searchperience\RemoteAccess\Domain\Request');
		$requestMock->expects($this->once())->method('getUrl')->will($this->returnValue(
			$fixtureUrl
		));

		$httpRequestMock 	= $this->getMutedMock('\Guzzle\Http\Message\Request');
		$httpResponseMock 	= $this->getMutedMock('\Guzzle\Http\Message\Response');
		$httpResponseMock->expects($this->once())->method('getBody')->will(
			$this->returnValue($fixtureContent)
		);

		$httpRequestMock->expects($this->once())->method('send')->will(
			$this->returnValue($httpResponseMock)
		);

			/** @var $httpClientMock \Guzzle\Http\Client */
		$httpClientMock = $this->getMutedMock('\Guzzle\Http\Client');
		$httpClientMock->expects($this->once())->method('get')->will($this->returnValue(
			$httpRequestMock
		));

		$searchperienceClient->injectHttpClient($httpClientMock);
		$searchperienceResponse	= $searchperienceClient->fetch($requestMock);
		$this->assertEquals($fixtureContent,$searchperienceResponse->getRawResponse(),'Client could not retrieve raw response');
	}
}