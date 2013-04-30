<?php
App::uses('AppModel', 'Model');
/**
 * Modelo de usuario
 *
 */
class Usuario extends AppModel {

	public $primaryKey = 'id_usuario';
	//public $displayField = 'razonsocial';
	public $actAs = array( 'AuditLog.Auditable' );
	public $virtualFields = array(
		'razonsocial' => 'CONCAT( Usuario.apellido, \', \', Usuario.nombre )' );

	public $belongsTo = array( 'ObraSocial', 'Grupo' );

	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Por favor, ingrese una dirección de correo electronico válida',
				'allowEmpty' => false,
				'required' => true
			)
		),
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese su nombre.',
				'allowEmpty' => false,
				'required' => true
			)
		),
		'apellido' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese su apellido.',
				'allowEmpty' => false,
				'required' => true
			)
		),
		'telefono' => array(
			'notempty' => array(
				'rule' => array('numeric'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Por favor, ingrese solo numeros.'
			)
		),
		'celular' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Por favor, ingrese solo numeros.'
			)
		),
		'notificaciones' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'required' => false
			)
		),
		'contra' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'La contraseña no puede estar vacia.'
			)
		)
	);

	// Esta funcion encripta las contraseñas antes de guardarlas en la base de datos
	function beforeSave($options = array()) {
		if( isset( $this->data['Usuario']['contra'] ) ) {
			$this->data['Usuario']['contra'] = AuthComponent::password( $this->data['Usuario']['contra'] );
		}
		return true;
	}

	/*!
	 * @fn verificarSiExiste( $email )
	 * Verifica que exista el email en la lista de usuarios.
	 * @return Verdadero si el email está dado de alta en el sistema
	 */
	public function verificarSiExiste( $email = null ) {
		$cantidad = $this->find( 'count', array( 'conditions' => array( 'email' => $email ) ) );
		if( $cantidad > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	/*!
	 * @fn generarNuevaContraseña( $email, $contra )
	 * Genera una nueva contraseña para el usuario, la coloca en la variable $contra y la asigna al email pasado como referencia.
	 * @return Verdadero si el email está dado de alta en el sistema
	 */
	public function generarNuevaContraseña( $email = null, $contra = null ) {
		$str = "ABCDE2FGHIJKLM4NOPQRSTUVWXY2Zabcdefghij5klmnopqrstu2vwxyz1234567890";
		$contra = "";
		for( $i=0; $i<8; $i++ ) {
			$contra .= substr($str, rand(0,64), 1 );
		}
		$id = $this->find( 'first', array( 'conditions' => array( 'email' => $email ), 'fields' => 'id_usuario' ) );
		if( $id['Usuario']['id_usuario'] != 0 ) {
			$this->id = $id['Usuario']['id_usuario'];
			if( !$this->saveField( 'contra', $contra ) ) {
				return false;
			} else {
				return $contra;
			}
		} else {
			// No debería de llegar aqui
			echo "El id del usuario no fue encontrado buscando x email. error de logica";
			exit();
		}
		return $contra;
	}

	public function eliminarPorEmail( $email ) {
		return $this->deleteAll( array( 'email' => $email ) );
	}

}