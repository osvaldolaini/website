var App_charts = function () {
    let first = function(){
        $.ajax({
            //busca eventos
            url: APP_URL + '/charts/first',
            dataType: 'json',
            type : "GET",
            success: function (response) {
                Highcharts.chart('first', {
                    colors:['#28a745','#dc3545'],
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: response.labels,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'R$ '
                        }
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>R$ ' +
                                parseFloat(this.point.y).toFixed(2).replace('.', ','); + ' ' + this.point.name.toLowerCase();
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Receitas',
                        data: response.enter

                    }, {
                        name: 'Despesas',
                        data: response.out
                    }]
                });
            }
        })
    }
    let second = function(){
        $.ajax({
            //busca eventos
            url: APP_URL + '/charts/second',
            dataType: 'json',
            type : "GET",
            success: function (response) {
                console.log(response)
                Highcharts.chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Monthly Average Temperature'
                    },
                    subtitle: {
                        text: 'Source: WorldClimate.com'
                    },
                    xAxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    },
                    yAxis: {
                        title: {
                            text: 'Temperature (°C)'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [{
                        name: 'Tokyo',
                        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                    }, {
                        name: 'London',
                        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                    }]
                });

            },
            error: function (response) {
                console.log(response)
            }
        })
    }
    let third = function(){
        $.ajax({
            //busca eventos
            url: APP_URL + '/charts/third',
            dataType: 'json',
            type : "GET",
            success: function (response) {
                Highcharts.chart('third', {
                    colors:response.color,
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b style="font-size:8pt;">{point.name}</b>: {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Porcentagem',
                        colorByPoint: true,
                        data: response.name
                    }]
                });
            },
        })
    }
    let four = function(){
        $.ajax({
            //busca eventos
            url: APP_URL + '/charts/four',
            dataType: 'json',
            type : "GET",
            success: function (response) {
                console.log(response)
                Highcharts.chart('four', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b style="font-size:8pt;">{point.name}</b>: {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Porcentagem',
                        colorByPoint: true,
                        data: response.name
                    }]
                });
            },
            error: function (response) {
                console.log(response)
            }
        })
    }
    return{
      init: function(){
        //first()
        second()
        //third()
        //four()
      }
    }
  }()

  jQuery(document).ready(function(){
    App_charts.init();
  })
