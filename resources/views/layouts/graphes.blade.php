@include('includes.head')

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

                        @php 
                        $debit_envoi = array();
                        $date_debut = $enregistrement->date_debut;
                        foreach($enregistrement->stloup_pasteurisateur_standardisation_data as $datas){
                        $debit_envoi[$datas->_date]=$datas->Debit_Envoi;
                        }

                        $debit_envoi_json = json_encode($debit_envoi);

                        @endphp


                    </div>

                    <div id="container" style="width:100%; height:400px;"></div>

                    <script>

<?php ?>












                        var debit_envoi = JSON.parse('<?= $debit_envoi_json; ?>');



                        document.addEventListener('DOMContentLoaded', function () {


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


                            Highcharts.chart('container', {
                                chart: {
                                    zoomType: 'x'
                                },
                                title: {
                                    text: 'Run ' + <?php echo $enregistrement->id?> 
                                },
                                subtitle: {
                                    text: document.ontouchstart === undefined ?
                                            'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                                },
                                xAxis: {
                                    type: 'datetime'
                                },
                                yAxis: {
                                    title: {
                                        text: 'Exchange rate'
                                    }
                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    area: {
                                        fillColor: {
                                            linearGradient: {
                                                x1: 0,
                                                y1: 0,
                                                x2: 0,
                                                y2: 1
                                            },
                                            stops: [
                                                [0, Highcharts.getOptions().colors[0]],
                                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                            ]
                                        },
                                        marker: {
                                            radius: 2
                                        },
                                        lineWidth: 1,
                                        states: {
                                            hover: {
                                                lineWidth: 1
                                            }
                                        },
                                        threshold: null
                                    }
                                },

                                series: [{

                                        name: 'Debit Envoi',
                                        data: [
                                        <?php
                                        date_default_timezone_set('Europe/Paris');


                                        foreach ($enregistrement->stloup_pasteurisateur_standardisation_data as $datas) {
                                            setlocale(LC_TIME, "fr_FR");
                                            $date = new DateTime($datas->_date);
                                            $annee = $date->format('Y');
                                            $mois = $date->format('m') - 1;
                                            $jour = $date->format('d');
                                            $heure = $date->format('H');
                                            $minute = $date->format('i');
                                            $seconde = $date->format('s');
                                            echo "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Debit_Envoi . "],";
                                        }
                                        ?>

                                        ]
                                    }]
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
    <script src="/js/highcharts/highcharts.js"></script>





</body>

</html>





