<?php
if (Configure::read('debug') == 0):
	throw new NotFoundException();
endif;
App::uses('Debugger', 'Utility');
?>
<?php
if (Configure::read('debug') > 0):
	Debugger::checkSecurityKeys();
endif;

$this->set( 'title_for_layout', "Sistema de turnos on-line :: Inicio" );
$this->Html->script( 'simpleSlide.min', array( 'inline' => false ) );
?>
<script type="text/javascript">
	$( function() {
		$("#referencia").accordion();
		simpleSlide();
		simpleSlide();
	});
</script>
<style>
.flotatipo {
	float: left;
	border: 1px solid rgba(0, 0, 0, 0.2);
	width: 350px;
	min-height: 150px;
	margin: 2px;
	-ms-border-radius: 4px;
	border-radius: 4px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	text-align: center;b
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
	-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
}
</style>
<div>
 <h1>Bienvenido <?php if( $loggeado ) { echo ", ". $usuarioactual['nombre'] . " " . $usuarioactual['apellido']; } ?> !</h1>
</div>

<div class="decorado1">
<table border="0">
 <tbody>
  <tr>
   <td width="50%">	
	<div class="titulo1">¿Que es este sitio?</div>
	En este sitio se encuentra una demostración del sistema de turnos que tenemos para ofrecerle!.
   </td>
   <td width="30%"><center>
	<div class="titulo2">¿Para quienes es util?</div>
	<div class="right-button left" rel="usuarios" style="display: none;"></div>
	<div class="simpleSlide-window" rel="usuarios">
	    <div class="simpleSlide-tray" rel="usuarios">
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'M&eacute;dicos</div>'           , array( 'controller' => 'pages/clientes/medicos'      ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'Consultorios</div>'             , array( 'controller' => 'pages/clientes/consultorios' ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'Sanatorios y/o Hospitales</div>', array( 'controller' => 'pages/clientes/hospital'     ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'Dentistas</div>'                , array( 'controller' => 'pages/clientes/dentista'     ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'Salones de Belleza</div>'       , array( 'controller' => 'pages/clientes/belleza'      ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'Canchas de F&uacute;tbol</div>' , array( 'controller' => 'pages/clientes/futbol'       ), array( 'escape' => false ) ); ?></div>        
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'Canchas de Tenis</div>'         , array( 'controller' => 'pages/clientes/tenis'        ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="flotatipo">'.$this->Html->image( 'cabecera.png' ).'Hoteles Alojamiento</div>'      , array( 'controller' => 'pages/clientes/hotel'        ), array( 'escape' => false ) ); ?></div>
	    </div>
	</div>
	<div class="simpleSlide-tray" rel="usuarios"></div>
	<div class="auto-slider" rel="usuarios"></div>
	<script>
		$('.auto-slider').each( function() {
		   	window.setInterval("simpleSlideAction( '.right-button', '" + $(this).attr('rel') + "' );", 4000);
		});
	</script>
    <div class="left-button left" rel="usuarios" style="display: none;"></div>
    </center></td>
  </tr>
 </tbody>
</table>
</div>

<div class="decorado1">
<table border="0">
 <tbody>
  <tr>
   <td width="50%">
	<?php if( !$loggeado ) { ?>
	<div class="titulo1">Pruebe nuestro sistema!</div>
	Ingrese por favor su email y su contraseña para ingresar al sistema.<br />
	<center>
	<?php
		echo $this->Form->create( 'Usuario', array( 'action' => '/ingresar' ) );
		echo $this->Form->text( 'email', array( 'label' => 'E-mail:' ) );
		echo "<br />";
		echo $this->Form->password( 'contra', array( 'label' => 'Contraseña:' ) );
		echo $this->Form->end( 'Ingresar' );
	?>
	
	<?php echo $this->Html->link( 'Olvide mi contraseña',
			array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' )  ); ?>
	&nbsp;
	<?php echo $this->Html->link( 'Registrarme',
			array( 'controller' => 'Usuarios', 'action' => 'registrarse' )  ); ?>
	</center>
	<?php } else { ?>
	<div class="titulo1">Bienvenido</div>
		<br />
		<center>
<div class="actions2">
			<ul>
	<?php   if( $usuarioactual['grupo_id'] == 4 ) { // Usuario normal ?>
				<li><?php echo $this->Html->link( 'Pedir turno', array( 'controller' => 'turnos', 'action' => 'nuevo', $usuarioactual['id_usuario'] ) ); ?></li>
				<li><?php echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
	<?php   } ?>
				<li><?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view', $usuarioactual['id_usuario'] ) ); ?></li>
	<?php  if( $usuarioactual['grupo_id'] == 3 ) { // SECRETARIAS ?>
				<li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'secretarias', 'action' => 'turnos' ) ); ?></li>
				<li><?php //echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view', $usuarioactual['id_usuario'] ) ); ?></li>
				<li><?php //echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
	<?php 	} else if( $usuarioactual['grupo_id'] == 2 ) { // MEDICOS ?>
				<li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'medicos', 'action' => 'turnos' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Disponibilidad', array( 'controller' => 'medicos', 'action' => 'disponibilidad' ) ); ?></li>
				<li><?php //echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
	<?php 	} else if( $usuarioactual['grupo_id'] == 1 ) { // ADMINISTRADORES ?>
				<li><?php echo $this->Html->link( 'Administración', '/administracion/usuarios/cpanel' ); ?></li>
	<?php 	} ?>
				<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>
			</ul>
		</div>
		
	<?php } ?>
		</center>
   </td>
   <td>
	<div class="titulo1">¿Como puedo probarlo?</div>
	Para ingresar y ver las características de este sitio ingrese mediante cualquier a de las siguientes cuentas:
	<div id="referencia">
		<h3><a href="#">Referencia</a></h3>
		<div>
			<small>
			Para probar las posibilidades de las secretarias ingrese con:<br />
			<b>Usuario:</b>&nbsp; secretaria@turnera.com<br /><b>Contraseña:</b> secretaria.<br /><br />
			Para probar las posibilidades de los medicos ingrese con:<br />
			<b>Usuario:</b> medico@turnera.com<br /><b>Contraseña:</b> medico.<br /><br />
			Para probar las posibilidades de los pacientes ingrese con:<br />
			<b>Usuario:</b> paciente@turnera.com<br /><b>Contraseña:</b> paciente.<br /><br />
			</small>
		</div>
	</div>
   </td>
  </tr>
 </tbody>
</table>
</div>