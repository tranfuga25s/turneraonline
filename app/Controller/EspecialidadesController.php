<?php
App::uses('AppController', 'Controller');
/**
 * Especialidades Controller
 *
 * @property Especialidade $Especialidade
 */
class EspecialidadesController extends AppController {
 	 var $uses = 'Especialidad';

	public function beforeFilter() {
		$this->Auth->allow( 'especialidadesInicio', 'view' );
		$this->layout = 'administracion';
		AppController::beforeFilter();
	}


	public function isAuthorized( $usuario = null, $request = null ) {
		if( ! parent::isAuthorized( $usuario, $request ) ) { return false; }
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
					case 'view':
					case 'index':
					case 'especialidadesInicio':
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
 	 * Listado de clinicas para la pagina inicial
 	 * @return void
 	 */
	public function especialidadesInicio() {
		$this->layout = '';
		$this->set( 'especialidades', $this->Especialidad->find( 'all', array( 'limit' => 5, 'recursive' => -1, 'fields' => array( 'id_especialidad', 'nombre' ) ) ) );
		return $this->render();
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Especialidad->recursive = 0;
		$this->set( 'especialidades', $this->paginate() );
	}

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
	public function view($id = null) {
		$this->Especialidad->id = $id;
		if (!$this->Especialidad->exists()) {
			throw new NotFoundException( 'Especialidad invalida' );
		}
		$this->set( 'especialidad', $this->Especialidad->read( null, $id ) );
	}


/**
 * administracion_index method
 *
 * @return void
 */
	public function administracion_index() {
		$this->Especialidad->recursive = 0;
		$this->set('especialidades', $this->paginate());
	}

/**
 * administracion_view method
 *
 * @param string $id
 * @return void
 */
	public function administracion_view($id = null) {
		$this->Especialidad->id = $id;
		if (!$this->Especialidad->exists()) {
			throw new NotFoundException( 'Especialidad invalida' );
		}
		$this->set('especialidade', $this->Especialidad->read(null, $id));
	}

/**
 * administracion_add method
 *
 * @return void
 */
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Especialidad->create();
			if ($this->Especialidad->save($this->request->data)) {
				$this->Session->correcto( 'La especialidad ha sido guardada correctamente' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->incorrecto( 'La especialidad no pudo ser guardada. Por favor, intente nuevamente.' );
			}
		}
	}

/**
 * administracion_edit method
 *
 * @param string $id
 * @return void
 */
	public function administracion_edit($id = null) {
		$this->Especialidad->id = $id;
		if (!$this->Especialidad->exists()) {
			throw new NotFoundException( 'Especialidad invalida' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Especialidad->save($this->request->data)) {
				$this->Session->correcto( 'La especialidad ha sido editada correctamente' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->incorrecto( 'La especialidad no se pudo guardar. Por favor, intente nuevamente.' );
			}
		} else {
			$this->request->data = $this->Especialidad->read(null, $id);
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
		$this->Especialidad->id = $id;
		if (!$this->Especialidad->exists()) {
			throw new NotFoundException( 'Escpecialidad invalida' );
		}
		// Busco la cantidad de medicos que quedan en esta especialidad
		$this->loadModel( 'Medico' );
		$cant = $this->Medico->find( 'count', array( 'conditions' => array( 'especialidad_id' => $id ) ) );
		if( $cant > 0 ) {
			$this->Session->incorrecto( 'No se pudo eliminar la especialidad ya que hay '.$cant.' medicos que todavía estan suscriptos a ella. <br /> Cambie los medicos de especialidad e intenteló de nuevo.' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if ($this->Especialidad->delete()) {
			$this->Session->correcto( 'La especialidad fue eliminada correctamente' );
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->incorrecto( "La especialidad no pudo ser eliminada" );
		$this->redirect(array('action' => 'index'));
	}
}
