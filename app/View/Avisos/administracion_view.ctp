<?php
$this->set( 'title_for_layout', "Ver aviso" );
?>
<div id="acciones">
	<?php echo $this->Html->link( 'Volver', array( 'action' => 'pendiente' ) ); ?>
</div>
<br />
<div class="index">
	<h2>Detalles de un aviso</h2>
	<dl>
		<dt>Identificador</dt>
		<dd>#<?php echo $aviso['Aviso']['id_aviso']; ?></dd>

		<dt>Fecha de envío:</dt>
		<dd><?php echo $this->Time->nice( $aviso['Aviso']['fecha_envio'] ); ?></dd>

		<dt>Tipo de aviso:</dt>
		<dd><?php echo $aviso['Aviso']['template']; ?></dd>

	</dl>
	<br />
	<fieldset>
	    <?php if( $aviso['Aviso']['metodo'] == 'email' ) : ?>
		<legend><h2>Email</h2></legend>
		<dl>
			<dt>Para:</dt>
			<dd><?php echo $aviso['Aviso']['para']['email']; ?></dd>

			<dt>De:</dt>
			<dd><?php echo $aviso['Aviso']['from']; ?></dd>

			<dt>Asunto:</dt>
			<dd><?php echo $aviso['Aviso']['subject']; ?></dd>

			<dt>Formato:</dt>
			<dd>
			    <?php if( $aviso['Aviso']['formato'] == 'both' ) : ?>
			    Texto y Html.
				<?php elseif ( $aviso['Aviso']['formato'] == 'text' ) : ?>
       			Texto.
		     	<?php else : ?>
			    Html.
				<?php endif; ?>
			</dd>
			<?php echo $this->requestAction( array( 'action' => 'renderizar_aviso', $aviso['Aviso']['id_aviso'], $aviso['Aviso']['metodo'] ) ); ?>
		</dl>
		<?php elseif( $aviso['Aviso']['metodo'] == 'sms' ) : ?>
    		<legend><h2>SMS</h2></legend>
            <dl>
                <dt>Número de teléfono:</dt>
                <dd><?php echo $aviso['Aviso']['to']; ?></dd>

            <?php echo $this->requestAction( array( 'action' => 'renderizar_aviso', $aviso['Aviso']['id_aviso'], $aviso['Aviso']['metodo'] ) ); ?>
            </dl>
		<?php endif; ?>
	</fieldset>
</div>
