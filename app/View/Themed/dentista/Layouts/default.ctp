<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title> <?php echo $title_for_layout; ?> :: Turnos On-Line :: <?php echo $_SERVER['SERVER_NAME']; ?></title>
	<?php
		echo $this->Html->meta('icon');
		//echo $this->Html->css('/theme/dentista/css/dentista');
		echo $this->Html->css('dentista');
		echo $this->Html->css('redmond/jquery-ui-1.9.1.custom.min');
		echo $this->Html->script( 'jquery-1.7.2.min' );
		echo $this->Html->script( 'jquery-ui-1.8.20.custom.min' );
		echo $scripts_for_layout;
	?>
	<meta lang="es" name="keywords" content="Turnos, turnos online, santa fe, dentista, pedir turno, argentina" />
</head>
<body>
	<div class="ui-corner-all contenedor">
		&nbsp;
		<div class="cinta ui-corner-all">
				<?php echo $this->Html->link(
						$this->Html->image( 'cabecera.png', array( 'class' => 'imagenCabecera' ) ),
						'/',
						array( 'escape' => false ) ); ?>
				<h1><?php echo $this->Html->link( "Sistema de turnos online", '/', array( 'style' => 'font-weight: bolder;' ) ); ?></h1>
				<h3>Sitio de demostraci&oacute;n</h3>
				<?php echo $this->Html->link(
						$this->Html->image( 'ayuda.png', array( 'class' => 'imagenAyuda' ) ),
						'/pages/ayuda',
						array( 'escape' => false ) ); ?>
				<?php echo $this->Html->link( 
								 $this->Html->image( 'contacto.png', array( 'class' => 'imagenAyuda' ) ),
								 '/contacto/formulario',
								 array( 'escape' => false ) ); ?>
				
		</div>
		<div class="contenido">
			<script type="application/javascript" language="JavaScript">
				$(function() { $("#menu-principal").menu(); $("#menu-principal").removeClass('ui-widget-content') });
			</script>	
			<div class="menu">
				<ul  id="menu-principal">
					<li><a>Item1</a></li>
					<li><a>Item2</a></li>
					<li><a>Item3</a></li>
					<li><a>Item4</a></li>
					<li><a>Item5</a></li>
					<li><a>Item6</a></li>
					<li><a>Item7</a></li>
					<li><a>Item8</a></li>
					<li><a>Item9</a></li>
				</ul>
			</div>
			<div class="contenido2">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->Session->flash( 'auth' ); ?>
				<?php echo $content_for_layout; ?>
			</div>
		</div>
		<div class="pie ui-corner-all">
			<div style="float: left;"><?php echo $_SERVER['SERVER_NAME']; ?> &copy; 2012</div>
			<?php echo $this->Html->link(
					$this->Html->image( 'tr.logo.png', array( 'alt' => "TR Sistemas Informaticos Integrados", 'border' => '0' ) ),
					'http://www.gestotux.com.ar/',
					array( 'target' => '_blank', 'escape' => false )
				);	?>
		</div>
		<?php if( $loggeado ) { ?>
			<div id="feedback">
			    <?php //echo $this->element( 'devolucion' ); ?>
			</div>
		<?php } ?>
	</div>
 	&nbsp;
	<?php echo $this->element( 'sql_dump' ); ?>
</body>
</html>