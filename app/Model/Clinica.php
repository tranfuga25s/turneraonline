<?php
App::uses('AppModel', 'Model');
/**
 * Clinica Model
 * Modelo que administra las clinicas que hay activas
 */
class Clinica extends AppModel {

	public $primaryKey = 'id_clinica';
	public $displayField = 'nombre';
	public $actAs = array( 'AuditLog.Auditable' );
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
			'class' => 'Consultorio',
			'foreignKey' => 'clinica_id'
		),
		'Medicos' => array(
			'class' => 'Medico',
			'foreignKey' => 'clinica_id'
		),
		'Secretarias' => array(
			'class' => 'Secretaria',
			'foreignKey' => 'clinica_id'
		)
	);

	/**
	 * Verifica si existen datos asociados
	 */
	public function beforeDelete( $cascade = true ) {
		$cantidad = $this->Medicos->find( 'count', array( 'conditions' => array( 'clinica_id' => $this->id ) ) );
		if( $cantidad > 0 ) {
			return false;
		}
		$cantidad = $this->Secretaria->find( 'count', array( 'conditions' => array( 'clinica_id' => $this->id ) ) );
		if( $cantidad > 0 ) {
			return false;
		}
		$cantidad = $this->Consultorios->find( 'count', array( 'conditions' => array( 'clinica_id' => $this->id ) ) );
		if( $cantidad > 0 ) {
			return false;
		}
		return true;
	}

	/*!
	 * Devuelve verdadero si existe una única clinica seteada en el sistema
	 * @return boolean
	 */
	public function unaSola() {
		$count = $this->find( 'count' );
		if( $count == 1 ) {
			return true;
		}
		return false;
	}

	/*!
	 * Devuelve el valor de los datos de la unica clinica
	 * @params mixed $options Opciones a pasarle al find
	 * @return Array Datos los datos
	 */
	public function unica() {
		return $this->find( 'first', array( 'fields' => array( 'id_clinica', 'nombre' ), 'recursive' => -1 ) );
	}

}
