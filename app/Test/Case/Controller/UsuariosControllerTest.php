<?php
App::uses('UsuariosController', 'Controller');

/**
 * UsuariosController Test Case
 *
 */
class UsuariosControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.usuario',
		'app.obra_social',
		'app.grupo',
		'app.medico',
		'app.secretaria',
		'app.turno'
	);

/**
 * testIngresar method
 *
 * @return void
 */
	public function testIngresar() {
	}

/**
 * testPacientes method
 *
 * @return void
 */
	public function testPacientes() {
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	}

/**
 * testAdministracionIngresar method
 *
 * @return void
 */
	public function testAdministracionIngresar() {
	}

/**
 * testAdministracionSalir method
 *
 * @return void
 */
	public function testAdministracionSalir() {
	}

/**
 * testSalir method
 *
 * @return void
 */
	public function testSalir() {
	}

/**
 * testRecuperarContra method
 *
 * @return void
 */
	public function testRecuperarContra() {
	}

/**
 * testRegistrarse method
 *
 * @return void
 */
	public function testRegistrarse() {
	}

/**
 * testEliminarUsuario method
 *
 * @return void
 */
	public function testEliminarUsuario() {
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testVerPorMedico method
 *
 * @return void
 */
	public function testVerPorMedico() {
	}

/**
 * testVerPorSecretaria method
 *
 * @return void
 */
	public function testVerPorSecretaria() {
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}

/**
 * testCambiarContra method
 *
 * @return void
 */
	public function testCambiarContra() {
	}

/**
 * testAdministracionCpanel method
 *
 * @return void
 */
	public function testAdministracionCpanel() {
	}

/**
 * testAdministracionIndex method
 *
 * @return void
 */
	public function testAdministracionIndex() {
	}

/**
 * testAdministracionView method
 *
 * @return void
 */
	public function testAdministracionView() {
	}

/**
 * testAdministracionAdd method
 *
 * @return void
 */
	public function testAdministracionAdd() {
        $this->testAction('/administracion/usuarios/add');

        $this->assertInternalType('array', $this->vars['grupos']);
        $this->assertNotEqual( count( $this->vars['grupos'] ), 0, "Debería existir algun grupo" );

        $this->assertInternalType('array', $this->vars['obras_sociales'] );
        $this->assertNotEqual( count( $this->vars['obras_sociales'] ), 0, "Debería existir alguna obra social" );
	}

    /**
     * testAdministracionEdit method
     *
     * @return void
     */
	public function testAdministracionEdit() {
	    $this->testAction('/administracion/usuarios/edit/1');

        $this->assertInternalType('array', $this->vars['grupos']);
        $this->assertNotEqual( count( $this->vars['grupos'] ), 0, "Debería existir algun grupo" );

        $this->assertInternalType('array', $this->vars['obras_sociales'] );
        $this->assertNotEqual( count( $this->vars['obras_sociales'] ), 0, "Debería existir alguna obra social" );
	}

/**
 * testAdministracionDelete method
 *
 * @return void
 */
	public function testAdministracionDelete() {
	}

/**
 * testAdministracionCambiarContra method
 *
 * @return void
 */
	public function testAdministracionCambiarContra() {
	}

/**
 * testAltaTurno method
 *
 * @return void
 */
	public function testAltaTurno() {
	}

/**
 * testBorrarCacheUsuarios method
 *
 * @return void
 */
	public function testBorrarCacheUsuarios() {
	}

/**
 * testHistorico method
 *
 * @return void
 */
	public function testHistorico() {
	}

}
