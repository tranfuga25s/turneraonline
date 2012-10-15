<?php
App::uses('AppModel', 'Model');
/**
 * Modelo para la administración de los medicos declarados en el sistema.
 *
 * @property Usuario $Usuario
 * @property Especialidad $Especialidad
 * @property Clinica $Clinica
 * @property Turno $Turno
 * @property Disponibilidad $Disponibilidad
 */
class Medico extends AppModel {

	public $primaryKey = 'id_medico';
	public $actAs = array( 'AuditLog.Auditable' );
	
	public $validate = array(
			'usuario_id' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => 'Por favor, ingrese un usuario para asociar al medico.',
					'allowEmpty' => false,
					'required' => true
				)
			)
		);
		
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'dependent' => true,
		),
		'Especialidad' => array(
			'className' => 'Especialidad',
			'foreignKey' => 'especialidad_id',
		),
		'Clinica' => array(
			'className' => 'Clinica',
			'foreignKey' => 'clinica_id',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Turno' => array(
			'className' => 'Turno',
			'foreignKey' => 'medico_id',
		),
		'Excepcion' => array(
			'className' => 'Excepcion',
			'foreignKey' => 'medico_id'
		)	
	);

	public $hasOne = array(
		'Disponibilidad' => array(
			'className' => 'Disponibilidad',
			'dependent' => true
		)
	);

	/**
	 * Devuleve el listado de medicos como para un select
	 */
	public function lista( $id_filtro = null ) {
		if( $id_filtro != null ) {
			$cond = array( 'id_usuario' => $id_filtro );
		} else { $cond = array(); }
		$ids = $this->find( 'list', array( 'conditions' => array( 'visible' => true ), 'fields' => array( 'usuario_id' ) ) );
		if( count( $ids > 0 ) && $id_filtro != null ) {
			$cond = array_merge( array( 'id_usuario' => $ids ), $cond );
		} else {
			return array();
		}
		$conds = array_merge( array( 'grupo_id' => 2 ), $cond );
		return $this->Usuario->find( 'list',
			array( 'conditions' => $conds, 'fields' => array( 'id_usuario', 'razonsocial' )
		) );

	}

	public function lista2( $id_filtro = null ) {
		if( $id_filtro != null ) {
			$cond = array( 'id_medico' => $id_filtro );
		} else { $cond = array(); }
		$lista = $this->find( 'list', array( 'conditions' => $cond, 'fields' => array( 'id_medico', 'usuario_id' ) ) );
		$lusuario = $this->Usuario->find( 'list', array( 'conditions' => array( 'grupo_id' => 2 ), 'fields' => array( 'id_usuario', 'razonsocial' ) ) );
		foreach( $lista as $id_med => $id_us ) {
			if( array_key_exists( $id_us, $lusuario ) ) {
				$lista[$id_med]= $lusuario[$id_us];
			}   
		}
		return $lista;
	}

	public function eliminar( $id_medico ) {
		$turnos = $this->Turno->find( 'list', array( 'conditions' => array( 'medico_id' => $id_medico ) ) );
		foreach( $turnos as $turno ) {
			$this->Turno->cancelar( $turno );
			$this->Turno->delete( $turno );
		}
		// Disponibilidad
		$this->Disponibilidad->deleteAll( array( 'medico_id' => $id_medico ) );
		// Excepcion
		
		// Finalmente elimino el medico
		return $this->delete( $id_medico );
	}

}
