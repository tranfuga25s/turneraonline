<?php
App::uses('GoogleChart', 'GoogleChart.Lib');

class EstadisticasController extends AppController {
	public $uses = array( 'Usuario', 'Turno', 'Grupo' );
	public $components = array( 'RequestHandler' );
	public $helpers = array('GoogleChart.GoogleChart');

	public function beforeFilter() {
		$this->layout = 'ajax';
		parent::beforeFilter();
	}

	public function administracion_index() {
		$this->layout = 'administracion';
		// Simplemente renderiza la vista
		$this->set( 'acciones',
			array( array( 'accion' => 'usuariosDeclarados'    			, 'titulo' => "Cantidad de usuarios según tipo" ),
				   array( 'accion' => 'usuariosActivos'       			, 'titulo' => "Cantidad de usuarios activos en el último mes" ),
				   array( 'accion' => 'turnosGuardadosFuturos'			, 'titulo' => "Proporcion de turnos historicos y a futuro" ),
				   array( 'accion' => 'turnosFuturoReserva'   			, 'titulo' => "Proporcion de turnos a futuro libres y reservados" ),
				  /* array( 'accion' => 'turnosReservaSecretariaUsuarios'	, 'titulo' => "Cantidad de turnos reservados por secretarias y por pacientes" )*/
			)
		);
	}

	/*
	 * Devuelve la cantidad de usuarios declarados según su tipo
	 */
	public function administracion_usuariosDeclarados() {
		// Busco la cantidad de usuarios por tipo
		$this->Usuario->recursive = -1;
		$total_usuarios = $this->Usuario->find( 'count' );
        $this->Usuario->virtualFields = array( 'cantidad' => ' COUNT( `Usuario`.`id_usuario` )' );
		$datos = $this->Usuario->find( 'all', array( 'group' => 'grupo_id',
		                                               'fields' => array( 'grupo_id', 'cantidad' ),
		                                               'recursive' => -1 ) );
		$etiquetas = $this->Grupo->find( 'list' );

		$grafico = new GoogleChart();
		$grafico->type( "PieChart" );
		$grafico->options( array( 'title' => ' Cantidad de Usuarios según tipo' ) );
		$grafico->columns( array(
			"grupo" => array(
				'type' => 'string',
				'label' => 'Grupo'
			),
			"cantidad" => array(
				'type' => 'number',
				'label' => 'Cantidad de Usuarios'
			) ) );
		foreach( $datos as $k => $d ) {
		    if( array_key_exists( $d['Usuario']['grupo_id'], $etiquetas) ) {
			 $grafico->addRow( array( 'grupo' => $etiquetas[$d['Usuario']['grupo_id']], 'cantidad' => count( $d )  ) );
            } else {
                $this->log( 'Error: el grupo '.$d['Usuario']['grupo_id'].' no existe y salió en la estadisticas' );
            }
		}
		$this->set( 'nombre_div', 'usuariosDeclarados' );
		$this->set( 'grafico', $grafico );
		$this->render( 'grafico' );

	}

	/*
	 * Devuelve la proporción de usuarios activos e inactivos durante los N meses anteriores
	 */
	public function administracion_usuariosActivos( $meses = 1 ) {
		// Total de pacientes declarados en el sistema
		$total_pacientes = $this->Usuario->find( 'count', array( 'recursive' => -1 ) );
		// Busco todos los pacientes que estan declarados en algún turno dentro de una cierta fecha
		$fecha_hoy = new DateTime();
		$fecha_antes = new DateTime();
		$fecha_antes->sub( new DateInterval( "P".$meses."M" ) );
		$cant_activos = $this->Turno->find( 'all', array( 'conditions' => array( 'DATE(fecha_inicio) >=' => $fecha_antes->format( 'Y-m-d' ),
									   											 'DATE(fecha_inicio) <=' => $fecha_hoy->format( 'Y-m-d' ) ),
											 			  'group' => array( 'paciente_id' ),
											 			  'fields' => array( 'id_turno' ),
											 			  'recursive' => -1 ) );
		$cant_activos = count( $cant_activos );
		$grafico = new GoogleChart();
		$grafico->type( "PieChart" );
		$grafico->options( array( 'title' => ' Cantidad de Usuarios activos e inactivos' ) );
		$grafico->columns( array(
			"grupo" => array(
				'type' => 'string',
				'label' => 'Grupo'
			),
			"cantidad" => array(
				'type' => 'number',
				'label' => 'Cantidad de Usuarios'
			) ) );
		$grafico->addRow( array( 'grupo' => "Activos", 'cantidad' => $cant_activos ) );
		$grafico->addRow( array( 'grupo' => "Inactivos", 'cantidad' => ($total_pacientes-$cant_activos) ) );

		$this->set( 'nombre_div', 'usuarioActivos' );
		$this->set( 'grafico', $grafico );
		$this->render( 'grafico' );
	}

	/*
	 * Devuelve la cantidade turnos historicos guardados y la cantidad de turnos a futuro
	 */
	public function administracion_turnosGuardadosFuturos() {
		$anteriores = $this->Turno->find( 'count', array( 'conditions' => array( 'DATE( fecha_inicio ) <= NOW()' ),
		                                                  'recursive' => -1 ) );
		$futuro     = $this->Turno->find( 'count', array( 'conditions' => array( 'DATE( fecha_inicio ) > NOW()' ),
		                                                  'recursive' => -1 ) );

		$grafico = new GoogleChart();
		$grafico->type( "PieChart" );
		$grafico->options( array( 'title' => 'Turnos Historicos vs Turnos a futuro' ) );
		$grafico->columns( array(
			"grupo" => array(
				'type' => 'string',
				'label' => 'Grupo'
			),
			"cantidad" => array(
				'type' => 'number',
				'label' => 'Cantidad de Usuarios'
			) ) );
		$grafico->addRow( array( 'grupo' => "Historicos", 'cantidad' => $anteriores ) );
		$grafico->addRow( array( 'grupo' => "Futuros"   , 'cantidad' => $futuro ) );

		$this->set( 'nombre_div', 'turnosGuardadosFuturo' );
		$this->set( 'grafico', $grafico );
		$this->render( 'grafico' );

	}

	/*
	 * Devuelve la proporcion de turnos a futuro reservados y no reservados
	 */
	public function administracion_turnosFuturoReserva() {
		$reservados   = $this->Turno->find( 'count', array( 'conditions' => array( 'DATE( fecha_inicio ) > NOW()', 'paciente_id IS NOT NULL' ),
		                                                    'recursive' => -1 ) );
		$noReservados = $this->Turno->find( 'count', array( 'conditions' => array( 'DATE( fecha_inicio ) > NOW()', 'paciente_id' => null ),
		                                                    'recursive' => -1 ) );
		$grafico = new GoogleChart();
		$grafico->type( "PieChart" );
		$grafico->options( array( 'title' => 'Cantidad de turnos reservados vs libres' ) );
		$grafico->columns( array(
			"grupo" => array(
				'type' => 'string',
				'label' => 'Grupo'
			),
			"cantidad" => array(
				'type' => 'number',
				'label' => 'Cantidad de Turnos'
			) ) );
		$grafico->addRow( array( 'grupo' => "Reservados", 'cantidad' => $reservados ) );
		$grafico->addRow( array( 'grupo' => "Libres", 'cantidad' => $noReservados ) );

		$this->set( 'nombre_div', 'turnosFuturoReserva' );
		$this->set( 'grafico', $grafico );
		$this->render( 'grafico' );

	}

	/*
	 * Devuelve la grafica de proporcion entre turnos reservados por usuarios y los reservados x la secretaria en un periodo de tiempo
	 */
	public function administracion_turnosReservaSecretariaUsuarios() {

		$this->set( 'grafico', $grafico );
		$this->render( 'grafico' );
	}

}
?>