<?php
/* Especialidade Test cases generated on: 2012-01-11 19:32:21 : 1326321141*/
App::uses('Especialidad', 'Model');

/**
 * Especialidade Test Case
 *
 */
class EspecialidadTestCase extends CakeTestCase {
    /**
     * Fixtures
     *
     * @var array
     */
	public $fixtures = array('app.especialidad');

    /**
     * setUp method
     *
     * @return void
     */
	public function setUp() {
		parent::setUp();

		$this->Especialidad = ClassRegistry::init('Especialidad');
        $this->Medico = ClassRegistry::init('Medico');
	}

    /**
     * tearDown method
     *
     * @return void
     */
	public function tearDown() {
		unset($this->Especialidad);
        unset($this->Medico);

		parent::tearDown();
	}


    /**
     * Probar de eliminar una especialidad que está vinculada con un médico
     */
    public function testEliminaction() {

        $ids_medicos = $this->Medico->find( 'list', array( 'fields' => array( 'especialidad_id' ) ) );
        $id_especialidad = intval( array_pop( $ids_medicos ) );

        $this->assertNotEqual( $id_especialidad,       0, "No se pudo seleccionar una especialidad - cero"        );
        $this->assertNotEqual( $id_especialidad,    null, "No se pudo seleciconar una especialidad - null"        );
        $this->assertNotEqual( $id_especialidad, array(), "No se pudo seleccionar una especialidad - array vacio" );

        $this->assertNotEqual( $this->Especialidad->delete( $id_especialidad ), true, "La especialidad no debe ser eliminada!" );
    }
}
