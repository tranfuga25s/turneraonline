<?php
/* ObrasSociale Test cases generated on: 2012-01-11 21:59:32 : 1326329972*/
App::uses('ObrasSociale', 'Model');

/**
 * ObrasSociale Test Case
 *
 */
class ObrasSocialeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.obras_sociale');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->ObrasSociale = ClassRegistry::init('ObrasSociale');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ObrasSociale);

		parent::tearDown();
	}

}
