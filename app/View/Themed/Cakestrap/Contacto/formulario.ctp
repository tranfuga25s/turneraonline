<?php
$this->set( 'title_for_layout', "Contactese con nosotros" );
?>
<div class="row-fluid">
	<div class="span12 well">
		<fieldset>
			<legend>Dirección de contacto</legend>
			Contactenos con nosotros a los siguientes telefonos:
		</fieldset>
		
		<ul class="thumbnails">
			<li class="span3 thumbnail">
				<?php echo $this->Html->image( 'cabecera.png' ); ?>
				<address>
					Vanesa Beatriz Apablaza<br />
					<div id="teljuampi" style="display: none;">(+54) 342 5134148  </div><a id="bteljuampi" href="#" onclick="$('#teljuampi').slideDown(); $('#bteljuampi').hide();">Ver Tel&eacute;fono</a><br />
					Santa Fe Capital - Argentina
				</address>
			</li>
			<li class="span3 thumbnail">
				<?php echo $this->Html->image( 'cabecera.png' ); ?>
				<address>
					Daniel Sequeira<br />
					<div id="teldani"   style="display: none;">(+54) 342 5128211  </div><a id="bteldani"   href="#" onclick="$('#teldani').slideDown(); $('#bteldani').hide();">Ver Tel&eacute;fono</a><br />
					Santa Fe Capital y alrededores - Argentina
				</address>
			</li>
			<li class="span3 thumbnail">
				<?php echo $this->Html->image( 'cabecera.png' ); ?>
				<address>
					Juan Pablo Vidocevich<br />
					<div id="teljuampi" style="display: none;">(+54) 342 5134148  </div><a id="bteljuampi" href="#" onclick="$('#teljuampi').slideDown(); $('#bteljuampi').hide();">Ver Tel&eacute;fono</a><br />
					Laguna Paiva y alrededores - Argentina
				</address>
			</li>
			<li class="span3 thumbnail">
				<?php echo $this->Html->image( 'cabecera.png' ); ?>
				<address>
					Esteban Javier Zeller<br />
					<div id="teleste"   style="display: none;">(+54) 342 154293436</div><a id="bteleste"   href="#" onclick="$('#teleste').slideDown(); $('#bteleste').hide();">Ver Tel&eacute;fono</a><br />
					Analista y Programador
				</address>
			</li>
		</ul>

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