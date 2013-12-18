<?php
App::uses('AppModel', 'Model');
/**
 * Turno Model
 *
 * @property Paciente $Paciente
 * @property Medico $Medico
 * @property Consultorio $Consultorio
 */
class Turno extends AppModel {

	public $primaryKey = 'id_turno';
	public $actAs = array( 'AuditLog.Auditable' );
	public $validate = array(
		'fecha_inicio' => array(
			'datetime' => array( 'rule' => array('datetime') )
		),
		'fecha_fin' => array(
			'datetime' => array( 'rule' => array('datetime') )
		),
		'recibido' => array(
			'boolean' => array( 'rule' => array('boolean') )
		),
		'atendido' => array(
			'boolean' => array( 'rule' => array('boolean') )
		),
		'cancelado' => array(
			'boolean' => array( 'rule' => array('boolean') )
		)
	);

	public $belongsTo = array(
		'Paciente' => array(
			'className' => 'Usuario',
			'foreignKey' => 'paciente_id',
			/*'conditions' => 'Paciente.grupo_id = 4',*/
			'fields' => '',
			'order' => ''
		),
		'Medico' => array(
			'className' => 'Medico',
			'foreignKey' => 'medico_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Consultorio' => array(
			'className' => 'Consultorio',
			'foreignKey' => 'consultorio_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/*!
	 * Busca los turnos disponibles para dar a los pacientes, y los devuelve en un array de la forma
	 * array( 2012 => array( 1 => array( 1, 2, ... ) ) )
	 * El día se devolverá si existe algun turno en el.
	 */
	public function buscarDisponibilidad( $mes, $ano, $id_clinica, $id_especialidad, $id_medico, $solo_visibles = false ) {
		/**************************
		 *  estructura a armar
		 * array( 'ano' => array( 'mes' => array( 'dia', 'dia' ) ) );
		 **************************/
		 $medicos = array();
		 if( $id_medico == null || $id_medico == 0 ) {
			// Busco todos los medicos de esta clinica y especialidad
			$condiciones = array();
			if( $id_clinica != 0 ) {
				$condiciones = array_merge( $condiciones, array( 'clinica_id' => $id_clinica ) );
			}
			if(  $id_especialidad != 0 ) {
				$condiciones = array_merge( $condiciones, array( 'especialidad_id' => $id_especialidad ) );
			}
			if( $solo_visibles ) {
				$condiciones = array_merge( $condiciones, array( 'visible' => true ) );
			}
			$medicos = $this->Medico->find( 'list',
					array( 'fields' => 'id_medico',
					       'conditions' => $condiciones )
					);
			if( count( $medicos ) < 0 ) {
				return array( date( "Y" ) => array( date( "m" ) => array() ) );
			}
		 } else {
			$medicos = $id_medico;
		 }
		$mactual = date( 'm' );
		if( $mes < $mactual ) { $mes = $mactual; }
		if( $mes == $mactual ) {
			$dia = date( 'd' );
		} else { $dia = 1; }
        // Si la fecha es hoy, pongo el horario como corresponde
        if( date( 'd', mktime( 0, 0, 0, $mes, $dia, $ano ) ) == date( 'd' ) ) {
            $condfinicio = 'fecha_inicio';
            $finicio = date( 'Y-m-d H:m:s' );
        } else {
            $condfinicio = 'DATE( fecha_inicio)';
            $finicio = date( 'Y-m-d', mktime( 0, 0, 0, $mes, $dia, $ano ) );
        }
		$condiciones = array(  $condfinicio.' >= ' => $finicio,
  			                   'DATE( fecha_fin    ) <= ' => date( 'Y-m-d', mktime( 23, 59, 59, $mes, date( 't', mktime( 0, 0, 0, $mes, 1, $ano ) ), $ano ) ),
  			                   'paciente_id IS NULL',
  			                   'cancelado != 1' );
		if( $medicos != array() ) {
			$condiciones = array_merge( $condiciones, array( 'medico_id' => $medicos ) );
		}
		$this->virtualFields = array( 'dia' => 'DATE_FORMAT( fecha_inicio,  \'%e\' )',
		                              'cantidad' => 'COUNT( DATE_FORMAT( fecha_inicio, \'%e\' ) )' );
		$datos =  $this->find( 'all',
				array(  'conditions' => $condiciones,
					    'order' => array( '`Turno__dia`' ),
					    'recursive' => -1,
					    'group' => 'dia',
					    'fields' => array( 'COUNT( DATE_FORMAT( fecha_inicio, \'%e\' ) ) as `Turno__cantidad`',
					                       'DATE_FORMAT( fecha_inicio, \'%e\' ) as `Turno__dia`' )
			     )
		);
		$this->virtualFields = null;
		$dias = array();
        //debug( $datos );
		if( count( $datos ) > 0 ) {
			foreach( $datos as $dato ) {
				$dias[$dato['Turno']['dia']] = $dato['Turno']['cantidad'];
			}
		} else {
			$dias = array();
		}
		return array( $ano => array( $mes => $dias ) );
	}

	/*!
	 * Busca los turnos disponibles para dar a los pacientes de un día determinado
	 * Se buscará durante todo el día marcado por los parametros empezando en hora:minuto determinado
	 * Si el id del medico es 0, se buscarn los medicos de la clinica con la especialidad determinada.
	 * Si pacientes es falso no se cargaran los datos del paciente. Si es verdadero se vinculará la información del paciente si existe alguna.
	 */
	public function buscarTurnos( $dia = null, $mes = null, $ano = null, $id_clinica = null, $id_especialidad = null, $id_medico = null, $pacientes = false, $hora = 0, $min = 0 ) {
		if( $id_medico == 0 ) {
			// Busco todos los medicos de esta clinica y especialidad
			$condiciones = array();
			if( $id_clinica != 0 ) {
				$condiciones = array_merge( $condiciones, array( 'clinica_id' => $id_clinica ) );
			}
			if( $id_especialidad != 0 ) {
				$condiciones = array_merge( $condiciones, array( 'especialidad_id' => $id_especialidad ) );
			}
			$condiciones = array_merge( array( 'visible' => true ), $condiciones );
			$medicos = $this->Medico->find( 'list',
					array( 'fields' => 'id_medico',
					       'conditions' => $condiciones )
					);
			if( count( $medicos ) <= 0 ) {
				return array();
			}
		} else {
			$medicos = $id_medico;
		}
		$this->virtualFields = array( 'hora' => 'DATE_FORMAT( fecha_inicio, \'%k\' )', 'minuto' => 'DATE_FORMAT( fecha_inicio, \'%i\') ',
					      'horaf' => 'DATE_FORMAT( fecha_fin, \'%k\' )', 'minutof' => 'DATE_FORMAT( fecha_fin, \'%i\' ) ',
					      'duracion' => 'TIME_FORMAT( TIMEDIFF( fecha_fin, fecha_inicio), \'%i\' )' );
		if( !$pacientes ) {
			$this->unbindModel( array( 'belongsTo' => array( 'Paciente' ) ) );
		} else {
			$this->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( `Paciente`.`apellido`, \', \', `Paciente`.`nombre` )'  );
		}
		$f1 = new DateTime( 'now' );
		$f1->setDate( $ano, $mes, $dia );
		$f1->setTime( $hora, $min );
		$f2 = clone $f1;
		$f2->add( new DateInterval( "P1D" ) );
		$f2->setTime( 23, 59, 59 );
        $this->unbindModel( array( 'belongsTo' => array( 'Medico' ) ) );
		return  $this->find( 'all', array(
			'conditions' => array(
				'medico_id' => $medicos,
				'paciente_id IS NULL',
				'cancelado != 1',
				"DATE( fecha_inicio ) >=" => $f1->format( 'Y-m-d' ),
				"DATE( fecha_fin ) <" => $f2->format( 'Y-m-d' ),
				"TIME( fecha_inicio ) >=" => $f1->format( 'H:i:s' ),
				"TIME( fecha_fin ) <=" => $f2->format( 'H:i:s' )
				),
			'recursive' => 1,
			'order' => array( 'fecha_inicio' )
			)
		);
	}

	/*!
	 * Busca los turnos anteriores que no caigan en la disponibilidad.
	 * Los turnos que no coincidan deberán estar dentro de un array que se retorna
	 */
	public function generarTurnos( $datos ) {
		// Busco los turnos anteriores
		$dias = array( 0 => 'domingo', 1 => 'lunes', 2 => 'martes', 3 => 'miercoles', 4 => 'jueves', 5 => 'viernes', 6 => 'sabado' );
		// array de turnos a cambiar
		$cambiar = array();
		$this->unbindModel( array( 'belongsTo' => array( 'Paciente') ) );
		$fecha_hoy = new DateTime();
		$fecha_hoy->setTime( 0, 0, 0 );
		$anteriores = $this->find( 'all', array( 'conditions' =>
							array( 	'medico_id' => $datos['Medico']['id_medico'],
								    'paciente_id IS NOT NULL',
								    'fecha_inicio >=' => $fecha_hoy->format( 'Y-m-d H:i:s' )
							) ) );
		// Fechas utlizadas para el rango de atencion cada día

		$num_dia = -1;
		// Veo si está dentro del rango de disponibilidad nuevo
		foreach( $anteriores as $turno ) {
			$num_dia = -1;
			$turno_tarde = false;
			// Veo si atiende ese día
			$n_dia = date( 'w', strtotime( $turno['Turno']['fecha_inicio'] ) );
			if( $datos['Medico'][$dias[$n_dia]] != 1 ) {
				$cambiar[] = $turno['Turno']['id_turno'];
				continue;
			} else {
				$num_dia = $n_dia;
			}
			if( $num_dia != -1 ) {
				// Si paso el filtro del día verifico que esté dentro del limite de los horarios del día
				$d1 = new DateTime( $turno['Turno']['fecha_inicio'] );
				$d2 = new DateTime( $turno['Turno']['fecha_fin']    );
				// Relleno los horarios segun corresponde
				$h1 = new DateTime( 'now' );
				$h1->setDate( $d1->format( 'Y' ), $d1->format( 'm' ), $d1->format( 'd' ) );
				$h1->setTime( $datos[$dias[$num_dia]]['hinicio'], $datos[$dias[$num_dia]]['minicio'] );
				$h2 = clone $h1;
				$h2->setTime( $datos[$dias[$num_dia]]['hfin'], $datos[$dias[$num_dia]]['mfin'] );
				if( $datos[$dias[$num_dia]]['hiniciotarde'] != 0 ) {
					$turno_tarde = true;
					$ht1 = clone $h1;
					$ht2 = clone $h1;
					$ht1->setTime( $datos[$dias[$num_dia]]['hiniciotarde'], $datos[$dias[$num_dia]]['miniciotarde'] );
					$ht2->setTime( $datos[$dias[$num_dia]]['hfintarde'], $datos[$dias[$num_dia]]['mfintarde'] );
				}
				// Realizo las comparaciones
				// d1 = hora de inicio del turno
				// d2 = hora de fin del turno
				// h1 = hora de inicio de atencion en el dia
				// h2 = hora de fin de atencion en el dia
				// ht1 = hora de inicio de atencion en el dia turno tarde
				// ht2 = hora de fin de atencion en el dia turno tarde
				if( !$turno_tarde ) {
					if( $d1 < $h1 || $d2 > $h2 || $d1 > $h2 )
					{  $cambiar[] = $turno['Turno']['id_turno'];  }
				} else {
					if( $d1 < $h1 || ( $d1 < $h2 && $d2 > $h2 && $d2 < $ht1 ) || ( $d1 > $ht1 && $d1 > $h2 ) || $d2 > $ht2 )
					{ $cambiar[] = $turno['Turno']['id_turno']; }
				}
			}
		} // Fin bucle turnos ya reservados
		// Una vez que tengo todos los turnos que no coinciden elimino todos los demás
		if( count( $cambiar ) > 0 ) {
			$this->deleteAll( array( 'medico_id' => $datos['Medico']['id_medico'],
									 'NOT' => array( 'id_turno', $cambiar ),
								    'fecha_inicio >=' => $fecha_hoy->format( 'Y-m-d H:i:s' ) ) );
		} else {
			$this->deleteAll( array( 'medico_id' => $datos['Medico']['id_medico'],
								    'fecha_inicio >=' => $fecha_hoy->format( 'Y-m-d H:i:s' ) ) );
		}
		////////////////////////////////////////
		// Regenero los turnos
		////////////////////////////////////////
		$cant_dias = Configure::read( 'Turnera.dias_turnos' );
		for( $d = 0; $d <= $cant_dias; $d++ ) {

			$fecha_inicio_dia = new DateTime( 'now' );
			$fecha_inicio_dia->add( new DateInterval( "P".$d."D" ) );
			$fecha_fin_dia = clone $fecha_inicio_dia;

			$turno_tarde = false;
			$num_dia = -1;
			// Verifico que ese día atienda
			switch( $fecha_inicio_dia->format( 'w' ) ) {
				case 0:
				{ if( $datos['Medico']['domingo'] == 1   ) { $num_dia = 0; } break; }
				case 1:
				{ if( $datos['Medico']['lunes'] == 1     ) { $num_dia = 1; } break; }
				case 2:
				{ if( $datos['Medico']['martes'] == 1    ) { $num_dia = 2; } break; }
				case 3:
				{ if( $datos['Medico']['miercoles'] == 1 ) { $num_dia = 3; } break; }
				case 4:
				{ if( $datos['Medico']['jueves']  == 1   ) { $num_dia = 4; } break; }
				case 5:
				{ if( $datos['Medico']['viernes']  == 1  ) { $num_dia = 5; } break; }
				case 6:
				{ if( $datos['Medico']['sabado']  == 1   ) { $num_dia = 6; } break; }
				default:
				{ $num_dia = -1; break; }
			}
			if( $num_dia != -1 ) {
				// Relleno los horarios segun corresponde
				$fecha_inicio_dia->setTime( $datos[$dias[$num_dia]]['hinicio'], $datos[$dias[$num_dia]]['minicio'] );
				$fecha_fin_dia->setTime( $datos[$dias[$num_dia]]['hfin'], $datos[$dias[$num_dia]]['mfin'] );
				if( $datos[$dias[$num_dia]]['hiniciotarde'] != 0 ) {
					$turno_tarde = true;
					$fecha_inicio_dia_tarde = clone $fecha_inicio_dia;
					$fecha_inicio_dia_tarde->setTime( $datos[$dias[$num_dia]]['hiniciotarde'], $datos[$dias[$num_dia]]['miniciotarde'] );
					$fecha_fin_dia_tarde = clone $fecha_inicio_dia_tarde;
					$fecha_fin_dia_tarde->setTime( $datos[$dias[$num_dia]]['hfintarde'], $datos[$dias[$num_dia]]['mfintarde'] );
				}

				// calculo la cantidad de pasos que tengo que hacer
				$dif = $fecha_inicio_dia->diff( $fecha_fin_dia );
				$txd = floor( ( $dif->format( '%h' ) * 60 + $dif->format( '%i' ) ) / $datos['Medico']['duracion'] );
				// Primer turno
				$finicio = clone $fecha_inicio_dia;
				// Hago el bucle
				for( $t = 0; $t < $txd; $t++ ) {
					if( $finicio >= $fecha_fin_dia ) {
						// El turno este no se tiene que realizar
						$t = $txd+1;
						continue;
					}
					$this->create();
					$ffin = clone $finicio;
					$ffin->add( new DateInterval( "PT".$datos['Medico']['duracion']."M" ) );
					if( !$this->existe( $finicio->format( 'Y-m-d' ), $finicio->format( 'H:i:s' ), $ffin->format( 'H:i:s' ), $datos['Medico']['id_medico'], $datos['Medico']['consultorio'] ) ) {
						$data = array(  'Turno' =>
								array(	'fecha_inicio'   => $finicio->format( 'Y-m-d H:i:s' ),
							    		'fecha_fin'      => $ffin->format( 'Y-m-d H:i:s' ),
										'medico_id'      => $datos['Medico']['id_medico'],
										'consultorio_id' => $datos['Medico']['consultorio'],
										'paciente_id'    => null,
										'recibido'       => false,
										'atendido'       => false,
										'cancelado'	     => false
								)
							);
						if( !$this->save( $data ) ) {
							echo "Error al guardar el turno";
						}
					} else {

					}
					$finicio->add( new DateInterval( "PT".$datos['Medico']['duracion']."M" ) );
				} // Lista la generación de turnos turno mañana
				// Turno tarde si es necesario
				if( $turno_tarde ) {
					// calculo la cantidad de pasos que tengo que hacer
					$dif = $fecha_inicio_dia_tarde->diff( $fecha_fin_dia_tarde );
					$txd = floor( ( $dif->format( '%h' ) * 60 + $dif->format( '%i' ) ) / $datos['Medico']['duracion'] );
					// Primer turno
					$finicio = clone $fecha_inicio_dia_tarde;
					// Hago el bucle
					for( $t = 0; $t < $txd-1; $t++ ) {
						if( $finicio >= $fecha_fin_dia_tarde ) {
							// El turno este no se tiene que realizar
							$t = $txd+1;
							continue;
						}
						$this->create();
						$ffin = clone $finicio;
						$ffin->add( new DateInterval( "PT".$datos['Medico']['duracion']."M" ) );
						if( !$this->existe( $finicio->format( 'Y-m-d' ), $finicio->format( 'H:i:s' ), $ffin->format( 'H:i:s' ), $datos['Medico']['id_medico'], $datos['Medico']['consultorio'] ) ) {
							$data = array(  'Turno' =>
									array(	'fecha_inicio'   => $finicio->format( 'Y-m-d H:i:s' ),
										    'fecha_fin'      => $ffin->format( 'Y-m-d H:i:s' ),
										    'medico_id'      => $datos['Medico']['id_medico'],
									    	'consultorio_id' => $datos['Medico']['consultorio'],
									    	'paciente_id'    => null,
									    	'recibido'       => false,
									    	'atendido'       => false,
									    	'cancelado'	     => false
									)
								);
							if( !$this->save( $data ) ) {
								echo "Error al guardar el turno";
							}
						}
						$finicio->add( new DateInterval( "PT".$datos['Medico']['duracion']."M" ) );
					}
				}// Listo generación de turnos turno tarde
			} // Fin num_dia != -1
		}// Fin for cantidad de días
		return $cambiar;
	}

	public function reservar( $id_turno = null, $id_paciente = null, &$mensaje = null ) {
		// Busco si está reservado
		$this->id = $id_turno;
		if( !$this->exists() ) {
			$mensaje = "El turno no existe";
			return false;
		}
		if( $this->field( 'paciente_id' ) != 0 ) {
			$mensaje = "El turno ya se encuentra reservado.";
			return false;
		}
		if( $this->field( 'cancelado' ) == true ) {
			$mensaje = "El turno se encuentra cancelado por el médico.";
			return false;
		}
		$this->set( 'paciente_id', $id_paciente );
		if( !$this->save() ) {
			$mensaje = "No se pudo guardar el turno.";
			return false;
		}
		return true;
	}

	public function verificarTurnosEnDia( $fecha, $id_paciente ) {
		$d = $this->find( 'count', array(
					'conditions' => array( 	'paciente_id' => $id_paciente,
								'DATE( fecha_inicio ) = ' => date( 'Y-n-j', strtotime( $fecha ) ) )
					)
				);
		if( $d > 0 ) { return true; } else { return false; }
	}

	public function turnosReservados( $id_usuario = null ) {
		$this->unbindModel( array( 'belongsTo' => array( 'Paciente' ) ) );
		return $this->find( 'all', array( 'conditions' => array( 'paciente_id' => $id_usuario, 'fecha_inicio >= NOW()' ), 'recursive' => 2 ) );
	}

	public function turnosAnteriores( $id_usuario ) {
	    $this->unbindModel( array( 'belongsTo' => array( 'Paciente' ) ) );
		return $this->find( 'all', array( 'conditions' => array( 'paciente_id' => $id_usuario, 'fecha_fin < NOW()' ), 'recursive' => 2 ) );
	}

	public function existe( $fecha_inicio, $hora_inicio, $hora_fin, $id_medico, $id_consultorio ) {
		$cant = $this->find( 'count', array( 'conditions' => array( 'medico_id' => $id_medico,
																	'consultorio_id' => $id_consultorio,
																	'DATE( fecha_inicio )' => $fecha_inicio,
																	'TIME( fecha_inicio ) >=' => $hora_inicio,
																	'TIME( fecha_fin ) <=' => $hora_fin ) ) );
		if( $cant > 0 ) {
			return true;
		} else { return false; }
	}

    /**
     * Elimina los turnos relacionados con el usuario. Todos, incluso los echos ya.
     * @param $id_usuario Identificador del usuario
     * @return verdadero si se pudo realizar la accion.
     * @author Esteban Zeller
     */
	public function eliminarTurnosUsuario( $id_usuario = null ) {
		if( $id_usuario != null ) {
			if( $this->updateAll( array( 'paciente_id' => null ), array( 'paciente_id' => $id_usuario ) ) ) {
				return true;
			}
		}
	    return false;
	}

    /**
     * Cancela un turno y no permite utilizarlo nuevamente.
     * Desliga al paciente del turno.
     * @param $id_turno Identificador del turno. Sino se usará $this->id
     * @author Esteban Zeller
     */
	public function cancelar( $id_turno = null ) {
		if( $id_turno == null )
			return false;

		$this->id = $id_turno;
		if( $this->saveField( 'cancelado', true ) ) {
			if( $this->saveField( 'paciente_id', null ) ) {
				return true;
			}
		}
		return false;
	}

    /**
     * Libera un turno como si lo cancelara un paciente.
     * Permite que el turno pueda estar disponible nuevamente.
     * @param $id_turno integer Identificador del turno. Sino se usara $this->id
     * @author Esteban Zeller
     */
    public function liberar( $id_turno = null ) {
        if( $id_turno == null && $this->id == null ) {
            return false;
        } else if( $this->id != null && $id_turno == null ) {
            $id_turno = $this->id;
        }

        $this->id = $id_turno;
        $this->set( 'cancelado', false );
        $this->set( 'atendido', false );
        $this->set( 'recibido', false );
        $this->set( 'paciente_id', null );
        if( $this->save() ) {
                return true;
        }
        return false;
    }

   /**
    * Devuelve verdadero si un turno se encuentra reservado
    * @param $id_turno integer identificador del turno.
    * @author Esteban Zeller
    */
   public function reservado( $id_turno = null ) {
		if( $id_turno == null )
			return false;

		if( $this->field( 'paciente_id' ) != null ) {
			return true;
		} else {
			return false;
		}
   }

  /*!
   * Selecciona los IDS de turno de las fechas comprendidas en los parametros para el medico seleccionado
   *
   */
   public function seleccionarIDS( $fini, $ffin, $id_medico ) {
   	  $dato = $this->find( 'list',
   				array( 'conditions' =>
   					array( 'medico_id' => $id_medico,
   						   'DATE(fecha_inicio) >=' => $fini->format( 'Y-m-d' ),
						   'DATE(fecha_fin) <=' => $ffin->format( 'Y-m-d' ),
						   'TIME(fecha_inicio) >=' => $fini->format( 'H:i:s' ),
						   'TIME(fecha_fin) <=' => $ffin->format( 'H:i:s' )
						  ),
						  'recursive' => -1,
						  'fields' => array( 'id_turno' )
				     )
			   );
	   return $dato;
   }

  /*!
   * Selecciona el ID de la proximo turno que precede a la fecha y hora especificada con el medico seleccionado
   */
   public function seleccionarSiguiente( $fini, $ffin, $id_medico ) {
   	return $this->find( 'list',
				array( 'conditions' =>
					array(  'medico_id' => $id_medico,
   						   'DATE(fecha_inicio) >=' => $fini->format( 'Y-m-d' ),
						   'DATE(fecha_fin) <=' => $ffin->format( 'Y-m-d' ),
						   'TIME(fecha_inicio) >=' => $fini->format( 'H:i:s' ),
						   'TIME(fecha_fin) <=' => $ffin->format( 'H:i:s' )
						),
						'recursive' => -1,
						'fields' => array( 'id_turno' ),
						'limit' => 1
				)
			);

   }

  /*!
   * Busca la lista de turnos de un usuario específico
   * @param id_usuario Identificador del usuario
   * @return Array con los turnos encontrados
   */
   public function buscarHistoricoUsuario( $id_usuario ) {
   	return $this->find( 'all', array( 'conditions' => array( 'paciente_id' => $id_usuario ),
   									  'recursive' => -1,
   									  'order' => array( 'fecha_inicio' => 'desc' ) ) );
   }

   public function cantidadDia( $condiciones = null ) {
       if( !is_array( $condiciones ) ) { $condiciones = array(); }
       $condiciones = array_merge( $condiciones,
                                   array( 'DATE( `Turno`.`fecha_inicio` ) >= ' => date( 'Y-m-d' ),
                                          'DATE( `Turno`.`fecha_fin` ) <= ' => date( 'Y-m-d' ) ) );
       return $this->find( 'count', array( 'conditions' => $condiciones, 'recursive' => -1 ) );
   }

   /*!
    * Fucion de dashboard
    * BUsca la cantidad de turnos para el día actual
    */
   public function cantidadDiaRecibidos( $condiciones = null ) {
       if( !is_array( $condiciones ) ) { $condiciones = array(); }
       $condiciones = array_merge( $condiciones,
                                   array( '`Turno`.`recibido`' => true,
                                          'DATE( `Turno`.`fecha_inicio` ) >= ' => date( 'Y-m-d' ),
                                          'DATE( `Turno`.`fecha_fin` ) <= ' => date( 'Y-m-d' ) ) );
       return $this->find( 'count', array( 'conditions' => $condiciones, 'recursive' => -1 ) );
   }

   /*!
    * Fucion de dashboard
    * BUsca la cantidad de turnos para el día actual
    */
   public function cantidadDiaAtendidos( $condiciones = null ) {
       if( !is_array( $condiciones ) ) { $condiciones = array(); }
       $condiciones = array_merge( $condiciones,
                                   array( '`Turno`.`atendido`' => true,
                                          'DATE( fecha_inicio ) >= ' => date( 'Y-m-d' ),
                                          'DATE( `Turno`.`fecha_fin` ) <= ' => date( 'Y-m-d' ) ) );
       return $this->find( 'count', array( 'conditions' => $condiciones, 'recursive' => -1 ) );
   }

   /*!
    * Fucion de dashboard
    * BUsca la cantidad de turnos para el día actual
    */
   public function cantidadDiaLibres( $condiciones = null ) {
       if( !is_array( $condiciones ) ) { $condiciones = array(); }
       $condiciones = array_merge( $condiciones,
                                   array( '`Turno`.`paciente_id`' => null,
                                          'DATE( fecha_inicio ) >= ' => date( 'Y-m-d' ),
                                          'DATE( `Turno`.`fecha_fin` ) <= ' => date( 'Y-m-d' ) ) );
       return $this->find( 'count', array( 'conditions' => $condiciones, 'recursive' => -1 ) );
   }

   /*!
    * Fucion de dashboard
    * BUsca la cantidad de turnos para el día actual
    */
   public function cantidadDiaReservados( $condiciones = null ) {
       if( !is_array( $condiciones ) ) { $condiciones = array(); }
       $condiciones = array_merge( $condiciones,
                                   array( '`Turno`.`recibido`' => false,
                                          '`Turno`.`atendido`' => false,
                                           'NOT' => array( '`Turno`.`paciente_id`' => null ),
                                           'DATE( fecha_inicio ) >= ' => date( 'Y-m-d' ),
                                           'DATE( `Turno`.`fecha_fin` ) <= ' => date( 'Y-m-d' )
                                         )
                                 );
       return $this->find( 'count', array( 'conditions' => $condiciones, 'recursive' => -1 ) );
   }

   public function anoMaximoTurno() {
       $data = $this->find( 'first', array( 'fields' => array( 'YEAR( fecha_inicio ) AS maximo'  ),
                                            'recursive' => -1,
                                            'order' => array( 'fecha_inicio' => 'desc' )
                                          )
       );
       if( count( $data ) > 0 ) {
            return intval( $data[0]['maximo'] );
       } else {
           return 0;
       }
   }

   public function anoMinimoTurno() {
       $data = $this->find( 'first', array( 'fields' => array( 'YEAR( fecha_inicio ) AS minimo'  ),
                                            'recursive' => -1,
                                            'order' => array( 'fecha_inicio' => 'asc' )
                                          )
       );
       if( count( $data ) > 0 ) {
            return intval( $data[0]['minimo'] );
       } else {
           return 0;
       }
   }


    public function trasladarTurno( $id_origen = null, $id_destino = null ) {
        if( $id_origen == null ) { return false; }
        if( $id_destino == null ) { return false; }

        // Veo que el turno de destino no esté ocupado
        $destino = $this->find( 'first', array( 'conditions' => array( 'id_turno' => $id_destino ),
                                                'recursive' => -1,
                                                'fields' => array( 'paciente_id' )
        ) );
        if( $destino['Turno']['paciente_id'] != null ) {
            // Esto significa que el turno de destino ya tiene un paciente!
            return false;
        }

        $this->id = $id_origen;
        $paciente = intval( $this->field( 'paciente_id' ) );
        if( !$this->saveField( 'paciente_id', null ) ) {
            return false;
        }
        $this->id = $id_destino;
        if( $this->saveField( 'paciente_id', $paciente ) ) {
            return true;
        } else {
            return false;
        }
    }

}