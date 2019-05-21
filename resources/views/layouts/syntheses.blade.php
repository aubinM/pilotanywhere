@extends('includes.all')

@section('content')


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Synthèse @if(isset($enregistrement->id)) {{$enregistrement->id}} @endif</h1>


</div>

<div class="card-body">
    <div class="table">
        <table class="table table-responsive table-bordered table-hover table-sm w-auto"  >
            <thead>
                <tr>
                    <th class="small font-weight-bold">Tanks</th>
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
                    <th class="small font-weight-bold">Note</th>
                </tr>
            </thead>
            <tbody>
                <tr>Vol début</tr>
                
            </tbody>

        </table>
    </div>
</div>

@endsection