'use strict';

angular.module('DashboardApp.DashboardServices', ['ngResource', 'ngCookies'])
       . factory('daily', function($resource){

            return $resource('teamdaily/', {}, {
                query: {method: 'GET', params: {}, isArray: true}
            })
       });