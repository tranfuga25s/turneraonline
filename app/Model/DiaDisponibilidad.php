<?php
App::uses('AppModel', 'Model');
/**
 * DiaDisponibilidad Model
 *
 * @property Disponibilidad $Disponibilidad
 */
class DiaDisponibilidad extends AppModel {

	public $useTable = 'dia_disponibilidad';

    public $primaryKey = 'id';

	public $actAs = array( 'AuditLog.Auditable' );

	public $belongsTo = array(
		'Disponibilidad' => array(
			'className' => 'Disponibilidad',
			'foreignKey' => 'disponibilidad_id'
		)
	);

    public $validate = array(
        'hora_inicio' => array(
            'formato' => array(
                'rule' => "/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/",
                'message' => 'Formato del campo incorrecto',
                'last' => true
            ),
            'horario' => array(
                'rule' => array( 'horarioMenorQue', 'hora_fin' ),
                'message' => "El horario de inicio debe ser menor que el horario de fin"
            )
        ),
        'hora_fin' => array(
            'formato' => array(
                'rule' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'message' => 'Formato del campo incorrecto',
                'last' => true
            ),
            'horario' => array(
                'rule' => array( 'horarioMayorQue', 'hora_inicio' ),
                'message' => "El horario de fin debe ser mayor que el horario de inicio"
            )
        ),
        'hora_inicio_tarde' => array(
            'formato' => array(
                'rule' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'message' => 'Formato del campo incorrecto',
                'last' => true
            ),
            'horario' => array(
                'rule' => array( 'horarioMenorQue', 'hora_fin_tarde' ),
                'message' => "El horario de inicio_tarde debe ser menor que el horario de fin_tarde"
            )
        ),
        'hora_fin_tarde' => array(
            'formato' => array(
                'rule' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'message' => 'Formato del campo incorrecto',
                'last' => true
            ),
            'horario' => array(
                'rule' => array( 'horarioMayorQue', 'hora_inicio_tarde' ),
                'message' => "El horario de fin_tarde debe ser mayor que el horario de inicio_tarde"
            )
        )
    );

    /*!
     * \fn horarioMenorQue( valor, dato )
     * Verifica que el valor pasado como 1º parametro sea menor que el contenido del campo pasado como 2º
     * \param valor mixed Valor a comparar como mayor al contenido del segundo parametro
     * \param dato string Nombre del campo a obtener el dato
     */
    public function horarioMenorQue( $valor, $dato ) {
        if( !empty( $this->data ) ) {
            $fecha = new DateTime( 'now' );
            if( is_array( $valor ) ) {
                $valor = array_pop( $valor );
            }
            $temp = split( ":", $valor );
            $fecha->setTime( $temp[0], $temp[1], $temp[2] );
            if( array_key_exists( $dato, $this->data[$this->name] ) ) {
                if( $valor == "00:00:00" &&
                    $this->data[$this->name][$dato] == "00:00:00" ) {
                        return true;
                }
                $fecha2 = clone $fecha;
                $temp = split( ":", $this->data[$this->name][$dato] );
                $fecha2->setTime( $temp[0], $temp[1], $temp[2] );
                $diferencia = $this->aSegundos( $fecha->diff( $fecha2 ) );
                if( $diferencia > 0 ) {
                    return true;
                }
            } else {
                throw new NotFoundException( "El parametro ".$dato." no existe en el \$this->data" );
            }
        } else {
            throw new NotImplementedException('No implementada validación sin datos en buffer' );
        }
        //debug( "Falló en ".$valor." contra ".$dato.":".$this->data[$this->name][$dato] );
        return false;
    }

    public function horarioMayorQue( $valor, $dato ) {
        if( !empty( $this->data ) ) {
            $fecha = new DateTime( 'now' );
            if( is_array( $valor ) ) {
                $valor = array_pop( $valor );
            }
            $temp = split( ":", $valor );
            $fecha->setTime( $temp[0], $temp[1], $temp[2] );
            if( array_key_exists( $dato, $this->data[$this->name] ) ) {
                if( $valor == "00:00:00" &&
                    $this->data[$this->name][$dato] == "00:00:00" ) {
                        return true;
                }
                $fecha2 = clone $fecha;
                $temp = split( ":", $this->data[$this->name][$dato] );
                $fecha2->setTime( $temp[0], $temp[1], $temp[2] );
                $diferencia = $this->aSegundos( $fecha->diff( $fecha2 ) );
                if( $diferencia < 0 ) {
                    return true;
                }
            } else {
                throw new NotFoundException( "El parametro ".$dato." no existe en el \$this->data" );
            }
        } else {
            throw new NotImplementedException('No implementada validación sin datos en buffer' );
        }
        return false;
    }

    private function aSegundos( DateInterval $diferencia ) {
        $sumatoria = ($diferencia->y * 365 * 24 * 60 * 60) +
               ($diferencia->m * 30 * 24 * 60 * 60) +
               ($diferencia->d * 24 * 60 * 60) +
               ($diferencia->h * 60 * 60) +
               ($diferencia->i * 60) +
               $diferencia->s;
        if( $diferencia->invert ) {
            $sumatoria *= -1;
        }
        return $sumatoria;
    }

	/*!
	 * Verifica que para las disponibilidades pasadas como parametros no exista una disponibilidad que esté durante estos días.
	 * @param id_disponibilidad Array con las disponibildiades a verificar
	 * @oaram hinicio Hora de inicio mañana
	 * @param hfin Hora de inicio mañana
	 * @oaram htinicio Hora de inicio tarde
	 * @param htfin Hora de inicio tarde
	 * @return Devuelve verdadero si existe alguna superposición entre los horarios con otro medico
	 */
	public function verificar( $id_disponibilidad, $dia, $hinicio, $hfin, $htinicio, $htfin ) {
		// Verifica que no haya otro turno de otra disponibilidad en el mismo horario y mismo consultorio
		$contador = 0;
		$contador += $this->find( 'count',
				 		array( 'conditions' =>
				 			array( 	'id_disponibilidad' => $id_disponibilidad,
						 			'dia' => $dia,
						 			'TIME( hora_inicio ) <' => $hinicio,
				 					'TIME( hora_fin ) >' => $hinicio,
								 )
							 )
					);
		$contador += $this->find( 'count',
				 		array( 'conditions' =>
				 			array( 	'id_disponibilidad' => $id_disponibilidad,
						 			'dia' => $dia,
						 			'TIME( hora_inicio ) <' => $hfin,
				 					'TIME( hora_fin ) >' => $hfin,
								 )
							 )
					);
		$contador += $this->find( 'count',
				 		array( 'conditions' =>
				 			array( 	'id_disponibilidad' => $id_disponibilidad,
						 			'dia' => $dia,
						 			'TIME( hora_inicio ) <' => $hinicio,
				 					'TIME( hora_fin ) >' => $hfin,
								 )
							 )
					);
		if( $contador > 0 ) {
			return true;
		}
		return false;
	}
}
