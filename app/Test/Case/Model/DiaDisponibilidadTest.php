<?php
/* DiaDisponibilidad Test cases generated on: 2012-03-13 21:58:35 : 1331686715*/
App::uses('DiaDisponibilidad', 'Model');

/**
 * DiaDisponibilidad Test Case
 *
 */
class DiaDisponibilidadTestCase extends CakeTestCase {
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
	   'app.dia_disponibilidad',
	   'app.disponibilidad');

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->DiaDisponibilidad = ClassRegistry::init('DiaDisponibilidad');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->DiaDisponibilidad);

		parent::tearDown();
	}

    public function testHorarios() {
        $datos = array(
            'DiaDisponibilidad' => array(
                'dia' => 1,
                'habilitado' => true,
                'hora_inicio' => '00:00:00',
                'hora_fin' => '00:00:00',
                'hora_inicio_tarde' => '00:00:00',
                'hora_fin_tarde' => '00:00:00'
            )
        );
        $resultado = $this->DiaDisponibilidad->save( $datos );
        $this->assertEqual( $resultado, false, "No se debe poder guardar un horario de inicio mayor al de fin" );
        $datos['DiaDisponibilidad']['hora_inicio'] = '01:00:00';
        $datos['DiaDisponibilidad']['hora_fin'] = '02:00:00';
        $this->assertEqual( $this->DiaDisponibilidad->save( $datos ), true, "horarios mañana correctos y tarde nulos - no debería de fallar" );
        $datos['DiaDisponibilidad']['hora_inicio_tarde'] = '01:30:00';
        $this->assertEqual( $this->DiaDisponibilidad->save( $datos ), false, "horarios mañana correctos y tarde incorrecto - debería de fallar" );
        $datos['DiaDisponibilidad']['hora_inicio_tarde'] = '03:00:00';
        $datos['DiaDisponibilidad']['hora_fin_tarde'] = '04:00:00';
        $this->assertEqual( $this->DiaDisponibilidad->save( $datos ), true, "horarios mañana correctos y tarde correcto - no debería de fallar" );
    }

    public function testValidacionFormatos() {
        $this->DiaDisponibilidad->id = 1;
        $this->assertEqual( $this->DiaDisponibilidad->saveField( 'hora_inicio', 'sdoidsosio' ), false, "No anduvo la regla de validacion de formato para hora_inicio" );
        $this->assertEqual( $this->DiaDisponibilidad->saveField( 'hora_fin', 'sdoidsosio' ), false, "No anduvo la regla de validacion de formato para hora_fin" );
        $this->assertEqual( $this->DiaDisponibilidad->saveField( 'hora_inicio_tarde', 'sdoidsosio' ), false, "No anduvo la regla de validacion de formato para hora_inicio_tarde" );
        $this->assertEqual( $this->DiaDisponibilidad->saveField( 'hora_fin_tarde', 'sdoidsosio' ), false, "No anduvo la regla de validacion de formato para hora_fin_tarde" );
    }

}
