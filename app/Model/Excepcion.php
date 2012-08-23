<?php
App::uses('AppModel', 'Model');
/**
 * Excepcion Model
 *
 * @property Medico $Medico
 */
class Excepcion extends AppModel {

	public $useTable = 'excepciones';
	public $primaryKey = 'id_excepcion';

	public $validate = array(
		'inicio' => array(
			'datetime' => array( 'rule' => array('datetime') )
		),
		'fin' => array(
			'datetime' => array( 'rule' => array('datetime') )
		),
		'rep_semanal' => array(
			'boolean' => array( 'rule' => array('boolean') )
		),
		'rep_mensual' => array(
			'boolean' => array( 'rule' => array('boolean') )
		),
		'rep_anual' => array(
			'boolean' => array( 'rule' => array('boolean') )
		),
		'relativo' => array(
			'boolean' => array( 'rule' => array('boolean') )
		)
	);

}
