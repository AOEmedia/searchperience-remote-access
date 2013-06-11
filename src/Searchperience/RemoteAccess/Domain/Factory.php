<?php

namespace Searchperience\RemoteAccess\Domain;

/**
 * Class Factory
 *
 * The factory class is responsible to create a client with all dependencies.
 *
 * @package Searchperience\RemoteAccess\Domain
 */
class Factory {
	/**
	 * @return \Searchperience\RemoteAccess\Domain\Client
	 */
	public static function createClient() {
		$searchperienceClient 		= new \Searchperience\RemoteAccess\Domain\Client();
		$httpClient 				= new \Guzzle\Http\Client();
		$searchperienceClient->injectHttpClient($httpClient);
		return $searchperienceClient;
	}

	/**
	 * @return \Searchperience\RemoteAccess\Domain\Request
	 */
	public static function createRequest() {
		return new \Searchperience\RemoteAccess\Domain\Request();
	}
}