<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Avisos Controller
 */
class AvisosController extends AppController {

    public $components = array( 'Waltook.Sms' );

    public function isAuthorized( $usuario = null ) {
        switch( $usuario['grupo_id'] ) {
            case 1: // Administradores
            {
                return true;
                break;
            }
            case 2: // Medicos
            case 3: // Secretarias
            {
                switch( $this->request->params['action'] ) {
                    case 'administracion_view':
                    case 'administracion_edit':
                    case 'index':
                    { return true; break; }
                }
                // saco el break y el default para que autorize a los permisos de el usuario normal
            }
            case 4: // Usuario normal
            default:
            { break; }
        }
        return false;

    }

    private $avisos_disponibles = array( 'nuevoTurno', 'turnoCancelado' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow( array( 'recibir' ) );
    }

    public function recibir() {
        $mensaje = $this->Sms->recibir();
    }

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
        $celular = $this->Usuario->read( 'celular' );
        $celular = $celular['Usuario']['celular'];
        $face = $this->Usuario->read( 'facebook_id' );
        $face = $face['Usuario']['facebook_id'];

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
        					'from' => $email_de,
        					'metodo' => 'email' )
        );
		if( $this->Aviso->save( $datos ) ) {
			$datas = array(
				array( 'modelo' => 'Turno'      , 'id' => $id_turno      , 'nombre' => 'turno'      , 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Usuario'    , 'id' => $id_paciente   , 'nombre' => 'usuario'    , 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Consultorio', 'id' => $id_consultorio, 'nombre' => 'consultorio', 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Clinica'    , 'id' => $id_clinica    , 'nombre' => 'clinica'    , 'aviso_id' => $this->Aviso->id ),
				array( 'modelo' => 'Usuario'    , 'id' => $id_medico     , 'nombre' => 'medico'     , 'aviso_id' => $this->Aviso->id )
			);
			$this->loadModel( 'VariableAviso' );
			foreach( $datas as $dato ) {
				$this->VariableAviso->create();
				$this->VariableAviso->save( $dato );
			}
		} else {
		    die( "No se pudo guardar el email!" );
		}
        // Guardo los datos del sms si tiene celular activado
        if( !is_null( $celular ) && !empty( $celular ) && $celular != 0 ) {
            $this->Aviso->create(); // Evita que se sobreescriban los datos del aviso por email
            $datos['Aviso']['to'] = $celular;
            $datos['Aviso']['metodo'] = 'sms';
            // Calculo la hora de envio
            $cant_horas = Configure::read( 'Turnera.notificaciones.minutos_proximo_sms' );
            $de_sms = Configure::read( 'Turnera.celular' );
            $fechahora = new DateTime( $d['Turno']['fecha_inicio'] );
            if( is_array( $cant_horas ) ) {
                $fechahora->sub( new DateInterval( "PT".$cant_horas[0]."H" ) );
                $aviso['Aviso']['from'] = $de_sms[0];
                $aviso['Aviso']['fecha_hora'] = $fechahora->format( "Y/m/d H:i:s" );
            } else {
                $fechahora->sub( new DateInterval( "PT".$cant_horas."H" ) );
                $aviso['Aviso']['from'] = $de_sms;
                $aviso['Aviso']['fecha_hora'] = $fechahora->format( "Y/m/d H:i:s" );
            }
            if( $this->Aviso->save( $datos ) ) {
                $datas = array(
                    array( 'modelo' => 'Turno'      , 'id' => $id_turno      , 'nombre' => 'turno'      , 'aviso_id' => $this->Aviso->id ),
                    array( 'modelo' => 'Usuario'    , 'id' => $id_paciente   , 'nombre' => 'usuario'    , 'aviso_id' => $this->Aviso->id ),
                    array( 'modelo' => 'Consultorio', 'id' => $id_consultorio, 'nombre' => 'consultorio', 'aviso_id' => $this->Aviso->id ),
                    array( 'modelo' => 'Clinica'    , 'id' => $id_clinica    , 'nombre' => 'clinica'    , 'aviso_id' => $this->Aviso->id ),
                    array( 'modelo' => 'Usuario'    , 'id' => $id_medico     , 'nombre' => 'medico'     , 'aviso_id' => $this->Aviso->id )
                );
                $this->loadModel( 'VariableAviso' );
                foreach( $datas as $dato ) {
                    $this->VariableAviso->create();
                    $this->VariableAviso->save( $dato );
                }
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
        $celular = $this->Usuario->read( 'celular' );
        $celular = $celular['Usuario']['celular'];

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
					'to' => $email['Usuario']['email'],
					'metodo' => 'email' ),
				'VariablesAviso' => array(
					0 => array( 'modelo' => 'Turno', 'id' => $id_turno, 'nombre' => 'turno' ),
					1 => array( 'modelo' => 'Usuario', 'id' => $id_paciente['Turno']['id_usuario'], 'nombre' => 'usuario' ) )
				);
		$this->Aviso->saveAssociated( $datos );
        if( !is_null( $celular ) || !empty($celular ) ) {
            $datos['Aviso']['fecha_envio'] = date( 'Y-m-d g:i:s' );
            $datos['Aviso']['metodo'] = 'sms';
            $datos['Aviso']['to'] = $celular;
            $this->Aviso->saveAssociated( $datos );
        }
		$this->autoRender = false;
		return "";
	}

	/**
	 * Muestra la configuración de las notificaciones del sistema
	 *
	 */
	public function administracion_cpanel() {
		// Verifico si está andando el sistema de avisos
        $this->set( 'sms_habilitado', $this->Sms->habilitado() );
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
        foreach( $demail['Aviso']['datos'] as $k=>$d ) {
            $this->set( $k, $d );
        }

		// Busco la vista a renderizar
		if( $formato == 'email' ) {
			$demail['Aviso']['formato'] = 'html';
			$this->layout = 'Emails/'.$demail['Aviso']['formato'].'/'.$demail['Aviso']['layout'];
			return $this->render( '../Emails/'.$demail['Aviso']['formato'].'/'.Inflector::underscore( $demail['Aviso']['template'] ) );
		} else if( $formato == 'sms' ) {
            $this->layout = 'Emails/sms/'.$demail['Aviso']['layout'];
            return $this->render( '../Emails/sms/'.Inflector::underscore( $demail['Aviso']['template'] ) );

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

    /*!
     * Funcion llamada desde el dashboard de medicos y/o secretarias
     */
    public function index() {
        // La verificación de que usuario puede entrar está echa antes
        $this->set( 'horas_email', Configure::read( 'Turnera.notificaciones.horas_proximo' ) );
        $this->set( 'minutos_sms', Configure::read( 'Turnera.notificaciones.minutos_proximo_sms' ) );
        if( $this->Sms->habilitado() ) {
            $this->set( 'sms_habilitado', true );
            $this->loadModel( 'Gestotux.ConteoSms' );
            $estado = array(
                'enviados' => $this->ConteoSms->cantidadEnviada(),
                'recibidos' => $this->ConteoSms->cantidadRecibida(),
                'costo' => $this->ConteoSms->costoMensaje()
            );
            $this->set( 'estado_sms', $estado );
        } else {
            $this->set( 'sms_habilitado', false );
        }

    }


     /**
      * Funcion que habilita el servicio de sms
      */
     public function administracion_habilitar_sms() {
         // Si el servicio no está habilitado el servicio muestro el descargo.
         if( $this->request->isPost() ) {
             // Veo que haya contestado correctamente la habilitacion
             if( $this->request->data['habilitar']['acepta'] == 1 ) {
                 // Habilito el servicio
                 $key = $this->request->data['habilitar']['key'];
                 $cliente_id = $this->request->data['habilitar']['id_cliente'];
                 $method = 'GET';
                 $codigo = $this->request->data['habilitar']['codigo'];
                 if( $this->Sms->configurarServicio( $cliente_id, $key, $method, $codigo ) ) {
                     $this->Session->correcto( 'El servicio ha sido configurado correctamente' );
                     $this->redirect( array( 'action' => 'sms' ) );
                 } else {
                     $this->Session->incorrecto( 'No se pudo configurar el servicio' );
                 }
             }
         }
         if( !$this->Sms->habilitado() ) {
             return $this->render( 'descargo' );
         }
         // El servicio ya está habilitado, lo envío a la pagina de configuración
         $this->redirect( array( 'action' => 'sms' ) );
     }

}

