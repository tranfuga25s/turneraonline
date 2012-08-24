<?php

App::uses('CakeEmail', 'Network/Email');

class TurnosShell extends AppShell {

	var $uses = array( 'Clinica', 'Medico', 'Disponibilidad', 'Turno', 'Secretaria' );

	public function main() {
		$this->out('Opciones de la consola de turnos:');
		$this->out('');
		$this->out('Comandos:');
		$this->out(' - generarTurnos: Genera los turnos para todas las clinicas y todos los medicos según su disponibilidad.');
		$this->out(' - borrarAnteriores: Borra todos los turnos de todos los médicos que estén antes del día de hoy y que no hayan sido reservados. Utilizado para mejorar el rendimiento de la base de datos.');
		$this->out(' - enviarResumenDiario: Para cada secretaria envía un resumen de tabla sobre los turnos del día en que se está ejecutando el comando con los datos reserados hasta el momento para ese día.' );
	}

	public function generarTurnos() {
		// Llamada automatizada para actualizar los turnos todos los días.
		// Utilizar cron
		Configure::load( '', 'Turnera' );
		$dias = array( 0 => 'domingo', 1 => 'lunes', 2 => 'martes', 3 => 'miercoles', 4 => 'jueves', 5 => 'viernes', 6 => 'sabado'  );
		// Genero un bucle con cada medico en cada clinica
		$clinicas = $this->Clinica->find( 'all', array( 'fields' => array( 'id_clinica', 'nombre' ), 'recursive' => -1 ) );
		foreach( $clinicas as $clinica ) {
			echo "Generando turnos para la clinica ".$clinica['Clinica']['nombre']."\n";
			echo "================================================================\n";
			$medicos = $this->Medico->find( 'list', array( 'conditions' => array( 'clinica_id' => $clinica['Clinica']['id_clinica'] ), 'fields' => array( 'id_medico' ) ) );
			foreach( $medicos as $medico ) {
				echo "Generando turnos para el medico " . $medico. "\n";
				echo "----------------------------------------------\n";
				$this->Medico->Disponibilidad->unbindModel( array( 'belongsTo' => array( 'Medico' ) ) );
				$disponibilidad = $this->Medico->Disponibilidad->find( 'first', array( 'conditions' => array( 'medico_id' => $medico ), 'recursive' => 1 ) );
				if( $disponibilidad == null ) { echo "Error -> disponibilidad de medico no encontrada.\n ---> No se generan turnos.\n"; continue; }
				if( count( $disponibilidad['DiaDisponibilidad'] ) <= 0 ) {
					echo "--> No tiene ningun día definido.\n";
					continue;
				} else {
					// Actualizo los indices del array para que me queden segun el numero del día
					$dn = array();
					foreach( $disponibilidad['DiaDisponibilidad'] as $d ) {
						$dn[$d['dia']] = $d;
					}
					$disponibilidad['DiaDisponibilidad'] = $dn;
				}

				$cant_dias = Configure::read( 'Turnera.dias_turnos' );
				echo "----------------------------------------------\n";
				echo "- Cantidad de dias:".$cant_dias."\n";
				echo "----------------------------------------------\n";
				echo "-- Inicio de generación de turnos\n";
				echo "-- Buscando ultimo turno generado\n";
				$ultimo = $this->Turno->find( 'first',
						array( 'conditions' => 
							array(  'medico_id' => $disponibilidad['Disponibilidad']['medico_id'],
								'consultorio_id' => $disponibilidad['Disponibilidad']['consultorio_id'] 
								),
							'recursive' => -1,
							'order' => array( 'fecha_inicio' => 'DESC' )
							)
						);
				// Calculo cuantos días hay desde hoy hasta el ultimo día y resto
				$iniciar_desde = 0;
				if( $ultimo != null ) {
					//pr( $ultimo );
					$f1 = new DateTime( 'now' );
					$f1->add( new DateInterval( "P".$cant_dias."D" ) );
					$f2 = new DateTime( 'now' );
					$f2->setDate( date( 'Y', strtotime( $ultimo['Turno']['fecha_fin'] ) ), date( 'm', strtotime( $ultimo['Turno']['fecha_fin'] ) ), date( 'd', strtotime( $ultimo['Turno']['fecha_fin'] ) ) );
					// Calculo la dif de dias y se lo resto a cant de dias para obtener la cantida de dias a generar
					$cant_dif = $f1->diff( $f2 )->days;
					echo "---- Cant dias dif=".$cant_dif."\n";
					if( $cant_dias > $cant_dif ) {
						$iniciar_desde = $cant_dias - $cant_dif;
						echo "---- Realizando solo ".$cant_dias. " iteraciones de fechas\n";
					}
				} else {
					echo "No hay turnos anteriores.\n";
				}
				for( $d = $iniciar_desde; $d < $cant_dias; $d++ ) {
					$fecha_inicio_dia = new DateTime( 'now' );
					$fecha_inicio_dia->add( new DateInterval( "P".$d."D" ) );
					// Verifico que ese día atienda
					// Teoricamente la relación está ordenada 0 -> domingo, 1 -> martes, etc...
					$dia_sem = $fecha_inicio_dia->format( 'w' );
					if( ! isset( $disponibilidad['DiaDisponibilidad'][$dia_sem] ) ) {
						echo "-> Dia no declarado como disponible - $dia_sem - $dias[$dia_sem]\n";
						continue;
					} else if( ! $disponibilidad['DiaDisponibilidad'][ $dia_sem]['habilitado'] ) {
						continue;
					}
					if( $disponibilidad['DiaDisponibilidad'][$dia_sem]['hora_inicio'] != null ) {
						$t = split( ":", $disponibilidad['DiaDisponibilidad'][$dia_sem]['hora_inicio'] );
						$fecha_inicio_dia->setTime( $t[0], $t[1], $t[2] );
						// calculo la cantidad de pasos que tengo que hacer
						$fecha_fin_dia = clone $fecha_inicio_dia;
						$t = split( ":", $disponibilidad['DiaDisponibilidad'][$dia_sem]['hora_fin'] );
						$fecha_fin_dia->setTime(  $t[0], $t[1], $t[2] );
						$dif = $fecha_inicio_dia->diff( $fecha_fin_dia );
						$txd = floor( ( $dif->format( '%h' ) * 60 + $dif->format( '%i' ) ) / $disponibilidad['Disponibilidad']['duracion'] );
						// Primer turno
						$finicio = clone $fecha_inicio_dia;
						// Hago el bucle
						for( $t = 0; $t < $txd; $t++ ) {
							if( $finicio >= $fecha_fin_dia ) {
								// El turno este no se tiene que realizar
								$t = $txd+1;
								continue;
							}
							$this->Turno->create();
							$ffin = clone $finicio;
							$ffin->add( new DateInterval( "PT".$disponibilidad['Disponibilidad']['duracion']."M" ) );
							$data = array(  'Turno' =>
									array(	'fecha_inicio'   => $finicio->format( 'Y-m-d H:i:s' ),
										'fecha_fin'      => $ffin->format( 'Y-m-d H:i:s' ),
										'medico_id'      => $disponibilidad['Disponibilidad']['medico_id'],
										'consultorio_id' => $disponibilidad['Disponibilidad']['consultorio_id'],
										'paciente_id'    => null,
										'recibido'       => false,
										'atendido'       => false,
										'cancelado'	 => false
									)
								);
							if( !$this->Turno->save( $data ) ) {
								echo "Error al guardar el turno";
							} else {
								echo "Generado turno ". $data['Turno']['fecha_inicio']. "\n";
							}
							$finicio->add( new DateInterval( "PT".$disponibilidad['Disponibilidad']['duracion']."M" ) );
						}
					}
					if( $disponibilidad['DiaDisponibilidad'][$dia_sem]['hora_inicio_tarde'] != null || $disponibilidad['DiaDisponibilidad'][$dia_sem]['hora_inico_tarde'] != "00:00:00" ) {
						$t = split( ":", $disponibilidad['DiaDisponibilidad'][$dia_sem]['hora_inicio_tarde'] );
						$fecha_inicio_dia->setTime( $t[0], $t[1] );
						// calculo la cantidad de pasos que tengo que hacer
						$fecha_fin_dia = clone $fecha_inicio_dia;
						$t = split( ":", $disponibilidad['DiaDisponibilidad'][$dia_sem]['hora_fin_tarde'] );
						$fecha_fin_dia->setTime(  $t[0], $t[1] );
						$dif = $fecha_inicio_dia->diff( $fecha_fin_dia );
						$txd = floor( ( $dif->format( '%h' ) * 60 + $dif->format( '%i' ) ) / $disponibilidad['Disponibilidad']['duracion'] );
						// Primer turno
						$finicio = clone $fecha_inicio_dia;
						// Hago el bucle
						for( $t = 0; $t < $txd; $t++ ) {
							if( $finicio >= $fecha_fin_dia ) {
								// El turno este no se tiene que realizar
								$t = $txd+1;
								continue;
							}
							$this->Turno->create();
							$ffin = clone $finicio;
							$ffin->add( new DateInterval( "PT".$disponibilidad['Disponibilidad']['duracion']."M" ) );
							$data = array(  'Turno' =>
									array(	'fecha_inicio'   => $finicio->format( 'Y-m-d H:i:s' ),
										'fecha_fin'      => $ffin->format( 'Y-m-d H:i:s' ),
										'medico_id'      => $disponibilidad['Disponibilidad']['medico_id'],
										'consultorio_id' => $disponibilidad['Disponibilidad']['consultorio_id'],
										'paciente_id'    => null,
										'recibido'       => false,
										'atendido'       => false,
										'cancelado'	 => false
									)
								);
							if( !$this->Turno->save( $data ) ) {
								echo "Error al guardar el turno";
							} else {
								echo "Generado turno ". $data['Turno']['fecha_inicio']. "\n";
							}
							$finicio->add( new DateInterval( "PT".$disponibilidad['Disponibilidad']['duracion']."M" ) );
						}
					}
					echo "------ Fin del día <-\n";
				}
				echo "---- Fin del medico <-\n";
			}
			echo "--- Fin clinica <-\n";
		}
		return;
	}

	public function borrarAnteriores() {
		// Busca todos los turnos anteriores al día de hoy para cualquier clinia y medico y si no están reservados los elimina.
		pr( $this->Turno->find( 'all', array( 'conditions' => array( 'paciente_id IS NULL', 'fecha_fin <= NOW()' ), 'recursive' => -1 ) ) );
		$this->Turno->deleteAll( array( 'paciente_id IS NULL', 'fecha_fin <= NOW()' ) );
	}

    public function enviarResumenDiario() {
    	// Busca para cada secretaria si desea el resumen y envía el resumen diario al correo
		$ids = $this->Secretaria->find( 'list', array( 'fields' => array( 'id_secretaria' ) ) );
		if( count( $ids ) > 0 ) {
			echo "---------------------------------------------\n";
			echo "-- Enviando resumenes de turnos para el día -\n";
			echo "---------------------------------------------\n";
			echo "Encontradas ".count( $ids )." secretarias... \n";
			echo "---------------------------------------------\n";
			foreach( $ids as $id ) {
				// Busco el correo electronico y los datos
				$secretaria = $this->Secretaria->read( null, $id );
				if( $secretaria['Secretaria']['resumen'] == true ) {
					$clinica = $this->Clinica->read( null, $secretaria['Secretaria']['clinica_id'] );
					// Busco los turnos del día
					$inicio = new DateTime('now');
					$fin = clone $inicio;
					$inicio->setTime( 0, 0, 0 );
					$fin->setTime( 23, 59, 59 );
					$this->Turno->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( `Paciente`.`apellido`, \', \', `Paciente`.`nombre` )'  );
					$turnos = $this->Turno->find( 'all', 
									array( 'conditions' => 
										array( '`Turno`.`fecha_inicio` >= \''.$inicio->format( 'Y-m-d H:i:s' ).'\'',
											   'fecha_fin <= \''.$fin->format( 'Y-m-d H:i:s' ).'\'' ) ) );
					$de = Configure::read( 'Turnera.email_notificaciones' );
					if( empty( $de )  ) { $de = 'info@alejandrotalin.com.ar'; }										   
					$email = new CakeEmail();
					$email->to( $secretaria['Usuario']['email'] );
					$email->subject( 'Turnos del día '.$inicio->format( 'Y-m-d H:i:s' ) );
					$email->emailFormat( 'both' );
					$email->from( $de );
					$email->viewVars( array( 'nombre_clinica' => $clinica['Clinica']['nombre'],
											 'secretaria' => $secretaria,
											 'turnos' => $turnos,
											 'fecha' => $inicio->format( 'd/m/Y' ) ) );
					$email->template( 'resumen_diario', 'secretaria' );										 						 
					$email->send();
					echo " - - - > Email enviado a ".$secretaria['Usuario']['email']."... \n";
				} else {
					echo " - - > La secretaria ". $secretaria['Usuario']['razonsocial']." no quiere resumen \n";
				}
			}
			echo "- Fin generación de emails - \n";			
		} else {
			echo "- Ninguna secretaria declarada <- \n";
		}
		
    }
}
?>