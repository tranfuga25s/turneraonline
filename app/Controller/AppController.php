<?php
App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
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
			'logoutRedirect' => array( 'controller' => 'pages'   , 'action' => 'display', 'homeVenta', 'administracion' => false ),
			'loginRedirect'  => array( 'controller' => 'turnos'  , 'action' => 'index'    ),
			'authorize'      => array( 'Controller' )
		),
		'Session',
		'PaginationRecall',
		'DebugKit.Toolbar'
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
