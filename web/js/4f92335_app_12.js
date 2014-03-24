'use strict';
var DashboardApp = angular.module('DashboardApp', ['ngRoute', 'DashboardApp.DashboardServices', 'DashboardApp.filters', 'DashboardApp.directives'])
                          .config(function($routeProvider, $locationProvider, $httpProvider){

                                $routeProvider.when('/daily',  {templateUrl: 'views/partials/', controller: 'UsersDailyCtrl'})
                                              .when('/weekly', {templateUrl: '', controller: 'UsersDailyCtrl'})
                                              .otherwise({redirectTo: '/daily'})

                          });