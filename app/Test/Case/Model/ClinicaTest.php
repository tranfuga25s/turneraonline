<?php
/* Clinica Test cases generated on: 2012-01-11 18:32:22 : 1326317542*/
App::uses('Clinica', 'Model');

/**
 * Clinica Test Case
 *
 */
class ClinicaTestCase extends CakeTestCase {
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array('app.clinica');

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Clinica = ClassRegistry::init('Clinica');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Clinica);

		parent::tearDown();
	}
	
    /**
	 * Funcion que prueba las devoluciones de las clinicas cuando no tienen coordenadas
	 */
	 public function testCoordenadas() {
	 	$coordenadas = $this->Clinica->find( 'all', array( 'fields' => array( 'lat', 'lng' ), 'recursive' => -1 ) );
		$this->assertNotEqual( $coordenadas, array(), "Array de resultado vacio" );
					
		foreach( $coordenadas as $coordenada ) {
			$this->assertEqual( 1, count( $coordenada ), "Hay mas de un array en la devolcuion" );
			$coordenada = $coordenada['Clinica'];
			$this->assertContains( 'lat', array_keys( $coordenada ), "El array de devolucion no contiene lat" );
			$this->assertContains( 'lng', array_keys( $coordenada ), "El array de devolucion no contiene lng" );
			
			$this->assertNotEqual( 0.0, $coordenada['lat'], "La coordenada lat es cero" );
			$this->assertNotEqual( 0.0, $coordenada['lng'], "La coordenada lng es cero" );
			
			$this->assertNotEqual( null, $coordenada['lat'], "La coordenada lat es nula" );
			$this->assertNotEqual( null, $coordenada['lng'], "La coordenada lng es nula" );	
		}
		
	 }

}
