<?php
declare(strict_types=1);

namespace ExampleModule\Model\Table;

use App\Model\Table\HostsTable;
use Cake\Datasource\RepositoryInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExampleNotes Model
 *
 * @property HostsTable&\Cake\ORM\Association\BelongsTo $Hosts
 *
 * @method \ExampleModule\Model\Entity\ExampleNote newEmptyEntity()
 * @method \ExampleModule\Model\Entity\ExampleNote newEntity(array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote[] newEntities(array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote get($primaryKey, $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ExampleModule\Model\Entity\ExampleNote[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ExampleNotesTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('example_notes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Hosts', [
            'foreignKey' => 'host_id',
            'joinType'   => 'INNER',
            'className'  => 'Hosts',
        ]);
    }


    public function bindCoreAssociations(RepositoryInterface $coreTable) {
        switch ($coreTable->getAlias()) {
            case 'Hosts':
                $coreTable->hasOne('ExampleNote', [ //Singular => hasOne!
                    'className' => 'ExampleModule.ExampleNotes',
                    'dependent' => true
                ]);
                break;
        }
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('notes')
            ->maxLength('notes', 255)
            ->requirePresence('notes', 'create')
            ->notEmptyString('notes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['host_id'], 'Hosts'));

        return $rules;
    }
}
