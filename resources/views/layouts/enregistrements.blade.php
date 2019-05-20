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
                                        <table class="table table-responsive table-bordered table-hover table-sm w-auto" id="dataTable"  >
                                            <thead>
                                                <tr>
                                                    <th class="small font-weight-bold">Séquence</th>
                                                    <th class="small font-weight-bold">Circuit autonome</th>
                                                    <th class="small font-weight-bold">Run</th>
                                                    <th class="small font-weight-bold">Date début</th>
                                                    <th class="small font-weight-bold">Date fin</th>
                                                    <th class="small font-weight-bold">Durée du run</th>
                                                    <th class="small font-weight-bold">Total</th>
                                                    <th class="small font-weight-bold">Test Recyclage</th>
                                                    <th class="small font-weight-bold">Test delta Température</th>
                                                    <th class="small font-weight-bold">Test delta Pression</th>
                                                    <th class="small font-weight-bold">Validation globale</th>
                                                    <th class="small font-weight-bold">Alarme</th>

                                                    <th class="small font-weight-bold">Check</th>
                                                    <th class="small font-weight-bold">Commentaires</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($enregistrements as $enregistrement)
                                                <tr>
                                                    <td><a href="{{route('syntheses.show', $enregistrement->id)}}" class="text-primary">{{$enregistrement->id}}</a></td>
                                                    <td>{{$enregistrement->materiel_autonome->name}}</td>
                                                    <td>{{$enregistrement->id}}</td>
                                                    <td>{{$enregistrement->date_debut}}</td>
                                                    <td>{{$enregistrement->date_fin}}</td>
                                                    <td>

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

                                                        <!--                                                        @php
                                                                                                                $debut = DateTime::createFromFormat('Y-m-d H:i:s',$enregistrement->date_debut);
                                                                                                                $fin = DateTime::createFromFormat('Y-m-d H:i:s',$enregistrement->date_fin);
                                                                           
                                                                                                                $duree = $debut->diff($fin);
                                                                                                                $heures = $duree->h;
                                                                                                                $heures = $heures + ($duree->days*24);
                                                                                                                $minutes = $duree->i;
                                                                                                                $minutes = $minutes + ($duree->days*24);;
                                                                                                                echo $heures
                                                                                       
                                                                                   
                                                                                                            @endphp-->
                                                    </td>
                                                    <td>250</td>
                                                    <td>ok</td>
                                                    <td>ok</td>
                                                    <td>ok</td>
                                                    <td>ok</td>
                                                    <td>

                                                        @foreach($enregistrement->alarmes as $alarme)
                                                        {{$alarme->name}}
                                                        @endforeach




                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                            <label class="form-check-label" for="defaultCheck1">

                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>ok</td>
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





    </body>

</html>


