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

namespace ExampleModule\Command;


use App\Model\Table\HostsTable;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use ExampleModule\Model\Table\MypluginSettingsTable;
use GuzzleHttp\Client;
use itnovum\openITCOCKPIT\ApiShell\Exceptions\MissingParameterExceptions;
use itnovum\openITCOCKPIT\Core\Views\Host;
use RuntimeException;

class ExampleCommand extends Command {

    /**
     * PROBLEM", "RECOVERY", "ACKNOWLEDGEMENT", "FLAPPINGSTART", "FLAPPINGSTOP",
     * "FLAPPINGDISABLED", "DOWNTIMESTART", "DOWNTIMEEND", or "DOWNTIMECANCELLED"
     *
     * @var string
     */
    private $notificationtype = '';

    /**
     * Host UUID
     * @var string
     */
    private $hostname;


    /**
     * UP, DOWN or UNREACHABLE
     * @var string
     */
    private $hostState;


    private $hostoutput;

    private $settingsEntity;


    /**
     * @return void
     */
    public function __construct() {
        parent::__construct();


        /** @var MypluginSettingsTable $myPluginSettingsTable */
        $myPluginSettingsTable = $this->getTableLocator()->get('ExampleModule.MypluginSettings');
        $this->settingsEntity = $myPluginSettingsTable->getSettingsEntity();
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param ConsoleOptionParser $parser The parser to be defined
     * @return ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser {
        $parser = parent::buildOptionParser($parser);

        $parser->addOptions([
            'type'             => ['short' => 't', 'help' => __d('oitc_console', 'Type of the notification host or service'), 'default' => 'host'],
            'notificationtype' => ['help' => __d('oitc_console', 'Notification type of monitoring engine')],
            'hostname'         => ['help' => __d('oitc_console', 'Host uuid you want to send a notification')],
            'hoststate'        => ['help' => __d('oitc_console', 'current host state')],
            'hostoutput'       => ['help' => __d('oitc_console', 'host output')],
        ]);

        return $parser;
    }

    /**
     * @param Arguments $args
     * @param ConsoleIo $io
     */
    public function execute(Arguments $args, ConsoleIo $io): void {
        try {
            // Validate User input
            $this->validateOptions($args);

            // Build notification.
            $notification = $this->buildNotification();

            // Build Data.
            $data = [
                'json'    => $this->buildMessage($notification),
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ];

            // Post Data.
            $guzzleclient = new Client();
            $r = $guzzleclient->post($this->settingsEntity->webhook_url, $data);

            var_dump($r);
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            exit(1);
        }
        exit(0);
    }

    /**
     * I will build the Notification.
     * @return array
     */
    private function buildNotification(): array {
        $notification['color'] = 'Good';
        $notification['hostId'] = $this->getHost()->getId();
        $notification['hostName'] = $this->getHost()->getHostname();
        $notification['output'] = $this->hostoutput;

        return $notification;
    }


    /**
     * Based on the user's input hostUuid, I will return the correct Host.
     * @return Host
     */
    private function getHost(): Host {
        try {
            /** @var HostsTable $HostsTable */
            $HostsTable = TableRegistry::getTableLocator()->get('Hosts');
            $host = $HostsTable->getHostByUuid($this->hostname, false);
        } catch (RecordNotFoundException) {
            throw new RuntimeException(sprintf('Host with uuid "%s" could not be found!', $this->hostname));
        }

        return new Host($host);
    }


    private function buildMessage(array $notification): array {
        return [
            'type'        => 'message',
            'attachments' => [
                [
                    'contentType' => 'application/vnd.microsoft.card.adaptive',
                    'contentUrl'  => null,
                    'content'     => [
                        '$schema' => 'http://adaptivecards.io/schemas/adaptive-card.json',
                        'type'    => 'AdaptiveCard',
                        'version' => '1.6',
                        'body'    => [
                            [
                                'type'  => 'Container',
                                'items' => [
                                    [
                                        'type'   => 'TextBlock',
                                        'text'   => sprintf(
                                            'Status changed for host %s',
                                            $this->getHost()->getHostname()
                                        ),
                                        'weight' => 'bolder',
                                        'size'   => 'medium',
                                        'color'  => $notification['color']
                                    ],
                                ]
                            ],
                            [
                                'type'  => 'Container',
                                'items' => [
                                    [
                                        'type'  => 'FactSet',
                                        'facts' => [
                                            [
                                                'title' => 'Output:',
                                                'value' => $notification['output']
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param Arguments $args
     * @throws MissingParameterExceptions
     */
    private function validateOptions(Arguments $args): void {
        $this->useProxy = $args->getOption('proxy');

        if ($args->getOption('hostname') === '') {
            throw new MissingParameterExceptions(
                'Option --hostname is missing'
            );
        }
        $this->hostname = $args->getOption('hostname');


        if ($args->getOption('hoststate') === '') {
            throw new MissingParameterExceptions(
                'Option --hoststate is missing'
            );
        }
        $this->hostState = $args->getOption('hoststate');
        if ($args->getOption('hostoutput') === '') {
            throw new MissingParameterExceptions(
                'Option --hostoutput is missing'
            );
        }
        $this->hostoutput = $args->getOption('hostoutput');

        if ($args->getOption('output') === '') {
            throw new MissingParameterExceptions(
                'Option --output is missing'
            );
        }
        $this->output = $args->getOption('output');

    }

}