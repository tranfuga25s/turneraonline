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
	public $fixtures = array('app.usuario');

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
	 * Prueba la condición de que si se elimina una clinica con datos asociados no se debería de poder hacer
	 * 
	 */
	 public function testEliminacion() {
	 	
		$this->assertNotEqual( $this->Usuario->delete( $id_clinica ), true, "La clinica no debe ser eliminada!" );
		
	 }
}
