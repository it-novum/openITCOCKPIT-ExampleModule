<?php

namespace ExampleModule\Lib;


use itnovum\openITCOCKPIT\Core\Menu\MenuCategory;
use itnovum\openITCOCKPIT\Core\Menu\MenuHeadline;
use itnovum\openITCOCKPIT\Core\Menu\MenuInterface;
use itnovum\openITCOCKPIT\Core\Menu\MenuLink;

class Menu implements MenuInterface {

    /**
     * @return array
     */
    public function getHeadlines() {
        $Overview = new MenuHeadline(\itnovum\openITCOCKPIT\Core\Menu\Menu::MENU_OVERVIEW);
        $Overview
            //Create a new Sub-Category of the Overview Headline
            ->addCategory((new MenuCategory(
                'ExampleModule',
                __('Example Module'),
                1000,
                'fas fa-burn'
            ))
                //Add new Link to Sub-Category
                ->addLink(new MenuLink(
                    __('Hello world'),
                    'TestIndex', //Name of the NG-State
                    'Test', //Name of the PHP Controller
                    'index', //Name of the PHP action
                    'ExampleModule', //Name of the Module
                    'fas fa-code', //Menu Icon
                    [],
                    1
                ))
            );

        return [$Overview];
    }

}


