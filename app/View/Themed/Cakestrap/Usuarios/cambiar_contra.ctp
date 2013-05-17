<?php $this->pageTitle = 'Cambiar mi contraseña'; ?>
<div class="row-fluid">
    <?php echo $this->element( 'menu/usuario' ); ?>

    <div class="span9 well">
        <?php echo $this->Form->create( 'Usuario' ); ?>
        <fieldset>
            <legend>Cambiar mi contraseña</legend>
            <?php echo $this->Form->input( 'id_usuario', array( 'type' => 'hidden', 'value' => $data['Usuario']['id_usuario'] ) ); ?>
            <?php echo $this->Form->input( 'contra', array( 'type' => 'password', 'label' => 'Contraseña Anterior:' ) ); ?>
            <?php echo $this->Form->input( 'nueva_pass', array( 'type' => 'password', 'label' => 'Nueva contraseña' ) ); ?>
            <?php echo $this->Form->input( 'nueva_pass_2', array( 'type' => 'password', 'label' => 'Confirmar nueva contraseña' ) ); ?>
        </fieldset>
        <?php echo $this->Form->end( array( 'label' => 'Cambiar', 'class' => 'btn btn-success', 'div' => array( 'class' => 'form-actions' ) ) ); ?>
    </div>
</div>