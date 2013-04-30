<!-- Formulario de ingreso -->
<script>
	$( function() {
		$( "a", "#inicios" ).button();
		$( "#referencia" ).accordion( { autoHeigth: false, active: false } );
	});
</script>
<center>
<div class="decorado1 inicio" id="inicio">
	<div class="titulo1">Formulario de ingreso al sistema</div>
	<table>
		<tbody>
			<tr>
				<td>
					<?php
					echo $this->Form->create( 'Usuario' );
					echo $this->Form->text( 'email', array( 'label' => "Email:" ) )."<br />";
					echo $this->Form->password( 'contra', array( 'label' => "Contraseña:" ) );
					echo $this->Form->end( 'Ingresar' );
					?>
				</td>
				<td id="inicios">
					<?php
					echo $this->Html->link( 'Olvide mi contraseña', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' ) );
					echo "<br />";
					echo $this->Html->link( 'Registrarme en el sitio', array( 'controller' => 'Usuarios', 'action' => 'registrarse' ) );
					echo "<br />";
					echo $this->Html->link( 'Eliminarme del sitio', array( 'controller' => 'Usuarios', 'action' => 'eliminarUsuario' ) );
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2" id="referencia">
					<h3><a href="#">Referencia</a></h3>
					<div>
						<small>
						Para probar las posibilidades de las secretarias ingrese con:<br />
						<b>Usuario:</b>&nbsp; secretaria@turnera.com<br /><b>Contraseña:</b> secretaria.<br /><br />
						Para probar las posibilidades de los medicos ingrese con:<br />
						<b>Usuario:</b> medico@turnera.com<br /><b>Contraseña:</b> medico.<br /><br />
						Para probar las posibilidades de los pacientes ingrese con:<br />
						<b>Usuario:</b> paciente@turnera.com<br /><b>Contraseña:</b> paciente.<br /><br />
						</small>
					</div>
					</small>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</center>