<?php
$this->set( 'title_for_layout', "Sistema de mensajes SMS" );
?>

<div class="row-fluid">

	<div class="span2" id="navegacion">
		<ul class="nav nav-list well affix span2">
			<li class="nav-header">Extras > Mensajes de Texto</li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Avisos', '#avisos' ); ?></li>
			<li><?php echo $this->Html->tag( 'a', '<i class="icon-chevron-right"></i>Costos', '#costos' ); ?></li>
		</ul>
		<?php echo $this->Html->link( 'Volver', '', array( 'class' => 'btn btn-primary', 'onclick' => 'window.history.back();' ) ); ?>
	</div>

	<div class="span9 offset1">
		<h3>Sistema de mensajes de texto a celular</h3>
		<p>Este sistema le permite estar en contacto con las personas que tiene algún turno reservado.</p>
		<h5 id="avisos">Avisos</h5>
		<p>El sistema le permite realizar los siguientes avisos mediante mensaje de texto.</p>
		<ul class="unstyled">
			<li><i class="icon-envelope"></i>&nbsp;Cuando un turno reservado se encuentra a 1 hora de ser realizado.</li>
			<li><i class="icon-envelope"></i>&nbsp;Cuando un turno es cancelado dentro del mismo día en que se debe concurrir.</li>
			<li><i class="icon-envelope"></i>&nbsp;Mensajes especiales para todos los interesados simultaneamente.</li>
		</ul>
		<h5 id="costos">Costos</h5>
		<p>La integración se ha realizado con el sistema <?php echo $this->Html->link( 'Waltook', 'http://www.waltook.com/' ); ?>, y por lo tanto, se deben revisar sus costos.</p>
		<p>El sitema utiliza un cobro por cantidad de mensajes por adelantado.<br />
		   Una vez habilitado el servicio nuestro sistema le mostrará cuantos mensajes de texto disponibles tiene para enviar y recibir. Además le permitirá contratar nuevos paquetes de mensajes cuando los necesite.</p>
	</div>
</div>
