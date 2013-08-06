<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');
App::uses( 'Folder', 'Utility');
App::uses( 'File', 'Utility');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    /**
     * Controller name
     *
     * @var string
     */
	public $name = 'Pages';

    /**
     * This controller does not use a model
     *
     * @var array
     */
	public $uses = array();
    
    
    private $filtrar = array(
        'administracion_index',
        'administracion_edit',
        'ayuda',
        'staff',
        'salir',
        'legales',
        'home_venta',
        'home-talin'
    );

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
    
    public function administracion_index() {
        // busco el listado de elementos que hay para editar
        $dir = new Folder( ROOT . DS . APP_DIR . DS . 'View'. DS . 'Pages' );
        $files = $dir->read( true, $this->filtrar );
        // Los archivos estan en el puesto 1
        $this->set( 'archivos', $files[1] );
    }
    
    public function administracion_edit( $nombre ) {
        // Busco si existe el archivo en View/Pages/
        if( $this->request->isPost() ) {
            // Guardo el contenido en el archivo
            $contenido_nuevo = $this->request->data['Page']['content'];
            $nombre = $this->request->data['Page']['nombre'];
            $archivo = new File(  ROOT . DS . APP_DIR . DS . 'View'. DS . 'Pages' . DS . $nombre .'.ctp' );
            if( $archivo->open('w') ) {
                if( $archivo->write( $contenido_nuevo ) ) {
                $this->Session->setFlash( 'El contenido se guardó correctamente', 'default', array( 'class' => 'success' )  );
                } else {
                $this->Session->setFlash( 'No se pudo escribir en el archivo', 'default', array( 'class' => 'error' )  );
                }
            } else {
                $this->Session->setFlash( "No se pudo abrir el archivo para escritura", 'default', array( 'class' => 'error' ) );
            }
            $this->redirect( array( 'action' => 'index' ) );
        }
        $archivo = new File(  ROOT . DS . APP_DIR . DS . 'View'. DS . 'Pages' . DS . $nombre .'.ctp' );
        if( $archivo->exists() ) {
            if( $archivo->open( 'r' ) ) {
                $contenido = $archivo->read();
                //$this->layout = 'default';
                $this->set( 'content', $contenido );
                $this->set( 'nombre', $nombre );
            } else {
                throw new NotFoundException( "No se puede acceder al archivo especificado".$archivo->pwd() );
            }
        } else {
            throw new NotFoundException( 'La pagina que esta intentando editar no existe: '. ROOT . DS . APP_DIR . DS . 'View'. DS . 'Pages' . DS . $nombre .'.ctp' );
        }
    }
    
}
