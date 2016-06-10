<?php
App::uses('Contributor', 'Model');

/**
 * Contributor Test Case
 *
 */
class ContributorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.contributor',
		'app.affiliation',
		'app.contributor_affiliation',
		'app.degree',
		'app.contributor_degree'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contributor = ClassRegistry::init('Contributor');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contributor);

		parent::tearDown();
	}

}
