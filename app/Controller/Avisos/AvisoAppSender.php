<?php

/**
 * Clase de implementacion abstracta para cada enviador de mensajes
 */

 interface AvisoAppSender {
     public function habilitado();
     public function verAvisosDisponibles();
     public function disponible( $tipo_aviso = null );
     public function renderizarAviso( $id_aviso = null );
     public function enviar( $id_aviso = null );
 }
