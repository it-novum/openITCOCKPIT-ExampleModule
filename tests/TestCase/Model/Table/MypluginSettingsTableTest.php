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

namespace ExampleModule\Test\TestCase\Model\Table;


use Cake\TestSuite\TestCase;
use ExampleModule\Model\Table\MypluginSettingsTable;

/**
 * ExampleModule\Model\Table\MypluginSettingsTable Test Case
 */
class MypluginSettingsTableTest extends TestCase {
    /**
     * Test subject
     *
     * @var \ExampleModule\Model\Table\MypluginSettingsTable
     */
    protected $MypluginSettings;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.ExampleModule.MypluginSettings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MypluginSettings') ? [] : ['className' => MypluginSettingsTable::class];
        $this->MypluginSettings = $this->getTableLocator()->get('MypluginSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void {
        unset($this->MypluginSettings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ExampleModule\Model\Table\MypluginSettingsTable::validationDefault()
     */
    public function testValidationDefault(): void {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
