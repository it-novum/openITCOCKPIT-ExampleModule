<?php
namespace ExampleModule\Lib;

use App\Lib\PluginAdditionalLinks;

/**
 * Class AdditionalLinks
 * @package itnovum\openITCOCKPIT\ExampleModule\AdditionalLinks
 */
class AdditionalLinks extends PluginAdditionalLinks {

    /**
     * @var array
     */
    private $links = [];

    /**
     * PluginAdditionalLinks constructor.
     */
    public function __construct() {
        // Add a link to hosts index drop down
        $this
            ->link(
                'hosts',
                'index',
                'list',
                'TestIndex({id: host.Host.id})',
                'fas fa-code',
                __('Module Link'),
                'test', //controller for permission check
                'index' //action for permission check
            );
    }
}
