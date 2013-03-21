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
			'loginRedirect'  => array( 'controller' => 'usuarios', 'action' => 'view'    ),
			'authorize'      => array( 'Controller' )
		),
		'Session',
		'PaginationRecall',
		'DebugKit.Toolbar',
		'Facebook.Connect' => array( 'model' => 'Usuario' )
	);
	
	public $helpers = array( 'Facebook.Facebook' );
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
		$this->set( 'facebook', $this->Connect->user() );
	}

	public function isAuthorized() { return true; }
	
	public function beforeFacebookSave(){
		$data = $this->Connect->user();
		$this->Connect->authUser['Usuario']['email'] = $data['email'];
		$this->Connect->authUser['Usuario']['nombre'] = $data['first_name'].' '.$data['middle_name'];
		$this->Connect->authUser['Usuario']['apellido'] = $data['last_name'];
		if( $data['gender'] == 'male' ){
			$this->Connect->authUser['Usuario']['sexo'] = 'm';	
		} else {
			$this->Connect->authUser['Usuario']['sexo'] = 'f';
		}
		// Por default va a el grupo de usuarios
		$this->Connect->authUser['Usuario']['grupo_id'] = 4;
		$this->Connect->authUser['Usuario']['notificaciones'] = 1;
		$this->Connect->authUser['Usuario']['obra_social_id'] = null;
	    return true; //Must return true or will not save.
	}
	
}
