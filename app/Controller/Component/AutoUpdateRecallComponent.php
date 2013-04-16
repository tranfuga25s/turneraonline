<?php 
/*
 * Pagination Recall CakePHP Component
 * Copyright (c) 2008 Matt Curry
 * www.PseudoCoder.com
 *
 * @author      mattc <matt@pseudocoder.com>
 * @version     1.0
 * @license     MIT
 *
 */
 
 App::uses( 'Component', 'Controller' );

class AutoUpdateRecallComponent extends Component {
  	
  var $components = array('Session');
  
  var $Controller = null;
  
  var $default_value = true;

  function startup( &$controller ) {
    $this->Controller = & $controller;

    $options = $this->Controller->request->params['named'];
	
	if( !$this->Session->check( 'actualizacion' ) ) {
		$controller->set( 'actualizacion', $this->default_value );	
	} else {
		$controller->set( 'actualizacion', $this->Session->read( 'actualizacion' ) );
	}

  }
  
  /**
   * Cambia el valor actual de la session de autoactualizacion
   * @param $valor boolean Valor a cambiar
   * @param $mensaje boolean Muestra o no el mensaje de cambio de valor
   * @param $flash_elem string Elemento para mostrar el flash
   */
  public function cambiarAutoActualizacion( $valor = true, $mensaje = true, $flash_elem = 'default' ) {
  	
  		if( $valor == 0 ) 
  			$valor = false;
		
		if( $valor == 1 ) 
			$valor = true;
		
  		$this->Session->write( "actualizacion", $valor );
		$this->Controller->set( 'actualizacion', $valor );
	
		if( $mensaje ) {
			if( $valor == false ) {
				$accion = " deshabilitada ";
			} else { $accion = " habilitada"; }
			$this->Session->setFlash( 'Auto actualización de la página ha sido' . $accion, $flash_elem );
		}
  }
  
}