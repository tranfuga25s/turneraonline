<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?> :: Turnos On-Line :: <?php echo $_SERVER['SERVER_NAME']; ?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('turnera');
		echo $this->Html->css( 'start/jquery-ui');
		echo $this->Html->script( 'jquery-1.7.2.min' );
		echo $this->Html->script( 'jquery-ui-1.8.20.custom.min' );
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<meta lang="es" name="keywords" content="Turnos, turnos online, santa fe, clinica, ginecologia, medico, paciente, pedir turno, argentina, alejandro, alejandro talin, oncologia, tracto genital, Docente Faculta de Medicina" />
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
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<div style="float: left;"><?php echo $_SERVER['SERVER_NAME']; ?> &copy; 2012</div>
			<?php echo $this->Html->link(
					$this->Html->image( 'tr.logo.png', array( 'alt' => "TR Sistemas Informaticos Integrados", 'border' => '0' ) ),
					'http://www.bscomputacion.org/',
					array( 'target' => '_blank', 'escape' => false )
				);	?>
		</div>
		<?php echo $this->element('sql_dump'); ?>
</body>
</html>