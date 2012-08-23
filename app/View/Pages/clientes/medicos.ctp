<?php
$this->set( 'title_for_layout', "Sistema adecuado al médico" );
?>
<style>
.flotatipo {
	float: left;
	border: 1px solid rgba(0, 0, 0, 0.2);
	width: 350px;
	min-height: 150px;
	margin: 2px;
	-ms-border-radius: 4px;
	border-radius: 4px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	text-align: center;b
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
	-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.50);
}
</style>
<div class="decorado1">
	<div class="titulo1">Sistema de turnos para médico individual</div>
	<div class="flotatipo"><?php echo $this->Html->image( 'cabecera.png' ); ?>M&eacute;dicos</div>
	Todo el sistema se encuentra preparado para que una sola persona sea capaz de administrarlo.<br /><br />
	Sin necesidad de secretarias ni intermediarios. El m&eacute;dico administra y mantiene todas los turnos.<br />
	<br />
	<div class="titulo2">Características</div>
	<table>
		<tbody>
			<tr>
				<td width="20"><div class="ui-icon ui-icon-check">&nbsp;</div></td>
				<td align="left">Todo es administrable por el único médico del sistema.</td>
			</tr>
			<tr>
				<td width="20"><div class="ui-icon ui-icon-check">&nbsp;</div></td>
				<td>Ventana de turnos auto-actualizable para el m&eacute;dico.</td>
			</tr>
			<tr>
				<td width="20"><div class="ui-icon ui-icon-check">&nbsp;</div></td>
				<td>P&aacute;gina personalizada como p&aacute;gina personal y de contacto.</td>
			</tr>
			<tr>
				<td width="20"><div class="ui-icon ui-icon-check">&nbsp;</div></td>
				<td>Mensaje de resumen diario por email.</td>
			</tr>
		</tbody>
	</table>
</div>