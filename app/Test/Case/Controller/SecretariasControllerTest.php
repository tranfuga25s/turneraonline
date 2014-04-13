<?php
App::uses('SecretariasController', 'Controller');

/**
 * SecretariasController Test Case
 *
 */
class SecretariasControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.secretaria',
		'app.usuario',
		'app.obra_social',
		'app.grupo',
		'app.medico',
		'app.especialidad',
		'app.clinica',
		'app.disponibilidad',
		'app.dia_disponibilidad',
		'app.turno',
		'app.consultorio',
		'app.excepcion'
	);

    /**
     * testTurnos method
     *
     * @return void
     */
	/*public function testTurnos() {} */

    /**
     * testCancelar method
     *
     * @return void
     */
	/*public function testCancelar() {} */

    /**
     * testResumen method
     *
     * @return void
     */
	/*public function testResumen() {} */

    /**
     * testTrasladar method
     *
     * @return void
     * @expectedException NotFoundException
     */
	public function testTrasladarErroneo() {
        // Sin ID
        $this->testAction( '/secretarias/trasladar' );
	}


    /**
     * testTrasladar method
     *
     * @return void
     */
    public function testTrasladar() {
        $this->testAction( '/secretarias/trasladar/13' );
        $this->assertArrayHasKey( 'turno_original', $this->vars, "No existe el turno original" );
        $this->assertArrayHasKey( 'turnos', $this->vars, "No existe la lista de turnos" );
        foreach( $this->vars['turnos'] as $turno ) {
            $this->assertArrayHasKey( 'Turno', $turno );
            $this->assertArrayHasKey( 'id_turno', $turno['Turno'] );
            $this->assertArrayHasKey( 'Consultorio', $turno );
            $this->assertArrayHasKey( 'Medico', $turno );
        }

    }

    /**
     * testAdministracionIndex method
     *
     * @return void
     */
	/* public function testAdministracionIndex() {} */

    /**
     * testAdministracionView method
     *
     * @return void
     */
	/*public function testAdministracionView() {} */

    /**
     * testAdministracionAdd method
     *
     * @return void
     */
	/*public function testAdministracionAdd() {}*/

    /**
     * testAdministracionEdit method
     *
     * @return void
     */
	/*public function testAdministracionEdit() {} */

    /**
     * testAdministracionDelete method
     *
     * @return void
     */
	/*public function testAdministracionDelete() {} */

}
