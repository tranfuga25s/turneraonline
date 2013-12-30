<?php
/* ObrasSociale Test cases generated on: 2012-01-11 21:59:32 : 1326329972*/
App::uses('ObrasSociale', 'Model');

/**
 * ObrasSociale Test Case
 *
 */
class ObrasSocialeTestCase extends CakeTestCase {
    /**
     * Fixtures
     *
     * @var array
     */
	public $fixtures = array('app.obra_social');

    /**
     * setUp method
     *
     * @return void
     */
	public function setUp() {
		parent::setUp();

		$this->ObraSocial = ClassRegistry::init('ObraSocial');
	}
    
    public function testRepetido() {
        $obrasocial = $this->ObraSocial->find( 'first', array( 'recursive' => -1 ) );
        $this->assertEqual( $this->ObraSocial->buscarRepetido( $obrasocial['ObraSocial'] ), true, "No funciona el repetido con formato array" );

        $obrasocial['ObraSocial']['nombre'] = "test1";
        $this->assertEqual( $this->ObraSocial->buscarRepetido( $obrasocial['ObraSocial'] ), false, "No funciona el no repetido con formato array" );
        
        $this->assertEqual( $this->ObraSocial->buscarRepetido( "Obra social 1" ), true, "No funciona el repetido con formato texto" );
        
        $this->assertEqual( $this->ObraSocial->buscarRepetido( "Test" ), false, "No funciona el no repetido con formato texto" );
    }

    /**
     * tearDown method
     *
     * @return void
     */
	public function tearDown() {
		unset($this->ObraSocial);

		parent::tearDown();
	}

}
