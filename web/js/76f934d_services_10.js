'use strict';

angular.module('dashApp.services', ['ngResource', 'ngCookies']).
    factory('Daily',function ($resource) {
        return $resource('/index/teamdaily/:date', {}, {
            query: {method: 'GET', params: {}, isArray: true}
        });
    }).
    factory('Weekly',function ($resource) {
        return $resource('/index/teamweekly/:date', {}, {
            query: {method: 'GET', params: {}, isArray: true}
        });
    }).
    factory('profileResource', function ($resource, $cookieStore, $http) {
        var user = window.user;

        user.isLogged = true;
        user.lastUpdate = new Date();

        user.isAdmin = function () {
            return this.role == 'admin'
        }
        user.isManager = function () {
            return this.role == 'manager'
        }
        user.isOwner = function () {
            return this.role == 'owner';
        }
        user.hasMangerRights = function () {
            return (this.isManager() || this.isAdmin() || this.isOwner());
        }

        user.hideVideo = function () {
            // runtime
            user.videoTips = false;
            // setting cookie to avoid show on next load
            $cookieStore.put('intro-videos-closed-' + user.id, 1);
        }

        user.hideDummy = function () {
            user.dummyData = false;
            $http.get('/dummy/disable').success(function () {
                user.lastUpdate = new Date();
            });
        }

        if ($cookieStore.get('intro-videos-closed-' + user.id)) {
            user.videoTips = false;
        }

        return user;
    });