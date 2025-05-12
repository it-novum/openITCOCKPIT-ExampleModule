<?php
// Copyright (C) <2015-present>  <it-novum GmbH>
//
// This file is dual licensed
//
// 1.
//     This program is free software: you can redistribute it and/or modify
//     it under the terms of the GNU General Public License as published by
//     the Free Software Foundation, version 3 of the License.
//
//     This program is distributed in the hope that it will be useful,
//     but WITHOUT ANY WARRANTY; without even the implied warranty of
//     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//     GNU General Public License for more details.
//
//     You should have received a copy of the GNU General Public License
//     along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
// 2.
//     If you purchased an openITCOCKPIT Enterprise Edition you can use this file
//     under the terms of the openITCOCKPIT Enterprise Edition license agreement.
//     License agreement and license key will be shipped with the order
//     confirmation.

declare(strict_types=1);

namespace ExampleModule\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MypluginSettings Model
 *
 * @method \ExampleModule\Model\Entity\MypluginSetting newEmptyEntity()
 * @method \ExampleModule\Model\Entity\MypluginSetting newEntity(array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting[] newEntities(array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting get($primaryKey, $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ExampleModule\Model\Entity\MypluginSetting[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MypluginSettingsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('myplugin_settings');
        $this->setDisplayField('webhook_url');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->scalar('webhook_url')
            ->maxLength('webhook_url', 255)
            ->notEmptyString('webhook_url');

        return $validator;
    }

    public function getSettingsEntity() {
        $result = $this->find()
            ->where([
                'id' => 1
            ])
            ->first();

        if (empty($result)) {
            $entity = $this->newEmptyEntity();
            $entity->set('id', 1);
            $entity->setAccess('id', false);
            return $entity;
        }

        $result->setAccess('id', false);
        return $result;
    }
}
