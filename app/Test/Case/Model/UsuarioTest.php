<?php
/* Usuario Test cases generated on: 2012-01-12 11:36:19 : 1326378979*/
App::uses('Usuario', 'Model');

/**
 * Usuario Test Case
 *
 */
class UsuarioTestCase extends CakeTestCase {
	
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array('app.usuario',
							 'app.medico',
							 'app.secretaria',
							 'app.especialidad',
							 'app.clinica',
							 'app.obras_sociales',
							 'app.grupo');

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->Usuario = ClassRegistry::init('Usuario');
		$this->Secretaria = ClassRegistry::init('Secretaria');
		$this->Medico = ClassRegistry::init('Medico');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Usuario);
		unset($this->Secretaria);
		unset($this->Medico);

		parent::tearDown();
	}
	
	/**
	 * Prueba la condición de que si se elimina una clinica con datos asociados no se debería de poder hacer
	 * 
	 */
	 public function testEliminacionUsuarioMedico() {
	 		 	
	 	$id_usuario = $this->Medico->find( 'first', array( 'fields' => array( 'usuario_id' ) ) );
								
		$this->assertNotEqual( $id_usuario,       0, "No se pudo seleccionar una secretaria - cero"        );
		$this->assertNotEqual( $id_usuario,    null, "No se pudo seleciconar una secretaria - null"        );
		$this->assertNotEqual( $id_usuario, array(), "No se pudo seleccionar una secretaria - array vacio" );	
	 	
		$this->assertNotEqual( $this->Usuario->delete( $id_usuario ), true, "Un usuario linkeado con un medico no debe ser eliminado!" );
		
	 }
	 
	/**
	 * Prueba la condición de que si se elimina una clinica con datos asociados no se debería de poder hacer
	 * 
	 */
	 public function testEliminacionUsuarioSecretaria() {
	 	
	 	$id_usuario = $this->Secretaria->find( 'first', array( 'fields' => array( 'usuario_id' ) ) );
								
		$this->assertNotEqual( $id_usuario,       0, "No se pudo seleccionar una secretaria - cero"        );
		$this->assertNotEqual( $id_usuario,    null, "No se pudo seleciconar una secretaria - null"        );
		$this->assertNotEqual( $id_usuario, array(), "No se pudo seleccionar una secretaria - array vacio" );	
		
		$this->assertNotEqual( $this->Usuario->delete( $id_usuario ), true, "Un usuario linkeado con una secretaria no debe ser eliminado!" );
		
	 }

}
