<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<?php echo $this->Html->link( $this->Html->image( 'cabecera.png' ), '/', array( 'escape' => false, 'style' => 'float: left; margin-right: 5px; margin-top: 10px;' ) ); ?>
			<div class="brand">
				<h4><?php echo $this->Html->link( "Sistema de turnos online", '/' ); ?></h4>
				<small>Sitio de demostraci&oacute;n</small>
			</div>
			<ul class="nav pull-right">
				<li><?php echo $this->Html->link( $this->Html->image( 'ayuda.png' ), '/pages/ayuda', array( 'escape' => false ) ); ?></li>
				<li><?php echo $this->Html->link( $this->Html->image( 'contacto.png' ), '/contacto/formulario', array( 'escape' => false ) ); ?></li>
			</ul>
		</div>
	</div>
</div>