<?php
/* Consultorio Test cases generated on: 2012-01-11 18:59:14 : 1326319154*/
App::uses('Consultorio', 'Model');

/**
 * Consultorio Test Case
 *
 */
class ConsultorioTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.consultorio', 'app.clinica');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Consultorio = ClassRegistry::init('Consultorio');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Consultorio);

		parent::tearDown();
	}

}
