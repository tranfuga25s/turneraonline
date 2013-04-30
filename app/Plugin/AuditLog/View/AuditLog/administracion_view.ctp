<?php
$this->set( 'title_for_layout', "Viendo registro de cambio" );
?>
<script>
    var datos = <?php echo $audit['Audits']['json_object']; ?>;
    $( function() {
       $.each( datos.<?php echo $audit['Audits']['model'] ?>, function( key, valueObj ) {
           $('#datos').append( $("#copiar1").clone().html( '<b>'+key+'</b>&nbsp;') );
           if( typeof(valueObj) == 'object' ) {
                $('#datos').append( $('#copiar2').clone().html( 'Objeto complejo &nbsp;' ) );
           } else {
                $('#datos').append( $('#copiar2').clone().html( valueObj+'&nbsp;' ) );
           }
       });
       $("#acordion").accordion( { autoHeight: false });
    });
</script>
<h2>Viendo registro de cambios</h2>
<div id="acordion">
    <h3><a href="#">Registro</a></h3>
    <div>
        <br />
    	<dl>
    		<dt>Accion:</dt>
    		<dd>
    			<?php echo h($audit['Audits']['event']); ?>
    			&nbsp;
    		</dd>
    		<dt>Modelo</dt>
    		<dd>
    			<?php echo h($audit['Audits']['model']); ?>
    			&nbsp;
    		</dd>
    		<dt>Identificador del modelo</dt>
            <dd>
                <?php echo $this->Html->link( h($audit['Audits']['entity_id'] ), array( 'controller' => Inflector::pluralize( $audit['Audits']['model'] ), 'action' => 'view', $audit['Audits']['entity_id'], 'admin' => true, 'plugin' => false ) ); ?>
                &nbsp;
            </dd>
            <dt>Descripcion</dt>
            <dd>
                <?php echo h($audit['Audits']['description']); ?>
                &nbsp;
            </dd>
            <dt>Usuario modificador&nbsp;</dt>
            <dd>
                <?php echo $this->Html->link( $usuarios[$audit['Audits']['source_id']], array( 'controller' => 'usuarios', 'action' => 'view', $audit['Audits']['source_id'] ) ); ?>
                &nbsp;
            </dd>
            <dt>Fecha de registro</dt>
            <dd>
                <?php echo h($audit['Audits']['created']); ?>
                &nbsp;
            </dd>
    	</dl>
    </div>
    <h3><a href="#">Datos modificados</a></h3>
    <div>
        <br />
        <table>
            <tbody>
                <th>Propiedad</th>
                <th>Valor anterior</th>
                <th>Valor nuevo</th>
        <?php foreach( $audit['AuditDeltas'] as $dato ) {
            echo "<tr>";
               echo "<td>".$dato['property_name']."</td>";
               echo "<td>".$dato['old_value']."</td>";
               echo "<td>".$dato['new_value']."</td>";
            echo "</tr>";
        } ?>
        </tbody>
       </table>
    </div>
    <h3><a href="#">Datos Actuales</a></h3>
    <div>
        <br />
        <dl id="datos">
            <dt id="copiar1"></dt>
            <dd id="copiar2"></dd>
        </dl>
    </div>
</div>