function construcGraphs(id, plotbands, analogiqueSeries2, sequenceSeries2, legendMarginTop, legendY, subtitle) {
    console.log(id);
    console.log("plotbands : " + plotbands);
    if (plotbands ==  null) {
        plotbands = "";
        console.log("plotbands : " + plotbands);
    }
    

    $(function () {

        /**
         * Create a global getSVG method that takes an array of charts as an
         * argument
         */
        Highcharts.getSVG = function (charts) {
            var svgArr = [],
                    top = 0,
                    width = 0;
            $.each(charts, function (i, chart) {
                var svg = chart.getSVG();
                svg = svg.replace('<svg', '<g transform="translate(0,' + top + ')" ');
                svg = svg.replace('</svg>', '</g>');


                top += chart.chartHeight;
                width = Math.max(width, chart.chartWidth);
                svgArr.push(svg);
            });
            top += 100;
            return '<svg height="' + top + '" width="' + width + '" version="1.1" xmlns="http://www.w3.org/2000/svg">' + svgArr.join('') + '</svg>';
        };
        /**
         * Create a global exportCharts method that takes an array of charts as an
         * argument, and exporting options as the second argument
         */
        Highcharts.exportCharts = function (charts, options) {

            // Merge the options
            options = Highcharts.merge(Highcharts.getOptions().exporting, options);
            // Post to export server
            Highcharts.post(options.url, {
                filename: options.filename || 'chart',
                type: options.type,
                width: options.width,
                svg: Highcharts.getSVG(charts)
            });
        };
        Highcharts.setOptions({
            lang: {
                months: [
                    'Janvier', 'Février', 'Mars', 'Avril',
                    'Mai', 'Juin', 'Juillet', 'Août',
                    'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ],
                weekdays: [
                    'Dimanche', 'Lundi', 'Mardi', 'Mercredi',
                    'Jeudi', 'Vendredi', 'Samedi'
                ],
                shortMonths: ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aout", "Sep", "Oct", "Nov", "Dec"]
            }
        });
//Color legend graph sequence
        (function (H) {
            H.Legend.prototype.getAllItems = function () {
                var allItems = [];
                H.each(this.chart.series, function (series) {
                    var seriesOptions = series && series.options;
                    if (typeof series !== 'undefined') {
                        if (series.type === 'xrange') {
                            series.color = series.userOptions.color
                        }
                        // Handle showInLegend. If the series is linked to another series,
                        // defaults to false.
                        if (series && H.pick(
                                seriesOptions.showInLegend,
                                !H.defined(seriesOptions.linkedTo) ? undefined : false, true
                                )) {

                            // Use points or series for the legend item depending on
                            // legendType
                            allItems = allItems.concat(
                                    series.legendItems ||
                                    (
                                            seriesOptions.legendType === 'point' ?
                                            series.data :
                                            series
                                            )
                                    );
                        }
                    }
                });
                H.fireEvent(this, 'afterGetAllItems', {allItems: allItems});
                return allItems;
            }
        })(Highcharts)

        Highcharts.seriesTypes.column.prototype.drawLegendSymbol =
                Highcharts.seriesTypes.line.prototype.drawLegendSymbol;


        var container_title = "Root Zone Soil Moisture Depletion:";
        var xrange_title = "Growth Stages";
        var chart1;
        var chart2;
        var chart3;
        var hasPlotBand = false;
//catch mousemove event and have all 3 charts' crosshairs move along indicated values on x axis

        function syncronizeCrossHairs(chart) {
            var container = $(chart.container),
                    offset = container.offset(),
                    x, y, isInside, report;
            container.mousemove(function (evt) {

                x = evt.clientX - chart.plotLeft - offset.left;
                y = evt.clientY - chart.plotTop - offset.top;
                var xAxis = chart.xAxis[0];
                //remove old plot line and draw new plot line (crosshair) for this chart
                var xAxis1 = chart1.xAxis[0];
                xAxis1.removePlotLine("myPlotLineId");
                xAxis1.addPlotLine({
                    value: chart.xAxis[0].translate(x, true),
                    width: 1,
                    color: 'gray',
                    //dashStyle: 'dash',                   
                    id: "myPlotLineId"
                });
                //remove old crosshair and draw new crosshair on chart2
                var xAxis2 = chart2.xAxis[0];
                xAxis2.removePlotLine("myPlotLineId");
                xAxis2.addPlotLine({
                    value: chart.xAxis[0].translate(x, true),
                    width: 1,
                    color: 'gray',
                    //dashStyle: 'dash',                   
                    id: "myPlotLineId"
                });
                //if you have other charts that need to be syncronized - update their crosshair (plot line) in the same way in this function.                   
            });
        }

        function syncExtremes(e) {
            var thisChart = this.chart;
            if (e.trigger !== 'syncExtremes') { // Prevent feedback loop
                Highcharts.each(Highcharts.charts, function (chart) {
                    if (chart !== thisChart) {
                        if (chart.xAxis[0].setExtremes) { // It is null while updating
                            chart.xAxis[0].setExtremes(e.min, e.max, undefined, false, {trigger: 'syncExtremes'});
                        }
                    }
                });
            }
        }



// Get the data. The contents of the data file can be viewed at
        var i = 0;
        for (var i = 0; i < 2; i++) {

            var chartDiv = document.createElement('div');
            chartDiv.className = 'chart';
            document.getElementById('container').appendChild(chartDiv);
            if (i === 0) {
                chart1 = Highcharts.chart(chartDiv, {

                    chart: {
                        type: 'line',
                        zoomType: 'x',
                        panning: true,
                        panKey: 'shift',
                    },
                    title: {
                        text: 'Run ' + id
                    },
                    subtitle: {
                        text: subtitle
                    },
                    xAxis: {
                        type: 'datetime',
                        plotBands: Function("return [" + plotbands + "]")(),
                        labels: {
                            enabled: false
                        },
                        maxZoom: 1000 * 60,
                        crosshair: true,
                        events: {
                            setExtremes: syncExtremes
                        }
                    },
                    yAxis: {
                        title: {
                            text: ''
                        },
                        gridLineWidth: 0,
                        minorGridLineWidth: 0
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        itemWidth: 160,
                    },
                    plotOptions: {
                        series: {
                            enabled: false,
                            turboThreshold: 10000, //set it to a larger threshold, it is by default to 1000
                            marker: {
                                enabled: false
                            }
                        }
                    }, tooltip: {

                        shared: true

                    },
                    series: Function("return [{" + analogiqueSeries2 + "}]")(),
                    exporting: {
                        sourceWidth: 1250,
                        sourceHeight: 500,
                        // scale: 2 (default)
                        chartOptions: {
                            subtitle: null
                        },
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    }


                }, function (chart) {
                    syncronizeCrossHairs(chart);
                });
            }
            if (i === 1) {
                chart2 = Highcharts.chart(chartDiv, {
                    chart: {
                        type: 'xrange',
                        zoomType: 'x',
                        panning: true,
                        panKey: 'shift',
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        type: 'datetime',
                        minTickInterval: 1000,
                        maxZoom: 1000 * 60,
                        crosshair: {
                            snap: false,
                            zIndex: 100
                        },
                        events: {
                            setExtremes: syncExtremes
                        }
                    },
                    yAxis: {

                        gridLineWidth: 0,
                        minorGridLineWidth: 0,
                        labels: {
                            enabled: false
                        },
                        categories: [''],
                        reversed: true
                    },
                    plotOptions: {
                        series: {
                            colorByPoint: true,
                            allowPointSelect: true,
                        }
                    },
                    legend: {
                        symbolHeight: 11,
                        symbolWidth: 15,
                        symbolRadius: 12,
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        itemWidth: 160,
                        y: legendY,
                        itemMarginTop: legendMarginTop,
                        itemStyle: {
                            color: '#000000',
                            fontWeight: 'bold',
                            fontSize: '12px'
                        }
                    }, tooltip: {
                        crosshairs: [true, false],
                        followPointer: true,
                        followTouchMove: true,
                        backgroundColor: '#FFFFFF',
                        crosshairs: {
                            width: 5
                        },
                    },
                    series: Function("return [{" + sequenceSeries2 + "}]")()
                            ,
                    exporting: {
                        sourceWidth: 1250,
                        sourceHeight: 500,
                        // scale: 2 (default)
                        chartOptions: {
                            subtitle: null
                        },
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    },
                }, function (chart) {
                    syncronizeCrossHairs(chart);
                });
            }
        }
   


        $('#export-pdf').click(function () {
            Highcharts.exportCharts([chart1, chart2], {
                type: 'application/pdf'
            });
        });
    });
}