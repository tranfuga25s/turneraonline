<?php
$this->set( 'title_for_layout', "Visor de registro de sistema" );
?>
<h2>Listado de acciones registradas en el sistema</h2>
<table cellpadding="0" cellspacing="0">
<tr>
        <th><?php echo $this->Paginator->sort('event');?></th>
        <th><?php echo $this->Paginator->sort('model');?></th>
        <th><?php echo $this->Paginator->sort('entity_id');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th class="actions">Acciones</th>
</tr>
<?php
$i = 0;
foreach ( $auditorias as $auditoria ): ?>
<tr>
    <td><?php echo h($auditoria['Audits']['event']); ?>&nbsp;</td>
    <td><?php echo h($auditoria['Audits']['model']); ?>&nbsp;</td>
    <td><?php echo h($auditoria['Audits']['entity_id']); ?>&nbsp;</td>
    <td><?php echo h($auditoria['Audits']['created']); ?>&nbsp;</td>
    <td class="actions">
        <?php echo $this->Html->link( 'Ver', array( 'action' => 'view', $auditoria['Audits']['id'] ) ); ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
<p>
<?php
echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
));
?>  </p>

<div class="paging">
<?php
    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
?>
</div>