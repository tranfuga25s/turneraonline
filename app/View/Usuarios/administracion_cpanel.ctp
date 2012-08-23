<!-- Panel de administración -->
<?php $this->set( 'title_for_layout', 'Panel de control' ); ?>
<div class="titulo1"> Panel de Administración </div>
<div class="decorado1">
 <table>
  <tbody>
   <tr>
	<td colspan="3"><div class="titulo2">Datos</div></td>
   </tr>
   <tr>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Clinicas', '/administracion/clinicas/index' ); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Especialidades', '/administracion/especialidades/index' ); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Consultorios', '/administracion/consultorios/index' ); ?></li></ul>
    </td>
   </tr>
   <tr>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Medicos', '/administracion/medicos/index' ); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Secretarias', '/administracion/secretarias/index' ); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Obras Sociales', '/administracion/obras_sociales/index' ); ?></li></ul>
    </td>
   </tr>
   <tr>
    <td class="actions"></td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Turnos', '/administracion/turnos/index' ); ?></li></ul>
    </td>
    <td class="actions"></td>
   </tr>
   <tr>
	<td colspan="3"><div class="titulo2">Sistema</div></td>
   </tr>
   <tr>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Usuarios', '/administracion/usuarios/index'); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Grupos', '/administracion/grupos/index' ); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Permisos', '#' ); ?></li></ul>
    </td>
   </tr>
   <tr>
	<td colspan="3"><div class="titulo2">Configuraci&oacute;n</div></td>
   </tr>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Notificaciones', '#' ); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Configuracion', '/administracion/configuracion/ver' ); ?></li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Ver sitio', '/', array( 'target' => '_blank' ) ); ?></li></ul>
    </td>
   </tr>
   <tr>
    <td class="actions">
	<ul><li><?php //echo $this->Html->link( 'Notificaciones', '/' ); ?>&nbsp;</li></ul>
    </td>
    <td class="actions">
	<ul><li><?php echo $this->Html->link( 'Salir', '/administracion/usuarios/salir' ); ?></li></ul>
    </td>
   </tr>
  </tbody>
 </table>
</div>