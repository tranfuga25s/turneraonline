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
		'Session',
		'PaginationRecall'
	);
	
	//public $theme = 'dentista';

	// Esto permite que cualquier pagina del controlador Pages sea vista por el publico.
	public function beforeFilter() {
		
		if( $this->request->params['controller'] == 'pages' ) {
			$this->Auth->allow( 'display' );
		}
		if( $this->request->administracion == "administracion" ) {
			$this->layout = 'administracion';
			$this->theme = '';
		}
		// coloco los datos del usuario
		$adentro = $this->Auth->loggedIn();
		$this->set( 'loggeado', $adentro );
		if( $adentro ) {
			$this->set( 'usuarioactual', $this->Auth->user() );
		}
		// Cargo la configuración
		Configure::load( '', 'Turnera' );
		
	}

	public function isAuthorized() { return true; }

}