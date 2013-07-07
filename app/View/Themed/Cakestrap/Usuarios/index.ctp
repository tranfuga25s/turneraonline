<?php
$this->set( 'title_for_layout', "Lista de pacientes" );

?>
<script>
 function cambiaContra( email ) {
    $("#RecuperarEmail").val( email );
 	$("#cambiarcontra").modal();
 }
</script>
<div class="row-fluid">

	<div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li><?php echo $this->Html->link( 'Inicio', '/' ); ?></li>
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
					<td><?php echo $this->Form->input( 'obra_social', array( 'div' => false, 'label' => false, 'options' => $obrassociales,  'before' => 'y/o obra social:', 'empty' => 'Ninguno' ) ); ?></td>
					<td><?php echo $this->Form->end  ( array( 'label' => 'Filtrar', 'div' => false, 'class' => 'btn btn-success' ) ); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="modal hide fade" id="cambiarcontra">
  <?php echo $this->Form->create( 'Recuperar', array( 'url' => '/usuarios/recuperarContra', 'id' => 'formcontra' ) ); ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Cambiar/Recuperar contraseña</h3>
  </div>
  <div class="modal-body">
    <p> Al presiónar la opción de enviar, se le enviará una nueva contraseña de acceso al paciente.<br />
        Este la recibirá en su email tal cual si el la ubiese solicitado por si mismo.
    </p>
    <?php echo $this->Form->input( 'email', array( 'type' => 'hidden', 'value' => '' ) ); ?>
  </div>
  <div class="modal-footer">
    <?php
    echo $this->Form->button( 'Cerrar', array( 'class' => 'btn btn-inverse', 'data-dismiss' => 'modal', 'aria-hidden' => "true" ) );
    echo $this->Form->button( $this->Html->tag( 'i', ' ', array( 'class' => 'icon-envelope' ) ).' Enviar', array( 'div' => false, 'class' => 'btn btn-primary', 'escape' => false ) ); ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>

<div class="row-fluid">
	<div class="span12">
		<h4>Listado de pacientes</h4>
		<?php
		if( isset( $texto ) ) {
			echo "<div style=\"text-align: left;\">Filtrando nombre y apellido que contentan <b>".$texto."</b></div><br />";
		}
		if( isset( $obra_social ) ) {
			echo "<div style=\"text-align: left;\">Filtrando pacientes que tienen obra social  <b>".$obrassociales[$obra_social]."</b></div><br />";
		}
		?>
		<table class="table table-hover table-bordered">
			<tbody>
				<th><?php echo $this->Paginator->sort( 'razon_social', 'Razon Social / Email' ); ?></th>
				<th><?php echo $this->Paginator->sort( 'obrasocial.nombre', 'Obra social' ); ?></th>
				<th>Telefonos</th>
				<th>Acciones</th>
				<?php foreach ( $usuarios as $usuario ) : ?>
				<tr>
					<td><?php echo h( $usuario['Usuario']['razonsocial'] ); ?><br />
                        <i class="icon-envelope"></i><?php echo $this->Html->link( $usuario['Usuario']['email'], 'mailto:'.$usuario['Usuario']['email']  ); ?>
                    </td>
					<td>
					    <?php echo $this->Html->link( h( $usuario['ObraSocial']['nombre'] ), array( 'controller' => 'obra_social', 'action' => 'view', $usuario['ObraSocial']['id_obra_social'] ) ); ?>
				    </td>
					<td>
					    <?php if( !empty( $usuario['Usuario']['telefono'] ) ) : ?>
					       <i class="icon-circle-arrow-right"></i><?php echo $usuario['Usuario']['telefono']; ?><br />
					    <?php elseif( !empty( $usuario['Usuario']['celular'] ) ) : ?>
					       <i class="icon-circle-arrow-right"></i><?php echo $usuario['Usuario']['celular']; ?>
					    <?php endif; ?>
					</td>
					<td class="actions">
						<?php
						echo $this->Html->link( '<i class=" icon-eye-open"></i> Ver', array( 'action' => 'view', $usuario['Usuario']['id_usuario'] ), array('class' => 'btn btn-mini', 'escape' => false ) );
						echo $this->Html->link( '<i class="icon-edit"></i> Editar', array('action' => 'edit', $usuario['Usuario']['id_usuario'] ), array('class' => 'btn btn-mini', 'escape' => false ) );
						echo $this->Form->postLink(	'<i class="icon-trash"></i> Eliminar',
													array('action' => 'delete', $usuario['Usuario']['id_usuario']),
													 array('class' => 'btn btn-mini', 'escape' => false ),
													'Se eliminaran TODOS los datos relacionados al paciente.\n Esta seguro que desea eliminar el item' . ' #' . $usuario['Usuario']['id_usuario']
						);
						echo $this->Html->tag( 'a', '<i class="icon-asterisk"></i> Camb contra', array( 'onclick' => 'cambiaContra( \''.$usuario['Usuario']['email'].'\' )', 'class' => 'btn btn-mini', 'escape' => false ) );
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
