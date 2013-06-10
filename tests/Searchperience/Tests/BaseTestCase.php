<?php

namespace Searchperience\Tests;

/**
 * Base testcase for searchperience remote access.
 *
 * Class BaseTestCase
 * @author Timo Schmidt <timo.schmidt@aoemedia.de>
 */
class BaseTestCase extends \Morphodo\PHPUnit\TestCase {

	/**
	 * Helper method to create a completly mocked object where no constructor gets called
	 *
	 * @param $classname
	 * @return object
	 */
	protected function getMutedMock($classname) {
		return $this->getMock($classname,array(),array(),'',false);
	}
}