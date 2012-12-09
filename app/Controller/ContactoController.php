<?php

App::import( 'Utility', 'Validation' );
App::uses('CakeEmail', 'Network/Email');

class ContactoController extends AppController {
	
	public function beforeFilter() {
    	$this->Auth->allow(array('formulario'));
		parent::beforeFilter();
    }
	
	public function formulario() {}

	public function enviar() {
		if( $this->request->isPost() ) {
			// Verifico la dirección de email
			if( !Validation::email( $this->data['contacto']['email'], true ) ) {
				$this->Session->setFlash( "La dirección de email ingresado no es válida." , 'default', array( 'class' => 'error') );
				$this->redirect( array( 'action' => 'formulario' ) );
			} else {
				$email = new CakeEmail();
				$email->from( array( $this->data['contacto']['email'] => $this->data['contacto']['nombre'] ) );
				$email->to('esteban.zeller@gmail.com');
				$email->subject( 'Contacto de turnosonline' );
				$email->send('Ha tenido un nuevo contacto a través del sitio de turnosonline: \n'.$this->data['contacto']['texto'] );
				$this->Session->setFlash( "Su mensaje ha sido enviado correctamente. Gracias por contactarse con nosotros!", 'default', array( 'class' => 'success') );
				$this->redirect( '/' );
			}
		} else {
			throw new NotFoundException( "Metodo de envío no encontrado" );
		}
	}
    
    public function administracion_error() {
    	$this->layout = 'administracion';
        if( $this->request->isPost() ) {
            // Verifico la dirección de email
            if( !empty( $this->data['contacto']['email'] ) && !Validation::email( $this->data['contacto']['email'], true ) ) {
                $this->Session->setFlash( "La dirección de email ingresado no es válida." , 'default', array( 'class' => 'error') );
                $this->redirect( array( 'action' => 'formulario' ) );
            } else {
                $email = new CakeEmail();
                if( empty( $this->data['contacto']['email'] ) ) {
                    $email->from( array( 'noreply@turnossantafe.com.ar' => "No responder!" ) );    
                } else {
                    $email->from( array( $this->data['contacto']['email'] => $this->data['contacto']['nombre'] ) );
                }
                $email->to('esteban.zeller@gmail.com');
                $email->subject( 'Informe de error de turnosonline' );
                $texto = 'Ha tenido un nuevo contacto a través del sitio de turnosonline: \n'
                             .$this->data['contacto']['descripcion_corta'].'\n\n'
                             .$this->data['contacto']['detalle'].'\n'
                             .'Deseo mantenerme informado de este error: ';
                $this->Session->setFlash( "Su mensaje ha sido enviado correctamente. Gracias por contactarse con nosotros!" , 'default', array( 'class' => 'success') );
                $this->redirect( array( 'controller' => 'usuarios', 'action' => 'cpanel' ) );
            }
        }
		// Averiguo el referer
		$this->set( 'direccion_error', $this->referer() );
    }
    
    public function administracion_sugerencia() {
    	$this->layout = 'administracion';
        if( $this->request->isPost() ) {
            $email = new CakeEmail();
			$user = $this->Auth->user();
            $email->from( array( $user['email'] => $user['razonsocial'] ) );
            $email->to('esteban.zeller@gmail.com');
            $email->subject( 'Nueva sugerencia para turnosonline' );
            $texto = 'Ha tenido un nuevo contacto a través del sitio de turnosonline: \n'
                         .$this->data['contacto']['descripcion_corta'].'\n\n'
                         .$this->data['contacto']['detalle'].'\n'
                         .'Deseo mantenerme informado de este error: ';
            if( $this->data['contacto']['contactar'] == 1 ) {
                $texto .= " Si.\n";
                $texto .= " Nombre y direccion: ".$user['razonsocial']." - ".$user['email'];
            } else {
                $texto .= " No.";
            }   
            $email->send( $texto );
            $this->Session->setFlash( "Su mensaje ha sido enviado correctamente. Gracias por contactarse con nosotros!" , 'default', array( 'class' => 'success') );
            $this->redirect( array( 'controller' => 'usuarios', 'action' => 'cpanel' ) );
        }
    }
	
}
?>