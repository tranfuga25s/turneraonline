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
	public $fixtures = array('app.turno',
	                         'app.medico',
	                         'app.consultorio',
	                         'app.clinica' );


    public $fecha_buena = "2012-10-09";
    public $fecha = "2000-10-09";

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
        $this->assertEqual( $this->Turno->cantidadDia(), 1, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDia( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDia( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCantidadAtendidos() {
        $this->assertEqual( $this->Turno->cantidadDiaAtendidos(), 1, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaAtendidos( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaAtendidos( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCantidadRecibidos() {
        $this->assertEqual( $this->Turno->cantidadDiaRecibidos(), 1, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaRecibidos( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaRecibidos( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCantidadLibres() {
        $this->assertEqual( $this->Turno->cantidadDiaLibres(), 1, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaLibres( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaLibres( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCantidadReservados() {
        $this->assertEqual( $this->Turno->cantidadDiaReservados(), 1, "Los turnos del día de hoy deben ser cero" );
        $this->assertEqual( $this->Turno->cantidadDiaReservados( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
        $this->assertEqual( $this->Turno->cantidadDiaReservados( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
        ///@TODO Agregar restricciones extras
    }

    public function testCancelacionTurnos() {

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
