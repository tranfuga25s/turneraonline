<?php
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
/**
 * Turnos Controller
 *
 * @property Turno $Turno
 */
class TurnosController extends AppController {

	var $helpers = array( 'Html', 'Form', 'Paginator', 'Js' => array( 'Jquery' ), 'Calendar.Calendar' );
	var $uses = array( 'Turno', 'Especialidad', 'Avisos', 'Clinica' );
	var $components = array( 'RequestHandler' );

	public function beforeFilter() {
		$this->Auth->allow( 'calcularTurnos' );
		AppController::beforeFilter();
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
			case 4: // Usuario normal
			{
				switch( $this->request->params['action'] ) {
					case 'verTurnos':
					case 'ver':
					case 'cargarDatos':
					case 'cargarCalendario':
					case 'cargarTurnos':
					case 'reservarTurno':
					case 'nuevo':
					case 'cambiarHorasAviso':
					case 'cancelar':
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
	* Muestra los turnos del usuario
	*/
	public function verTurnos( $id_usuario = null ) {
		if( $id_usuario == null ) {
			// Supongo que está con el usuario actual
			$id_usuario = $this->Auth->user( 'id_usuario' );
		}
		$this->Turno->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ), 'belongsTo' => array( 'Clinica', 'Especialidad' ), 'hasOne' => array( 'Disponibilidad' ) ) );
		$this->Turno->Consultorio->unbindModel( array( 'belongsTo' => array( 'Clinica' ) ) );
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( Paciente.apellido, \', \', Paciente.nombre )' );
		$this->set( 'turnos', $this->Turno->turnosReservados( $id_usuario ) );
		$this->set( 'turnosanteriores', $this->Turno->turnosAnteriores( $id_usuario ) );
	}

	/**
	* view method
	*
	* @param string $id
	* @return void
	*/
	public function ver($id = null) {
		$this->Turno->id = $id;
		if (!$this->Turno->exists()) {
			throw new NotFoundException(__('Invalid turno'));
		}
		$this->set('turno', $this->Turno->read(null, $id));
	}

	/**
	* Solicita un nuevo turno con el usuario loggeado
	*
	* @return void
	*/
	public function nuevo( $id_usuario = null ) {
		$this->set( 'usuario', $this->Auth->user() );
	}

	/**
	* Solicita los datos segun los parametros pasados desde ajax
	*
	* @return json array con los elementos html.
	*/
	public function cargarDatos() {
		if( $this->request->is('post') ) {
			//pr( $this->request->data );
			$id_clinica = $this->request->data['id_clinica'];
			if( $id_clinica == null || $id_clinica == "" ) { $id_clinica = 0; }
			$id_especialidad = $this->request->data['id_especialidad'];
			if( $id_especialidad == null || $id_especialidad == "" ) { $id_especialidad = 0; }
			$id_medico = $this->request->data['id_medico'];
			if( $id_medico == null || $id_medico == "" ) { $id_medico = 0; }
			if( $id_clinica == 0 && $id_medico == 0 && $id_especialidad == 0) {
				// Busco la lista entera
				$this->set( 'clinicas', $this->Clinica->find( 'list' ) );
				$this->set( 'especialidades', $this->Especialidad->find( 'list' ) );
				$this->set( 'medicos', $this->Turno->Medico->lista2() );

			} else if( $id_clinica == 0 && $id_medico == 0 && $id_especialidad != 0 ) {

				// Busco todos los medicos y clinicas que atienden la especialidad
				$this->set( 'especialidades',
					 $this->Especialidad->find( 'list', array( 'conditions' => array( 'id_especialidad' => $id_especialidad ) ) ) );
				// Busco todos los medicos con es especialidad
				$ids = $this->Turno->Medico->find( 'list', array( 'conditions' => array( 'especialidad_id' => $id_especialidad ) ) );
				$this->set( 'medicos', $this->Turno->Medico->lista2( $ids ) ); 
									 
				$clinicas = $this->Turno->Medico->find( 'list', array( 'conditions' => array( 'especialidad_id' => $id_especialidad ), 'fields' => array( 'clinica_id' ) ) );
				// Busco las clinicas que tienen medicos que dan esa especialidad
				$this->set( 'clinicas', 
					 $this->Clinica->find( 'list', array( 'conditions' => array( 'id_clinica' => $clinicas ) ) ) );

			} else if( $id_clinica == 0 && $id_medico != 0 && $id_especialidad == 0 ) {

				// Busco la clinica a la que pertenece y su especialidad
				$this->Turno->Medico->id = $id_medico;
				$d = $this->Turno->Medico->read();
				$this->set( 'clinicas',
					$this->Clinica->find( 'list', array( 'conditions' => array( 'id_clinica' => $d['Medico']['clinica_id'] ) ) ) );
				$this->set( 'especialidades',
					$this->Especialidad->find( 'list', array( 'conditions' => array( 'id_especialidad' => $d['Medico']['especialidad_id'] ) ) ) );
				$this->set( 'medicos', $this->Turno->Medico->lista2( $id_medico ) );

			} else if( $id_clinica != 0 && $id_medico == 0 && $id_especialidad == 0 ) {

				// Busco todos los medicos de una clinica
				$med = $this->Turno->Medico->find( 'list', array( 'conditions' => array( 'clinica_id' => $id_clinica ), 'fields' => array( 'id_medico' ) ) );
				$esp = $this->Turno->Medico->find( 'list', array( 'conditions' => array( 'id_medico' => $med ), 'fields' => array( 'especialidad_id' ) ) );
				$this->set( 'especialidades',
					$this->Especialidad->find( 'list', array( 'conditions' => array( 'id_especialidad' => $esp ) ) ) );
				$this->set( 'medicos',
					$this->Turno->Medico->lista2( $med ) );
				$this->set( 'clinicas',
					$this->Clinica->find( 'list', array( 'conditions' => array( 'id_clinica' => $id_clinica ) ) ) );
			} else if( $id_clinica != 0 && $id_medico == 0 && $id_especialidad != 0 ) {

				// Busco todos los medicos de la clinica con la especialidad indicada
				$meds = $this->Turno->Medico->find( 'list', 
					 	array( 'conditions' => array( 'clinica_id' => $id_clinica, 'especialidad_id' => $id_especialidad ),
							'fields' => array( 'usuario_id' ) ) );
				$this->set( 'medicos',
					$this->Turno->Medico->lista2( $meds ) );
				$this->set( 'especialidades',
					$this->Especialidad->find( 'list', array( 'conditions' => array( 'id_especialidad' => $id_especialidad ) ) ) );
				$this->set( 'clinicas',
					$this->Clinica->find( 'list', array( 'conditions' => array( 'id_clinica' => $id_clinica ) ) ) );

			} else if( $id_clinica == 0 && $id_medico != 0 && $id_especialidad != 0 ) {

				// Busco las clinicas que dan esta especialidad con estos medicos
				$ids = $this->Turno->Medico->find( 'list',
					array( 'conditions' => array( 'id_medico' => $id_medico, 'especialidad_id' => $id_especialidad ),
					       'fields' => array( 'clinica_id' ) ) );
				$this->set( 'clinicas',
					$this->Turno->Consultorio->Clinica->find( 'list', array( 'conditions' => array( 'id_clinica' => $ids ) ) ) );
				$this->set( 'especialidades',
					$this->Especialidad->find( 'list', array( 'conditions' => array( 'id_especialidad' => $id_especialidad ) ) ) );
				$this->set( 'medicos',
					$this->Turno->Medico->lista2( $id_medico ) );

			} else if( $id_clinica != 0 && $id_medico != 0 && $id_especialidad == 0 ) {

				// Busco la especialidad que da el medico en esa clinica
				$ids = $this->Turno->Medico->find( 'list', array( 'conditions' => array( 'id_medico' => $id_medico, 'clinica_id' => $id_clinica ), 'fields' => array( 'especialidad_id' ) ) );
				$this->set( 'especialidades',
					$this->Especialidad->find( 'list', array( 'conditions' => array( 'id_especialidad' => $ids ) ) ) );
				$this->set( 'clinicas',
					$this->Turno->Consultorio->Clinica->find( 'list', array( 'conditions' => array( 'id_clinica' => $id_clinica ) ) ) );
				$this->set( 'medicos',
					$this->Turno->Medico->lista2( $ids ) );

			} else if( $id_clinica != 0 && $id_medico != 0 && $id_especialidad != 0 ) {

				$this->set( 'clinicas',
					$this->Turno->Consultorio->Clinica->find( 'list', array( 'conditions' => array( 'id_clinica' => $id_clinica ) ) ) );
				$this->set( 'especialidades',
					$this->Especialidad->find( 'list', array( 'conditions' => array( 'id_especialidad' => $id_especialidad ) ) ) );
				// No filtro por medico ya que quiero que los demás esten disponibles.
				$this->set( 'medicos', $this->Turno->Medico->lista2() );

			}
			$this->set( 'id_clinica', $id_clinica );
			$this->set( 'id_especialidad', $id_especialidad );
			$this->set( 'id_medico', $id_medico );
		}
	}

	public function cargarCalendario() {
		if( $this->request->is( "post" ) ) {
			//pr( $this->request->data );
			if( isset( $this->request->data['mes'] ) ) { $mes = $this->request->data['mes']; }
			if( isset( $this->request->data['ano'] ) ) { $ano = $this->request->data['ano']; }
			$id_clinica = $this->request->data['id_clinica'];
			$id_especialidad = $this->request->data['id_especialidad'];
			$id_medico = $this->request->data['id_medico'];
			if( !isset( $ano ) || $ano == 0 ) { $ano = date( 'Y' ); }
			if( !isset( $mes ) || $mes == 0 ) { $mes = date( 'n' ); }

			// Busco la cantidad de meses hacia adelante y atras que se pueden buscar
			$cant_dias = Configure::read( 'Turnera.dias_turnos' );
			if( $cant_dias == null ) {
				die( "Error de lectura de configuracion" );
			}

			$fecha_inicio = new DateTime( 'now' );

			$fecha_fin = $fecha_inicio;
			$fecha_fin->add( new DateInterval( "P".$cant_dias."D" ) );

			$fecha_buscada = new DateTime();
			$fecha_buscada->setDate( $ano, $mes, 1 );
			$fecha_buscada2 = $fecha_buscada;
			$fecha_buscada2->add( new DateInterval( "P1M" ) );

			if( $fecha_buscada > $fecha_inicio && $fecha_buscada < $fecha_fin ) {
				$this->set( 'meses_anteriores', 1 );
			} else { $this->set( 'meses_anteriores', 0 ); }
			if( $fecha_fin > $fecha_buscada2 ) {
				$this->set( 'meses_siguientes', 1 );
			} else { $this->set( 'meses_siguientes', 0 ); }
			// Busco en la disponibilidad de los medicos
			$turnos = $this->Turno->buscarDisponibilidad( $mes, $ano, $id_clinica, $id_especialidad, $id_medico, true );
			$this->set( 'turnos', $turnos );
			$this->set( 'mes', $mes );
			$this->set( 'ano', $ano );
		}
	}


	public function cargarTurnos() {
		if( $this->request->is( "post" ) ) {
			$dia = $this->request->data['dia'];
			$mes = $this->request->data['mes'];
			$ano = $this->request->data['ano'];
			$id_clinica = $this->request->data['id_clinica'];
			$id_especialidad = $this->request->data['id_especialidad'];
			$id_medico = $this->request->data['id_medico'];
			// Veo si el día es hoy de poner los turnos con hora mayor a la actual
			if( $dia == date( 'j' ) && $mes == date( 'n' )  && $ano == date( 'Y' ) ) {
				$this->set( 'turnos', $this->Turno->buscarTurnos( $dia, $mes, $ano, $id_clinica, $id_especialidad, $id_medico, false, date( 'H' ), date( 'i' ) ) );
			} else {
				$this->set( 'turnos', $this->Turno->buscarTurnos( $dia, $mes, $ano, $id_clinica, $id_especialidad, $id_medico ) );
			}
			$this->set( 'medicos', $this->Turno->Medico->lista() );
			$this->set( 'fecha', $dia.'/'.$mes.'/'.$ano );
		} else {
			echo "Metodo no autorizado.";
			$this->autoRender = false;
			return;
		}
	}

	/**
	 * \fn reservarTurno( $id_turno, $id_paciente )
	 * Reserva un turno por parte del usuario
	 */
	public function reservarTurno( $id_turno = null, $id_paciente = null ) {

		if( $id_paciente == null ) {
			$id_paciente = $this->Auth->user( 'id_usuario' );
		}

		$this->Turno->id = $id_turno;
		if (!$this->Turno->exists()) {
			throw new NotFoundException( 'El turno solicitado no existe' );
		}
		$this->Turno->unbindModel( array( 'belongsTo' => array( 'Paciente' ) ) );
		$turno = $this->Turno->read();

		// Verificar restricción de cantidad de turnos x día.
		if( $this->Turno->verificarTurnosEnDia( $turno['Turno']['fecha_inicio'], $id_paciente ) ) {
			$this->Session->setFlash( "Usted ya ha reservado un turno para este día. Solo puede reservar un turno por día" );
			$this->redirect( array( 'action' => 'nuevo' ) );
		}

		$tiempo = Configure::read( 'Turnera.notificaciones.horas_proximo' );

		$this->loadModel( 'Usuario' );
		$this->Usuario->id = $id_paciente;
		if( !$this->Usuario->exists() ) {
			throw new NotFoundException( 'El usuario solicitado no existe' );
		}
		$this->Usuario->recursive = -1;
		$usuario = $this->Usuario->read();

		$turno['Medico'] = $this->Usuario->read( null, $turno['Medico']['usuario_id'] );

		$error = '';
		if( $this->Turno->reservar( $id_turno, $id_paciente, $error )  ) {
			$this->requestAction( array( 'controller' => 'avisos', 'action' => 'agregarAvisoNuevoTurno', 'id_turno' => $id_turno, 'id_paciente' => $id_paciente ) );
		}

		$this->set( 'tiempo', $tiempo );
		$this->set( 'turno', $turno );
		$this->set( 'usuario', $usuario );
		$this->set( 'error', $error );
	}

	public function administracion_trasladar( $id_turno = null ) {
		if( $this->request->isPost() ) {
			// Pedido por ajax
			if( $this->params['named']['id_turno'] == null ) {
				throw new NotFoundException( 'El turno solicitado no existe' );
			}
			$this->autoRender = false;
			$id_turno = $this->params['named']['id_turno'];
			return json_encode( array( 'estado' => false, 'id_turno' => $id_turno, 'mensaje' => 'No implementado todavía' ) );
		}
	}

	/*!
	 * Funcion llamada cuando un usuario desea cancelar un turno que resevó con anterioridad.
	 */
	public function cancelar( $id_turno = null ) {
		if( $id_turno == null ) {
			throw new NotFoundException( "El turno no está especificado" );
		}
		$this->Turno->id = $id_turno;
		if( !$this->Turno->exists() ) {
			throw new NotFoundException( "El turno especificado no existe" );
		}
		
		// Libero el turno.
		if( $this->Turno->cancelar( $id_turno ) ) {
			// Veo el aviso
			$this->requestAction( array( 'controller' => 'avisos', 'action' => 'cancelarAvisoNuevoTurno', $id_turno ) );
			$this->Session->setFlash( "Turno cancelado correctamente." );
		} else {
			$this->Session->setFlash( "Existió un error al intentar cancelar el turno" );
		}
		$this->redirect( array( 'action' => 'verTurnos' ) );
	}
	/**
	* administracion_index method
	*
	* @return void
	*/
	public function administracion_index() {
		$conditions = array();
		if( !empty( $this->request->data ) ) {
			if( $this->request->data['Turno']['atendido']  ) { $conditions['atendido'] = true; 	 }
			if( $this->request->data['Turno']['reservado'] ) { $conditions[] = '`Turno`.`paciente_id` IS NOT NULL';  }
			if( $this->request->data['Turno']['cancelado'] ) { $conditions['cancelado'] = true;  }
			if( $this->request->data['Turno']['consultorio_id'] != 0 ) { $conditions['consultorio_id'] = $this->request->data['Turno']['consultorio_id']; }
			if( $this->request->data['Turno']['medico_id'] != 0 ) { $conditions['medico_id'] = $this->request->data['Turno']['medico_id']; }
			if( $this->request->data['Turno']['fechaDesdeCkB'] ) {
				$conditions['DATE( `Turno`.`fecha_inicio` ) >= '] = $this->request->data['Turno']['fechaDesde']['year'].'-'.
												                    $this->request->data['Turno']['fechaDesde']['month'].'-'.
												                    $this->request->data['Turno']['fechaDesde']['day']; }
			if( $this->request->data['Turno']['fechaHastaCkB'] ) {
				$conditions['DATE( `Turno`.`fecha_fin` ) <= '] = $this->request->data['Turno']['fechaHasta']['year'].'-'.
												     	         $this->request->data['Turno']['fechaHasta']['month'].'-'.
												                 $this->request->data['Turno']['fechaHasta']['day']; }
		}
		$this->Turno->recursive = 2;
		$this->Turno->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( Paciente.apellido, \', \', Paciente.nombre )' );
		$this->set('turnos', $this->paginate( 'Turno', $conditions ) );
		$this->set( 'consultorios', $this->Turno->Consultorio->find('list') );
		$this->set( 'medicos', $this->Turno->Medico->lista2() );
	}

	/**
	* administracion_view method
	*
	* @param string $id
	* @return void
	*/
	public function administracion_view($id = null) {
		$this->Turno->id = $id;
		if (!$this->Turno->exists()) {
			throw new NotFoundException(__('Invalid turno'));
		}
		$this->Turno->recursive = 2;
		$this->Turno->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( Paciente.apellido, \', \', Paciente.nombre )' );
		$this->set('turno', $this->Turno->read(null, $id));
	}

	/**
	* administracion_add method
	*
	* @return void
	*/
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Turno->create();
			if ($this->Turno->save($this->request->data)) {
				$this->Session->setFlash(__('The turno has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The turno could not be saved. Please, try again.'));
			}
		}
		$pacientes = $this->Turno->Paciente->find('list');
		$medicos = $this->Turno->Medico->find('list');
		$consultorios = $this->Turno->Consultorio->find('list');
		$this->set(compact('pacientes', 'medicos', 'consultorios'));
	}

	/**
	* administracion_edit method
	*
	* @param string $id
	* @return void
	*/
	public function administracion_edit($id = null) {
		throw new NotFoundException( "Metodo no necesario" );
		$this->Turno->id = $id;
		if (!$this->Turno->exists()) {
			throw new NotFoundException( 'Turno Invalido' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Turno->save($this->request->data)) {
				$this->Session->setFlash( 'El turno ha sido guardado' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The turno could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Turno->read(null, $id);
		}
		$pacientes = $this->Turno->Paciente->find('list');
		$medicos = $this->Turno->Medico->find('list');
		$consultorios = $this->Turno->Consultorio->find('list');
		$this->set(compact('pacientes', 'medicos', 'consultorios'));
	}

	/**
	* Metodo para eliminar un turno desde la administración
	*
	* @param string $id Identificador del turno a eliminar.
	* @return void
	*/
	public function administracion_delete( $id = null ) {
		if( !$this->request->is( 'post' ) ) {
			throw new MethodNotAllowedException();
		}
		$this->Turno->id = $id;
		if (!$this->Turno->exists()) {
			throw new NotFoundException( 'El turno no existe' );
		}
		$reservado = $this->Turno->field( 'paciente_id' );
		if( $reservado != null ) {
			$this->Session->setFlash( 'El turno está reservado. Canceleló primero.' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$recibido = $this->Turno->field( 'recibido' );
		if( $recibido == true ) {
			$this->Session->setFlash( 'El turno está marcado como recibido. Canceleló primero.' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$atendido = $this->Turno->field( 'atendido' );
		if( $atendido == true ) {
			$this->Session->setFlash( 'El turno está atendido ya. Canceleló primero.' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if ($this->Turno->delete()) {
			$this->Session->setFlash('El turno fue eliminado correctamente');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('El turno no pudo ser eliminado');
		$this->redirect(array('action' => 'index'));
	}

   /*!
    * Muestra el listado de turnos según un médico específico
    * \param id_medico Identificador del medico
    */
    public function administracion_verPorMedico( $id_medico = null )
	{
		$this->loadModel( 'Medico' );
		$this->Medico->id = $id_medico;
		if( !$this->Medico->exists() ) {
			throw new NotFoundException( "No se puede encontrar el medico que busca" );
		}
		$this->Medico->unbindModel( array( 'hasMany' => array( 'Turnos' ) ) );
		$this->set( 'medico', $this->Medico->read( null, $id_medico ) );
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => ' CONCAT( Paciente.apellido, \', \', Paciente.nombre ) ' );
		$this->paginate = array( 'medico_id' => $id_medico );
		$this->set( 'turnos', $this->paginate() );
	}
	
	/*!
	 * Permite modificar la cantidad de horas de anterioridad con la que se le enviará el aviso de turno proximo por email.
	 */
	public function cambiarHorasAviso()
	{
		if( !$this->request->isPost() ) {
			throw new NotFoundExpection( 'Metodo no implementado de esta forma' );
			return;
		}
		$id_turno = $this->data['Turno']['id_turno'];
		$nhoras = $this->data['Turno']['horas'];
		$this->Turno->id = $id_turno;
		if( !$this->Turno->exists() ) {
			throw new NotFoundException( "El turno solititado no existe!" );
			return;
		}
		$hturno = $this->Turno->field( 'fecha_inicio' );
		$this->loadModel( "Aviso" );
		if( $this->Aviso->cambiarHorasTurno( $id_turno, $nhoras, $hturno ) ) {
			$this->Session->setFlash( 'Cantidad de horas cambiadas correctamente' );
		} else {
			$this->Session->setFlash( 'No se pudieron cambiar la cantidad de horas. Se dejó de manera predeterminada.');
		}
		$this->redirect( '/' );
	}
	 
}
