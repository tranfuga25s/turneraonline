<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
/**
 * Clase que administra los usuarios
 *
 * @property Usuario $Usuario
 */
class UsuariosController extends AppController {

	public $components = array( 'RequestHandler' );

	public function beforeFilter() {
	    parent::beforeFilter();
		// Defino que acciones son publicas
		$this->Auth->allow( array( 	'ingresar',
						'administracion_ingresaradmin',
						'administracion_salir',
						'salir',
						'recuperarContra',
						'registrarse',
						'cancelar',
						'eliminarUsuario' ) );
	}

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
					case 'pacientes':
					case 'verPorMedico':
					case 'verPorSecretaria':
					case 'altaTurno':
					case 'index':
					case 'add':
					case 'delete':
					case 'historico':
					{ return true; break; }
				}
				// no pongo break para que acredite las acciones de menos prioridad
			}
			case 4: // Usuario normal
			{
				switch( $this->request->params['action'] ) {
					case 'view':
					case 'edit':
					case 'cambiarContra':
					{ return true; break; }
					default:
					{ return false; break; }
				}
				break;
			}
		}
		return false;
	}

	/**
	 * Metodo de login de usuario para la pagina
	 *
	 * @return void
	 */
	public function ingresar() {
		if ($this->request->is('post')) {
			if ( $this->Auth->login() ) {
				return $this->redirect( array( 'controller' => 'pages', 'action' => 'display', 'homeVenta' ) );
			} else {
				$this->Session->setFlash( "El email ingresado o la contraseña son incorrectas", 'default', array(), 'auth');
			}
		}
	}

	public function pacientes() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		if( isset( $this->request->query['query'] ) ) {
			$term = $this->request->query['query'];
			$ret = Cache::read( 'pacientes-'.$term );
			if( $ret == false ) {
				$data = $this->Usuario->find( 'all',
					array(  'fields' => array( 'razonsocial', 'id_usuario' ),
							'conditions' => array( 'razonsocial LIKE ' => "%".$term."%" ),
							'order' => array( 'razonsocial' ) ) );
				$ret = array();
				foreach( $data as $d ) {
					$ret[] = $d['Usuario']['id_usuario'].' - '.$d['Usuario']['razonsocial'];
				}
				$ret = json_encode( $ret );
				Cache::write( 'pacientes-'.$term, $ret );
			}

		} else {
			$ret = Cache::read( 'pacientes' );
			if( $ret == false ) {
				$data = $this->Usuario->find( 'all', array(  'fields' => array( 'razonsocial', 'id_usuario', 'nombre', 'apellido' ), 'order' => array( 'razonsocial' ) ) );
				$ret = array();
				foreach( $data as $d ) {
				    $ret[] = $d['Usuario']['id_usuario'].' - '.$d['Usuario']['razonsocial'];
				}
				$ret = json_encode( $ret );
				Cache::write( 'pacientes', $ret );
			}
		}
		return $ret;
	}

   /*!
    * Listado de pacientes para médicos y secretarias.
	*/
    public function index() {
    	$cond = array();
    	if( $this->request->isPost() ) {
    		if( !empty( $this->request->data['Usuario']['texto'] ) ) {
    			$cond = array_merge( $cond, array( 'OR' =>
    							array( '`Usuario`.`nombre` LIKE' => '%'.$this->request->data['Usuario']['texto'].'%',
    							       '`Usuario`.`apellido` LIKE' => '%'.$this->request->data['Usuario']['texto'].'%' ) ) );
				$this->set( 'texto',  $this->request->data['Usuario']['texto'] );
    		}
			$cond['grupo_id'] = 4;
			if( !empty(  $this->request->data['Usuario']['obra_social'] ) ) {
				$cond = array_merge( $cond, array( 'obra_social_id' => $this->request->data['Usuario']['obra_social'] ) );
				$this->set( 'obra_social',  $this->request->data['Usuario']['obra_social'] );
			}
    	}
    	$this->set( 'usuarios', $this->paginate( 'Usuario', $cond ) );
		$this->set( 'obrassociales', $this->Usuario->ObraSocial->find( 'list' ) );
    }

   /*!
	* Metodo para agregar un nuevo usuario
    */
	public function add() {
		if ($this->request->is('post')) {
			$this->Usuario->create();
			if ($this->Usuario->save($this->request->data)) {
				$this->Session->setFlash('El usuario se agregó correctamente' );
				$this->borrarCacheUsuarios();
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash( 'Los datos del usuario no se pudieron guardar. Por favor, intentelo nuevamente.' );

			}
		}
		$this->set( 'grupos', $this->Usuario->Grupo->find( 'list' ) );
		$this->set( 'obras_sociales', $this->Usuario->ObraSocial->find( 'list' ) );
		$this->set( 'dominio', $_SERVER['SERVER_NAME'] );
	}

	/*!
	 *  Metodo de login de usuario para la administracion
	 *
	 * @return void
	 */
	public function administracion_ingresaradmin() {
		$this->layout='adminlogin';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect( '/administracion/usuarios/cpanel' );
			} else {
				//echo AuthComponent::password( $this->request->data['Usuario']['contra'] );
				$this->Session->setFlash( 'El email ingresado o la contraseña son incorrectas', 'default', array(), 'auth');
			}
		}
	}

	/**
	 * Metodo de salir de login de usuario para la administracion
	 *
	 * @return void
	 */
	public function administracion_salir() {
		$this->redirect( $this->Auth->logout() );
	}

	public function salir() {
		$this->redirect( $this->Auth->logout() );
	}

	/**
	 * Metodo recuperar la contraseña
	 *
	 * @return void
	 */
	public function recuperarContra() {
		if( $this->request->isPost() ) {
			if( !empty( $this->request->data['Recuperar']['email'] ) ) {
				if( !$this->Usuario->verificarSiExiste( $this->request->data['Recuperar']['email'] ) ) {
					$this->Session->setFlash( 'La casilla de email ingresada no existe en nuestro sistema. Por favor, registrese en nuestro sitio.');
				} else {
					$nueva_contra = $this->Usuario->generarNuevaContraseñarray( $this->request->data['Recuperar']['email'] );
					if( $nueva_contra != false ) {
						// Envio el email explicandolo
						$de = Configure::read( 'Turnera.email' );
						if( is_array( $de ) ) { $de = $de[0]; }
						$email = new CakeEmail();
						$email->template( 'recuperaContra', 'usuario' );
						$email->emailFormat( 'both' );
						$email->to( $this->request->data['Recuperar']['email'] );
						$email->viewVars( array( 'email' => $this->request->data['Recuperar']['email'], 'contra' => $nueva_contra ) );
						$email->subject( 'Su nueva contraseña' );
						$email->from( $de );
						$email->send();
						if( $this->Auth->loggedIn() ) {
							$this->Session->setFlash( 'Se envió una nueva contraseña de ingreso al usuario' );
							$this->redirect( array( 'action' => 'index' ) );
						} else {
							$this->Session->setFlash( 'Se ha enviado un mensaje con su nueva contraseña.<br />Por favor, revise su casilla de correo para obtener los datos y así poder ingresar al sistema.' );
							$this->redirect( array( 'action' => 'ingresar' ) );
						}
					} else {
						$this->Session->setFlash( 'No se pudo generar una nueva contraseña.');
					}
				}
			} else {
				$this->Session->setFlash( 'Por favor, ingrese una dirección de correo electronico para solicitar su nueva contraseña.');
			}
		}
		$this->set( 'dominio', $_SERVER['SERVER_NAME'] );
	}

	/**
	 * Metodo para mostrar el formulario de registración y agregar nuevos usuarios
	 *
	 */
	public function registrarse() {
		if ( $this->request->is('post') ) {
			// Verifico que las contraseñas coincidan
			if( empty( $this->request->data['Usuario']['contra'] ) || empty( $this->request->data['Usuario']['contrarep'] ) ) {
				$this->Session->setFlash( 'Por favor, ingrese una contraseña' );
			} else {
				if( $this->request->data['Usuario']['contra'] != $this->request->data['Usuario']['contrarep'] ) {
					$this->Session->setFlash( 'Las contraseñas no coinciden' );
				} else {
					// Busco si el email no existe ya
					if( $this->Usuario->verificarSiExiste( $this->request->data['Usuario']['email'] ) ) {
						$this->Session->setFlash( "Ya existe una cuenta con este usuario y contraseña.<br \> Recupere su contraseña para usarla" );
						$this->redirect( array( 'action' => 'recuperarContra' ) );
					}
					$this->Usuario->create();
					if ( $this->Usuario->save( $this->request->data ) ) {
						$id = $this->Usuario->id;
						$this->request->data['Usuario'] = array_merge( $this->request->data['Usuario'], array( 'id' => $id ) );
						if( $this->Auth->login() ) {
							$this->borrarCacheUsuarios();
							$this->Session->setFlash( "Bienvenido! - Su usuario ha sido creado correctamente." );
							$de = Configure::read( 'Turnera.email_notificaciones' );
							if( empty( $de )  ) { $de = 'info@alejandrotalin.com.ar'; }
							// Crear email de bienvenida!
							$email = new CakeEmail();
							$email->template( 'bienvenida', 'usuario' )
							->emailFormat( 'both' )
							->from( $de )
							->to( $this->request->data['Usuario']['email'] )
							->viewVars( array( 'usuario' => $this->request->data['Usuario'] ) )
							->subject( 'Bienvenido al sistema de turnos' )
							->send();
							// Hago que el usuario se logee directamente
							$this->redirect( array( 'controller' => 'turnos', 'action' => 'nuevo' ) );
						} else {
							$this->Session->setFlash( "Bienvenido! - Su usuario ha sido creado correctamente.<br />Por favor, ingrese con sus datos recien creados para utilizar el sistema." );
							$this->redirect( '/' );
						}
					} else {
						$this->Session->setFlash( 'El Usuario no pude ser guardado. Por favor, intente nuevamente.' );
					}
				}
			}
		}
		//$this->set( 'grupos', $this->Usuario->Grupo->find( 'list' ) );
		$this->set( 'obras_sociales', $this->Usuario->ObraSocial->find( 'list' ) );
		$this->set( 'dominio', $_SERVER['SERVER_NAME'] );
	}

   /*!
    * Funcion llamada cuando un usuario desea dar de baja su cuenta.
    */
	public function eliminarUsuario()
	{
		if( $this->request->isPost() ) {
			if( empty( $this->request->data['Usuario']['email'] ) ) {
				$this->Session->setFlash( 'El correo electronico no puede estar vacío' );
			} else {
				if( ! $this->Usuario->verificarSiExiste( $this->request->data['Usuario']['email'] ) ) {
					$this->Session->setFlash( 'El correo electronico ingresado no pertenece a ningún usuario registrado' );
				} else {
					// Elimino los turnos que tenga asociados
					$id = $this->Usuario->find( 'first', array( 'conditions' => array( 'email' => $this->request->data['Usuario']['email'] ), 'fields' => array( 'id_usuario' ) ) );
					$id = $id['Usuario']['id_usuario'];
					$this->loadModel( 'Turno' );
					if( ! $this->Turno->eliminarTurnosUsuario( $id ) ) {
						$this->Session->setFlash( 'Existió un error al eliminar los turnos asociados con este usuario' );
					} else {
						if( $this->Usuario->delete( $id ) ) {
							$this->log( 'Usuario de id='.$id.' fue dado de baja' );
							$this->log( 'Razon de baja:'.$this->request->data['Usuario']['razon'] );
							$this->Session->setFlash( 'El usuario fue dado de baja correctamente.<br />Gracias por haber utilizado nuestros servicios!' );
							$this->borrarCacheUsuarios();
							$this->redirect( '/' );
						} else {
							$this->Session->setFlash( 'Existió un error al dar de baja el usuario' );
						}
					}
				}
			}
		}
	}


	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view( $id = null ) {
		if( $id == null ) {
			$id = $this->Auth->user( 'id_usuario' );
		}
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			die( "El USUARIO NO EXISTE!" );
			throw new NotFoundException( 'El usuario no es valido' );
		}
		$usuario = $this->Usuario->read( null, $id );
		if( $usuario['Usuario']['celular'] == '' && $usuario['Usuario']['telefono'] == '' ) {
			$this->Session->setFlash( 'Por favor, ingrese algún número telefónico para que nos podamos poner en contacto con usted.', 'flash/info' );
		} else if( $usuario['Usuario']['celular'] == '' ) {
			$this->Session->setFlash( 'Por favor, ingrese un número de celular para que pueda recibir notificaciones por mensaje de texto', 'flash/info' );
		}
		$this->set( 'usuario', $this->Usuario->read( null, $id ) );
	}

	/*!
	 * Metodo par ver los datos por medio del medico
	 *
	 * @param int $id
	 * @return void
	 */
	public function verPorMedico( $id = null ) {
		if( $id == null ) {
			throw new NotFoundException( 'El usuario no existe' );
		}
		$this->Usuario->id = $id;
		if( ! $this->Usuario->exists() ) {
			throw new NotFoundException( 'El usuario no es valido' );
		}
		$this->set( 'usuario', $this->Usuario->read( null, $id ) );
		$this->loadModel( 'Turno' );
		$this->set( 'turnos', $this->Turno->turnosReservados( $id ) );
		$this->set( 'turnosanteriores', $this->Turno->turnosAnteriores( $id ) );
	}

	/*!
	 * Metodo par ver los datos por medio del medico
	 *
	 * @param int $id
	 * @return void
	 */
	public function verPorSecretaria( $id = null ) {
		if( $id == null ) {
			throw new NotFoundException( 'El usuario no existe' );
		}
		$this->Usuario->id = $id;
		if( ! $this->Usuario->exists() ) {
			throw new NotFoundException( 'El usuario no es valido' );
		}
		$this->set( 'usuario', $this->Usuario->read( null, $id ) );
		$this->loadModel( 'Turno' );
		$this->set( 'turnos', $this->Turno->turnosReservados( $id ) );
		$this->set( 'turnosanteriores', $this->Turno->turnosAnteriores( $id ) );
	}


	/**
	 * Metodo para que un usuario pueda modificar sus datos
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException( 'El usuario no es válido' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Usuario->save($this->request->data)) {
				$this->Session->setFlash( 'Sus datos fueron modificados correctamente' );
				$this->borrarCacheUsuarios();
				$this->redirect( array( 'action' => 'view' ) );
			} else {
				$this->Session->setFlash(__('The usuario could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Usuario->read (null, $id );
			$this->set( 'grupos', $this->Usuario->Grupo->find( 'list' ) );
			$this->set( 'obras_sociales', $this->Usuario->ObraSocial->find( 'list' ) );
		}
	}

	/**
	 * Metodo para darse de baja como usuario. Punto importante.
	 *
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException( 'El usuario no es valido' );
		}
		// Veo si si es un medico
		$this->loadModel( 'Medico' );
		if( $this->Medico->find( 'count', array( 'conditions' => array( 'usuario_id' => $id ) ) ) > 0 ) {
			$this->Session->setFlash( "No se pudo eliminar el usuario solicitado. \n <b>Razon:</b> El usuario tiene un medico asociado" );
			$this->redirect( array( 'action' => 'index' ) );
		}
		// Veo si es una secretaria
		$this->loadModel( 'Secretaria' );
		if( $this->Secretaria->find( 'count', array( 'conditions' => array( 'usuario_id' => $id ) ) ) > 0 ) {
			$this->Session->setFlash( "No se pudo eliminar el usuario solicitado. <br /><b>Razon:</b> El usuario tiene una secretaria asociada" );
			$this->redirect( array( 'action' => 'index' ) );
		}
		// Verifico si tiene alguna relación con Turnos.
		$this->loadModel( 'Turno' );
		if( $this->Turno->find( 'count', array( 'conditions' => array( 'paciente_id' => $id ) ) ) > 0 ) {
			$this->Session->setFlash( "No se pudo eliminar el usuario solicitado. <br /><b>Razon:</b> El usuario tiene turnos asociados todavía." );
			$this->redirect( array( 'action' => 'index'  ) );
		}
		if( $this->Usuario->delete() ) {
			$this->borrarCacheUsuarios();
			$this->Session->setFlash( 'El Usuario ha sido eliminado correctamente' );
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash( __('Usuario was not deleted') );
		$this->redirect(array('action' => 'index'));
	}

   /**
    * Función para cambiar la contraseña
    * @param string $id_usuario Identificador de usuario
    */
	public function cambiarContra( $id_usuario = null ) {
		if( $this->request->is( 'post' ) ) {
			if( $this->request->data['Usuario']['contra'] != $this->request->data['Usuario']['recontra'] ) {
				$this->Session->setFlash( "Las contraseñas no coinciden." );
			} else if( AuthComponent::password( $this->request->data['Usuario']['anterior'] ) != $this->Auth->user( 'contra' ) ) {
				$this->Session->setFlash( "La contraseña actual no coincide" );
			} else {
				if( $this->Usuario->save( $this->request->data, false ) ) {
					$this->Session->setFlash( "Contraseña cambiada correctamente" );
					$this->redirect( array( 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( "No se pudo cambiar la contraseña" );
					pr( $this->Usuario->invalidFields() );
				}
			}
		}
		if( $id_usuario == null ) {
			// Cargo el usuario actual
			$id_usuario = $this->Auth->user( 'id_usuario' );
		}
		$this->Usuario->id = $id_usuario;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException( 'El usuario no es valido' );
		}
		$this->set( 'data', $this->Usuario->read() );
	}

	/**
	 * Metodo para mostrar el panel de control de la administración
	 * @return void
	 */
	public function administracion_cpanel() {}

	/**
	 * Listado de usuarios de la administración.
	 *
	 * @return void
	 */
	public function administracion_index() {
		$this->Usuario->recursive = 0;
		$this->set( 'usuarios', $this->paginate() );
	}

	/**
	 * administracion_view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function administracion_view($id = null) {
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException( 'Usuario invalido' );
		}
		$this->set('usuario', $this->Usuario->read(null, $id));
	}

	/**
	 * administracion_add method
	 *
	 * @return void
	 */
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Usuario->create();
			if ($this->Usuario->save($this->request->data)) {
				$this->borrarCacheUsuarios();
				$this->Session->setFlash('El usuario se agregó correctamente' );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash( 'Los datos del usuario no se pudieron guardar. Por favor, intentelo nuevamente.' );

			}
		}
		$this->set( 'grupos', $this->Usuario->Grupo->find( 'list' ) );
		$this->set( 'obras_sociales', $this->Usuario->ObraSocial->find( 'list' ) );
	}

	/**
	 * administracion_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function administracion_edit($id = null) {
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException( 'Usuario invalido' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Usuario->save($this->request->data)) {
				$this->Session->setFlash( 'Los datos del usuario se modificaron correctamente' );
				$this->borrarCacheUsuarios();
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash( 'Los datos del usuario no pudieron ser guardados correctamente. Por favor intente nuevamente.' );
			}
		} else {
			$this->request->data = $this->Usuario->read(null, $id);
			$this->set( 'grupos', $this->Usuario->Grupo->find( 'list' ) );
			$this->set( 'obras_sociales', $this->Usuario->ObraSocial->find( 'list' ) );
		}
	}

	/**
	 * administracion_delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function administracion_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException( 'El usuario no es valido' );
		}
		$this->loadModel( 'Turno' );
		if( $this->Turno->find( 'count', array( 'conditions' => array( 'paciente_id' => $id ) ) ) > 0 ) {
			$this->Session->setFlash( "No se pudo eliminar el usuario solicitado. \n <b>Razón:</b> El usuario tiene turnos asociados todavía." );
			$this->redirect( array( 'action' => 'index'  ) );
		}
		$this->loadModel( 'Medico' );
		if( $this->Medico->find( 'count', array( 'conditions' => array( 'usuario_id' => $id ) ) ) > 0 ) {
			$this->Session->setFlash( "No se pudo eliminar el usuario solicitado. \n <b>Razón:</b> El usuario tiene un medico asociado" );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->loadModel( 'Secretaria' );
		if( $this->Secretaria->find( 'count', array( 'conditions' => array( 'usuario_id' => $id ) ) ) > 0 ) {
			$this->Session->setFlash( "No se pudo eliminar el usuario solicitado. \n <b>Razón:</b> El usuario tiene una secretaria asociada" );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if( $this->Usuario->delete() ) {
			$this->borrarCacheUsuarios();
			$this->Session->setFlash( 'El Usuario ha sido eliminado correctamente' );
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash( __('Usuario was not deleted') );
		$this->redirect(array('action' => 'index'));
	}

   /**
    * Función para cambiar la contraseña
    * @param string $id_usuario Identificador de usuario
    */
	public function administracion_cambiarContra( $id_usuario = null ) {
		if( $this->request->is( 'post' ) ) {
			if( $this->request->data['Usuario']['contra'] != $this->request->data['Usuario']['recontra'] ) {
				$this->Session->setFlash( "Las contraseñas no coinciden." );
			} else {
				if( $this->Usuario->save( $this->request->data, false ) ) {
					$this->Session->setFlash( "Contraseña cambiada correctamente" );
					$this->redirect( array( 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( "No se pudo cambiar la contraseña" );
					pr( $this->Usuario->invalidFields() );
				}
			}
		}
		$this->Usuario->id = $id_usuario;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException( 'El usuario no es valido' );
		}
		$this->set( 'data', $this->Usuario->read() );
	}

   /**
    * Funcion pra dar de alta cuando se intenta reservar un turno
    * @param integer $id_turno Identificador del turno
    */
	public function altaTurno( $id_turno = null, $id_medico = null, $secretaria = true, $nombre = null, $accion = null ) {
		if( $this->request->isPost() ) {
			if( $this->Usuario->verificarSiExiste( $this->request->data['Usuario']['email'] ) ) {
				$this->Session->setFlash( 'El email proporcionado ya está registrado en el sistema.');
			} else {
				$this->Usuario->create();
				if ( $this->Usuario->save( $this->request->data ) ) {
					$this->borrarCacheUsuarios();
					$this->Session->setFlash('El usuario se agregó correctamente' );
					$id_turno = $this->request->data['Usuario']['id_turno'];
					$id_medico = $this->request->data['Usuario']['id_medico'];
					$id_usuario = $this->Usuario->id;
					$this->request->data['Usuario'] = array_merge( $this->request->data['Usuario'], array( 'id' => $id_usuario ) );
					$de = Configure::read( 'Turnera.email_notificaciones' );
					if( empty( $de )  ) { $de = 'info@alejandrotalin.com.ar'; }
					// Crear email de bienvenida!
					$email = new CakeEmail();
					$email->template( 'bienvenida', 'usuario' )
					->emailFormat( 'both' )
					->from( $de )
					->to( $this->request->data['Usuario']['email'] )
					->viewVars( array( 'usuario' => $this->request->data['Usuario'] ) )
					->subject( 'Bienvenido al sistema de turnos' )
					->send();
					if( $secretaria ) {
						$this->redirect( array( 'controller' => 'secretarias', 'action' => $accion, $id_turno, $id_usuario, $id_medico ) );
					} else {
						$this->redirect( array( 'controller' => 'medicos', 'action' => $accion, $id_turno, $id_usuario, $id_medico ) );
					}
				} else {
					$this->Session->setFlash( 'Los datos del usuario no se pudieron guardar. Por favor, intentelo nuevamente.' );
				}
			}
		}
		$this->set( 'id_turno', $id_turno );
		$this->set( 'id_medico', $id_medico );
		$this->set( 'secretaria', $secretaria );
		$this->set( 'nombre', $nombre );
		$this->set( 'dominio', $_SERVER['SERVER_NAME'] );
		$this->set( 'obras_sociales', $this->Usuario->ObraSocial->find( 'list' ) );
	}

	function borrarCacheUsuarios() {
		// Busco todos los archivos que sean paciente* en el directorio de cache
		$f = new Folder( APP . 'tmp' . DS . 'cache', false );
		$claves = $f->find( ".*paciente.*" );
		foreach( $claves as $clave ) {
			// Elimino el "cake_" que tiene delante
			Cache::delete( substr( $clave, 5 ) );
		}
		Cache::gc();
	}

    /**
	 * Muestra el listado de turnos del paciente para el médico
	 *
	 * @param usuario_id integer Identificación del usuario buscado
	 * @throws NotFoundException Si el usuario no existe
	 */
	public function historico( $usuario_id ) {
		$this->Usuario->id = $usuario_id;
		if( !$this->Usuario->exists() ) {
			throw new NotFoundException( "El usuario no existe" );
		}
		$this->loadModel( 'Turnos' );
		$this->set( 'usuario', $this->Usuario->read() );
		$this->set( 'turnos', $this->Turnos->buscarHistoricoUsuario( $usuario_id ) );
	}
}