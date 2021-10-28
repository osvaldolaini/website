var App_charts = function () {
    let first = function(){
        $.ajax({
            //busca eventos
            url: APP_URL + '/charts/first',
            dataType: 'json',
            type : "GET",
            success: function (response) {
                //console.log(response)
                Highcharts.chart('first', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: response.labels
                    },
                    yAxis: {
                        title: {
                            text: 'Visualizações'
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
                        name: 'Vies',
                        data: response.views
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
                //console.log(response)
                Highcharts.chart('second', {
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
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Aparelho',
                        colorByPoint: true,
                        data: response.data
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

    return{
      init: function(){
        first()
        second()
        third()
        //four()
      }
    }
  }()

  jQuery(document).ready(function(){
    App_charts.init();
  })
