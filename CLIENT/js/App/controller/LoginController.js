angular.module('myApp')
    .controller('login', function ($scope, $http, $window, $rootScope, $cookieStore, $location) {
        $scope.tryToLogin = function (email, password) {
            var link = 'http://localhost:8000/authentification/profiles';

            $http({
                method: 'POST',
                url: link,
                data: {
                    email: email,
                    password: password
                },
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                if (data.data['message'] == 'false') {
                    return false;
                }
                var myId = data.data['Id'];
                $cookieStore.put('myId', myId);
                $window.localStorage.setItem('myId', myId);
                $location.path("/dashboard");
            }, function errorCallback(error) {
                console.log('error', error);
            });
        };
    });