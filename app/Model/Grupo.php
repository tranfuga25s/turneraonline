<?php
App::uses('AppModel', 'Model');
/**
 * Modelo para los grupos
 *
 */
class Grupo extends AppModel {

	public $primaryKey = 'id_grupo';
	public $displayField = 'nombre';
	public $actAs = array( 'AuditLog.Auditable' );
	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese un nombre para el grupo'
			)
		)
	);

	public $hasMany = array( 'Usuarios' );
}
