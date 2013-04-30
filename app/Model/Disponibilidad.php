<?php
App::uses('AppModel', 'Model');
/**
 * Disponibilidad Model
 *
 * @property Medico $Medico
 */
class Disponibilidad extends AppModel {

	public $useTable = 'disponibilidad';
	public $primaryKey = 'id_disponibilidad';
	public $actAs = array( 'AuditLog.Auditable' );

	public $hasMany = array(
		'DiaDisponibilidad' => array(
			'className' => 'DiaDisponibilidad',
			'foreignKey' => 'disponibilidad_id',
			'order' => 'DiaDisponibilidad.dia ASC'
		),
	);

	public $belongsTo = array(
		'Medico' => array(
			'className' => 'Medico',
			'foreignKey' => 'medico_id'
		)
	);
	
   /*!
    * Verifica la existencia de disponibildiades en el mismo consultorio en los horarios especificados
    * @param id_medico Medico que reservará la disponibildiad
    * @param id_consultorio Identificador del consultorio que desea utilizar
    * @param dia Numero de día que desea utilizar el horario.
    * @param hi Hora de inicio del turno mañana
    * @param hf Hora de fin del turno mañana
    * @param hit Hora de inicio del turno tarde
    * @param hft Hora de fin del turno tarde
    */
	public function verificar( $id_medico, $id_consultorio, $dia, $hi, $hf, $hit, $hft ) 
	{
		// Busco los medicos que atienden en ese consultorio
		$disp = $this->find( 'list', array( 'conditions' => array(
												'medico_id !=' => $id_medico, 
												'consultorio_id' => $id_consultorio ),
											 'fields' => array( 'id_disponibilidad' ) ) );
		if( count( $disp ) ) {
			// No hay medicos que atiendan en este consultorio en este día
			return false;
		} else {
			// busco si los horarios coinciden
			return $this->DiaDisponibilidad->verificar( $disp, $dia, $hi, $hf, $hit, $hft );
		}
	}

}