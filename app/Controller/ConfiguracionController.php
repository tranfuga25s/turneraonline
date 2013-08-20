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
				$this->Session->incorrecto( "La cuenta de correo indicada no es una dirección de correo valida" );
			} else if( $horas < 1 ) {
				$this->Session->incorrecto( "La cantidad de horas previas deberá ser mayor a 1 hora." );
			} else if( $dias <= 1 ) {
				$this->Session->incorrecto( "La cantidad de días deberá ser mayor a 1." );
			} else {
				/// @TODO Mejorar esto!
				Configure::write( 'Turnera.dias_turnos', $dias );
				Configure::write( 'Turnera.notificaciones.horas_proximo', $horas );
				Configure::write( 'Turnera.email_notificaciones', $email );
                Configure::write( 'Turnera.notificaciones.minutos_proximo_sms', $minutos );
				$cadena =  "[Turnera]\n";
				$cadena .= "dias_turnos = ".$dias."\n";
				$cadena .= "notificaciones.turno_proximo = on\n";
				$cadena .= "notificaciones.horas_proximo = ".$horas."\n";
                $cadena .= "notificaciones.minutos_proximo_sms".$minutos."\n";
				$cadena .= "notificaciones.cancelacion = on\n";
				$cadena .= "email = ".$email."\n";

				$dir = new Folder( ROOT.DS.APP_DIR.DS.'Config' );
				$arch = new File( $dir->pwd(). DS . 'turnos.ini' );
				if( ! $arch->writable() ) {
					$this->Session->incorrecto( "El archivo de configuración no se puede escribir" );
				} else {
					$arch->prepare($cadena);
					if( !$arch->write( $cadena ) ) {
						$this->Session->incorrecto( "No se pudo escribir el archivo correctamente" );
					} else {
						$this->Session->correcto( "Configuración cambiada correctamente." );
					}
				}
			}
			$this->redirect( array( 'action' => 'ver' ) );
		}
	}
}
?>