openITCOCKPIT.config(function($stateProvider){
    $stateProvider
        .state('TestIndex', { // Name of the NG-State => Same as in Menu.php
            url: '/example_module/test/index', // URL the browser should display
            templateUrl: '/example_module/test/index.html', // URL of the .html Template for AngularJS
            controller: 'TestIndexController' // Name of the AngularJS Controller. Convention: Controller name + Action Name + 'Controller'
        });
});
