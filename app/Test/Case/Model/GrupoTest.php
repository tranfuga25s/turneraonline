<?php
/* Grupo Test cases generated on: 2012-01-16 11:22:45 : 1326723765*/
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
	public $fixtures = array('app.grupo');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Grupo = ClassRegistry::init('Grupo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Grupo);

		parent::tearDown();
	}

}
