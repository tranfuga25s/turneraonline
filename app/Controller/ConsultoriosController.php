<?php
App::uses('AppController', 'Controller');
/**
 * Consultorios Controller
 *
 * @property Consultorio $Consultorio
 */
class ConsultoriosController extends AppController {


	public function isAuthorized( $usuario = null ) {
		//pr( $this->request->params );
		switch( $usuario['grupo_id'] ) {
			case 1: // Administradores
			{
				return true;
				break;
			}
			case 2: // Medicos
			case 3: // Secretarias
			{
				switch( $this->request->params['action'] ) {
					case 'administracion_index':
					case 'administracion_edit':
					case 'administracion_view':
					{ return true; break; }
				}
			}
			case 4: // Usuario normal
			{
				switch( $this->request->params['action'] ) {
					case 'view':
					case 'index':
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
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Consultorio->recursive = 0;
		$this->set('consultorios', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Consultorio->id = $id;
		if (!$this->Consultorio->exists()) {
			throw new NotFoundException( 'Consultorio invalido' );
		}
		$this->set('consultorio', $this->Consultorio->read(null, $id));
	}


/**
 * administracion_index method
 *
 * @return void
 */
	public function administracion_index() {
		$this->Consultorio->recursive = 0;
		$this->set('consultorios', $this->paginate());
	}

/**
 * administracion_view method
 *
 * @param string $id
 * @return void
 */
	public function administracion_view($id = null) {
		$this->Consultorio->id = $id;
		if (!$this->Consultorio->exists()) {
			throw new NotFoundException( 'Consultorio invalido');
		}
		$this->set( 'consultorio', $this->Consultorio->read( null, $id ) );
	}

/**
 * administracion_add method
 *
 * @return void
 */
	public function administracion_add() {
		if ($this->request->is('post')) {
			$this->Consultorio->create();
			if ($this->Consultorio->save($this->request->data)) {
				$this->Session->correcto( 'El consultorio fue agregado correctamente' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->incorrecto( 'El consultario no pudo ser agregado, intente nuevamente.' );
			}
		}
		$clinicas = $this->Consultorio->Clinica->find('list');
		$this->set(compact('clinicas'));
	}

/**
 * administracion_edit method
 *
 * @param string $id
 * @return void
 */
	public function administracion_edit($id = null) {
		$this->Consultorio->id = $id;
		if (!$this->Consultorio->exists()) {
			throw new NotFoundException( 'Consultorio invalido' );
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Consultorio->save($this->request->data)) {
				$this->Session->correcto( 'El consultorio fue modificado correctamente' );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->incorrecto( 'El consultorio no ha podido ser modificado, intente nuevamente.' );
			}
		} else {
			$this->request->data = $this->Consultorio->read(null, $id);
		}
		$clinicas = $this->Consultorio->Clinica->find('list');
		$this->set( compact( 'clinicas' ) );
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
		$this->Consultorio->id = $id;
		if (!$this->Consultorio->exists()) {
			throw new NotFoundException( 'Consultorio invalido' );
		}
		if ($this->Consultorio->delete()) {
			$this->Session->correcto( 'Consultorio eliminado correctamente' );
			$this->redirect( array( 'action' => 'index' ) );
		}
		$this->Session->incorrecto( 'El Consultorio no pudo ser eliminado' );
		$this->redirect( array('action' => 'index' ) );
	}
}
