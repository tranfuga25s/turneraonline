<?php
App::uses('AppModel', 'Model');
/**
 * ObrasSocial Model
 *
 */
class ObraSocial extends AppModel {

	public $useTable = 'obras_sociales';
	public $primaryKey = 'id_obra_social';
	public $displayField = 'nombre';
	public $actAs = array( 'AuditLog.Auditable' );
	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese un nombre para la obra social'
			),
			'repetido' => array(
				'rule' => array( 'buscaRepetido' ),
				'message' => 'La obra social elegida ya existe.'
			)
		),
		'telefono' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El numero de telefono debe ser solo numeros',
				'allowEmpty' => true
			)
		)
	);
	
	public function buscarRepetido( $valor ) {
		$count = $this->find( 'count', array( 'conditions' => array( 'nombre' => $valor['nombre'] ) ) );
		if( $count <= 0 ) {
			return true;
		} else {
			return false;
		}
	}
}
