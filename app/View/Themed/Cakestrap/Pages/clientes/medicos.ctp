<?php $this->set( 'title_for_layout', "Sistema adecuado al médico" ); ?>
<div class="row-fluid">
	<div class="span12">
		<h3>Sistema de turnos para médico individual</h3>
		<p>Todo el sistema se encuentra preparado para que una sola persona sea capaz de administrarlo.<br />Sin necesidad de secretarias ni intermediarios. El m&eacute;dico administra y mantiene todas los turnos.</p>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<div class="well">
			<h4>Caraterísticas</h4>
			<table class="table table-condensed table-hover">
				<tbody>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td align="left">Todo es administrable por el único médico del sistema.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>Ventana de turnos auto-actualizable para el m&eacute;dico.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>P&aacute;gina personalizada como p&aacute;gina personal y de contacto.</td>
					</tr>
					<tr>
						<td width="20"><span class="icon-check">&nbsp;</span></td>
						<td>Mensaje de resumen diario por email.</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="well">
			<h4>Extras Opcionales</h4>
			<table class="table table-condensed table-hover">
				<tbody>
					<tr>
						<td><span class="icon-check">&nbsp;</span></td>
						<td>Aviso por mensaje de texto.
							<span class="pull-right"><?php echo $this->Html->link( 'Más información', array( 'controller' => 'pages', 'action' => 'display', 'extras','waltook' ), array( 'class' => 'btn btn-primary') ); ?></span>
						</td>
					</tr>
					<tr>
						<td><span class="icon-check">&nbsp;</span></td>
						<td>Integración con Facebook.
							<span class="pull-right"><?php echo $this->Html->link( 'Más información', array( 'controller' => 'pages', 'action' => 'display', 'extras','facebook' ), array( 'class' => 'btn btn-primary') ); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="span7 well">
		<h4>Precios</h4>
		<?php echo $this->element( 'precios', array( 'id_servicio' => Configure::read( 'Gestotux.id_servicio.medico' ), 'nombre' => "Médico" ) ); ?>
	</div>

</div>
<div class="row-fluid">

    <div class="span5 well">
        <?php echo $this->Facebook->like(); ?>
        <?php echo $this->Facebook->recommendations(); ?>
    </div>
    <div class="span7 well">
        <?php echo $this->Facebook->comments(); ?>
    </div>

</div>