<?php
App::uses('AppController', 'Controller');
/**
 * Secretarias Controller
 *
 * @property Secretaria $Secretaria
 */
class SecretariasController extends AppController {

	private $dia;
	private $mes;
	private $ano;

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
					case 'sobreturno':
					case 'recibido':
					case 'cancelar':
					case 'reservar':
					case 'atendido':
					case 'resumen':
					{
						$this->verificarDia();
						$this->loadModel('Turno');
						return true; 
						break;
					}
				}
			}
		}
		return false;
	}

   /**
    * Mantiene el día en que debe ser mostrados los turnos
    * guardandolos en las variables de sesion 
    */
	function verificarDia() {
		if( !$this->Session->check( "Secretaria.dia" ) ) {
			$this->Session->write( "Secretaria.dia", date( 'j' ) );
			$this->Session->write( "Secretaria.mes", date( 'n' ) );
			$this->Session->write( "Secretaria.ano", date( 'Y' ) );
		}
		$this->dia = $this->Session->read( "Secretaria.dia" );
		$this->mes = $this->Session->read( "Secretaria.mes" );
		$this->ano = $this->Session->read( "Secretaria.ano" );
		$this->set( 'actualizacion', $this->Session->read( 'actualizacion' ) );
	}
	
	function cambiarDia( $dia, $mes, $ano ) {
		if( $this->Session->read( "Secretaria.dia" ) != $dia ) {
			$this->Session->write( "Secretaria.dia", $dia );
		}
		if( $this->Session->read( "Secretaria.mes" ) != $mes ) {
			$this->Session->write( "Secretaria.mes", $mes );
		}
		if( $this->Session->read( "Secretaria.ano" ) != $ano ) {
			$this->Session->write( "Secretaria.ano", $ano );
		}
		$this->dia = $dia;
		$this->mes = $mes;
		$this->ano = $ano;		
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
			if( isset( $this->data['Secretarias']['actualizacion'] ) ) {
				$this->Session->write( "actualizacion", $this->data['Secretarias']['actualizacion'] );
				$this->set( 'actualizacion', $this->data['Secretarias']['actualizacion'] );
				if( $this->data['Secretarias']['actualizacion'] == 'true' ) {
					$accion = " habilitada ";
				} else { $accion = " deshabilitada"; }
				$this->Session->setFlash( 'Auto actualización de la página ha sido' . $accion );
			} else {
				$this->data = $this->data['Secretaria'];
				// Busco la fecha e que me pasaron
				if( isset( $this->data['accion'] ) ) {
					$t = new DateTime('now'); $t->setDate( $this->ano, $this->mes, $this->dia );
					$t2 = clone $t;
					if( $this->data['accion'] == 'ayer' ) {
						$t2 = $t->sub( new DateInterval( "P1D" ) );
					} else if( $this->data['accion'] == 'manana' ) {
						$t2 = $t->add( new DateInterval( "P1D" ) );
					} else  if( $this->data['accion'] == 'mes' ) {
						$t2 = $t->add( new DateInterval( "P1M" ) );
					} else if( $this->data['accion'] == 'sem' ) {
						$t2 = $t->add( new DateInterval( "P1W" ) );
					}
					// Actualizo la fecha
					$this->cambiarDia( $t2->format( "j" ), $t2->format( "n" ), $t2->format( "Y" ) );
				} else {
					$this->cambiarDia( $this->data['fecha']['day'],
									   $this->data['fecha']['month']+1,
									   $this->data['fecha']['year'] );				
				}
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
		$f1->setDate( $this->ano, $this->mes, $this->dia ); $f1->setTime( 0, 0, 0 );
		$f2 = clone $f1; $f2->add( new DateInterval( "P1D" ) );
		foreach( $cons as $c ) {
			$c['Turnos'] = $this->Turno->find( 'all', array( 'conditions' => array( 'consultorio_id' => $c['Consultorio']['id_consultorio'],
												'DATE( fecha_inicio ) >=' =>  $f1->format( 'Y-m-d' ),
												'DATE( fecha_fin ) <' => $f2->format( 'Y-m-d' ) ),
												'order' => 'fecha_inicio',
									 			'limit' => 80 ) );
			$nuevo[] = $c;
		}
		$this->set( 'consultorios', $nuevo );
	}

   /**
    * Mantiene el día en que debe ser mostrados los turnos
    * 
    */
	public function sobreturno( $id_turno = null, $id_paciente = null, $id_medico = null ) {
		if( $this->request->isPost() ) {
			$this->data = $this->data['Turno'];
			
			$id_turno    = $this->data['id_turno'];
			$id_paciente = $this->data['spaciente'];
			$id_medico   = $this->data['id_medico'];
			$hora        = $this->data['hora'];
			$min         = $this->data['min'];
			$duracion    = $this->data['duracion'];
		} else {
			// Si entro por aquí, tuve que dar de alta el paciente.
			if( $id_turno == null || $id_paciente == null || $id_medico == null ) {
				throw new NotFoundException( "Error de parametros" );
			}
			$id_medico = $this->Session->read( 'st.medico' );
			$hora = $this->Session->read( 'st.hora' );
			$min = $this->Session->read( 'st.min' );
			$duracion = $this->Session->read( 'st.duracion' );
			$this->Session->delete( 'st' );
		}
		
		$this->Turno->id = $id_turno;
		if( ! $this->Turno->exists() ) {
			throw new NotFoundException( 'El turno no existe, '.$id_turno );
		}
		$this->Turno->Paciente->virtualFields = '';
		$this->Turno->unbindModel( array( 'belongsTo' => array( 'Consultorio', 'Medico', 'Paciente' ) ) );
		$turno = $this->Turno->read();

		$this->Turno->Paciente->id = $id_paciente;
		if( ! $this->Turno->Paciente->exists() ) {
			$this->Session->setFlash( 'El Usuario seleccionado no existe, por favor, ingrese sus datos para darlo de alta.' );
			$this->Session->write( array( 'st.medico' => $id_medico, 'st.hora' => $hora, 'st.min' => $min, 'st.duracion' => $duracion ) );
			$this->redirect( array( 'controller' => 'usuarios', 'action' => 'altaTurno', $id_turno, $id_medico, true, $this->data['spaciente'], 'sobreturno' ) );
		}

		$this->Turno->Medico->id = $id_medico;
		if( ! $this->Turno->Medico->exists() ) {
			throw new NotFoundException( 'El medico no existe, '.$id_medico );
		}
		$this->Turno->Medico->unbindModel( array( 'hasMany' => array( 'Turno', 'Excepcion' ) ) );
		$this->Turno->Medico->unbindModel( array( 'belongsTo' => array( 'Especialidad', 'Clinica', 'Usuario' ) ) );
		$medico = $this->Turno->Medico->read();

		// Cargo la cantidad de horas configuradas en el sistema
		$tiempo = Configure::read( 'Turnera.notificaciones.horas_proximo' );
		if( $duracion == null ) {
			$duracion = $medico['Disponibilidad']['duracion'];
		}

		// Genero el sobreturno
		$finicio = DateTime::createFromFormat( 'Y-m-d H:i:s', $turno['Turno']['fecha_inicio'] );
		$finicio->setTime( $hora, $min, 0 );
		$ffin = clone $finicio;
		$ffin->add( new DateInterval( "PT".$duracion."M" ) );
		$data = array(  'Turno' =>
				array(	'fecha_inicio'   => $finicio->format( 'Y-m-d H:i:s' ),
						'fecha_fin'      => $ffin->format( 'Y-m-d H:i:s' ),
						'medico_id'      => $id_medico,
						'consultorio_id' => $turno['Turno']['consultorio_id'],
						'paciente_id'    => $id_paciente,
						'recibido'       => true,
						'atendido'       => false,
						'cancelado'	     => false
				)
			);
		$this->Turno->create();
		if( $this->Turno->save( $data ) ) {
			$this->Session->setFlash( 'Sobre turno creado correctamente' );
		} else {
			$this->Session->setFlash( 'No se pudo generar el sobreturno' );
			pr( $this->Turno->validationErrors );
			die();
		}
		$this->redirect( array( 'action' => 'turnos' ) );
	}

   /**
    * Mantiene el día en que debe ser mostrados los turnos
    * 
    */
	public function recibido( $id_turno = null ) {
		
		$this->Turno->id = $id_turno;
		if( ! $this->Turno->exists() ) {
			throw new NotFoundException( 'El turno no existe, '.$id_turno );
		}
		$this->Turno->set( 'recibido', true );
		if( $this->Turno->save() ) {
			$this->Session->setFlash( 'El turno ha sido colocado como recibido' );
		} else {
			$this->Session->setFlash( 'No se pudo colocar el turno como recibido' );
		}
		$this->redirect( array( 'action' => 'turnos' ) );
	}

   /**
    * Mantiene el día en que debe ser mostrados los turnos
    * 
    */
	public function cancelar( $id_turno = null ) {
		
		if( $id_turno == null ) {
			$id_turno = $this->data['Secretaria']['id_turno'];
		} else {
			// Se coloca esto ya que solo cancelamos desde la vista de los turnos del paciente
			$this->data = array( 'Secretaria' => array( 'quien' => 'p' ) );
		}

		if( $this->data['Secretaria']['quien'] == "m" ){
			
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
		} else if( $this->data['Secretaria']['quien'] == "p" ) {
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
			pr( $this->data );
			die();
			$this->Session->setFlash( 'No se supo quien canceló el turno, por lo tanto se conservó intacto' );
		}
	    $this->redirect( array( 'action' => 'turnos' ) );
	}
	
   /**
    * Reserva el turno correspondiente
    * 
    */
	public function reservar( $id_turno = null, $id_paciente = null, $id_medico = null ) {
		if( $this->request->isPost() ) {
			$this->data = $this->data['Turno'];
			$id_turno = $this->data['id_turno'];
			$id_paciente = $this->data['rpaciente'];
			$id_medico = $this->data['id_medico'];
			// Divido el codigo del paciente
			$tmp = split( "-", $id_paciente );
			$id_paciente = $tmp[0];
		} else {
			// Si entro por aquí, tuve que dar de alta el paciente.
			if( $id_turno == null || $id_paciente == null || $id_medico == null ) {
				throw new NotFoundException( "Error de parametros" );
			}
		}
		
		$this->Turno->id = $id_turno;
		if (!$this->Turno->exists()) {
			throw new NotFoundException( 'El turno solicitado no existe'.$id_turno );
		}
		$this->Turno->unbindModel( array( 'belongsTo' => array( 'Paciente' ) ) );
		$turno = $this->Turno->read();

		$this->loadModel( 'Usuario' );
		$this->Usuario->id = $id_paciente;
		if( !$this->Usuario->exists() ) {
			$this->Session->setFlash( 'El Usuario seleccionado no existe, por favor, ingrese sus datos para darlo de alta.' );
			$this->redirect( array( 'controller' => 'usuarios', 'action' => 'altaTurno', $id_turno, $id_medico, true, $this->data['rpaciente'], 'reservar' ) );
		}

		// No verifico la  restricción de cantidad de turnos x día
		// Cargo la cantidad de horas configuradas en el sistema
		$tiempo = Configure::read( 'Turnera.notificaciones.horas_proximo' );

		$this->Usuario->recursive = -1;
		$usuario = $this->Usuario->read();

		$turno['Medico'] = $this->Usuario->read( null, $turno['Medico']['usuario_id'] );

		$error = '';
		if( $this->Turno->reservar( $id_turno, $id_paciente, $error )  ) {
			$this->requestAction( array( 'controller' => 'avisos', 'action' => 'agregarAvisoNuevoTurno', 'id_turno' => $id_turno, 'id_paciente' => $id_paciente ) );
			$this->Session->setFlash('El turno se reservó correctamente');
		} else {
			$this->Session->setFlash( " Existió un error al intentar reservar el turno.\n Error:".$error );
		}
		$this->redirect( array( 'action' => 'turnos' ) );
	}

   /**
    * Mantiene el día en que debe ser mostrados los turnos
    * 
    */
	public function atendido( $id_turno = null ) {

		$this->Turno->id = $id_turno;
		if( ! $this->Turno->exists() ) {
			throw new NotFoundException( 'El turno no existe, '.$id_turno );
		}
		$this->Turno->set( 'recibido', true );
		$this->Turno->set( 'atendido', true );
		if( $this->Turno->save() ) {
			$this->Session->setFlash( 'El turno ha sido colocado como atendido' );
		} else {
			$this->Session->setFlash( 'No se pudo colocar el turno como atendido' );
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
			if( $this->data['Secretaria']['resumen'] ) {
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
		$this->Secretaria->recursive = 1;
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
				$this->Session->setFlash( 'La secretaria fue agregada correctamente' );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash(__('The secretaria could not be saved. Please, try again.'));
			}
		}
		$ids = $this->Secretaria->find( 'list', array( 'fields' => array( 'usuario_id' ) ) );
		$usuarios = $this->Secretaria->Usuario->find('list', array( 'conditions' => array( 'grupo_id' => 3, 'NOT' => array( 'id_usuario' => $ids ) ), 'fields' => array( 'razonsocial' ) ) );
		if( count( $usuarios ) <= 0 ) {
			$this->Session->setFlash( 'No existen usuarios del grupo secretarias que no esten declarados ya como secretarias.<br />Si desea agregar una nueva secretaria, cree un nuevo usuario dentro del grupo secretarias.' );
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
				$this->Session->setFlash( 'La secretaria ha sido guardada correctamente' );
				$this->redirect( array('action' => 'index' ) );
			} else {
				$this->Session->setFlash( 'Los datos de la secretaria no pudieron ser guardados. Por favor, intente nuevamente.'  );
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
			$this->Session->setFlash( 'La secretaria fue eliminada correctamente' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->setFlash( 'La secretaria no fue eliminada' );
		$this->redirect( array( 'action' => 'index' ) );
	}
}
