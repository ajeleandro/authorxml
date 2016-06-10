<?php
App::uses('Accesssite', 'Model');

/**
 * Accesssite Test Case
 *
 */
class AccesssiteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.accesssite',
		'app.video',
		'app.category',
		'app.access_site'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Accesssite = ClassRegistry::init('Accesssite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Accesssite);

		parent::tearDown();
	}

}
