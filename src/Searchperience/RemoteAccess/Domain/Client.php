<?php

namespace Searchperience\RemoteAccess\Domain;

/**
 * Class Client
 */
class Client {

	/**
	 * @var
	 */
	protected $httpClient;

	/**
	 * @param \Guzzle\Http\Client $client
	 */
	public function injectHttpClient(\Guzzle\Http\Client  $client) {
		$this->httpClient = $client;
	}

	/**
	 * @param \Searchperience\RemoteAccess\Domain\Request $request
	 * @return \Searchperience\RemoteAccess\Domain\Response
	 */
	public function fetch(\Searchperience\RemoteAccess\Domain\Request $request) {
		$response 		= new \Searchperience\RemoteAccess\Domain\Response();
		$url			= $request->getUrl();

			/** @var  $httpRequest \Guzzle\Http\Message\Request */
		$httpRequest 	= $this->httpClient->get($url);

		try {
				/** @var  $httpResponse \Guzzle\Http\Message\Response */
			$httpResponse 	= $httpRequest->send();
			$rawResponse 	= $httpResponse->getBody(true);
			$response->setRawResponse($rawResponse);
		} catch(\Exception $e) {

		}

		return $response;
	}
}