<?php
App::uses('AppController', 'Controller');
/**
 * Medicos Controller
 *
 * @property Medico $Medico
 */
class MedicosController extends AppController {

	var $helpers = array( 'Html', 'Form', 'Paginator', 'Js' => array( 'Jquery' ) );
	var $components = array( 'RequestHandler' );
	var $uses = array( 'Medico', 'Consultorio', 'Turno' );
	
	
	private $dia;
	private $mes;
	private $ano;
	
	public function beforeFilter() {
		$this->Auth->allow( array( 'view' ) );
        parent::beforeFilter();
	}

	public function isAuthorized( $usuario = null ) {
		switch( $usuario['grupo_id'] ) {
			case 1: // Administradores
			{
				return true;
				break;
			}
			case 2: // Medicos
			{
				switch( $this->request->params['action'] ) {
					case 'turnos':
					case 'sobreturno':
					case 'recibido':
					case 'cancelar':
					case 'reservar':
					case 'atendido':
					{
						$this->verificarDia();
						$this->loadModel('Turno');
						return true; 
						break;
					}
					case 'verExcepciones':
					case 'disponibilidad':
					{
						return true;
						break;
					}
				}
				break;
			}
			case 4: // Paciente
			{
				switch( $this->request->params['action'] ) {
					case 'view':
					{
						return true;
						break;
					}
				}
				break;
			}
		}
		return false;
	}

   /**
    * Mantiene el día en que debe ser mostrados los turnos
    * guardandolos en las variables de sesion 
    */
	function verificarDia() {
		if( !$this->Session->check( "Medico.dia" ) ) {
			$this->Session->write( "Medico.dia", date( 'j' ) );
			$this->Session->write( "Medico.mes", date( 'n' ) );
			$this->Session->write( "Medico.ano", date( 'Y' ) );
		}
		$this->dia = $this->Session->read( "Medico.dia" );
		$this->mes = $this->Session->read( "Medico.mes" );
		$this->ano = $this->Session->read( "Medico.ano" );
		$this->set( 'actualizacion', $this->Session->read( 'actualizacion' ) );
	}
	
	function cambiarDia( $dia, $mes, $ano ) {
		if( $this->Session->read( "Medico.dia" ) != $dia ) {
			$this->Session->write( "Medico.dia", $dia );
		}
		if( $this->Session->read( "Medico.mes" ) != $mes ) {
			$this->Session->write( "Medico.mes", $mes );
		}
		if( $this->Session->read( "Medico.ano" ) != $ano ) {
			$this->Session->write( "Medico.ano", $ano );
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
		$t = $this->Medico->find( 'first', array( 'conditions' => array( 'usuario_id' => $id_usuario ), 'fields' => array( 'id_medico' ) ) );
		$id_medico = $t['Medico']['id_medico'];

		if( $this->request->isPost() ) {
			if( isset( $this->data['Medicos']['actualizacion'] ) ) {
				$this->Session->write( "actualizacion", $this->data['Medicos']['actualizacion'] );
				$this->set( 'actualizacion', $this->data['Medicos']['actualizacion'] );
				if( $this->data['Medicos']['actualizacion'] == 'false' ) {
					$accion = " deshabilitada ";
				} else { $accion = " habilitada"; }
				$this->Session->setFlash( 'Auto actualización de la página ha sido' . $accion );
			} else {
				$this->data = $this->data['Medico'];
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
					} else if( $this->data['accion'] == 'hoy' ) {
						$t2 = new DateTime('now');
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

		$this->set( 'fechas', $this->dia."/".$this->mes."/".$this->ano );
		$this->set( 'dia', $this->dia );
		$this->set( 'mes', $this->mes-1 ); // Lista de meses base 0 
		$this->set( 'ano', $this->ano ); 
		
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => ' CONCAT( Paciente.apellido, \', \', Paciente.nombre ) ' );
		$this->Turno->unbindModel( array( 'belongsTo' => array( 'Consultorio' ) ) );
		$f1 = new DateTime( 'now' );
		$f1->setDate( $this->ano, $this->mes, $this->dia ); $f1->setTime( 0, 0, 0 );
		$f2 = clone $f1; $f2->add( new DateInterval( "P1D" ) );
		$this->set( 'turnos' , $this->Turno->find( 'all', array( 'conditions' => array( 
												'medico_id' => $id_medico,
												'DATE( fecha_inicio ) >=' =>  $f1->format( 'Y-m-d' ),
												'DATE( fecha_fin ) <' => $f2->format( 'Y-m-d' ) ),
												'order' => 'fecha_inicio',
									 			'limit' => 80 ) )
												);
		$f2 = new DateTime( 'now' ); $f2->setTime( 0, 0, 0 );
		if( $f2 == $f1 ) {
			 // Estoy en el día de hoy
			 $this->set( 'hoy', true );
		} else {
			// Estoy en otro día
			$this->set( 'hoy', false );
		}
												
	}

   /**
    * Genera un sobreturno con los datos especificados
    * Los parametros son utilizados solamente cuando se debe dar de alta el usuario que fue ingresado.
    * Se necesitan los siguientes parametros: id_turno, spaciente, id_medico, hora, min, duracion.
    * spaciente es la cadena: <id_usuario - nombre usuario> si el usuario está dado de alta sino se dará de alta.
    */
	public function sobreturno( $id_turno = null, $id_paciente = null, $id_medico = null ) {
		if( $this->request->isPost() ) {
			$this->data = $this->data['Medico'];
			
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
			throw new NotFoundException( 'El médico no existe, '.$id_medico );
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
			$id_turno = $this->data['Medico']['id_turno'];
		} else {
			// Se coloca esto ya que solo cancelamos desde la vista de los turnos del paciente
			$this->data = array( 'Medico' => array( 'quien' => 'p' ) );
		}

		if( $this->data['Medico']['quien'] == "m" ) {
			
			// Veo si es algo especial
			$ids = array();
			if( isset( $this->data['Medico']['que'] ) ) {
				// Cargo los ids de los turnos según corresponda.
				$f1 = new DateTime( 'now' );
				$f2 = clone $f1; 
				$f2->setTime( 0, 0, 0 ); 
				$f2->add( new DateInterval("P1D" ) );
				$this->loadModel( 'Turno' );
				$id_usuario = $this->Auth->user( 'id_usuario' );
				$t = $this->Medico->find( 'first', array( 'conditions' => array( 'usuario_id' => $id_usuario ), 'fields' => array( 'id_medico' ) ) );
				$id_medico = $t['Medico']['id_medico'];
				if( $this->data['Medico']['que'] == 'dia' ) {
					$ids[] = $this->Turno->find( 'list', array( 'conditions' =>
													 array( 'medico_id' => $id_medico,
													 		'DATE( fecha_inicio ) >=' => $f1->format( 'Y-m-d' ),
													 		'TIME( fecha_inicio ) >=' => $f1->format( 'H:i:s' ),
													 		'DATE( fecha_inicio ) <=' => $f2->format( 'Y-m-d' )
													       ),
													   'fields' => array( 'id_turno' ),
													   'recursive' => -1
													  ) );																  
				} else if( $this->data['Medico']['que'] == 'proximo' ) {
					$ids[] = $this->Turno->find( 'list', array( 'conditions' =>
													 array( 'medico_id' => $id_medico,
													 		'DATE( fecha_inicio ) >=' => $f1->format( 'Y-m-d' ),
													 		'TIME( fecha_inicio ) >=' => $f1->format( 'H:i:s' ),
													 		'DATE( fecha_inicio ) <=' => $f2->format( 'Y-m-d' )
													       ),
													   'fields' => array( 'id_turno' ),
													   'recursive' => -1,
													   'limit' => 1
													  ) );					
				}
			} else {
				// Eliminando un solo turno desde la seccion normal
				$ids[] = $id_turno;
			}
			// Eliminación			
			if( count( $ids ) > 0 ) {
			   	$correcto = $incorrecto = array();
			   	foreach( $ids as $id ) {
			   		if( !is_array( $id ) ) {
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
			   	}
				if( count( $correcto ) > 0 ) {
					$mensaje = 'Se cancelaron correctamente '.count( $correcto ). ' turnos.<br />';
				}
				if( count( $incorrecto ) > 0 ) {
					$mensaje .= ". Los turnos ".implode( ', ', $incorrecto )." no se pudieron eliminar.";
				}
				$this->Session->setFlash($mensaje);
		   } else {
		   		$this->Session->setFlash( "No se canceló ningún turno" );
		   }
		} else if( $this->data['Medico']['quien'] == "p" ) {
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
    * Mantiene el día en que debe ser mostrados los turnos
    * 
    */
	public function reservar( $id_turno = null, $id_paciente = null, $id_medico = null ) {
		if( $this->request->isPost() ) {
			$this->data = $this->data['Medico'];
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
	

	public function index() {
		$this->Medico->recursive = 0;
		$this->set( 'medicos', $this->paginate() );
	}

	public function view( $id = null ) {
		if( $id == null ) {
			// Quieren ver los horarios de atención - Muestro el del primer médico
			$d = $this->Medico->find( 'first', array( 'recursive' => -1 ) );
			$id = $d['Medico']['id_medico'];
		}
		$this->Medico->id = $id;
		if (!$this->Medico->exists()) {
			throw new NotFoundException( 'El medico no existe' );
		}
		$this->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
		$this->set( 'medico', $this->Medico->find( 'first', array( 'conditions' => array( 'id_medico' => $id ), 'recursive' => 2 ) ) );
	}

	/**
	* administracion_index method
	*
	* @return void
	*/
	public function administracion_index() {
	    $this->layout = 'administracion';
		$this->Medico->recursive = 0;
		$this->set('medicos', $this->paginate());
	}

	/**
	* administracion_view method
	*
	* @param string $id
	* @return void
	*/
	public function administracion_view($id = null) {
		$this->Medico->id = $id;
		if (!$this->Medico->exists()) {
			throw new NotFoundException( 'El medico no existe' );
		}
		$this->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
		$this->set( 'medico', $this->Medico->find( 'first', array( 'conditions' => array( 'id_medico' => $id ), 'recursive' => 2 ) ) );
	}

	/**
	* administracion_add method
	*
	* @return void
	*/
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Medico->create();
			if ($this->Medico->save($this->request->data)) {
				$this->Session->setFlash( 'Se ha dado de alta el medico correctamente' );
				$this->redirect( array( 'action' => 'disponibilidad', $this->Medico->id ) );
			} else {
				$this->Session->setFlash( 'No se pudo dar de alta el medico. Por favor, intente nuevamente.' );
			}
		}
		// Selecciono solo los usuarios que son del grupo de medicos
		$ids = $this->Medico->find( 'list', array( 'fields' => array( 'usuario_id' ) ) );
		$usuarios = $this->Medico->Usuario->find('list', array( 'conditions' => array( 'grupo_id' => 2, 'NOT' => array( 'id_usuario' => $ids ) ), 'fields' => array( 'razonsocial' ) ) );
		$especialidads = $this->Medico->Especialidad->find('list');
		$clinicas = $this->Medico->Clinica->find('list');
		$this->set(compact('usuarios', 'especialidads', 'clinicas'));
	}

	/**
	* administracion_edit method
	*
	* @param string $id
	* @return void
	*/
	public function administracion_edit($id = null) {
		$this->Medico->id = $id;
		if (!$this->Medico->exists()) {
			throw new NotFoundException(__('Invalid medico'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Medico->save($this->request->data)) {
				$this->Session->setFlash(__('The medico has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The medico could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Medico->read(null, $id);
		}
		$usuarios = $this->Medico->Usuario->find('list');
		$especialidades = $this->Medico->Especialidad->find('list');
		$clinicas = $this->Medico->Clinica->find('list');
		$this->set( compact('usuarios', 'especialidades', 'clinicas' ) );
	}

	/**
	* administracion_delete method
	*
	* @param string $id
	* @return void
	*/
	public function administracion_delete($id = null) {
		$this->Session->setFlash( "METODO NO IMPLEMENTADO Y PELIGROSO!" );
		$this->redirect( array( 'action' => 'index' ) );
		return;
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Medico->id = $id;
		if (!$this->Medico->exists()) {
			throw new NotFoundException( 'El médico no existe!' );
		}
		if ($this->Medico->delete()) {
			$this->Session->setFlash( __( 'El médico fue eliminado correctamente.' ) );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->setFlash( 'El médico no pudo ser eliminado' );
		$this->redirect( array( 'action' => 'index' ) );
	}

	/**
	* Permite ver y administrar la disponibilidad de un medico
	*
	*/
	public function administracion_disponibilidad( $id_medico = null ) {
		$dias = array(  0 => 'domingo', 
		                1 => 'lunes', 
		                2 => 'martes', 
		                3 => 'miercoles', 
		                4 => 'jueves', 
		                5 => 'viernes', 
		                6 => 'sabado' );
		if( $this->request->isPost() ) {
			$this->Medico->id = $this->data['Medico']['id_medico'];
			if( !$this->Medico->exists() ) {
				throw new NotFoundException( 'El medico no existe en la base de datos' );
			}
			if( $this->data['Medico']['duracion'] == 0 ) {
				$this->Session->setFlash( 'La duración del turno no puede ser cero' );
			} else {
				$mensaje_flash = '';
				foreach( $dias as $dia ) {
					if( $this->data['Medico'][$dia] ) {
						if( $this->data[$dia]['hinicio'] == 0      && $this->data[$dia]['hfin'] == 0 
						 && $this->data[$dia]['hiniciotarde'] == 0 && $this->data[$dia]['hfintarde'] == 0 ) {
								$mensaje_flash .= 'El horario del día &nbsp;'.$dia.'&nbsp; tiene mal ajustados los horarios de inicio y fin.<br />';
						} else if( $this->data[$dia]['hinicio'] == $this->data[$dia]['hfin'] 
						        && $this->data[$dia]['minicio'] == $this->data[$dia]['mfin'] && $this->data[$dia]['hinicio'] != 0 ) {
								$mensaje_flash .= 'El horario del día&nbsp;'.$dia.'&nbsp; tiene un horario de inicio y fin identicos para le horario de mañana.<br />';	
						} else if( $this->data[$dia]['hiniciotarde'] == $this->data[$dia]['hfintarde'] 
							    && $this->data[$dia]['miniciotarde'] == $this->data[$dia]['mfintarde']  && $this->data[$dia]['hiniciotarde'] != 0 ) {
								$mensaje_flash .= 'El horario del día&nbsp;'.$dia.' tiene un horario de inicio y fin identicos para le horario de tarde.<br />';	
						}
						if( $this->Medico->Disponibilidad->verificar(
								$this->data['Medico']['id_medico'],
								$this->data['Medico']['consultorio'],
						        array_pop( array_reverse( array_keys( $dias, $dia ) ) ), 
								date( 'H:i:s', mktime( $this->data[$dia]['hinicio']     , $this->data[$dia]['minicio']     , 0 ) ),
								date( 'H:i:s', mktime( $this->data[$dia]['hfin']        , $this->data[$dia]['mfin']        , 0 ) ),
								date( 'H:i:s', mktime( $this->data[$dia]['hiniciotarde'], $this->data[$dia]['miniciotarde'], 0 ) ),
								date( 'H:i:s', mktime( $this->data[$dia]['hfintarde']   , $this->data[$dia]['mfintarde']   , 0 ) )
							) ) { 
							$mensaje_flash .= "El horario del dia ".strtoupper($dia)." en el consultorio seleccionado ya está ocupado por otro medico<br />";
						}
					}
				}
				if( $mensaje_flash != '' ) {
					$id_medico = $this->data['Medico']['id_medico'];
					$this->Session->setFlash( $mensaje_flash );
				} else {
						// Inicio el guardado de los datos
						$this->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
						$datos = array( 'Disponibilidad' => 
							array( 	'medico_id'      => $this->data['Medico']['id_medico'],
								    'duracion'       => intval( $this->data['Medico']['duracion'] ),
								    'consultorio_id' => $this->data['Medico']['consultorio']
							)
						);
						// Busco si existe una disponibilidad anterior
						if( $this->Medico->Disponibilidad->find( 'count', array( 'conditions' => array( 'medico_id' => $this->data['Medico']['id_medico'] ) ) ) > 0 ) {
							// Ya existe esta disponibilidad
							$d = $this->Medico->Disponibilidad->find( 'first',
								 array( 'conditions' => array( 'medico_id' => $this->data['Medico']['id_medico'] ),
									    'fields'     => array( 'id_disponibilidad' ) ) );
							$datos['Disponibilidad']['id_disponibilidad'] = $d['Disponibilidad']['id_disponibilidad'];
						}
						$this->Medico->Disponibilidad->save( $datos );
						// Elimino los datos anteriores
						if( $this->data['Medico']['disponibilidad_id'] > 0 ) {
							$this->Medico->Disponibilidad->DiaDisponibilidad->deleteAll( array( 'disponibilidad_id' => $this->data['Medico']['disponibilidad_id'] ) );
						}
						// Guardo los datos asociados - Genero todos los dias para mas comodidad en el script de generación automatica
						foreach( $dias as $dia ) {
							if( $this->data['Medico'][$dia] == 1 ) {
								$dat = array( 'DiaDisponibilidad' => 
										array(	'dia' => $this->data[$dia]['numero'],
											    'disponibilidad_id' => $this->data['Medico']['disponibilidad_id'],
											    'habilitado' => true,
											    'hora_inicio'       => date( 'H:i:s', mktime( $this->data[$dia]['hinicio']     , $this->data[$dia]['minicio']     , 0 ) ),
											    'hora_fin'          => date( 'H:i:s', mktime( $this->data[$dia]['hfin']        , $this->data[$dia]['mfin']        , 0 ) ),
											    'hora_inicio_tarde' => date( 'H:i:s', mktime( $this->data[$dia]['hiniciotarde'], $this->data[$dia]['miniciotarde'], 0 ) ),
											    'hora_fin_tarde'    => date( 'H:i:s', mktime( $this->data[$dia]['hfintarde']   , $this->data[$dia]['mfintarde']   , 0 ) )
										)
								);
								$this->Medico->Disponibilidad->DiaDisponibilidad->create();
								$this->Medico->Disponibilidad->DiaDisponibilidad->save( $dat );
							}

						}
						// Busco cuantos turnos no coinciden y redirecciono si es necesario - devuleve un array con los ids que nocoinciden
						$acambiar = $this->Medico->Turno->generarTurnos( $this->data );
						if( count( $acambiar ) <= 0 ) {
							$this->Session->setFlash( 'Disponibilidad guardada correctamente y re generados todos los turnos' );
							$this->redirect( array( 'action' => 'index' ) );
						} else {
							$this->Session->setFlash( 'Estos turnos han sido sacados del horario en que atiende. <br /> Reajustelos o cancelelos.' );
							$this->loadModel( 'Turno' );
							$this->Turno->Paciente->virtualFields = array( 'razon_social' => 'CONCAT( Paciente.apellido, \',\', Paciente.nombre )' );
							$this->set( 'turnos', $this->Turno->find( 'all', array( 'conditions' => array( 'id_turno' => $acambiar ) ) ) );
							$this->set( 'ids', json_encode( $acambiar ) );
							$this->render( 'administracion_ajustar_turnos' );
							return;
						}
				  }
			}
		}

		if( $id_medico == null ) {
			throw new NotFoundException( 'El medico no existe - Parametro nulo' );
		}
		$this->Medico->id = $id_medico;
		if( !$this->Medico->exists() ) {
			throw new NotFoundException( 'El medico no existe' );
		}
		$this->Medico->unbindModel( array( 'hasMany' => array( 'Turno', 'Excepcion' ), 'belongsTo' => array( 'Clinica', 'Especialidad' ) ) );
		$d = $this->Medico->read();
		$this->set( 'consultorios', $this->Consultorio->find( 'list', array( 'conditions' => array( 'clinica_id' => $d['Medico']['clinica_id'] ) ) ) );
		$this->Medico->Disponibilidad->id = $d['Disponibilidad']['id_disponibilidad'];
		$this->Medico->Disponibilidad->unbindModel( array( 'belongsTo' => array( 'Medico' ) ) );
		$d['Disponibilidad'] = $this->Medico->Disponibilidad->read();
		if( $d['Disponibilidad'] == false ) {
			// Nunca tuvo una disponibilidad habilitada
			foreach( $dias as $dia ) {
				$d['Disponibilidad']['DiaDisponibilidad'][$dia] =
					array(
						'hora_inicio' => 0,
						'minuto_inicio' => 0,
						'hora_fin' => 0,
						'minuto_fin' => 0,
						'hora_inicio_tarde' => 0,
						'hora_fin_tarde' => 0,
						'minuto_inicio_tarde' => 0,
						'minuto_fin_tarde' => 0,
						'habilitado' => false
					);
			}
			$d['Disponibilidad']['Disponibilidad']['duracion'] = 20;
			$d['Disponibilidad']['Disponibilidad']['consultorio_id'] = -1;
			$d['Disponibilidad']['Disponibilidad']['id_disponibilidad'] = -2;
		} else {
			$nuevo = array();
			foreach( $d['Disponibilidad']['DiaDisponibilidad'] as $disp ) {
				$t = split( ':', $disp['hora_inicio'] );
				$disp['hora_inicio'] = $t[0];
				$disp['minuto_inicio'] = $t[1];
				$t = split( ':', $disp['hora_fin'] );
				$disp['hora_fin'] = $t[0];
				$disp['minuto_fin'] = $t[1];
				if( $disp['hora_inicio_tarde'] == null ) { $disp['hora_inicio_tarde'] = '0:0'; }
				$t = split( ':', $disp['hora_inicio_tarde'] );
				$disp['hora_inicio_tarde'] = $t[0];
				$disp['minuto_inicio_tarde'] = $t[1];
				if( $disp['hora_fin_tarde'] == null ) { $disp['hora_fin_tarde'] = '0:0'; }
				$t = split( ':', $disp['hora_fin_tarde'] );
				$disp['hora_fin_tarde'] = $t[0];
				$disp['minuto_fin_tarde'] = $t[1];
				$nuevo[$dias[$disp['dia']]] = $disp;
			}
			$d['Disponibilidad']['DiaDisponibilidad'] = $nuevo;
		}
		$this->set( 'medico', $d );
	}

   /**
	* Permite ver y administrar la disponibilidad de un medico
	*/
	public function disponibilidad( $id_medico = null ) {
		// El medico es el usuario actual
		if( $id_medico == null ) {
			$id_usuario = $this->Auth->user( 'id_usuario' );
			$t = $this->Medico->find( 'first', array( 'conditions' => array( 'usuario_id' => $id_usuario ), 'fields' => array( 'id_medico' ) ) );
			$id_medico = $t['Medico']['id_medico'];
		}
		$dias = array(  0 => 'domingo', 
		                1 => 'lunes', 
		                2 => 'martes', 
		                3 => 'miercoles', 
		                4 => 'jueves', 
		                5 => 'viernes', 
		                6 => 'sabado' );
		if( $this->request->isPost() ) {
			$this->Medico->id = $this->data['Medico']['id_medico'];
			if( !$this->Medico->exists() ) {
				throw new NotFoundException( 'El medico no existe en la base de datos' );
			}
			if( $this->data['Medico']['duracion'] == 0 ) {
				$this->Session->setFlash( 'La duración del turno no puede ser cero' );
			} else {
				$mensaje_flash = '';
				foreach( $dias as $dia ) {
					if( $this->data['Medico'][$dia] ) {
						if( $this->data[$dia]['hinicio'] == 0      && $this->data[$dia]['hfin'] == 0 
						 && $this->data[$dia]['hiniciotarde'] == 0 && $this->data[$dia]['hfintarde'] == 0 ) {
								$mensaje_flash .= 'El horario del día &nbsp;'.$dia.'&nbsp; tiene mal ajustados los horarios de inicio y fin.<br />';
						} else if( $this->data[$dia]['hinicio'] == $this->data[$dia]['hfin'] 
						        && $this->data[$dia]['minicio'] == $this->data[$dia]['mfin'] && $this->data[$dia]['hinicio'] != 0 ) {
								$mensaje_flash .= 'El horario del día&nbsp;'.$dia.'&nbsp; tiene un horario de inicio y fin identicos para le horario de mañana.<br />';	
						} else if( $this->data[$dia]['hiniciotarde'] == $this->data[$dia]['hfintarde'] 
							    && $this->data[$dia]['miniciotarde'] == $this->data[$dia]['mfintarde']  && $this->data[$dia]['hiniciotarde'] != 0 ) {
								$mensaje_flash .= 'El horario del día&nbsp;'.$dia.' tiene un horario de inicio y fin identicos para le horario de tarde.<br />';	
						}
						if( $this->Medico->Disponibilidad->verificar(
								$this->data['Medico']['id_medico'],
								$this->data['Medico']['consultorio'],
						        array_pop( array_reverse( array_keys( $dias, $dia ) ) ), 
								date( 'H:i:s', mktime( $this->data[$dia]['hinicio']     , $this->data[$dia]['minicio']     , 0 ) ),
								date( 'H:i:s', mktime( $this->data[$dia]['hfin']        , $this->data[$dia]['mfin']        , 0 ) ),
								date( 'H:i:s', mktime( $this->data[$dia]['hiniciotarde'], $this->data[$dia]['miniciotarde'], 0 ) ),
								date( 'H:i:s', mktime( $this->data[$dia]['hfintarde']   , $this->data[$dia]['mfintarde']   , 0 ) )
							) ) { 
							$mensaje_flash .= "El horario del dia ".strtoupper($dia)." en el consultorio seleccionado ya está ocupado por otro medico<br />";
						}
					}
				}
				if( $mensaje_flash != '' ) {
					$id_medico = $this->data['Medico']['id_medico'];
					$this->Session->setFlash( $mensaje_flash );
				} else {
						// Inicio el guardado de los datos
						$this->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
						$datos = array( 'Disponibilidad' => 
									array( 	'medico_id'      => $this->data['Medico']['id_medico'],
										    'duracion'       => intval( $this->data['Medico']['duracion'] ),
										    'consultorio_id' => $this->data['Medico']['consultorio']
									)
						);
						// Busco si existe una disponibilidad anterior
						if( $this->Medico->Disponibilidad->find( 'count', array( 'conditions' => array( 'medico_id' => $this->data['Medico']['id_medico'] ) ) ) > 0 ) {
							// Ya existe esta disponibilidad
							$d = $this->Medico->Disponibilidad->find( 'first',
								 array( 'conditions' => array( 'medico_id' => $this->data['Medico']['id_medico'] ),
									    'fields'     => array( 'id_disponibilidad' ) ) );
							$datos['Disponibilidad']['id_disponibilidad'] = $d['Disponibilidad']['id_disponibilidad'];
						}
						$this->Medico->Disponibilidad->save( $datos );
						// Elimino los datos anteriores
						if( $this->data['Medico']['disponibilidad_id'] > 0 ) {
							$this->Medico->Disponibilidad->DiaDisponibilidad->deleteAll( array( 'disponibilidad_id' => $this->data['Medico']['disponibilidad_id'] ) );
						}
						// Guardo los datos asociados - Genero todos los dias para mas comodidad en el script de generación automatica
						foreach( $dias as $dia ) {
							if( $this->data['Medico'][$dia] == 1 ) {
								$dat = array( 'DiaDisponibilidad' => 
										array(	'dia' => $this->data[$dia]['numero'],
											    'disponibilidad_id' => $this->data['Medico']['disponibilidad_id'],
											    'habilitado' => true,
											    'hora_inicio'       => date( 'H:i:s', mktime( $this->data[$dia]['hinicio']     , $this->data[$dia]['minicio']     , 0 ) ),
											    'hora_fin'          => date( 'H:i:s', mktime( $this->data[$dia]['hfin']        , $this->data[$dia]['mfin']        , 0 ) ),
											    'hora_inicio_tarde' => date( 'H:i:s', mktime( $this->data[$dia]['hiniciotarde'], $this->data[$dia]['miniciotarde'], 0 ) ),
											    'hora_fin_tarde'    => date( 'H:i:s', mktime( $this->data[$dia]['hfintarde']   , $this->data[$dia]['mfintarde']   , 0 ) )
										)
								);
								$this->Medico->Disponibilidad->DiaDisponibilidad->create();
								$this->Medico->Disponibilidad->DiaDisponibilidad->save( $dat );
							}

						}
						// Busco cuantos turnos no coinciden y redirecciono si es necesario - devuleve un array con los ids que nocoinciden
						$acambiar = $this->Medico->Turno->generarTurnos( $this->data );
						if( count( $acambiar ) <= 0 ) {
							$this->Session->setFlash( 'Disponibilidad guardada correctamente y re generados todos los turnos' );
							$this->redirect( '/' );
						} else {
							$this->Session->setFlash( 'Estos turnos han sido sacados del horario en que atiende. <br /> Reajustelos o cancelelos.' );
							$this->loadModel( 'Turno' );
							$this->Turno->Paciente->virtualFields = array( 'razon_social' => 'CONCAT( Paciente.apellido, \',\', Paciente.nombre )' );
							$this->set( 'turnos', $this->Turno->find( 'all', array( 'conditions' => array( 'id_turno' => $acambiar ) ) ) );
							$this->set( 'ids', json_encode( $acambiar ) );
							$this->render( 'ajustar_turnos' );
							return;
						}
				  }
			}
		}

		if( $id_medico == null ) {
			throw new NotFoundException( 'El medico no existe - Parametro nulo' );
		}
		$this->Medico->id = $id_medico;
		if( !$this->Medico->exists() ) {
			throw new NotFoundException( 'El medico no existe' );
		}
		$this->Medico->unbindModel( array( 'hasMany' => array( 'Turno', 'Excepcion' ), 'belongsTo' => array( 'Clinica', 'Especialidad' ) ) );
		$d = $this->Medico->read();
		$this->set( 'consultorios', $this->Consultorio->find( 'list', array( 'conditions' => array( 'clinica_id' => $d['Medico']['clinica_id'] ) ) ) );
		$this->Medico->Disponibilidad->id = $d['Disponibilidad']['id_disponibilidad'];
		$this->Medico->Disponibilidad->unbindModel( array( 'belongsTo' => array( 'Medico' ) ) );
		$d['Disponibilidad'] = $this->Medico->Disponibilidad->read();
		if( $d['Disponibilidad'] == false ) {
			// Nunca tuvo una disponibilidad habilitada
			foreach( $dias as $dia ) {
				$d['Disponibilidad']['DiaDisponibilidad'][$dia] =
					array(
						'hora_inicio' => 0,
						'minuto_inicio' => 0,
						'hora_fin' => 0,
						'minuto_fin' => 0,
						'hora_inicio_tarde' => 0,
						'hora_fin_tarde' => 0,
						'minuto_inicio_tarde' => 0,
						'minuto_fin_tarde' => 0,
						'habilitado' => false
					);
			}
			$d['Disponibilidad']['Disponibilidad']['duracion'] = 20;
			$d['Disponibilidad']['Disponibilidad']['consultorio_id'] = -1;
			$d['Disponibilidad']['Disponibilidad']['id_disponibilidad'] = -2;
		} else {
			$nuevo = array();
			foreach( $d['Disponibilidad']['DiaDisponibilidad'] as $disp ) {
				$t = split( ':', $disp['hora_inicio'] );
				$disp['hora_inicio'] = $t[0];
				$disp['minuto_inicio'] = $t[1];
				$t = split( ':', $disp['hora_fin'] );
				$disp['hora_fin'] = $t[0];
				$disp['minuto_fin'] = $t[1];
				if( $disp['hora_inicio_tarde'] == null ) { $disp['hora_inicio_tarde'] = '0:0'; }
				$t = split( ':', $disp['hora_inicio_tarde'] );
				$disp['hora_inicio_tarde'] = $t[0];
				$disp['minuto_inicio_tarde'] = $t[1];
				if( $disp['hora_fin_tarde'] == null ) { $disp['hora_fin_tarde'] = '0:0'; }
				$t = split( ':', $disp['hora_fin_tarde'] );
				$disp['hora_fin_tarde'] = $t[0];
				$disp['minuto_fin_tarde'] = $t[1];
				$nuevo[$dias[$disp['dia']]] = $disp;
			}
			$d['Disponibilidad']['DiaDisponibilidad'] = $nuevo;
		}
		$this->set( 'medico', $d );
	}

	public function verExcepciones() {
		// Datos basicos
		$id_usuario = $this->Auth->user( 'id_usuario' );
		$t = $this->Medico->find( 'first', array( 'conditions' => array( 'usuario_id' => $id_usuario ), 'fields' => array( 'id_medico' ) ) );
		$id_medico = $t['Medico']['id_medico'];
		$this->Medico->id = $id_medico;
		if( !$this->Medico->exists() ) {
			throw new NotFoundException( "Usted no se un médico." );
		}
		$this->set( 'medico', $this->Medico->read() ); 
		$excepciones = $this->Medico->Disponibilidad->Excepciones->find( 'all', array( 'conditions' => array( 'medico_id' => $id_medico ) ) );
		$this->set( 'excepciones', $excepciones );
		$this->render( '/Excepciones/indice_medico' );
	}
	
	public function administracionEliminarExcepcion() {
		$this->autoRender = false;
		return json_encode( array( 'guardado' => false, 'error' => '\n No implementado' ) );
	}
}
