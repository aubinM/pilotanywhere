<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Cipanywhere</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


        <!-- Custom styles for this template-->
        <link href="/css/sb-admin-2.min.css" rel="stylesheet">

        <!-- Custom styles for DataTables-->
        <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="\dataTables\FixedHeader-3.1.4\css\fixedHeader.dataTables.min.css" rel="stylesheet">
        <link href="\dataTables\Responsive-2.2.2\css\responsive.dataTables.min.css" rel="stylesheet">
        <link href="\dataTables\ColReorder-1.5.0\css\colReorder.dataTables.min.css" rel="stylesheet">
        <link href="\dataTables\Select-1.3.0\css\select.dataTables.min.css" rel="stylesheet">
        <link href="\dataTables\Buttons-1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/DataTables/datatables.min.css"/>

<!--        <script>

            $("chkOrgRow").click(function(){

            $.ajax({
            type: "GET",
                    url: {{route('enregistrements.edit', "1")}},
                    success: success
            }).done(function(data) {
            $('.alert-success').removeClass('hidden');
            $('#myModal').modal('hide');
            });
            });
        </script>-->

        <!--<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">-->

    </head>

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
                            <h1 class="h3 mb-0 text-gray-800">Enregistrements</h1>
                            <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
                        </div>

                        <!-- Content Row -->
                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                            <!-- Page Heading -->
                            <!--          <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                                      <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>-->

                            <!-- DataTales Example -->
                            <div class="card shadow mb-">

                                <div class="card-body">
                                    <div class="table">
                                        <table class=" table table-responsive table-bordered table-sm table-striped table-hover " >
                                            <thead>
                                                <tr >
                                                    <th class="small font-weight-bold text-center align-middle">Séquence</th>
                                                    <th class="small font-weight-bold text-center align-middle">Circuit autonome</th>
                                                    <th class="small font-weight-bold text-center align-middle">Run</th>
                                                    <th class="small font-weight-bold text-center align-middle">Date début</th>
                                                    <th class="small font-weight-bold text-center align-middle">Date fin</th>
                                                    <th class="small font-weight-bold text-center align-middle">Durée du run</th>
                                                    <th class="small font-weight-bold text-center align-middle">Total</th>
                                                    <th class="small font-weight-bold text-center align-middle">Test Recyclage</th>
                                                    <th class="small font-weight-bold text-center align-middle">Test delta Température</th>
                                                    <th class="small font-weight-bold text-center align-middle">Test delta Pression</th>
                                                    <th class="small font-weight-bold text-center align-middle">Validation globale</th>
                                                    <th class="small font-weight-bold text-center align-middle">Alarme</th>
                                                    <th class="small font-weight-bold text-center align-middle">Check</th>
                                                    <th class="small font-weight-bold text-center align-middle">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($enregistrements as $enregistrement)
                                                <tr>
                                                    <td class="text-center align-middle"><a href="{{route('graphes.show', $enregistrement->id)}}" class="text-primary">{{$enregistrement->id}}</a></td>
                                                    <td class="text-center align-middle">{{$enregistrement->materiel_autonome->name}}</td>
                                                    <td class="text-center align-middle"><a href="{{route('syntheses.show', $enregistrement->id)}}" class="text-primary">{{$enregistrement->id}}</a></td>
                                                    <td class="text-center align-middle">{{$enregistrement->date_debut}}</td>
                                                    <td class="text-center align-middle">{{$enregistrement->date_fin}}</td>
                                                    <td class="text-center align-middle">

                                                        @php
                                                        $start = Carbon\Carbon::parse($enregistrement->date_debut);
                                                        $end = Carbon\Carbon::parse($enregistrement->date_fin);
                                                        $hours = $end->diffInHours($start);
                                                        $minutes = $end->diffInMinutes($start)%60;
                                                        $seconds = $end->diffInSeconds($start)%60;
                                                        @endphp
                                                        @if($hours > 0)
                                                        {{$hours . " h" }}<br>
                                                        @endif
                                                        @if($minutes > 0)
                                                        {{$minutes . " m" }}<br>
                                                        @endif
                                                        @if($seconds > 0)
                                                        {{$seconds . " s"}}
                                                        @endif

                                                    </td>
                                                    <td class="text-center align-middle">{{$enregistrement->total_volumes ? $enregistrement->total_volumes : ""}}</td>

                                                    @if(!is_null($enregistrement->test_recyclage))
                                                    @if($enregistrement->test_recyclage_valide == 0 && !is_null($enregistrement->test_recyclage_valide))
                                                    <td class="table-danger text-center align-middle">{{$enregistrement->test_recyclage}}</td>
                                                    @elseif($enregistrement->test_recyclage_valide == 1)
                                                    <td class="table-success text-center align-middle">{{$enregistrement->test_recyclage}}</td>
                                                    @else
                                                    <td class="text-center align-middle">{{$enregistrement->test_recyclage}}</td>
                                                    @endif
                                                    @else
                                                    <td class="text-center align-middle"><i class="fas fa-times"></i></td>
                                                    @endif

                                                    @if(!is_null($enregistrement->test_delta_temperature))

                                                    @if($enregistrement->test_delta_temperature_valide == 0 && !is_null($enregistrement->test_delta_temperature_valide))
                                                    <td class="table-danger">{{$enregistrement->test_delta_temperature ? $enregistrement->test_delta_temperature : ""}}</td>
                                                    @elseif($enregistrement->test_delta_temperature_valide == 1)
                                                    <td class="table-success">{{$enregistrement->test_delta_temperature ? $enregistrement->test_delta_temperature : ""}}</td>
                                                    @else
                                                    <td class="text-center align-middle">{{$enregistrement->test_delta_temperature ? $enregistrement->test_delta_temperature : ""}}</td>
                                                    @endif
                                                    @else
                                                    <td class="text-center align-middle"><i class="fas fa-times"></i></td>
                                                    @endif

                                                    @if(!is_null($enregistrement->test_delta_pression))

                                                    @if($enregistrement->test_delta_pression_valide == 0 && !is_null($enregistrement->test_delta_pression_valide))
                                                    <td class="table-danger">{{$enregistrement->test_delta_pression ? $enregistrement->test_delta_pression : ""}}</td>
                                                    @elseif($enregistrement->test_delta_pression_valide == 1)
                                                    <td class="table-success">{{$enregistrement->test_delta_pression ? $enregistrement->test_delta_pression : ""}}</td>
                                                    @else
                                                    <td class="text-center align-middle">{{$enregistrement->test_delta_pression ? $enregistrement->test_delta_pression : ""}}</td>
                                                    @endif
                                                    @else
                                                    <td class="text-center align-middle"><i class="fas fa-times"></i></td>
                                                    @endif

                                                    <td class="text-center align-middle">
                                                        @if(is_null($enregistrement->validation_globale))
                                                        <i class="fas fa-times"></i>
                                                        @else
                                                        {{$enregistrement->validation_globale}}

                                                        @endif

                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @php
                                                        $critical_1 = 0;
                                                        $critical_2 = 0;
                                                        $alarmes_names_1 = [];
                                                        $alarmes_names_2 = [];

                                                        foreach($enregistrement->alarmes as $alarme)
                                                        {
                                                        if($alarme->critical_level == 1){
                                                        $critical_1 ++;
                                                        array_push($alarmes_names_1,$alarme->name);
                                                        } elseif($alarme->critical_level == 2) {
                                                        $critical_2 ++;
                                                        array_push($alarmes_names_2,$alarme->name);
                                                        }
                                                        }
                                                        if($critical_1 != 0){
                                                        echo '<p style="height: 15px">'.$critical_1." ".'<i class="fas fa-times text-warning text-center align-middle " data-toggle="tooltip"  data-html="true" title="'.implode("<br hidden> ",$alarmes_names_1).'"></i></p>';
                                                        }
                                                        if($critical_2 != 0){
                                                        echo $critical_2." ".'<i class="fas fa-times text-danger text-center align-middle" data-toggle="tooltip" data-html="true" title="'.implode("<br>",$alarmes_names_2).'"></i>';
                                                        }

                                                        @endphp




                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <!--                                                        <form action="{{$enregistrement->id}}" method="put" class="form-inline">-->
                                                        {{ Form::open(array('url' => route('enregistrements.edit', $enregistrement->id), 'method' => 'GET', 'class'=>'')) }}



                                                        @if(is_null($enregistrement->checked_by))

                                                        <input class="" type='checkbox' name='chkOrgRow' id='chkOrgRow' onChange="this.form.submit()"/>

                                                        @else 

                                                        <i class="fas fa-check-square text-success text-center align-middle" data-toggle="tooltip" data-html="true" title="{{\App\User::find($enregistrement->checked_by)->login }}<br>{{$enregistrement->checked_at}}"></i>

                                                        @endif



                                                        {{ Form::close() }}


                                                        <!--                                                        </form>-->


                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @if(is_null($enregistrement->commentaire))
                                                        <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal" data-id="{{$enregistrement->id}}" data-whatever="{{$enregistrement->commentaire}}">
                                                            <i class="far fa-comment-alt"></i>
                                                        </button>
                                                        @else 
                                                        <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal" data-id="{{$enregistrement->id}}" data-whatever="{{$enregistrement->commentaire}}" >
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
                                                                        {!! Form::model($enregistrement, ['method'=>'PATCH', 'action'=> ['RecordsController@update', $enregistrement->id]]) !!}

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




                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.container-fluid -->

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
        <!-- Page level custom scripts -->
        <script type="text/javascript" charset="utf8" src="/dataTables/datatables-demo.js"></script>
        <script type="text/javascript" charset="utf8" src="\dataTables\DataTables-1.10.18\js\jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="/DataTables/datatables.min.js"></script>
        <script type="text/javascript" src="/DataTables/FixedHeader-3.1.4/js/dataTables.fixedHeader.min.js"></script>
        <script type="text/javascript" src="/DataTables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="/DataTables/ColReorder-1.5.0/js/dataTables.colReorder.min.js"></script>
        <script type="text/javascript" src="/DataTables/Select-1.3.0/js/dataTables.select.min.js"></script>
        <script type="text/javascript" src="/DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="/DataTables/Buttons-1.5.6/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="/DataTables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="/DataTables/Buttons-1.5.6/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js"></script>
        <script type="text/javascript" src="/DataTables/Buttons-1.5.6/js/buttons.bootstrap4.min.js"></script>

        <!-- Page level plugins DataTables -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
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
                                                                console.log(my_id_value);
                                                                $(".modal-body #hiddenValue").val(my_id_value);
                                                            })
        </script>





    </body>

</html>


