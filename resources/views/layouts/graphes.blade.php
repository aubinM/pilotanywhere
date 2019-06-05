@include('includes.head')
<script src="/js/highcharts/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/xrange.js"></script>
<!-- optional -->
<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('includes.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('includes.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Graphe @if(isset($enregistrement->id)) {{$enregistrement->id}} @endif</h1>
                    </div>

                    <?php
                    $y = 0;
                    $analogiqueSeries = null;
                    $sequenceSeries = null;
                    $annee = null;
                    $mois = null;
                    $jour = null;
                    $heure = null;
                    $minute = null;
                    $seconde = null;

                    function random_color_part() {
                        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
                    }

                    function random_color() {
                        return random_color_part() . random_color_part() . random_color_part();
                    }

                    foreach ($materiels as $config) {
                        $code = $config->code;
                        echo $config->name;

                        if ($config->type == 2) {
                            $color = random_color();
                            $sequenceSeries .= "name: '" . $config->name . "',";
                            $sequenceSeries .= "pointWidth: 5,";
                            $sequenceSeries .= "color: '#" . $color . "',";
                            $sequenceSeries .= "data: [";
                            $date_debut = null;
                            $date_fin = null;
                            $date_fin_ok = false;
                            $y ++;



                            foreach ($enregistrement->stloup_pasteurisateur_standardisation_data as $datas) {
                                $date = new DateTime($datas->_date);


                                $annee = $date->format('Y');
                                $mois = $date->format('m') - 1;

                                $jour = $date->format('d');
                                $heure = $date->format('H');
                                $minute = $date->format('i');
                                $seconde = $date->format('s');
                                if ($mois[0] == "0") {
                                    $mois = substr($mois, 1);
                                }
                                if ($jour[0] == "0") {
                                    $jour = substr($jour, 1);
                                }
                                if ($heure[0] == "0") {
                                    $heure = substr($heure, 1);
                                }
                                if ($minute[0] == "0") {
                                    $minute = substr($minute, 1);
                                }
                                if ($seconde[0] == "0") {
                                    $seconde = substr($seconde, 1);
                                }

                                if ($datas->$code == 1 && is_null($date_debut)) {
                                    $date_debut = $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde;
                                    $date_fin = null;
                                    $date_fin_ok = false;
                                }

                                if ($datas->$code == 0 && !is_null($date_debut) && $date_fin_ok == 0) {
                                    $date_fin = $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde;
                                    $date_fin_ok = true;

                                    $sequenceSeries .= "{x: Date.UTC(" . $date_debut . "),x2: Date.UTC(" . $date_fin . "),y: " . $y . ",color: '#" . $color . "' },";
                                    $date_debut = null;
                                }
                            }
                            if (is_null($date_fin)) {
                                $date_fin = $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde;
                                $sequenceSeries .= "{x: Date.UTC(" . $date_debut . "),x2: Date.UTC(" . $date_fin . "),y: " . $y . "," . "color: '#" . $color . "'}";
                            }
                            $sequenceSeries .= "],}, {";
                        } else if ($config->type == 1) {
                            $analogiqueSeries .= "name: '" . $config->name . "',";
                            $analogiqueSeries .= "marker:{states:{hover:{enabled:false}}},";
                            $analogiqueSeries .= "data: [";



                            foreach ($enregistrement->stloup_pasteurisateur_standardisation_data as $datas) {
                                $date = new DateTime($datas->_date);
                                $annee = $date->format('Y');
                                $mois = $date->format('m') - 1;
                                $jour = $date->format('d');
                                $heure = $date->format('H');
                                $minute = $date->format('i');
                                $seconde = $date->format('s');
                                if ($mois[0] == "0") {
                                    $mois = substr($mois, 1);
                                }
                                if ($jour[0] == "0") {
                                    $jour = substr($jour, 1);
                                }
                                if ($heure[0] == "0") {
                                    $heure = substr($heure, 1);
                                }
                                if ($minute[0] == "0") {
                                    $minute = substr($minute, 1);
                                }
                                if ($seconde[0] == "0") {
                                    $seconde = substr($seconde, 1);
                                }
                                $analogiqueSeries .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->$code . "],";
                            }
                            $analogiqueSeries .= "]},{";
                        }
                    }
                    $sequenceSeries = rtrim($sequenceSeries, ',}, { ');
                    $analogiqueSeries = rtrim($analogiqueSeries, '},{');
                    //echo $sequenceSeries;
                    ?>

                    <div id="container" style="width:100%; height:400px;"></div>
                    <div id="container2" style="width:100%; height:400px;"></div>

                    <script>



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

(function (H) {
    H.Legend.prototype.getAllItems = function () {
        var allItems = [];
        H.each(this.chart.series, function (series) {
            var seriesOptions = series && series.options;
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
        });
        H.fireEvent(this, 'afterGetAllItems', {allItems: allItems});
        return allItems;
    }
})(Highcharts)

Highcharts.seriesTypes.column.prototype.drawLegendSymbol =
        Highcharts.seriesTypes.line.prototype.drawLegendSymbol;





$(function () {
    $('#container').bind('mouseleave mouseout ', function(e) {
    var chart,
      point,
      i,
      event;

    for (i = 0; i < Highcharts.charts.length; i = i + 1) {
      chart = Highcharts.charts[i];
      event = chart.pointer.normalize(e.originalEvent);
      point = chart.series[0].searchPoint(event, true);

      point.onMouseOut(); 
      chart.tooltip.hide(point);
      chart.xAxis[0].hideCrosshair(); 
    }
  });

    /**
     * In order to synchronize tooltips and crosshairs, override the
     * built-in events with handlers defined on the parent element.
     */
    $('#container').bind('mousemove touchmove touchstart', function (e) {
        var chart,
                point,
                i,
                event;
        for (i = 0; i < Highcharts.charts.length; i = i + 1) {
            chart = Highcharts.charts[i];
            event = chart.pointer.normalize(e.originalEvent); // Find coordinates within the chart
            point = chart.series[0].searchPoint(event, true); // Get the hovered point

            if (point) {
                point.highlight(e);
            }
        }
    });
    /**
     * Override the reset function, we don't need to hide the tooltips and crosshairs.
     */
    Highcharts.Pointer.prototype.reset = function () {
        return undefined;
    };
    /**
     * Highlight a point by showing tooltip, setting hover state and draw crosshair
     */
    Highcharts.Point.prototype.highlight = function (event) {
        this.onMouseOver(); // Show the hover marker
        this.series.chart.tooltip.refresh(this); // Show the tooltip
        this.series.chart.xAxis[0].drawCrosshair(event, this); // Show the crosshair
    };
    /**
     * Synchronize zooming through the setExtremes event handler.
     */
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

// Get the data. The contents of the data file can be viewed at
    var i = 0;
    for (var i = 0; i < 2; i++) {

        console.log(i);
        // Add X values
//            dataset.data = Highcharts.map(dataset.data, function (val, j) {
//                return [activity.xData[j], val];
//            });
        //document.getElementById("whereToPrint").innerHTML = JSON.stringify(dataset.data, null, 4);

        var chartDiv = document.createElement('div');
        chartDiv.className = 'chart';
        document.getElementById('container').appendChild(chartDiv);
        if (i === 0) {
            Highcharts.chart(chartDiv, {

                chart: {
                    renderTo: 'container2',
                    zoomType: 'x'
                },
                title: {
                    text: 'Run ' + <?php echo $enregistrement->id ?>
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                            'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        enabled: false
                    },
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
                    x:-45
                    
                },
                plotOptions: {
                    series: {enabled: false,
                        marker: {
                            enabled: false
                        }
                    }
                },tooltip: {
                    
                        shared: true,
                        
                        
                        
                        
                    },
                series: [{
<?php echo $analogiqueSeries; ?>
                    }]


            });
        }
        if (i === 1) {
            Highcharts.chart(chartDiv, {
                chart: {
                    renderTo: 'container2',
                    type: 'xrange',
                    zoomType: 'x'

                },
                title: {
                    text: ''
                },
                xAxis: {
                    type: 'datetime',
                    tickInterval: 1000 * 60 * 15,
                    crosshair: true,
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
                    verticalAlign: 'middle'
                }, tooltip: {
                    
                },
                series: [{
<?php echo $sequenceSeries; ?>
                    }]
            });
        }
    }



});











                    </script>



                </div>
                <!-- /.container-fluid -->


            </div>
            <!-- End of Main Content -->

            @include('includes.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    @include('includes.bottom_scripts')







</body>

</html>





