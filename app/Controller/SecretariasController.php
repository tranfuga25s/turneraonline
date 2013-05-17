<?php
App::uses('AppController', 'Controller');
/**
 * Secretarias Controller
 *
 * @property Secretaria $Secretaria
 */
class SecretariasController extends AppController {

    public $helpers = array( 'Html', 'Form', 'Paginator', 'Js' => array( 'Jquery' ) );
    public $components = array( 'RequestHandler', 'AutoUpdateRecall', 'DiaTurnoRecall' => array( 'variable' => 'Secretaria' ) );
    public $uses = array( 'Secretaria', 'Consultorio', 'Turno' );

	public function isAuthorized( $usuario = null ) {
		switch( $usuario['grupo_id'] ) {
			case 1: // Administradores
			{
				return true;
				break;
			}
			case 3: // Secretarias
			{
				switch( $this->request->params['action'] ) {
					case 'turnos':
					case 'cancelar':
					case 'resumen':
					{
						return true; 
						break;
					}
				}
			}
		}
		return false;
	}

   /**
    * Muestra los turnos del dia elegido
    * 
    */
	public function turnos() {
		// Datos basicos
		$id_usuario = $this->Auth->user( 'id_usuario' );
		$t = $this->Secretaria->find( 'first', array( 'conditions' => array( 'usuario_id' => $id_usuario ), 'fields' => array( 'id_secretaria' ) ) );
		$id_secretaria = $t['Secretaria']['id_secretaria'];

		// Veo que consultorios tiene a cargo
		$this->Secretaria->id = $id_secretaria;
		if(  ! $this->Secretaria->exists() ) {
			throw new NotFoundException( 'La secretaria no existe!' );
		}
		$clinicas = $this->Secretaria->find( 'list', array( 'conditions' => array( 'id_secretaria' => $id_secretaria ), 'fields' => array( 'clinica_id', 'clinica_id' ) ) );
		// Busco los consultorios de estas clinicas
		$this->loadModel( 'Consultorio' );
		$consultorios = $this->Consultorio->find( 'list', array( 'conditions' => array( 'clinica_id' => $clinicas ), 'fields' => array( 'id_consultorio' ) ) );
		
		if( $this->request->isPost() ) {
			$this->request->data = $this->request->data['Secretaria'];
			// Busco la fecha e que me pasaron
			if( isset( $this->request->data['accion'] ) ) {
				$t = new DateTime('now'); $t->setDate( $this->ano, $this->mes, $this->dia );
				$t2 = clone $t;
				if( $this->request->data['accion'] == 'ayer' ) {
					$t2 = $t->sub( new DateInterval( "P1D" ) );
				} else if( $this->request->data['accion'] == 'manana' ) {
					$t2 = $t->add( new DateInterval( "P1D" ) );
				} else  if( $this->request->data['accion'] == 'mes' ) {
					$t2 = $t->add( new DateInterval( "P1M" ) );
				} else if( $this->request->data['accion'] == 'sem' ) {
					$t2 = $t->add( new DateInterval( "P1W" ) );
				} else if( $this->request->data['accion'] == 'hoy' ) {
					$t2 = new DateTime( 'now' );
				}
				// Actualizo la fecha
				$this->DiaTurnoRecall->cambiarDia( $t2->format( "j" ), $t2->format( "n" ), $t2->format( "Y" ) );
			} else {
				$this->DiaTurnoRecall->cambiarDia( $this->data['fecha']['day'],
                                                   $this->data['fecha']['month']+1,
                                                   $this->data['fecha']['year'] );			
			}
		}
		// Lista de nombres de medicos
		$this->loadModel( 'Medico' );
		$this->set( 'medicos', $this->Medico->lista() );

		$this->set( 'fechas', $this->dia."/".$this->mes."/".$this->ano );
		$this->set( 'dia', $this->dia );
		$this->set( 'mes', $this->mes-1 ); // Lista de meses base 0 
		$this->set( 'ano', $this->ano ); 
		
		// Cargo todos los turnos del día x consultorio		
		$cons = $this->Consultorio->find( 'all', array( 'conditions' => array( 'id_consultorio' => $consultorios ),
										  'fields' => array( 'id_consultorio', 'nombre' ),
										  'recursive' => -1 ) );
		
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => ' CONCAT( Paciente.apellido, \', \', Paciente.nombre ) ' );
		$this->Turno->unbindModel( array( 'belongsTo' => array( 'Consultorio' ) ) );
		$nuevo = array();
		$f1 = new DateTime( 'now' );
		$f1->setDate( $this->DiaTurnoRecall->ano(), $this->DiaTurnoRecall->mes(), $this->DiaTurnoRecall->dia() ); $f1->setTime( 0, 0, 0 );
		$f2 = clone $f1; $f2->add( new DateInterval( "P1D" ) );
		foreach( $cons as $c ) {
			$c['Turnos'] = $this->Turno->find( 'all', array( 'conditions' => array( 'consultorio_id' => $c['Consultorio']['id_consultorio'],
												'DATE( fecha_inicio ) >=' =>  $f1->format( 'Y-m-d' ),
												'DATE( fecha_fin ) <' => $f2->format( 'Y-m-d' ) ),
												'order' => 'fecha_inicio',
									 			'limit' => 80 ) );
			$nuevo[] = $c;
		}
        //debug( $nuevo );
		$this->set( 'consultorios', $nuevo );
        $this->set( 'controller', $this->name );
	}

   /**
    * Mantiene el día en que debe ser mostrados los turnos
    * 
    */
	public function cancelar( $id_turno = null ) {
		
		if( $id_turno == null ) {
			$id_turno = $this->request->data['Secretaria']['id_turno'];
		} else {
			// Se coloca esto ya que solo cancelamos desde la vista de los turnos del paciente
			$this->request->data = array( 'Secretaria' => array( 'quien' => 'p' ) );
		}

		if( $this->request->data['Secretaria']['quien'] == "m" ){
			
			$ids = array();
			$ids[] = $id_turno;
			if( count( $ids ) > 0 ) {
			   	$correcto = $incorrecto = array();
			   	foreach( $ids as $id ) {
			   		$aviso = $this->Turno->reservado( $id );
			   		if( $this->Turno->cancelar( $id ) ) {
			   			if( $aviso ) {
			   				$this->requestAction( array( 'controller' => 'avisos', 'action' => 'agregarAvisoCancelacionTurno', $id ) );
							$this->loadModel( "Aviso" );
							$this->Aviso->cancelarAvisoNuevoTurno( $id );
						}
			   			$correcto[] = $id;
			   		} else {
			   			$incorrecto[]  = $id;
			   		}
			   	}
				if( count( $correcto ) ) {
					$mensaje = 'Se cancelaron correctamente '.count( $correcto ). ' turnos.<br />';
				}
				if( count( $incorrecto ) ) {
					$mensaje .= ". Los turnos ".explode( $incorrecto )." no se pudieron eliminar.";
				}
				$this->Session->setFlash($mensaje);
		   } else {
		   		$this->Session->setFlash( "No se canceló ningún turno" );
		   }
		} else if( $this->request->data['Secretaria']['quien'] == "p" ) {
			$this->Turno->id = $id_turno;
			if( $this->Turno->exists() ) {
				$this->Turno->set( 'paciente_id', null );
				$this->Turno->set( 'atendido', false );
				$this->Turno->set( 'recibido', false );
				if( $this->Turno->save() ) {
					$this->Session->setFlash( 'Turno liberado correctamente' );
				} else {
					$this->Session->setFlash( 'El turno no se pudo liberar' );
				}
			} else {
				$this->Session->setFlash( 'El turno no existe!' );
			}	
		} else {
			pr( $this->request->data );
			die();
			$this->Session->setFlash( 'No se supo quien canceló el turno, por lo tanto se conservó intacto' );
		}
	    $this->redirect( array( 'action' => 'turnos' ) );
	}
	
	/**
	 * 
	 */
	 public function resumen() {
	 	// muestro la opción para el resumen
	 	if( $this->request->isPost() ) {
	 		$id_usuario = $this->Auth->user( 'id_usuario' );
			$t = $this->Secretaria->find( 'first', array( 'conditions' => array( 'usuario_id' => $id_usuario ), 'fields' => array( 'id_secretaria' ) ) );
	 		$this->Secretaria->id = $t['Secretaria']['id_secretaria'];
			if( $this->request->data['Secretaria']['resumen'] ) {
				$accion = " habilitado  ";
				$estado = true;
			} else {
				$accion = " deshabilitado  ";
				$estado = false;
			}
			if( $this->Secretaria->saveField( 'resumen', $estado ) ) {
				$this->Session->setFlash( "Resumen diario ".$accion." correctamente." );
				$this->redirect( '/' );		
			} else {
				$this->Session->setFlash( "No se pudo guardar el cambio" );
			}
	 	} 
	 	$this->set( 'resumen', $this->Secretaria->field( 'resumen' ) );
		$this->set( 'id_secretaria', $this->Secretaria->field( 'id_secretaria' ) );
	 	
	 }
	/**
	 * administracion_index method
	 *
	 * @return void
	 */
	public function administracion_index() {
		//$this->Secretaria->recursive = 1;
		$this->set( 'secretarias', $this->paginate() );
	}

	/**
	 * administracion_index method
	 *
	 * @return void
	 */
	public function administracion_view( $id_secretaria = null ) {
		$this->Secretaria->id = $id_secretaria;
		$this->Secretaria->recursive = 2;
		$this->set( 'secretaria', $this->Secretaria->read() );
	}

	/**
	 * administracion_add method
	 *
	 * @return void
	 */
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Secretaria->create();
			if ($this->Secretaria->save($this->request->data)) {
				$this->Session->setFlash( 'La secretaria fue agregada correctamente', 'default', array( 'class' => 'success' ) );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash( 'Los datos no se pudieron guardar, intente nuevamente', 'default', array( 'class' => 'error' ) );
			}
		}
		$ids = $this->Secretaria->find( 'list', array( 'fields' => array( 'usuario_id' ) ) );
		$usuarios = $this->Secretaria->Usuario->find('list', array( 'conditions' => array( 'grupo_id' => 3, 'NOT' => array( 'id_usuario' => $ids ) ), 'fields' => array( 'razonsocial' ) ) );
		if( count( $usuarios ) <= 0 ) {
			$this->Session->setFlash( 'No existen usuarios del grupo secretarias que no esten declarados ya como secretarias.<br />Si desea agregar una nueva secretaria, cree un nuevo usuario dentro del grupo secretarias.' , 'default', array( 'class' => 'error' ) );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$clinicas = $this->Secretaria->Clinica->find('list');
		$this->set( compact( 'usuarios', 'clinicas' ) );
	}

/**
 * administracion_edit method
 *
 * @param string $id
 * @return void
 */
	public function administracion_edit($id = null) {
		$this->Secretaria->id = $id;
		if (!$this->Secretaria->exists()) {
			throw new NotFoundException( 'Secretaria invalida' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Secretaria->save($this->request->data)) {
				$this->Session->setFlash( 'La secretaria ha sido guardada correctamente', 'default', array( 'class' => 'success' ) );
				$this->redirect( array('action' => 'index' ) );
			} else {
				$this->Session->setFlash( 'Los datos de la secretaria no pudieron ser guardados. Por favor, intente nuevamente.' , 'default', array( 'class' => 'error' ) );
			}
		} else {
			$this->request->data = $this->Secretaria->read( null, $id );
		}
		$usuarios = $this->Secretaria->Usuario->find('list');
		$clinicas = $this->Secretaria->Clinica->find('list');
		$this->set( compact( 'usuarios', 'clinicas' ) );
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
		$this->Secretaria->id = $id;
		if (!$this->Secretaria->exists()) {
			throw new NotFoundException( 'Secretaria Invalida' );
		}
		if ($this->Secretaria->delete()) {
			$this->Session->setFlash( 'La secretaria fue eliminada correctamente', 'default', array( 'class' => 'success' ) );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->setFlash( 'La secretaria no fue eliminada' , 'default', array( 'class' => 'error' ) );
		$this->redirect( array( 'action' => 'index' ) );
	}
}
