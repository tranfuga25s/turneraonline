<!-- Pagina de despedida -->
<?php $this->set( 'title_for_layout', "Gracias por usar nuestro servicio!" ); ?>
<script>
	$(function() {
		$("a","#salida").button();
	});
</script>
<div class="decorado1" id="salida">
	<div class="titulo1">Hasta pronto!</div>
	Muchas gracias por utilizar nuestros servicios!
	<br />
	<br />
	<?php echo $this->Html->link( 'Volver al inicio', '/' ); ?>
</div>