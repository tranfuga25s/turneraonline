<?php
App::uses('AppController', 'Controller');
/**
 * ObrasSociales Controller
 *
 * @property ObrasSociale $ObrasSociale
 */
class ObrasSocialesController extends AppController {

	public $uses = 'ObraSocial';
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ObraSocial->recursive = 0;
		$this->set('obrasSociales', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException(__('Invalid obras sociale'));
		}
		$this->set('obrasSociale', $this->ObraSocial->read(null, $id));
	}

/**
 * administracion_index method
 *
 * @return void
 */
	public function administracion_index() {
		$this->layout = 'administracion';
		$this->ObraSocial->recursive = 0;
		$this->set('obrasSociales', $this->paginate());
	}

/**
 * administracion_view method
 *
 * @param string $id
 * @return void
 */
	public function administracion_view($id = null) {
		$this->layout = 'administracion';
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException(__('Invalid obras sociale'));
		}
		$this->set('obrasSociale', $this->ObraSocial->read(null, $id));
	}

/**
 * administracion_add method
 *
 * @return void
 */
	public function administracion_add() {
		$this->layout = 'administracion';
		if ($this->request->is('post')) {
			$this->ObraSocial->create();
			if ($this->ObraSocial->save($this->request->data)) {
				$this->Session->setFlash( 'La nueva obra social ha sido guardada correctamente.' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The obras sociale could not be saved. Please, try again.'));
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
		$this->layout = 'administracion';
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException(__('Invalid obras sociale'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ObraSocial->save($this->request->data)) {
				$this->Session->setFlash( 'La obra social ha sido modificada correctamente.' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The obras sociale could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ObraSocial->read(null, $id);
		}
	}

/**
 * administracion_delete method
 *
 * @param string $id
 * @return void
 */
	public function administracion_delete($id = null) {
		$this->layout = 'administracion';
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ObraSocial->id = $id;
		if (!$this->ObraSocial->exists()) {
			throw new NotFoundException(__('Invalid obras sociale'));
		}
		$this->loadModel( 'Usuario' );
		if( $this->Usuario->find( 'count', array( 'conditions' => array( 'obra_social_id' => $id ) ) ) > 0 ) {
			$this->Session->setFlash( "Existe algún paciente con esta obra social. No se eliminará" );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if ($this->ObraSocial->delete()) {
			$this->Session->setFlash(__('Obras sociale deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Obras sociale was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
