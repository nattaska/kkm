(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "dashboard";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        // --------- Report Range ------------- //
        var start = moment().subtract(8, 'days');
        var end = moment().subtract(1, 'days');

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // console.log(start.format('YYYY-MM-DD')+ ' - ' + end.format('YYYY-MM-DD'));  
            profitSummary(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            profitDetails(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        function profitSummary(start, end) {
            $.post(module+"/xhrProfitSummary", {"sdate":start, "edate":end}, function(o) {
                $("#sumsale").text(parseInt(o.sale));
                $("#sumbuff").text(parseInt(o.buff));
                $("#sumexp").text(parseInt(o.expense));
                $("#sumprofit").text(parseInt(o.sale) + parseInt(o.buff) - parseInt(o.expense));      
            },'json');
        }

        function profitDetails(start, end) {

            // Traffic Chart using chartist
            if ($('#traffic-chart').length) {
                var pdate = [];
                var income = [];
                var expense = [];            

                $.post(module+"/xhrGetProfitDetails", {"sdate":start, "edate":end}, function(o) {
                    // console.log(o);

                    for (var i=0; i<o.length; i++) {
                        pdate.push(o[i].date_x);
                        income.push(parseInt(o[i].rvamt)+parseInt(o[i].bfamt));
                        expense.push(o[i].expamt);
                    }
                    
                }, 'json');

                var datas = [];
                datas.push(income);
                datas.push(expense);
                // console.log(income);
                // console.log(expense);
                // console.log(pdate);

                var chart = new Chartist.Line('#traffic-chart', {
                        // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        labels: pdate,
                        series: datas
                    }, {
                        low: 0,
                        showArea: true,
                        // showLine: false,
                        // showPoint: false,
                        fullWidth: true,
                        axisX: {
                            showGrid: true
                        }
                    });

                chart.on('draw', function(data) {
                    if(data.type === 'line' || data.type === 'area') {
                        data.element.animate({
                            d: {
                                begin: 2000 * data.index,
                                dur: 2000,
                                from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                                to: data.path.clone().stringify(),
                                easing: Chartist.Svg.Easing.easeOutQuint
                            }
                        });
                    }
                });
            }
        }

    });
  
  }(jQuery));
