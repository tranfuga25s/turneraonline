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

$this->set( 'title_for_layout', "Sistema de turnos on-line :: Inicio" ); ?>
<div class="row-fluid">
		
	<div class="span6 well">
		<div class="row-fluid">
			<div class="span12">
				<h3>¿Que es este sitio?</h3>
				<p>En este sitio se encuentra una demostración del sistema de turnos que tenemos para ofrecerle!.</p>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span12">
				<h3>Nuestros datos</h3>
				<?php echo $this->Html->link( 'Horarios de atención aqui', array( 'controller' => 'medicos', 'action' => 'view' ), array( 'class' => 'btn btn-primary btn-block' ) ); ?>
				<?php echo $this->Html->link( 'Obras sociales disponibles', array( 'controller' => 'obras_sociales', 'action' => 'index' ), array( 'class' => 'btn btn-info btn-block' ) ); ?>
				<?php echo $this->Html->link( '¿Donde estamos?', array( 'controller' => 'clinicas', 'action' => 'view', 1 ), array( 'class' => 'btn btn-success btn-block' ) ); ?>
			</div>
		</div>
		<br />
		<?php echo $this->Facebook->like(); ?>

	</div> <!-- fin infositio -->

	<div class="span6 well">
		<?php echo $this->element( 'carrusel' ); ?>
	</div><!-- carrusel -->
	

</div>

<div class="row-fluid">
	<div class="span6 well">
	<?php if( !$loggeado ) { ?>
		<?php echo $this->Form->create( 'Usuario', array( 'action' => '/ingresar' ) ); ?>
		<fieldset>
			<legend>Pruebe nuestro sistema</legend>
			<p class="center">Ingrese por favor su email y su contraseña para ingresar al sistema.</p>
			<?php echo $this->Form->input( 'email', array( 'label' => 'E-mail:', 'type' => 'text' ) ); ?>
			<?php echo $this->Form->label( 'Contraseña' ); ?>
			<?php echo $this->Form->password( 'contra' ); ?>
			<div class="form-actions">
				<?php echo $this->Form->submit( 'Ingresar', array( 'class' => 'btn btn-primary', 'div' => false ) ); ?>
				<?php echo $this->Html->link( 'Registrarme', array( 'controller' => 'Usuarios', 'action' => 'registrarse' ), array( 'class' => 'btn' )  ); ?>
				<?php echo $this->Html->link( 'Olvide mi contraseña', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' ), array( 'class' => 'btn' )  ); ?>
			</div>
		</fieldset>
		<?php echo $this->Facebook->login( array( 'label' => 'Ingresar con facebook', 'redirect' => array( 'controller' => 'usuarios', 'action' => 'view' ) ) ); ?>	
	<?php } else { ?>
		<fieldset>
			<legend>Bienvenido <?php if( $loggeado ) { echo ", ". $usuarioactual['nombre'] . " " . $usuarioactual['apellido']; } ?> !</legend>
		</fieldset>
			<ul class="nav nav-list">
				<?php   if( $usuarioactual['grupo_id'] == 4 ) { // Usuario normal ?>
							<li><?php echo $this->Html->link( 'Pedir turno', array( 'controller' => 'turnos', 'action' => 'nuevo', $usuarioactual['id_usuario'] ) ); ?></li>
							<li><?php echo $this->Html->link( 'Mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuarioactual['id_usuario'] ) ); ?></li>
							<li><?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view', $usuarioactual['id_usuario'] ) ); ?></li>
				<?php   } 
			    	    if( $usuarioactual['grupo_id'] == 3 ) { // SECRETARIAS ?>
							<li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'secretarias', 'action' => 'turnos' ) ); ?></li>
							<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
							<li><?php echo $this->Html->link( 'Resumen Diario', array( 'controller' => 'secretarias', 'action' => 'resumen' ) ); ?></li>
			
				<?php 	} else if( $usuarioactual['grupo_id'] == 2 ) { // MEDICOS ?>
							<li><?php echo $this->Html->link( 'Turnos del día', array( 'controller' => 'medicos', 'action' => 'turnos' ) ); ?></li>
							<li><?php echo $this->Html->link( 'Disponibilidad', array( 'controller' => 'medicos', 'action' => 'disponibilidad' ) ); ?></li>
							<li><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>				
			
				<?php 	} else if( $usuarioactual['grupo_id'] == 1 ) { // ADMINISTRADORES ?>
							<li><?php echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view', $usuarioactual['id_usuario'] ) ); ?></li>
							<li><?php echo $this->Html->link( 'Administración', '/administracion/usuarios/cpanel' ); ?></li>
			
				<?php 	} ?>
							<li class="divider"></li>
							<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li>				
			</ul>
	<?php } ?>
	</div>
	
	<div class="span6 well">
		<fieldset><legend>¿Como puedo probarlo?</legend></fieldset>
		<p>Para ingresar y ver las características de este sitio ingrese mediante cualquiera de las siguientes cuentas:</p>
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

<div class="row-flow">
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-1880233918301202";
		/* Turnera-frontpage2 */
		google_ad_slot = "2436087288";
		google_ad_width = 728;
		google_ad_height = 90;
		//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div><!-- end publicity -->