<?php
/* Medico Test cases generated on: 2012-01-17 16:28:31 : 1326828511*/
App::uses('Medico', 'Model');

/**
 * Medico Test Case
 *
 */
class MedicoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.medico', 'app.usuario', 'app.obra_social', 'app.grupo', 'app.usuarios', 'app.especialidad', 'app.clinica', 'app.consultorios', 'app.turno', 'app.consultorio');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Medico = ClassRegistry::init('Medico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Medico);

		parent::tearDown();
	}

}
