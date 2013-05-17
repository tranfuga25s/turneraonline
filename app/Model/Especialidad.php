<?php
App::uses('AppModel', 'Model');
/**
 * Especialidad Model
 *
 */
class Especialidad extends AppModel {

	public $useTable = 'especialidades';
	public $primaryKey = 'id_especialidad';
	public $displayField = 'nombre';
	public $actAs = array( 'AuditLog.Auditable' );
	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese un nombre para la especialidad'
			)
		)
	);
	
	public $hasMany = array( 
		'Medico' => array(
			'className' => 'Medico',
			'foreignKey' => 'especialidad_id' 
		)
	);
	
	/**
	 * Devuelve el listado de especialidades según una clinica específica
	 * @param integer $id_clinica Identificador de Clínica
	 * @return Lista de Especialidades que tiene la clinica
	 */
	public function listaPorClinica( $id_clinica ) {
		return $this->find( 'list', array( 	'conditions' => array( 'id_especialidad' => $this->Medico->find( 'list', array( 'conditions' => array( 'clinica_id' => $id_clinica ), 
																															'fields' => array( 'especialidad_id' ) ) ) ), 
											'fields' => array( 'id_especialidad', 'nombre' ) ) );
	}
}
