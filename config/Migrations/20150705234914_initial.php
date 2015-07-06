<?php
use Phinx\Migration\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('avisos', ['id' => false, 'primary_key' => ['id_aviso']]);
        $table
            ->addColumn('id_aviso', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('fecha_envio', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('template', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('layout', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('formato', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('metodo', 'string', [
                'default' => 'email',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('to', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('from', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();
        $table = $this->table('categorias', ['id' => false, 'primary_key' => ['id_categoria']]);
        $table
            ->addColumn('id_categoria', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('nombre', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('lft', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('rght', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('publicada', 'boolean', [
                'default' => 0,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('descripcion', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();
        $table = $this->table('clinicas', ['id' => false, 'primary_key' => ['id_clinica']]);
        $table
            ->addColumn('id_clinica', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('nombre', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('direccion', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('telefono', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('logo', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('lat', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lng', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('zoom', 'string', [
                'default' => 12,
                'limit' => 255,
                'null' => true,
            ])
            ->create();
        $table = $this->table('cobro_sms', ['id' => false, 'primary_key' => ['id_cobro_sms']]);
        $table
            ->addColumn('id_cobro_sms', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('cliente_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('fecha', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('costo', 'float', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('mov_ctacte_id', 'integer', [
                'default' => 0,
                'limit' => 10,
                'null' => false,
            ])
            ->addIndex(
                [
                    'mov_ctacte_id',
                ],
                ['unique' => true]
            )
            ->create();
        $table = $this->table('comentarios', ['id' => false, 'primary_key' => ['id_comentario']]);
        $table
            ->addColumn('id_comentario', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('pregunta_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('usuario', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('comentario', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('aprobado', 'boolean', [
                'default' => 0,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('consultorios', ['id' => false, 'primary_key' => ['id_consultorio']]);
        $table
            ->addColumn('id_consultorio', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('clinica_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('nombre', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('conteo_sms', ['id' => false, 'primary_key' => ['id_conteo_sms']]);
        $table
            ->addColumn('id_conteo_sms', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('cliente_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('fecha', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('envios', 'integer', [
                'default' => 0,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('recibidos', 'integer', [
                'default' => 0,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('costo', 'float', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addIndex(
                [
                    'cliente_id',
                    'fecha',
                ],
                ['unique' => true]
            )
            ->create();
        $table = $this->table('dia_disponibilidad');
        $table
            ->addColumn('disponibilidad_id', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('dia', 'integer', [
                'default' => null,
                'limit' => 6,
                'null' => false,
            ])
            ->addColumn('habilitado', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('hora_inicio', 'time', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('hora_fin', 'time', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('hora_inicio_tarde', 'time', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('hora_fin_tarde', 'time', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'disponibilidad_id',
                    'dia',
                ],
                ['unique' => true]
            )
            ->create();
        $table = $this->table('disponibilidad', ['id' => false, 'primary_key' => ['id_disponibilidad']]);
        $table
            ->addColumn('id_disponibilidad', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('medico_id', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('duracion', 'integer', [
                'default' => 10,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('consultorio_id', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->create();
        $table = $this->table('especialidades', ['id' => false, 'primary_key' => ['id_especialidad']]);
        $table
            ->addColumn('id_especialidad', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('nombre', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();
        $table = $this->table('excepciones', ['id' => false, 'primary_key' => ['id_excepcion']]);
        $table
            ->addColumn('id_excepcion', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('medico_id', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('inicio', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('fin', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rep_semanal', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rep_mensual', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rep_anual', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('relativo', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->create();
        $table = $this->table('grupos', ['id' => false, 'primary_key' => ['id_grupo']]);
        $table
            ->addColumn('id_grupo', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('nombre', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('medicos', ['id' => false, 'primary_key' => ['id_medico']]);
        $table
            ->addColumn('id_medico', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('usuario_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('especialidad_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('clinica_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('visible', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('obras_sociales', ['id' => false, 'primary_key' => ['id_obra_social']]);
        $table
            ->addColumn('id_obra_social', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('nombre', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('direccion', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('telefono', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('imagen', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();
        $table = $this->table('secretarias', ['id' => false, 'primary_key' => ['id_secretaria']]);
        $table
            ->addColumn('id_secretaria', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('usuario_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('clinica_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('resumen', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('turnos', ['id' => false, 'primary_key' => ['id_turno']]);
        $table
            ->addColumn('id_turno', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('paciente_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('medico_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('fecha_inicio', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('fecha_fin', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('consultorio_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('recibido', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('atendido', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('cancelado', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();
        $table = $this->table('usuarios', ['id' => false, 'primary_key' => ['id_usuario']]);
        $table
            ->addColumn('id_usuario', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('nombre', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('apellido', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('telefono', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('celular', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('obra_social_id', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('notificaciones', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('contra', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('grupo_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('facebook_id', 'float', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('sexo', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();
        $table = $this->table('variables_avisos', ['id' => false, 'primary_key' => ['id_variable']]);
        $table
            ->addColumn('id_variable', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('modelo', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('nombre', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('aviso_id', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addIndex(
                [
                    'aviso_id',
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->dropTable('avisos');
        $this->dropTable('clinicas');
        $this->dropTable('cobro_sms');
        $this->dropTable('comentarios');
        $this->dropTable('consultorios');
        $this->dropTable('conteo_sms');
        $this->dropTable('dia_disponibilidad');
        $this->dropTable('disponibilidad');
        $this->dropTable('especialidades');
        $this->dropTable('excepciones');
        $this->dropTable('grupos');
        $this->dropTable('medicos');
        $this->dropTable('obras_sociales');
        $this->dropTable('secretarias');
        $this->dropTable('turnos');
        $this->dropTable('usuarios');
        $this->dropTable('variables_avisos');
    }
}
