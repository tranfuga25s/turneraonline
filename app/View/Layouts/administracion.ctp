<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title> <?php echo $title_for_layout; ?> :: Administracion :: Sistema de turnos online </title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('turnera');
		echo $this->Html->css( 'start/jquery-ui');
		echo $this->Html->script( 'jquery-1.7.2.min' );
		echo $this->Html->script( 'jquery-ui-1.8.20.custom.min' );
		echo $scripts_for_layout;
	?>
	<script>
		$( function() {  $("a", ".menu").button(); 	});
	</script>
</head>
<body>
	<div id="container" style="width: 790px; heigth: 580px; border: 1px solid black;">
		<div>
			<table><tbody>
					<tr>
						<td rowspan="2"><?php echo $this->Html->image( 'cabecera.png' ); ?></td>
						<td rowspan="2">
						    <h1><?php echo $this->Html->link( "Sistemas de Turnos On-Line", '/administracion/usuario/cpanel' ); ?></h1>
							Secci&oacute;n de administraci&oacute;n
						</td>
						<td class="menu">
							<?php echo $this->Html->link( 'Inicio', '/administracion/usuarios/cpanel' ); ?> &nbsp; &nbsp;<b>
							Bienvenido <?php echo ", ". $usuarioactual['nombre'] . " " . $usuarioactual['apellido']; ?> ! </b>&nbsp; &nbsp;
							<?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?>
						</td>
					</tr>
					<tr>
						<td class="menu">
								<?php echo $this->Html->link( 'Obras Sociales', array( 'controller' => 'obras_sociales', 'action' => 'index' ) ); ?>
								<?php echo $this->Html->link( 'Usuarios', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?>
								<?php echo $this->Html->link( 'Turnos', array( 'controller' => 'turnos', 'action' => 'index' ) ); ?>
								<?php echo $this->Html->link( 'Medicos', array( 'controller' => 'medicos', 'action' => 'index' ) ); ?>
								<?php echo $this->Html->link( 'Secretarias', array( 'controller' => 'secretarias', 'action' => 'index' ) ); ?>
						</td>
					</tr>
					<tr>
						<td colspan="4"><?php echo $this->Session->flash(); ?><?php echo $this->Session->flash( 'auth' ); ?></td>
					</tr>
			</tbody></table>
		</div>
		<div id="content">
			<?php echo $content_for_layout; ?>
		</div>
		<div id="footer">
			<div style="float: left;"><?php echo $_SERVER['SERVER_NAME']; ?> &copy; 2012</div>
			<?php   echo $this->Html->link(
					$this->Html->image('cake.power.gif', array( 'alt' => "CakePHP", 'border' => '0')),
					'http://www.cakephp.org/',
					array( 'target' => '_blank', 'escape' => false )
				);
			      echo "&nbsp; &nbsp;";
			      echo $this->Html->link( 
					$this->Html->image( 'bslogo.png', array( 'alt' => 'BSComputacion', 'border' => 0 ) ),
					'http://www.bscomputacion.com.ar',
					array( 'target' => '_blank', 'escape' => false  ) );
			      echo "&nbsp; &nbsp;";
			      echo $this->Html->link(
					$this->Html->image( 'tr.logo.png', array( 'alt' => "TR Sistemas Informaticos Integrados", 'border' => '0' ) ),
					'http://www.bscomputacion.org/',
					array( 'target' => '_blank', 'escape' => false )
				);
			?>
		</div>
	<div class="publicidad">
		 <script type="text/javascript"> <!--
			google_ad_client = "ca-pub-1880233918301202";
			/* Desarrollo */
			google_ad_slot = "0058508055";
			google_ad_width = 468;
			google_ad_height = 60;
			//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script> 
	</div>
	<?php echo $this->Html->link( 'Auditoria', array( 'plugin' => 'AuditLog', 'controller' => 'audit_log', 'action' => 'index' ) ); ?>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>