<?php
$this->set( 'title_for_layout', "Darse de baja" );
?>
<div class="row-fluid">

    <div id="dialogo" class="alert fade in out">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <b>ATENCION:</b> Este proceso es irreversible!
        Esta acción eliminará todos los datos personales y reservas a futuro y pasado que el usuario tenga asociado!
    </div>

    <div class="span5 offset2">
        <?php echo $this->Form->create( 'Usuario', array( 'action' => 'eliminarUsuario' ) ); ?>
        <legend class="text-center">Darse de baja del sistema</legend>
        <p>Por favor ingrese la casilla de correo con que se dió de alta al sistema para dar de baja el usuario asociado.</p>
        <div class="text-center">
            <?php
            echo $this->Form->input( 'email', array( 'label' => 'Correo electronico' ) );
            echo $this->Form->input( 'razon', array( 'type' => 'text', 'label' => 'Si desea, especifique la razón de su decisión' ) );
            ?>            
        </div>
        <?php echo $this->Form->submit( 'Darme de baja', array( 'div' => array( 'class' => 'form-actions text-center' ), 'class' => 'btn btn-danger' ) ); ?>
        <?php echo $this->Form->end(); ?>
    </div>
    

   
</div>
		