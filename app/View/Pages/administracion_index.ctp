<?php
$this->set( 'title_for_layout', "Editor de paginas estaticas" );
?>
<div class="index">
	<h2>P&aacute;ginas est&aacute;ticas del sistema</h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
				<th>Nombre</th>
				<th class="actions">Acciones</th>
		</tr>
		<?php foreach ( $archivos as $archivo ):
				$archivo = str_replace( '.ctp', '', $archivo ) 
			?>
		<tr>
			<td><?php echo h( $archivo  ); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link( 'Ver', array( 'administracion' => false, 'action' => $archivo ), array( 'target' => '_blank' ) ); ?>
				<?php echo $this->Html->link( 'Editar', array( 'action' => 'edit', $archivo ) ); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>