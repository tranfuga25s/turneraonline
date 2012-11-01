<?php

App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');

class AppController extends Controller {

	public $components = array(
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'fields' => array( 'username' => 'email', 'password' => 'contra' ),
					'userModel' => 'Usuario'
				)
			),
			'authError'      => 'Debe ingresar como usuario para poder utilizar esta funcionalidad',
			'loginAction'    => array( 'controller' => 'usuarios', 'action' => 'ingresar' ),
			'logoutRedirect' => array( 'controller' => 'pages'   , 'action' => 'salir'    ),
			'loginRedirect'  => array( 'controller' => 'turnos'  , 'action' => 'index'    ),
			'authorize'      => array( 'Controller' )
		),
		'Session'
	);

	// Esto permite que cualquier pagina del controlador Pages sea vista por el publico.
	public function beforeFilter() {
		if( $this->request->params['controller'] == 'pages' ) {
			$this->Auth->allow( 'display' );
		}
		if( $this->request->administracion == "administracion" ) {
			$this->layout = 'administracion';
		}
		// coloco los datos del usuario
		$adentro = $this->Auth->loggedIn();
		$this->set( 'loggeado', $adentro );
		if( $adentro ) {
			$this->set( 'usuarioactual', $this->Auth->user() );
		}
		// Cargo la configuración
		Configure::load( '', 'Turnera' );
		
		// Temas disponibles
		// Pongo la lista de temas disponibles
		$f = new Folder(  ROOT . DS . APP_DIR . DS . 'View' . DS . 'Themed' . DS);
		$lista = $f->read( true );
		$this->set( 'temas', $lista[0] );
		if( isset( $this->request->data['temas'] ) ) {
			$this->viewClass = $lista[$this->request->data['temas']['theme']];
			$this->Session->write( 'tema', $lista[$this->request->data['temas']['theme']] );
		} else {
			$this->viewClass = $this->Session->read( 'tema' );	
		}
		
	}

	public function isAuthorized() { return true; }

}

?>
