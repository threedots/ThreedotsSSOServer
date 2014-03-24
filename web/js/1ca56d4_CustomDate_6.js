/*
 Filename: Custom Date Manager

 Dependency:
 ----------
 1. jquery v1.10.2
 2. Twitter Bootstrap3 Library: http://getbootstrap.com/
 3. Moment.js: momentjs.com version : 2.4.0

 Slightly modified libraries:
 ----------------------------
 1. daterange picker: https://github.com/dangrossman/bootstrap-daterangepicker (attached file)
 2. datetimepicker: http://eonasdan.github.io/bootstrap-datetimepicker (attached file)

 */

var CustomDate = {

    $stOfWeek   : '',
    $enOfweek   : '',
    $date       : '',
    weekCounter : 0,
    dayCounter  : 0,

    dateSelector: function(ele, callback){

        var count = 0;
        var $sel = $(ele);
        this.$date = $sel.find('.date-val');


        this.$date.datetimepicker({ pickTime: false }).on("change.dp",function (e) {

            if (count == 0){
                var val = moment(e.date).format('MMMM DD, YYYY');
                this.$date.text(val);

                (typeof callback === 'function' ) ? callback(val) : '';
                count++;
            }else{
                count = 0;
            }

        }.bind(this));

        $sel.find('.prev').unbind('click').on('click', function(){
            this.dayCounter = -1;
            this.changeDate(callback);
        }.bind(this));

        $sel.find('.next').unbind('click').on('click', function(){
            this.dayCounter = 1;
            this.changeDate(callback);
        }.bind(this));

        this.currentDate(callback);
    },

    currentDate:function(callback){

        var val = moment().format('MMMM DD, YYYY')
        this.$date.text(val);

        (typeof callback === 'function' ) ? callback(val) : '';
    },

    changeDate: function(callback){

        var val = moment(this.$date.text()).add('day', this.dayCounter).format('MMMM DD, YYYY')
        this.$date.text(val);

        (typeof callback === 'function' ) ? callback(val) : '';
    },

    weekSelector: function(ele, callback){

        var $sel = $(ele);
        var count = 0;

        this.$stOfWeek = $sel.find('.st_week');
        this.$enOfweek = $sel.find('.en_week');
        this.$weekdate = $sel.find('.week-val');


        this.$weekdate.datetimepicker({ pickTime: false }).on("change.dp",function (e) {

            if (count == 0){
                var st = moment(moment(e.date).format('MMMM DD, YYYY')).startOf('week').format('MMMM DD, YYYY');
                var en = moment(moment(e.date).format('MMMM DD, YYYY')).endOf('week').format('MMMM DD, YYYY');
                this.setWeek(st,en);

                (typeof callback === 'function' ) ? callback(st,en) : '';
                count++;
            }else{
                count = 0;
            }

        }.bind(this));



        $sel.find('.prev').on('click', function(){

            this.weekCounter = -1;
            this.changeWeek(callback);

        }.bind(this));

        $sel.find('.next').on('click', function(){

            this.weekCounter = 1;
            this.changeWeek(callback);

        }.bind(this));

        this.currentWeek(callback);
    },

    currentWeek: function(){

        var st = moment().startOf('week').format('MMMM DD, YYYY');
        var en = moment().endOf('week').format('MMMM DD, YYYY');

        this.setWeek(st, en);
    },

    changeWeek: function(callback) {

        var st = moment(this.$stOfWeek.text()).add('week', this.weekCounter).startOf('week').format('MMMM DD, YYYY');
        var en = moment(this.$stOfWeek.text()).add('week', this.weekCounter).endOf('week').format('MMMM DD, YYYY');

        this.setWeek(st, en);
        (typeof callback === 'function' ) ? callback(st,en) : '';
    },

    setWeek: function(st, en){

        this.$stOfWeek.text(st);
        this.$enOfweek.text(en);
    },

    dateRangeSelector: function(ele, callback){

        var $sel = $(ele);

        $sel.find("#start_date").text(moment().startOf('month').format('MMMM DD, YYYY'));
        $sel.find("#end_date").text(moment().endOf('month').format('MMMM DD, YYYY'));

        $sel.find('.date-separator').daterangepicker({
                applyClass: 'btn-primary',
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                opens: "left"

            }, function(start, end) {

                $sel.find("#start_date").html(start.format('MMMM DD, YYYY'));
                $sel.find("#end_date").html(end.format('MMMM DD, YYYY'));

                (typeof callback === 'function' ) ? callback( start.format('MMMM DD, YYYY'), end.format('MMMM DD, YYYY')) : '';
            }
        );

        $sel.find("#end_date, #start_date").on('click', function(){

            $sel.find('.date-separator').click();
        });
    }

}