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
	public $fixtures = array( 'app.obra_social',
                              'app.usuario',
                              'app.grupo' );

    /**
     * setUp method
     *
     * @return void
     */
	public function setUp() {
		parent::setUp();

		$this->ObraSocial = ClassRegistry::init('ObraSocial');
        $this->Usuario = ClassRegistry::init('Usuario');
	}

    public function testRepetido() {
        $obrasocial = $this->ObraSocial->find( 'first', array( 'recursive' => -1 ) );
        $this->assertEqual( $this->ObraSocial->buscarRepetido( $obrasocial['ObraSocial'] ), true, "No funciona el repetido con formato array" );

        $obrasocial['ObraSocial']['nombre'] = "test1";
        $this->assertEqual( $this->ObraSocial->buscarRepetido( $obrasocial['ObraSocial'] ), false, "No funciona el no repetido con formato array" );

        $this->assertEqual( $this->ObraSocial->buscarRepetido( "Obra social 1" ), true, "No funciona el repetido con formato texto" );

        $this->assertEqual( $this->ObraSocial->buscarRepetido( "Test" ), false, "No funciona el no repetido con formato texto" );
    }

    public function testEliminacionObraSocial() {

        $usuario = $this->Usuario->find( 'first', array( 'condition' => array( 'NOT' => array( 'obra_social_id' => null ) ),
                                              'recursive' => -1,
                                              'fields' => array( 'obra_social_id' ) ) );
        $this->assertGreaterThan( 0, count( $usuario ), "No hay usuarios con obra social? -> Arreglar fixture" );
        $this->assertArrayHasKey( 'Usuario', $usuario, "Formato incorrecto base" );
        $this->assertArrayHasKey( 'obra_social_id', $usuario['Usuario'], "Formato incorrecto hijo" );
        $this->assertGreaterThan( 0, $usuario['Usuario']['obra_social_id'], "Numero de obra social incorrecto" );

        $id_obra_social = intval( $usuario['Usuario']['obra_social_id'] );

        $this->assertNotEqual( $this->ObraSocial->delete( $id_obra_social ), true, "No se puede eliminar una obra social que tiene usuarios asociados" );
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
