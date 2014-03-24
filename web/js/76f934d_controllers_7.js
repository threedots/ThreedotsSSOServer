/* Controllers */

angular.module('dashApp.controllers', []).
    controller('UsersDailyCtrl', function ($scope, $http, $location, Daily, profileResource) {

        var dateNow = moment().tz(profileResource.timezone);
        $scope.profileResource = profileResource;
        $scope.dailyDate = dateNow.toDate();

        $scope.reportView = 'daily';

        // init as empty
        $scope.usersdaily = {};
        $scope.loaded = false;
        $scope.dateRange = dateNow.format("MMMM Do");

        $scope.predicate = '-status';
        $scope.reverse = false;

        $scope.setSort = function (column) {
            $scope.predicate = column;
            $scope.reverse = !$scope.reverse;
        }

        $scope.getClass = function (column) {
            if (column === $scope.predicate) {
                if ($scope.reverse) {
                    return "icon-sort-down";
                } else {
                    return "icon-sort-up";
                }
            } else {
                return "icon-sort";
            }
        }

        $scope.changeDay = function () {
            //todo: remove this hack
            if ($('#date-end').data().datepicker) {
                $('#date-end').datepicker('hide');
            }

            $scope.usersdaily.list = Daily.query({date: moment($scope.dailyDate).tz(profileResource.timezone).format("YYYY-MM-DD")}, function(){
                 $scope.loaded = true;
            });
			
            $scope.dateRange = moment($scope.dailyDate).tz(profileResource.timezone).format("MMMM Do");
        };

        $scope.prevDay = function () {
            $scope.dailyDate = moment($scope.dailyDate).tz(profileResource.timezone).subtract('d', 1).toDate();
            $scope.loaded = false;
			$scope.changeDay();
        };

        $scope.nextDay = function () {
            $scope.dailyDate = moment($scope.dailyDate).tz(profileResource.timezone).add('d', 1).toDate();
            $scope.loaded = false;
			$scope.changeDay();
        };

        $scope.$watch('profileResource.lastUpdate', function () {
            if (profileResource.lastUpdate) {
                // load records for today
                $scope.changeDay();
            }
        });
		
        $scope.$watch('usersdaily.list', function () {
            $scope.loaded = false;
        });

        // update data every 6 minutes
        $scope.updater = Visibility.every(360000, function () {
            $scope.changeDay();
        });

        $scope.$on('$routeChangeStart', function (scope, next, current) {
            Visibility.stop($scope.updater);
        });

    }).controller('UsersWeeklyCtrl', function ($scope, $http, $location, Weekly, profileResource) {

        var dateNow = moment().tz(profileResource.timezone);
        $scope.profileResource = profileResource;
        $scope.weeklyDate = dateNow.toDate();

        // init as empty
        $scope.usersWeekly = {};
        $scope.loaded = false;
        $scope.dateRange = dateNow.clone().days(1).format("MMM Do") + ' - ' + dateNow.clone().days(7).format("MMM Do");
        $scope.reportView = 'weekly';

        $scope.predicate = '-status';
        $scope.reverse = false;

        $scope.setSort = function (column) {
            $scope.predicate = column;
            $scope.reverse = !$scope.reverse;
        }

        $scope.getClass = function (column) {
            if (column === $scope.predicate) {
                if ($scope.reverse) {
                    return "icon-sort-down";
                } else {
                    return "icon-sort-up";
                }
            } else {
                return "icon-sort";
            }
        }

        $scope.changeWeek = function () {
            //todo: remove this hack
            if ($('#date-end').data().datepicker) {
                $('#date-end').datepicker('hide');
            }
            var dateWeek = moment($scope.weeklyDate).tz(profileResource.timezone);

            $scope.usersWeekly.list = Weekly.query({date: dateWeek.days(1).format("YYYY-MM-DD")}, function(){
                 $scope.loaded = true;
            });
            $scope.dateRange = dateWeek.days(1).format("MMM Do") + ' - ' + dateWeek.days(7).format("MMM Do");
        };

        $scope.prevWeek = function () {
            $scope.weeklyDate = moment($scope.weeklyDate).tz(profileResource.timezone).subtract('d', 7).toDate();
            $scope.loaded = false;
			$scope.changeWeek();
        };

        $scope.nextWeek = function () {
            $scope.weeklyDate = moment($scope.weeklyDate).tz(profileResource.timezone).add('d', 7).toDate();
            $scope.loaded = false;
			$scope.changeWeek();
        };

        $scope.$watch('profileResource.lastUpdate', function () {
            if (profileResource.lastUpdate) {
                // load records for current week
                $scope.changeWeek()
            }
        });

        // update data every 6 minutes
        $scope.updater = Visibility.every(360000, function () {
            $scope.changeWeek()
        });

        $scope.$on('$routeChangeStart', function (scope, next, current) {
            Visibility.stop($scope.updater);
        });

    });


