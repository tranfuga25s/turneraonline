<?php
/* Disponibilidad Test cases generated on: 2012-01-18 19:16:00 : 1326924960*/
App::uses( 'Disponibilidad', 'Model' );

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
	public $fixtures = array( 'app.disponibilidad', 
							  'app.dia_disponibilidad' );

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Disponibilidad = ClassRegistry::init('Disponibilidad');
		$this->DiaDisponibilidad = ClassRegistry::init('DiaDisponibilidad');
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

	/**
	 * Función que verifica la eliminacion
	 */
	public function testEliminacion() {
		
		$id_disponibilidad = $this->DiaDisponibilidad->find( 'list', array( 'fields' => array( 'disponibilidad_id' ), 'limit' => 1 ) );
				
		$this->assertNotEqual( $id_disponibilidad,       0, "No se pudo seleccionar una disponibilidad - cero"        );
		$this->assertNotEqual( $id_disponibilidad,    null, "No se pudo seleciconar una disponibilidad - null"        );
		$this->assertNotEqual( $id_disponibilidad, array(), "No se pudo seleccionar una disponibilidad - array vacio" );	
		
		$this->assertNotEqual( $this->Disponibilidad->delete( $id_disponibilidad ), true, "La disponibilidad no puede ser eliminada!" );
		
	}
}
