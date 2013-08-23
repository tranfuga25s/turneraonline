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
                <tr>
                    <td>Usuario de facebook:</td>
                    <td>
                        <?php if( isset( $facebook ) || !is_null( $usuario['Usuario']['facebook_id'] ) ) : ?>
                            <?php debug( $facebook ); ?>
                            Asociado con: <?php echo $this->Facebook->picture( $usuario['Usuario']['facebook_id'] ); ?>
                            <?php echo $this->Html->link( 'Quitar Asociacion', array( 'action' => 'desasociarFacebook', $usuario['Usuario']['id_usuario'] ), array( 'class' => 'btn btn-small btn-info' ) ); ?>
                        <?php else : ?>
                            No asociado a ningún perfil de facebook.
                            <?php echo $this->Html->link( 'Asociar a un perfil', array( 'action' => 'desasociarFacebook', $usuario['Usuario']['id_usuario'] ), array( 'class' => 'btn btn-small btn-info' ) ); ?>
                        <?php endif; ?>
                    </td>                                   
                </tr>
			
			</tbody>
		</table>

	</div>
	
</div>
