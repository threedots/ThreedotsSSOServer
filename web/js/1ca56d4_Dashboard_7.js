
var TDModule = angular.module('DashboardApp.controllers', []);

TDModule.controller('UsersDailyCtrl', function($scope, $http, $location, Daily, profileResource){

            $scope.dailyDate = 'hello';

       })
       .controller('UsersWeeklyCtrl', function($scope, $http, $location, Weekly, profileResource){

            $scope.dailyDate = 'week';

       });