@include('includes.head')
<script src="/js/highcharts/highcharts.js"></script>
<script src="/js/highcharts/modules/boost.js"></script>
<script src="/js/highcharts/modules/exporting.js"></script>
<script src="/js/highcharts/modules/xrange.js"></script>
<!-- optional -->
<script src="/js/highcharts/modules/offline-exporting.js"></script>
<script src="/js/highcharts/modules/export-data.js"></script>
<script src="/js/highcharts/modules/data.js"></script>
<script src="/js/jquery-3.4.0.min.js"></script>

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
                    $current_config = 0;
                    $analogiqueSeries = null;
                    $analogiqueSeriesData = array();
                    $sequenceSeries = null;
                    $sequenceSeriesData = array();
                    $sequenceDates = array();
                    $plotbands = null;
                    $annee = null;
                    $mois = null;
                    $jour = null;
                    $heure = null;
                    $minute = null;
                    $seconde = null;

                    $dates_alarmes = array();
                    $en_attente = array();
                    foreach ($all_alarmes as $alarme) {
                        $dates_alarmes[$alarme->id . "debut"] = null;
                        $dates_alarmes[$alarme->id . "fin"] = null;
                    }

                    function random_color_part() {
                        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
                    }

                    function random_color() {
                        return random_color_part() . random_color_part() . random_color_part();
                    }

                    foreach ($materiels as $config) {
                        if ($config->type == 1) {
                            $analogiqueSeriesData[$config->code] = null;
                        } else if ($config->type == 2) {
                            $sequenceSeriesData[$config->code] = null;
                            $sequenceDates[$config->code."date_debut"] = null;
                            $sequenceDates[$config->code."date_fin"] = null;
                            $sequenceDates[$config->code."date_fin_ok"] = null;
                            $sequenceDates[$config->code."color"] = random_color();;
                        }
                    }

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
                        $alarmes = explode(",", $datas->alarmes);
                        $display = null;




                        foreach ($all_alarmes as $all_alarme) {

                            if (in_array($all_alarme->id, $alarmes) && is_null($dates_alarmes[$all_alarme->id . "debut"])) {

                                $dates_alarmes[$all_alarme->id . "debut"] = 'Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . ')';
                                //echo"La date debut de l'alarme " . $all_alarme->id . "est  : " . $dates_alarmes[$all_alarme->id . "debut"];
                            }

                            if (!in_array($all_alarme->id, $alarmes) && !is_null($dates_alarmes[$all_alarme->id . "debut"])) {
                                $dates_alarmes[$all_alarme->id . "fin"] = 'Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . ')';
                                if ($all_alarme->critical_level == 1) {
                                    $colorBand = '#FF7F50';
                                    $plotbands .= '{color: \'' . $colorBand . '\',from: ' . $dates_alarmes[$all_alarme->id . "debut"] . ',to: ' . $dates_alarmes[$all_alarme->id . "fin"] . ',},';
                                } else {
                                    $colorBand = '#ff4040';
                                    array_push($en_attente, '{color: \'' . $colorBand . '\',from: ' . $dates_alarmes[$all_alarme->id . 'debut'] . ',to: ' . $dates_alarmes[$all_alarme->id . 'fin'] . ',},');
                                }
                                //echo"La date fin de l'alarme " . $all_alarme->id . "est  : " . $dates_alarmes[$all_alarme->id . "fin"];
                                $dates_alarmes[$all_alarme->id . 'debut'] = null;
                            }


                            if (is_null($dates_alarmes[$all_alarme->id . 'fin']) && $enregistrement->stloup_pasteurisateur_standardisation_data->last()->is($datas) && in_array($all_alarme->id, $alarmes)) {
                                $dates_alarmes[$all_alarme->id . 'fin'] = 'Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . ')';
                                if ($all_alarme->critical_level == 1) {
                                    $colorBand = '#FF7F50';
                                    $plotbands .= '{color: \'' . $colorBand . '\',from: ' . $dates_alarmes[$all_alarme->id . 'debut'] . ',to: ' . $dates_alarmes[$all_alarme->id . 'fin'] . ',},';
                                } else {
                                    $colorBand = '#ff4040';
                                    array_push($en_attente, '{color: \'' . $colorBand . '\',from: ' . $dates_alarmes[$all_alarme->id . 'debut'] . ',to: ' . $dates_alarmes[$all_alarme->id . 'fin'] . ',},');
                                }
                                //echo"La date fin de l'alarme " . $all_alarme->id . "est  : " . $dates_alarmes[$all_alarme->id . "fin"];
                                $dates_alarmes[$all_alarme->id . 'debut'] = null;
                            }
                        }



                        foreach ($alarmes as $alarme) {
                            foreach ($all_alarmes as $all_alarme) {
                                if ($alarme == $all_alarme->id) {
                                    if ($all_alarme->critical_level == 1) {
                                        $display .= '<p style=\"color:#FF7F50\";>' . $all_alarme->name . '<br\>';
                                    } else {
                                        $display .= '<p style=\"color:#ff4040\";>' . $all_alarme->name . '<br\>';
                                    }
                                }
                            }
                        }
                        $y = 0;
                        $current_config = 0;
                        
                        foreach ($materiels as $config) {
                            $current_config++;
                            
                            $code = $config->code;
                            //echo $code;
                            
                            if ($config->type == 1) {
                                echo  $current_config;
                                if ($current_config == 2) {
                                    
                                    $analogiqueSeriesData[$config->code] = $analogiqueSeriesData[$config->code] . '{x: Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . '), y : ' . $datas->$code . ', myData : \'' . $display . '\'},';
                                } else {
                                    $analogiqueSeriesData[$config->code] = $analogiqueSeriesData[$config->code] . '{x: Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . '), y : ' . $datas->$code . ', myData : \'\'},';
                                }
                            }


                            if ($config->type == 2) {
                                $y++;
                                
                                if ($datas->$code == 1 && is_null($sequenceDates[$config->code."date_debut"])) {
                                    $sequenceDates[$config->code."date_debut"] = $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde;
                                    $sequenceDates[$config->code."date_fin"] = null;
                                    $sequenceDates[$config->code."date_fin_ok"] = false;
                                }

                                if ($datas->$code == 0 && !is_null($sequenceDates[$config->code."date_debut"]) && $sequenceDates[$config->code."date_fin_ok"] == 0) {
                                    $sequenceDates[$config->code."date_fin"] = $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde;
                                    $sequenceDates[$config->code."date_fin_ok"] = true;
                                    //echo $y." ".$config->code."| ";

                                    $sequenceSeriesData[$config->code] .= '{x: Date.UTC(' . $sequenceDates[$config->code."date_debut"] . '),x2: Date.UTC(' . $sequenceDates[$config->code."date_fin"] . '),y: ' . $y . ',color: \'#' . $sequenceDates[$config->code."color"] . '\' },';
                                    $sequenceDates[$config->code."date_debut"] = null;
                                    $sequenceDates[$config->code."date_fin"] = null;
                                }
                            }
                        }
                    }
                    $y = 0;
                    foreach ($materiels as $config) {
                        if ($current_config == 1) {
                            foreach ($en_attente as $attente) {
                                $plotbands .= $attente;
                            }
                        }


                        if ($config->type == 1) {
                            $analogiqueSeriesData[$config->code] .= ']},{';
                        }
                        if ($config->type == 2) {
                            $y++;

                            if (is_null($sequenceDates[$config->code."date_fin"])) {
                                $sequenceDates[$config->code."date_fin"] = $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde;
                                $sequenceSeriesData[$config->code] .= '{x: Date.UTC(' . $sequenceDates[$config->code."date_debut"] . '),x2: Date.UTC(' .  $sequenceDates[$config->code."date_fin"]. '),y: ' . $y . ',' . 'color: \'#' . $sequenceDates[$config->code."color"] . '\'}';
                            }
                             $sequenceSeriesData[$config->code] .= '],}, {';
                        }
                    }

                    foreach ($materiels as $config) {


                        if ($config->type == 1) {
                            //$analogiqueSeriesData[$config->code] = rtrim($analogiqueSeriesData[$config->code], '},{');
                            $analogiqueSeries .= 'name: \'' . $config->name . '\',';
                            $analogiqueSeries .= 'marker:{states:{hover:{enabled:false}}},';
                            $analogiqueSeries .= 'tooltip: {pointFormatter: function () {return this.myData +\'<br\><span style=\"color:\' + this.color + \'\">\u25CF</span> \' + this.series.name + \': <b>\' + this.y + \'</b><br/>\';}},';
                            $analogiqueSeries .= 'data: [';
                            $analogiqueSeries .= $analogiqueSeriesData[$config->code];
                        } else if ($config->type == 2) {
                            //$sequenceSeriesData[$config->code] = rtrim($sequenceSeriesData[$config->code], ',}, { ');

                            $sequenceSeries .= 'name: \'' . $config->name . '\',';
                            $sequenceSeries .= 'pointWidth: 5,';
                            $sequenceSeries .= 'color: \'#' . $sequenceDates[$config->code."color"] . '\',';
                            $sequenceSeries .= 'data: [';
                            $sequenceSeries .= $sequenceSeriesData[$config->code];
                        }
                    }

                    $sequenceSeries2 = rtrim($sequenceSeries, ',}, { ');
                    $analogiqueSeries2 = rtrim($analogiqueSeries, '},{');
                    echo $analogiqueSeries2;
//                    echo $sequenceSeries2;
                    //  dd($analogiqueSeriesData);

                    $legendMarginTop = null;
                    $legendY = 0;

                    switch ($y) {
                        case 1:
                            $legendMarginTop = 125;
                            $legendY = 15;
                            break;
                        case 2:
                            $legendMarginTop = 65;
                            $legendY = 15;
                            break;
                        case 3:
                            $legendMarginTop = 53;
                            $legendY = 5;
                            break;
                        case 4:
                            $legendMarginTop = 42;
                            $legendY = 5;
                            break;
                        case 5:
                            $legendMarginTop = 34;
                            $legendY = 2;
                            break;
                        case 6:
                            $legendMarginTop = 22;
                            $legendY = 1;
                            break;
                        case 7:
                            $legendMarginTop = 22;
                            break;
                        case 8:
                            $legendMarginTop = 19;
                            break;
                        case 9:
                            $legendMarginTop = 15;
                            break;
                        case 10:
                            $legendMarginTop = 12.5;
                            break;
                        case 11:
                            $legendMarginTop = 10;
                            break;
                        case 12:
                            $legendMarginTop = 8;
                            break;
                        case 13:
                            $legendMarginTop = 6;
                            break;
                        case 14:
                            $legendMarginTop = 4.5;
                            break;
                        case 15:
                            $legendMarginTop = 3.5;
                            break;
                        case 16:
                            $legendMarginTop = 2;
                            break;
                        case 17:
                            $legendMarginTop = 1;
                            break;
                        case 18:
                            $legendMarginTop = 0;
                            break;
                        case 19:
                            $legendMarginTop = -0.8;
                            break;
                        case 20:
                            $legendMarginTop = -1.5;
                            break;
                        case 21:
                            $legendMarginTop = -2.4;
                            break;
                        case 22:
                            $legendMarginTop = -2.9;
                            break;
                        case 23:
                            $legendMarginTop = -3.6;
                            break;
                        case 24:
                            $legendMarginTop = -4.2;
                            break;
                    }
                    ?>
                    <nav aria-label="Page navigation example">


                        <ul class="pagination d-flex justify-content-between">


                            @if($enregistrement->id-1 < 1)
                            <a href="{{$enregistrement->id-1 > 0 ? route('graphes.show', $enregistrement->id-1) : ""}}" class="btn btn-primary disabled btn-sm" role="button" >Précédent</a>
                            @else 
                            <a href="{{$enregistrement->id-1 > 0 ? route('graphes.show', $enregistrement->id-1) : ""}}" class="btn btn-primary  btn-sm" role="button">Précédent</a>
                            @endif



                            </li>

                            <li><button id="export-pdf" class="btn btn-primary"><i class="fas fa-print"></i></button></li>
                            <li>

                                @if(is_null($enregistrement->commentaire))
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="{{$enregistrement->id}}" data-whatever="{{$enregistrement->commentaire}}">
                                    <i class="far fa-comment-alt"></i>
                                </button>
                                @else 
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="{{$enregistrement->id}}" data-whatever="{{$enregistrement->commentaire}}" >
                                    @php

                                    $enregistrement_commentaire = [];
                                    array_push($enregistrement_commentaire,$enregistrement->commentaire);

                                    echo '<i class="fas fa-comment-alt" data-toggle="tooltip" data-html="true" title="'.implode("<br>",$enregistrement_commentaire).'"></i>';

                                    @endphp
                                </button>
                                <p hidden>{{$enregistrement->commentaire}}</p>

                                @endif

                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Commentaire</h5>

                                            </div>
                                            <div class="modal-body">
                                                {!! Form::model($enregistrement, ['method'=>'PATCH', 'action'=> ['GraphsController@update', $enregistrement->id]]) !!}

                                                <div class="form-group">

                                                    <input type="hidden" name="comment_id" id="hiddenValue" value="" />

<!--                                                                            <textarea class="form-control" id="comment"></textarea>-->


                                                    {!! Form::textarea('comment', null, ['class'=>'form-control' , 'rows' => 3, 'id'=>'comment' ,'placeholder' => 'Ecrivez votre commentaire..'])!!}
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary no_print" data-dismiss="modal">Fermer</button>
                                                {!! Form::submit('Mettre à jour', ['class'=>'btn btn-primary']) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </li>


                            @if($enregistrement->id+1 > $enregistrement_last_id)
                            <a href="{{$enregistrement->id+1 > 0 ? route('graphes.show', $enregistrement->id+1) : ""}}" class="btn btn-primary disabled btn-sm" role="button" >Suivant</a>
                            @else 
                            <a href="{{$enregistrement->id+1 > 0 ? route('graphes.show', $enregistrement->id+1) : ""}}" class="btn btn-primary  btn-sm"  >Suivant</a>
                            @endif

                            </li>
                        </ul>


                    </nav>

                    <div id="container"></div>


                    <script>






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
                    text: 'Run ' + <?php echo $enregistrement->id ?>
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                            'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime',
                    plotBands: [<?php echo $plotbands ?>],
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
                series: [{
<?php echo $analogiqueSeries2; ?>
                    }],
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
                    y: <?php echo $legendY; ?>,
                    itemMarginTop: <?php echo $legendMarginTop; ?>,
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
                series: [{
<?php echo $sequenceSeries2; ?>
                    }],
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
//    chart1.reflow();
//    chart2.reflow();



    $('#export-pdf').click(function () {
        Highcharts.exportCharts([chart1, chart2], {
            type: 'application/pdf'
        });
    });
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
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var comment = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-body #comment').val(comment)

        })


        $('#exampleModal').on('show.bs.modal', function (event) {
            var my_id_value = $(event.relatedTarget).data('id');
            $(".modal-body #hiddenValue").val(my_id_value);
        })
    </script>







</body>

</html>





