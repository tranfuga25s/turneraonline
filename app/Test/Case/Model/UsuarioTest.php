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
        Configure::write( 'Turnera.grupos.0', 2 );
        Configure::write( 'Turnera.grupos.1', 3 );
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
	 */
	 public function testEliminacionUsuarioMedico() {
	 	$this->Medico = ClassRegistry::init('Medico');
	 	$id_usuario = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ) ) );
        $this->assertGreaterThan( 0, count( $id_usuario ), "No existen medicos para correr el test!" );
		$id_usuario = $id_usuario['Medico']['usuario_id'];

		$this->assertNotEqual( $id_usuario,       0, "No se pudo seleccionar una secretaria - cero"        );
		$this->assertNotEqual( $id_usuario,    null, "No se pudo seleciconar una secretaria - null"        );
		$this->assertNotEqual( $id_usuario, array(), "No se pudo seleccionar una secretaria - array vacio" );

		$this->assertNotEqual( $this->Usuario->delete( $id_usuario ), true, "Un usuario linkeado con un medico no debe ser eliminado!" );
		unset($this->Medico);
	 }

	/**
	 * Prueba la condición de que si se elimina un usuario con datos asociados a una secretaria no se debería de poder hacer
	 */
	 public function testEliminacionUsuarioSecretaria() {

	 	$this->Secretaria = ClassRegistry::init('Secretaria');
	 	$id_usuario = $this->Secretaria->find( 'first', array( 'fields' => array( 'usuario_id' ) ) );
        $this->assertGreaterThan( 0, count( $id_usuario ), "No existen secretarias para correr el test!" );
		$id_usuario = $id_usuario['Secretaria']['usuario_id'];

		$this->assertNotEqual( $id_usuario,       0, "No se pudo seleccionar una secretaria - cero"        );
		$this->assertNotEqual( $id_usuario,    null, "No se pudo seleciconar una secretaria - null"        );
		$this->assertNotEqual( $id_usuario, array(), "No se pudo seleccionar una secretaria - array vacio" );

		$this->assertNotEqual( $this->Usuario->delete( $id_usuario ), true, "Un usuario linkeado con una secretaria no debe ser eliminado!" );
		unset($this->Secretaria);
	 }

	/**
	 * Prueba la condición de que si se elimina un usuario con datos asociados a turnos no se debería de poder hacer
	 */
	 public function testEliminacionUsuarioTurno() {
	 	$this->Turno = ClassRegistry::init('Turno');
	 	$id_usuario = $this->Turno->find( 'first', array( 'fields' => array( 'paciente_id' ), 'conditions' => array( 'paciente_id IS NOT NULL' ) ) );
        $this->assertGreaterThan( 0, count( $id_usuario ), "No existen datos de turnos para hacer la prueba - verifique el fixture" );
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
        $this->assertGreaterThan( 0, count( $temp ), "No existen secretarias para correr el test!" );
        $id_usuario = $temp['Secretaria']['usuario_id'];
        unset($temp);
        $this->Usuario->recursive = -1;
        $data = $this->Usuario->read( null, $id_usuario );
        $data['Usuario']['id_usuario'] = $id_usuario;
        $data['Usuario']['grupo_id'] = 3;
        $return_value = $this->Usuario->save( $data );
        $this->assertEqual( $return_value, false, "El grupo del usuario no se debería de poder modificar si está asociado con una secretaria" );
        unset($this->Secretaria);
     }

     /**
      * Prueba el cambio de grupo del usuario cuando es un medico
      */
     public function testCambioUsuarioMedico() {
        $this->Medico = ClassRegistry::init( 'Medico' );
        $temp = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ), 'recursive' => -1 ) );
        $this->assertGreaterThan( 0, count( $temp ), "No existen medicos para correr el test!" );
        $id_usuario = $temp['Medico']['usuario_id'];
        unset($temp);
        $this->Usuario->recursive = -1;
        $data = $this->Usuario->read( null, $id_usuario );
        $data['Usuario']['grupo_id'] = 4;
        $return_value = $this->Usuario->save( $data );
        $this->assertEqual( $return_value, false, "El grupo del usuario no se debería de poder modificar si está asociado con un médico\n".print_r( $return_value, true ) );
        unset($this->Medico);
     }


    /**
     * Verifico que funcione correctamente el verificador de correo electrónico
     */
     public function testVerificarSiExiste() {
         // Busco una direccion registrada y una inventada
         $registrada = $this->Usuario->find( 'first', array( 'fields' => array( 'email' ), 'recursive' => -1 ) );
         $this->assertGreaterThan( 0, count( $registrada ), "No existen usuarios para comprobar la función con direcciones existentes!" );
         $registrada = $registrada['Usuario']['email'];
         $inventada = 'inventadisisisima@notengoidea.com.ar';
         $this->assertEqual( $this->Usuario->verificarSiExiste( $registrada ), true, "La direccion de correo electronica correcta falla." );
         $this->assertEqual( $this->Usuario->verificarSiExiste( $inventada  ), false, "La direccion de correo inventada está dandose como correcta." );
     }

     /**
      * Verificación del generador de contraseñas
      */
     public function testGenerarNuevaContraseña() {
         $usuario = $this->Usuario->find( 'first', array( 'fields' => array( 'email', 'id_usuario' ), 'recursive' => -1 ) );
         $this->assertGreaterThan( 0, count( $usuario ), "No existen usuarios para intentar el cambio de contraseña" );
         $this->assertArrayHasKey( 'Usuario', $usuario, "Array no conforme a estandares" );
         $this->assertArrayHasKey( 'email', $usuario['Usuario'], "El usuario seleccionado no posee campo de email" );
         $this->assertEqual( false, $this->Usuario->generarNuevaContraseñarray(), "La funcion no devuelve falso si no se le pasan parametros" );
         $nueva_contra = '';
         $this->assertNotEqual( false, $this->Usuario->generarNuevaContraseñarray( $usuario['Usuario']['email'], $nueva_contra ), "No se generó una nueva contraseña con campos validos" );
         $this->assertNotEmpty( $nueva_contra, "La contraseña pasada como parametro no puede estar nula" );
         /// @TODO: Verificar generación del HASH en test de nueva contraseña para verificar seteo correcto.
     }

     /**
      * Testear que la funcion siempre devuelva una cadena, con algun usuario conocido su razonsocial
      * Si se pasa cualquier banana o un numero inexistente, se deberá retornar una cadena vacía.
      * Si el numero de telefono pasado no corresponde exactamente deberá ser capaz de identificarlo.
      */
     public function testGetUsuarioPorTelefono() {
         $this->assertEqual( $this->Usuario->getUsuarioPorTelefono( null ), "", "El método debería de devolver una cadena vacía si se pasa un parametro nulo" );
         $this->assertEqual( $this->Usuario->getUsuarioPorTelefono( "" ), "", "El método debería de devolver una cadena vacía si se pasa una cadena vacía" );
         $telefono = $this->Usuario->find( 'first', array( 'fields' => array( 'telefono' ),
                                                           'conditions' => array( 'Usuario.telefono IS NOT NULL' ),
                                                           'recursive' => -1 ) );
         $this->assertGreaterThan( 0, count( $telefono ), "No hay ningun usuario con telefono para revisar el metodo!" );
         if( is_array( $telefono ) ) { $telefono = $telefono['Usuario']['telefono']; }
         $devolucion = $this->Usuario->getUsuarioPorTelefono( $telefono );
         $this->assertNotEqual( $devolucion, "", "No debería devolver un valor vacio si el telefono es uno de la base de datos" );
         $this->assertInternalType( 'array', $devolucion, "Debería devolver un array" );
         $this->assertGreaterThan( 0, count( $devolucion ), "Debería de contener al menos un elemento" );
         $this->assertArrayHasKey( 'Paciente', $devolucion, "La devolucion debería de tener el array paciente" );
         $this->assertArrayHasKey( 'id_usuario', $devolucion['Paciente'], "El elemento de deolvucion debe tener la clave id_usuario" );
         $this->assertArrayHasKey( 'razonsocial', $devolucion['Paciente'], "El elemento de deolvucion debe tener la clave razonsocial" );


     }

     /**
      */
    /*public function testEliminacionUltimoAdmin() {
        $this->assertEqual( true, false, "Falta la eliminacion - Se eliminó el ultimo usuario admin" );
    }

    public function testEliminacionPorEmail() {
        $this->assertEqual( true, false, "Falta implementacion de test de eliminar por email" );
    }*/
}
