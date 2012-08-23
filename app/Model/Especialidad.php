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

	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese un nombre para la especialidad'
			)
		)
	);
}
