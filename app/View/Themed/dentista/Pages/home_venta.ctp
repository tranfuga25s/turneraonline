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
		$("#horarios").button();
		$("a", "#botones").button();
		$("#referencia").accordion();
		simpleSlide();
		simpleSlide();
	});
</script>
<div class="ui-widget-content ui-corner-all  alinear-superior">
<table border="0">
 <tbody>
  <tr>
   <td width="50%" class="alinear-superior">	
	<div class="ui-widget-header ui-corner-all alinear-centrado separacion-titulo">¿Que es este sitio?</div>
	<br />
	En este sitio se encuentra una demostraci&oacute;n del sistema de turnos que tenemos para ofrecerle!.<br /><br />
	<div class="ui-widget-header ui-corner-all alinear-centrado separacion-titulo">Horarios de atención</div>
	<br />
	<center>
		<?php echo $this->Html->link( 'Horarios de atención aqui', array( 'controller' => 'medicos', 'action' => 'view' ), array( 'id' => 'horarios' ) ); ?>
	</center>
   </td>
   <td width="30%" class=" alinear-superior"><center>
	<div class="ui-widget-header ui-corner-all alinear-centrado separacion-titulo">¿Para quienes es util?</div>
	<div class="right-button left" rel="usuarios" style="display: none; "></div>
	<div class="simpleSlide-window alinear-centrado" rel="usuarios" style="height: 150px; width: 250px; position: relative; overflow: hidden; ">
	    <div class="simpleSlide-tray" rel="usuarios">
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />M&eacute;dicos</div>'           , array( 'controller' => 'pages/clientes/medicos'      ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />Consultorios</div>'             , array( 'controller' => 'pages/clientes/consultorios' ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />Sanatorios y/o Hospitales</div>', array( 'controller' => 'pages/clientes/hospital'     ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />Dentistas</div>'                , array( 'controller' => 'pages/clientes/dentista'     ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />Salones de Belleza</div>'       , array( 'controller' => 'pages/clientes/belleza'      ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />Canchas de F&uacute;tbol</div>' , array( 'controller' => 'pages/clientes/futbol'       ), array( 'escape' => false ) ); ?></div>        
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />Canchas de Tenis</div>'         , array( 'controller' => 'pages/clientes/tenis'        ), array( 'escape' => false ) ); ?></div>
	        <div class="simpleSlide-slide" rel="usuarios"><?php echo $this->Html->link( '<div class="ui-corner-all ui-widget-content flotatipo">'.$this->Html->image( 'cabecera.png' ).'<br />Hoteles Alojamiento</div>'      , array( 'controller' => 'pages/clientes/hotel'        ), array( 'escape' => false ) ); ?></div>
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
&nbsp;
<div>
<table border="0">
 <tbody>
  <tr>
   <td width="50%" class="ui-widget-content ui-corner-all alinear-superior">
	<?php if( !$loggeado ) { ?>
	<div class="ui-widget-header ui-corner-all alinear-centrado separacion-titulo">Pruebe nuestro sistema!</div>
	<?php echo $this->Form->create( 'Usuario', array( 'action' => '/ingresar' ) ); ?>
	<table>
	    <tbody>
	       <tr>
	           <td colspan="2" style="text-align: center;">Ingrese por favor su email y su contraseña para ingresar al sistema.</td>
	       </tr>
	       <tr>
	           <td style="text-align: right;"><b>Email:</b></td>
	           <td style="text-align: left;"><?php echo $this->Form->text( 'email', array( 'label' => 'E-mail:' ) ); ?></td>
	       </tr>
	       <tr>
	           <td style="text-align: right;"><b>Contrase&ntilde;a:</b></td>
	           <td style="text-align: left;"><?php echo $this->Form->password( 'contra', array( 'label' => 'Contraseña:' ) ); ?></td>
	       </tr>
	       <tr><td colspan="2" style="text-align: center;"><?php echo $this->Form->end( 'Ingresar' ); ?></td></tr>
	       <tr id="botones">
	           <td style="text-align: center;"><?php echo $this->Html->link( 'Registrarme', array( 'controller' => 'Usuarios', 'action' => 'registrarse' )  ); ?></td>
	           <td style="text-align: center;"><?php echo $this->Html->link( 'Olvide mi contraseña', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' )  ); ?></td>
	       </tr>
	    </tbody>
	</table>
	<?php } else { ?>
	<div class="ui-widget-header ui-corner-all">Bienvenido</div>
		<br />
		<center>
<div class="actions2">
			<ul>
	<?php   if( $usuarioactual['grupo_id'] == 4 ) { // Usuario normal ?>
				<li><?php echo $this->Html->link( 'Pedir turno', array( 'controller' => 'turnos', 'action' => 'nuevo', $usuarioactual['id_usuario'] ) ); ?></li>
				<li><?php echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
				<li><?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view', $usuarioactual['id_usuario'] ) ); ?></li>
	<?php   } ?>

	<?php  if( $usuarioactual['grupo_id'] == 3 ) { // SECRETARIAS ?>
				<li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'secretarias', 'action' => 'turnos' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Resumen Diario', array( 'controller' => 'secretarias', 'action' => 'resumen' ) ); ?></li>
				<li><?php //echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
	<?php 	} else if( $usuarioactual['grupo_id'] == 2 ) { // MEDICOS ?>
				<li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'medicos', 'action' => 'turnos' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Disponibilidad', array( 'controller' => 'medicos', 'action' => 'disponibilidad' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>				
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
   <td class="ui-widget-content ui-corner-all alinear-superior">
	<div class="ui-widget-header ui-corner-all alinear-centrado separacion-titulo">¿Como puedo probarlo?</div>
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