<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsultoriosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsultoriosTable Test Case
 */
class ConsultoriosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.consultorios',
        'app.clinicas',
        'app.medicos',
        'app.usuarios',
        'app.obra_socials',
        'app.grupos',
        'app.facebooks',
        'app.baker_repositorios',
        'app.secretarias',
        'app.especialidads',
        'app.disponibilidad',
        'app.excepciones',
        'app.turnos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Consultorios') ? [] : ['className' => 'App\Model\Table\ConsultoriosTable'];
        $this->Consultorios = TableRegistry::get('Consultorios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Consultorios);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
