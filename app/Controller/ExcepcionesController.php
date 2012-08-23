<?php
App::uses('AppController', 'Controller');
/**
 * Excepciones Controller
 *
 * @property Excepcione $Excepcione
 * @property RequestHandlerComponent $RequestHandler
 */
class ExcepcionesController extends AppController {

	public $helpers = array('Js', 'Ajax');
	public $components = array('RequestHandler');

	public function administracion_index() {
		$this->Excepcione->recursive = 0;
		$this->set('excepciones', $this->paginate());
	}

/**
 * administracion_view method
 *
 * @param string $id
 * @return void
 */
	public function administracion_view($id = null) {
		$this->Excepcione->id = $id;
		if (!$this->Excepcione->exists()) {
			throw new NotFoundException(__('Invalid excepcione'));
		}
		$this->set('excepcione', $this->Excepcione->read(null, $id));
	}

/**
 * administracion_add method
 *
 * @return void
 */
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Excepcione->create();
			if ($this->Excepcione->save($this->request->data)) {
				$this->Session->setFlash(__('The excepcione has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The excepcione could not be saved. Please, try again.'));
			}
		}
		$medicos = $this->Excepcione->Medico->find('list');
		$this->set(compact('medicos'));
	}

/**
 * administracion_edit method
 *
 * @param string $id
 * @return void
 */
	public function administracion_edit($id = null) {
		$this->Excepcione->id = $id;
		if (!$this->Excepcione->exists()) {
			throw new NotFoundException(__('Invalid excepcione'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Excepcione->save($this->request->data)) {
				$this->Session->setFlash(__('The excepcione has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The excepcione could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Excepcione->read(null, $id);
		}
		$medicos = $this->Excepcione->Medico->find('list');
		$this->set(compact('medicos'));
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
		$this->Excepcione->id = $id;
		if (!$this->Excepcione->exists()) {
			throw new NotFoundException(__('Invalid excepcione'));
		}
		if ($this->Excepcione->delete()) {
			$this->Session->setFlash(__('Excepcione deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Excepcione was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
