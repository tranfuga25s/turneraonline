<?php
/* Especialidade Test cases generated on: 2012-01-11 19:32:21 : 1326321141*/
App::uses('Especialidad', 'Model');

/**
 * Especialidade Test Case
 *
 */
class EspecialidadTestCase extends CakeTestCase {
    /**
     * Fixtures
     *
     * @var array
     */
	public $fixtures = array('app.especialidad');

    /**
     * setUp method
     *
     * @return void
     */
	public function setUp() {
		parent::setUp();

		$this->Especialidad = ClassRegistry::init('Especialidad');
	}

    /**
     * tearDown method
     *
     * @return void
     */
	public function tearDown() {
		unset($this->Especialidad);

		parent::tearDown();
	}

}
