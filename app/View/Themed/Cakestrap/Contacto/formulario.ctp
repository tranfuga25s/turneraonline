<?php
$this->set( 'title_for_layout', "Contactese con nosotros" );
?>
<div class="row-fluid">
	<div class="span9 well">
		<fieldset>
			<legend>Dirección de contacto</legend>

			<ul class="thumbnails">
				<li class="span3 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail', 'style' => 'width: 90%;'  ) ); ?>
					<address>
						Vanesa Apablaza<br />
						<a id="btelvane" href="#" onclick="$('#telvane').slideDown(); $('#btelvane').hide();">Ver Tel&eacute;fono</a>
						<span id="telvane" style="display: none;">(+549) 342 5134148 </span><br />
						Santa Fe Capital
					</address>
				</li>
				<li class="span3 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail', 'style' => 'width: 90%;'  ) ); ?>
					<address>
						Daniel Sequeira<br />
						<span id="teldani" style="display: none;">(+549) 342 5128211</span>
						<a id="bteldani"   href="#" onclick="$('#teldani').slideDown(); $('#bteldani').hide();">Ver Tel&eacute;fono</a><br />
						Santa Fe Capital y alrededores
					</address>
				</li>
				<li class="span3 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail', 'style' => 'width: 90%;'  ) ); ?>
					<address>
						Milton Martinazzo<br />
						<span id="teljuampi" style="display: none;">(+549) 11 55801850  </span>
						<a id="bteljuampi" href="#" onclick="$('#teljuampi').slideDown(); $('#bteljuampi').hide();">Ver Tel&eacute;fono</a><br />
						Buenos Aires
					</address>
				</li>
				<li class="span3 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail', 'style' => 'width: 90%;'  ) ); ?>
					<address>
						Esteban Zeller<br />
						<span id="teleste" style="display: none;">(+549) 342 154293436</span>
						<a id="bteleste" href="#" onclick="$('#teleste').slideDown(); $('#bteleste').hide();">Ver Tel&eacute;fono</a><br />
						Programador y Analista
					</address>
				</li>
			</ul>
		</fieldset>
	</div>

	<div class="span3 well">
	    <script type="text/javascript" src="http://v2.envialosimple.com/form/show/AdministratorID/31149/FormID/1/format/widget"></script>
	</div>
</div>

<div class="row-fluid">
	<div class="span5 pull-center">
		<?php echo $this->Form->create( 'contacto', array( 'url' => '/contacto/enviar' ) ); ?>
		<fieldset>
			<legend>Contacto directo</legend>
			<p>Utilice el siguiente formulario para enviarnos su consulta:</p>
			<?php
			echo $this->Form->input( 'nombre', array( 'label' => "Su nombre" ) );
			echo $this->Form->input( 'email', array( 'label' => "Su e-mail" ) );
			echo $this->Form->input( 'texto', array( 'label' => "Texto del mensaje:", 'type' => 'textarea' ) );
			echo $this->Form->end( array( 'label' => 'Enviar', 'div' => array( 'class' => 'form-actions' ), 'class' => 'btn btn-primary' ) ); ?>
		</fieldset>
	</div>

	<div class="span7">
		<h4>Recomendanos en facebook o ingresa tu comentario</h4>
		<?php echo $this->Facebook->recommendations(); ?>
		<?php echo $this->Facebook->comments(); ?>
	</div>
</div>