<?php
$this->set( 'modelo', 'Medico' );
$this->extend( '/Turnos/turnos_dia' );

echo $this->element( 'Turnos/lista_turnos', array( 'turnos' => $turnos ) );

?>