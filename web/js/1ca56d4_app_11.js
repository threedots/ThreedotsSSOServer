'use strict';
var DashboardApp = angular.module('DashboardApp', ['ngRoute', 'DashboardApp.services', 'DashboardApp.controllers'])
                          .config(function($routeProvider, $locationProvider, $httpProvider){

                                $routeProvider.when('/daily',  {templateUrl: '/bundles/partials/daily.html', controller: 'UsersDailyCtrl'})
                                              .when('/weekly', {templateUrl: '/bundles/partials/weekly.html', controller: 'UsersWeeklyCtrl'})
                                              .otherwise({redirectTo: '/daily'})

                          });