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

namespace ExampleModule\Controller;

use ExampleModule\Model\Table\MypluginSettingsTable;

class TestController extends AppController {
    public function index() {
        /** @var MypluginSettingsTable $myPluginSettingsTable */
        $myPluginSettingsTable = $this->getTableLocator()->get('ExampleModule.MypluginSettings');
        $settingsEntity = $myPluginSettingsTable->getSettingsEntity();

        if ($this->request->is('post')) {
            $settingsEntity = $myPluginSettingsTable->patchEntity($settingsEntity, $this->request->getData(null, []));

            $myPluginSettingsTable->save($settingsEntity);
            if ($settingsEntity->hasErrors()) {
                $this->response = $this->response->withStatus(400);
                $this->set('error', $settingsEntity->getErrors());
                $this->viewBuilder()->setOption('serialize', ['error']);
                return;
            }

            $this->set('teamsSettings', $settingsEntity);
            $this->viewBuilder()->setOption('serialize', [
                'teamsSettings'
            ]);
        }

        $this->set('settings', $settingsEntity);
        $this->viewBuilder()->setOption('serialize', ['settings']);
    }
}
