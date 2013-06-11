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

    /**
     * Verifica la creación de turnos al generar los turnos del día
     */
	public function testGenerarTurnos() {

		$r = $this->Turno->find( 'all',
						array( 'conditions' =>
							array( '`Turno`.`paciente_id` IS NOT NULL',
							       'fecha_fin >= NOW()' ),
							   'recursive' => -1 )
        );

		$t = array( 0 => array( 'Turno' => array( 'id_turno' => 3, 'paciente_id' => 1, 'medico_id' => 1, 'fecha_inicio' => '2012-09-16 12:03:30', 'fecha_fin' => '2012-09-16 12:03:40', 'consultorio_id' => 1,	'recibido' => false, 'atendido' => false, 'cancelado' => false ) ) );

		$this->assertEqual( $t, $r );
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
