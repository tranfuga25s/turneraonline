<?php $this->set( 'title_for_layout', "Mis datos" ); ?>
<div class="row-fluid">
	
	<?php echo $this->element( 'menu/usuario', array( 'usuario' => $usuario ) ); ?>
	
	<div class="span10 well">
		<h3>Mis datos</h3>
		<table class="table table-hover table-condensed">
			<tbody>
				<tr>
					<td width="25%">Email</td>
					<td><?php echo h($usuario['Usuario']['email']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Nombre completo</td>
					<td><?php echo h($usuario['Usuario']['nombre']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Apellido</td>
					<td><?php echo h($usuario['Usuario']['apellido']); ?></td>
				</tr>
				<tr>
					<td>Sexo</td>
					<td><?php 
					if( $usuario['Usuario']['sexo'] == 'm' ) {
						echo "Masculino";
					} else {
						echo "Femenino";
					} ?>&nbsp;</td>
				</tr>
				<tr>
					<td>Télefono</td>
					<td><?php echo h($usuario['Usuario']['telefono']); ?></td>
				</tr>
				<tr>
					<td>Teléfono Celular</td>
					<td><?php echo h($usuario['Usuario']['celular']); ?></td>
				</tr>
				<tr>
					<td>Obra Social</td>
					<td>
					<?php
					if( $usuario['Usuario']['obra_social_id'] != null ) { 
						echo $this->Html->link( $usuario['ObraSocial']['nombre'], array( 'controller' => 'obras_sociales', 'action' => 'view', $usuario['ObraSocial']['id_obra_social'] ) );
					} else {
						echo "Ninguna";
					} ?>						
					</td>
				</tr>
				<tr>
					<td>Notificaciones</td>
					<td><?php if( $usuario['Usuario']['notificaciones'] ) { ?>
							<span class=" icon-ok-sign"></span>Habilitadas
						<?php  } else { ?>
							<span class="icon-ban-circle"></span>Deshabilitadas
						<?php  }  ?></td>
				</tr>
				
			</tbody>
		</table>

	</div>
	
</div>
