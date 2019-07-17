(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "dashboard";
        var disabled = ($('#auth').val()==='R'?'disabled':'');
        var xx = [
            [0, 18000, 35000,  25000,    0],
            [0, 33000, 15000,  20000],
            [0, 15000, 28000,  15000,    5000]
            ];
        var date = new Date();
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
        var days = [];
        // console.log(xx);
        // console.log(lastDay);

        for (let i = 0; i < lastDay; i++) { 
            days.push(i+1) ;
        } 
        // console.log(days);

        

        // Traffic Chart using chartist
        if ($('#traffic-chart').length) {
            var pdate = [];
            var income = [];
            var expense = [];            

            $.post(module+"/xhrGetProfitAllDays", function(o) {
                // console.log(o);

                for (var i=0; i<o.length; i++) {
                    pdate.push(o[i].date_field);
                    income.push(parseInt(o[i].rvamt)+parseInt(o[i].bfamt));
                    expense.push(o[i].expamt);
                }
                
            }, 'json');

            // console.log(pdate);
            // console.log(income);
            // console.log(expense);

            var xxx = [];
            xxx.push(income);
            xxx.push(expense);
            // console.log(xxx);

            var chart = new Chartist.Line('#traffic-chart', {
                    // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    labels: days,
                    series: xxx
                }, {
                    low: 0,
                    showArea: true,
                    showLine: false,
                    showPoint: false,
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
        // Traffic Chart using chartist End

        //Traffic chart chart-js
        // if ($('#TrafficChart').length) {
        //     var ctx = document.getElementById( "TrafficChart" );
        //     ctx.height = 150;
        //     var myChart = new Chart( ctx, {
        //         type: 'line',
        //         data: {
        //             labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul" ],
        //             datasets: [
        //             {
        //                 label: "Visit",
        //                 borderColor: "rgba(4, 73, 203,.09)",
        //                 borderWidth: "1",
        //                 backgroundColor: "rgba(4, 73, 203,.5)",
        //                 data: [ 0, 2900, 5000, 3300, 6000, 3250, 0 ]
        //             },
        //             {
        //                 label: "Bounce",
        //                 borderColor: "rgba(245, 23, 66, 0.9)",
        //                 borderWidth: "1",
        //                 backgroundColor: "rgba(245, 23, 66,.5)",
        //                 pointHighlightStroke: "rgba(245, 23, 66,.5)",
        //                 data: [ 0, 4200, 4500, 1600, 4200, 1500, 4000 ]
        //             },
        //             {
        //                 label: "Targeted",
        //                 borderColor: "rgba(40, 169, 46, 0.9)",
        //                 borderWidth: "1",
        //                 backgroundColor: "rgba(40, 169, 46, .5)",
        //                 pointHighlightStroke: "rgba(40, 169, 46,.5)",
        //                 data: [1000, 5200, 3600, 2600, 4200, 5300, 0 ]
        //             }
        //             ]
        //         },
        //         options: {
        //             responsive: true,
        //             tooltips: {
        //                 mode: 'index',
        //                 intersect: false
        //             },
        //             hover: {
        //                 mode: 'nearest',
        //                 intersect: true
        //             }

        //         }
        //     } );
        // }
        //Traffic chart chart-js  End

    });
  
  }(jQuery));
