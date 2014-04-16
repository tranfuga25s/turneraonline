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
        'app.dia_disponibilidad'
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
        $datos = $this->Medico->find( 'first', array( 'recurisve' => 3 ) );
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
        $this->assertArrayHasKey( 'Turno', $datos );
        $ids_turnos = Set::classicExtract( $datos['Turno'], "{n}.id_turno" );
        
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

}
