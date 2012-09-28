<?php

class ContactoController extends AppController {
	
	var $uses = array( 'Usuario', 'Turnos' );
	var $components = array( 'RequestHandler' );
	/* Tamaño de los graficos generados */
	public $tamano = array( 'ancho' => 300, 'alto' => 300 );
	
	public function index() {
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
		$this->set( 'datos', $this->Usuarios->find( 'count', array( 'groupBy' => 'group_id' ) ) );
		$this->set( 'etiquetas', $this->Grupos->find( 'list' ) );
	}
	
	/*
	 * Devuelve la proporción de usuarios activos e inactivos durante los n meses anteriores
	 */ 
	public function usuariosActivos( $meses = 1 ) {
		
	}
	
	/*
	 * Devuelve la cantidade turnos historicos guardados y la cantidad de turnos a futuro
	 */
	public function turnosGuardadosFuturos() {
		
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