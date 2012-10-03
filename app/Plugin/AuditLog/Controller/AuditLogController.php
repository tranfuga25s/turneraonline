<?php

class AuditLogController extends AuditLogAppController {
    
    var $uses = array( 'AuditLog.Audits', 'Usuarios' );
  
  public function administracion_index() {
      // Muestra la paginación de los logs del sistema
      $this->set( 'auditorias', $this->paginate() );
  }
  
  public function administracion_view( $id = null ) {
        $this->Audits->id = $id;
        if (!$this->Audits->exists()) {
            throw new NotFoundException( __('Invalid audit' ) );
        }
        $this->Audits->bindModel( array( 'hasMany' => array( 'AuditDeltas' ) ) );
        $this->set( 'audit', $this->Audits->read( null, $id ) );
		$dat = $this->Users->find( 'all', array( 'fields' => array( 'id', 'username' ) ) );
		foreach( $dat as $u ) {
			$usuarios[$u['Users']['id']] = $u['Users']['username'];
		}
		$this->set( 'usuarios', $usuarios );
  }  
    
}

?>