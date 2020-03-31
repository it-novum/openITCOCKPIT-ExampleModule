angular.module('openITCOCKPIT')
    .controller('TestIndexController', function($scope, $http){

        //Name TestIndexController same as in ng.states.js
        //Convention: Controller name + Action Name + 'Controller' = TestIndexController


        $scope.load = function(){

            // Query String parameters
            var params = {
                'angular': true
            };

            $http.get("/example_module/test/index.json", {
                params: params
            }).then(function(result){

                //Save notes from json result into local $scope.notes variable
                $scope.notes = result.data.result;

            }, function errorCallback(result){
                if(result.status === 403){
                    $state.go('403');
                }

                if(result.status === 404){
                    $state.go('404');
                }
            });
        };

        //Fire on page load
        $scope.load();

    });
