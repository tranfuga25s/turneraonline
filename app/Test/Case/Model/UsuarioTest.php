<?php
/* Usuario Test cases generated on: 2012-01-12 11:36:19 : 1326378979*/
App::uses( 'Usuario', 'Model' );
App::uses( 'AuthComponent', 'Controller/Component' );

/**
 * Usuario Test Case
 */
class UsuarioTestCase extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array('app.usuario',     'app.medico',
							 'app.secretaria',  'app.especialidad',
							 'app.clinica',     'app.obra_social',
							 'app.grupo',       'app.turno',
							 'app.consultorio', 'app.disponibilidad',
                             'app.excepcion' );

    public $components = array( 'Auth' );

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Usuario = ClassRegistry::init('Usuario');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Usuario);
		parent::tearDown();
	}

	/**
	 * Prueba la condición de que si se elimina un usuario con datos asociados a un médico no se debería de poder hacer
	 *
	 */
	 public function testEliminacionUsuarioMedico() {
	 	$this->Medico = ClassRegistry::init('Medico');
	 	$id_usuario = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ) ) );
		$id_usuario = $id_usuario['Medico']['usuario_id'];

		$this->assertNotEqual( $id_usuario,       0, "No se pudo seleccionar una secretaria - cero"        );
		$this->assertNotEqual( $id_usuario,    null, "No se pudo seleciconar una secretaria - null"        );
		$this->assertNotEqual( $id_usuario, array(), "No se pudo seleccionar una secretaria - array vacio" );

		$this->assertNotEqual( $this->Usuario->delete( $id_usuario ), true, "Un usuario linkeado con un medico no debe ser eliminado!" );
		unset($this->Medico);
	 }

	/**
	 * Prueba la condición de que si se elimina un usuario con datos asociados a una secretaria no se debería de poder hacer
	 *
	 */
	 public function testEliminacionUsuarioSecretaria() {

	 	$this->Secretaria = ClassRegistry::init('Secretaria');
	 	$id_usuario = $this->Secretaria->find( 'first', array( 'fields' => array( 'usuario_id' ) ) );
		$id_usuario = $id_usuario['Secretaria']['usuario_id'];

		$this->assertNotEqual( $id_usuario,       0, "No se pudo seleccionar una secretaria - cero"        );
		$this->assertNotEqual( $id_usuario,    null, "No se pudo seleciconar una secretaria - null"        );
		$this->assertNotEqual( $id_usuario, array(), "No se pudo seleccionar una secretaria - array vacio" );

		$this->assertNotEqual( $this->Usuario->delete( $id_usuario ), true, "Un usuario linkeado con una secretaria no debe ser eliminado!" );
		unset($this->Secretaria);
	 }

	/**
	 * Prueba la condición de que si se elimina un usuario con datos asociados a turnos no se debería de poder hacer
	 *
	 */
	 public function testEliminacionUsuarioTurno() {
	 	$this->Turno = ClassRegistry::init('Turno');
	 	$id_usuario = $this->Turno->find( 'first', array( 'fields' => array( 'paciente_id' ), 'conditions' => array( 'paciente_id IS NOT NULL' ) ) );
		$id_usuario = $id_usuario['Turno']['paciente_id'];
		$this->assertNotEqual( $id_usuario,       0, "No se pudo seleccionar un paciente - cero"        );
		$this->assertNotEqual( $id_usuario,    null, "No se pudo seleciconar un paciente - null"        );
		$this->assertNotEqual( $id_usuario, array(), "No se pudo seleccionar un paciente - array vacio" );

		$this->assertNotEqual( $this->Usuario->delete( $id_usuario ), true, "Un usuario linkeado con un turno no debe ser eliminado!" );
		unset($this->Turno);
	 }

     /**
      * Prueba el cambio de grupo del usuario cuando es una secretaria
      */
     public function testCambioUsuarioSecretaria() {
        $this->Secretaria = ClassRegistry::init( 'Secretaria' );
        $temp = $this->Secretaria->find( 'first', array( 'fields' => array( 'usuario_id' ), 'recursive' => -1 ) );
        $id_usuario = $temp['Secretaria']['usuario_id'];
        unset($temp);
        $this->Usuario->recursive = -1;
        $data = $this->Usuario->read( null, $id_usuario );
        $data['Usuario']['grupo_id'] = 4;
        $this->assertEqual( $this->Usuario->save( $data ), false, "El usuario no se debería de poder modificar si está asociado con una secretaria" );
        unset($this->Secretaria);
     }

     /**
      * Prueba el cambio de grupo del usuario cuando es un medico
      */
     public function testCambioUsuarioMedico() {
        $this->Medico = ClassRegistry::init( 'Medico' );
        $temp = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ), 'recursive' => -1 ) );
        $id_usuario = $temp['Medico']['usuario_id'];
        unset($temp);
        $this->Usuario->recursive = -1;
        $data = $this->Usuario->read( null, $id_usuario );
        $data['Usuario']['grupo_id'] = 4;
        $this->assertEqual( $this->Usuario->save( $data ), false, "El usuario no se debería de poder modificar si está asociado con un médico" );
        unset($this->Medico);
     }


    /**
     * Verifico que funcione correctamente el verificador de correo electrónico
     */
     public function testVerificarSiExiste() {
         $this->assertEqual( true, false, "Método no implementado todavía" );
     }

     /**
      * Verificación del generador de contraseñas
      */
     public function testGenerarNuevaContraseña() {
         $this->assertEqual( true, false, "Método no implementado todavía" );
     }

}
