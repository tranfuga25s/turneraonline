<?php
$this->set( 'title_for_layout', "Contactese con nosotros" );
?>
<script>
 $( function() { $("a","#telefonos").button(); });
</script>
<div class="decorado1">
	<div class="titulo2">Dirección de contacto</div>
	<div id="telefonos">
		Contactenos con nosotros a los siguientes telefonos:<br /><br />
		<table>
		 <tbody>
		  <tr>
		  	<td>Esteban Javier Zeller</td>
		  	<td>Daniel Sequeira</td>
		  	<td>Juan Pablo Vidocevich</td>
		  </tr>
		  <tr>
			<td><div id="teleste"   style="display: none;">(+54) 342 154293436</div><a id="bteleste"   href="#" onclick="$('#teleste').slideDown(); $('#bteleste').hide();">Ver Tel&eacute;fono</a></td>
			<td><div id="teldani"   style="display: none;">(+54) 342 5128211  </div><a id="bteldani"   href="#" onclick="$('#teldani').slideDown(); $('#bteldani').hide();">Ver Tel&eacute;fono</a></td>	
			<td><div id="teljuampi" style="display: none;">(+54) 342 5134148  </div><a id="bteljuampi" href="#" onclick="$('#teljuampi').slideDown(); $('#bteljuampi').hide();">Ver Tel&eacute;fono</a></td>
		  </tr>
		  <tr>
				<td>Santa Fe Capital - Argentina</td>
				<td>Santa Fe Capital y alrededores - Argentina</td>
			    <td>Laguna Paiva y alrededores - Argentina</td>
		  </tr>
		 </tbody>
		</table>
		</div>
	</div>
	<div class="titulo2">Contacto directo</div>
	<div>
		Utilice el siguiente formulario para enviarnos su consulta:
		<?php
			echo $this->Form->create( 'contacto', array( 'url' => '/contacto/enviar' ) );
			echo $this->Form->input( 'nombre', array( 'label' => "Su nombre" ) );
			echo $this->Form->input( 'email', array( 'label' => "Su e-mail" ) );
			echo $this->Form->input( 'texto', array( 'label' => "Texto del mensaje:", 'type' => 'textarea' ) );
			echo $this->Form->end( 'Enviar' );
		?>	
	</div>
</div>