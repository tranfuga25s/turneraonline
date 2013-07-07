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
				$this->Session->correcto( 'El grupo ha sido guardado correctamente' );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->incorrecto( 'El grupo no pudo ser guardado correctamente' );
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
				$this->Session->correcto( 'El grupo fue modificado correctamente' );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->incorrecto( 'El grupo no pudo ser guardado' );
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
		if( $this->Grupo->tieneUsuariosAsociados() ) {
			$this->Session->peligro( $this->Session->flash().'<br />. El grupo no se puede eliminar. Existen usuarios que pertenecen a este grupo todavía.' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		if ($this->Grupo->delete()) {
			$this->Session->correcto( 'Grupo eliminado correctamente' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->incorrecto( 'El Grupo no pudo ser eliminado' );
		$this->redirect( array( 'action' => 'index' ) );
	}

}
