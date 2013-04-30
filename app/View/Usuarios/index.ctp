<?php  $this->set( 'title_for_layout', "Lista de pacientes" );  ?>
<script>

 function cambiaContra( email ) {
 	$("#cambiarcontra").dialog({
 		modal: true,
 		width: 500,
 		buttons: 
 		{
 			"Enviar": function() {
				$("#RecuperarEmail").val( email );
				$("#formcontra").submit();
				$(this).dialog('close');
 			},
 			"Cancelar": function() {
 				$(this).dialog('close');
 			}	
 		} 		
 	});	
 }
 
 $( function() { 
 	$("a", "#accion").button(); 
  });
</script>
<div id="accion">
	<?php echo $this->Html->link( 'Inicio'        , '/' ); ?>
	<?php echo $this->Html->link( 'Nuevo Paciente', array( 'action'     => 'add' ) ); ?>
	<?php echo $this->Html->link( 'Filtrar'       , '#', array( 'onclick' => '$("#dfiltro").slideDown();' ) ); ?>
	<?php echo $this->Html->link( 'Salir'         , array( 'controller' => 'usuarios'  , 'action' => 'salir'  ) ); ?>
</div>
<br />
<div class="decorado2" id="dfiltro" style="display: none;">
<?php  echo $this->Form->create( 'Usuario', array( 'action' => 'index' ) ); ?>
	<table>
		<tr>
			<td>Filtrar por:</td>
			<td><?php echo $this->Form->input( 'texto'      , array( 'div' => false, 'label' => false ) ); ?></td>
			<td><?php echo $this->Form->input( 'grupo_id'   , array( 'div' => false, 'label' => false, 'options' => $grupos,   'before' => 'y/o grupo:', 'empty' => 'Ninguno' ) ); ?></td>
			<td><?php echo $this->Form->input( 'obra_social', array( 'div' => false, 'label' => false, 'options' => $obrassociales,  'before' => 'y/o obra social:', 'empty' => 'Ninguno' ) ); ?></td> 
			<td><?php echo $this->Form->end  ( 'Filtrar'    , array( 'div' => false ) ); ?></td>
		</tr>
	</table>
</div>
<div class="decorado1">
	<div class="titulo1">Listado de pacientes</div>
<?php
if( isset( $texto ) ) {
	echo "<div style=\"text-align: left;\">Filtrando nombre y apellido que contentan <b>".$texto."</b></div><br />";
}
if( isset( $grupo_id ) ) {
	echo "<div style=\"text-align: left;\">Filtrando pacientes que pertenecen al grupo  <b>".$grupos[$grupo_id]."</b></div><br />";
}
if( isset( $obra_social ) ) {
	echo "<div style=\"text-align: left;\">Filtrando pacientes que tienen obra social  <b>".$obrassociales[$obra_social]."</b></div><br />";
}
?>
<div title="Cambiar Contraseña" id="cambiarcontra" style="display: none;">
	Al presiónar la opción de enviar, se le enviará una nueva contraseña de acceso al paciente.
	Este la recibirá en su email tal cual si el la ubiese solicitado por si mismo.
	<?php echo $this->Form->create( 'Recuperar', array( 'url' => '/usuarios/recuperarContra', 'id' => 'formcontra' ) );
		  echo $this->Form->input( 'email', array( 'type' => 'hidden', 'value' => '' ) );
		  echo $this->Form->end();
    ?>
</div>
<table cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<th><?php echo $this->Paginator->sort( 'razon_social' ); ?></th>
			<th><?php echo $this->Paginator->sort( 'grupo_id' ); ?></th>
			<th>Acciones</th>
		</tr>
<?php
$i = 0;
foreach ( $usuarios as $usuario ):
	echo "<tr>";
		echo "<td>".$usuario['Usuario']['razonsocial']."</td>";
		echo "<td>".$this->Html->link( h( $usuario['Grupo']['nombre'] ), array( 'controller' => 'grupos', 'action' => 'view', $usuario['Grupo']['id_grupo'] ) )."</td>";
		echo '<td class="actions">';
		echo $this->Html->link( 'Ver', array( 'action' => 'view', $usuario['Usuario']['id_usuario'] ) );
		echo $this->Html->link( 'Editar', array('action' => 'edit', $usuario['Usuario']['id_usuario'] ) );
		echo $this->Form->postLink(
			'Eliminar',
			array('action' => 'delete', $usuario['Usuario']['id_usuario']),
			null,
			'Se eliminaran TODOS los datos relacionados al paciente.\n Esta seguro que desea eliminar el item' . ' #' . $usuario['Usuario']['id_usuario']
		);
		echo $this->Html->tag( 'a', 'Camb contra', array( 'onclick' => 'cambiaContra( \''.$usuario['Usuario']['email'].'\' )' ) );
		//echo $this->Html->link( 'Turnos', array( 'controller' => 'turnos', 'action' => 'verPorMedico' ) );
		echo '</td>';
	echo '</tr>';

endforeach;

?>
 	</tbody>
</table>
	<p><?php
	echo $this->Paginator->counter(array(
		'format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?></p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev( '< anterior', array(), null, array( 'class' => 'prev disabled' ) );
		echo $this->Paginator->numbers( array( 'separator' => '' ) );
		echo $this->Paginator->next( 'siguiente >', array(), null, array( 'class' => 'next disabled' ) );
	?>
	</div>
</div>