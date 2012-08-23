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
?>
<div>
 <h1>Bienvenido <?php if( $loggeado ) { echo ", ". $usuarioactual['nombre'] . " " . $usuarioactual['apellido']; } ?> !</h1>
 Aqui encontrar&aacute; todas las partes que se estan desarrollando para el sistema de Turnos Online.
</div>

<div class="decorado1">
	<div class="titulo1">Clinicas Disponibles</div>
	<div> <?php echo $this->requestAction( array( 'controller' => 'clinicas', 'action' => 'clinicasInicio' ) ); ?> </div>
</div>

<div class="decorado1">
<table border="0">
 <tbody>
  <tr>
   <td width="50%">
	<?php if( !$loggeado ) { ?>
	<div class="titulo1">Ingresar y solicitar un turno</div>
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
				<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
				<li><?php //echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
	<?php 	} else if( $usuarioactual['grupo_id'] == 2 ) { // MEDICOS ?>
				<li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'medicos', 'action' => 'turnos' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Disponibilidad', array( 'controller' => 'medicos', 'action' => 'disponibilidad' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
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
	<div class="titulo1">Especialidades Disponibles</div>
	<div><?php echo $this->requestAction( array( 'controller' => 'especialidades', 'action' => 'especialidadesInicio' ) ); ?> </div>
   </td>
  </tr>
 </tbody>
</table>
</div>
