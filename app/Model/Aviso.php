<?php
App::uses('AppModel', 'Model');
/**
 * Modelo para los avisos
 *
 */
class Aviso extends AppModel {

	public $primaryKey = 'id_aviso';
	public $displayField = 'subject';

	public $hasMany = array( 'VariableAviso' => array( 'class' => 'VariableAviso', 'dependent' => true ) );

   /*!
    * Función que revisa si existe algún aviso pendiente a enviar.
    */
	public function existePendiente() {
		$d = $this->find( 'count',
				array( 'conditions' =>
					array( 'DATE( fecha_envio)  <=' => date( 'Y-m-d', time() ), 'TIME( fecha_envio ) <= ' =>  date( 'H:i:s', time() ) ),
					'recursive' => -1,
					'limit' => 1
					)
				);
		if( $d > 0 ) { return true; } else { return false; }
	}

	/*!
	 * Devuelve el primer registro de los datos guardados en envios.
	 */
	public function buscarSiguiente() {
		$rec = $this->find( 'first', array( 'limit' => 1, 'order' => 'fecha_envio' ) );
		if( $rec != null ) {
			return $rec;
		} else {
			die( "Error al intentar recuperar el registro del aviso" );
		}
	}
	
	/*!
	 * Cambia la cantidad de horas antes de un aviso.
	 * @param id_turno integer Identificador del turno.
	 * @param horas integer Nueva cantidad de horas antes.
	 * @param horaturno integer Horario del turno.
	 */
	public function cambiarHorasTurno( $id_turno, $horas, $horaturno ) {
		// Busco a que ID corresponde este turno.
		$temp = $this->find( 'list', array( 'conditions' => array( 'template' => 'nuevoTurno' ), 'fields' => array( 'id_aviso' ) ) );
		$ret = $this->VariableAviso->find('first', array( 'conditions' => array( 'modelo' => 'Turno', 'id' => $id_turno, 'aviso_id' => $temp ), 'fields' => array( 'aviso_id' ) ) );
		$this->id = $ret['VariableAviso']['aviso_id'];
		$this->unbindModel( array( 'hasMany' => array( 'VariableAviso' ) ) );
		$datos = $this->read();
		$fecha = new DateTime( $horaturno );
		$fecha->sub( new DateInterval( "PT".$horas."H" ) );
		if( $fecha < new DateTime( 'now' ) ) {
			$fecha = new DateTime( 'now' );
		}
		$datos['Aviso']['fecha_envio'] = $fecha->format( 'Y-m-d H:i:s' );
		if( $this->save( $datos ) ) {
			return true;
		}
	    return false;
	}
	
	/*!
	 * Cancela el aviso para el turno pasado como parametro
	 * @param id_turno integer Identificador del turno.
	 */
	public function cancelarAvisoNuevoTurno( $id_turno ) {
		// Busco a que ID corresponde este turno.
		$ret = $this->VariableAviso->find('first', array( 'conditions' => array( 'modelo' => 'Turno', 'id' => $id_turno ), 'fields' => array( 'aviso_id' ) ) );
		$this->id = $ret['VariableAviso']['aviso_id'];
		$template = $this->read( 'template' );
		if( $template == 'nuevoTurno' ) {
			$this->VariableAviso->deleteAll( array( 'modelo' => 'Turno', 'id' => $id_turno ) );
			$this->delete();
		}
	}
}