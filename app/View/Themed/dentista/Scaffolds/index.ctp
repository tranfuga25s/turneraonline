<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Scaffolds
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<script>
 $( function() { $("a", "#accion").button(); });
</script>
<div id="accion">
			<?php echo $this->Html->link( 'Nuevo '. $singularHumanName, array( 'action' => 'add' ) ); ?>
<?php
		$done = array();
		foreach ($associations as $_type => $_data) {
			foreach ($_data as $_alias => $_details) {
				if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
					echo $this->Html->link(__d('cake', 'List %s', Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index'));
					echo $this->Html->link(__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add')) ;
					$done[] = $_details['controller'];
				}
			}
		}
?>
</div>
<br />
<div class="decorado1">
	<div class="titulo1"><?php echo $pluralHumanName;?></div>
<table cellpadding="0" cellspacing="0">
<tr>
<?php foreach ($scaffoldFields as $_field):?>
	<th><?php echo $this->Paginator->sort($_field);?></th>
<?php endforeach;?>
	<th>Acci&oacute;ns</th>
</tr>
<?php
$i = 0;
foreach (${$pluralVar} as ${$singularVar}):
	echo "<tr>";
		foreach ($scaffoldFields as $_field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $_alias => $_details) {
					if ($_field === $_details['foreignKey']) {
						$isKey = true;
						echo "<td>" . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "</td>";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "<td>" . h(${$singularVar}[$modelClass][$_field]) . "</td>";
			}
		}

		echo '<td class="actions">';
		echo $this->Html->link( 'Ver', array('action' => 'view', ${$singularVar}[$modelClass][$primaryKey]));
		echo $this->Html->link( 'Editar', array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]));
		echo $this->Form->postLink(
			'Eliminar',
			array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]),
			null,
			'Esta seguro que desea eliminar el item' . ' #' . ${$singularVar}[$modelClass][$primaryKey]
		);
		echo '</td>';
	echo '</tr>';

endforeach;

?>
</table>
	<p><?php
	echo $this->Paginator->counter(array(
		'format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?></p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev( '< anterior', array(), null, array( 'class' => 'prev disabled' ) );
		echo $this->Paginator->numbers( array( 'separator' => '' ) );
		echo $this->Paginator->next( 'siguiente >', array(), null, array( 'class' => 'next disabled' ) );
	?>
	</div>
</div>