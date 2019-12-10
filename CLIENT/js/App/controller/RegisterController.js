angular.module('myApp')
    .controller('register', function ($scope, $http, $window, $rootScope, $location) {
        $scope.tryToSignup = function (name, lastname, password, email, file) {
            if (file) {
                var photo = 'data:' + file.filetype + ';base64,' + file.base64;
                var data = {name: name, lastname: lastname, password: password, email: email, photo: photo}
            } else {
                var data = {name: name, lastname: lastname, password: password, email: email}
            }

            var link = 'http://back.epitech/add/profiles';
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                $location.path("/login");
            }, function errorCallback(error) {
                console.log('error', error);
            });
        };
    });