<?php

/**
 * Clase de implementacion abstracta para cada enviador de mensajes
 */
 
 interface EnviadorAviso {
     
     public function habilitado();
     public function verAvisosDisponibles();
     public function verAviso();
 }
