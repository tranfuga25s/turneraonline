<?php
App::uses('AppController', 'Controller');
/**
 * Clinicas Controller
 * Controlador de la clinica
 * @property Clinica $Clinica
 */
class ClinicasController extends AppController {


	/* Funciones con acceso publico */
	public function beforeFilter() {
		$this->Auth->allow( 'clinicasInicio', 'view', 'index' );
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
			{
				switch( $this->request->params['actions'] ) {
					case 'administracion_view':
					case 'administracion_edit':
					{ return true; break; }
				}
				// saco el break y el default para que autorize a los permisos de el usuario normal
			}
			case 4: // Usuario normal
			{
				switch( $this->request->params['actions'] ) {
					case 'clinicasInicio':
					case 'view':
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
	public function clinicasInicio() {
		$this->layout = '';
		$this->set( 'clinicas', $this->Clinica->find( 'all', array( 'limit' => 5, 'recursive' => -1, 'fields' => array( 'id_clinica', 'nombre', 'logo' ) ) ) );
		return $this->render();
	}

	public function index() {
		$this->set( 'clinicas', $this->paginate() );
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Clinica->id = $id;
		if (!$this->Clinica->exists()) {
			throw new NotFoundException( 'La clinica no existe' );
		}
		$clinica = $this->Clinica->read( null, $id );
		$this->loadModel( 'Medico' );
		$ids = $this->Medico->find( 'list', array( 'conditions' => array( 'clinica_id' => $id ), 'fields' => 'id_medico' ) );
		$clinica['Medicos'] = $this->Medico->lista( $ids );
		$this->loadModel( 'Especialidad' );
		$ids = $this->Medico->find( 'list', array( 'conditions' => array( 'clinica_id' => $id ), 'fields' => 'especialidad_id' ) );
		$clinica['Especialidades'] = $this->Especialidad->find( 'all', array( 'conditions' => array( 'id_especialidad' => $ids ) ) );
		$this->set( 'clinica', $clinica );
	}

/**
 * administracion_index method
 *
 * @return void
 */
	public function administracion_index() {
		$this->Clinica->recursive = 0;
		$this->set( 'clinicas', $this->paginate() );
	}

/**
 * administracion_view method
 *
 * @param string $id
 * @return void
 */
	public function administracion_view($id = null) {
		$this->Clinica->id = $id;
		if (!$this->Clinica->exists()) {
			throw new NotFoundException( 'La clinica no existe' );
		}
		$this->set('clinica', $this->Clinica->read(null, $id));
	}

/**
 * administracion_add method
 *
 * @return void
 */
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Clinica->create();
			if ($this->Clinica->save($this->request->data)) {
				$this->Session->setFlash(__('The clinica has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The clinica could not be saved. Please, try again.'));
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
		$this->Clinica->id = $id;
		if (!$this->Clinica->exists()) {
			throw new NotFoundException( 'La clinica no existe' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Clinica->save($this->request->data)) {
				$this->Session->setFlash(__('The clinica has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The clinica could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Clinica->read(null, $id);
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
		$this->Clinica->id = $id;
		if (!$this->Clinica->exists()) {
			throw new NotFoundException( 'La clinica no existe' );
		}
		$this->loadModel( 'Medico' );
		$cant_med = $this->Medico->find( 'count', array( 'conditions' => array( 'clinica_id' => $id ) ) );
		$this->loadModel( 'Consultorio' );
		$cant_con = $this->Consultorio->find( 'count', array( 'conditions' => array( 'clinica_id' => $id ) ) );
		if( $cant_med > 0 ) {
			$this->Session->setFlash("Existen medicos asociados a esta clinica. No se podrá eliminar." );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if( $cant_con > 0 ) {
			$this->Session->setFlash( "Existen consultorios asociados a esta clinica. No se podrá eliminar." );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if ($this->Clinica->delete()) {
			$this->Session->setFlash( 'Clinica eliminada' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->setFlash(__('Clinica was not deleted'));
		$this->redirect( array( 'action' => 'index' ) );
	}
}
