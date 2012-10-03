<?php
App::uses('AppModel', 'Model');
/**
 * Consultorio Model
 * Modelo para administrar los consultorios de cada clinica
 * @property Clinica $Clinica
 */
class Consultorio extends AppModel {
	public $primaryKey = 'id_consultorio';
	public $displayField = 'nombre';
	public $actAs = array( 'AuditLog.Auditable' );
	public $validate = array(
		'clinica_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Seleccione una clinica valida',
				'allowEmpty' => false,
				'required' => true
			)
		),
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese un nombre para el consultorio.',
				'allowEmpty' => false,
				'required' => true
			)
		)
	);

	public $belongsTo = array(
		'Clinica' => array(
			'className' => 'Clinica',
			'foreignKey' => 'clinica_id',
		)
	);
}
