<?php

/* Medico Test cases generated on: 2012-01-17 16:28:31 : 1326828511 */
App::uses('Medico', 'Model');

/**
 * Medico Test Case
 *
 */
class MedicoTestCase extends CakeTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'app.medico',
        'app.usuario',
        'app.obra_social',
        'app.grupo',
        'app.especialidad',
        'app.clinica',
        'app.turno',
        'app.consultorio',
        'app.disponibilidad',
        'app.dia_disponibilidad',
        'app.secretaria'
    );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->Medico = ClassRegistry::init('Medico');
        $this->DiaDisponibilidad = ClassRegistry::init('DiaDisponibilidad');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Medico);
        unset($this->DiaDisponibilidad);
        parent::tearDown();
    }

    /**
     * Verifica las condiciones del bug #152
     * Verifique que cuando se elimina un medico, se elimina:
     * - el usuario asociado
     * - los turnos asociados a ese medico
     * - la disponibilidad
     * - los dias de disponibilidad asociadas.
     */
    public function testEliminarMedico() {
        // Obtengo los datos de un médico a eliminar
        $d = $this->Medico->Disponibilidad->find( 'first', array( 'fields' => array( 'medico_id' ), 'recursive' => -1 ) );
        $id_medico = intval( $d['Disponibilidad']['medico_id'] );
        unset( $d );

        $datos = $this->Medico->find( 'first', array( 'recursive' => 3, 'conditions' => array( 'id_medico' => $id_medico ) ) );
        $this->assertArrayHasKey( 'Medico', $datos );
        $this->assertArrayHasKey( 'id_medico', $datos['Medico'] );
        $id_medico = intval( $datos['Medico']['id_medico'] );
        $this->assertArrayHasKey( 'Usuario', $datos );
        $this->assertArrayHasKey( 'id_usuario', $datos['Usuario'] );
        $id_usuario = intval( $datos['Usuario']['id_usuario'] );
        $this->assertArrayHasKey( 'Especialidad', $datos );
        $this->assertArrayHasKey( 'id_especialidad', $datos['Especialidad'] );
        $id_especialidad = intval( $datos['Especialidad']['id_especialidad'] );
        $this->assertArrayHasKey( 'Clinica', $datos );
        $this->assertArrayHasKey( 'id_clinica', $datos['Clinica'] );
        $id_clinica = intval( $datos['Clinica']['id_clinica'] );
        $this->assertArrayHasKey( 'Disponibilidad', $datos );
        $this->assertArrayHasKey( 'id_disponibilidad', $datos['Disponibilidad'] );
        $id_disponibilidad = intval( $datos['Disponibilidad']['id_disponibilidad'] );
        $ids_dia_disponibilidad = $this->DiaDisponibilidad->find( 'all', array( 'conditions' => array( 'disponibilidad_id' => $id_disponibilidad ),
                                                                               'fields' => array( 'id' ),
                                                                               'recursive' => -1 ) );
        $ids_dia_disponibilidad = Set::classicExtract( $ids_dia_disponibilidad, '{n}.DiaDisponibilidad.id' );
        $this->assertNotEqual( count( $ids_dia_disponibilidad ), 0 );

        $this->assertArrayHasKey( 'Turno', $datos );
        $ids_turnos = Set::classicExtract( $datos['Turno'], "{n}.id_turno" );
        $this->assertNotEqual( count( $ids_turnos ), 0 );

        // Elimino el médico
        $this->assertEqual( $this->Medico->eliminar( $id_medico ), true, "No se pudo eliminar el medico" );

        $this->Medico->id = $id_medico;
        $this->assertEqual( $this->Medico->exists(), false, "El medico debería de dejar de existir" );

        $this->Medico->Usuario->id = $id_usuario;
        $this->assertEqual( $this->Medico->Usuario->exists(), true, "El usuario debería seguir existiendo" );

        $this->Medico->Clinica->id = $id_clinica;
        $this->assertEqual( $this->Medico->Clinica->exists(), true, "La clinica no debería de desaparecer" );

        $this->Medico->Especialidad->id = $id_especialidad;
        $this->assertEqual( $this->Medico->Especialidad->exists(), true, "La especialidad no debería de desaparecer" );

        $this->Medico->Disponibilidad->id = $id_disponibilidad;
        $this->assertEqual( $this->Medico->Disponibilidad->exists(), false, "La disponibilidad de médico no debería de existir" );

        foreach( $ids_turnos as $id ) {
            $this->Medico->Turno->id = $id;
            $this->assertEqual( $this->Medico->Turno->exists(), false, "Un turno no fue eliminado" );
        }

        foreach( $ids_dia_disponibilidad as $id ) {
            $this->DiaDisponibilidad->id = $id;
            $this->assertEqual( $this->DiaDisponibilidad->exists(), false, "Un dia de especialidad no debería de existir: ".$id  );
        }
    }

    /**
     * Lista simple
     */
    public function testListaSelect() {
       $lista = $this->Medico->lista();
       $this->assertInternalType( 'array', $lista );
       $this->assertNotEqual( count( $lista ), 0 );
    }

    /**
     * Lista simple cuando se pasa un ID
     */
    public function testListaSelectIDFiltro() {

       // Si paso solo un ID debe devolverlo
       $data = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ),
                                                    'recursive' => -1 ) );
       $id_usuario = intval( $data[$this->Medico->alias]['usuario_id'] );
       $this->assertNotEqual( $id_usuario, 0 );

       $lista2 = $this->Medico->lista( $id_usuario );
       $this->assertInternalType( 'array', $lista2 );
       $this->assertNotEqual( count( $lista2 ), 0 );
       $this->assertArrayHasKey( $id_usuario, $lista2 );

    }

    /**
     * Lista de medicos solo visibles
     */
    public function testListaSelectVisibles() {
       // Si paso solo los visibles
       $data2 = $this->Medico->find( 'all', array( 'fields' => array( 'usuario_id' ),
                                                  'recursive' => -1,
                                                  'conditions' => array('visible' => 1 )
       ) );
       $ids_usuarios = Set::classicExtract( $data2, "{n}.Medico.usuario_id" );
       $this->assertNotEqual( count( $ids_usuarios ), 0 );

       $lista3 = $this->Medico->lista( null, true );
       $this->assertInternalType( 'array', $lista3 );
       $this->assertNotEqual( count( $lista3 ), 0 );
       foreach( $ids_usuarios as $id_usuario ) {
           $this->assertArrayHasKey( $id_usuario, $lista3 );
       }
    }

    /**
     * Lista de medicos visibles con ID
     * @TODO Arreglar este test!
     */
     public function testListaSelectVisiblesConID() {
       // Si paso solo un ID debe devolverlo si está visible
       $data = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ),
                                                    'recursive' => -1,
                                                    'conditions' => array( 'visible' => true ) ) );
       $id_usuario = intval( $data[$this->Medico->alias]['usuario_id'] );
       $this->assertNotEqual( $id_usuario, 0 );

       $lista2 = $this->Medico->lista( $id_usuario, true );
       $this->assertInternalType( 'array', $lista2 );
       $this->assertNotEqual( count( $lista2 ), 0 );
       $this->assertArrayHasKey( $id_usuario, $lista2 );
     }
     
     
     /* public function testListaSelectInvisibleConID() {
       // Pruebo con ID no visible
       /*$data2 = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ),
                                                    'recursive' => -1,
                                                    'conditions' => array( 'visible' => false ) ) );
       $id_usuario2 = intval( $data2[$this->Medico->alias]['usuario_id'] );
       $this->assertNotEqual( $id_usuario2, 0 );

       $lista = $this->Medico->lista( $id_usuario, true );
       $this->assertInternalType( 'array', $lista );
       $this->assertEqual( count( $lista ), 0 );
    } */

}
