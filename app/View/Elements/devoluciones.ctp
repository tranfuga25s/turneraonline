<?php
 // Muestra el formulario para generar devoluciónes desde el usuario
 
 ?>
 <style>
 #devolucion {
    position: fixed;
	bottom: -2px;
	right: 0px;
	font-size: 12px;
	z-index: 200;
	-moz-box-shadow: 0 -1px 1px rgba(0,0,0,.05);
	-ms-box-shadow: 0 -1px 1px rgba(0,0,0,.05);
	-webkit-box-shadow: 0 -1px 1px rgba(0, 0, 0, .05);
	box-shadow: 0 -1px 1px rgba(0, 0, 0, .05);
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
	border-radius: 2px;
	background-color: #ACACAC;
	padding-top: 7px;
	padding-bottom: 7px;
	padding-left: 10px;
	padding-right: 10px;
	border: 2px solid #9C9C9C;	
 }
 
 #devolucion a {
 	color: white;
 	text-decoration: none;
 }
 
 #devolucion a:hover {
 	color: black;
 }
 </style>
 <div id="devolucion">
    <?php echo $this->Html->link( 'Error!', array( 'controller' => 'contacto', 'action' => 'error' ) ); ?>
    <?php echo $this->Html->link( '¿Sugerencia?', array( 'controller' => 'contacto', 'action' => 'sugerencia' ) ); ?>
 </div>