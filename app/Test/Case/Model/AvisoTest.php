<?php
App::uses('Aviso', 'Model');

/**
 * Aviso Test Case
 * @property Aviso Aviso Modelo de avisos
 */
class AvisoTest extends CakeTestCase {

    private $Aviso = null;

	/**
	 * Fixtures
	 * @TODO Agregar fixture estático
	 * @var array
	 */
	public $fixtures = array(
		'app.aviso',
		'app.variable_aviso'
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Aviso = ClassRegistry::init('Aviso');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Aviso);

		parent::tearDown();
	}

    /**
     * testExisteCampoSMS method
     *
     * @return void
     */
    public function testExisteCampoSMS() {
        $this->assertArrayHasKey( 'metodo', $this->Aviso->_schema, 'No se detectó el campo de metodo de envío' );
    }


	/**
	 * testExistePendiente method
	 *
	 * @return void
	 */
	public function testExistePendiente() {
	    $this->assertEqual( $this->Aviso->existePendiente(), true, 'No se detectó corretamente el aviso pendiente' );
	}

	/**
	 * testBuscarSiguiente method
	 *
	 * @return void
	 */
	public function testBuscarSiguiente() {}

	/**
	 * testCambiarHorasTurno method
	 *
	 * @return void
	 */
	public function testCambiarHorasTurno() {}

	/**
	 * testCancelarAvisoNuevoTurno method
	 *
	 * @return void
	 */
	public function testCancelarAvisoNuevoTurno() {
	}


}
