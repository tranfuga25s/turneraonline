<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('AppController', 'Controller');
App::uses('SessionComponent', 'Controller/Component');
App::uses('DiaTurnoRecallComponent', 'Controller/Component');

/**
 * DiaTurnoRecallComponent Test Case
 *
 */
class DiaTurnoRecallComponentTest extends CakeTestCase {


    public $components = array( 'Session' );

    private $controlador = null;


    /**
     * setUp method
     *
     * @return void
     */
	public function setUp() {
		parent::setUp();
		$this->Collection = new ComponentCollection();
		$this->DiaTurnoRecall = new DiaTurnoRecallComponent( $this->Collection );
        $this->Session = new SessionComponent( $this->Collection );
        $this->controlador = new AppController();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DiaTurnoRecall);
        unset($this->Session);
        unset($this->controlador);
        unset($this->Collection);

		parent::tearDown();
	}

/**
 * testCambiarDia method
 *
 * @return void
 */
	public function testCambiarDia() {
	    $this->DiaTurnoRecall->cambiarDia( 1, 1, 1900 );
        $this->assertEqual( $this->DiaTurnoRecall->dia(), 1, 'El día no fue cambiado' );
        $this->assertEqual( $this->DiaTurnoRecall->mes(), 1, 'El mes no fue cambiado' );
        $this->assertEqual( $this->DiaTurnoRecall->ano(), 1900, 'El día no fue cambiado' );
        $this->DiaTurnoRecall->cambiarDia( 2, 2, 1902 );
        $this->assertEqual( $this->DiaTurnoRecall->dia(), 2, 'El día no fue cambiado' );
        $this->assertEqual( $this->DiaTurnoRecall->mes(), 2, 'El mes no fue cambiado' );
        $this->assertEqual( $this->DiaTurnoRecall->ano(), 1902, 'El día no fue cambiado' );
	}

/**
 * testCambiarDia method
 *
 * @return void
 */
    public function testStartUp() {
        $this->DiaTurnoRecall = new DiaTurnoRecallComponent( $this->Collection, array( 'variable' => 'test' ) );
        $this->DiaTurnoRecall->cambiarDia( 1, 1, 1900 );
        $this->assertEqual( intval( $this->Session->read( 'test.dia' ) ), 1, 'La variable no está guardada correctamente' );
        $this->assertEqual( intval( $this->Session->read( 'test.mes' ) ), 1, 'La variable no está guardada correctamente' );
        $this->assertEqual( intval( $this->Session->read( 'test.ano' ) ), 1900, 'La variable no stá guardada correctamente' );
        $this->DiaTurnoRecall->startup( $this->controlador );
        $this->DiaTurnoRecall = new DiaTurnoRecallComponent( $this->Collection, array( 'variable' => 'test2' ) );
        $this->DiaTurnoRecall->cambiarDia( 1, 1, 1900 );
        $this->assertEqual( intval( $this->Session->read( 'test2.dia' ) ), 1, 'La variable no está guardada correctamente' );
        $this->assertEqual( intval( $this->Session->read( 'test2.mes' ) ), 1, 'La variable no está guardada correctamente' );
        $this->assertEqual( intval( $this->Session->read( 'test2.ano' ) ), 1900, 'La variable no stá guardada correctamente' );
    }

    public function testBeforeRender() {
        $this->DiaTurnoRecall = new DiaTurnoRecallComponent( $this->Collection, array( 'variable' => 'test' ) );
        $this->DiaTurnoRecall->cambiarDia( 1, 1, 1900 );
        $this->DiaTurnoRecall->beforeRender( $this->controlador );
        $this->assertEqual( array_key_exists( 'dia', $this->controlador->viewVars ), true, 'No se seteo la variable día' );
        $this->assertEqual( intval( $this->controlador->viewVars['dia'] ),    1, 'No se seteo la variable día correctamente' );
        $this->assertEqual( array_key_exists( 'mes', $this->controlador->viewVars ), true, 'No se seteo la variable mes' );
        $this->assertEqual( intval( $this->controlador->viewVars['mes'] ),    0, 'No se seteo la variable mes correctamente' );
        $this->assertEqual( array_key_exists( 'ano', $this->controlador->viewVars ), true, 'No se seteo la variable ano' );
        $this->assertEqual( intval( $this->controlador->viewVars['ano'] ), 1900, 'No se seteo la variable año correctamente' );
        $this->assertEqual( array_key_exists( 'fechas', $this->controlador->viewVars ), true, 'No se seteo la variable fecha' );
        $this->assertEqual( array_key_exists( 'hoy', $this->controlador->viewVars ), true, 'No se seteo la variable hoy' );
    }

    public function testDiaHoy() {
        $controller = new AppController();
        $this->DiaTurnoRecall->cambiarDia( date('d'), date('m'), date('Y') );
        $this->DiaTurnoRecall->beforeRender( $this->controlador );
        $this->assertEqual( array_key_exists( 'hoy', $this->controlador->viewVars ), true, 'No se seteo la variable fecha' );
        $this->assertEqual( $this->controlador->viewVars['hoy'], true, 'No se seteo la variable fecha correctamente' );
    }

    /**
     * testDia method
     *
     * @return void
     */
	public function testDia() {
	    $this->DiaTurnoRecall->cambiarDia( 1, 1, 1900 );
        $this->assertEqual( $this->DiaTurnoRecall->dia(), 1, 'El día no fue cambiado' );
	}

/**
 * testMes method
 *
 * @return void
 */
	public function testMes() {
	    $this->DiaTurnoRecall->cambiarDia( 1, 1, 1900 );
        $this->assertEqual( $this->DiaTurnoRecall->mes(), 1, 'El mes no fue cambiado' );
	}

/**
 * testAno method
 *
 * @return void
 */
	public function testAno() {
	    $this->DiaTurnoRecall->cambiarDia( 1, 1, 1900 );
        $this->assertEqual( $this->DiaTurnoRecall->ano(), 1900, 'El día no fue cambiado' );
	}

}
