  <script>
                        $(function () {
                        var chart;
                                $(document).ready(function() {


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
                                var graphe_analogique = new Highcharts.chart('container', {
                                chart: {
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
                                var graphe_booleen = newHighcharts.chart('container', {
                                chart: {
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
                                                categories: ['Prototyping', 'Development', 'Testing'],
                                                reversed: true
                                        },
                                        series: [{
                                        name: 'Project 1',
                                                // pointPadding: 0,
                                                // groupPadding: 0,
                                                borderColor: 'gray',
                                                pointWidth: 20,
                                                data: [{
                                                x: Date.UTC(2014, 10, 21),
                                                        x2: Date.UTC(2014, 11, 2),
                                                        y: 0,
                                                        partialFill: 0.25
                                                }, {
                                                x: Date.UTC(2014, 11, 2),
                                                        x2: Date.UTC(2014, 11, 5),
                                                        y: 1
                                                }, {
                                                x: Date.UTC(2014, 11, 8),
                                                        x2: Date.UTC(2014, 11, 9),
                                                        y: 2
                                                }, {
                                                x: Date.UTC(2014, 11, 9),
                                                        x2: Date.UTC(2014, 11, 19),
                                                        y: 1
                                                }, {
                                                x: Date.UTC(2014, 11, 10),
                                                        x2: Date.UTC(2014, 11, 23),
                                                        y: 2
                                                }],
                                                dataLabels: {
                                                enabled: true
                                                }
                                        }]

                                });
                        });
                    </script>