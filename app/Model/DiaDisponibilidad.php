<?php
App::uses('AppModel', 'Model');
/**
 * DiaDisponibilidad Model
 *
 * @property Disponibilidad $Disponibilidad
 */
class DiaDisponibilidad extends AppModel {

	public $useTable = 'dia_disponibilidad';

	public $belongsTo = array(
		'Disponibilidad' => array(
			'className' => 'Disponibilidad',
			'foreignKey' => 'disponibilidad_id'
		)
	);
	
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
