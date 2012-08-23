<?php
/* Disponibilidad Test cases generated on: 2012-01-18 19:16:00 : 1326924960*/
App::uses('Disponibilidad', 'Model');

/**
 * Disponibilidad Test Case
 *
 */
class DisponibilidadTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.disponibilidad', 'app.medico', 'app.usuario', 'app.obra_social', 'app.grupo', 'app.usuarios', 'app.especialidad', 'app.clinica', 'app.consultorios', 'app.turno', 'app.consultorio');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Disponibilidad = ClassRegistry::init('Disponibilidad');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Disponibilidad);

		parent::tearDown();
	}

}
