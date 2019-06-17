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
<script type="text/javascript" src="/js/graphes.js"></script>
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>


<style>
    .spinner {
        display: inline-block;
        opacity: 0;
        width: 0;
        -webkit-transition: opacity 0.25s, width 0.25s;
        -moz-transition: opacity 0.25s, width 0.25s;
        -o-transition: opacity 0.25s, width 0.25s;
        transition: opacity 0.25s, width 0.25s;
    }
    .has-spinner.active {
        cursor:progress;
    }
    .has-spinner.active .spinner {
        opacity: 1;
        width: auto;
    }

    .has-spinner.btn.active .spinner {
        min-width: 20px;
    }

    .content {display:none;}
    .preload { width:100px;
               height: 100px;
               position: fixed;
               top: 50%;
               left: 50%;}

</style>









<body id="page-top">

    <div class="preload"><img src="/images/Ellipsis-1s-150px.gif">
    </div>


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
                    //Initialisation des variables
                    $current_config = 0;
                    foreach ($graphe_config as $config) {
                        if ($config->type == 1) {
                            ${"analogiqueSeries" . $config->name} = null;
                        } else if ($config->type == 2) {
                            ${"sequenceSeries" . $config->name} = null;
                            ${"date_debut" . $config->name} = null;
                            ${"date_fin" . $config->name} = null;
                            ${"date_fin_ok" . $config->name} = false;
                        }
                    }
                    $analogiqueSeries = null;
                    $sequenceSeries = null;
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




                    //Traitement pour le sous titre du graphe analogique
                    $datetime1 = new DateTime($enregistrement->stloup_pasteurisateur_standardisation_data->first()->_date);
                    $datetime2 = new DateTime($enregistrement->stloup_pasteurisateur_standardisation_data->last()->_date);
                    $interval = $datetime1->diff($datetime2);
                    $subtitle = "Début du run : " . $enregistrement->stloup_pasteurisateur_standardisation_data->first()->_date;
                    $subtitle .= " | Fin du run : " . $enregistrement->stloup_pasteurisateur_standardisation_data->last()->_date;
                    $subtitle .= $interval->format(" | Durée du run: %H Heures %I Minutes %S Secondes");

                    //Pour chaque données de l'enregistrement
                    foreach ($enregistrement->stloup_pasteurisateur_standardisation_data as $datas) {


                        //Récupération de la date et mise en format 
                        $date = new DateTime($datas->_date);
                        $annee = $date->format('Y');
                        $mois = $date->format('m') - 1;
                        $jour = $date->format('d');
                        $heure = $date->format('H');
                        $minute = $date->format('i');
                        $seconde = $date->format('s');

                        //Enlève le 0 pour chaque date car sinon bug dans js console
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
                        //Récupération des alarmes la ligne traité 
                        $alarmes = explode(",", $datas->alarmes);

                        //Pour toutes les alarmes dans la base Alarme
                        foreach ($all_alarmes as $all_alarme) {

                            //Si l'alarme est présente dans la ligne de donnée et que sa date de début est null -> MAJ de sa date de début
                            if (in_array($all_alarme->id, $alarmes) && is_null($dates_alarmes[$all_alarme->id . "debut"])) {

                                $dates_alarmes[$all_alarme->id . "debut"] = 'Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . ')';
                                //echo"La date debut de l'alarme " . $all_alarme->id . "est  : " . $dates_alarmes[$all_alarme->id . "debut"];
                            }

                            //Si l'alarme n'est pas présente dans la ligne de donnée et que sa date de début n'est pas null -> MAJ de sa date de fin
                            if (!in_array($all_alarme->id, $alarmes) && !is_null($dates_alarmes[$all_alarme->id . "debut"])) {
                                $dates_alarmes[$all_alarme->id . "fin"] = 'Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . ')';
                                //Si l'alarme a une criticité de 1 : couleur orange, sinon couleur rouge
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

                            //Si la date de fin est nul est que c'est la dernière ligne de donée et que l'alarme est dans la ligne de donnée -> MAJ de la fin de l'alarme
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
                    }



                    foreach ($enregistrement->stloup_pasteurisateur_standardisation_data as $datas) {



                        $date = new DateTime($datas->_date);
                        $annee = $date->format('Y');
                        $mois = $date->format('m') - 1;
                        $jour = $date->format('d');
                        $heure = $date->format('H');
                        $minute = $date->format('i');
                        $seconde = $date->format('s');
                        //Enlève le 0 pour chaque date car sinon bug dans js console
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
                        $sequence_placement = 0;
                        $current_config = 0;

                        foreach ($graphe_config as $config) {
                            $current_config++;




                            $code = $config->code;
                            //echo $code;

                            if ($config->type == 1) {
                                $alarmes = explode(",", $datas->alarmes);
                                $display = null;
                                foreach ($alarmes as $alarme) {
                                    foreach ($all_alarmes as $all_alarme) {
                                        if ($alarme == $all_alarme->id) {
                                            if ($all_alarme->critical_level == 1) {
                                                $display .= "<p style=\"color:#FF7F50\";>" . $all_alarme->name . "<br\>";
                                            } else {
                                                $display .= "<p style=\"color:#ff4040\";>" . $all_alarme->name . "<br\>";
                                            }
                                        }
                                    }
                                }
                                //echo $current_config;
                                if ($current_config == 2) {

                                    ${"analogiqueSeries" . $config->name} .= '{x: Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . '), y : ' . $datas->$code . ', myData : \'' . $display . '\'},';
                                } else {
                                    ${"analogiqueSeries" . $config->name} .= '{x: Date.UTC(' . $annee . ',' . $mois . ',' . $jour . ',' . $heure . ',' . $minute . ',' . $seconde . '), y : ' . $datas->$code . ', myData : \'\'},';
                                }
                            }


                            if ($config->type == 2) {
                                $sequence_placement ++;
                                // echo $sequence_placement;




                                if (($datas->$code == 1) && is_null(${"date_debut" . $config->name})) {
                                    ${"date_debut" . $config->name} = $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde;
                                    ${"date_fin" . $config->name} = null;
                                    ${"date_fin_ok" . $config->name} = false;
                                }


                                if ($datas->$code == 0 && !is_null(${"date_debut" . $config->name}) && ${"date_fin_ok" . $config->name} == false) {

                                    ${"date_fin" . $config->name} = $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde;
                                    ${"date_fin_ok" . $config->name} = true;
                                    ${"sequenceSeries" . $config->name} .= "{x: Date.UTC(" . ${"date_debut" . $config->name} . "),x2: Date.UTC(" . ${"date_fin" . $config->name} . "),y: " . $sequence_placement . ",color: '" . $config->hex . "' },";
                                    ${"date_debut" . $config->name} = null;
                                }
                            }
                        }
                    }

                    $current_config = 0;
                    $sequence_placement = 0;

                    foreach ($graphe_config as $config) {
                        $current_config++;
                        if ($current_config == 1) {
                            foreach ($en_attente as $attente) {
                                $plotbands .= $attente;
                            }
                        }
                        if ($config->type == 1) {
                            $analogiqueSeries .= "name: '" . $config->name . "',";
                            $analogiqueSeries .= "marker:{states:{hover:{enabled:false}}},";
                            $analogiqueSeries .= "tooltip: {pointFormatter: function () {return this.myData +'<br\><span style=\"color:' + this.color + '\">\u25CF</span> ' + this.series.name + ': <b>' + this.y + '</b><br/>';}},";
                            $analogiqueSeries .= "data: [" . ${"analogiqueSeries" . $config->name};
                            $analogiqueSeries .= "]},{";
                        } else if ($config->type == 2) {
                            $sequence_placement ++;
                            if (is_null(${"date_fin" . $config->name})) {
                                ${"date_fin" . $config->name} = $annee . "," . $mois . "," . $jour . "," . $heure . "," . $minute . "," . $seconde;
                                ${"sequenceSeries" . $config->name} .= "{x: Date.UTC(" . ${"date_debut" . $config->name} . "),x2: Date.UTC(" . ${"date_fin" . $config->name} . "),y: " . $sequence_placement . "," . "color: '" . $config->hex . "'}";
                            }
                            $sequenceSeries .= "name: '" . $config->name . "',";
                            $sequenceSeries .= "pointWidth: 5,";
                            $sequenceSeries .= "color: '" . $config->hex . "',";
                            $sequenceSeries .= "data: [" . ${"sequenceSeries" . $config->name};
                            $sequenceSeries .= "],}, {";
                        }
                    }



                    $sequenceSeries2 = rtrim($sequenceSeries, ',}, { ');
                    $analogiqueSeries2 = rtrim($analogiqueSeries, '},{');
                    //echo $analogiqueSeries2;
                    //echo $sequenceSeries2;
                    //  dd($analogiqueSeriesData);  
                    //echo $plotbands;

                    $legendMarginTop = null;
                    $legendY = 0;

                    switch ($sequence_placement) {
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
                            <a id="precedent" href="{{$enregistrement->id-1 > 0 ? route('graphes.show', $enregistrement->id-1) : ""}}" class="btn btn-primary disabled btn-sm has-spinner" role="button" >Précédent</a>
                            @else 
                            <a id="precedent" href="{{$enregistrement->id-1 > 0 ? route('graphes.show', $enregistrement->id-1) : ""}}" class="btn btn-primary  btn-sm has-spinner" role="button">Précédent</a>
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
                            <a id="suivant" href="{{$enregistrement->id+1 > 0 ? route('graphes.show', $enregistrement->id+1) : ""}}" class="btn btn-primary disabled btn-sm has-spinner" role="button" >Suivant</a>
                            @else 
                            <a id="suivant" href="{{$enregistrement->id+1 > 0 ? route('graphes.show', $enregistrement->id+1) : ""}}" class="btn btn-primary  btn-sm has-spinner"  >Suivant</a>
                            @endif

                            </li>
                        </ul>


                    </nav>

                    <div id="container"></div>

                    <script type="text/javascript">
var id = <?php echo $enregistrement->id; ?>;
var plotbands = <?php echo json_encode($plotbands); ?>;
var analogiqueSeries2 = <?php echo json_encode($analogiqueSeries2); ?>;
var sequenceSeries2 = <?php echo json_encode($sequenceSeries2); ?>;
var legendMarginTop = <?php echo json_encode($legendMarginTop); ?>;
var legendY = <?php echo json_encode($legendY); ?>;
var subtitle = <?php echo json_encode($subtitle); ?>;
//console.log(analogiqueSeries2);
construcGraphs(id, plotbands, analogiqueSeries2, sequenceSeries2, legendMarginTop, legendY, subtitle);
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



    </script>

    <script src="/js/modals.js"></script>
    <script src="/js/spinner.js"></script>

</body>

</html>





