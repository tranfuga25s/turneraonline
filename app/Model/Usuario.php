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

    public $hasOne = array(
        'Medico',
        'Secretaria'
    );

    public $hasMany = array(
        'Turno' => array(
            'class' => 'Turno',
            'foreignKey' => 'paciente_id'
        )
    );

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

	/**
     * Esta funcion encripta las contraseñas antes de guardarlas en la base de datos
     *  y
     * Verifica que al cambiar de grupo no se esté cambiando a un medico o una secretaria
     */
	function beforeSave($options = array()) {
		if( isset( $this->data['Usuario']['contra'] ) ) {
			$this->data['Usuario']['contra'] = AuthComponent::password( $this->data['Usuario']['contra'] );
		}

        $grupo = intval( $this->field( 'grupo_id' ) );

        // Si llamamos al eliminar desde la consola de reinicialización estas propiedades no están guardadas
        if( count( Configure::read( 'Turnera.grupos' ) ) > 0 ) {

            // Miro si el grupo de origen pertenece al grupo de medicos o secretarias
            if( in_array( $grupo, Configure::read( 'Turnera.grupos' ) ) ) {

                 // Verifico que exista la relación en la tabla de medicos
                 if( $grupo == 2 ) {
                     $conteo = $this->Medico->find( 'count', array( 'conditions' => array( 'usuario_id' => $this->data['Usuario']['id_usuario'] ) ) );
                     if( intval( $conteo ) > 0 ) {
                         return false;
                     }
                 // Verifico que exista la relación en la tabla de secretaria
                 } else if( $grupo == 3 ) {
                     $conteo = $this->Secretaria->find( 'count', array( 'conditions' => array( 'usuario_id' => $this->data['Usuario']['id_usuario'] ) ) );
                     if( intval( $conteo ) > 0 ) {
                         return false;
                     }
                 }
                 return false;
            }
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
	 * @fn generarNuevaContraseñarray( $email, $contra )
	 * Genera una nueva contraseña para el usuario, la coloca en la variable $contra y la asigna al email pasado como referencia.
	 * @return Verdadero si el email está dado de alta en el sistema
	 */
	public function generarNuevaContraseñarray( $email = null, &$contra = null ) {
		$str = "ABCDE2FGHIJKLM4NOPQRSTUVWXY2Zabcdefghij5klmnopqrstu2vwxyz1234567890";
		$contra = "";
		for( $i=0; $i<8; $i++ ) {
			$contra .= substr($str, rand(0,64), 1 );
		}
		$id = $this->find( 'first', array( 'conditions' => array( 'email' => $email ), 'fields' => 'id_usuario' ) );
		if( count( $id ) > 0 && $id['Usuario']['id_usuario'] != 0 ) {
			$this->id = $id['Usuario']['id_usuario'];
			if( !$this->saveField( 'contra', $contra ) ) {
				return false;
			} else {
				return $contra;
			}
		} else {
			// No debería de llegar aqui
			return false;
		}
		return $contra;
	}

	public function eliminarPorEmail( $email ) {
		return $this->deleteAll( array( 'email' => $email ) );
	}

    /**
     * Verificaciones de eliminación de usuarios
     * @ref test
     */
    public function beforeDelete( $cascade = true ) {
        // Verifico que no esté asociado con algún médico
        $cmedico = $this->Medico->find( 'count', array( 'conditions' => array( 'usuario_id' => $this->id ) ) );
        if( intval( $cmedico ) > 0 ) {
            return false;
        }
        $csecretaria = $this->Secretaria->find( 'count', array( 'conditions' => array( 'usuario_id' => $this->id ) ) );
        if( intval( $csecretaria ) > 0 ) {
            return false;
        }
        $cturnos = $this->Turno->find( 'count', array( 'conditions' => array( 'paciente_id' => $this->id ) ) );
        if( intval( $cturnos ) > 0 ) {
            return false;
        }
        // Verifico que no sea el ultimo administrador
        $grupo = $this->field( 'grupo_id', array( 'id_usuario' => $this->id ) );
        if( is_array( $grupo ) ) { $grupo = $grupo['Usuario']['grupo_id']; }
        if( $grupo == 1 ) { // Veo si es el administrador
            $conteo = $this->find( 'count', array( 'grupo_id' => 1, 'NOT' => array( 'id_usuario' => $this->id ) ) );
            if( $conteo == 0 ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Obtiene los datos de un usuario si existe a partir del número de teléfono.
     * @param $tel mixed Numero de telefono a buscar
     * @return Cadena vacía si no existe el usuario o la razón social
     */
     public function getUsuarioPorTelefono( $tel = null ) {
         if( is_null( $tel ) || empty( $tel ) ) {
             return "";
         }
         $data = $this->find( 'first',
            array(
                'conditions' => array( 'OR' => array( 'telefono' => $tel, 'celular' => $tel ) ),
                'fields' => array( 'razonsocial' ),
                'recursive' => -1
            )
         );
         if( count( $data ) > 0 ) {
             return $data['Usuario']['razonsocial'];
         } else {
             return "";
         }
     }

}