var variable1 = true;
angular.module('myApp')
    .controller('adminDashboard', function ($scope, $http, $window, $rootScope, $cookieStore, $location, $route, $timeout, $routeParams) {

        var user_id = $routeParams.userId;

        var myId = $cookieStore.get('myId');
        $scope.showmodifytasks = false;
        $scope.tasksShow = false;
        $scope.tasksShowindex;
        $scope.activeParentIndex;
        if (!myId) {
            $location.path("/register");
        }

        $scope.disconnect = function ($event) {
            $event.stopPropagation();
            $cookieStore.remove('myId');
            $location.path("/login");
        };

        $scope.showKids = function (index) {
            $scope.tasksShow = true;
            $scope.activeParentIndex = index;
        };

        $scope.isShowing = function (index) {
            return $scope.activeParentIndex === index;
        };

        $scope.changeTasks = function (list) {
            $scope.tasksShow = false;
        };

        $scope.deteletasks = function (Tasksid) {
            var link = 'http://localhost:8000/delete/tasks/' + Tasksid;

            $http({
                method: 'POST',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                Object.keys($scope.models.lists).forEach(function (key) {
                    for (var k = 0; k < $scope.models.lists[key][0].length; k++) {
                        if ($scope.models.lists[key][0][k].id === Tasksid) {
                            $scope.models.lists[key][0].splice(k, 1);
                        }
                    }
                });
            }, function errorCallback(error) {
            });
        };
        $scope.modifytasks = function (list) {
            $scope.showmodifytasks = true;
        };
        $scope.myFunc = function (keyEvent, tasks, item) {
            if (keyEvent.which === 13) {
                $scope.showmodifytasks = false;
            }

        };

        var link = 'http://localhost:8000/show/profiles/' + myId;

        $http({
            method: 'POST',
            url: link,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(data) {
            $scope.id = data.data['id'];
            $scope.photo = data.data['photo'];
            $scope.name = data.data['name'];
            $scope.lastname = data.data['lastname'];
            $scope.email = data.data['email'];
            $scope.theme = data.data['theme'];
            $scope.variable1 = data.data['theme'];
            $scope.biographie = data.data['biographie'];
            $scope.isAdmin = data.data['isAdmin'];

            if (data.data['isAdmin'] === false) {
                $location.path("/dashboard");
            }

        }, function errorCallback(error) {
        });

        var link = 'http://localhost:8000/show/profiles/' + user_id;

        $http({
            method: 'POST',
            url: link,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(data) {

            $scope.user_id = data.data['id'];
            $scope.user_name = data.data['name'];
            $scope.user_lastname = data.data['lastname'];
            $scope.user_email = data.data['email'];
            $scope.user_isAdmin = data.data['isAdmin'];

            if (data.data['id'] == null || data.data['isAdmin'] === true) {
                $location.path("/dashboard");
            }

        }, function errorCallback(error) {
        });

        /*** Create the Categorie **/

        $scope.CreateCategorie = function (categorie) {
            $scope.categorie = categorie;

            var link = 'http://localhost:8000/add/categories/admin/' + $scope.categorie + '/' + user_id + '/' + myId;
            $http({
                method: 'POST',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                $route.reload();
            }, function errorCallback(error) {
            });
            $scope.categorie = null;
        };

        /***End of Categorie Creation**/


        var link3 = 'http://localhost:8000/show/tasks';

        $http({
            method: 'POST',
            url: link3,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(data) {
            $scope.tasks = data.data;

        }, function errorCallback(error) {
        });

        /************** Show all Categorie*****************/

        var link2 = 'http://localhost:8000/show/categories/' + user_id;
        var test = [];
        var element = {};

        $http({
            method: 'POST',
            url: link2,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(data) {
            $scope.categories = data;
            for (var i = 0; i < $scope.categories.data.length; i++) {
                var test2 = $scope.categories.data[i].name;
                element[test2] = [[], [$scope.categories.data[i].id]];
                test.push({[test2]: [], id: $scope.categories.data[i].id})
            }
            $scope.models = {selected: null, lists: element};
            var link3 = 'http://localhost:8000/show/tasks';
            $http({
                method: 'POST',
                url: link3,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                $scope.tasks = data.data;
                Object.keys($scope.models.lists).forEach(function (key) {
                    for (var k = 0; k < $scope.tasks.length; k++) {
                        if ($scope.models.lists[key][1][0] == $scope.tasks[k].categorieId) {
                            $scope.models.lists[key][0].push({
                                label: $scope.tasks[k].title,
                                id: $scope.tasks[k].id,
                                description: $scope.tasks[k].description,
                                limit_date: $scope.tasks[k].limitDate
                            })
                        }
                    }
                });
            }, function errorCallback(error) {
            });


        }, function errorCallback(error) {
        });

        $scope.dropCallback2 = function (item, list, index) {
            var tasks_id = list[0][index].id;
            var categorie_id = list[1][0];
            var title = list[0][index].label;
            var descrption = list[0][index].description;


            var link = 'http://localhost:8000/update/tasks/' + tasks_id + '/' + categorie_id + '/' + title + '/' + descrption;
            $http({
                method: 'POST',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
            }, function errorCallback(error) {
            });


        };

        $scope.CreateTasks = function (list, title, description) {
            if (title == '' || title == undefined || description == '' || description == undefined) {
                return false;
            }
            var link = 'http://localhost:8000/add/tasks/admin/' + list[0] + '/' + title + '/' + description + '/' + myId;
            $http({
                method: 'POST',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                $route.reload();
                $scope.tasksShow = false;
            }, function errorCallback(error) {
            });
        };

        $scope.SaveTasksUpdate = function (tasksId, title, description, list) {
            if (title == '' || title == undefined || description == '' || description == undefined) {
                return false;
            }
            var link = 'http://localhost:8000/update/tasks/' + tasksId + '/' + list[0] + '/' + title + '/' + description;
            $http({
                method: 'POST',
                url: link,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(data) {
                $route.reload();
            }, function errorCallback(error) {
            });
            $scope.tasksShow = false;
        };

        $scope.$watch('models', function (model) {
            $scope.modelAsJson = angular.toJson(model, true);
        }, true);
    });