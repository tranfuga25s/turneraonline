<?php
/* Excepcione Test cases generated on: 2012-02-01 23:26:39 : 1328149599*/
App::uses('Excepcione', 'Model');

/**
 * Excepcione Test Case
 *
 */
class ExcepcioneTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.excepcione', 'app.medico', 'app.usuario', 'app.obra_social', 'app.grupo', 'app.usuarios', 'app.especialidad', 'app.clinica', 'app.consultorios', 'app.disponibilidad', 'app.turno', 'app.consultorio');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Excepcione = ClassRegistry::init('Excepcione');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Excepcione);

		parent::tearDown();
	}

}
