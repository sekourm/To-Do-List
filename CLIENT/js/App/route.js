angular.module('myApp', ['ngRoute', 'naif.base64', 'ngSanitize', 'ngCookies', 'dndLists'])
    .config(function ($routeProvider) {
        $routeProvider
            .when('/', {
                url: "/",
                templateUrl: 'templates/login.html',
                controller: 'login'
            })
            .when('/register', {
                url: "/register",
                templateUrl: 'templates/register.html',
                controller: 'register'
            })
            .when('/dashboard/admin/:userId', {
                url: "/dashboard/admin/:userId",
                templateUrl: 'templates/dashboard-admin.html',
                controller: 'adminDashboard'
            })
            .when('/dashboard', {
                url: "/dashboard",
                templateUrl: 'templates/dashboard.html',
                controller: 'dashboard'
            })
            .when('/test', {
                url: "/test",
                templateUrl: 'templates/test.html',
                controller: 'test'
            })
            .when('/profil', {
                url: "/profil",
                templateUrl: 'templates/profil.html',
                controller: 'profil'
            })
            .when('/users', {
                url: "/users",
                templateUrl: 'templates/users.html',
                controller: 'users'
            })
            .otherwise({redirectTo: '/'});
    });