<?php
App::uses( 'AppController', 'Controller' );
App::uses( 'Avisos/AvisoAppSender','Controller' );

class EmailSender extends AppController implements AvisoAppSender {

    private $disponibles = array(
        'nuevoTurno' => array(
            'template' => 'nuevoTurno',
            'layout' => 'usuario',
            'formato' => 'both'
        ),
        'turnoCancelado' => array(
            'template' => 'turnoCancelado',
            'layout' => 'usuario',
            'formato' => 'both'
        )
    );

    public function habilitado() {
        return true;
    }

    public function verAvisosDisponibles() {
        return array_keys( $disponibles );
    }

    public function renderizarAviso( $id_aviso = null ) {
        $this->Aviso = new Aviso();
        $this->Aviso->id = $id_aviso;
        if( !$this->Aviso->exists() ) {
            throw new NotFoundExpception( 'No se encontró el aviso buscado' );
        }
        $this->Aviso->recursive = 2;
        $demail = $this->Aviso->read( null, $id_aviso );

        $datos = array();
        foreach( $demail['VariableAviso'] as $v ) {
            $this->loadModel( $v['modelo'] );
            $this->$v['modelo']->id = $v['id'];
            if( !$this->$v['modelo']->exists() ) {
                throw new NotFoundException( 'No se encontró uno de los datos del aviso. Modelo: '.$v['modelo'].' - id: '.$v['id'] );
            }
            $this->$v['modelo']->recursive = -1;
            $datos[ $v['nombre'] ] = $this->$v['modelo']->read();
        }
        $datos['email_de'] = Configure::read( 'Turnera.email' );
        unset( $demail['VariablesAviso'] );
        $demail['Aviso']['datos'] = $datos;

        // Busco la vista a renderizar
        $demail['Aviso']['formato'] = 'html';
        foreach( $demail['Aviso']['datos'] as $k=>$d ) {
          $this->set( $k, $d );
        }
        $this->layout = 'Emails/'.$demail['Aviso']['formato'].'/'.$demail['Aviso']['layout'];
        return $this->render( '../Emails/'.$demail['Aviso']['formato'].'/'.Inflector::underscore( $demail['Aviso']['template'] ) );
    }

    public function enviar( $id_aviso = null ) {
        $this->Aviso = new Aviso();
        $this->Aviso->id = $id_aviso;
        if( !$this->Aviso->exists() ) {
            throw new NotFoundException( 'No se encontró el aviso a enviar' );
        }
        $demail = $this->Aviso->read();
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
            return false;
        } else {
            $email = new CakeEmail();
            $email->template( $demail['Aviso']['template'], $demail['Aviso']['layout'] )
            ->emailFormat( $demail['Aviso']['formato'] )
            ->from( $demail['Aviso']['from'] )
            ->to( $demail['Aviso']['to'] )
            ->subject( $demail['Aviso']['subject'] )
            ->viewVars( $demail['Aviso']['datos'] );
            return $email->send();
        }

    }

}
