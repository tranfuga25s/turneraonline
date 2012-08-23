<!-- Formulario de ingreso -->
<script>
	$( function() {
		$("a", "#botones").button();
	});
</script>
<br />
<div class="decorado1">
	<div class="titulo1">Formulario de ingreso al sistema</div>
	<br />
	<?php echo $this->Form->create( 'Usuario' ); ?>
	<center>
	<table width="50%" align="center">
	 <tbody>
	  <tr>
	   <td>Email:</td>
	   <td><?php echo $this->Form->text( 'email' ); ?></td>
	  </tr>
	  <tr>
	   <td>Contrase&ntilde;a:</td>
	   <td><?php echo $this->Form->password( 'contra' ); ?> </td>
	  </tr>
	  <tr>
	   <td colspan="2"><?php echo $this->Form->end( 'Ingresar' ); ?></td>
	  </tr>
	 </tbody>
	</table>
	<div id="botones">
	    <?php echo $this->Html->link( 'Olvide mi contraseña', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' ) ); ?>
	    &nbsp;&nbsp;&nbsp;&nbsp 
	    <?php echo  $this->Html->link( 'Eliminarme del sitio', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' ) ); ?>
	</div>
	</center>
</div>