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
	public $fixtures = array( 'app.consultorio', 'app.clinica', 'app.turno', 'app.usuario', 'app.medico' );

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Consultorio = ClassRegistry::init('Consultorio');
		$this->Turno = ClassRegistry::init('Turno');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Consultorio);
		unset($this->Turno);

		parent::tearDown();
	}
	
	/**
	 * Testeo de eliminacion
	 */
	public function testEliminacion() {
		
		$ids_turnos = $this->Turno->find( 'list', array( 'fields' => array( 'consultorio_id' ) ) );
		$id_consultorio = array_pop( $ids_turnos );
		
		$this->assertNotEqual( $id_consultorio,       0, "No se pudo seleccionar un consultorio - cero"        );
		$this->assertNotEqual( $id_consultorio,    null, "No se pudo seleciconar un consultorio - null"        );
		$this->assertNotEqual( $id_consultorio, array(), "No se pudo seleccionar un consultorio - array vacio" );	
		
		$this->assertNotEqual( $this->Consultorio->delete( $id_consultorio ), true, "El consultorio no debe ser eliminado!" );
		
	}

}
