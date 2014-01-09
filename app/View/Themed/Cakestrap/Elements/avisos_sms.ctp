<?php
$mensajes = Cache::read( 'mensajes', 'sms' );
if( $mensajes != false ) {

    $primero = array_shift( $mensajes );

    echo $this->element( 'flash/info', array( 'message' => $mensajes['alerta'] ) );

    Cache::write( 'mensajes', $mensajes, 'sms' );
}