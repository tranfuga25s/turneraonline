<?php
App::uses('AppModel', 'Model');
/**
 * Secretaria Model
 *
 * @property Usuario $Usuario
 * @property Clinica $Clinica
 */
class Secretaria extends AppModel {

	public $primaryKey = 'id_secretaria';

	public $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
		),
		'Clinica' => array(
			'className' => 'Clinica',
			'foreignKey' => 'clinica_id',
		)
	);

	/**
	 * Devuleve el listado de medicos como para un select
	 */
	public function lista( $id_filtro = null ) {
		if( $id_filtro != null ) {
			$cond = array( 'id_usuario' => $id_filtro );
		} else { $cond = array(); }
		$conds = array_merge( array( 'grupo_id' => 3 ), $cond );
		return $this->Usuario->find( 'list',
			array( 'conditions' => $conds, 'fields' => array( 'id_usuario', 'razonsocial' )
		) );

	}
}
