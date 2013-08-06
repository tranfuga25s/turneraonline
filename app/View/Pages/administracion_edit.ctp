<?php
$this->set('title_for_layout', "Editar pagina estatica" );
echo $this->Html->script( 'ckeditor/ckeditor', array( 'inline' => false ) );

echo $this->Form->create( 'Page', array( 'id' => "formedit" ) );
echo $this->Form->input( 'content', array( 'type' => 'hidden', 'value' => $content ) );
echo $this->Form->input( 'nombre', array( 'type' => 'hidden', 'value' => $nombre ) );
echo $this->Form->input( 'content', array( 'class' => 'ckeditor', 'value' => $content, 'type' => 'textarea' ) ); 
echo $this->Form->button( 'Guardar', array( 'onclick' => 'actualizar()') );
echo $this->Form->end();
?>
<script>
	function actualizar() {
		$("#PageContent").val( $("#contenido").html() );
		
		$("#formedit").submit();
	}
</script>
<div contenteditable="true" id="contenido">
	<?php echo $content; ?>	
</div>
<hr />