<?php
App::uses('Aviso', 'Model');

/**
 * Aviso Test Case
 *
 */
class AvisoTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.aviso',
		'app.variable_aviso'
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Aviso = ClassRegistry::init('Aviso');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Aviso);

		parent::tearDown();
	}

	/**
	 * testExistePendiente method
	 *
	 * @return void
	 */
	public function testExistePendiente() {
	}

	/**
	 * testBuscarSiguiente method
	 *
	 * @return void
	 */
	public function testBuscarSiguiente() {
	}

	/**
	 * testCambiarHorasTurno method
	 *
	 * @return void
	 */
	public function testCambiarHorasTurno() {
	}

	/**
	 * testCancelarAvisoNuevoTurno method
	 *
	 * @return void
	 */
	public function testCancelarAvisoNuevoTurno() {
	}

	
}
