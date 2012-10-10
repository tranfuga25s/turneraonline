<?php
App::uses('Controller' , 'Controller');
App::uses( 'Validation', 'Utility'   );
App::uses( 'File'      , 'Utility'   );
App::uses( 'Folder'    , 'Utility'   );
class ConfiguracionController extends AppController {

	var $uses = null;

	public function administracion_ver() {
		$this->set( 'datos', Configure::read( 'Turnera' ) );
		$this->layout = 'administracion';
	}

	public function administracion_notificaciones() {
		$this->layout = 'administracion';
	}

	public function administracion_guardar() {
		if( $this->request->is( "post" ) ) {
			$dias = $this->request->data['dias'];
			$horas = $this->request->data['horas'];
			$email = $this->request->data['email'];
			if( !Validation::email( $email ) ) {
				$this->Session->setFlash( "La cuenta de correo indicada no es una dirección de correo valida", 'default', array( 'class' => 'error') );
			} else if( $horas < 1 ) {
				$this->Session->setFlash( "La cantidad de horas previas deberá ser mayor a 1 hora.", 'default', array( 'class' => 'error') );
			} else if( $dias <= 1 ) {
				$this->Session->setFlash( "La cantidad de días deberá ser mayor a 1.", 'default', array( 'class' => 'error') );
			} else {
				/// @TODO Mejorar esto!
				Configure::write( 'Turnera.dias_turnos', $dias );
				Configure::write( 'Turnera.notificaciones.horas_proximo', $horas );
				Configure::write( 'Turnera.email_notificaciones', $email );
				$cadena =  "[Turnera]\n";
				$cadena .= "dias_turnos = ".$dias."\n";
				$cadena .= "notificaciones.turno_proximo = on\n";
				$cadena .= "notificaciones.horas_proximo = ".$horas."\n";
				$cadena .= "notificaciones.cancelacion = on\n";
				$cadena .= "email = ".$email."\n";
				
				$dir = new Folder( ROOT.DS.APP_DIR.DS.'Config' );
				$arch = new File( $dir->pwd(). DS . 'turnos.ini' );
				if( ! $arch->writable() ) {
					$this->Session->setFlash( "El archivo de configuración no se puede escribir", 'default', array( 'class' => 'error') );
				} else {
					$arch->prepare($cadena);
					if( !$arch->write( $cadena ) ) {
						$this->Session->setFlash( "No se pudo escribir el archivo correctamente", 'default', array( 'class' => 'error') );
					} else {
						$this->Session->setFlash( "Configuración cambiada correctamente.", 'default', array( 'class' => 'success') );
					}
				}
			}
			$this->redirect( array( 'action' => 'ver' ) );
		}
	}
}
?>