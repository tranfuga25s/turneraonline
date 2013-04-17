<?php
App::uses('AppController', 'Controller');
/**
 * Controlador de grupos del sistema
 * Administra los grupos que asignan luego permisos
 * @property Grupo $Grupo
 */
class GruposController extends AppController {

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Grupo->recursive = 0;
		$this->set('grupos', $this->paginate());
	}

	/**
	 * view method
	 * @param string $id Identificador del grupo
	 * @return void
	 */
	public function view($id = null) {
		$this->Grupo->id = $id;
		if (!$this->Grupo->exists()) {
			throw new NotFoundException( 'Grupo Invalido' );
		}
		$this->set('grupo', $this->Grupo->read( null, $id ) );
	}

	/**
	 * administracion_index method
	 * @return void
	 */
	public function administracion_index() {
		$this->Grupo->recursive = 0;
		$this->set( 'grupos', $this->paginate() );
	}

	/**
	 * administracion_view method
	 * @param string $id Identificador del grupo
	 * @return void
	 */
	public function administracion_view($id = null) {
		$this->Grupo->id = $id;
		if (!$this->Grupo->exists()) {
			throw new NotFoundException( 'Grupo Invalido' );
		}
		$this->set( 'grupo', $this->Grupo->read( null, $id ) );
	}

	/**
	 * administracion_add method
	 * @return void
	 */
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Grupo->create();
			if ($this->Grupo->save($this->request->data)) {
				$this->Session->setFlash( 'El grupo ha sido guardado correctamente', 'default', array( 'class' => 'success' ) );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash( 'El grupo no pudo ser guardado correctamente', 'default', array( 'class' => 'error' ) );
			}
		}
	}

	/**
	 * administracion_edit method
	 * @param string $id Identificador del grupo
	 * @return void
	 */
	public function administracion_edit($id = null) {
		$this->Grupo->id = $id;
		if (!$this->Grupo->exists()) {
			throw new NotFoundException( 'Grupo invalido' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Grupo->save($this->request->data)) {
				$this->Session->setFlash( 'El grupo fue modificado correctamente', 'default', array( 'class' => 'success' ) );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash( 'El grupo no pudo ser guardado', 'default', array( 'class' => 'error' ) );
			}
		} else {
			$this->request->data = $this->Grupo->read( null, $id );
		}
	}

	/**
	 * administracion_delete method
	 * @param string $id Identificador del grupo a eliminar
	 * @return void
	 */
	public function administracion_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Grupo->id = $id;
		if (!$this->Grupo->exists()) {
			throw new NotFoundException( 'Grupo invalido' );
		}
		$this->Session->setFlash( 'Verificación de eliminación de grupo sin usuarios no implementada. No se eliminó el grupo.', 'default', array( 'class' => 'error' ) );
		$this->redirect( array( 'action' => 'index' ) );
		return;
		if ($this->Grupo->delete()) {
			$this->Session->setFlash( 'Grupo eliminado correctamente', 'default', array( 'class' => 'success' ) );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->setFlash( 'El Grupo no pudo ser eliminado', 'default', array( 'class' => 'error' ) );
		$this->redirect( array( 'action' => 'index' ) );
	}

}
