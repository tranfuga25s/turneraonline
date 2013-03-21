<?php $this->set( 'title_for_layout', "Datos de usuario" ); ?>
<div id="acciones">
		<?php echo $this->Html->link( 'Editar Usuario', array( 'action' => 'edit', $usuario['Usuario']['id_usuario'] ) );
		      echo $this->Form->postLink( 'Eliminar Usuario', array('action' => 'delete', $usuario['Usuario']['id_usuario']), null, __('Are you sure you want to delete # %s?', $usuario['Usuario']['id_usuario']));
		      echo $this->Html->link( 'Lista de Usuarios', array('action' => 'index'));
		      echo $this->Html->link( 'Nuevo Usuario', array('action' => 'add'));
		      echo $this->Html->link( 'Lista de Obras Sociales', array('controller' => 'obras_sociales', 'action' => 'index' ) ); ?>
</div>
<br />
<h2> Datos del Usuario </h2>
<dl>
	<dt>Email</dt>
	<dd>
		<?php echo $this->Html->link( h($usuario['Usuario']['email']), 'mailto:'.$usuario['Usuario']['email'] ); ?>
		&nbsp;
	</dd>
	<dt>Nombre</dt>
	<dd>
		<?php echo h($usuario['Usuario']['nombre']); ?>
		&nbsp;
	</dd>
	<dt>Apellido</dt>
	<dd>
		<?php echo h($usuario['Usuario']['apellido']); ?>
		&nbsp;
	</dd>
	<dt>Sexo</dt>
	<dd>
		<?php 
		if( $usuario['Usuario']['sexo'] == 'm' ) {
			echo "Masculino";
		} else {
			echo "Femenino";
		} ?>
		&nbsp;
	</dd>
	<dt>Tel&eacute;fono</dt>
	<dd>
		<?php echo h($usuario['Usuario']['telefono']); ?>
		&nbsp;
	</dd>
	<dt>Tel&eacute;fono Celular</dt>
	<dd>
		<?php echo h($usuario['Usuario']['celular']); ?>
		&nbsp;
	</dd>
	<dt>Obra Social</dt>
	<dd>
		<?php echo $this->Html->link($usuario['ObraSocial']['nombre'], array('controller' => 'obra_socials', 'action' => 'view', $usuario['ObraSocial']['id_obra_social'])); ?>
		&nbsp;
	</dd>
	<dt>Notificaciones</dt>
	<dd>
		<?php if( $usuario['Usuario']['notificaciones'] ) { ?>
			Si
		<?php } else { ?>
			No
		<?php } ?> 
		&nbsp;
	</dd>
	<dt>Grupo</dt>
	<dd>
		<?php echo $this->Html->link($usuario['Grupo']['nombre'], array('controller' => 'grupos', 'action' => 'view', $usuario['Grupo']['id_grupo'])); ?>
		&nbsp;
	</dd>
</dl>