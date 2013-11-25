<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"> -->
<?php echo $this->Facebook->html(); ?>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title><?php echo $title_for_layout; ?> :: Turnos On-Line :: <?php echo $_SERVER['SERVER_NAME']; ?></title>
		<?php
			echo $this->Html->meta('icon');

			echo $this->fetch('meta');

			echo $this->Html->css('bootstrap.min');
			echo $this->Html->css('bootstrap-responsive.min');
			echo $this->Html->css('core');

			echo $this->fetch('css');

			echo $this->Html->script('libs/jquery');
			echo $this->Html->script('libs/bootstrap.min');

			echo $this->fetch('script');
		?>
		<meta lang="es" name="keywords" content="Turnos, turnos online, clinica, medico, paciente, pedir turno, argentina" />
	</head>

	<body>
		<div id="main-container">
			<div id="header" class="container">
				<?php echo $this->element('menu/top_menu'); ?>
			</div><!-- #header .container -->

			<div id="content" class="container">

				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
			</div><!-- #header .container -->

			<div id="footer" class="container well">
				<?php echo $_SERVER['SERVER_NAME']; ?> &copy; 2012 &nbsp;
				<?php echo $this->Html->link(
					$this->Html->image( 'tr.logo.png', array( 'alt' => "TR Sistemas Informaticos Integrados", 'border' => '0' ) ),
						'http://www.bscomputacion.org/',
						array( 'target' => '_blank', 'escape' => false, 'class' => 'pull-right', 'style' => 'margin-left: 3px;' )
					);	?>
				<div class="pull-right">
				   <?php echo $this->Html->link( '<i class="icon-briefcase"></i>', array( 'controller' => 'pages', 'action' => 'display', 'legal' ), array( 'escape' => false ) ); ?>
				   <?php echo $this->Html->tag( 'a', '<i class="icon-info-sign"></i>',
				   			array( 	'escape' => false,
				   					'data-toogle' => 'popover',
				   					'title' => 'Informacion del tema',
				   					'data-original-title' => 'Informacion del tema',
				   					'data-placement' => 'left',
				   					'data-html' => 'true',
				   					'data-trigger' => 'click',
				   					'id' => 'test',
				   					'data-content' =>
				   						"Tema basado en <a href='http://twitter.github.io/bootstrap' target='_blank'>Bootstrap</a>".
				   						"<br />".
				   						"Iconos basados en <a href='http://glyphicons.com/' taget='_blank'>Glyphicons</a>"
				   	 ) ); ?>
			   </div>
			   <script>$(function() { $("#test").popover(); });</script>
			</div><!-- #footer .container -->

		</div><!-- #main-container -->
		<?php echo $this->element( 'sql_dump' ); ?>
		<?php echo $this->Js->writeBuffer(); ?>
	</body>
    <?php echo $this->Facebook->init(); ?>
</html>