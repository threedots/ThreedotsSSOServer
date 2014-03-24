'use strict';
var TDServices = angular.module('DashboardApp.services', ['ngResource', 'ngCookies']);

TDServices.factory('daily', function($resource){

            return $resource('teamdaily/', {}, {
                query: {method: 'GET', params: {}, isArray: true}
            })
       });