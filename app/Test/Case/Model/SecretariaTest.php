<?php
/* Secretaria Test cases generated on: 2012-01-18 19:17:09 : 1326925029*/
App::uses('Secretaria', 'Model');

/**
 * Secretaria Test Case
 *
 */
class SecretariaTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.secretaria', 'app.usuario', 'app.obra_social', 'app.grupo', 'app.usuarios', 'app.clinica', 'app.consultorios');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Secretaria = ClassRegistry::init('Secretaria');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Secretaria);

		parent::tearDown();
	}

}
