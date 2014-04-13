<?php

/* Grupo Test cases generated on: 2012-01-16 11:22:45 : 1326723765 */
App::uses('Grupo', 'Model');

/**
 * Grupo Test Case
 *
 */
class GrupoTestCase extends CakeTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.grupo',
        'app.usuario'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();

        $this->Grupo = ClassRegistry::init('Grupo');
        $this->Usuario = ClassRegistry::init('Usuario');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Grupo);
        unset($this->Usuario);

        parent::tearDown();
    }

    /**
     * Testea la posibilidad de no insertar grupos repetidos
     */
    public function testDuplicado() {
        $data = array('Grupo' => array('nombre' => 'Medicos'));
        $this->assertEqual($this->Grupo->save($data), false, "No se debería de agregar grupos repetidos");
        $this->arrayHasKey('nombre', $this->Grupo->validationErrors, "No existe la regla de validacion");
    }
    
    /**
     * Testea la funcion que pemrite saber si un grupo tiene usuarios o no
     */
    public function testTieneUsuarios() {
        
        $usuario = $this->Usuario->find( 'first', array( 'fields' => array( 'grupo_id' ), 'recursive' => -1 ) );
        $this->assertArrayHasKey( 'Usuario', $usuario );
        $this->assertArrayHasKey( 'grupo_id', $usuario['Usuario'] );
        $id_grupo = $usuario['Usuario']['grupo_id'];
        $this->assertGreaterThan( 0, $id_grupo );
        $this->Grupo->id = $id_grupo;
        $this->assertEqual( $this->Grupo->tieneUsuariosAsociados( $id_grupo ), true, "No se buscó la cantidad usuarios correctamente" );
        
        $this->Grupo->id = null;
        $this->assertEqual( $this->Grupo->tieneUsuariosAsociados(), false, "Error de filtrado de datos" );
    }

}
