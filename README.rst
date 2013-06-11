++++++++++++++++++++++++
Searchperience Remote Access
++++++++++++++++++++++++

:Author: AOE Searchperience Team
:Author: AOE media <dev@aoemedia.com>
:Description: PHP Library to build searchperience requests and retrieve them
:Homepage: http://www.searchperience.com
:Build status: |buildStatusIcon|

Installing via Composer
========================

The recommended way to install Searchperience API client is through [Composer](http://getcomposer.org).

1. Add ``aoemedia/searchperience-remote-access`` as a dependency in your project's ``composer.json`` file:

::

	{
		"require": {
			"aoemedia/searchperience-remote-access": "*"
		},
		"require-dev": {
			"guzzle/plugin-log": "*"
		}
	}

Consider tightening your dependencies to a known version when deploying mission critical applications (e.g. ``1.0.*``).

2. Download and install Composer:

::

	curl -s http://getcomposer.org/installer | php

3. Install your dependencies:

::

	php composer.phar install

4. Require Composer's autoloader

Composer also prepares an autoload file that's capable of autoloading all of the classes in any of the libraries that it downloads. To use it, just add the following line to your code's bootstrap process:

::

	require 'vendor/autoload.php';

You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at http://getcomposer.org.


Searchperience Remote Access usage
=========================

The remote access package provides a Request, a Response, a Client and a Factory. The factory should be used to retrieve
ensembled components from outside.

The application flow is:

1. Create a request
2. Refine the request with arguments
3. Pass the request to the client and get a response
4. Use the response in your application

Example:

::
		$request = \Searchperience\RemoteAccess\Domain\Factory::createRequest();
		$request->addFacetOption('category_s','plates');
		$request->addFacetOption('color_s','blue');

		$client  	= \Searchperience\RemoteAccess\Domain\Factory::createClient();
		$response 	= $client->fetch($request);

			//raw response contains the response from searchperience and can be used within your application
		$rawResponse 	= $response->getRawResponse();

.. |buildStatusIcon| image:: https://secure.travis-ci.org/AOEmedia/searchperience-remote-access.png?branch=master
   :alt: Build Status
   :target: http://travis-ci.org/AOEmedia/searchperience-remote-access