<?php
/* Turno Test cases generated on: 2012-01-16 12:03:30 : 1326726210*/
App::uses('Turno', 'Model');

/**
 * Turno Test Case
 *
 */
class TurnoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.turno', 'app.paciente', 'app.medico', 'app.consultorio', 'app.clinica', 'app.consultorios');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		
		parent::setUp();

		$this->Turno = ClassRegistry::init('Turno');
		
	}

	public function testBasico() {
		$this->assertEqual( 1, 1 );
	}
	
	public function testGenerarTurnos() {
		
		$r = $this->Turno->find( 'all', 
						array( 'conditions' => 
							array( '`Turno`.`paciente_id` IS NOT NULL'
							 	 , 'fecha_fin >= NOW()' ),
							   'recursive' => -1 ) );
		
		$t = array( 0 => array( 'Turno' => array( 'id_turno' => 3, 'paciente_id' => 1, 'medico_id' => 1, 'fecha_inicio' => '2012-09-16 12:03:30', 'fecha_fin' => '2012-09-16 12:03:40', 'consultorio_id' => 1,	'recibido' => false, 'atendido' => false, 'cancelado' => false ) ) );

		$this->assertEqual( $t, $r );
		 
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset( $this->Turno );

		parent::tearDown();
	}

}
