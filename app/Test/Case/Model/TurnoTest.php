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
	public $fixtures = array( 'app.clinica',
	                          'app.consultorio',
	                          'app.medico',
	                          'app.turno' );


    public $fecha_buena = array( 'DATE( fecha_inicio )' => "2012-10-09" );
    public $fecha = array( 'DATE( fecha_inicio )' => "2011-10-09" );

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

    /**
     * Verifica la creación de turnos al generar los turnos del día
     */
	public function testGenerarTurnos() {
        // Busco si existen turnos reservados de hoy en adelante
		$r = $this->Turno->find( 'count',
						array( 'conditions' =>
							array( '`Turno`.`paciente_id` IS NOT NULL',
							       '`Turno`.`fecha_fin` >=' => date( 'Y-m-d') ),
							   'recursive' => -1 )
        );
        $this->assertEqual( $r, 0, "Existen turnos reservados en los datos. No se continuará el proceso." );
	}

    /**
     * Verifica que se devuelvan los años correspondientes al maximo y minimo
     */
    public function testMax() {
        // Veo de tomar los datos correspondientes
        $max = $this->Turno->find( 'first', array( 'recursive' => -1, 'fields' => array( 'fecha_inicio' ), 'order' => array( 'fecha_inicio' => 'desc' ) ) );
        $ano_max = intval( date( 'Y', strtotime( $max['Turno']['fecha_inicio'] ) ) );
        $this->assertNotEqual( $ano_max, null, "La fecha maxima de comparacion no puede ser nula" );
        $this->assertNotEqual( $ano_max, 0, "La fecha máxima de comparación no puede ser cero" );
        $this->assertEqual( $this->Turno->anoMaximoTurno(), $ano_max, "La fecha obtenida por el modelo no coincide" );
    }

    /**
     * Verifica que se devuelvan los años correspondientes al maximo y minimo
     */
    public function testMin() {
        // Veo de tomar los datos correspondientes
        $min = $this->Turno->find( 'first', array( 'recursive' => -1, 'fields' => array( 'fecha_inicio' ), 'order' => array( 'fecha_inicio' => 'asc' ) ) );
        $ano_min = intval( date( 'Y', strtotime( $min['Turno']['fecha_inicio'] ) ) );
        $this->assertNotEqual( $ano_min, null, "La fecha minima de comparacion no puede ser nula" );
        $this->assertNotEqual( $ano_min, 0, "La fecha minima de comparación no puede ser cero" );
        $this->assertEqual( $this->Turno->anoMinimoTurno(), $ano_min, "La fecha obtenida por el modelo no coincide" );
    }


    public function testCantidadTurnos() {
        $this->assertEqual( $this->Turno->cantidadDia(), 0, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDia( $this->fecha ), 0, "Los turnos del año 2000 no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDia( $this->fecha_buena ), 12, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    /*public function testCantidadAtendidos() {
        $this->assertEqual( $this->Turno->cantidadDiaAtendidos(), 0, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaAtendidos( $this->fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaAtendidos( $this->fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCantidadRecibidos() {
        $this->assertEqual( $this->Turno->cantidadDiaRecibidos(), 0, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaRecibidos( $this->fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaRecibidos( $this->fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCantidadLibres() {
        $this->assertEqual( $this->Turno->cantidadDiaLibres(), 0, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaLibres( $this->fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaLibres( $this->fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCantidadReservados() {
        $this->assertEqual( $this->Turno->cantidadDiaReservados(), , "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaReservados( $this->fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaReservados( $this->fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }*/

    /*!
     * Pruebo que genera la condiciones necesarias para generar un nuevo traslado de turno a otro horario
     * Turnos id = 12 -> <12
     */
    public function testTrasladoTurno() {
        $turno = $this->Turno->find( 'first', array( 'conditions' => array( 'id_turno' => 12 ), 'recursive' => -1 ) );
        $this->assertArrayHasKey( 'Turno', $turno, "El turno de origen no puede ser nulo" );
        $this->assertEqual( $turno['Turno']['id_turno'], 12, "El turno de origen es incorrecto" );
        $id_paciente = $turno['Turno']['paciente_id'];

        $this->assertEqual( $this->Turno->trasladarTurno( 12, 11 ), true, "El turno no se pudo hacer como traslado" );

        $turno2 = $this->Turno->find( 'first', array( 'conditions' => array( 'id_turno' => 11 ), 'recursive' => -1 ) );
        $this->assertArrayHasKey( 'Turno', $turno2, "El turno trasladado no tiene datos!" );
        $this->assertEqual( $turno2['Turno']['paciente_id'], $id_paciente, "El paciente traslado no corresponde con el original" );

        unset( $truno );
        $turno = $this->Turno->find( 'first', array( 'conditions' => array( 'id_turno' => 12 ), 'recursive' => -1 ) );
        $this->assertArrayHasKey( 'Turno', $turno, "El turno original no se pudo releer!" );
        $this->assertEqual( $turno['Turno']['paciente_id'], null, "El turno original no tiene dato de paciente reestablecido" );

    }

    /*!
     * Funcion que prueba que el sistema falla si se intenta trasladar un turno a otro ya ocupado
     * Turnos id = 12 -> 13
     */
    public function testTrasladoTurnoOcupado() {
        $turno = $this->Turno->find( 'first', array( 'conditions' => array( 'id_turno' => 12 ), 'recursive' => -1 ) );
        $this->assertArrayHasKey( 'Turno', $turno, "El turno de origen no puede ser nulo" );
        $this->assertEqual( $turno['Turno']['id_turno'], 12, "El turno de origen es incorrecto" );

        $this->assertEqual( $this->Turno->trasladarTurno( 12, 13 ), false, "El traslado de turno a un turno ocupado no debe suceder!" );

    }

    public function testTrasladoTurnosNulos() {
        $this->assertEqual( $this->Turno->trasladarTurno( 12, null ), false, "El valor devuelto debería ser falso" );
        $this->assertEqual( $this->Turno->trasladarTurno( null, 13 ), false, "El valor devuelto debería ser falso" );
        $this->assertEqual( $this->Turno->trasladarTurno( null, null ), false, "El valor devuelto debería ser falso" );
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
