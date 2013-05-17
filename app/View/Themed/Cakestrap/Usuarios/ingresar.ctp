<!-- Formulario de ingreso -->
<div class="row-fluid">
    <div class="span4 well well-small">
    <?php echo $this->Form->create( 'Usuario' ); ?>
    <fieldset>
        <legend class="text-center">Ingreso al sistema</legend>
        <div class="text-center">
        <?php echo $this->Form->input( 'email', array( 'label' => "Email:", 'type' => 'text' ) );
              echo $this->Form->input( 'contra', array( 'label' => "Contraseña:", 'type' => 'password' ) ); ?>
        <?php echo $this->Form->submit( 'Ingresar', array( 'div' => array( 'class' => 'form-actions' ), 'class' => 'btn btn-success' ) ); ?>
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
    </div>
    
    <div class="span3">
        <br /><br /><br /><br />
        <ul class="nav nav-tabs nav-stacked">
            <li><?php echo $this->Html->link( 'Olvide mi contraseña', array( 'controller' => 'Usuarios', 'action' => 'recuperarContra' ), array( 'class' => 'btn btn-info' ) ); ?></li>
            <li><?php echo $this->Html->link( 'Registrarme en el sitio', array( 'controller' => 'Usuarios', 'action' => 'registrarse' ), array( 'class' => 'btn btn-success' ) ); ?></li>
            <li><?php echo $this->Html->link( 'Eliminarme del sitio', array( 'controller' => 'Usuarios', 'action' => 'eliminarUsuario' ), array( 'class' => 'btn btn-danger') );  ?></li>
        </ul>   
    </div>
    
    <div class="span5 well">
        <h4>Referencia</h4>
        <div>
            <small>
            Para probar las posibilidades de las secretarias ingrese con:<br />
            <b>Usuario:</b>&nbsp; secretaria@turnera.com<br /><b>Contraseña:</b> secretaria.<br /><br />
            Para probar las posibilidades de los medicos ingrese con:<br />
            <b>Usuario:</b> medico@turnera.com<br /><b>Contraseña:</b> medico.<br /><br />
            Para probar las posibilidades de los pacientes ingrese con:<br />
            <b>Usuario:</b> paciente@turnera.com<br /><b>Contraseña:</b> paciente.<br /><br />
            </small>
        </div>
    </div>
</div>
