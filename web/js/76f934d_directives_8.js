'use strict';

/* Directives */

angular.module('dashApp.directives', ["ngCookies"]).

    // may be used like <div user-info="user"></div>
    directive('userInfo',function () {

        return {
            restrict: 'A',
            scope: {
                user: '=userInfo'
            },
            template: '<img ng-src="{{user.avatar}}" width="32" height="32" alt="{{user.name}}" class="user-avatar">' +
                '<a href="#" class="user-name">{{user.name}}</a>' +
                '<ng:switch on="user.status">' +
                '<div ng:switch-when="not-active" class="status-info status-info-atention">{{user.statusinfo}}' +
                '&nbsp;<span style="cursor: pointer" title="Please ask this user to activate Time Doctor from the invitation email sent to them. You can also find the invitation link to send them on the \'Invite Users\' page (Settings menu)"><img src="/v2/views/images/question-icon.png" /></span></div>' +
                '<div ng:switch-when="not-using-client" class="status-info status-info-atention">{{user.statusinfo}} '+
				'<a ng-show="{{user.isLoggedUser}}" href="http://www.timedoctor.com/download.html" title="Download Time Doctor software" target="_blank">Download Time Doctor</a>'+
				'</div>' +
                '<div ng-switch-default class="status-info">{{user.statusinfo}}'+
				'</div>' +
                '</ng:switch>'
        };
    }).

    // may be used like <div two-hours-time-bar hour="foo"></div>
    directive('twoHoursTimeBar',function () {
        return {
            restrict: 'A',
            scope: {
                hour: '@',
                timeline: "="
            },
            template: '<div ng-repeat="time_entry in timeline | isTwoHourRange:hour" class="timebar timebar-{{time_entry.timetype}}"  ng-style="{ width: time_entry.length / 72 +\'%\', left: (time_entry.start % 7200) / 72 + \'%\' }"  title="<p><b>{{time_entry.message}}</b></p> {{time_entry.length | secToTime}}"></div>',
            link: function (scope, element, attrs) {
                // todo: find a way to setTimeout()
                setTimeout(function () {
                    $(element).children().tooltipster({
                        position: 'top',
                        maxWidth: 250
                    })
                }, 500);
            }
        };
    }).

    // may be used like <div weekly-time-bar time-entry="timeEntry"></div>
    directive('weeklyTimeBar', function () {

        return {
            restrict: 'A',
            scope: {
                timeEntry: "="
            },
            link: function (scope, element) {
                if (parseInt(scope.timeEntry.totaltime) <= 43200) {
                    scope.divisor = 432;
                } else {
                    scope.divisor = parseInt(scope.timeEntry.totaltime) / 100;
                }
                // tooltip
                setTimeout(function () {
                    $(element).children('.timebar').tooltipster({
                        position: 'top'
                    })
                }, 500);
            },
            template: '<div ng-show="timeEntry.worktime"   class="timebar timebar-worktime" ' +
                'ng-style="{width: timeEntry.worktime / divisor + \'%\'}" title="{{timeEntry.worktime | secToTime2}}"></div>' +
                '<div ng-show="timeEntry.editedtime" class="timebar timebar-editedtime" ' +
                'ng-style="{left: timeEntry.worktime / divisor + \'%\', width: timeEntry.editedtime / divisor + \'%\'}" title="{{timeEntry.editedtime | secToTime2}}"></div>' +
                '<div ng-show="timeEntry.mobiletime" class="timebar timebar-mobiletime" ' +
                'ng-style="{left: (timeEntry.worktime+timeEntry.editedtime) / divisor+ \'%\', width: timeEntry.mobiletime / divisor+ \'%\'}" title="{{timeEntry.mobiletime | secToTime2}}"></div>' +
                '<div class="timebar-block"></div>'
        };
    }).

    // may be used like <div video></div>
    directive('video', function (profileResource) {
        return {
            restrict: 'A',
            template: ' <div class="video-holder">' +
                                '<div id="video-close-button" ng-click="profileResource.hideVideo()"></div>' +
                                 '<div class="vi    deo">' +
									  '<div class="title">For Individuals</div>' +
										   '<div id="vid1" class="video-container">' +
												   '<iframe width="397" height="294" src="https://www.youtube.com/embed/McFBNvURBw4?feature=player_embedded&modestbranding=1&showinfo=0&theme=light" frameborder="0" allowfullscreen></iframe>' +
										   '</div>' +
								   '</div>' +
								   '<div class="video">' +
									   '<div class="title">For Admins and Managers</div>' +
										   '<div id="vid2" class="video-container">' +
												   '<iframe width="397" height="294" src="https://www.youtube.com/embed/hIlh6u0NiHE?feature=player_embedded&modestbranding=1&showinfo=0&theme=light" frameborder="0" allowfullscreen></iframe>' +
										   '</div>' +
									   '<div class="video-container">' +
								   '</div>' +
                            '</div>'
        };
    });
