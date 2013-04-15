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
<div class="row-fluid">
	
	<div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
				<li class="active"><?php echo $this->Html->link( 'Pacientes', array( 'controller' => 'usuarios', 'action' => 'index' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Nuevo Paciente', array( 'action'     => 'add' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Filtrar'       , '#', array( 'onclick' => '$("#dfiltro").slideDown();' ) ); ?></li>
				<li><?php echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?></li> 
			</ul>
		</div>	
	</div>
</div>

<div class="row-fluid">
	<div class="span12 well" id="dfiltro" style="display: none;">
		<?php echo $this->Form->create( 'Usuario', array( 'action' => 'index', 'class' => 'form-inline' ) ); ?>
		<table>
			<tbody>
				<tr>
					<td>Filtrar por:</td>
					<td><?php echo $this->Form->input( 'texto'      , array( 'div' => false, 'label' => false, 'placeholder' => 'Texto a buscar' ) ); ?></td>
					<td><?php echo $this->Form->input( 'grupo_id'   , array( 'div' => false, 'label' => false, 'options' => $grupos,   'before' => 'y/o grupo:', 'empty' => 'Ninguno' ) ); ?></td>
					<td><?php echo $this->Form->input( 'obra_social', array( 'div' => false, 'label' => false, 'options' => $obrassociales,  'before' => 'y/o obra social:', 'empty' => 'Ninguno' ) ); ?></td> 
					<td><?php echo $this->Form->end  ( array( 'label' => 'Filtrar', 'div' => false, 'class' => 'btn btn-success' ) ); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div title="Cambiar Contraseña" id="cambiarcontra" style="display: none;">
	Al presiónar la opción de enviar, se le enviará una nueva contraseña de acceso al paciente.
	Este la recibirá en su email tal cual si el la ubiese solicitado por si mismo.
	<?php echo $this->Form->create( 'Recuperar', array( 'url' => '/usuarios/recuperarContra', 'id' => 'formcontra' ) );
		  echo $this->Form->input( 'email', array( 'type' => 'hidden', 'value' => '' ) );
		  echo $this->Form->end();
    ?>
</div>
<div class="row-fluid">
	<div class="span12">
		<h4>Listado de pacientes</h4>
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
		<table class="table table-hover table-bordered">
			<tbody>
				<th><?php echo $this->Paginator->sort( 'razon_social' ); ?></th>
				<th><?php echo $this->Paginator->sort( 'grupo_id' ); ?></th>
				<th>Acciones</th>
				<?php foreach ( $usuarios as $usuario ) : ?>
				<tr>
					<td><?php echo h( $usuario['Usuario']['razonsocial'] ); ?></td>
					<td><?php echo $this->Html->link( h( $usuario['Grupo']['nombre'] ), array( 'controller' => 'grupo', 'action' => 'view', $usuario['Grupo']['id_grupo'] ) ); ?></td>
					<td class="actions">
						<?php
						echo $this->Html->link( 'Ver', array( 'action' => 'view', $usuario['Usuario']['id_usuario'] ), array('class' => 'btn btn-mini') );
						echo $this->Html->link( 'Editar', array('action' => 'edit', $usuario['Usuario']['id_usuario'] ), array('class' => 'btn btn-mini') );
						echo $this->Form->postLink(	'Eliminar',
													array('action' => 'delete', $usuario['Usuario']['id_usuario']),
													 array('class' => 'btn btn-mini'),
													'Se eliminaran TODOS los datos relacionados al paciente.\n Esta seguro que desea eliminar el item' . ' #' . $usuario['Usuario']['id_usuario']
						);
						echo $this->Html->tag( 'a', 'Camb contra', array( 'onclick' => 'cambiaContra( \''.$usuario['Usuario']['email'].'\' )', 'class' => 'btn btn-mini' ) );
						//echo $this->Html->link( 'Turnos', array( 'controller' => 'turnos', 'action' => 'verPorMedico' ), array('class' => 'btn btn-mini') );
						?>
					</td>
				</tr>					
				<?php endforeach; ?>				
			</tbody>
		</table>
		<p><small><?php echo $this->Paginator->counter(array('format' => 'Pagina {:page} de {:pages}, mostrando {:current} de {:count}, desde {:start} al {:end}')); ?></small></p>
		<div class="pagination">
			<ul>
			<?php
				echo $this->Paginator->prev( '< anterior', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
				echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
				echo $this->Paginator->next( 'siguiente >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
			?>
			</ul>
		</div>
	</div>
</div>
