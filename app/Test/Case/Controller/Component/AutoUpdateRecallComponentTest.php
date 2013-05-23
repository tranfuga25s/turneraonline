<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('AutoUpdateRecallComponent', 'Controller/Component');

/**
 * AutoUpdateRecallComponent Test Case
 *
 */
class AutoUpdateRecallComponentTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$Collection = new ComponentCollection();
		$this->AutoUpdateRecall = new AutoUpdateRecallComponent($Collection);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AutoUpdateRecall);

		parent::tearDown();
	}

/**
 * testCambiarAutoActualizacion method
 *
 * @return void
 */
	public function testCambiarAutoActualizacion() {
	}

}
