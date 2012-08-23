<?php

App::uses('CakeEmail', 'Network/Email');

class AvisosShell extends AppShell {

	var $uses = array( 'Aviso' );

	public function verificarEnvio() {
		// Busco si existe algun email para saber si tengo que enviarlo.
		if( ! $this->Aviso->existePendiente() ) {
			echo "No hay avisos pendientes.\n";
			return;
		}
		$demail = $this->Aviso->buscarSiguiente();
		if( empty( $demail ) ) { return; }
		$datos = array();
		$registrar = false;
		foreach( $demail['VariableAviso'] as $v ) {
			App::import( 'Model', $v['modelo'] );
			$this->$v['modelo'] = new $v['modelo']();
			$this->$v['modelo']->id = $v['id'];
			if( !$this->$v['modelo']->exists() ) {
				$this->log( 'error-avisos', "El indicador del modelo ".$v['modelo']." no es valido. No se eliminará el aviso y se lo dejará registrado aquí." );
				$registrar = true;
			}
			$this->$v['modelo']->recursive = -1;
			$datos[ $v['nombre'] ] = $this->$v['modelo']->read();
		}
		$datos['email_de'] = Configure::read( 'Turnera.email' );
		unset( $demail['VariablesAviso'] );
		$demail['Aviso']['datos'] = $datos;
		if( $registrar == true ) {
			$this->log( 'error-avisos', pr( $datos ) );
		} else {
			$email = new CakeEmail();
			$email->template( $demail['Aviso']['template'], $demail['Aviso']['layout'] )
			->emailFormat( $demail['Aviso']['formato'] )
			->from( $demail['Aviso']['from'] )
			->to( $demail['Aviso']['to'] )
			->subject( $demail['Aviso']['subject'] )
			->viewVars( $demail['Aviso']['datos'] )
			->send();
		}
		$this->Aviso->delete( $demail['Aviso']['id_aviso'] );
	}
}
?>