<?php
$this->set( 'title_for_layout', "Licencia de Uso del sistema Waltook" );
?>
<h2>Habilitar servicio de avisos por mensaje de texto</h2>
Por favor, lea y acepte los siguientes términos y condiciones:<br /><br />
<fieldset>
    <legend><h2>Condiciones para el uso del servicio</h2></legend>
    Por favor, tenga en cuenta que las condiciones de uso son las siguientes respecto al servicio utilizado:
    <?php echo $this->Html->link( 'Condiciones y Terminos', 'http://www.waltook.com/terminos' ); ?><br />
    <br />
    <p>La integración del servicio de este sistema con el sistema de waltook se encuentra</p>
</fieldset>
<?php echo $this->Form->create( 'habilitar', array( 'url' => Router::url( array( 'action' => 'habilitar_sms' ) ) ) ); ?>
<fieldset>
    <legend>Configurar Servicio</legend>
    <p>Por favor, ingrese los datos que le provee el servicio waltook desde el panel de control en la sección de API a continuación:</p>
    <?php
    echo $this->Form->input( 'id_cliente', array( 'type' => 'text', 'label' => 'Número de cliente Waltook' ) );
    echo $this->Form->input( 'key', array( 'type' => 'text', 'label' => 'Clave de encriptación' ) );
    echo $this->Form->input( 'codigo', array( 'type' => 'text', 'label' => 'Código de identificacion' ) );
    echo $this->Form->input( 'acepta', array( 'type' => 'checkbox', 'label' => 'Acepto las condiciones arriba mencionadas' ) );
    echo $this->Form->submit( 'Habilitar' );
    ?>    
</fieldset>
