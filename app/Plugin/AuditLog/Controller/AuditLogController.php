<?php

class AuditLogController extends AuditLogAppController {

    var $uses = array( 'AuditLog.Audits' );

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
        $this->loadModel( 'Usuario' );
		$this->set( 'usuarios', $this->Usuario->find( 'list' ) );
  }

}

?>