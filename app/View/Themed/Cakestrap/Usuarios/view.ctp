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
					<td rowspan="4">Notificaciones</td>
                    <td><?php if( $usuario['Usuario']['notificaciones'] ) { ?>
							<span class="label label-success"><i class=" icon-ok-sign"></i> Habilitadas</span>
						<?php  } else { ?>
							<span class="label label-warning"><i class="icon-ban-circle"></i> Deshabilitadas</span>
						<?php  }  ?>
				    </td>
				</tr>
				<tr>
				    <td>Correo electrónico:
				    <?php if( !is_null( $usuario['Usuario']['email'] ) ) : ?>
				        <span class="label label-success"><i class=" icon-ok-sign"></i> Habilitadas</span>
				    <?php else : ?>
				        <span class="label label-warning"><i class="icon-ban-circle"></i> Deshabilitadas</span>
				    <?php endif; ?>
				    </td>
                </tr>
				<tr>
				    <td>Mensaje por SMS:
				    <?php if( $usuario['Usuario']['celular'] != '' ) : ?>
                        <span class="label label-success"><i class=" icon-ok-sign"></i> Habilitadas</span>
                    <?php else : ?>
                        <span class="label label-warning"><i class="icon-ban-circle"></i> Deshabilitadas</span><br /><small class="text-info"> Ingrese un numero de celular para que pueda recibir estas notificaciones.</small>
                    <?php endif; ?>
				    </td>
				</tr>
				<tr>
				    <td>Mensaje de Facebook:
				    <?php if( !is_null( $usuario['Usuario']['facebook_id'] ) ) : ?>
                        <span class="label label-success"><i class=" icon-ok-sign"></i> Habilitadas</span>
                    <?php else : ?>
                        <span class="label label-warning"><i class="icon-ban-circle"></i> Deshabilitadas</span><br /><small class="text-info"> Asociese con una cuenta de facebook para recibir mensajes de facebook.</small>
                    <?php endif; ?>
				    </td>
				</tr>
                <tr>
                    <td>Usuario de facebook:</td>
                    <td>
                        <?php if( isset( $facebook ) || !is_null( $usuario['Usuario']['facebook_id'] ) ) : ?>
                            <?php //debug( $facebook ); ?>
                            <div class="thumbnail span3 text-center">
                                <?php echo $this->Facebook->picture( $usuario['Usuario']['facebook_id'] ); ?>
                                <?php echo $this->Html->link( 'Quitar Asociacion', array( 'action' => 'desasociarFacebook', $usuario['Usuario']['id_usuario'] ), array( 'class' => 'btn btn-small btn-info' ) ); ?>
                            </div>
                        <?php else : ?>
                            No asociado a ningún perfil de facebook.
                            <?php echo $this->Facebook->login( array( 'perms' => 'email,read_mailbox' ) ); ?>
                        <?php endif; ?>
                    </td>
                </tr>

			</tbody>
		</table>

	</div>

</div>
