<!-- Formulario de ingreso -->
<script>
	$( function() {
		$("a", "#botones").button();
	});
</script>
<?php echo $this->Form->create( 'Usuario' ); ?>
<div class="main">
	<label>Email:</label>
	<?php echo $this->Form->text( 'email' ); ?>
	<label>Contrase&ntilde;a:</label>
	<?php echo $this->Form->password( 'contra' ); ?>
	<?php echo $this->Form->end( array( 'label' => 'Ingresar', 'div' => false ) ); ?>
</div>
<div id="botones" style="text-align: center;">
	 &nbsp; &nbsp; &nbsp;
	<?php echo $this->Html->link( 'Olvide mi contraseña', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' ) ); ?>
	&nbsp;&nbsp;&nbsp;&nbsp; 
	<?php echo  $this->Html->link( 'Eliminarme del sitio', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' ) ); ?>
</div>	