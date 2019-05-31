@include('includes.head')
<script src="/js/highcharts/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/xrange.js"></script>
<!-- optional -->
<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>

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
                    $debit_envoi = "";
                    $debit_retour = "";
                    $temp_retour = "";
                    $conductivite_retour = "";
                    $temp_cuve_soude = "";
                    $conductivite_cuve_soude = "";
                    $niveau_cuve_soude = "";
                    $temp_cuve_acide = "";
                    $conductivite_cuve_acide = "";
                    $niveau_cuve_acide = "";
                    $pression_envoi = "";
                    $turbidite_retour = "";

                    foreach ($enregistrement->stloup_pasteurisateur_standardisation_data as $datas) {
                        $date = new DateTime($datas->_date);
                        $annee = $date->format('Y');
                        $mois = $date->format('m') - 1;
                        $jour = $date->format('d');
                        $heure = $date->format('H');
                        $minute = $date->format('i');
                        $seconde = $date->format('s');
                        $debit_envoi .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Debit_Envoi . "],";
                        $debit_retour .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Debit_Retour . "],";
                        $conductivite_retour .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Conductivite_Retour . "],";
                        $temp_cuve_soude .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Temp_Cuve_Soude . "],";
                        $conductivite_cuve_soude .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Conductivite_Cuve_Soude . "],";
                        $niveau_cuve_soude .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Niveau_Cuve_Soude . "],";
                        $temp_cuve_acide .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Temp_Cuve_Acide . "],";
                        $conductivite_cuve_acide .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Conductivite_Cuve_Acide . "],";
                        $niveau_cuve_acide .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Niveau_Cuve_Acide . "],";
                        $turbidite_retour .= "[Date.UTC(" . $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde . ")," . $datas->Turbidite_Retour . "],";
                    }
                    ?>

                    <div id="container1" style="width:100%; height:400px;"></div>
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


                        var chart1 = new Highcharts.Chart({
                            chart: {
                                renderTo: 'container1',
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
                                type: 'datetime'
                            },
                            yAxis: {
                                title: {
                                    text: 'Valeur'
                                }
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            plotOptions: {
                                series: {
                                    marker: {
                                        enabled: false
                                    }
                                }
                            }, tooltip: {
                                crosshairs: [true],
                                shared: true
                            },

                            series: [{

                                    name: 'Debit Envoi',
                                    data: [
                        <?php echo $debit_envoi; ?>
                                    ]
                                }, {

                                    name: 'Debit Retour',
                                    data: [
                        <?php echo $debit_retour; ?>
                                    ]
                                }, {

                                    name: 'Conductivite Retour',
                                    data: [
                        <?php echo $conductivite_retour; ?>
                                    ]
                                }, {

                                    name: 'Temp Retour',
                                    data: [
                        <?php echo $temp_retour; ?>
                                    ]
                                }, {

                                    name: 'Temp Cuve Soude',
                                    data: [
                        <?php echo $temp_cuve_soude; ?>
                                    ]
                                }, {

                                    name: 'Conductivite Cuve Soude',
                                    data: [
                        <?php echo $conductivite_cuve_soude; ?>
                                    ]
                                }, {

                                    name: 'Niveau Cuve Soude',
                                    data: [
                        <?php echo $niveau_cuve_soude; ?>
                                    ]
                                }, {

                                    name: 'Temp Cuve Acide',
                                    data: [
                        <?php echo $temp_cuve_acide; ?>
                                    ]
                                }, {

                                    name: 'Conductivite Cuve Acide',
                                    data: [
                        <?php echo $conductivite_cuve_acide; ?>
                                    ]
                                }, {

                                    name: 'Niveau Cuve Acide',
                                    data: [
                        <?php echo $niveau_cuve_acide; ?>
                                    ]
                                }, {

                                    name: 'Pression Envoi',
                                    data: [
                        <?php echo $pression_envoi; ?>
                                    ]
                                }, {

                                    name: 'Turbidite Retour',
                                    data: [
                        <?php echo $turbidite_retour; ?>
                                    ]
                                }],
                            exporting: {
                                enabled: true,
                                sourceWidth: 2000,
                                sourceHeight: 200,
                                // scale: 2 (default)
                                chartOptions: {
                                    subtitle: null
                                }
                            }

                        });

                        var chart2 = new Highcharts.chart({
                            chart: {
                                renderTo: 'container2',
                                type: 'xrange'
                            },
                            title: {
                                text: 'Highcharts X-range'
                            },
                            xAxis: {
                                type: 'datetime'
                            },
                            yAxis: {
                                title: {
                                    text: ''
                                },
                                categories: ['envoi_eau_neuve','x'],
                                reversed: true
                            }, tooltip: {
                                crosshairs: [true],
                                shared: true
                            },
                            series: [{
                                    name: 'Project 1',
                                    // pointPadding: 0,
                                    // groupPadding: 0,
                                    borderColor: 'gray',
                                    pointWidth: 5,
                                    data: [
                                        <?php
                                        $date_debut = null;
                                        $date_fin = null;
                                        $date_fin_ok = 0;
                                        foreach ($enregistrement->stloup_pasteurisateur_standardisation_data as $datas) {
                                            $date = new DateTime($datas->_date);
                                            $annee = $date->format('Y');
                                            $mois = $date->format('m') - 1;
                                            $jour = $date->format('d');
                                            $heure = $date->format('H');
                                            $minute = $date->format('i');
                                            $seconde = $date->format('s');
                                            
                                           
                                                if($datas->envoi_eau_neuve == 1 && is_null($date_debut))
                                                {
                                                    $date_debut = $annee.",".$mois.",".$jour.",".$heure.",".$minute.",".$seconde;
                                                    $date_fin_ok = 0;
                                                     
                                                }
                                                
                                                if($datas->envoi_eau_neuve == 0 && !is_null($date_debut) && $date_fin_ok == 0)
                                                {
                                                    $date_fin = $annee.",".$mois.",".$jour.",".$heure.",".$minute.",".$seconde;
                                                    $date_fin_ok = 1;
                                                    echo "{x: Date.UTC(".$date_debut."),x2: Date.UTC(".$date_fin."),y: 0},"; 
                                                    $date_debut = null;
                                                }
                                                
                                                
                                        }
                                        if(is_null($date_fin)){
                                            $date_fin = $annee.",".$mois.",".$jour.",".$heure.",".$minute.",".$seconde;
                                            echo "{x: Date.UTC(".$date_debut."),x2: Date.UTC(".$date_fin."),y: 0},";
                                        }
                                        
                                        
                                        ?>
                                            
                                       ]
                                    
                                }]

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





