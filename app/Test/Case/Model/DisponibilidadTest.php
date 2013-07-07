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
							  'app.dia_disponibilidad',
							  'app.medico',
							  'app.consultorio' );

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

    /**
     * Función que verifica que el médico tenga una disponibilidad asociada
     */
    public function testVerificarData() {
        $this->Medico = ClassRegistry::init('Medico');
        $ids_medicos = $this->Medico->find( 'list', array( 'recursive' => -1, 'fields' => array( 'id_medico' ) ) );
        $this->assertNotEqual( $ids_medicos,       0, "No se pudo seleccionar ningun medico - cero"        );
        $this->assertNotEqual( $ids_medicos,    null, "No se pudo seleciconar ningun medico - null"        );
        $this->assertNotEqual( $ids_medicos, array(), "No se pudo seleccionar ningun medico - array vacio" );

        foreach( $ids_medicos as $medico ) {
            // Por cada médico verifico que tenga disponibilidad
            //$this->asserEqual( $this->Disponibilidad->existe( $medico ), true, "El médico ".$medico." no posee una disponibilidad asociada" );

            // Verifico que tenga una duración de turno
            $this->assertEqual( $this->verificarDuracionTurno( $medico ), true, "El médico ".$medico." no posee una duracion de turno asociada" );

            // Verifico que tenga un consultorio asociado
            $this->assertEqual( $this->verificarConsultorioAsociado( $medico ), true, "El médico ".$medico." no posee un consultorio asociado" );
        }
        unset( $this->Medico );
    }

    /**
     * Funcion que verifica que le medico tenga algúna duracion de turno asociada
     */
    public function verificarDuracionTurno( $id_medico = null ) {
        $this->assertNotEqual( $id_medico, null, "Parametro del test incorrecto" );

        $data = $this->Disponibilidad->find( 'first', array( 'conditions' => array( 'medico_id' => $id_medico ),
                                                             'fields' => array( 'duracion' ),
                                                             'recursive' => -1 ) );
        $this->assertNotEqual( $data, 0, "Datos cero" );
        $this->assertNotEqual( $data, null, "Datos nulos" );
        $this->assertNotEqual( $data, array(), "Datos vacios" );

        $this->assertArrayHasKey( 'Disponibilidad', $data, "El array no trae el formato correcto" );
        $this->assertArrayHasKey( 'duracion', $data['Disponibilidad'], "El array no trajo el campo duracion" );
        $this->assertNotEqual( $data['Disponibilidad']['duracion'], null, "El dato de duracion no puede ser nulo" );
        $this->assertNotEqual( $data['Disponibilidad']['duracion'], 0, "El dato de duracion no puede ser cero" );

        // Si llegé hasta aca está todo OK
        return true;
    }

    /**
     * Funcion que verifica que el medico tenga algún consultorio asociado
     */
    public function verificarConsultorioAsociado( $id_medico = null ) {

        $this->assertNotEqual( $id_medico, null, "Parametro del test incorrecto" );

        $data = $this->Disponibilidad->find( 'first', array( 'conditions' => array( 'medico_id' => $id_medico ),
                                                             'fields' => array( 'consultorio_id' ),
                                                             'recursive' => -1 ) );
        $this->assertNotEqual( $data, 0, "Datos cero" );
        $this->assertNotEqual( $data, null, "Datos nulos" );
        $this->assertNotEqual( $data, array(), "Datos vacios" );

        $this->assertArrayHasKey( 'Disponibilidad', $data, "El array no trae el formato correcto" );
        $this->assertArrayHasKey( 'consultorio_id', $data['Disponibilidad'], "El array no trajo el campo del consultorio" );
        $this->assertNotEqual( $data['Disponibilidad']['consultorio_id'], null, "El dato de consultorio no puede ser nulo" );
        $this->assertNotEqual( $data['Disponibilidad']['consultorio_id'], 0, "El dato de consultorio no puede ser cero" );

        $this->Consultorio = ClassRegistry::init('Consultorio');
        $this->Consultorio->id = $data['Disponibilidad']['consultorio_id'];
        $this->Consultorio->recursive = -1;
        $this->assertEqual( $this->Consultorio->exists(), true, "El consultorio asociado no existe" );
        unset( $this->Consultorio );

        // Si llegé hasta aca está todo OK
        return true;
    }


}
