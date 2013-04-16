<?php 
/*
 * * Mantiene el día en que debe ser mostrados los turnos guardandolos en las variables de sesion
 * Copyright (c) 2013 Zeller Esteban
 * www.gestotux.com.ar
 *
 * @author      trafuga25s <trafuga25s@gmail.com>
 * @version     1.0
 * @license     GPL3
 *
 */
 App::uses( 'Component', 'Controller' );

class DiaTurnoRecallComponent extends Component {
  	
  var $components = array( 'Session' );
  
  var $Controller = null;
  
  var $dia = null;
  var $mes = null;
  var $ano = null;
  
  var $sessionvar = null;
  
  function __construct( ComponentCollection $collection, $settings = array() ) {
  	if( array_key_exists( "variable", $settings ) ) {
  		$this->sessionvar = $settings['variable'].".";
  	} else {
  		$this->sessionvar = '';
  	}
	parent::__construct( $collection, $settings );
  }

  function startup( &$controller ) {
    $this->Controller = & $controller;

	if( !$this->Session->check( $this->sessionvar."dia" ) ) {
		$this->Session->write( $this->sessionvar."dia", date( 'j' ) );
		$this->Session->write( $this->sessionvar."mes", date( 'n' ) );
		$this->Session->write( $this->sessionvar."ano", date( 'Y' ) );
	}
	$this->dia = $this->Session->read( $this->sessionvar."dia" );
	$this->mes = $this->Session->read( $this->sessionvar."mes" );
	$this->ano = $this->Session->read( $this->sessionvar."ano" );
	
  }
  
  function beforeRender( &$controller ) {
	$this->Controller->set( 'fechas', $this->dia."/".$this->mes."/".$this->ano );
	$this->Controller->set( 'dia', $this->dia );
	$this->Controller->set( 'mes', $this->mes-1 ); // Lista de meses base 0 
	$this->Controller->set( 'ano', $this->ano ); 
  }
  
  /**
   * Cambia el valor actual de la session de autoactualizacion
   * @param $valor boolean Valor a cambiar
   * @param $mensaje boolean Muestra o no el mensaje de cambio de valor
   */
  public function cambiarDia( $dia, $mes, $ano ) {
  	
		if( $this->Session->read( $this->sessionvar."dia" ) != $dia ) {
			$this->Session->write( $this->sessionvar."dia", $dia );
		}
		if( $this->Session->read( $this->sessionvar."mes" ) != $mes ) {
			$this->Session->write( $this->sessionvar."mes", $mes );
		}
		if( $this->Session->read( $this->sessionvar."ano" ) != $ano ) {
			$this->Session->write( $this->sessionvar."ano", $ano );
		}
		$this->dia = $dia;
		$this->mes = $mes;
		$this->ano = $ano;
  }
  
  public function dia() { return $this->dia; }
  public function mes() { return $this->mes; }
  public function ano() { return $this->ano; }
  
}