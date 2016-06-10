<?php
App::uses('Degree', 'Model');

/**
 * Degree Test Case
 *
 */
class DegreeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.degree',
		'app.contributor',
		'app.affiliation',
		'app.contributor_affiliation',
		'app.contributor_degree'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Degree = ClassRegistry::init('Degree');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Degree);

		parent::tearDown();
	}

}
