<?php
/* DiaDisponibilidad Test cases generated on: 2012-03-13 21:58:35 : 1331686715*/
App::uses('DiaDisponibilidad', 'Model');

/**
 * DiaDisponibilidad Test Case
 *
 */
class DiaDisponibilidadTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.dia_disponibilidad', 'app.disponibilidad', 'app.medico', 'app.usuario', 'app.obra_social', 'app.grupo', 'app.usuarios', 'app.especialidad', 'app.clinica', 'app.consultorios', 'app.medicos', 'app.turno', 'app.consultorio', 'app.excepcion', 'app.dias_disponibilidad');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->DiaDisponibilidad = ClassRegistry::init('DiaDisponibilidad');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DiaDisponibilidad);

		parent::tearDown();
	}

}
