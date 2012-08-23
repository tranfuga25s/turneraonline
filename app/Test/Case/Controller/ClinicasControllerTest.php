<?php
/* Clinicas Test cases generated on: 2012-01-11 19:08:59 : 1326319739*/
App::uses('ClinicasController', 'Controller');

/**
 * TestClinicasController *
 */
class TestClinicasController extends ClinicasController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * ClinicasController Test Case
 *
 */
class ClinicasControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.clinica', 'app.consultorios');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Clinicas = new TestClinicasController();
		$this->Clinicas->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Clinicas);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {

	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}

/**
 * testAdministracionIndex method
 *
 * @return void
 */
	public function testAdministracionIndex() {

	}

/**
 * testAdministracionView method
 *
 * @return void
 */
	public function testAdministracionView() {

	}

/**
 * testAdministracionAdd method
 *
 * @return void
 */
	public function testAdministracionAdd() {

	}

/**
 * testAdministracionEdit method
 *
 * @return void
 */
	public function testAdministracionEdit() {

	}

/**
 * testAdministracionDelete method
 *
 * @return void
 */
	public function testAdministracionDelete() {

	}

}
