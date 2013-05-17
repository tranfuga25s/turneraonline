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
					case 'cargarDatosClinicas':
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
	 * Listado de clinicas para reservar turnos
	 */
	 public function cargarDatosClinicas() {
	 	if( $this->request->isPost() ) {
	 		$clinicas = $this->Clinica->find( 'list', array( 'conditions' => array( 'publicado' => true ) ) );
			$this->set( 'clinicas', $clinicas );
			return $this->render();
	 	} else {
	 		return json_encode( array( 'error' => 'Método no implementado' ) );
	 	}
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
	    $this->Clinica->recursive = -1;
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

		$this->helpers[] = 'GoogleMapV3';
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
		$this->helpers[] = 'GoogleMapV3';
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
				$this->Session->setFlash( 'La clinica ha sido agregada correctamente', 'default', array( 'class' => 'success' ) );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash( 'No se pudo guardar la clinica. Por favor, intente nuevamente.', 'default', array( 'class' => 'error') );
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
				$this->Session->setFlash( 'Clinica guardada correctamente', 'default', array( 'class' => 'success' ) );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash( 'No se puede guardar los datos editados. Por favor, intente nuevamente', 'default', array( 'class' => 'error') );
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
			$this->Session->setFlash( "Existen consultorios asociados a esta clinica. No se podrá eliminar.", 'default', array( 'class' => 'error') );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if ($this->Clinica->delete()) {
			$this->Session->setFlash( 'Clinica eliminada', 'default', array( 'class' => 'success' ) );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->setFlash( 'No se pudo eliminar la clinica.', 'default', array( 'class' => 'error') );
		$this->redirect( array( 'action' => 'index' ) );
	}
}
