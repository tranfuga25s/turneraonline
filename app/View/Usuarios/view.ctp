<?php $this->set( 'title_for_layout', "Mis datos" ); ?>
<div class="usuarios view">
<h2>Mis datos</h2>
	<dl>
		<dt>Email</dt>
		<dd>
			<?php echo h($usuario['Usuario']['email']); ?>
			&nbsp;
		</dd>
		<dt>Nombre completo</dt>
		<dd>
			<?php echo h($usuario['Usuario']['nombre']); ?>
			&nbsp;
		</dd>
		<dt>Apellido</dt>
		<dd>
			<?php echo h($usuario['Usuario']['apellido']); ?>
			&nbsp;
		</dd>
		<dt>Telefono</dt>
		<dd>
			<?php echo h($usuario['Usuario']['telefono']); ?>
			&nbsp;
		</dd>
		<dt>Telefono Celular</dt>
		<dd>
			<?php echo h($usuario['Usuario']['celular']); ?>
			&nbsp;
		</dd>
		<dt>Obra Social</dt>
		<dd>
			<?php
			if( $usuario['Usuario']['obra_social_id'] != null ) { 
				echo $this->Html->link( $usuario['ObraSocial']['nombre'], array( 'controller' => 'obras_sociales', 'action' => 'view', $usuario['ObraSocial']['id_obra_social'] ) );
			} else {
				echo "Ninguna";
			} ?>
			&nbsp;
		</dd>
		<dt>Notificaciones</dt>
		<dd>
			<?php if( $usuario['Usuario']['notificaciones'] ) { ?>
				Habilitadas
			<?php  } else { ?>
				Deshabilitadas
			<?php  }  ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3>Acciones</h3>
	<ul>
		<li><?php echo $this->Html->link( 'Editar mis datos', array('action' => 'edit', $usuario['Usuario']['id_usuario'])); ?> </li>
		<li><?php echo $this->Html->link( 'Cambiar contraseña', array('action' => 'cambiaContra', $usuario['Usuario']['id_usuario'])); ?> </li>
		<li><?php echo $this->Html->link( 'Ver Obras sociales', array('controller' => 'obras_sociales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link( 'Pedir turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) ); ?></li>
		<li><?php echo $this->Html->link( 'Ver mis turnos', array( 'controller' => 'turnos', 'action' => 'verTurnos', $usuario['Usuario']['id_usuario'] ) ); ?></li>
		<li><?php echo $this->Html->link( 'Salir', array( 'action' => 'salir' ) ); ?></li>
	</ul>
</div>
