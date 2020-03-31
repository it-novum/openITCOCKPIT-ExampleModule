<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * Class Initial
 *
 * Created via:
 * oitc migrations create -p ExampleModule Initial
 */
class Initial extends AbstractMigration {

    /**
     * Whether the tables created in this migration
     * should auto-create an `id` field or not
     *
     * This option is global for all tables created in the migration file.
     * If you set it to false, you have to manually add the primary keys for your
     * tables using the Migrations\Table::addPrimaryKey() method
     *
     * @var bool
     */
    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change() {

        $this->table('example_notes')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default'       => null,
                'limit'         => 11,
                'null'          => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('host_id', 'integer', [
                'default' => null,
                'limit'   => 11,
                'null'    => false,
            ])
            ->addColumn('notes', 'string', [
                'default' => null,
                'limit'   => 255,
                'null'    => false,
            ])
            ->create();
    }
}
