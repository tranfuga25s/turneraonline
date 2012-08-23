<?php
/* Clinica Test cases generated on: 2012-01-11 18:32:22 : 1326317542*/
App::uses('Clinica', 'Model');

/**
 * Clinica Test Case
 *
 */
class ClinicaTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.clinica');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Clinica = ClassRegistry::init('Clinica');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Clinica);

		parent::tearDown();
	}

}
