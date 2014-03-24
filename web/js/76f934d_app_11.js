'use strict';
var dashApp = angular.module('dashApp', ['ngRoute', '$strap.directives', 'dashApp.services', 'dashApp.controllers', 'dashApp.filters', 'dashApp.directives']).
    config(function ($routeProvider, $locationProvider, $httpProvider) {
        $routeProvider.
            when("/daily", {templateUrl: "/partials/daily.html", controller: "UsersDailyCtrl"}).
            when("/weekly", {templateUrl: "/partials/weekly.html", controller: "UsersWeeklyCtrl"}).
            otherwise({redirectTo: '/daily'});


        // check for session expire
        // todo: rewrite this code during update to angularjs 1.X (Response interceptors (DEPRECATED))
        var interceptor = ['$rootScope', '$q', function (scope, $q) {

            function success(response) {
                return response;
            }

            function error(response) {
                var status = response.status;

                if (status == 401) {
                    window.location = "/v2/login.php";
                }
                // otherwise
                return $q.reject(response);

            }

            return function (promise) {
                return promise.then(success, error);
            }

        }];
        $httpProvider.responseInterceptors.push(interceptor);
    }
);

dashApp.value('$strap.config', {
    datepicker: {
        format: 'M d, yyyy',
        weekStart: 1,
        todayHighlight: true
    }
});