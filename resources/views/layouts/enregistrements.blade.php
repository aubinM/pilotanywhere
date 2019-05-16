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
<!--                        <div class="card shadow mb-">

                            <div class="card-body">-->
                                <div class="table">
                                    <table class="table table-responsive table-bordered table-hover table-sm w-auto row-border " id="dataTable"  >
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
                                                <th class="small font-weight-bold">Commentaires</th>zdazdadad
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < 100; $i++)
                                            <tr>
                                                <td><a href="#" class="text-primary">n°1</a></td>
                                                <td>Pasto stand</td>
                                                <td>n°8</td>
                                                <td>13/05/2019</td>
                                                <td>14/05/2019</td>
                                                <td>1 jour</td>
                                                <td>250</td>
                                                <td>ok</td>
                                                <td>ok</td>
                                                <td>ok</td>
                                                <td>ok</td>
                                                <td>ok</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>ok</td>
                                            </tr>
                                            @endfor
                                            
                                        </tbody>
                                    </table>
<!--                                </div>
                            </div>-->
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
    <!-- Page level plugins DataTables -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>





</body>

</html>


