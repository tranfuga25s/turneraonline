<?php
App::uses('AvisosController', 'Controller');

/**
 * AvisosController Test Case
 *
 */
class AvisosControllerTest extends ControllerTestCase {

    /**
     * Fixtures que usa el sistema
     *
     * @var array
     */
	public $fixtures = array(
		'app.aviso',
		'app.turno'
	);
    
    /**
     * testAgregarAvisoNuevoTurno method
     *
     * @return void
     */
	public function testAgregarAvisoNuevoTurno() {
	    // Testear parametros
	    
	}
    
    public function testAgregarAvisoNuevoTurnoSoloEmail() {
        // Desabilito la funcionalidad de Waltook        
    }
    
    public function testAgregarAvisoNuevoTurnoSoloSms() {
        // Habilito la funcionalidad de Waltook
        $aviso = $this->generate( 'Aviso', array(
            'methods' => array( 'isAuthorized' ),
            'models' => array( 'Aviso' => array( 'save' ) ),
            'components' => array( 'Waltook.Sms' => array( 'habilitado' ) )
        ) );
        $aviso->Sms->method('habilitado')
                   ->expects( $this->once() )
                   ->will( $this->returnValue( false ) );
        /*$this->testAction( '/aviso/agregarAvisoNuevoTurno', 
                           array( 'data' => array( 'Aviso' => array( 'metodo' => 'sms' ) ) ) 
        );*/
                   
    }

    /**
     * testCancelarAvisoNuevoTurno method
     *
     * @return void
     */
	public function testCancelarAvisoNuevoTurno() {
	}

    /**
     * testAgregarAvisoCancelacionTurno method
     *
     * @return void
     */
	public function testAgregarAvisoCancelacionTurno() {
	}


    /**
     * testAdministracionCancelar method
     *
     * @return void
     */
	public function testAdministracionCancelar() {
	}

}
