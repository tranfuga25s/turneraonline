<?php
App::uses( 'SmsComponent', 'Waltook.Controller/Component' );
App::uses( 'AvisosController', 'Controller' );

class SmsSender extends AvisosController implements AvisoAppSender {

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
    public function loadHelpers() {}

    public function verAvisosDisponibles() {
        return array_keys( $disponibles );
    }
    
    public function disponible( $aviso = null ) {
        return array_key_exists( $aviso, $this->disponibles );
    }

    public function renderizarAviso( $id_aviso = null ) {
        // Busco los datos del aviso
        $this->loadModel( 'Aviso' );
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
        unset( $aviso['VariablesAviso'] );
        $aviso['Aviso']['datos'] = $datos;

        foreach( $aviso['Aviso']['datos'] as $k=>$d ) {
          $this->set( $k, $d );
        }
        debug( $aviso );
        $this->layout = 'Emails'.DS.'sms'.DS.$aviso['Aviso']['layout'];
        $vista = new View();
        $salida = $vista->render( '..'.DS.'Emails'.DS.'sms'.DS.Inflector::underscore( $aviso['Aviso']['template'] ) );
        if( count( $texto ) > $this->_limite_caracteres ) {
            // Corto el texto
            $texto = String::truncate( $text0, $this->_limite_caracteres );    
        }
        return $salida;
    }

    public function enviar( $id_aviso = null ) {
        $this->loadModel( 'Aviso' );
        $this->Aviso->id = $id_aviso;
        if( !$this->Aviso->exists() ) {
            throw new NotFoundException( "El aviso solicitado no existe!" );
        }
        $aviso = $this->Aviso->read();
        $this->Sms = new SmsComponent( new ComponentCollection() );
        if( $this->Sms->habilitado() ) {
            
            $num_telefono = $aviso['Aviso']['to'];
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
            unset( $aviso['VariablesAviso'] );
            $aviso['Aviso']['datos'] = $datos;
    
            foreach( $aviso['Aviso']['datos'] as $k=>$d ) {
              $this->set( $k, $d );
            }
            
            $this->layout = 'Emails'.DS.'sms'.DS.$aviso['Aviso']['layout'];
            $vista = new View( $this );
            $texto = $vista->render( '..'.DS.'Emails'.DS.'sms'.DS.Inflector::underscore( $aviso['Aviso']['template'] ) );
            if( count( $texto ) > $this->_limite_caracteres ) {
                // Corto el texto
                $texto = String::truncate( $text0, $this->_limite_caracteres );    
            }
            return $this->Sms->enviar( $num_telefono, $texto );
        }
        return false;
    }

}
