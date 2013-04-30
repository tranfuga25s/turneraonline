<!-- Formulario de recuperación de contraseña -->
<?php $this->set( 'title_for_layout', "Recuperar mi contraseña" ); ?>
<script>$(function(){$("#dialogo").alert();});</script>
<dic class="row-fluid">
	<div class="span7 well">
		<?php echo $this->Form->create( 'Recuperar' ); ?>
		<fieldset>
			<legend>Recuperar mi contrase&ntilde;a</legend>
			<label>Direcci&oacute;n de correo electr&oacute;nico</label>
			<?php echo $this->Form->email( 'email' ); ?>
		</fieldset>
		<?php echo $this->Form->end( array( 'class' => 'btn btn-success', 'label' => 'Pedir nueva contraseña', 'div' => array( 'class' => 'form-actions' ) ) ); ?>
	</div>

	<div id="dialogo" class="alert fade in out span5">
		<?php echo $this->Html->tag( 'a', '&times;', array( 'class' => 'close', 'data-dismiss' => 'alert') ); ?>
		<center>
			Si usted ya reserv&oacute; alg&uacute;n turno anteriormente a travez de nuestra secretaria, su cuenta ya fue dada de alta.<br />
			Por ejemplo, Si su nombre y apellido son Juan Martinez, deber&aacute; ingresar con:<br />
			<i>juanmartinez@<?php echo $dominio; ?></i><br /> Su contrase&ntilde;a ser&aacute;:<br />
			<i>juanmartinez</i><br />
			<?php echo $this->Html->link( 'Intentar esta opción', '/', array( 'class' => 'btn' ) ); ?>
				
		</center>
	</div>
</div>