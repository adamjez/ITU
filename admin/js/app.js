(function(){
    var app = angular.module('email', []);
    app.controller('EmailController', function($scope){
	$scope.mailbox = {};
        $scope.mailbox.doClick = function(address, type)
        {
            $scope.mailbox.address = address;
            $scope.mailbox.type = type;
            $scope.mailbox.edit = true;
        }
    });
})();

