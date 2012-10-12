<?php
class EstadisticasController extends AppController {
	var $uses = array( 'Usuario', 'Turnos' );
	var $components = array( 'RequestHandler' );
	//var $helpers = array( 'JsGraph' );
	
	public function beforeFilter() {
		$this->layout = 'ajax';
		parent::beforeFilter();
	}
	
	public function administracion_index() {
		$this->layout = 'administracion';
		// Simplemente renderiza la vista
		$this->set( 'acciones',
			array( 'usuariosDeclarados' => "Cantidad de usuarios según tipo",
				   'usuariosActivos' => "Cantidad de usuarios activos en el último mes",
				   'turnosGuardadosFuturos' => "Proporcion de turnos historicos y a futuro",
				   'turnosFuturoReserva' => "Proporcion de turnos a futuro libres y reservados",
				   'turnosReservaSecretariaUsuarios' => "Cantidad de turnos reservados por secretarias y por pacientes",
			)
		);
	}
	
	/*
	 * Devuelve la cantidad de usuarios declarados según su tipo
	 */ 
	public function usuariosDeclarados() {
		// Busco la cantidad de usuarios por tipo
		$this->set( 'total_usuarios', $this->Usuarios->find( 'count' ) );
		$this->set( 'datos', $this->Usuarios->find( 'count', array( 'group' => 'group_id' ) ) );
		$this->set( 'etiquetas', $this->Grupos->find( 'list' ) );
	}
	
	/*
	 * Devuelve la proporción de usuarios activos e inactivos durante los N meses anteriores
	 */ 
	public function usuariosActivos( $meses = 1 ) {
		// Total de pacientes declarados en el sistema
		$this->set( 'total_pacientes', $this->Usuarios->find( 'count', array( 'conditions' => array( 'grupo_id' => 1 ) ) ) );
		// Busco todos los pacientes que estan declarados en algún turno dentro de una cierta fecha
		$fecha_hoy = new Date();
		$fecha_antes = new Date();
		$fecha_antes->sub( new DateInterval( "P".$meses."M" ) );
		$this->set( 'cant_activos', $this->Turnos->find( 'count', array( 'conditions' => array( 'DATE(fecha_inicio) >=' => $fecha_antes->format( ),
									   															'DATE(fecha_inicio) <=' => $fecha_hoy->format( ) ),
											 							 'fields' => array( ),
											 							 'group' => array( ) ) ) );
	}
	
	/*
	 * Devuelve la cantidade turnos historicos guardados y la cantidad de turnos a futuro
	 */
	public function turnosGuardadosFuturos() {
		$this->set( 'anteriores', $this->Turno->find( 'count', array( 'conditions' => array( 'DATE( fecha_inicio ) <=' => 'NOW()' ) ) ) );
		$this->set( 'futuro'    , $this->Turno->find( 'count', array( 'conditions' => array( 'DATE( fecha_inicio ) >' => 'NOW()' ) ) ) );
	}
	
	/*
	 * Devuelve la proporcion de turnos a futuro reservados y no reservados
	 */ 
	public function turnosFuturoReserva() {
		
	}
	
	/*
	 * Devuelve la grafica de proporcion entre turnos reservados por usuarios y los reservados x la secretaria en un periodo de tiempo 
	 */
	public function turnosReservaSecretariaUsuarios() {
		
	}	
	
}
?>