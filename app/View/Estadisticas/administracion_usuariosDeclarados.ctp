<!-- Genero el grafico correspondiente -->
<?php

$grafico = new PieGraph( $ancho, $alto );

$grafico->title->Set( "Cantidad de usuarios por tipo" );
$grafico->subtitle->Set( "Total de usuarios: ".$total_usuarios );

$pieplot = new PiePlot( $datos );

?>