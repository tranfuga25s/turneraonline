<?php
$this->set( 'title_for_layout', "Configuración de envio de sms" );

?>
<div id="acciones">
    <?php echo $this->Html->link( 'Volver', array( 'action' => 'cpanel' ) ); ?>
</div>
<br />
<?php echo $this->Form->create( 'Formato' ); ?>
<fieldset>
    <legend><h2>Formato de mensajes</h2></legend>
    <?php echo $this->Form->input( 'desde', array( 'type' => 'text' ) ); ?>
    <?php echo $this->Form->input( 'texto', array( 'type' => 'textarea', 'between' => '<p>Reemplace el nombre del paciente con [{nombre}]</p>' ) ); ?>
</fieldset>
<?php echo $this->Form->end(); ?>

<fieldset>
    <legend><h2>Estado de mensajes</h2></legend>
    <label>Cantidad enviada: </label> NNNN mensajes<br />
    <label>Costo acumulado: </label> $ NNN AR<br />
</fieldset>
