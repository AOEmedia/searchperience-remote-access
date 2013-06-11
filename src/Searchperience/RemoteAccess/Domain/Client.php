<?php

namespace Searchperience\RemoteAccess\Domain;

/**
 * The client is responsible to get the content that will be produced from a searchperience
 * request and retrieve it.
 *
 * @package Searchperience\RemoteAccess\Domain
 * @author Pavlo Bogomolenko <pavlo.bogomolenko@aoemedia.de>
 * @author Timo Schmidt <timo.schmidt@aoemedia.de>
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
			$statusCode 	= $httpResponse->getStatusCode();
			$response->setHttpStatus($statusCode);

			if($statusCode !== 200) {
				$response->setHasError(true);
			}
		} catch(\Exception $e) {
			$response->setHasError(true);
		}

		return $response;
	}
}