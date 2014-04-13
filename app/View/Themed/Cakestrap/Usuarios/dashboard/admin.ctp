<?php
$this->set( 'title_for_layout', "Inicio" );
$this->element( 'avisos_sms' );
?>

<div class="row-fluid">
    <div class="span12">
        <h3>Panel de control</h3>
        <div class="row-fluid">
            <div class="span2 well">
                <?php echo $this->Html->link( 'Pacientes', array( 'action' => 'pacientes' ) ); ?>
            </div>
        </div>
    </div>
</div>
