<?php
$this->set( 'title_for_layout', "Contactese con nosotros" );
?>
<div class="row-fluid">
	<div class="span12 well">
		<fieldset>
			<legend>Dirección de contacto</legend>
		
			<ul class="thumbnails">
				<li class="span2 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail' ) ); ?>
					<address>
						Vanesa Apablaza<br />
						<a id="btelvane" href="#" onclick="$('#telvane').slideDown(); $('#btelvane').hide();">Ver Tel&eacute;fono</a>
						<span id="telvane" style="display: none;">(+54) 342 5134148 </span><br />
						Santa Fe Capital
					</address>
				</li>
				<li class="span2 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail' ) ); ?>
					<address>
						Daniel Sequeira<br />
						<span id="teldani" style="display: none;">(+54) 342 5128211</span>
						<a id="bteldani"   href="#" onclick="$('#teldani').slideDown(); $('#bteldani').hide();">Ver Tel&eacute;fono</a><br />
						Santa Fe Capital y alrededores
					</address>
				</li>
				<li class="span2 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail' ) ); ?>
					<address>
						Juan Pablo Vidocevich<br />
						<span id="teljuampi" style="display: none;">(+54) 342 5134148  </span>
						<a id="bteljuampi" href="#" onclick="$('#teljuampi').slideDown(); $('#bteljuampi').hide();">Ver Tel&eacute;fono</a><br />
						Laguna Paiva y alrededores
					</address>
				</li>
				<li class="span2 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail' ) ); ?>
					<address>
						Fernando Liernur<br />
						<span id="telfer" style="display: none;">(+54) 342 154293436</span>
						<a id="btelfer" href="#" onclick="$('#telfer').slideDown(); $('#btelfer').hide();">Ver Tel&eacute;fono</a><br />
						Rosario - Santa Fe
					</address>
				</li>
				<li class="span2 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail' ) ); ?>
					<address>
						Melisa Fontanessi<br />
						<span id="telmeli" style="display: none;">(+54) 342 154293436</span>
						<a id="btelmeli" href="#" onclick="$('#telmeli').slideDown(); $('#btelmeli').hide();">Ver Tel&eacute;fono</a><br />
						Rosario - Santa Fe
					</address>
				</li>
				<li class="span2 thumbnail text-center">
					<?php echo $this->Html->image( "perfil-generico.jpg", array( 'class' => 'thumbnail' ) ); ?>
					<address>
						Esteban Zeller<br />
						<span id="teleste" style="display: none;">(+54) 342 154293436</span>
						<a id="bteleste" href="#" onclick="$('#teleste').slideDown(); $('#bteleste').hide();">Ver Tel&eacute;fono</a><br />
						Programador y Analista
					</address>
				</li>
			</ul>
		</fieldset>
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