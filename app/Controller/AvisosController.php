<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Avisos Controller
 */
class AvisosController extends AppController {
	
	public function agregarAvisoNuevoTurno( $id_turno = null, $id_paciente = null ) {

		if( $id_turno == null ) { $id_turno = $this->request->params['named']['id_turno']; }
		if( $id_paciente == null ) { $id_paciente = $this->request->params['named']['id_paciente']; }
		// Busco los datos y los paso a la vista
		$this->loadModel( 'Turno' );
		$this->Turno->id = $id_turno;
		if( !$this->Turno->exists() ) {
			throw new NotFoundException( 'Turno Invalido' );
			return;
		}
		$d = $this->Turno->read( array( 'fecha_inicio', 'consultorio_id', 'medico_id' ) );
		$fecha_hora = $d['Turno']['fecha_inicio'];
		$id_consultorio = $d['Turno']['consultorio_id'];
		
		$this->loadModel( 'Medico' );
		$this->Medico->id = $d['Turno']['medico_id'];
		if( !$this->Medico->exists() ) {
			throw new NotFoundException( 'Medico Invalido' );
			return;
		}
		$this->Medico->recursive = 0;
		$temp = $this->Medico->read( array( 'usuario_id', 'clinica_id' ) );
		$id_medico = $temp['Medico']['usuario_id'];
		$id_clinica = $temp['Medico']['clinica_id'];
		unset( $temp );

		$this->loadModel( 'Usuario' );
		$this->Usuario->id = $id_paciente;
		if( !$this->Usuario->exists() ) {
			throw new NotFoundException( 'Usuario Invalido' );
			return;
		}
		$email = $this->Usuario->read( 'email' );

		// Calculo la hora de envio
		$cant_horas = Configure::read( 'Turnera.notificaciones.horas_proximo' );
		$email_de = Configure::read( 'Turnera.email' );
		$fechahora = new DateTime( $d['Turno']['fecha_inicio'] );
		if( is_array( $cant_horas ) ) {
			$fechahora->sub( new DateInterval( "PT".$cant_horas[0]."H" ) );
			$email_de = $email_de[0];
		} else {
			$fechahora->sub( new DateInterval( "PT".$cant_horas."H" ) );
		}
		// Guardo el email
		$datos = array(	'Aviso' =>
				 array( 'fecha_envio' => $fechahora->format( 'Y-m-d H:i:s' ),
					'template' => 'nuevoTurno',
					'layout' => 'usuario',
					'formato' => 'both',
					'to' => $email['Usuario']['email'],
					'subject' => 'Turno proximo',
					'from' => $email_de ) );
		if( $this->Aviso->save( $datos ) ) {
			$d = array(
				array( 'modelo' => 'Turno'      , 'id' => $id_turno      , 'nombre' => 'turno'      , 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Usuario'    , 'id' => $id_paciente   , 'nombre' => 'usuario'    , 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Consultorio', 'id' => $id_consultorio, 'nombre' => 'consultorio', 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Clinica'    , 'id' => $id_clinica    , 'nombre' => 'clinica'    , 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Usuario'    , 'id' => $id_medico     , 'nombre' => 'medico'     , 'aviso_id' => $this->Aviso->id )
			);
			$this->loadModel( 'VariableAviso' );
			foreach( $d as $dato ) {
				$this->VariableAviso->create();
				$this->VariableAviso->save( $dato );
			}
		}
		$this->autoRender = false;
		return "";
	}

	public function cancelarAvisoNuevoTurno( $id_turno = null ) {
		$this->Aviso->cancelarAvisoNuevoTurno( $id_turno );
	}

	public function agregarAvisoCancelacionTurno( $id_turno = null ) {
		if( $id_turno == null ) { $id_turno = $this->request->params['named']['id_turno']; }
		// Busco los datos y los paso a la vista
		$this->loadModel( 'Turno' );
		$this->Turno->id = $id_turno;
		if( !$this->Turno->exists() ) {
			echo "Turno inexistente";
		}
		$fecha_hora = $this->Turno->read( 'fecha_inicio' );
		$id_paciente = $this->Turno->read( 'paciente_id' );
		
		if( $id_paciente['Turno']['paciente_id'] == null )
			return;

		$this->loadModel( 'Usuario' );
		$this->Usuario->id = $id_paciente['Turno']['paciente_id'];
		$email = $this->Usuario->read( 'email' );

		$email_de = Configure::read( 'Turnera.email' );
		if( is_array( $email_de ) ) { $email_de = $email_de[0]; }
		// Guardo el email
		$datos = array(	'Aviso' =>
				 array( 'fecha_envio' => date( 'Y-m-d g:i:s' ),
					'template' => 'turnoCancelado',
					'layout' => 'usuario',
					'formato' => 'both',
					'from' => $email_de,
					'subject' => 'Su turno fue cancelado!',
					'to' => $email['Usuario']['email'] ),
				'VariablesAviso' => array(
					0 => array( 'modelo' => 'Turno', 'id' => $id_turno, 'nombre' => 'turno' ),
					1 => array( 'modelo' => 'Usuario', 'id' => $id_paciente['Turno']['id_usuario'], 'nombre' => 'usuario' ) )
				);
		$this->Aviso->saveAssociated( $datos );
		$this->autoRender = false;
		return "";
	}

	/**
	 * Muestra la configuración de las notificaciones del sistema
	 * 
	 */
	public function administracion_cpanel() {
		// Verifico si está andando el sistema de avisos
			
	}
	
	/**
	 *  Muestra la configuración y/o habilitacion del sistema de sms
	 */
	public function administracion_sms() {
		
	}
	
	/**
	 * Muestra la configuración y/o habilitacion del sistema de email
	 */
	public function administracion_email() {
		// Cargo los templates disponibles
		$data = array(
			'nuevoTurno' => array(
				'nombre' => 'Recordatorio de turno proximo',
				'explicacion' => 'Este aviso es enviado avisando al paciente de que tiene un turno dentro de las 12 horas proximas',
				'template' => 'nuevoTurno',
				'Formato' => array( 
					'text' => array(
						'nombre' => 'Solo texto',
						'content' => 'Formato solo texto',
						'campos' => 'Para reemplazar por los datos actuales utilice {nombre}'
					 ),
					 'html' => array(
					 	'nombre' => 'Html',
					 	'content' => 'Formato en html',
						'campos' => 'Para reemplazar por los datos actuales utilice {nombre}'
					 ) 
				)
			)
		);
		$this->set( 'avisos', $data );
	}
	
	/**
	 * Muestra la lista de notificaciones pendientes de envio
	 */
	public function administracion_pendiente() {
		// cargo las notificaciones que hay que enviar todavía
		$this->set( 'pendientes', $this->paginate() );
		
	}
	
	/** 
	 * Función para administrar las redirecciones según sea necesario
	 * @param string $que Que elemento configurar
	 */
	public function administracion_configurar( $que = 'email' ) {
		$this->redirect( array( 'action' => $que ) );
	}
}

