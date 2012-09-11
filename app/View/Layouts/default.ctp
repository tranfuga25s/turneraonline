<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title> <?php echo $title_for_layout; ?> :: Turnos On-Line :: <?php echo $_SERVER['SERVER_NAME']; ?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('turnera');
		echo $this->Html->css( 'start/jquery-ui');
		echo $this->Html->script( 'jquery-1.7.2.min' );
		echo $this->Html->script( 'jquery-ui-1.8.20.custom.min' );
		echo $scripts_for_layout;
	?>
	<meta lang="es" name="keywords" content="Turnos, turnos online, santa fe, clinica, medico, paciente, pedir turno, argentina" />
</head>
<body>
		<div id="header">
			<div id="header2" class="ui-corner-bottom">
				<div id="header3">
				<?php echo $this->Html->link(
						$this->Html->image( 'cabecera.png', array( 'class' => 'imagenCabecera' ) ),
						'/',
						array( 'escape' => false ) ); ?>
				<?php echo $this->Html->link(
						$this->Html->image( 'ayuda.png', array( 'class' => 'imagenAyuda' ) ),
						'/pages/ayuda',
						array( 'escape' => false ) ); ?>
				<?php echo $this->Html->link( 
								 $this->Html->image( 'contacto.png', array( 'class' => 'imagenAyuda' ) ),
								 '/contacto/formulario',
								 array( 'escape' => false ) ); ?>
				<h1><?php echo $this->Html->link( "Sistema de turnos online", '/', array( 'style' => 'font-weight: bolder;' ) ); ?></h1>
				Sitio de demostraci&oacute;n
			    </div>
			</div>
		</div>

		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash( 'auth' ); ?>
			<?php echo $content_for_layout; ?>
		</div>

		<div id="footer">
			<div style="float: left;"><?php echo $_SERVER['SERVER_NAME']; ?> &copy; 2012</div>
			<?php echo $this->Html->link(
					$this->Html->image( 'tr.logo.png', array( 'alt' => "TR Sistemas Informaticos Integrados", 'border' => '0' ) ),
					'http://www.bscomputacion.org/',
					array( 'target' => '_blank', 'escape' => false )
				);	?>
		</div>
		
		<div id="feedback">
		    <?php echo $this->element( 'devolucion' ); ?>
		</div>
</body>
</html>