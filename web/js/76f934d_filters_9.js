'use strict';

/* Filters */

angular.module('dashApp.filters', []).

    filter('range',function () {
        return function (input, total) {
            total = parseInt(total);
            for (var i = 0; i < total; i++)
                input.push(i);
            return input;
        };
    }).

    filter('isTwoHourRange',function () {
        return function (input, hour) {
            hour = parseInt(hour)
            var out = [];
            for (var i = 0; i < input.length; i++) {
                if (input[i].start >= hour * 3600 && input[i].start < ((hour + 2) * 3600)) {
                    out.push(input[i]);
                }

            }
            return out;
        };
    }).

    filter('secToTime',function () {
        return function (input, total) {
            var sec_numb = parseInt(input);
            var hours = Math.floor(sec_numb / 3600);
            var minutes = Math.floor((sec_numb - (hours * 3600)) / 60);

            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            return  hours + ':' + minutes;
        };
    }).

    filter('secToTime2', function () {
        return function (input, total) {
            var sec_numb = parseInt(input);
            var hours = Math.floor(sec_numb / 3600);
            var minutes = Math.floor((sec_numb - (hours * 3600)) / 60);

            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            return  hours + 'h ' + minutes + 'm';
        };
    })