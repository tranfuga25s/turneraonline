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
                'rule' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'message' => 'Formato del campo incorrecto'
            ),
            'horario' => array(
                'rule' => array( 'horarioMenorQue', 'hora_fin' ),
                'message' => "El horario de inicio debe ser menor que el horario de fin"
            )
        ),
        'hora_fin' => array(
            'formato' => array(
                'rule' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'message' => 'Formato del campo incorrecto'
            ),
            'horario' => array(
                'rule' => array( 'horarioMayorQue', 'hora_inicio' ),
                'message' => "El horario de inicio debe ser mayor que el horario de fin"
            )
        ),
        'hora_inicio_tarde' => array(
            'formato' => array(
                'rule' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'message' => 'Formato del campo incorrecto'
            ),
            'horario' => array(
                'rule' => array( 'horarioMenorQue', 'hora_fin_tarde' ),
                'message' => "El horario de inicio debe ser menor que el horario de fin"
            )
        ),
        'hora_fin_tarde' => array(
            'formato' => array(
                'rule' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
                'message' => 'Formato del campo incorrecto'
            ),
            'horario' => array(
                'rule' => array( 'horarioMayorQue', 'hora_inicio_tarde' ),
                'message' => "El horario de inicio debe ser mayor que el horario de fin"
            )
        )
    );

    public function horarioMenorQue( $valor, $dato ) {
        if( !empty( $this->data ) ) {
            $fecha = new DateTime( 'now' );
            if( is_array( $valor ) ) {
                $valor = array_pop( $valor );
            }
            $temp = split( ":", $valor );
            $fecha->setTime( $temp[0], $temp[1], $temp[2] );
            if( array_key_exists( $dato, $this->data[$this->name] ) ) {
                $fecha2 = clone $fecha;
                $temp = split( ":", $this->data[$this->name][$dato] );
                $fecha2->setTime( $temp[0], $temp[1], $temp[2] );
                $diferencia = $fecha->diff( $fecha2 )->format( 's' );
                if( $diferencia >= 0 ) {
                    return true;
                }
            }
        }
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
                $fecha2 = clone $fecha;
                $temp = split( ":", $this->data[$this->name][$dato] );
                $fecha2->setTime( $temp[0], $temp[1], $temp[2] );
                $diferencia = $fecha->diff( $fecha2 )->format( 's' );
                if( $diferencia <= 0 ) {
                    return true;
                }
            }
        }
        return false;
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
