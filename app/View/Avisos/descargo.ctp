<?php
$this->set( 'title_for_layout', "Licencia de Uso del sistema Waltook" );
?>
<h2>Habilitar servicio de avisos por mensaje de texto</h2>
Por favor, lea y acepte los siguientes términos y condiciones:<br /><br />
<fieldset>
    <legend><h2>Condiciones para el uso del servicio</h2></legend>
    bla bla bla
</fieldset>
<?php
echo $this->Form->create( 'habilitar', array( 'url' => Router::url( array( 'action' => 'habilitarSms' ) ) ) );
echo $this->Form->input( 'acepta', array( 'type' => 'checkbox', 'label' => 'Acepto las condiciones arriba mencionadas' ) );
echo $this->FOrm->submit( 'Habilitar' );
?>