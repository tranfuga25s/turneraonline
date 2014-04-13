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
	public $fixtures = array( 'app.clinica',
	                          'app.consultorio',
	                          'app.secretaria',
	                          'app.medico' );

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Clinica = ClassRegistry::init('Clinica');
		$this->Medico = ClassRegistry::init('Medico');
		$this->Secretaria = ClassRegistry::init('Secretaria');
		$this->Consultorio = ClassRegistry::init('Consultorio');
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

	 /**
	  * Prueba la condición de que si se elimina una clinica con datos asociados no se debería de poder hacer
	  *
	  */
	 public function testEliminacion() {

		// Elijo una clinica para eliminar que tenga al menos un medico, una secretaria y un consultorio asociado
		$id_medicos = $this->Medico->find( 'list', array( 'fields' => array( 'clinica_id' ) ) );
		$id_secretarias = $this->Secretaria->find( 'list', array( 'fields' => array( 'clinica_id' ) ) );
		$id_consultorios = $this->Consultorio->find( 'list', array( 'fields' => array( 'clinica_id' ) ) );

		$ids = array_merge( $id_medicos, $id_secretarias, $id_consultorios );
		$temp = array_reverse( $ids );
        $temp2 = array_pop( $temp );
		$id_clinica = intval( $temp2 );

		$this->assertNotEqual( $id_clinica,       0, "No se pudo seleccionar una clinica - cero"        );
		$this->assertNotEqual( $id_clinica,    null, "No se pudo seleciconar una clinica - null"        );
		$this->assertNotEqual( $id_clinica, array(), "No se pudo seleccionar una clinica - array vacio" );

		$this->assertNotEqual( $this->Clinica->delete( $id_clinica ), true, "La clinica no debe ser eliminada!" );

	 }

     /**
      * Prueba el uso de la función Clinica::unaSola()
      */
    public function testClinicaUnica() {
        $cantidad = $this->Clinica->find( 'count' );
        $this->assertGreaterThan( 0, $cantidad, "Deben existir al menos 1 clinica para probar la funcion" );
        if( $cantidad == 1 ) {
            $this->assertEqual( $this->Clinica->unaSola(), true, "La funcion de una sola clinica debería de devolver verdadero" );
            $this->Clinica->id = 1;
            $this->Clinica->recursive = -1;
            $datos = $this->Clinica->read();
            unset( $datos[$this->Clinica->alias][$this->Clinica->primaryKey] );
            $datos[$this->Clinica->alias][$this->Clinica->displayField] .= '1';
            $this->Clinica->create();
            $this->assertNotEqual( $this->Clinica->save( $datos ), false, "Error al guardaro los nuevos datos" );
            $this->assertEqual( $this->Clinica->unaSola(), false, "La funcion de una sola clinica debería de devolver falso ya que hay más de una clinica");
        }
    }

    /**
     * Prueba el uso de la función Clinica::unica()
     *
     */
     public function testClinicaUnicaData() {
         $this->assertEqual( $this->Clinica->unaSola(), true, "Hay mas de una clinica!" );
         $ret = $this->Clinica->unica();
         $this->assertInternalType( 'array', $ret, "Formato devuelto incorrecto" );
         $this->assertArrayHasKey( 'Clinica', $ret, "No contiene la clave buscada" );
         $ret = $ret['Clinica'];
         $this->assertArrayHasKey( 'id_clinica', $ret, "No contiene la clave primaria" );
         $this->assertArrayHasKey( 'nombre', $ret );
     }
}