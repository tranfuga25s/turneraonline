<?php
App::uses('AppModel', 'Model');
/**
 * Modelo para los grupos
 *
 */
class Grupo extends AppModel {

    public $useTable = 'grupos';

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

	/**
	 * Permite saber si existen usuarios relacionados con este grupo
	 * @return boolean Verdadero si existen usuarios relacionados con este grupo
	 */
    public function tieneUsuariosAsociados() {
    	$count = $this->Usuarios->find( 'count', array( 'conditions' => array( 'grupo_id' => $this->id ) ) );
		if( $count > 0 ) {
			return true;
		}
		return false;
	}

}
