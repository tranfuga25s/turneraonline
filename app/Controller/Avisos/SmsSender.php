<?php
App::uses( 'SmsComponent', 'Gestotux.Components' );

class SmsSender implements AvisoAppSender {

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

    private $_limite_caracteres = 140;

    public function habilitado() {
        return false;
    }

    public function verAvisosDisponibles() {
        return array_keys( $disponibles );
    }

    public function renderizarAviso( $id_aviso = null ) {
        // Busco los datos del aviso
        $this->Aviso->id = $id_aviso;
        if( !$this->Aviso->exists() ) {
            throw new NotFoundException( "El aviso solicitado no existe!" );
        }
        $aviso = $this->Aviso->read();
        $datos = array();
        foreach( $aviso['VariableAviso'] as $v ) {
            $this->loadModel( $v['modelo'] );
            $this->$v['modelo']->id = $v['id'];
            if( !$this->$v['modelo']->exists() ) {
                throw new NotFoundException( 'No se encontró uno de los datos del aviso. Modelo: '.$v['modelo'].' - id: '.$v['id'] );
            }
            $this->$v['modelo']->recursive = -1;
            $datos[ $v['nombre'] ] = $this->$v['modelo']->read();
        }
        $datos['celular'] = Configure::read( 'Turnera.celular' );
        unset( $demail['VariablesAviso'] );
        $aviso['Aviso']['datos'] = $datos;

        foreach( $aviso['Aviso']['datos'] as $k=>$d ) {
          $this->set( $k, $d );
        }
        $this->layout = 'Emails'.DS.'sms'.DS.$aviso['Aviso']['layout'];
        $salida = $this->render( '../Emails/'.$demail['Aviso']['formato'].'/'.Inflector::underscore( $demail['Aviso']['template'] ) );
        /// @TODO Controlar largo del mensaje
        return $salida;
    }

}
