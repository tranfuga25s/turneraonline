<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Avisos Controller
 */
class AvisosController extends AppController {

    public $components = array( 'Waltook.Sms' );
    
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
        // Configuración de los mensajes para sms
        $this->set( 'num_cliente', $this->Sms->getClientId() );
        $this->set( 'clave', $this->Sms->getKey() );
        $this->set( 'codigo_respuesta', $this->Sms->getRequestCode() );

        // Agregar visión de creditos
        $this->set( 'saldo', $this->Sms->getCreditoMensajes() );
        $mensajes = $this->Sms->obtenerListaMensajes();
        $this->loadModel( 'Usuario' );
        foreach( $mensajes as &$mensaje ) {
            $mensaje['Paciente']['razonsocial'] = $this->Usuario->getUsuarioPorTelefono( $mensaje['Sms']['uid'] );
        }
        $this->set( 'mensajes', $mensajes );
	}

	/**
	 * Muestra la lista de notificaciones pendientes de envio
	 */
	public function administracion_pendiente() {
		// cargo las notificaciones que hay que enviar todavía
		$this->set( 'pendientes', $this->paginate( array( 'fecha_envio >= NOW()' ) ) );
		$this->set( 'vencidas', $this->paginate( array( 'fecha_envio <= NOW()' ) ) );
	}

	/**
	 * Función para administrar las redirecciones según sea necesario
	 * @param string $que Que elemento configurar
	 */
	public function administracion_configurar( $que = 'email' ) {
		$this->redirect( array( 'action' => $que ) );
	}

	/**
	 * Función para ver un aviso
	 * @param integer $id Identificador del aviso
	 */
	public function administracion_view( $id_aviso = null ) {
		$this->Aviso->id = $id_aviso;
		if( !$this->Aviso->exists() ) {
			throw new NotFoundException( 'El aviso no existe o ya fue enviado' );
		}
		$this->Aviso->recursive = -1;
		$aviso = $this->Aviso->read( null, $id_aviso );
		// Busco el destinatario
		$id_usuario = $this->Aviso->VariableAviso->find( 'first', array( 'conditions' => array( 'aviso_id' => $id_aviso, 'nombre' => 'usuario' ), 'fields' => array( 'id' ) ) );
		$id_usuario = $id_usuario['VariableAviso']['id'];
		$this->loadModel( 'Usuario' );
		$destinos = $this->Usuario->read( array( 'email', 'celular' ), $id_usuario );
		$aviso['Aviso']['para'] = $destinos['Usuario'];
		$this->set( 'aviso', $aviso );
	}

	/**
	 * Función para renderizar el formato de un aviso
	 * @param integer $id_aviso Identificador del aviso
	 * @param string $formato Identificador del formato ( email o sms )
	 * @return Contenido html renderizado
	 */
	public function administracion_renderizar_aviso( $id_aviso = null, $formato = 'email' ) {
		$this->Aviso->id = $id_aviso;
		if( !$this->Aviso->exists() ) {
			throw new NotFoundExpception( 'No se encontró el aviso buscado' );
		}
		$this->Aviso->recursive = 2;
		$demail = $this->Aviso->read( null, $id_aviso );

		$datos = array();
		foreach( $demail['VariableAviso'] as $v ) {
			$this->loadModel( $v['modelo'] );
			$this->$v['modelo']->id = $v['id'];
			if( !$this->$v['modelo']->exists() ) {
				throw new NotFoundException( 'No se encontró uno de los datos del aviso. Modelo: '.$v['modelo'].' - id: '.$v['id'] );
			}
			$this->$v['modelo']->recursive = -1;
			$datos[ $v['nombre'] ] = $this->$v['modelo']->read();
		}
		$datos['email_de'] = Configure::read( 'Turnera.email' );
		unset( $demail['VariablesAviso'] );
		$demail['Aviso']['datos'] = $datos;

		// Busco la vista a renderizar
		if( $formato == 'email' ) {
			$demail['Aviso']['formato'] = 'html';
			foreach( $demail['Aviso']['datos'] as $k=>$d ) {
				$this->set( $k, $d );
			}
			$this->layout = 'Emails/'.$demail['Aviso']['formato'].'/'.$demail['Aviso']['layout'];
			return $this->render( '../Emails/'.$demail['Aviso']['formato'].'/'.Inflector::underscore( $demail['Aviso']['template'] ) );
		} else if( $formato == 'sms' ) {
			return "Todavía no se encuentra disponible esta característica";
		} else {
			throw new NotFoundException( 'No se encontró el formato de renderizado: '.$formato );
		}
	}

	/**
	 * Función para cancelar un aviso
	 * @param integer $id_aviso Identificador del aviso a cancelar
	 */
	 public function administracion_cancelar( $id_aviso = null ) {
	 	$this->Aviso->id = $id_aviso;
		if( !$this->Aviso->exists() ) {
			throw new NotFoundException( 'No existe el aviso que intenta cancelar' );
		}

		if( $this->Aviso->delete( $id_aviso, true ) ) {
			$this->Session->correcto( 'El aviso ha sido cancelado correctamente' );
		} else {
			$this->Session->incorrecto( 'El aviso no pudo ser cancelado' );
		}
		$this->redirect( array( 'action' => 'pendiente' ) );
	 }

     /**
      * Funcion que habilita el servicio de sms
      */
     public function administracion_habilitarSms() {
         // Si el servicio no está habilitado el servicio muestro el descargo.
         if( !$this->Sms->habilitado() ) {
             return $this->render( 'Waltook.descargo' );
         }
         // El servicio ya está habilitado, lo envío a la pagina de configuración
         $this->redirect( array( 'action' => 'sms' ) );
     }

}

