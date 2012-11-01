<?php $this->set( 'title_for_layout', "Datos de la obra social" ); ?>
<script>
 $( function() {
	$("a","#botones").button();
 });
</script>
<div id="botones">
	<?php echo $this->Html->link( 'Inicio', '/' );
		  echo $this->Html->link( 'Listado de Obras Sociales', array( 'action' => 'index' ) );
		  echo $this->Html->link( 'Nuevo turno', array( 'controller' => 'turnos', 'action' => 'nuevo' ) );
		  echo $this->Html->link( 'Mis datos', array( 'controller' => 'usuarios', 'action' => 'view' ) ); 
		  echo $this->Html->link( 'Salir', array( 'controller' => 'usuarios', 'action' => 'salir' ) ); ?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1">Datos de la obra social</div>
	<dl>
		<dt>Razon Social</dt>
		<dd>
			<?php echo h($obrasSociale['ObraSocial']['nombre']); ?>
			&nbsp;
		</dd>
		<dt>Direccion</dt>
		<dd>
			<?php echo h($obrasSociale['ObraSocial']['direccion']); ?>
			&nbsp;
		</dd>
		<dt>Telefono</dt>
		<dd>
			<?php echo h($obrasSociale['ObraSocial']['telefono']); ?>
			&nbsp;
		</dd>
	</dl>
</div>