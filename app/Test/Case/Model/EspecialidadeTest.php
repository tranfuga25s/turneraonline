<?php
/* Especialidade Test cases generated on: 2012-01-11 19:32:21 : 1326321141*/
App::uses('Especialidade', 'Model');

/**
 * Especialidade Test Case
 *
 */
class EspecialidadeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.especialidade');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Especialidade = ClassRegistry::init('Especialidade');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Especialidade);

		parent::tearDown();
	}

}
