(function(){
    var app = angular.module('email', []);
    app.controller('EmailController', function($scope){
        $scope.edit = function(address, type)
        {
            $scope.edit.address = address;
            $scope.edit.type = type;
            $scope.edit.show = true;
        }
    });
})();

