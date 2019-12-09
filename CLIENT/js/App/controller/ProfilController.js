angular.module('myApp')

    .controller('profil', function ($scope, $http, $window, $rootScope, $cookieStore, $location) {
        var myId = $cookieStore.get('myId');

        var link = 'http://localhost:8000/show/profiles/' + myId;

        $http({
            method: 'POST',
            url: link,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(data) {
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

        $scope.disconnect = function ($event) {
            $event.stopPropagation();
            $cookieStore.remove('myId');
            $location.path("/login");
        };

        $scope.UpdateProfil = function (name, lastname, email, biographie) {
            var link = 'http://localhost:8000/update/profiles';
            var data = {name: name, lastname: lastname, email: email, biographie: biographie, profile_id: myId};

            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });

        };

        $scope.trigger = function (file) {
            var link = 'http://localhost:8000/update/photos';
            var photo = 'data:' + file.filetype + ';base64,' + file.base64;
            var data = {photo: photo, profile_id: myId};
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });

        };

        $scope.ChangeBlue = function () {
            var link = 'http://localhost:8000/update/themes';
            var data = {theme: 'blue', profile_id: myId};
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });
            $scope.theme = 'blue';
        };
        $scope.ChangeRed = function () {
            var link = 'http://localhost:8000/update/themes';
            var data = {theme: 'red', profile_id: myId};
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });
            $scope.theme = 'red';
        };
        $scope.ChangePurple = function () {
            var link = 'http://localhost:8000/update/themes';
            var data = {theme: 'purple', profile_id: myId};
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });
            $scope.theme = 'purple';
        };
        $scope.ChangeOrange = function () {
            var link = 'http://localhost:8000/update/themes';
            var data = {theme: 'orange', profile_id: myId};
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });
            $scope.theme = 'orange';
        };
        $scope.ChangeGreen = function () {
            var link = 'http://localhost:8000/update/themes';
            var data = {theme: 'green', profile_id: myId};
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });
            $scope.theme = 'green';
        };
        $scope.ChangeAzure = function () {
            var link = 'http://localhost:8000/update/themes';
            var data = {theme: 'azure', profile_id: myId};
            $http({
                method: 'POST',
                url: link,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
                console.log('error', error);
            });
            $scope.theme = 'azure';
        };
    });