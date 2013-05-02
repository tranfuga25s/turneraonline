<?php
$this->set( 'title_for_layout', "Notificaciones pendientes" );
?>
<div id="acciones">
	<?php echo $this->Html->link( 'Volver', array( 'action' => 'cpanel' ) ); ?>
</div>
<br />
<div class="index">
	<h2>Notificaciones pendientes de envío</h2>
	<p>Este listado es al momento de su carga. Las notificaciones se verifican cada segundo.</p>
	<table>
		<tbody>
			<th>#Aviso</th>
			<th>Tipo</th>
			<th>Fecha/Hora envio</th>
			<th>Acciones</th>
		<?php foreach( $pendientes as $pendiente ) : ?>
			<tr>
				<td>#<?php echo $pendiente['Aviso']['id_aviso']; ?></td>
				<td><?php echo $pendiente['Aviso']['template']; ?></td>
				<td><?php echo $this->Time->nice( $pendiente['Aviso']['fecha_envio'] ); ?></td>
				<td class="acciones">
					<?php echo $this->Html->link( 'Ver', array( 'action' => 'view', $pendiente['Aviso']['id_aviso'] ) ); ?>
					<?php echo $this->Html->link( 'Cancelar', array( 'action' => 'cancelar', $pendiente['Aviso']['id_aviso'] ) ); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<br />
	<h2>Notificaciones vencidas</h2>
	<p>Este listado es las notificaciones que no se enviaron por alguna razón.</p>
	<table>
		<tbody>
			<th>#Aviso</th>
			<th>Tipo</th>
			<th>Fecha/Hora envio</th>
			<th>Acciones</th>
		<?php foreach( $vencidas as $pendiente ) : ?>
			<tr>
				<td>#<?php echo $pendiente['Aviso']['id_aviso']; ?></td>
				<td><?php echo $pendiente['Aviso']['template']; ?></td>
				<td><?php echo $this->Time->nice( $pendiente['Aviso']['fecha_envio'] ); ?></td>
				<td class="acciones">
					<?php echo $this->Html->link( 'Ver', array( 'action' => 'view', $pendiente['Aviso']['id_aviso'] ) ); ?>
					<?php echo $this->Html->link( 'Cancelar', array( 'action' => 'cancelar', $pendiente['Aviso']['id_aviso'] ) ); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
<script>
	$("a",".acciones").button();
</script>