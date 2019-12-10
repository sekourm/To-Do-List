angular.module('myApp')
    .controller('users', function ($scope, $http, $window, $rootScope, $cookieStore, $location, $timeout) {
        console.log('users load');

        var myId = $cookieStore.get('myId');

        var link = 'http://back.epitech/show/profiles/' + myId;

        $http({
            method: 'POST',
            url: link,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(data) {
            $scope.myId = data.data['id'];
            $scope.photo = data.data['photo'];
            $scope.name = data.data['name'];
            $scope.lastname = data.data['lastname'];
            $scope.email = data.data['email'];
            $scope.theme = data.data['theme'];
            $scope.biographie = data.data['biographie'];
            $scope.isAdmin = data.data['isAdmin'];

        }, function errorCallback(error) {
            console.log('error', error);
        });

        var link = 'http://back.epitech/show/profiles';

        $http({
            method: 'GET',
            url: link,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(data) {
            $scope.users = data.data;

        }, function errorCallback(error) {
            console.log('error', error);
        });

        $scope.disconnect = function ($event) {
            $event.stopPropagation();
            $cookieStore.remove('myId');
            $location.path("/login");
        };

        $scope.banne = function (userId) {
            var link = 'http://back.epitech/banne/profiles/'+userId;
            $http({
                method: 'GET',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                location.reload();
            }, function errorCallback(error) {
            });
        };

        $scope.debanne = function (userId) {
            var link = 'http://back.epitech/active/profiles/'+userId;
            $http({
                method: 'GET',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                location.reload();
            }, function errorCallback(error) {
            });
        };

        $scope.delete = function (userId) {
            var link = 'http://back.epitech/delete/profiles/'+userId;
            $http({
                method: 'GET',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                location.reload();
            }, function errorCallback(error) {
            });
        };


    });