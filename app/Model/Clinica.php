<?php
App::uses('AppModel', 'Model');
/**
 * Clinica Model
 * Modelo que administra las clinicas que hay activas
 */
class Clinica extends AppModel {

	public $primaryKey = 'id_clinica';
	public $displayField = 'nombre';

	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese un nombre para la clinica.',
				'allowEmpty' => false,
				'required' => true
			)
		),
		'telefono' => array(
			'numeric' => array(
				'rule' => array( 'numeric' ),
				'message' => 'El numero de telefono solo debe contener digitos',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'email' => array(
			'email' => array( 
				'rule' => array( 'email' ),
				'message' => 'Ingrese una dirección de correo electronica correcta.',
				'allowEmpty' => true,
				'required' => false
			)
		)
	);

	public $hasMany = array(
		'Consultorios' => array(
			'class' => 'Consultorio'
		),
		'Medicos' => array( 
			'class' => 'Medico'
		)
	);
}
